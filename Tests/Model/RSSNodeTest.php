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
                    'desc'  => 'desc',
                    'link'  => 'link',
                    'date'  => '2012-01-01'
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testTrue($options)
    {
        $this->node->setOptions($options);
        $this->assertEquals($options['title'], $this->node->getTitle());
        $this->assertEquals($options['desc'], $this->node->getDesc());
        $this->assertEquals($options['link'], $this->node->getLink());
        $this->assertEquals($options['date'], $this->node->getPubDate()->format('Y-m-d'));
    }

    /**
     * data Provider 
     */
    public function getDataForTestXSS()
    {
        return array(
            array(
                array(
                    'title' => '<img src="jav&#x09;ascript:alert(\'XSS\');"/>',
                    'desc'  => '%3C%73%63%72%69%70%74%3E%61%6C%65%72%74%28%27%58%53%53%27%29%3C%2F%73%63%72%69%70%74%3E',
                    'link'  => '&#x3C;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;&#x61;&#x6C;&#x65;&#x72;&#x74;&#x28;&#x27;&#x58;&#x53;&#x53;&#x27;&#x29;&#x3C;&#x2F;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;',
                ),
                array(
                    'title' => '',
                    'desc'  => '%3C%73%63%72%69%70%74%3E%61%6C%65%72%74%28%27%58%53%53%27%29%3C%2F%73%63%72%69%70%74%3E',
                    'link'  => '&#x3C;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;&#x61;&#x6C;&#x65;&#x72;&#x74;&#x28;&#x27;&#x58;&#x53;&#x53;&#x27;&#x29;&#x3C;&#x2F;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3E;',
                )
            ),
            array(
                array(
                    'title' => '<script>alert(\'XSS\')</script>',
                    'desc'  => 'PHNjcmlwdD5hbGVydCgnWFNTJyk8L3NjcmlwdD4=',
                    'link'  => '&#60&#115&#99&#114&#105&#112&#116&#62&#97&#108&#101&#114&#116&#40&#39&#88&#83&#83&#39&#41&#60&#47&#115&#99&#114&#105&#112&#116&#62',
                ),
                array(
                    'title' => 'alert(\'XSS\')',
                    'desc'  => 'PHNjcmlwdD5hbGVydCgnWFNTJyk8L3NjcmlwdD4=',
                    'link'  => '&#60&#115&#99&#114&#105&#112&#116&#62&#97&#108&#101&#114&#116&#40&#39&#88&#83&#83&#39&#41&#60&#47&#115&#99&#114&#105&#112&#116&#62',
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForTestXSS
     * @param type $options 
     */
    public function testXSS($options, $results)
    {
        $this->node->setOptions($options);
        $this->assertEquals($this->node->getTitle(), $results['title']);
        $this->assertEquals($this->node->getDesc(), $results['desc']);
        $this->assertEquals($this->node->getLink(), $results['link']);
    }

}
