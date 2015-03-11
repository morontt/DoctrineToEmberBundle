<?php

namespace Mtt\Bundle\DoctrineToEmberBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mtt_doctrine_to_ember');

        $rootNode
            ->children()
                ->scalarNode('application_variable')
                    ->defaultValue('Todos')
                ->end()
                ->scalarNode('models_path')
                    ->defaultValue('%kernel.root_dir%/../web/js/models')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
