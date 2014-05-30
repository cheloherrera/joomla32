<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableAutoreply extends F0FTable
{
	public function check()
	{
		$result = true;

		if(!$this->title)
		{
			$this->setError(JText::_('COM_ATS_AUTOREPLIES_ERR_TITLE'));
			$result = false;
		}

		return parent::check() && $result;
	}

    protected function onBeforeStore($updateNulls)
    {
        $result = parent::onBeforeStore($updateNulls);

        if($result)
        {
            $cats   = $this->input->get('categories', array(), 'array');

	        // Ok, this is an ugly hack, but this is the situation: the "categories" input requests
	        // remains in the session, so if the user saves and then orders the rule list, it's still
	        // there but it's empty, wiping out the data of EVERY rule. Any ideas?
	        if(isset($cats[0]) && $cats[0] !== '')
	        {
		        $this->params = json_encode(array('categories' => $cats));
	        }
        }

        return $result;
    }

    /**
     * Converts the params JSON string into a formatted array
     */
    protected function onAfterLoad(&$result)
    {
        if($result && $this->params && $this->params != '{}')
        {
            $params = json_decode($this->params, true);
            $this->categories = $params['categories'];
        }

        parent::onAfterLoad($result);
    }
}