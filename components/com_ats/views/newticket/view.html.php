<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewNewticket extends F0FViewHtml
{
	function onAdd($tpl = null)
	{
		parent::onAdd($tpl);

		$ats_params = JComponentHelper::getParams('com_ats');
		$this->loadHelper('credits');

		// Is the "No new tickets" killswitch activated?
		if($ats_params->get('nonewtickets', 0))
		{
			echo $this->loadAnyTemplate('site:com_ats/newticket/nonewtickets');
			return false;
		}

		// Fire onTicketsAdd event, maybe I have anything that changes the
		// user credit balance (ie AlphaUserPoint)?
		JPluginHelper::importPlugin('ats');
		$dispatcher = JDispatcher::getInstance();
		$result 	= $dispatcher->trigger('onTicketsBeforeAdd', array(&$this->item, $this->category, JFactory::getUser()));
		if (in_array(false, $result, true))
		{
			// Plugin failed, return false
			echo $this->item->getError();
			return false;
		}

		$user = JFactory::getUser();
		$this->isManager = $user->authorise('core.manage','com_ats');

		// @TODO change this variable name, let's call it "enable_credits"
		$this->show_credits    		  = $ats_params->get('showcredits', 0);
		$this->enough_credits_public  = true;
		$this->enough_credits_private = true;

		// Perform checks only if requested to
		if($this->show_credits)
		{
            $this->category->objParams = F0FModel::getTmpInstance('Categories', 'AtsModel')->getCatParams($this->category->id);
            $forcetype  = $this->category->objParams->get('forcetype');

			// First of all, let's check if the user can post anything with the lower credit cost
			// (ie public ticket with low priority)
            if($ats_params->get('ticketPriorities'))
            {
                $this->enough_credits_public  = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $this->category->id, true, true, false);
                $this->enough_credits_private = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $this->category->id, true, false, false);
            }
            else
            {
                $this->enough_credits_public  = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $this->category->id, true, true, 5);
                $this->enough_credits_private = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $this->category->id, true, false, 1);
            }

			// Let's get credit cost on "default" values
			$this->credits_public  = AtsHelperCredits::creditsRequired($this->category->id, true, true,  5);
			$this->credits_private = AtsHelperCredits::creditsRequired($this->category->id, true, false, 1);

			// If the user can't do anything, neither post on low priority, let's stop here
			// Those tests are run vs default visibility, not the one coming from the session. However, if the user could select it, it means
			// that can use it (checks are performed before saving, too)
			if(
				(!$this->enough_credits_public && !$this->enough_credits_private) ||                         // Not enough credits for anything
				(!$this->enough_credits_public && $this->enough_credits_private && !$this->allow_private) || // Not enough credits for public posting
                ($forcetype == 'PRIV' && !$this->enough_credits_private)                                  || // Forced private but not enough credits
                ($forcetype == 'PUB'  && !$this->enough_credits_public)                                      // Forced public but not enough credits
			) {
				echo $this->loadAnyTemplate('site:com_ats/newticket/notenoughcredits');
				return false;
			}
		}

		return true;
	}
}