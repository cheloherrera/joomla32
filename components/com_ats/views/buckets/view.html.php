<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

class AtsViewBuckets extends F0FViewHtml
{
	protected function onChoosebucket()
	{
		// This is a choose view and I need to narrow down the list
		// I have to use a Tmp Instance of the model, so I won't mess up data of "standard view"
		// The only downside is that I have to manually pass every filter value :(
		$model = F0FModel::getTmpInstance('Buckets', 'AtsModel');
		$model->status('O')
			  ->enabled(1)
			  ->username($this->input->getString('username', ''))
			  ->search($this->input->getString('search'))
			  ->limit($this->input->getInt('limit'))
			  ->limitstart($this->input->getInt('limitstart', 0))
			  ->filter_order($this->input->getCmd('filter_order', 'id'))
			  ->filter_order_Dir($this->input->getCmd('filter_order_Dir', 'DESC'));

		$this->lists->set('order', 	   $model->getState('filter_order', 'id', 'cmd'));
		$this->lists->set('order_Dir', $model->getState('filter_order_Dir', 'DESC', 'cmd'));

		// Assign data to the view
		$this->assign('items', 		$model->getItemList());
		$this->assign('pagination', $model->getPagination());
		$this->assignRef('lists',	$this->lists);

		// @TODO We should rename pageparams to params to be consistent with F0F logic
		$params = JFactory::getApplication()->getParams();
		$this->assignRef('pageparams', $params);

		return true;
	}
}