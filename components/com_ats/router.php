<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_LIBRARIES.'/f0f/include.php';
require_once JPATH_SITE.'/components/com_ats/helpers/router.php';

/**
 * Which views does this router handle?
 */
global $atsHandleViews;
$atsHandleViews = array(
	'categories', 'latest', 'my', 'newticket', 'ticket', 'tickets'
);

function AtsBuildRoute(&$query)
{
	global $atsHandleViews;
	$segments = array();

	// We need to find out if the menu item link has a view param
	$menuQuery = array();
	$menuView = 'categories';
	$Itemid = AtsHelperRouter::getAndPop($query, 'Itemid', 0);

	// Get the menu view, if an Item ID exists
	if($Itemid) {
		$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
		if(is_object($menu)) {
			parse_str(str_replace('index.php?',  '',$menu->link), $menuQuery); // remove "index.php?" and parse
			if(array_key_exists('view', $menuQuery)) {
				$menuView = $menuQuery['view'];
			}
		}

		$query['Itemid'] = $Itemid;
	}

	// Add the view
	$newView = array_key_exists('view', $query) ? $query['view'] : $menuView;

	// We can only handle specific views. Is it one of them?
	if(!in_array($newView, $atsHandleViews)) {
		if($Itemid) $query['Itemid'] = $Itemid;
		return array();
	}

	// Remove the option and view from the query
	AtsHelperRouter::getAndPop($query, 'view');

	// Build the URL
	switch($newView)
	{
		case 'tickets':
			// Fetch the category ID
			$catID = AtsHelperRouter::getAndPop($query, 'category', 0);

			// Do I have to look for a new Item ID?
			$found = false;
			$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
			$qoptions = array(
				'option'	=> 'com_ats',
				'view'		=> 'tickets',
			);
			$params = array(
				'category'	=> $catID
			);
			$found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);
			if(!$found) {
				$qoptions2 = array_merge($qoptions, array('category' => $catID));
				$found = AtsHelperRouter::checkMenu($menu, $qoptions2);
			}
			if(!$found) {
				// Try to find a menu item ID directly for this category
				$item = AtsHelperRouter::findMenu($qoptions, $params);

				// Or, try to find a manual link
				if(is_null($item)) {
					$item = AtsHelperRouter::findMenu($qoptions2);
				}

				if(!is_null($item)) {
					$Itemid = $item->id;
					$found = true;
				}

			}

			// Get and append the category alias path, if the category wasn't found
			if(!$found)
			{
				$db = JFactory::getDbo();
				$q = $db->getQuery(true)
					->select($db->qn('path'))
					->from($db->qn('#__categories'))
					->where($db->qn('id').' = '.$db->q($catID))
					->where($db->qn('extension').' = '.$db->q('com_ats'));
				$db->setQuery($q);
				$path = $db->loadResult();
				$pathParts = explode('/', $path);
				foreach($pathParts as $p) $segments[] = $p;
			}
			break;

		case 'ticket':
			$ticketID = AtsHelperRouter::getAndPop($query, 'id', 0);
			$ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')
				->setId($ticketID)
				->getItem();
			$catID = $ticket->catid;

			// Do I have to look for a new Item ID?
			$found = false;
			$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
			$qoptions = array(
				'option'	=> 'com_ats',
				'view'		=> 'tickets',
			);
			$params = array(
				'category'	=> $catID
			);
			$found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);
			if(!$found) {
				$qoptions2 = array_merge($qoptions, array('category' => $catID));
				$found = AtsHelperRouter::checkMenu($menu, $qoptions2);
			}
			if(!$found) {
				// Try to find a menu item ID directly for this category
				$item = AtsHelperRouter::findMenu($qoptions, $params);

				// Or, try to find a manual link
				if(is_null($item)) {
					$item = AtsHelperRouter::findMenu($qoptions2);
				}

				if(is_null($item))
				{
					unset($qoptions2['category']);
					$qoptions2['view'] = 'categories';
					$item = AtsHelperRouter::findMenu($qoptions2);
					if(!is_null($item))
					{
						$Itemid = $item->id;
					}
				}
				else
				{
					$Itemid = $item->id;
					$found = true;
				}

			}

			// Get and append the category alias path, if the category wasn't found
			if(!$found)
			{
				$db = JFactory::getDbo();
				$q = $db->getQuery(true)
					->select($db->qn('path'))
					->from($db->qn('#__categories'))
					->where($db->qn('id').' = '.$db->q($catID))
					->where($db->qn('extension').' = '.$db->q('com_ats'));
				$db->setQuery($q);
				$path = $db->loadResult();
				$pathParts = explode('/', $path);
				foreach($pathParts as $p) $segments[] = $p;
			}

			// Append the ticket ID and alias
			$segments[] = $ticketID . ':' . $ticket->alias;

			break;

		case 'newticket':
			$catID = AtsHelperRouter::getAndPop($query, 'category', 0);

			// Do I have to look for a new Item ID?
			$found = false;
			$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
			$qoptions = array(
				'option'	=> 'com_ats',
				'view'		=> 'tickets',
			);
			$params = array(
				'category'	=> $catID
			);
			$found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);
			if(!$found) {
				$qoptions2 = array_merge($qoptions, array('category' => $catID));
				$found = AtsHelperRouter::checkMenu($menu, $qoptions2);
			}
			if(!$found) {
				// Try to find a menu item ID directly for this category
				$item = AtsHelperRouter::findMenu($qoptions, $params);

				// Or, try to find a manual link
				if(is_null($item)) {
					$item = AtsHelperRouter::findMenu($qoptions2);
				}

				if(!is_null($item)) {
					$Itemid = $item->id;
					$found = true;
				}

			}

			// Get and append the category alias path, if the category wasn't found
			if(!$found)
			{
				$db = JFactory::getDbo();
				$q = $db->getQuery(true)
					->select($db->qn('path'))
					->from($db->qn('#__categories'))
					->where($db->qn('id').' = '.$db->q($catID))
					->where($db->qn('extension').' = '.$db->q('com_ats'));
				$db->setQuery($q);
				$path = $db->loadResult();
				$pathParts = explode('/', $path);
				foreach($pathParts as $p) $segments[] = $p;
			}

			// Append "new"
			$segments[] = 'new';

			// Make sure the view name is not added
			$newView = '';
			break;

		case 'categories':
		case 'my':
		case 'latest':
			// Do I have to look for a new Item ID?
			$found = false;
			$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
			$qoptions = array(
				'option'	=> 'com_ats',
				'view'		=> $newView,
			);
			$found = AtsHelperRouter::checkMenu($menu, $qoptions);
			if(!$found) {
				// Try to find a menu item ID directly for this category
				$item = AtsHelperRouter::findMenu($qoptions);

				if(!is_null($item)) {
					$Itemid = $item->id;
					$found = true;
				}
			}

			// No other parameters are expected
			break;
	}

	// Process the Itemid
	$menuView = null;
	if($Itemid) {
		$menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
		if(is_object($menu)) {
			parse_str(str_replace('index.php?',  '',$menu->link), $menuQuery); // remove "index.php?" and parse
			if(array_key_exists('view', $menuQuery)) {
				$menuView = $menuQuery['view'];
			}
		}

		$query['Itemid'] = $Itemid;
	}

	// If the menu's view is different to the new view, add the view name to the URL
	if(!empty($newView) && ($newView != $menuView)) {
		// Only append the view name if the $menuView is not categories, OR if the
		// $menuView is categories and the $newView IS NOT 'ticket' or 'tickets'
		if( ($menuView != 'categories') || empty($menuView) ) {
			array_unshift($segments, $newView);
		} elseif(!in_array($newView, array('ticket','tickets'))) {
			array_unshift($segments, $newView);
		}
	}

	return $segments;
	//@ob_end_clean();var_dump($query);die();
}

