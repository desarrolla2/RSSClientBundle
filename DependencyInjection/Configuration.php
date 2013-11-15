<?php

namespace Desarrolla2\Bundle\RSSClientBundle\DependencyInjection;

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
        $treeBuilder->root('rss_client')
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('adapter')
                            ->defaultValue('Desarrolla2\Cache\Adapter\NotCache')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('ttl')
                            ->defaultValue('3600')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('processors')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('channels')
                    ->useAttributeAsKey('id')
                    ->info('RSS Client Channels Configuration')
                    ->treatNullLike(array())
                        ->prototype('array')
                        ->treatNullLike(array())
                            ->prototype('scalar')
                            ->treatNullLike(null)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;
        return $treeBuilder;
    }
}
