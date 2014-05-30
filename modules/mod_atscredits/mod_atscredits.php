<?php
/**
 *  @package	ats
 *  @copyright	Copyright (c)2010-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 *  @license	GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 *  @version 	$Id$
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('');

// PHP version check
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	// No version info. I'll lie and hope for the best.
	$version = '5.0.0';
}
// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.3.0', '>=')) return;

include_once JPATH_LIBRARIES.'/f0f/include.php';
if(!defined('F0F_INCLUDED') || !class_exists('F0FForm', true))
{
	return;
}
require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/credits.php';

if(JFactory::getUser()->guest)
{
	echo '&nbsp;';
}
else
{
    $credits = AtsHelperCredits::creditsLeft(JFactory::getUser()->id, true);
	echo JText::sprintf('MOD_ATSCREDITS_CREDITS', $credits);
}