<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class JFormFieldAtscats extends JFormField
{
	public function getInput()
	{
		$options	= array();
		$options[]	= JHTML::_('select.option','0',JText::_( 'COM_ATS_CONFIG_DEFAULTCAT_MSG' ));

		if(!class_exists('CategoriesModelCategories')) {
			require_once JPATH_ADMINISTRATOR.'/components/com_categories/models/categories.php';
		}
		$model = new CategoriesModelCategories();
		$model->getState()->set('list.select', 'a.id, a.title, a.level');
		$model->getState()->set('filter.extension',	'com_ats');
		$model->getState()->set('filter.access',		null);
		$model->getState()->set('filter.published',	1);
		$items = $model->getItems();
		
		if(count($items)) foreach($items as $item) {
			$id = $item->id;
			$title = $item->title;
			if($item->level > 1) {
				$title = str_repeat('–', $item->level - 1).' '.$title;
			}
			$options[] = JHTML::_('select.option', $id, $title);
		}
		
		return JHTML::_('select.genericlist', $options, $this->name.'[]', 'class="inputbox"', 'value', 'text', $this->value, $this->id);
	}
}