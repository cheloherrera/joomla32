<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die;

class AtsControllerAttempts extends F0FController
{
    public function save()
    {
        $result = parent::save();

        if($result && $this->input->getCmd('format') == 'json')
        {
            $attempt = $this->getThisModel()->getSavedTable();

            echo json_encode($attempt->getData());

            JFactory::getApplication()->close();
        }

        return $result;
    }
}