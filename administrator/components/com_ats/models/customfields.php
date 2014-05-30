<?php
/**
 *  @package Ats
 *  @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

class AtsModelCustomfields extends F0FModel
{
	var $preventCatCheck = false;

	protected function onAfterSave(&$table)
	{

		// In some situation (ie reordering) I don't want to perform these check on categories
		if($this->preventCatCheck)
		{
			return parent::onAfterSave($table);
		}

		$db	     = JFactory::getDbo();
		$app     = JFactory::getApplication();
		$cats    = array();
		$rawcats = $this->input->get('catid', array(), 'array');

		// Let's wipe out the customfield-category table
		// I always have to do that, otherwise I could have some problems when
		// a field changes from 'all' to 'category'
		$query = $db->getQuery(true)
					->delete('#__ats_customfields_cats')
					->where('ats_customfield_id = '.$table->ats_customfield_id);

		if(!$db->setQuery($query)->query())
		{
			$app->enqueueMessage(JText::_('COM_ATS_CUSTOMFIELDS_ERR_DELETE_CATS'), 'error');
			return false;
		}

		// Let's skip the first row that have no value
		foreach($rawcats as $raw)
		{
			if($raw)
			{
				$cats[] = $raw;
			}
		}

		if($cats && $table->show == 'category')
		{
			$query = $db->getQuery(true)
						->insert('#__ats_customfields_cats')
						->columns('ats_customfield_id, catid');

			foreach($cats as $cat)
			{
				if(!$cat) continue;

				$query->values($table->ats_customfield_id.', '.$cat);
			}

			if(!$db->setQuery($query)->query())
			{
				$app->enqueueMessage(JText::_('COM_ATS_CUSTOMFIELDS_ERR_INSERT_CATS'), 'error');
				return false;
			}

		}
		// I said that I want to show the field on specific categories, but I didn't say which ones...
		elseif(!$cats && $table->show == 'category')
		{
			$table->show = 'all';
			$table->store();
			$app->enqueueMessage(JText::_('COM_ATS_CUSTOMFIELDS_ERR_EMPTY_CATS'), 'error');
			return false;
		}

		return parent::onAfterSave($table);
	}
}