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
        $this->markTestIncomplete("Needs to be implemented");
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
