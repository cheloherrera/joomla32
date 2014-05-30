<?php
// Protect from unauthorized access
defined('_JEXEC') or die();

class F0FFormFieldAtsautoreplieskeywords extends F0FFormFieldText
{
    public function getRepeatable()
    {
        $html = array();

        if($this->item->keywords_title)
        {
            $html[] = '<em>'.JText::_('COM_ATS_AUTOREPLIES_KEYWORDS_TITLE').'</em>';
        }

        if($this->item->keywords_text)
        {
            $html[] = '<em>'.JText::_('COM_ATS_AUTOREPLIES_KEYWORDS_TEXT').'</em>';
        }

        return implode('<br/>', $html);
    }
}
