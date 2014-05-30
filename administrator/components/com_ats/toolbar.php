<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die;

class AtsToolbar extends F0FToolbar
{
	/**
	 * Used by the AtsHelper, which in turn is called by com_categories'
	 * controller to render the toolbar submenu. So, basically, this method
	 * simply exposes the protected renderSubmenu method.
	 *
	 * @param   string   $vName
	 *
	 * @return  void
	 */
	public function atsHelperRenderSubmenu($vName)
	{
		return $this->renderSubmenu($vName);
	}

	public function renderSubmenu($vName = null)
	{
		if(is_null($vName)) {
			$vName = $this->input->getCmd('view','cpanel');
		}

		$this->input->set('view', $vName);

		parent::renderSubmenu();

		$toolbar = F0FToolbar::getAnInstance($this->input->getCmd('option','com_foobar'), $this->config);
		$toolbar->appendLink(
			JText::_('COM_ATS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_ats',
			$vName == 'categories'
		);

		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('COM_ATS')),
				'ats-categories');
			$items = $toolbar->getLinks();
			foreach($items as $i) {
				JSubMenuHelper::addEntry($i['name'], $i['link'], $i['active']);
			}
		}
	}

	public function onTicketsBrowse()
	{
		//on frontend, buttons must be added specifically
		list($isCli, $isAdmin) = F0FDispatcher::isCliAdmin();

		if($isAdmin || $this->renderFrontendSubmenu) {
			$this->renderSubmenu();
		}

		if(!$isAdmin && !$this->renderFrontendButtons) return;

		// Set toolbar title
		$option = $this->input->getCmd('option','com_foobar');
		$subtitle_key = strtoupper($option.'_TITLE_'.$this->input->getCmd('view','cpanel'));
		JToolBarHelper::title(JText::_( strtoupper($option)).' &ndash; <small>'.JText::_($subtitle_key).'</small>', str_replace('com_', '', $option));

		// Add toolbar buttons
		if($this->perms->create) {
			if(version_compare(JVERSION, '3.0', 'ge')) {
				JToolBarHelper::addNew();
			} else {
				JToolBarHelper::addNewX();
			}
		}

		if($this->perms->edit) {
			if(version_compare(JVERSION, '3.0', 'ge')) {
				JToolBarHelper::editList();
			} else {
				JToolBarHelper::editListX();
			}
		}
		if($this->perms->create || $this->perms->edit) {
			JToolBarHelper::divider();
		}

		if($this->perms->editstate) {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::divider();
			JToolBarHelper::publishList('status_publish', JText::_('COM_ATS_TICKET_LBL_REOPEN'));
			JToolBarHelper::unpublishList('status_unpublish', JText::_('COM_ATS_TICKET_LBL_CLOSE'));
			JToolBarHelper::publishList('public_publish', JText::_('COM_ATS_TICKET_LBL_MAKEPUBLIC'));
			JToolBarHelper::unpublishList('public_unpublish', JText::_('COM_ATS_TICKET_LBL_MAKEPRIVATE'));
		}
		if($this->perms->delete) {
			$msg = JText::_($this->input->getCmd('option','com_foobar').'_CONFIRM_DELETE');
			JToolBarHelper::deleteList($msg);
		}

		// Add "Export to CSV"
		$bar = JToolBar::getInstance('toolbar');
		$link = JURI::getInstance();
		$query = $link->getQuery(true);
		$query['format'] = 'csv';
		$query['option'] = 'com_ats';
		$query['view']   = 'tickets';
		$query['task']   = 'browse';
		$link->setQuery($query);

		JToolBarHelper::divider();

		$options['text']    = JText::_('COM_ATS_ADD_TO_BUCKET');
		$options['a.href']  = 'index.php?option=com_ats&view=buckets&tmpl=component&task=choosebucket&layout=choose';

		$this->addCustomBtn('bucketadd', $options);

		JToolBarHelper::divider();
		$icon = version_compare(JVERSION, '3.0', 'lt') ? 'export' : 'download';
		$bar->appendButton('Link', $icon, JText::_('COM_ATS_COMMON_EXPORTCSV'), $link->toString());
	}

    public function onEmailtemplatesAdd()
    {
        // Quick hack to mark this record as new
        $this->_isNew = true;

        parent::onAdd();
    }

    public function onEmailtemplatesEdit()
    {
        if(!isset($this->_isNew))
        {
            $options['class']   = 'preview';
            $options['a.task']  = 'testtemplate';
            $options['a.href']  = '#';
            $options['text']    = JText::_('COM_ATS_EMAILTEMPLATES_TESTTEMPLATE');

            $this->addCustomBtn('test-template', $options);
            JToolBarHelper::divider();
        }
        parent::onEdit();
    }

	protected function addCustomBtn($id, $options = array())
	{
		$options = (array) $options;
		$a_class = 'toolbar';
		$href	 = '';
		$task	 = '';
		$text    = '';
		$rel	 = '';
		$target  = '';
		$other   = '';

		if(isset($options['a.class']))	$a_class .= $options['a.class'];
		if(isset($options['a.href']))	$href     = $options['a.href'];
		if(isset($options['a.task']))	$task     = $options['a.task'];
		if(isset($options['a.target']))	$target   = $options['a.target'];
		if(isset($options['a.other']))	$other    = $options['a.other'];
		if(isset($options['text']))		$text	  = $options['text'];
		if(isset($options['class']))
		{
			$class = $options['class'];
		}
		else
		{
			$class = 'default';
		}

		if(isset($options['modal']))
		{
			JHTML::_('behavior.modal');
			$a_class .= ' modal';
			$rel	  = "'handler':'iframe'";
			if(is_array($options['modal']))
			{
				if(isset($options['modal']['size']['x']) && isset($options['modal']['size']['y']))
				{
					$rel .= ", 'size' : {'x' : ".$options['modal']['size']['x'].", 'y' : ".$options['modal']['size']['y']."}";
				}
			}
		}

		$html = '<a id="'.$id.'" class="'.$a_class.'" alt="'.$text.'"';

		if($rel)	$html .= ' rel="{'.$rel.'}"';
		if($href)	$html .= ' href="'.$href.'"';
		if($task)	$html .= " onclick=\"javascript:submitbutton('".$task."')\"";
		if($target) $html .= ' target="'.$target.'"';
		if($other)  $html .= ' '.$other;
		$html .= ' >';

		$html .= '<span class="icon-32-'.$class.'" title="'.$text.'" > </span>';
		$html .= $text;
		$html .= '</a>';

		$bar = JToolBar::getInstance();
		$bar->appendButton('Custom', $html, $id);
	}
}