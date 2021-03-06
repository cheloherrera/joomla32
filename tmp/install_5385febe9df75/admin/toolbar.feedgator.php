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

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

switch (strtolower($task))

{
	case 'add':
	case 'edit':
		TOOLBAR_feedgator::_EDIT();
		break;

	case 'editdefault':
		TOOLBAR_feedgator::_FEED_DEFAULT();
		break;

	case 'about':

		TOOLBAR_feedgator::_ABOUT();
		break;

	case 'support':

		TOOLBAR_feedgator::_SUPPORT();
		break;

	case 'settings':

		TOOLBAR_feedgator::_SETTINGS();
		break;

	case 'plugins':

		TOOLBAR_feedgator::_PLUGINS();
		break;

	case 'feeds':

		TOOLBAR_feedgator::_FEEDS();
		break;

	case 'imports':

		TOOLBAR_feedgator::_IMPORTS();
		break;

	case 'tools':

		TOOLBAR_feedgator::_TOOLS();
		break;

	default:

		TOOLBAR_feedgator::_DEFAULT();
		break;
}