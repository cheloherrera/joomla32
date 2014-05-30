<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.2
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

/**
* @version		$Id: menuitem.php 11324 2008-12-05 19:06:24Z kdevine $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

/**
 * Renders a select list of content_type/sects/cats
 *
 * @package 	Joomla.Framework
 * @subpackage	Parameter
 * @since		1.5
 */

class JElementFGContent extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'FGContent';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$user			= JFactory::getUser();
		$db				= JFactory::getDBO();
		$pluginModel	= FGFactory::getPluginModel();
		$task			= JRequest::getWord('task');
		$cid = JRequest::getInt('cid',0);

		//node attributes var -> dyna
		$default = $node->attributes('default');
		$type = $node->attributes('var');
		$class	= $node->attributes('class');
		if (!$class) {
			$class = "inputbox";
		}

		$fgParams = JComponentHelper::getParams ('com_feedgator');
		if(!$value) $value = $fgParams->get('content_type');

		$plugins = $pluginModel->loadInstalledPlugins();

		$options = array();

		if($default) {
			$options[] = JHTML::_('select.option', '', JText::_('Use Default'), 'id', 'title');
		} else {
			$options[] = JHTML::_('select.option', -1, $type ? '- '.JText::_('FG_CHOOSE_CONTENT').' -' : '- '.JText::_('FG_DEFAULT_CONTENT').' -', 'id', 'title');
		}
		foreach($plugins as $plugin) {
			if($plugin->published) {
				$options[] = JHTML::_('select.option', $plugin->extension, $plugin->name, 'id', 'title');
			}
		}

		$javascript = $type ? ' onchange="changeDynaList( \'datasectionid\', contentsections, document.adminForm.datacontent_type.options[document.adminForm.datacontent_type.selectedIndex].value, 0, 0); changeDynaList( \'datacatid\', sectioncategories, document.adminForm.datasectionid.options[document.adminForm.datasectionid.selectedIndex].value, 0, 0);"' : '';

		//return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', $attributes, 'value', 'text', $value, $control_name.$name);
		//return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']'.$multipleArray, $attributes, $key, $val, $value, $control_name.$name);
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="'.$class.'"'.$javascript, 'id', 'title', $value, $control_name.$name);
	}
}