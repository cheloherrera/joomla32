<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewTicket extends F0FViewHtml
{
	public function onAdd($tpl = null)
	{
		$result = parent::onAdd($tpl);

		if ($result)
		{
			$this->akeebasubs = false;
			$this->showuserinfo = false;
		}

		return $result;
	}

	public function onEdit($tpl = null)
	{
		$result = parent::onEdit($tpl);

		if ($result)
		{
			$this->showuserinfo = true;

			// Do we have Akeeba Subscriptions?
			JLoader::import('joomla.filesystem.folder');
			$hasAkeebasubs = JFolder::exists(JPATH_ADMINISTRATOR.'/components/com_akeebasubs');

			$this->assign('akeebasubs', $hasAkeebasubs);
			if($hasAkeebasubs)
			{
				if(!defined('AKEEBASUBS_VERSION'))
				{
					include_once JPATH_ADMINISTRATOR.'/components/com_akeebasubs/version.php';
				}

				$subs = F0FModel::getTmpInstance('Subscriptions', 'AkeebasubsModel')
							->limit(0)
							->limitstart(0)
							->savestate(0)
							->paystate('C')
							->user_id($this->getModel()->getItem()->created_by)
							->getList();

				$subscriptions_active = array();
				$subscriptions_inactive = array();
				if(!empty($subs)) foreach($subs as $sid => $sub)
				{
					$name = $sub->title;
					if($sub->enabled)
					{
						if(!in_array($name, $subscriptions_active)) $subscriptions_active[] = $name;
					}
					else
					{
						if(!in_array($name, $subscriptions_inactive)) $subscriptions_inactive[] = $name;
					}
				}

				$this->assign('activesubs', $subscriptions_active);
				$this->assign('inactivesubs', $subscriptions_inactive);
			}
		}

		return $result;
	}
}