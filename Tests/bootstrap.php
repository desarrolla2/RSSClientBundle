<?php

/**
 * This file is part of the RSSClientBundle proyect.
 * 
 * Description of bootstrap
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@ideup.com>
 * @file : bootstrap.php , UTF-8
 * @date : Aug 10, 2012 , 10:08:10 AM
 */



require_once __DIR__ .'/../vendor/ezyang/htmlpurifier/library/HTMLPurifier/Bootstrap.php';
$loader = require_once __DIR__ .'/../vendor/autoload.php';;
$loader->add('', __DIR__ .'/../vendor/ezyang/htmlpurifier/library');
$loader->add('Desarrolla2\Bundle\RSSClientBundle', __DIR__ .'/');
//
//require_once __DIR__ .'/../Model/RSSNode.php';
//require_once __DIR__ . '/../Model/RSSClientInterface.php';
//require_once __DIR__ . '/../Service/RSSClient.php';