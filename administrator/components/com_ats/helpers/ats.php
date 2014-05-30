<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die;

class AtsHelper
{
	public static function addSubmenu($vName)
	{
		if(!defined('F0F_INCLUDED'))
        {
			include_once JPATH_ADMINISTRATOR.'/components/com_ats/fof/include.php';
		}
		return F0FToolbar::getAnInstance('com_ats')->atsHelperRenderSubmenu($vName);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
     * @param   int     User id
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0, $userId = null)
	{
		// If a user ID is passed we have to use it
		if(!is_null($userId)) {
			$user	= JUser::getInstance($userId);
		} else {
			$user	= JFactory::getUser();
		}

		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_ats';
		} else {
			$assetName = 'com_ats.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit',
			'core.edit.own', 'core.edit.state', 'core.delete',
			'ats.private', 'ats.attachment'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Is the user a manger?
	 *
	 * @param   int   $category  Category id (opt.)
	 * @param   int   $userid    Userid (opt. current user if null)
	 *
	 * @return  bool  Is manager?
	 */
	public static function isManager($category = null, $userid = null)
	{
		$user = JFactory::getUser($userid);

		if ($user->authorise('core.admin', 'com_ats') 	||
			$user->authorise('core.manage', 'com_ats') 	||
			($category ? $user->authorise('core.manage', 'com_ats.category.'.$category) : false)){
				return true;
		}

		return false;
	}

    public static function getManagers($category = null)
	{
		static $cache = array();

		if(isset($cache[$category]))
		{
			return $cache[$category];
		}

		//AFAIK there is no way to get the list of users enabled to do something, so we have to improvise
		$db		   = JFactory::getDbo();
		$users 	   = array();
		$allowed   = array();
		$managers  = array();

		// First, let's get the whole list of groups
		$query = $db->getQuery(true)
					->select('id')
					->from('#__usergroups')
					->order('id DESC');
		$groups = $db->setQuery($query)->loadColumn();

		// Then check if they can admin tickets
		foreach ($groups as $group)
		{
			if (JAccess::checkGroup($group, 'core.admin', 'com_ats')  ||
				JAccess::checkGroup($group, 'core.manage', 'com_ats') ||
				($category ? JAccess::checkGroup($group, 'core.manage', 'com_ats.category.'.$category) : false))
			{
				//If so, let's get all the users
				$users = array_merge($users, JAccess::getUsersByGroup($group));
			}
		}

		// Let's check if any user has the right privileges
		foreach($users as $user)
		{
			$juser = JUser::getInstance($user);
			if ($juser->authorise('core.admin', 'com_ats') 		||
				$juser->authorise('core.manage', 'com_ats') 	||
			   ($category ? $juser->authorise('core.manage', 'com_ats.category.'.$category) : false))
			{
				$allowed[] = $user;
			}
		}

		if($allowed)
		{
			$query = $db->getQuery(true)
						->select('id, name')
						->from('#__users')
						->where('id IN('.implode(',', $allowed).')')
						->where('block = 0');
			$managers = $db->setQuery($query)->loadObjectList('id');
		}

		$cache[$category] = $managers;

		return $managers;
	}

	public static function getCustomTicketStatuses()
	{
		static $statuses = '';

		if(is_array($statuses)) return $statuses;

		$custom = JComponentHelper::getParams('com_ats')->get('customStatuses', '');
		$custom = str_replace("\\n" , "\n", $custom);
		$custom = str_replace("\r"  , "\n", $custom);
		$custom = str_replace("\n\n", "\n", $custom);

		$lines = explode("\n", $custom);
		foreach($lines as $line)
		{
			$parts = explode('=', $line);
			if(count($parts) != 2) continue;

			$statuses[$parts[0]] = $parts[1];
		}

		// Uh oh, there are no custom status, let's set an empty array, so next time I can skip the above lines
		if(!$statuses)
		{
			$statuses = array();
		}

		return $statuses;
	}

    /**
     * Shorthand function to perform a redirect or output the message in JSON format if the
     * incoming call was made using AJAX
     *
     * @param   string  $format
     * @param   string  $url
     * @param   string  $msg
     * @param   string  $type
     * @param   array   $extra
     *
     * @return void
     */
	public static function redirect($format, $url, $msg = null, $type = null, $extra = array())
	{
		$app = JFactory::getApplication();

		if($format == 'json')
		{
			$response['result'] = true;
			$response['error']  = '';

			if($type == 'error')
			{
				$response['result'] = false;
				$response['error']  = $msg;
			}

            $response = array_merge($response, $extra);

			header('Content-type: application/json');
			echo json_encode($response);

			$app->close();
		}
		else
		{
			$app->redirect($url, $msg, $type);
		}
	}
}