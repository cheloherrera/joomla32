#!/usr/bin/php
<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Please note that you may wish to remove the hashbang placed at the top of this file before the php start tag
// You may also need to edit the path to php for the hashbang

// set error reporting to not warn of session headers already set by hashbang in process.php
error_reporting(E_ERROR | E_PARSE);

define( '_JEXEC', 1 );

define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', substr(__FILE__,0,strrpos(__FILE__, DS.'administrator')));

require_once(JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once(JPATH_ADMINISTRATOR.DS.'includes'.DS.'framework.php' );
require_once(JPATH_ADMINISTRATOR.DS.'includes'.DS.'helper.php' );
require_once(JPATH_ADMINISTRATOR.DS.'includes'.DS.'toolbar.php' );

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();

$version = new JVersion();
define('J_VERSION', $version->getShortVersion());

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'controller.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'factory.feedgator.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'helpers'.DS.'feedgator.helper.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'helpers'.DS.'feedgator.utility.php');
if(file_exists(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'addkeywords.php')) {
	require_once(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'addkeywords.php');
}
FeedgatorUtility::profiling('Start cron');

define('SPIE_CACHE_AGE', 60*10);

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'simplepie'.DS.'simplepie131.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'simplepie'.DS.'overrides.php');
FeedgatorUtility::profiling('Loaded SimplePie');

JRequest::setVar('task','cron','get');
JRequest::setVar(JUtility::getToken(),'1','get');

$jlang = JFactory::getLanguage();
// Back-end translation
$jlang->load('com_feedgator', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_feedgator', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_feedgator', JPATH_ADMINISTRATOR, null, true);

$config = array('base_path'=>JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator');
$controller = new FeedgatorController($config);
$controller->import('all');

FeedgatorUtility::profiling('End');
echo 'Import finished';