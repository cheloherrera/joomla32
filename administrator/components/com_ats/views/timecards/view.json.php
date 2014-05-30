<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewTimecards extends F0FViewJson
{
	protected function onBrowse($tpl = null)
	{
		$model = F0FModel::getAnInstance('Posts', 'AtsModel');
		$this->setModel($model, true);

		return parent::onBrowse($tpl);
	}
}
