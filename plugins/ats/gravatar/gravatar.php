<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

/**
 * Gravatar integration for Akeeba Ticket System
 *
 * @author Nicholas Dionysopoulos <nicholas@akeebabackup.com>
 */
class plgAtsGravatar extends JPlugin
{
	public function onATSAvatar($user, $size = 64)
	{
		if(is_string($user)) {
			$email = $user;
		} elseif($user instanceof JUser) {
			$email = $user->email;
		} else {
			$email = '';
		}

		$md5 = md5($email);

		list($isCLI, $isAdmin) = F0FDispatcher::isCliAdmin();
		if($isCLI) {
			$scheme = 'http';
		} else {
			$scheme = JURI::getInstance()->getScheme();
		}

		if($scheme == 'http') {
			$url = 'http://www.gravatar.com/avatar/'.$md5.'.jpg?s='.$size.'&d=mm';
		} else {
			$url = 'https://secure.gravatar.com/avatar/'.$md5.'.jpg?s='.$size.'&d=mm';
		}

		return $url;
	}
}
