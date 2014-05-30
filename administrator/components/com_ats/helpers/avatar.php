<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

/**
 * Avatar display helper class
 */
class AtsHelperAvatar
{
	/**
	 * Uses the ATS plugins to fetch ana avatar for the user
	 * 
	 * @param JUser $user The user for which to fetch an avatar for
	 * @param int $size The size (in pixels), defaults to 64
	 * @return string The URL to the avatar image
	 */
	public static function getAvatarURL($user, $size = 64)
	{
		JLoader::import('joomla.plugin.helper');
		JPluginHelper::importPlugin('ats');
		$dispatcher = JDispatcher::getInstance();
		$jResponse = $dispatcher->trigger('onATSAvatar',array($user, $size));
		$url = '';
		if(!empty($jResponse)) {
			foreach($jResponse as $response)
			{
				if($response) {
					$url = $response;
				}
			}
		}
		
		return $url;
	}
}