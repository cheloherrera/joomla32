<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

class plgAtsAlphauserpoints extends JPlugin
{
	public function onTicketsBeforeAdd($ticket, $category, $user)
	{
		$result = true;
		$this->loadLanguage();

		// Should I run?
		if(!$this->performChecks($ticket, $category, $user))
		{
			// There is no error, simply I don't have to run, so return true
			return true;
		}

		$result = $this->convertAUPinATScredits($ticket, $category, $user);

		return $result;
	}

	private function convertAUPinATScredits($ticket, $category, $user)
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$consumePoints = $this->params->get('consumePoints');
		$giveCredits   = $this->params->get('giveCredits');

		if(!$giveCredits || !$consumePoints)
		{
			$ticket->setError(JText::_('PLG_ATS_ALPHAUSERPOINTS_MISSING_PARAMS'));
			return false;
		}

		// User has not enough credits to post a public or private ticket, let's convert
		// points into credits.
		// P.A. I don't know which kind of ticket will be created, so I check vs both types
		if( !AtsHelperCredits::haveEnoughCredits($user->id, $category->id, true, true) ||
			!AtsHelperCredits::haveEnoughCredits($user->id, $category->id, true, false))
		{
			$AUP_points = AlphaUserPointsHelper::getCurrentTotalPoints('', $user->id);

			if($AUP_points)
			{
				$units 		= floor($AUP_points / $consumePoints);

				// Not enough points, do nothing
				if(!$units)
				{
					return true;
				}

				$newCredits 	= $giveCredits * $units;
				$subtractPoints = $units * $consumePoints * -1;

				// Create a new transaction
				$trans = F0FTable::getAnInstance('Credittransaction', 'AtsTable');
				$trans->ats_credittransaction_id = null;
				$trans->type 					 = 'alphauserpoints';
				$trans->user_id 				 = $user->id;
				$trans->value					 = $newCredits;
				$trans->enabled					 = 1;

				if(!$trans->check() || !$trans->store())
				{
					$ticket->setError(JText::_('PLG_ATS_ALPHAUSERPOINTS_ERR_SAV_CREDITS'));
					return false;
				}

				// Subtract to AUP user
				// P.A. at the moment AUP API are bugged, the won't return the state of the transaction! ;(
				AlphaUserPointsHelper::newpoints('plgaup_ats_convert_points', '', '', 'ATS point convertion', $subtractPoints);

				// Purge credit cache
				AtsHelperCredits::purgeCache($user->id);
			}
		}

		return true;
	}

	private function performChecks($ticket, $category, $user)
	{
		if(!defined('F0F_INCLUDED'))
		{
			require_once JPATH_LIBRARIES.'/f0f/include.php';
		}

		if(!file_exists(JPATH_ROOT.'/components/com_alphauserpoints/helper.php'))
		{
			// There is no AlphaUserPoint component, it's useless to continue
			return false;
		}

		require_once JPATH_ROOT.'/components/com_alphauserpoints/helper.php';

		// Fires only on new tickets
		if($ticket->ats_ticket_id)
		{
			return false;
		}

		return true;
	}
}
