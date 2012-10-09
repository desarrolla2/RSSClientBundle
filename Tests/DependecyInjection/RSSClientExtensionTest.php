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
     * @test
     */
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new RSSClientExtension();
        $loader->load(array(array()), $container);
        $this->assertTrue($container->hasDefinition('client_rss.sanitizer'), 'The sanitizer is loaded');
        $this->assertTrue($container->hasDefinition('client_rss'), 'The RSS client is loaded');
    }

}
