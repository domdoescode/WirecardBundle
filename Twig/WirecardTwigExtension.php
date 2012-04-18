<?php
namespace DomUdall\WirecardBundle\Twig;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Http\AccessMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router;

class WirecardTwigExtension extends \Twig_Extension
{
    protected $container;
    protected $cache = array();

    public function __construct($container) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array(
            'wirecardSetting'  => new \Twig_Function_Method($this, 'wirecardSetting', array('is_safe' => array('html'))),
            'wirecardUrl'  => new \Twig_Function_Method($this, 'wirecardUrl', array('is_safe' => array('html'))),
            'wirecardFingerprint'  => new \Twig_Function_Method($this, 'wirecardFingerprint', array('is_safe' => array('html'))),
        );
    }

    public function wirecardSetting($parameter, $returnBoolean = false)
    {
        $setting = null;
        try {
            $setting = $this->container->getParameter("wirecard.qpay." . $parameter);
        } catch(\InvalidArgumentException $e) {}

        if ($returnBoolean) {
            $setting = $setting ? "yes" : "no";
        }

        return $setting;
    }

    public function wirecardUrl($parameter = "qpay")
    {
        return $this->wirecardSetting("url." . $parameter);
    }

    public function wirecardFingerprint($entity)
    {
        $fingerprint = "";
        $fingerprintOrder = explode(",", $this->wirecardSetting("fingerprint_order"));
        foreach ($fingerprintOrder as $orderKey) {
            switch (strtolower($orderKey)) {
                case "successurl":
                    $fingerprint .= $this->wirecardUrl("success");
                    break;
                case "duplicaterequestcheck":
                    $fingerprint .= $this->wirecardSetting("duplicaterequestcheck", true);
                    break;
                case "requestfingerprintorder":
                    $fingerprint .= $this->wirecardSetting("fingerprint_order");
                    break;
                case "orderdescription":
                    $fingerprint .= $entity->getName();
                    break;
                case "displaytext":
                    $fingerprint .= $entity->getName();
                    break;
                default:
                    if ($setting = $this->wirecardSetting($orderKey)) {
                        $fingerprint .= $setting;
                    } else {
                        $function = "get" . ucfirst($orderKey);
                        $fingerprint .= $entity->$function();
                    }
                    break;
            }
        }

        return md5($fingerprint);
    }

    public function getName()
    {
        return 'wirecard_extensions';
    }
}