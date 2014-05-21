<?php
/**
 * @version   $Id: SourceBase.php 6813 2013-01-28 04:28:56Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('ROKMINIEVENTS') or die('Restricted access');

abstract class RokMiniEvents_SourceBase implements RokMiniEvents_Source
{
	protected static function getTime($params, $date)
	{
		$display = $params->get('timedisplay', 24);

		if ($display == '24') return date('H:i', $date); else return date('h:iA', $date);
	}
}
