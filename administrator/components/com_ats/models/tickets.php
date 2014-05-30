<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelTickets extends F0FModel
{
	private function getFilterValues()
	{
		// On frontend I have the field category, on backend I have catid...
		$category = $this->getState('category', $this->getState('catid', 0,'int') ,'int');

		return (object)array(
			'title'			=> $this->getState('title'			, null, 'string'),
			'alias'			=> $this->getState('alias'			, null, 'string'),
			'username'		=> $this->getState('username'		, null, 'string'),
			'ass_username'	=> $this->getState('ass_username'	, null, 'string'),
			'user_id'		=> $this->getState('user_id'		, null, 'int'),
			'created_since'	=> $this->getState('created_since'	, null, 'string'),
			'created_until'	=> $this->getState('created_until'	, null, 'string'),
			'modified_since'=> $this->getState('modified_since'	, null, 'string'),
			'modified_until'=> $this->getState('modified_until'	, null, 'string'),

			'search'		=> $this->getState('search'			, null, 'string'),
			'enabled'		=> $this->getState('enabled'		, ''  , 'cmd'),
			'status'		=> $this->getState('status'			, null, 'raw'),
			'public'		=> $this->getState('public'			, ''  , 'cmd'),

			'mytickets'		=> $this->getState('mytickets'		, null, 'cmd'),
			'assignedtome'	=> $this->getState('assignedtome'	, null, 'cmd'),
			'frontendfilter'=> $this->getState('frontendfilter'	, null, 'cmd'),

			'groupbydate'	=> $this->getState('groupbydate'	, null, 'int'),

			'category'		=> $category,
			'categories'	=> $this->getState('categories', array(), 'array'),

			'bucket'		=> $this->getState('bucket','','int'),
			'buckets'		=> $this->getState('buckets', array(), 'array'),

			'custom'		=> $this->getState('custom','','raw')
		);
	}

	protected function _buildQueryJoins($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) return;

		$query
			->join('INNER', $db->qn('#__categories').' AS '.$db->qn('c').' ON '.
					$db->qn('c').'.'.$db->qn('id').' = '.
					$db->qn('tbl').'.'.$db->qn('catid'))
			->join('LEFT OUTER', $db->qn('#__users').' AS '.$db->qn('u').' ON '.
					$db->qn('u').'.'.$db->qn('id').' = '.
					$db->qn('tbl').'.'.$db->qn('created_by'))
			->join('LEFT OUTER', $db->qn('#__users').' AS '.$db->qn('ass').' ON '.
					$db->qn('ass').'.'.$db->qn('id').' = '.
					$db->qn('tbl').'.'.$db->qn('assigned_to'))
		;
	}

	protected function _buildQueryColumns($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) {
			$query->select(array(
				'DATE('.$db->qn('created_on').') AS '.$db->qn('date'),
				'COUNT('.$db->qn('ats_ticket_id').') AS '.$db->qn('tickets')
			));
		} else {
			$query->select(array(
				$db->qn('tbl').'.*',

				$db->qn('c').'.'.$db->qn('title').' AS '.$db->qn('category_title'),
				$db->qn('c').'.'.$db->qn('alias').' AS '.$db->qn('category_alias'),
				$db->qn('c').'.'.$db->qn('description').' AS '.$db->qn('category_description'),
				$db->qn('c').'.'.$db->qn('published').' AS '.$db->qn('category_published'),
				$db->qn('c').'.'.$db->qn('language').' AS '.$db->qn('category_language'),

				$db->qn('u').'.'.$db->qn('username').' AS '.$db->qn('user_username'),
				$db->qn('u').'.'.$db->qn('name').' AS '.$db->qn('user_name'),
				$db->qn('u').'.'.$db->qn('email').' AS '.$db->qn('user_email'),

				$db->qn('ass').'.'.$db->qn('name').' AS '.$db->qn('assigned_name')
			));

			$filterNewest = $this->getState('filterNewest', false, 'bool');

			if ($filterNewest)
			{
				$order = 'IFNULL('.$db->qn('modified_on').','.$db->qn('created_on').')';
			}
			else
			{
				$order = $this->getState('filter_order', 'ats_ticket_id', 'cmd');
				if (!in_array($order, array_keys($this->getTable()->getData())))
				{
					$order = 'ats_ticket_id';
				}
			}

			$dir = strtoupper($this->getState('filter_order_Dir', 'DESC', 'cmd'));

			if (!in_array($dir,array('ASC','DESC')))
			{
				$dir = 'ASC';
			}

			$query->order($order.' '.$dir);
		}
	}

	protected function _buildQueryGroup($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) {
			$query->group(array(
				'DATE('.$db->qn('tbl').'.'.$db->qn('created_on').')'
			));
		}
	}

	protected function _buildQueryWhere($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		JLoader::import('joomla.utilities.date');

		if(!$state->groupbydate) {
			// Search for title
			if($state->title) {
				$title = "%{$state->title}%";
				$query->where(
					$db->qn('tbl').'.'.$db->qn('title').' LIKE '.$db->q($title)
				);
			}

			// Search for alias
			if($state->alias) {
				$alias = "{$state->alias}%";
				$query->where(
					$db->qn('tbl').'.'.$db->qn('alias').' LIKE '.$db->q($alias)
				);
			}

			// Search for username
			if($state->username) {
				$username = "%{$state->username}%";
				$query->where(
					$db->qn('u').'.'.$db->qn('username').' LIKE '.$db->q($username)
				);
			}

			// Search for assigned to name
			if($state->ass_username) {
				$ass_username = "%{$state->ass_username}%";
				$query->where(
					$db->qn('ass').'.'.$db->qn('name').' LIKE '.$db->q($ass_username)
				);
			}

			// Search for title
			if($state->search) {
				$search = "%{$state->search}%";
				$query->where(
					$db->qn('tbl').'.'.$db->qn('title').' LIKE '.$db->q($search)
				);
			}


			// Filter by user ID
			if($state->user_id > 0) {
				$query->where(
					$db->qn('tbl').'.'.$db->qn('created_by').' = '.$db->q($state->user_id)
				);
			}

			// Filter by category ID
			if ($state->category > 0)
			{
				$query->where(
					$db->qn('tbl').'.'.$db->qn('catid').' = '.$db->q($state->category)
				);
			}
			elseif (!empty($state->categories))
			{
				$categories = array();
				foreach ($state->categories as $catid)
				{
					$clean = (int)$catid;
					if (!in_array($catid, $categories))
					{
						$categories[] = $db->q($catid);
					}
				}
				$query->where(
					$db->qn('tbl').'.'.$db->qn('catid').' IN('.implode(',', $categories).')'
				);
			}

			// Filter by bucket ID
			if ($state->bucket > 0)
			{
				$query->where(
					$db->qn('tbl').'.'.$db->qn('ats_bucket_id').' = '.$db->q($state->bucket)
				);
			}
			elseif (!empty($state->buckets))
			{
				$buckets = array();
				foreach ($state->buckets as $bucketid)
				{
					$clean = (int)$bucketid;
					if (!in_array($bucketid, $buckets))
					{
						$buckets[] = $db->q($bucketid);
					}
				}
				$query->where(
					$db->qn('tbl').'.'.$db->qn('ats_bucket_id').' IN('.implode(',', $buckets).')'
				);
			}

			// Filter only my tickets
			if($state->mytickets == 1) {
				$user_id = JFactory::getUser()->id;
				if($user_id > 0) {
					$query->where(
						$db->qn('tbl').'.'.$db->qn('created_by').' = '.
							$db->q($user_id)
					);
				}
			}

            if($state->assignedtome == 1)
            {
                $user_id = JFactory::getUser()->id;

                if($user_id > 0)
                {
                    $query->where($db->qn('tbl').'.'.$db->qn('assigned_to').' = '.$db->q($user_id));
                }
            }

			// Filter only public tickets and tickets visible to me
			if($state->frontendfilter == 1) {
				$user_id = JFactory::getUser()->id;

				$iAmGod = false;
				$category = $state->category;
				if($category) {
					$iAmGod = JFactory::getUser()->authorise('core.manage', 'com_ats.category.'.$category);
				}
				if(!$iAmGod) {
					$iAmGod = JFactory::getUser()->authorise('core.manage', 'com_ats');
				}

				if(!$iAmGod && ($user_id > 0)) {
					// I am not a manager and I have a user ID
					$query->where(
						'('.
							'('.$db->qn('tbl').'.'.$db->qn('public').' = '.$db->q(1).')'.
						' OR '.
							'('.
								'('.$db->qn('tbl').'.'.$db->qn('public').' = '.$db->q(0).')'.
								'AND'.
								'('.$db->qn('tbl').'.'.$db->qn('created_by').' = '.$db->q($user_id).')'.
							')'.
							/**/
						')'
					);
				} elseif(!$iAmGod) {
					// I am a guest
					$query->where(
						'('.$db->qn('tbl').'.'.$db->qn('public').' = '.$db->q(1).')'
					);
				}
				// If I am a manager there is no filtering (show all tickets)
			}
		}

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('enabled').' = '.
					$db->q($state->enabled)
			);
		}

		// Filter by public status
		if(is_numeric($state->public)) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('public').' = '.
					$db->q($state->public)
			);
		}

		// Filter by status (open, closed, pending)
		if($state->status) {
			$states_temp = explode(',', $state->status);
			$states = array();
			foreach($states_temp as $s) {
				$s = strtoupper($s);
				if(!in_array($s, array('O','P','C', 1, 2, 3, 4, 5, 6, 7, 8, 9))) continue;
				$states[] = $db->q($s);
			}
			if(!empty($states)) {
				$query->where(
					$db->qn('tbl').'.'.$db->qn('status').' IN ('.
						implode(',',$states).')'
				);
			}
		}



		// "Created Since" queries
		$since = trim($state->created_since);
		if(empty($since) || ($since == '0000-00-00') || ($since == '0000-00-00 00:00:00')) {
			$since = '';
		} else {
			$jFrom = new JDate($since);
			$since = $jFrom->toUnix();
			if($since == 0) {
				$since = '';
			} else {
				$since = $jFrom->toSql();
			}
			// Filter from-to dates
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_on').' >= '.
					$db->q($since)
			);
		}

		// "Created Until" queries
		$until = trim($state->created_until);
		if(empty($until) || ($until == '0000-00-00') || ($until == '0000-00-00 00:00:00')) {
			$until = '';
		} else {
			$jFrom = new JDate($until);
			$until = $jFrom->toUnix();
			if($until == 0) {
				$until = '';
			} else {
				$until = $jFrom->toSql();
			}
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_on').' <= '.
					$db->q($until)
			);
		}

		// "Modified Since" queries
		$since = trim($state->modified_since);
		if(empty($since) || ($since == '0000-00-00') || ($since == '0000-00-00 00:00:00')) {
			$since = '';
		} else {
			$jFrom = new JDate($since);
			$since = $jFrom->toUnix();
			if($since == 0) {
				$since = '';
			} else {
				$since = $jFrom->toSql();
			}
			// Filter from-to dates
			$query->where(
				$db->qn('tbl').'.'.$db->qn('modified_on').' >= '.
					$db->q($since)
			);
		}

		// "Modified Until" queries
		$until = trim($state->modified_until);
		if(empty($until) || ($until == '0000-00-00') || ($until == '0000-00-00 00:00:00')) {
			$until = '';
		} else {
			$jFrom = new JDate($until);
			$until = $jFrom->toUnix();
			if($until == 0) {
				$until = '';
			} else {
				$until = $jFrom->toSql();
			}
			$query->where(
				$db->qn('tbl').'.'.$db->qn('modified_on').' <= '.
					$db->q($until)
			);
		}
	}

	public function buildQuery($overrideLimits = false) {
		$db = $this->getDbo();
		$query = $db->getQuery(true)
				->from($db->qn('#__ats_tickets').' AS '.$db->qn('tbl'));

		$this->_buildQueryColumns($query);
		$this->_buildQueryJoins($query);
		$this->_buildQueryWhere($query);
		$this->_buildQueryGroup($query);

		return $query;
	}

	protected function onProcessList(&$resultArray)
	{
		// Process on CSV format only
		if($this->input->get('format', 'html') != 'csv')
		{
			return;
		}

		foreach ($resultArray as &$row)
		{
			// Process only tickets with custom fields
			if(!$row->params || $row->params == '{}')
			{
				continue;
			}

			$customfields = json_decode($row->params, true);
			if (!empty($customfields))
			{
				foreach($customfields as $slug => $value)
				{
					$field = 'custom_'.$slug;
					$row->$field = $value;
				}
			}

			unset($row->params);
		}
	}

	public function visible($publish = 1, $user = null)
	{
		if(is_array($this->id_list) && !empty($this->id_list)) {
			if(empty($user)) {
				$oUser = JFactory::getUser();
				$user = $oUser->id;
			}
			$table = $this->getTable($this->table);

			if(!$this->onBeforeVisible($table)) return false;

			if(!$table->visible($this->id_list, $publish, $user) ) {
				$this->setError($table->getError());
				return false;
			} else {
				$this->onAfterVisible($table);

				// Call the plugin events
				$dispatcher = JDispatcher::getInstance();
				JPluginHelper::importPlugin('content');
				$name = $this->input->getCmd('view','cpanel');
				$context = $this->option.'.'.$name.'.visibility';
				$result = $dispatcher->trigger($this->event_change_state, array($context, $this->id_list, $publish));
			}
		}
		return true;
	}

	public function setstatus($status = 'C', $user = null)
	{
		if(is_array($this->id_list) && !empty($this->id_list)) {
			if(empty($user)) {
				$oUser = JFactory::getUser();
				$user = $oUser->id;
			}
			$table = $this->getTable($this->table);

			if(!$table->setstatus($this->id_list, $status, $user) ) {
				$this->setError($table->getError());
				return false;
			}
		}
		return true;
	}

	/**
	 * Is everythinng ok?
	 *
	 * @TODO At the moment only checks for custom fields, then we have to move ticket checks here
	 *
	 * @param   F0FTable    $table  Table instance to perform checks
	 *
	 * @return   bool   Is the submitted form ok (including custom field data)?
	 */
	public function isValid($table)
	{
		$validation = $this->getValidation($table);

		$isValid = true;
		// Make sure custom fields also validate
		$isValid = $isValid && $validation->custom_valid;

		return $isValid;
	}

	/**
	 * Loads and decode ticket custom fields data, returning an array conataining labels and values
	 *
	 * @return   array   Array list of array following this logic:
	 *                   array('label' => field label, 'value' => field value)
	 */
	public function loadCustomFields()
	{
		$customFields = array();

		$ticket_id = $this->getId();

		// Got no ticket id, return an empty set
		if(!$ticket_id)
		{
			return $customFields;
		}

		$table     = $this->getTable();
		$table->load($ticket_id);
		$to_decode = json_decode($table->params, true);

		// No fields to decode
		if(!$to_decode)
		{
			return $customFields;
		}

		$decoded = F0FModel::getTmpInstance('Customfields', 'AtsModel')
					->enabled(1)
					->getList(true, 'slug');

		foreach ($to_decode as $slug => $value)
		{
			if(isset($decoded[$slug]))
			{
				switch ($decoded[$slug]->type)
				{
					// Display a "yes" or "no" string
					case 'checkbox':
						if(strtolower($value) == 'on')
						{
							$value = JText::_('JYES');
						}
						else
						{
							$value = JText::_('JNO');
						}
						break;
					// Display the value label, not the value itself
					case 'dropdown':
					case 'list':
					case 'radio':
						//Use of non-capturing group: end of line OR new line
						preg_match('/'.$value.'=(.*?)(?:$|\n)/i', $decoded[$slug]->options, $matches);
						isset($matches[1]) ? $value = $matches[1] : '';
						break;
                    case 'multiselect':

                        $values = array();

                        foreach($value as $selected)
                        {
                            preg_match('/'.$selected.'=(.*?)(?:$|\n)/i', $decoded[$slug]->options, $matches);
                            isset($matches[1]) ? $values[] = trim($matches[1]) : '';
                        }

                        $value = implode(', ', $values);

                        break;
					default:
						;
					break;
				}

				$customFields[] = array('label' => $decoded[$slug]->title,
										'value' => $value);
			}
		}

		return $customFields;
	}

	/**
	 * Performs a validation
	 * @TODO This function should be moved into table check method?
	 */
	protected function getValidation($table)
	{
		JLoader::import('joomla.plugin.helper');
		JPluginHelper::importPlugin('ats');

		$response = (object)array(
			'custom_validation'		=> array(),
			'custom_valid'			=> true
		);

		try
		{
			$app      = JFactory::getApplication();
		}
		catch (Exception $e)
		{
			// Application instantiation error, i.e. we're running in CLI.
			$app = null;
		}

		$savestate = $this->_savestate;
		$this->savestate(0);
		$state = $this->getFilterValues();
		$this->savestate($savestate);

		// Get the results from the custom validation
		list($isCli , $isAdmin) = F0FDispatcher::isCliAdmin();

		if((!$isCli && !$isAdmin) || ($isAdmin && $table->ats_ticket_id))
		{
			$jResponse = $app->triggerEvent('onValidate', array($state));
			if(is_array($jResponse) && !empty($jResponse))
			{
				foreach($jResponse as $pluginResponse)
				{
					if(!is_array($pluginResponse)) continue;
					if(!array_key_exists('valid', $pluginResponse)) continue;
					if(!array_key_exists('custom_validation', $pluginResponse)) continue;

					$response->custom_valid = $response->custom_valid && $pluginResponse['valid'];
					$response->custom_validation = array_merge($response->custom_validation, $pluginResponse['custom_validation']);
					if(array_key_exists('data', $pluginResponse))
					{
						$state = $pluginResponse['data'];
					}
				}
			}
		}

		return $response;
	}

	protected function onBeforeSave(&$data, &$table)
	{
		if(!$this->isValid($table))
		{
			$this->setError(JText::_('COM_ATS_ERR_NEWTICKET_CUSTOM_FIELDS'));
			return false;
		}

		return parent::onBeforeSave($data, $table);
	}

    protected function onAfterSave(&$table)
    {
        // Let's save user tags
        $tags = $this->input->get('usertags', array(), 'array', 2);

        $user = JUser::getInstance($table->created_by);

        $user->setParam('ats_tags', $tags);
        $user->save();

        return parent::onAfterSave($table);
    }

	/**
	 * Adds tickets to a bucket
	 *
	 * @param   array|int   $tickets  Ticket to add
	 * @param   int		    $bucket   Target bucket
	 *
	 * @return  bool		Is the task succesfull?
	 */
	public function addTicketsToBucket($tickets, $bucket)
	{
		$tickets = (array) $tickets;

		if(!$tickets || !$bucket)
		{
			return false;
		}

		// Let's clone the internal table, so we won't mess up the model
		$table  = clone $this->getTable();
		$result = true;

		foreach($tickets as $ticket)
		{
			$table->load($ticket);
			$table->ats_bucket_id = $bucket;

			$result = $table->store() && $result;
		}

		return $result;
	}

    /**
     * Given an array of intervals, returns ratings according to such time intervals
     *
     * @param    array   $intervals  It must be formatted in this way:
     *                                  key   = key for later use (ie week)
     *                                  value = value to be passed to strtotime function (ie 7 days)
     *
     * @return   array   Return ratings grouped by user and indexed by the keys provided in the $interval param
     */
    public function getRatings($intervals = array())
    {
        $db      = JFactory::getDbo();
        $ratings = array();

        // Base query: grab only assigned and closed tickets
        $basequery = $db->getQuery(true)
			->select(
				array(
					'AVG(' . $db->qn('rating') . ') AS '. $db->qn('average'),
					$db->qn('id'),
					$db->qn('name')
				)
			)
			->from('#__ats_tickets')
			->innerJoin('#__users ON ' . $db->qn('assigned_to') . ' = ' . $db->qn('id'))
			->where($db->qn('assigned_to') . ' <> ' . $db->q(''))
			->where($db->qn('status') . ' = ' . $db->quote('C'))
			->where($db->qn('rating') . ' > ' . $db->q('0'))
			->group($db->qn('assigned_to'));

		jimport('joomla.utilities.date');

        foreach($intervals as $key => $time)
        {
	        $query = clone $basequery;

            if($time)
            {
				$mDate = date('Y-m-d', strtotime('-'.$time));
				$jModified = new JDate($mDate);
                $query->where($db->qn('modified_on') . ' >= ' . $db->quote($jModified->toSql()));
            }

            $rows = $db->setQuery($query)->loadObjectList();

            foreach($rows as $row)
            {
                $ratings[$row->id]['user'] = $row->name;
                $ratings[$row->id][$key]   = $row->average;
            }
        }

        return $ratings;
    }

    public function getTotalsByCategory()
    {
        $db = JFactory::getDbo();

        $state = $this->getFilterValues();

        $query = $db->getQuery(true)
                    ->select('COUNT(ats_ticket_id) as total, catid')
                    ->from($db->qn('#__ats_tickets'))
                    ->group($db->qn('catid'))
                    ->order($db->qn('catid'));

        $since = $state->created_since;
        if(intval($since))
        {
            $since = new JDate($since);
            $query->where($db->qn('created_on').' >= '.$db->q($since->toSql()));
        }

        $until = $state->created_until;
        if(intval($until))
        {
            $until = new JDate($until);
            $query->where($db->qn('created_on').' <= '.$db->q($until->toSql()));
        }

        $count = $db->setQuery($query)->loadObjectList('catid');

        return $count;
    }
}