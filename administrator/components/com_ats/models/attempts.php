<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelAttempts extends F0FModel
{
    public function getTotalsByCategory()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select('COUNT(ats_attempt_id) as total, ats_category_id')
            ->from($db->qn('#__ats_attempts'))
            ->where($db->qn('ats_ticket_id').' = 0')
            ->group($db->qn('ats_category_id'))
            ->order($db->qn('ats_category_id'));

        $since = $this->getState('created_since');
        if(intval($since))
        {
            $since = new JDate($since);
            $query->where($db->qn('created_on').' >= '.$db->q($since->toSql()));
        }

        $until = $this->getState('created_until');
        if(intval($until))
        {
            $until = new JDate($until);
            $query->where($db->qn('created_on').' <= '.$db->q($until->toSql()));
        }

        $count = $db->setQuery($query)->loadObjectList('ats_category_id');

        return $count;
    }
}