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
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
