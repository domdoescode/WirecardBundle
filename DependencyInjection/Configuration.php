<?php

namespace DomUdall\WirecardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wirecard');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->arrayNode('payment')
                    ->scalarNode('request_class')
                        ->isRequired()
                        ->cannotBeEmpty()
                        ->end()
                    ->scalarNode('response_class')
                        ->isRequired()
                        ->cannotBeEmpty()
                        ->end()
                    ->scalarNode('manager_class')
                        ->isRequired('wirecard.payment_manager.default')
                        ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->arrayNode('qpay')
                    ->scalarNode('secret')
                        ->isRequired()
                        ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->arrayNode('from_email')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('address')
                            ->defaultValue('payments@moneybags.com')
                            ->cannotBeEmpty()
                            ->end()
                        ->scalarNode('sender_name')
                            ->defaultValue('payments')
                            ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
            ->end();

        $this->addServiceSection($rootNode);
        $this->addTemplateSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Creates the services section of the configuration file.
     *
     * @param ArrayNodeDefinition $node Root node of configuration tree builder
     */
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('mailer')
                            ->defaultValue('synth_notification.mailer.default')
                            ->end()
                        ->scalarNode('notification_manager')
                            ->defaultValue('synth_notification.notification_manager.default')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addTemplateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('engine')->defaultValue('twig')->end()
                        ->scalarNode('theme')->defaultValue('DomUdallWirecardBundle::form.html.twig')->end()
                    ->end()
                ->end()
            ->end();
    }
}