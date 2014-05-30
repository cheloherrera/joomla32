<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelCategories extends F0FModel
{
	/**
	 * This trick allows us to proxy the back-end CategoriesModelCategories
	 * model through a F0FModel instance
	 *
	 * @param   boolean   $overrideLimits
	 *
	 * @return  JDatabaseQuery
	 */
	function buildQuery($overrideLimits = false)
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$userid = $this->getState('userid', 0, 'int');
		if(!$userid) {
			$user	= JFactory::getUser();
		} else {
			$user	= JUser::getInstance($userid);
		}

		// Select the required fields from the table.
		$query->select(
			'a.id, a.title, a.alias, a.description' .
			', a.level, a.language, a.params'
		);
		$query->from('#__categories AS a');

		// Join over the language
		$query->select('l.title AS language_title');
		$query->join('LEFT', $db->qn('#__languages').' AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_user_id');

		// Filter by extension
		$query->where('a.extension = '.$db->q('com_ats'));

		// Filter on the level.
		if ($level = $this->getState('level', 0, 'int')) {
			$query->where('a.level <= '.(int) $level);
		}

		// Filter by access level.
		if ($access = $this->getState('access', null)) {
			$query->where('a.access = ' . (int) $access);
		}

		// Implement View Level Access
		if (!$user->authorise('core.admin'))
		{
			$groups	= implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN ('.$groups.')');
		}

		// Filter by published state
		$published = $this->getState('published', 1);
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			elseif (stripos($search, 'author:') === 0) {
				$search = $db->q('%'.$db->escape(substr($search, 7), true).'%');
				$query->where('(ua.name LIKE '.$search.' OR ua.username LIKE '.$search.')');
			}
			else {
				$search = $db->q('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.' OR a.alias LIKE '.$search.' OR a.note LIKE '.$search.')');
			}
		}

		// Add the list ordering clause
		$listOrdering = $this->getState('ordering', 'a.lft');
		$listDirn = $db->escape($this->getState('direction', 'ASC'));
		if ($listOrdering == 'a.access') {
			$query->order('a.access '.$listDirn.', a.lft '.$listDirn);
		} else {
			$query->order($db->escape($listOrdering).' '.$listDirn);
		}

		// Language filtering
		list($isCli, $isAdmin) = F0FDispatcher::isCliAdmin();
		$language = $this->getState('language');
		if (($isCli || $isAdmin) && !empty($language) && ($language != '*')) {
			$query->where('a.language = '.$db->q($language));
		} elseif(!$isCli && !$isAdmin) {
			if(JFactory::getApplication()->getLanguageFilter()) {
				$lang_filter_plugin = JPluginHelper::getPlugin('system', 'languagefilter');
				$lang_filter_params = new JRegistry($lang_filter_plugin->params);
				if ($lang_filter_params->get('remove_default_prefix')) {
					// Get default site language
					$lg = JFactory::getLanguage();
					$query->where('a.language IN ('.$db->q($lg->getTag()).', '.$db->q('*').')');
				}else{
					$query->where('a.language IN (' . $db->q(JFactory::getApplication()->input->getCmd('language', '*')) . ', '.$db->q('*').')');
				}
				/*
				$lang = JFactory::getLanguage()->getTag();
				if(!empty($lang)) {
					$query->where('a.language IN ('.$db->q($lang).', '.$db->q('*').')');
				}
				*/
			}
		}

		// ID filtering
		$id = $this->getState('category', null, 'int');
		if(!is_null($id)) {
			$query->where($db->qn('a').'.'.$db->qn('id').' = '.$db->q($id));
		}

		// Alias filtering
		$alias = $this->getState('alias', null, 'string');
		if(!is_null($alias)) {
			$query->where($db->qn('a').'.'.$db->qn('alias').' = '.$db->q($alias));
		}

		// Hack to show all categories
		$this->setState('limit',0);
		$this->setState('limitstart',0);

		return $query;
	}

	public function getCatParams($catid)
	{
		$params = new JRegistry();

		$this->category($catid);
		$categories = $this->getList(true);

		if(!empty($categories))
		{
			$category = array_pop($categories);
		}
		else
		{
			return false;
		}

		if(version_compare(JVERSION, '3.0', 'ge'))
		{
			$params->loadString($category->params, 'JSON');
		}
		else
		{
			$params->loadJSON($category->params);
		}

		return $params;
	}
}