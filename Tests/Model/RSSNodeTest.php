<?php

/*
 * This file is part of the RSSClientBundle package.
 * 
 * Short description   
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Jun 22, 2012, 12:53:47 AM
 * @file RSSNodeTest.php , UTF-8
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Test\Service;

use Desarrolla2\Bundle\RSSClientBundle\Model\RSSNode;

class RSSNodeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Model\RSSNode
     */
    protected $node = null;

    public function setUp()
    {
        $this->node = new RSSNode();
    }

    /**
     * data Provider 
     */
    public function getDataForTrue()
    {
        return array(
            array(
                array(
                    'title' => 'title',
                    'desc' => 'desc',
                    'link' => 'link',
                    'date' => '2012-01-01',
                    'content' => 'content'
                ),
            ),
        );
    }

    /**
     * data Provider 
     */
    public function getDataForFalse()
    {
        return array(
            array(
                array(
                    'title' => 'title',
                    'desc' => 'desc',
                    'link' => 'link',
                    'date' => 'dabDateTimeFormat',
                    'content' => 'content'
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testTitle($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['title'], $this->node->getTitle());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testDesc($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['desc'], $this->node->getDesc());
    }
    
    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testToString($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['desc'], (string) $this->node);
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testLink($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['link'], $this->node->getLink());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testContent($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['content'], $this->node->getContent());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testPubDate($options)
    {
        $this->node->fromArray($options);
        $date = new \DateTime($options['date']);
        $this->assertEquals($date, $this->node->getPubDate());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testTimestamp($options)
    {
        $this->node->fromArray($options);
        $date = new \DateTime($options['date']);
        $this->assertEquals($date->getTimestamp(), $this->node->getTimestamp());
    }

    /**
     * @test
     * @dataProvider getDataForFalse
     * @param type $options 
     */
    public function testPubDateFalse($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals(false, $this->node->getPubDate());
    }

    /**
     * @test
     * @dataProvider getDataForFalse
     * @param type $options 
     */
    public function testTimestampFalse($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals(false, $this->node->getTimestamp());
    }

}