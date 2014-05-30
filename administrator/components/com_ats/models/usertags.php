<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelUsertags extends F0FModel
{
    /**
     * Returns an array containing the tags belonging to the select user
     *
     * @param   int     $userid     Userid
     *
     * @return  array   User tag ids
     */
    public function loadTagsByUser($userid)
    {
        $tags = array();

        if(!$userid)
        {
            return $tags;
        }

        // I can't use JFactory::getUser since data are store inside the session. So I won't see any updated info
        // until I logout

        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                    ->select($db->qn('params'))
                    ->from($db->qn('#__users'))
                    ->where($db->qn('id').' = '.$userid);

        $params = $db->setQuery($query)->loadResult();
        $params = json_decode($params, true);

        if(isset($params['ats_tags']))
        {
            $tags = $params['ats_tags'];
        }

        return $tags;
    }
}