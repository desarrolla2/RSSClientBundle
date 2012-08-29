<?php

/*
 * This file is part of the symfony-madrid package.
 * 
 * Short description   
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Jun 19, 2012, 11:18:58 PM
 * @file RSSClientTest.php , UTF-8
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Test\Service;

use Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;

class RSSClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $example_feed = 'http://desarrolla2.com/feed/';
    
    protected $example_feed2 = 'http://blog.desarrolla2.com/feed/';

    public function setUp()
    {
        $this->client = new RSSClient();
    }

    public function getDataForFeeds()
    {
        return array(
            array(
                array(
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getDataForChannels()
    {
        return array(
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                    'channel3' => array(
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testAddFeed($data)
    {
        $this->client->addFeed($this->example_feed);
        foreach ($data as $feed) {
            $this->client->addFeed($feed);
        }
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testAddFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->client->addFeeds($data);
        $this->assertEquals(count($this->client->getFeeds()), 2);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testSetFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->setFeeds($data);
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function countFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->assertEquals($this->client->countFeeds(), 2);
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testCountChannels($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testGetChannels($data)
    {        
        $this->client->setChannels($data);
        $this->assertEquals(count($data), count($this->client->getChannels()));
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testGetChannelsNames($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(array_keys($data), $this->client->getChannelsNames());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testAddChannels($data)
    {
        $this->client->addChannels(array(
            'test1' => array(
                $this->example_feed,
            ),
        ));
        $this->client->addChannels($data);
        $this->assertEquals((count($data) + 1), $this->client->countChannels());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testClearChannels($data)
    {
        $this->client->setChannels($data);
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }
//
//    public function getNodes($data)
//    {
//        
//    }

//    /**
//     * @test
//     */
//    public function testFetch($data)
//    {
//        $this->client->fetch();
//        $this->assertEquals(10, $this->client->countNodes());
//    }
}