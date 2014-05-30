<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3RC4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class TableFeed extends JTable

{
	var $id=null;

  	var $title=null;

  	var $content_type=null;

	var $sectionid = 0;

  	var $feed=null;

  	var $description=null;

  	var $catid=null;

  	var $published=null;

  	var $front_page=null;

  	var $default_author=null;

  	var $default_introtext=null;

  	var $created = null;

  	var $created_by = 0;

  	var $checked_out = 0;

	var $checked_out_time = 0;

  	var $last_run = null;

  	var $last_email = null;

  	var $filtering = 0;

  	var $filter_whitelist = null;

  	var $filter_blacklist = null;

  	var $params = null;

  	var $imports = null;

	/**

	* @param database A database connector object

	*/

	function TableFeed(&$db)
	{
		parent::__construct( '#__feedgator', 'id', $db );
	}
}