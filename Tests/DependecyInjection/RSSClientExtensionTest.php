<?php

/**
 * This file is part of the RSSClientBundle proyect.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Test\DependencyInjection;

use Desarrolla2\Bundle\RSSClientBundle\DependencyInjection\RSSClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * 
 * Description of RSSClientExte nsionTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSSClientExte nsionTest.php , UTF-8
 * @date : Oct 9, 2012 , 9:16:39 PM
 */
class RSSClientExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder 
     */
    protected $container;

    /**
     * @var \Desarrolla2\Bundle\RSSClientBundle\DependencyInjection\RSSClientExtension 
     */
    protected $loader;

    /**
     * 
     */
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->loader = new RSSClientExtension();
        $this->loader->load(array(array()), $this->container);
    }

    /**
     * dataProvider
     * @return array
     */
    public function dataProviderTestHasDefinition()
    {
        return array(
            array('rss_client'),
        );
    }

    /**
     * @test
     * @dataProvider dataProviderTestHasDefinition
     */
    public function testhasDefinition($parameter)
    {
        $this->assertTrue($this->container->hasDefinition($parameter), 'The ' . $parameter . ' is loaded');
    }

    /**
     * dataProvider
     * @return array
     */
    public function dataProviderTestHasParameter()
    {
        return array(
            array('rss_client.class'),
            array('rss_client.channels'),
        );
    }

    /**
     * @test
     * @dataProvider dataProviderTestHasParameter
     */
    public function testhasParammeter($parameter)
    {
        $this->assertTrue($this->container->hasParameter($parameter), 'The ' . $parameter . ' is loaded');
    }

}
