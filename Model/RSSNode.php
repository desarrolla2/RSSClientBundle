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

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $desc = null;

    /**
     * @var string
     */
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
        $this->setOptions($options);
    }
    
    /**
     * toString 
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getDesc();
    }

    /**
     *
     * @param array $options 
     */
    public function setOptions($options = array())
    {
        if (is_array($options)) {
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
    }

    /**
     * Clean text for XSS atacks
     * 
     * @param string $string
     * @return string $string 
     */
    protected function doClean($string)
    {
        return strip_tags((string) $string);
    }

    /**
     *
     * @param string $title 
     */
    public function setTitle($title)
    {
        $this->title = $this->doClean($title);
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
        $this->desc = $this->doClean($desc);
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
        $this->link = $this->doClean($link);
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
            if (strtotime($date)) {
                $this->pubDate = new DateTime($this->doClean($date));
            } else {
                $this->pubDate = new DateTime('-1 year');
            }
        }
        catch (Exception $e) {
            $this->pubDate = new DateTime('-1 year');
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
