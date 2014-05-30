<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

class AtsTableCustomfield extends F0FTable
{
	public function check()
	{
		$result = true;

		if(!$this->show)
		{
			$this->setError(JText::_('COM_ATS_CUSTOMFIELDS_ERR_SHOW'));
			$result = false;
		}

		if (empty($this->slug))
		{
			$this->setError(JText::_('COM_AKEEBASUBS_ERR_SLUG_EMPTY'));
			$result = false;
		}
		else
		{
			$pattern = '/^[a-z_][a-z0-9_\-]*$/';
			if (!preg_match($pattern, $this->slug))
			{
				$this->setError(JText::_('COM_AKEEBASUBS_ERR_SLUG_INVALID'));
				$result = false;
			}
		}

		return parent::check() && $result;
	}

	protected function onBeforeStore($updateNulls)
	{
		$result = parent::onBeforeStore($updateNulls);

		if($result)
		{
			$slug = $this->getColumnAlias('slug');
			if(property_exists($this, $slug))
			{
				$this->$slug = str_replace('-', '_', $this->$slug);
			}
		}

		return $result;
	}

	/**
	 * Loads categories attached to the custom fields
	 */
	protected function onAfterLoad(&$result)
	{
		$this->cats = array();

		// Load everything only if I need to show the field on selected categories
		if($this->show == 'category')
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true)
					->select('catid')
					->from('#__ats_customfields_cats')
					->where('ats_customfield_id = '.$this->ats_customfield_id);
			$this->cats = $db->setQuery($query)->loadColumn();
		}

		parent::onAfterLoad($result);
	}

	/**
	 * Deletes every references from the category-customfield table
	 */
	protected function onAfterDelete($oid)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
					->delete('#__ats_customfields_cats')
					->where('ats_customfield_id = '.$oid);
		// @TODO add error handling if the delete fails
		$db->setQuery($query)->query();

		return parent::onAfterDelete($oid);
	}
}