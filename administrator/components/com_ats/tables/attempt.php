<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableAttempt extends F0FTable
{
    protected function onBeforeStore($updateNulls)
    {
        $result = parent::onBeforeStore($updateNulls);

        $updateClicks = $this->input->getCmd('update_clicks');

        // I have to manually populate these fields, since I don't have the created_by or the modified_by ones
        if(!$this->created_on)
        {
            $date = new JDate();
            $this->created_on = $date->toSql();
        }

        if($this->ats_attempt_id && $updateClicks)
        {
            $this->load();

            $date = new JDate();
            $this->modified_on = $date->toSql();

            if($updateClicks == 'docimport')
            {
                $this->docimport_clicks += 1;
            }
            elseif($updateClicks == 'ats')
            {
                $this->ticket_clicks +=1;
            }
        }

        return $result;
    }
}