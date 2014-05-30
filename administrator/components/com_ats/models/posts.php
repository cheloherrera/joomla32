<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelPosts extends F0FModel
{
	private function getFilterValues()
	{
		return (object)array(
			'hasattachment'	=> $this->getState('hasattachment','','cmd'),
			'ticket'		=> $this->getState('ticket','','int'),
			'search'		=> $this->getState('search',null,'string'),
			'enabled'		=> $this->getState('enabled','','cmd'),
			'att_enabled'	=> $this->getState('att_enabled','','cmd'),
			'user_id'		=> $this->getState('user_id','','int'),
			'since'			=> $this->getState('since',null,'string'),
			'until'			=> $this->getState('until',null,'string'),

			'groupbydate'	=> $this->getState('groupbydate',null,'int'),
            'sumtimespent'  => $this->getState('sumtimespent'	, null, 'int'),
		);
	}

	/**
	 * Checks if the post is the first one
	 *
	 * @param   int   $post_id   Post id
	 *
	 * @return  bool
	 */
	public function isFirstOne($post_id = null)
	{
		$post = $this->getItem($post_id);

		$db = $this->getDbo();
		// Do I have a post previous of this one?
		$query = $db->getQuery(true)
					->select('COUNT(*)')
					->from('#__ats_posts')
					->where('ats_ticket_id = '.$post->ats_ticket_id)
					->where('ats_post_id < '.$post->ats_post_id);

		return !($db->setQuery($query)->loadResult());
	}

	public function buildCountQuery()
    {
		$db    = $this->getDbo();

		$query = $db->getQuery(true)
                    ->select('COUNT(*)')
                    ->from($db->qn('#__ats_posts').' AS '.$db->qn('tbl'));

		$this->_buildQueryJoins($query);
		$this->_buildQueryWhere($query);

		return $query;
	}

	public function buildQuery($overrideLimits = false)
    {
		$db    = $this->getDbo();

		$query = $db->getQuery(true)
				    ->from($db->qn('#__ats_posts').' AS '.$db->qn('tbl'));

		$this->_buildQueryColumns($query);
		$this->_buildQueryJoins($query);
		$this->_buildQueryWhere($query);
		$this->_buildQueryGroup($query);

		if(!$overrideLimits)
        {
			$order = $this->getState('filter_order',null,'cmd');

			if(!array_key_exists($order, array_keys($this->getTable()->getData())))
            {
                $order = $this->getTable()->getKeyName();
            }

			$dir = $this->getState('filter_order_Dir', 'ASC', 'cmd');
			$query->order($db->qn($order).' '.$dir);
		}

		return $query;
	}

	protected function onProcessList(&$resultArray)
	{
		if(!count($resultArray)) return;

		// Let's get the last post id
		$item = end($resultArray);

		if(property_exists($item, 'ats_post_id'))
		{
			$this->_last_ats_post_id = $item->ats_post_id;
		}

		reset($resultArray);

        // Let's load the attachments for every post
        $table = F0FModel::getTmpInstance('Attachments', 'AtsModel')->getTable();

        foreach($resultArray as $item)
        {
            $attachments = array();

            if(isset($item->ats_attachment_id))
            {
                $files = explode(',', $item->ats_attachment_id);

                foreach($files as $file)
                {
                    if(!$file)
                    {
                        continue;
                    }

                    $table->load($file);
                    $attachments[] = clone $table;
                }
            }

            $item->attachments = $attachments;
        }
	}

    protected function onAfterGetItem(&$record)
    {
        parent::onAfterGetItem($record);

        $attachments = array();
        $table       = F0FModel::getTmpInstance('Attachments', 'AtsModel')->getTable();

        if(isset($record->ats_attachment_id))
        {
            $files = explode(',', $record->ats_attachment_id);

            foreach($files as $file)
            {
                $table->load($file);
                $attachments[] = clone $table;
            }
        }

        $record->attachments = $attachments;
    }

	protected function onAfterSave(&$table)
	{
		$component  = JComponentHelper::getParams('com_ats');
		$extra_cred = $this->input->getInt('extracredits');

		if($extra_cred && $component->get('showcredits', 0))
		{
			require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';

			$ticket = F0FTable::getAnInstance('Ticket', 'AtsTable');
			$ticket->load($table->ats_ticket_id);

			// Probably that's an overkill, but let's check if the user has enough credits
			if(AtsHelperCredits::creditsLeft($ticket->created_by) >= $extra_cred)
			{
				// We're adding extra credits, the ticket is always created and we don't care about ticket priority
				AtsHelperCredits::chargeCredits($ticket->created_by, $ticket->catid, $ticket->ats_ticket_id, $table->ats_post_id, false, false, 0, $extra_cred);
			}
		}

        // User tagging
        $tags = $this->input->get('usertags', array(), 'array', 2);

        // I have to blank out the tags only if I'm in the frontend (on backend I'm saving the tags while I'm saving
        // the ticket, not when adding a post
        list(, $isAdmin) = F0FDispatcher::isCliAdmin();

        if(!$isAdmin)
        {
            $ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')->getItem($table->ats_ticket_id);
            $user = JUser::getInstance($ticket->created_by);

            $user->setParam('ats_tags', $tags);
            $user->save();
        }

		return parent::onAfterSave($table);
	}

	protected function _buildQueryColumns($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1)
        {
			$query->select(array(
				'DATE('.$db->qn('created_on').') AS '.$db->qn('date'),
				'COUNT('.$db->qn('ats_post_id').') AS '.$db->qn('posts')
			));
		}
        else
        {
			$query->select(array(
				$db->qn('tbl').'.'.'*',
				$db->qn('att').'.'.$db->qn('original_filename'),
				$db->qn('att').'.'.$db->qn('mangled_filename'),
				$db->qn('att').'.'.$db->qn('mime_type'),
				$db->qn('att').'.'.$db->qn('enabled').' AS '.$db->qn('att_enabled'),
			));

            if($state->sumtimespent)
            {
                $query->select(array(
                    'SUM('.$db->qn('timespent').' / 60) as tot_timespent',
                    $db->qn('users').'.'.$db->qn('name').' as poster_name'
                ));
            }
		}
	}

	protected function _buildQueryJoins($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) return;

		$query
			->join('LEFT OUTER', $db->qn('#__ats_attachments').' AS '.$db->qn('att').' USING('.
					$db->qn('ats_attachment_id').')');

        // Let's get the name of the poster
        if($state->sumtimespent)
        {
            $query->innerJoin($db->qn('#__users').' AS '.$db->qn('users').
                              ' ON '.$db->qn('tbl').'.'.$db->qn('created_by').' = '.$db->qn('users').'.'.$db->qn('id'));
        }
	}

	protected function _buildQueryGroup($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1)
        {
			$query->group(array(
				'DATE('.$db->qn('tbl').'.'.$db->qn('created_on').')'
			));
		}

        if($state->sumtimespent == 1)
        {
            $query->group($db->qn('tbl').'.'.$db->qn('created_by'));
        }
	}

	protected function _buildQueryWhere($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		JLoader::import('joomla.utilities.date');

		if(!$state->groupbydate)
        {
			// Filter by the existence of a (published) attachment
			if(is_numeric($state->hasattachment)) {
				if($state->hasattachment) {
					$query->where(
						'('.
							'('.$db->qn('tbl').'.'.$db->qn('ats_attachment_id').' > '.$db->q('0').
							' AND '.
							'('.$db->qn('att').'.'.$db->qn('enabled').' = '.$db->q('1').')'.
						')'
					);
				} else {
					$query->where(
						'('.
							'('.$db->qn('tbl').'.'.$db->qn('ats_attachment_id').' <= '.$db->q('0').
							' OR '.
							'('.$db->qn('att').'.'.$db->qn('enabled').' = '.$db->q('0').')'.
						')'
					);
				}
			}

			// Filter by ticket ID
			if($state->ticket > 0) {
				$query->where(
					$db->qn('tbl').'.'.$db->qn('ats_ticket_id').' = '.$db->q($state->ticket)
				);
			}

			// Search inside the rendered HTML contents
			if($state->search) {
				$query->where(
					'MATCH ('.$db->q('content_html').') AGAINST ('.$db->q($state->search).')'
				);
			}

			// Filter by enabled attachment status
			if(is_numeric($state->att_enabled)) {
				$query->where(
					$db->qn('att').'.'.$db->qn('enabled').' = '.
						$db->q($state->enabled)
				);
			}

            // Get replies with a stored time spent only. This will exclude managers that never posted a post with a
            // time spent value, but we can't work on users since we should run multiple queries to check if the user
            // is a manager for the current category or not.
            if($state->sumtimespent == 1)
            {
                $query->where($db->qn('tbl').'.'.$db->qn('timespent').' > 0');
            }
		}

		// "Since" queries
		$since = trim($state->since);
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

		// "Until" queries
		$until = trim($state->until);
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

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('enabled').' = '.
					$db->q($state->enabled)
			);
		}

		// Filter by user ID (who created the row)
		if($state->user_id > 0) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_by').' = '.
					$db->q($state->user_id)
			);
		} elseif(is_array($state->user_id)) {
			$ids = array();
			foreach($state->user_id as $id) if( (int)$id > 0 ) $ids[] = (int)$id;
			if(!emtpy($ids)) {
				$filter = implode(',',$ids);
				$query->where(
					$db->qn('tbl').'.'.$db->qn('created_by').' IN ('.$ids.')'
				);
			}
		}
	}
}