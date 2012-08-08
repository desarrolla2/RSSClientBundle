<?php

/*
 * This file is part of the symfony-madrid package.
 * 
 * Short description   
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Jun 19, 2012, 11:18:58 PM
 * @file RSSClient.php , UTF-8
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Service;

use Desarrolla2\Bundle\RSSClientBundle\Model\RSSNode;

class RSSClient
{

    protected $feeds = array();
    protected $nodes = array();
    protected $apcKey = 'd2.client.rss.nodes';

    /**
     * @param array $feeds 
     */
    public function __construct($feeds = array())
    {
        $this->setFeeds($feeds);
    }

    /**
     * @return array feeds
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

    /**
     * 
     */
    public function clearFeeds()
    {
        $this->feeds = array();
    }

    /**
     *
     * @param string $feed 
     */
    public function setFeed($feed)
    {
        $this->clearFeeds();
        $this->addFeed($feed);
    }

    /**
     *
     * @param array $feeds 
     */
    public function setFeeds($feeds)
    {
        $this->clearFeeds();
        $this->addFeeds($feeds);
    }

    /**
     *
     * @param string $feed 
     */
    public function addFeed($feed)
    {
        array_push($this->feeds, (string) $feed);
    }

    /**
     *
     * @param array $feeds 
     */
    public function addFeeds($feeds)
    {
        $feeds = (array) $feeds;
        foreach ($feeds as $feed) {
            $this->addFeed($feed);
        }
    }

    /**
     *
     * @return int count $feeds
     */
    public function countFeeds()
    {
        return count($this->feeds);
    }

    /**
     *
     * @param RSSNode $node
     */
    public function addNode(RSSNode $node)
    {
        array_push($this->nodes, $node);
    }

    /**
     *
     * @return int count $nodes
     */
    public function countNodes()
    {
        return count($this->nodes);
    }

    /**
     *
     * @return int $nodes
     */
    public function fetch()
    {
        if ($nodes = $this->getCache()) {
            $this->nodes = $nodes;
        } else {
            foreach ($this->feeds as $feed) {
                $feed = @file_get_contents($feed);
                if ($feed) {
                    $DOMDocument = new \DOMDocument();
                    $DOMDocument->strictErrorChecking = false;
                    if ($DOMDocument->loadXML($feed)) {
                        $nodes = $DOMDocument->getElementsByTagName('item');
                        foreach ($nodes as $node) {
                            try {
                                $this->addNode(
                                        new RSSNode(
                                                array(
                                                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                                                    'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                                                    'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                                                    'date'  => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
                                                )
                                        )
                                );
                            }
                            catch (Exception $e) {
                                // ..  
                            }
                        }
                    }
                }
            }
            $this->setCache();
        }
        $this->sort();

        return $this->countNodes();
    }

    /**
     * Set APC cache 
     */
    protected function setCache()
    {
        if (extension_loaded('apc')) {
            if (function_exists('apc_exists')) {
                if (apc_exists($this->apcKey)) {
                    apc_store($this->apcKey, $this->nodes, 3600);
                }
            }
        }
    }

    /**
     * Retrieves from APC cache
     * @return boolean 
     */
    protected function getCache()
    {
        if (extension_loaded('apc')) {
            if (function_exists('apc_store')) {
                if (apc_exists($this->apcKey)) {
                    return apc_fetch($this->apcKey);
                }
            }
        }
        return false;
    }

    /**
     * Retrieves a $limit number of nodes
     * 
     * @param int $limit
     * @return array $nodes
     */
    public function getNodes($limit = 20)
    {
        $limit = (int) $limit;
        $response = array();
        for ($i = 0; $i < $limit; $i++) {
            if (isset($this->nodes[$i])) {
                array_push($response, $this->nodes[$i]);
            }
        }
        return $response;
    }

    public function sort()
    {
        $countNodes = $this->countNodes();
        for ($i = 1; $i < $countNodes; $i++) {
            for ($j = 0; $j < $countNodes - $i; $j++) {
                if ($this->nodes[$j]->getTimestamp() < $this->nodes[$j + 1]->getTimestamp()) {
                    $k = $this->nodes[$j + 1];
                    $this->nodes[$j + 1] = $this->nodes[$j];
                    $this->nodes[$j] = $k;
                }
            }
        }
    }

}