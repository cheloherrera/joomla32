<?php
/**
 * @version   $Id: mod_rokminievents.php 6813 2013-01-28 04:28:56Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

if (!defined('ROKMINIEVENTS')) define('ROKMINIEVENTS','ROKMINIEVENTS');
if (!defined('ROKMINIEVENTS_ROOT')) define('ROKMINIEVENTS_ROOT', dirname(__FILE__));

require_once(ROKMINIEVENTS_ROOT . '/lib/include.php');

JHtml::_('behavior.framework', true);
$doc =JFactory::getDocument();
if ($params->get('builtin_css', 1)) $doc->addStyleSheet(JURI::Root(true).'/modules/mod_rokminievents/tmpl/css/rokminievents.css');

if ($params->get('set_widths',1)) {
	$width = $params->get('wrapper_width',750);
	$item = intval($width / $params->get('item_number',3));
	$inlinestyle = ".rokminievents-wrapper {width:".$width."px;} .rokminievents-item {width:".$item."px;}";
	$doc->addStyleDeclaration($inlinestyle);
}


$rokminievents = new RokMiniEvents();
$rokminievents->loadScripts($params);
$events = $rokminievents->getEvents($params);

require(JModuleHelper::getLayoutPath('mod_rokminievents'));