<?php

namespace GT\BlackListBundle\DependencyInjection;

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
	$rootNode = $treeBuilder->root('gt_black_list');

	$rootNode->children()
		->scalarNode("provider")->defaultValue("array")->validate()
		    ->ifTrue(function($v) {return !in_array($v, array('array', 'class'));})
		    ->thenInvalid('Invalid black list provider specified: %s')
		    ->end()->end()
		->scalarNode('class')->end()
		->arrayNode('data')->defaultValue(array())->prototype('scalar')->end();

	return $treeBuilder;
    }
   
}