<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewTickets extends F0FViewJson
{
    protected function onShowspared($tpl)
    {
        if (is_null($tpl))
        {
            $tpl = 'json';
        }

        echo $this->loadTemplate($tpl, true);

        return false;
    }
}