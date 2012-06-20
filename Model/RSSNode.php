<?php

/*
 * This file is part of the symfony-madrid package.
 * 
 * Short description   
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Jun 19, 2012, 11:18:58 PM
 * @file RSSNode.php , UTF-8
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Model;

use DateTime;

class RSSNode
{

    protected $title = null;
    protected $desc = null;
    protected $link = null;

    /**
     *
     * @var \DateTime
     */
    protected $pubDate = null;

    /**
     *
     * @param array $options 
     */
    public function __construct($options = array())
    {
        if (isset($options['title'])) {
            $this->setTitle($options['title']);
        }
        if (isset($options['desc'])) {
            $this->setDesc($options['desc']);
        }
        if (isset($options['link'])) {
            $this->setLink($options['link']);
        }
        if (isset($options['date'])) {
            $this->setPubDate($options['date']);
        }
    }

    /**
     *
     * @param string $title 
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     *
     * @return string $title 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $desc 
     */
    public function setDesc($desc)
    {
        $this->desc = (string) $desc;
    }

    /**
     *
     * @return string $desc  
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     *
     * @param string $link 
     */
    public function setLink($link)
    {
        $this->link = (string) $link;
    }

    /**
     *
     * @return string $link  
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     *
     * @param  string $date 
     */
    public function setPubDate($date)
    {
        try {
            $this->pubDate = new DateTime($date);
        }
        catch (Exception $e) {
            // ..
        }
    }

    /**
     *
     * @return DateTime $date 
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    public function getTimestamp()
    {
        if ($this->pubDate) {
            return $this->pubDate->getTimestamp();
        }
        return 0;
    }

}
