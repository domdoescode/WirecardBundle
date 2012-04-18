<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace DomUdall\WirecardBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DomUdallWirecardExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (in_array(strtolower($config['db_driver']), array('mongodb', 'couchdb', 'propel'))) {
            throw new \InvalidArgumentException(
                sprintf('Currently only the orm db driver is supported, %s support is en route.', $config['db_driver'])
            );
        } elseif (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }

        $loader->load(sprintf('%s.yml', $config['db_driver']));

        // $container->setParameter('wirecard.payment.request.class', $config['payment']['request_class']);
        $container->setParameter('wirecard.payment.response.class', $config['payment']['response_class']);
        $container->setParameter('wirecard.payment.manager.class', $config['payment']['manager_class']);

        $container->setAlias('wirecard.payment_manager', $config['service']['payment_manager']);

        $this->remapParametersNamespaces($config, $container, array(
            'qpay'     => 'wirecard.qpay.%s',
            'template' => 'wirecard.template.%s',
        ));
    }

    protected function recursiveRemapParameters(ContainerBuilder $container, $map, array $values)
    {
        foreach ($values as $name => $value) {
            if (is_array($value)) {
                $this->recursiveRemapParameters($container, sprintf($map, $name . ".%s"), $value);
            } else {
                $container->setParameter(sprintf($map, $name), $value);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            $this->recursiveRemapParameters($container, $map, $config[$ns]);
        }
    }
}
