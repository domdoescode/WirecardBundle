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
        unset($config['qpay']['customer_id']);
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

    public function testLoadServicesWithDefaults()
    {
        $this->createMinimalConfiguration();

        $this->assertHasDefinition('wirecard.payment_manager');
        $this->assertAlias('wirecard.payment_manager.default', 'wirecard.payment_manager');
    }
    
    public function testLoadTemplatesWithDefaults()
    {
        $this->createMinimalConfiguration();

        $this->assertParameter('twig', 'wirecard.template.engine');
        $this->assertParameter('DomUdallWirecardBundle::form.html.twig', 'wirecard.template.theme');
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
  customer_id: D200001
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