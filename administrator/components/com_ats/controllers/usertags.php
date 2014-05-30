<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerUsertags extends F0FController
{
    public function getbyuser()
    {
        $userid = $this->input->getInt('user', 0);

        $model = $this->getThisModel();
        $tags  = $model->loadTagsByUser($userid);

        echo json_encode($tags);

        JFactory::getApplication()->close();
    }
}
