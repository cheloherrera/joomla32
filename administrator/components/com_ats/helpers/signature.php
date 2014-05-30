<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

class AtsHelperSignature
{
	public static function getSignature(JUser $user)
	{
		static $signatures = array();
		
		if(!array_key_exists($user->username, $signatures)) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->qn('profile_value'))
				->from($db->qn('#__user_profiles'))
				->where($db->qn('user_id').' = '.$db->q($user->id))
				->where($db->qn('profile_key').' = '.$db->q('ats.signature'))
			;
			$db->setQuery($query);
			$signature = $db->loadResult();
			if(!is_null($signature)) {
				if(!class_exists('AtsHelperFilter', false)) {
					require_once JPATH_ADMINISTRATOR.'/components/com_ats/filter.php';
				}
				$signature = AtsHelperFilter::filterText($signature, $user);
			}
			$signatures[$user->username] = empty($signature) || is_null($signature) ? '' : $signature;
		}

		return $signatures[$user->username];
	}
}