<?php
/**
 * @version   $Id: Source.php 6813 2013-01-28 04:28:56Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('ROKMINIEVENTS') or die('Restricted access');

/**
 *
 */
interface RokMiniEvents_Source
{
	/**
	 * @abstract
	 *
	 * @param $params
	 */
	function getEvents(&$params);

	/**
	 * Checks to see if the source is available to be used
	 * @abstract
	 * @return bool
	 */
	function available();
}
