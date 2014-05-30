<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class JFormFieldAtsmanagerlist extends JFormField
{
	public function getInput()
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$html  = '<div style="float:left;width:300px">';
		$catid = $this->form->getValue('id');

		$all[]    = JHTML::_('select.option', 'all', JText::_('COM_ATS_CATEGORY_ALL_MANAGERS'), 'id', 'name');
		$managers = AtsHelper::getManagers($catid);
		$options  = array_merge($all, $managers);

		if(!$catid && !isset($this->element['hidetip']))
		{
			$html .= '<div style="font-weight:bold">'.JText::_('COM_ATS_CATEGORY_NOTIFY_MANAGERS_SAVEBEFORE').'</div>';
		}

		$html .= JHTML::_('select.genericlist', $options, $this->name.'[]', 'class="inputbox" multiple="multiple" size="5"', 'id', 'name', $this->value, $this->id);
		$html .= '</div>';

		return $html;
	}
}