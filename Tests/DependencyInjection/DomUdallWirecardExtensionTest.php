<?php

/**
 * This file is part of the DomUdallWirecardBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace DomUdall\WirecardBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use DomUdall\WirecardBundle\DependencyInjection\DomUdallWirecardExtension;

class DomUdallWirecardExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $configuration;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionWithNoConfig()
    {
        $loader = new DomUdallWirecardExtension();
        $loader->load(array(), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionMongoDBDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        $config['db_driver'] = 'mongodb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionCouchDBDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        $config['db_driver'] = 'couchdb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionPropelDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        $config['db_driver'] = 'propel';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessPaymentNodeSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['payment']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessPaymentRequestSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['payment']['request_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessPaymentResponseSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['payment']['response_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessManagerClassSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['payment']['manager_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpaySet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpaySecretSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['secret']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayCustomerIdSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['customerid']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayCurrencySet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['currency']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayUrlsSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpaySuccessUrlSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']['success']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayCancelUrlSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']['cancel']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayFailureUrlSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']['failure']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayServiceUrlSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']['service']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessQpayImageUrlSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        unset($config['qpay']['url']['image']);
        $loader->load(array($config), new ContainerBuilder());
    }

    public function testLoadGeneralWithMinimalConfig()
    {
        $this->createMinimalConfiguration();

        $this->assertParameter('DomUdall/WirecardBundle/Entity/Request.php', 'wirecard.payment.request.class');
        $this->assertParameter('DomUdall/WirecardBundle/Entity/Response.php', 'wirecard.payment.response.class');
        $this->assertParameter('DomUdall/WirecardBundle/Model/Manager.php', 'wirecard.payment.manager.class');
    }

    public function testLoadQpayWithMinimalConfig()
    {
        $this->createMinimalConfiguration();

        $this->assertParameter('NOT_SO_SECRET', 'wirecard.qpay.secret');
        $this->assertParameter('D200001', 'wirecard.qpay.customerid');
        $this->assertParameter('GBP', 'wirecard.qpay.currency');
        $this->assertParameter('en', 'wirecard.qpay.language');
        $this->assertParameter(true, 'wirecard.qpay.duplicaterequestcheck');
        $this->assertParameter(true, 'wirecard.qpay.autodeposit');

        $this->assertParameter('http://moneybags.com/payment/success.php', 'wirecard.qpay.url.success');
        $this->assertParameter('http://moneybags.com/payment/cancel.php', 'wirecard.qpay.url.cancel');
        $this->assertParameter('http://moneybags.com/payment/failure.php', 'wirecard.qpay.url.failure');
        $this->assertParameter('http://moneybags.com/contact.php', 'wirecard.qpay.url.service');
        $this->assertParameter('http://moneybags.com/resource/image/logo.png', 'wirecard.qpay.url.image');
    }

    public function testLoadServicesWithMinimalConfig()
    {
        $this->createMinimalConfiguration();

        $this->assertHasDefinition('wirecard.payment_manager');
        $this->assertAlias('wirecard.payment_manager.default', 'wirecard.payment_manager');
    }

    public function testLoadTemplatesWithMinimalConfig()
    {
        $this->createMinimalConfiguration();

        $this->assertParameter('twig', 'wirecard.template.engine');
        $this->assertParameter('DomUdallWirecardBundle::form.html.twig', 'wirecard.template.theme');
    }

    public function testLoadGeneralWithFullConfig()
    {
        $this->createMinimalConfiguration();

        $this->assertParameter('DomUdall/WirecardBundle/Entity/Request.php', 'wirecard.payment.request.class');
        $this->assertParameter('DomUdall/WirecardBundle/Entity/Response.php', 'wirecard.payment.response.class');
        $this->assertParameter('DomUdall/WirecardBundle/Model/Manager.php', 'wirecard.payment.manager.class');
    }

    public function testLoadQpayWithFullConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('SUPER_SECRET_SIGNAL', 'wirecard.qpay.secret');
        $this->assertParameter('D200002', 'wirecard.qpay.customerid');
        $this->assertParameter('EUR', 'wirecard.qpay.currency');
        $this->assertParameter('de', 'wirecard.qpay.language');
        $this->assertParameter(false, 'wirecard.qpay.duplicaterequestcheck');
        $this->assertParameter(false, 'wirecard.qpay.autodeposit');

        $this->assertParameter('http://moneybags.com/paywall/success.php', 'wirecard.qpay.url.success');
        $this->assertParameter('http://moneybags.com/paywall/cancel.php', 'wirecard.qpay.url.cancel');
        $this->assertParameter('http://moneybags.com/paywall/failure.php', 'wirecard.qpay.url.failure');
        $this->assertParameter('http://moneybags.com/contact/', 'wirecard.qpay.url.service');
        $this->assertParameter('http://moneybags.com/image/logo.png', 'wirecard.qpay.url.image');
    }

    public function testLoadServicesWithFullConfig()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('wirecard.payment_manager');
        $this->assertAlias('wirecard.payment_manager.custom', 'wirecard.payment_manager');
    }

    public function testLoadTemplatesWithFullConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'wirecard.template.engine');
        $this->assertParameter('AcmeBank::form.html.php', 'wirecard.template.theme');
    }

    /**
     * @return array
     */
    protected function getMinimumConfig()
    {
        $yaml = <<<EOF
db_driver: orm
payment:
  request_class: DomUdall/WirecardBundle/Entity/Request.php
  response_class: DomUdall/WirecardBundle/Entity/Response.php
  manager_class: DomUdall/WirecardBundle/Model/Manager.php
qpay:
  secret: NOT_SO_SECRET
  customerid: D200001
  currency: GBP
  url:
    success: http://moneybags.com/payment/success.php
    cancel: http://moneybags.com/payment/cancel.php
    failure: http://moneybags.com/payment/failure.php
    service: http://moneybags.com/contact.php
    image: http://moneybags.com/resource/image/logo.png
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
db_driver: orm
payment:
  request_class: AcmeBank/WirecardBundle/Entity/Request.php
  response_class: AcmeBank/WirecardBundle/Entity/Response.php
  manager_class: AcmeBank/WirecardBundle/Model/Manager.php
qpay:
  secret: SUPER_SECRET_SIGNAL
  customerid: D200002
  currency: EUR
  language: de
  duplicaterequestcheck: false
  autodeposit: false
  url:
    success: http://moneybags.com/paywall/success.php
    cancel: http://moneybags.com/paywall/cancel.php
    failure: http://moneybags.com/paywall/failure.php
    service: http://moneybags.com/contact/
    image: http://moneybags.com/image/logo.png
service:
    payment_manager: wirecard.payment_manager.custom
template:
  engine: php
  theme: AcmeBank::form.html.php
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @return ContainerBuilder
     */
    protected function createMinimalConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new DomUdallWirecardExtension();
        $config = $this->getMinimumConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * @return ContainerBuilder
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new DomUdallWirecardExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    protected function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    protected function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    protected function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}