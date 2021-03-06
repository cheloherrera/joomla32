<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2014 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('joomla.application.component.modellist');
JLoader::import('components.com_dpcalendar.tables.event', JPATH_ADMINISTRATOR);

class DPCalendarModelEvents extends JModelList
{

	public function __construct ($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id',
					'a.id',
					'title',
					'a.title',
					'hits',
					'a.hits'
			);
		}

		parent::__construct($config);
	}

	public function getItems ()
	{
		$items = array();
		$categoryIds = $this->getState('category.id');
		if (! is_array($categoryIds))
		{
			$categoryIds = array(
					$categoryIds
			);
		}
		$options = new JRegistry();
		$search = $this->getState('filter.search');
		if (! empty($search))
		{
			$options->set('filter', $search);
		}
		if ($this->getState('list.limit') > 0)
		{
			$options->set('limit', $this->getState('list.limit'));
		}
		$options->set('order', $this->getState('list.direction', 'ASC'));

		// Add location filter
		$options->set('location', $this->getState('filter.location', null));
		$options->set('radius', $this->getState('filter.radius', 20));
		$options->set('length_type', $this->getState('filter.length_type', 'm'));

		$containsExternalEvents = false;

		if (in_array('root', $categoryIds))
		{
			JPluginHelper::importPlugin('dpcalendar');
			$tmp = JDispatcher::getInstance()->trigger('onCalendarsFetch');
			if (! empty($tmp))
			{
				foreach ($tmp as $tmpCalendars)
				{
					foreach ($tmpCalendars as $calendar)
					{
						$categoryIds[] = $calendar->id;
					}
				}
			}
		}
		foreach ($categoryIds as $catId)
		{
			if (is_numeric($catId) && $catId != 'root')
			{
				continue;
			}

			$startDate = null;
			if ($this->getState('list.start-date', null) !== null)
			{
				$startDate = DPCalendarHelper::getDate($this->getState('list.start-date'));
			}
			$endDate = null;
			if ($this->getState('list.end-date', null) !== null)
			{
				$endDate = DPCalendarHelper::getDate($this->getState('list.end-date'));
			}

			JPluginHelper::importPlugin('dpcalendar');
			$tmp = JDispatcher::getInstance()->trigger('onEventsFetch', array(
					$catId,
					$startDate,
					$endDate,
					$options
			));
			if (! empty($tmp))
			{
				$containsExternalEvents = true;
				foreach ($tmp as $events)
				{
					foreach ($events as $event)
					{
						$items[] = $event;
					}
				}
			}
		}
		if ($containsExternalEvents)
		{
			$items = array_merge(parent::getItems(), $items);
			usort($items, array(
					$this,
					"compareEvent"
			));
			if ($this->getState('list.limit') > 0)
			{
				$items = array_slice($items, 0, $this->getState('list.limit'));
			}
		}
		else
		{
			$items = parent::getItems();
			if ($items)
			{
				usort($items, array(
						$this,
						"compareEvent"
				));
			}
		}

		if (empty($items))
		{
			echo $this->getError();
			return array();
		}

		$location = $this->getState('filter.location');
		$radius = $this->getState('filter.radius', 20);
		$lengthType = $this->getState('filter.length_type', 'm');

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models', 'DPCalendarModel');
		$model = JModelLegacy::getInstance('Locations', 'DPCalendarModel', array(
				'ignore_request' => true
		));
		$model->getState();
		$model->setState('filter.location', $location);
		$model->setState('filter.radius', $radius);
		$model->setState('filter.length_type', $lengthType);

		$filteredItems = array();
		foreach ($items as $key => $item)
		{
			if (! isset($this->_params))
			{
				$params = new JRegistry();
				$params->loadString($item->params);
				$item->params = $params;
			}

			if (! empty($item->location_ids) && empty($item->locations))
			{
				$model->setState('filter.search', 'ids:' . $item->location_ids);
				$locations = $model->getItems();
				$item->locations = $locations;
			}
			else if (empty($item->locations))
			{
				// External events can have locations
				$item->locations = null;
			}

			if (! empty($location) && empty($item->locations))
			{
				continue;
			}

			if (empty($item->color))
			{
				$item->color = DPCalendarHelper::getCalendar($item->catid)->color;
			}

			// Implement View Level Access
			if (! JFactory::getUser()->authorise('core.admin') && ! in_array($item->access_content, JFactory::getUser()->getAuthorisedViewLevels()))
			{
				$item->title = JText::_('COM_DPCALENDAR_EVENT_BUSY');
				$item->location = '';
				$item->url = '';
				$item->description = '';
			}
			$filteredItems[] = $item;
		}

		return $filteredItems;
	}

	protected function getListQuery ()
	{
		$user = JFactory::getUser();
		$groups = implode(',', $user->getAuthorisedViewLevels());

		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select required fields from the categories.
		$query->select($this->getState('list.select', 'a.*'));
		$query->from($db->quoteName('#__dpcalendar_events') . ' AS a');
		$query->where('a.access IN (' . $groups . ')');

		// Don't show original events
		if ($this->getState('filter.expand'))
		{
			$query->where('a.original_id > -1');
		}
		else
		{
			$query->where(
					'(a.original_id in (-1, 0) or (a.original_id > 0 and a.modified > ' . $this->getDbo()
						->quote($this->getDbo()
						->getNullDate()) . '))');
		}

		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');

		if ($user->id > 0 && ! DPCalendarHelper::isFree())
		{
			// Join to ettendees to add a field if the logged in user is
			// attending
			$query->select('if(at.id is not null, at.id, ato.id) as attending');
			$query->join('LEFT', '#__dpcalendar_attendees AS at ON at.event_id = a.id and at.user_id = ' . (int) $user->id);
			$query->join('LEFT',
					'#__dpcalendar_attendees AS ato ON ato.event_id = a.original_id and a.original_id > 0 and ato.user_id = ' . (int) $user->id);
		}

		// Join locations
		$query->select("GROUP_CONCAT(v.id SEPARATOR ', ') location_ids");
		$query->join('LEFT', '#__dpcalendar_events_location AS rel ON a.id = rel.event_id');
		$query->join('LEFT', '#__dpcalendar_locations AS v ON rel.location_id = v.id');
		$query->group('a.id');

		// Filter by category.

		if ($categoryIds = $this->getState('category.id', 0))
		{
			if (! is_array($categoryIds))
			{
				$categoryIds = array(
						$categoryIds
				);
			}
			$cats = array();
			foreach ($categoryIds as $categoryId)
			{
				if ($categoryId)
				{
					$cats[$categoryId] = (int) $categoryId;
					if ($this->getState('category.recursive', false) && (is_numeric($categoryId) || $categoryId == 'root'))
					{
						$cal = DPCalendarHelper::getCalendar($categoryId);
						if ($cal != null)
						{
							foreach ($cal->getChildren(true) as $child)
							{
								$cats[$child->id] = (int) $child->id;
							}
						}
					}
				}
			}
			if (! empty($cats))
			{
				$query->where('a.catid IN (' . implode(',', $cats) . ')');
			}

			$query->where('c.access IN (' . $groups . ')');

			// Filter by published category
			$cpublished = $this->getState('filter.c.published');
			if (is_numeric($cpublished))
			{
				$query->where('c.published = ' . (int) $cpublished);
			}
		}
		// Join over the users for the author and modified_by names.
		$query->select("CASE WHEN a.created_by_alias > ' ' THEN a.created_by_alias ELSE ua.name END AS author");

		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		$query->join('LEFT', '#__users AS uam ON uam.id = a.modified_by');

		// Filter by state
		$state = $this->getState('filter.state');
		if (is_numeric($state))
		{
			$query->where('a.state = ' . (int) $state);
		}
		else if (is_array($state))
		{
			JArrayHelper::toInteger($state);
			$query->where('a.state in (' . implode(',', $state) . ')');
		}
		// Do not show trashed links on the front-end
		$query->where('a.state != -2');

		// Filter by start and end dates.
		$nullDate = $db->Quote($db->getNullDate());
		$date = JFactory::getDate();
		$nowDate = $db->Quote($date->toSql());

		if ($this->getState('filter.publish_date'))
		{
			$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
			$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		}

		$startDate = $db->Quote(DPCalendarHelper::getDate($this->getState('list.start-date'))->toSql());
		$dateCondition = 'a.start_date  >= ' . $startDate;
		if ($this->getState('list.end-date', null) !== null)
		{
			$endDate = $db->Quote(DPCalendarHelper::getDate($this->getState('list.end-date'))->toSql());
			$dateCondition = '(a.end_date between ' . $startDate . ' and ' . $endDate . ' or a.start_date between ' . $startDate . ' and ' . $endDate .
					 ' or (a.start_date < ' . $startDate . ' and a.end_date > ' . $endDate . '))';
		}

		if ($this->getState('filter.ongoing', 0) == 1)
		{
			$now = DPCalendarHelper::getDate();
			$dateCondition .= ' or ' . $db->quote($now->toSql()) . ' between a.start_date and a.end_date';
			$now->setTime(0, 0);
			$dateCondition .= ' or (a.start_date=' . $db->quote($now->toSql()) . ' and all_day=1)';
			$dateCondition .= ' or (a.end_date=' . $db->quote($now->toSql()) . ' and all_day=1)';
		}
		$query->where('(' . $dateCondition . ')');

		// Filter by language
		if ($this->getState('filter.language'))
		{
			$query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		}

		// Filter by title
		$search = $this->getState('filter.search');
		if (! empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape(JString::strtolower($search), true) . '%');
				$query->where(
                        '(LOWER(v.title) LIKE ' . $search . ' OR LOWER(CONCAT_WS(v.`country`,",",v.`province`,",",v.`city`,",",v.`zip`,",",v.`street`)) LIKE ' . $search . ' OR LOWER(a.title) LIKE ' . $search . ' OR LOWER(a.alias) LIKE ' . $search . ' OR LOWER(a.description) LIKE ' . $search .
                                 ' OR LOWER(a.metakey) LIKE ' . $search . ' OR LOWER(a.metadesc) LIKE ' . $search . ')');
			}
		}

		$location = $this->getState('filter.location');
		if (! empty($location))
		{
			$query->where('v.id is not null');
		}

		if ($this->getState('filter.my', '0') == '1')
		{
			$query->where('a.created_by = ' . $user->id);
			$query->where('at.id is not null');
		}
		if ($this->getState('filter.children', 0) > 0)
		{
			$query->where('a.original_id = ' . (int) $this->getState('filter.children', 0));
		}
		$search = $this->getState('filter.search_start');
		if (! empty($search))
		{
			$search = $db->Quote($db->escape($search, true));
			$query->where('a.start_date >= ' . $search);
		}
		$search = $this->getState('filter.search_end');
		if (! empty($search))
		{
			$search = $db->Quote($db->escape($search, true));
			$query->where('a.end_date <= ' . $search);
		}

		// Add the list ordering clause.
		$query->order($db->escape($this->getState('list.ordering', 'a.start_date')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));

		// Echo str_replace('#__', 'a_', $query); die();
		return $query;
	}

	protected function _getList ($query, $limitstart = 0, $limit = 0)
	{
		$this->_db->setQuery($query, $limitstart, $limit);
		$result = $this->_db->loadObjectList(null, 'DPCalendarTableEvent');
		return $result;
	}

	protected function populateState ($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_dpcalendar');

		// List state information
		if (JRequest::getInt('limit', null) === null)
		{
			$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
			$this->setState('list.limit', $limit);
		}
		else
		{
			$this->setState('list.limit', JRequest::getInt('limit', 0));
		}

		$this->setState('list.start-date', JRequest::getInt('date-start', DPCalendarHelper::getDate()->format('U')));
		if (JRequest::getInt('date-end', null) !== null)
		{
			$this->setState('list.end-date', JRequest::getInt('date-end', 0));
		}

		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$this->setState('list.start', $limitstart);

		$orderCol = JRequest::getCmd('filter_order', 'start_date');
		if (! in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'start_date';
		}
		$this->setState('list.ordering', $orderCol);

		$listOrder = JRequest::getCmd('filter_order_dir', 'ASC');
		if (! in_array(strtoupper($listOrder), array(
				'ASC',
				'DESC',
				''
		)))
		{
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);

		$id = JRequest::getVar('ids', null);
		if (! is_array($id))
		{
			$id = explode(',', $id);
		}
		if (empty($id))
		{
			$id = JFactory::getApplication()->getParams()->get('ids');
		}
		$this->setState('category.id', $id);
		$this->setState('category.recursive', JRequest::getVar('layout') == 'module');

		$user = JFactory::getUser();
		if ((! $user->authorise('core.edit.state', 'com_dpcalendar')) && (! $user->authorise('core.edit', 'com_dpcalendar')))
		{
			// Limit to published for people who can't edit or edit.state.
			$this->setState('filter.state', 1);

			// Filter by start and end dates.
			$this->setState('filter.publish_date', true);
		}

		$this->setState('filter.language', $app->getLanguageFilter());
		$this->setState('filter.search', JRequest::getVar('filter-search'));
		$this->setState('filter.my', JRequest::getVar('my', $params->get('show_my_only_list', '0')) == '1');

		// Filter for
		$this->setState('filter.expand', true);

		// Load the parameters.
		$this->setState('params', $params);
	}

	public function compareEvent ($event1, $event2)
	{
		return strcmp($event1->start_date, $event2->start_date);
	}
}
