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
    public function testLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionMongoDBDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'mongodb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionCouchDBDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'couchdb';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadThrowsExceptionPropelDriverIsInvalid()
    {
        $loader = new DomUdallWirecardExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'propel';
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
db_driver: orm
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
