<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

/**
 * Integration with subscriptions components
 */
class AtsHelperSubscriptions
{
	/**
	 * Do we have a subscriptions component?
	 *
	 * @return bool
	 */
	public static function hasSubscriptionsComponent()
	{
		static $result = null;

		if(is_null($result)) {
			JLoader::import('joomla.filesystem.folder');
			$result = JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_akeebasubs');
		}

		return $result;
	}

	/**
	 * Get a list of the subscription levels (IDs and names) for a particular
	 * user.
	 *
	 * @param JUser $user The user to check
	 *
	 * @return object An object with arrays for active and inactive subscriptions
	 */
	public static function getSubscriptionsList(JUser $user = null)
	{
		static $cache = array();

		if(!self::hasSubscriptionsComponent()) {
			return (object)array(
				'active'	=> array(),
				'inactive'	=> array(),
			);
		}

		if(!($user instanceof JUser)) {
			$user = JFactory::getUser();
		}

		if(!array_key_exists($user->id, $cache))
		{
			$subs = F0FModel::getTmpInstance('Subscriptions', 'AkeebasubsModel')
				->limit(0)
				->limitstart(0)
				->paystate('C')
				->user_id($user->id)
				->getList();

			$subscriptions_active = array();
			$subscriptions_inactive = array();
			if(!empty($subs)) foreach($subs as $sid => $sub) {
				$name = $sub->title;
				if($sub->enabled) {
					if(!in_array($name, $subscriptions_active)) $subscriptions_active[] = $name;
				} else {
					if(!in_array($name, $subscriptions_inactive)) $subscriptions_inactive[] = $name;
				}
			}

			$cache[$user->id] = (object)array(
				'active'	=> $subscriptions_active,
				'inactive'	=> $subscriptions_inactive
			);
		}

		return $cache[$user->id];
	}
}