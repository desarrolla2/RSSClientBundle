<?php

namespace Desarrolla2\Bundle\RSSClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RSSClientExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('rss_client.xml');
        $loader->load('rss_client_cache.xml');

        $container->setParameter('rss_client.cache.ttl', $config['cache']['ttl']);
        $container->setParameter('rss_client.channels', $config['channels']);

        /* @var $client \Symfony\Component\DependencyInjection\Definition */
        /* @var $cached_client \Symfony\Component\DependencyInjection\Definition */
        $client = $container->getDefinition('rss_client');
        $cached_client = $container->getDefinition('rss_client.cache');
        foreach($config['processors'] as $processor_service_id) {
          $client->addMethodCall('pushProcessor', array(new Reference($processor_service_id)));
          $cached_client->addMethodCall('pushProcessor', array(new Reference($processor_service_id)));
        }
    }

    public function getAlias()
    {
        return 'rss_client';
    }

}
