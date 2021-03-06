<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.2
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class FeedgatorViewPlugin extends JView
{
	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$user = JFactory::getUser();
		$model = FGFactory::getPluginModel();

		JHTML::_('behavior.tooltip');

		$doc->addStyleSheet('components/com_feedgator/css/styles.css');

		if($tpl == 'settings') {
			$ext = JRequest::getCmd('ext');
			if(!$plugin = $model->getPlugin($ext)) {
				jexit($ext.' is not valid');
			}
			//need to check component installed!
			if(!$plugin->componentCheck()) {
				$msg = JText::_('Unable to view plugin options - component not installed!');
				$app->redirect('index.php?option=com_feedgator&task=plugins', $msg);
			}
			$plugin->getParams();
			$this->plugin = $plugin;
		} else {
			$plugins = $model->loadInstalledPlugins();
			$this->plugins = $plugins;
		}

		parent::display($tpl);
	}
}