function atsParseRoute(&$segments)
{
	$query = array();

	global $atsHandleViews;

	// Fetch the default query from the active menu item
	$mObject = JFactory::getApplication()->getMenu()->getActive();
	$query = is_object($mObject) ? $mObject->query : array();

	if(!array_key_exists('option', $query)) $query['option'] = 'com_ats';
	if(!array_key_exists('view', $query)) $query['view'] = 'categories';
	$view = $query['view'];

	// Replace : with - in segments
	$segments = AtsHelperRouter::preconditionSegments($segments);

	// Do not process an empty segment list (just in case...)
	if(empty($segments)) return $query;

	// Do not process a view I know nothing at all about
	if(!in_array($view, $atsHandleViews)) return $query;

	// Initialise
	$ticketID = null;
	$catID = null;

	// If we have segments and we're in a no-parameters view, we have to deal
	// with a different view than the one listed in the menu.
	if(in_array($view, array('my', 'latest'))) {
		$view = array_shift($segments);
	}
	// Otherwise, do I have a new ticket view?
	else {
		$lastSegment = array_pop($segments);
		if($lastSegment == 'new') {
			$view = 'newticket';
		} else {
			$segments[] = $lastSegment;
		}
	}

	// If this is a categories or tickets view, we have to check the last
	// segment to figure out if it's really a "ticket" view.
	if(in_array($view, array('categories','tickets','ticket','newticket'))) {
		// Is it a category path?
		$path = implode('/',$segments);
		$db = JFactory::getDbo();
		$q = $db->getQuery(true)
			->select($db->qn('id'))
			->from($db->qn('#__categories'))
			->where($db->qn('path').' = '.$db->q($path))
			->where($db->qn('extension').' = '.$db->q('com_ats'));
		$db->setQuery($q);
		$catID = $db->loadResult();

		if($catID) {
			// The category exists, therefore it's a "tickets" view, unless it's
			// a 'newticket' view
			if($view != 'newticket') $view = 'tickets';
		} else {
			// Do we have a valid-looking ticket ID?
			$lastSegment = array_pop($segments);
			$segments[] = $lastSegment;

			$sParts = explode('-', $lastSegment);
			$ticketID = (int)$sParts[0];

			if($ticketID > 0) {
				// We have a valid-looking ticket ID. I think it's a "ticket" view.
				$view = 'ticket';
				// We don't care about the path. The ticket ID is enough, he he!
				$segments = array();
			} elseif($view == 'newticket') {
				$ticketID = 0;
				$catID = $mObject->query['category'];
				if (isset($query['id']))
				{
					unset($query['id']);
				}
				//var_dump($catID);die();
			} else {
				// This will result in a 404. Can't have it all, dude.
				$catID = 0;
				$view = 'tickets';
			}
		}

		$query['view'] = $view;
		if($ticketID) {
			$query['id'] = $ticketID;
		} elseif($catID) {
			$query['category'] = $catID;
		}
	}

	return $query;
}