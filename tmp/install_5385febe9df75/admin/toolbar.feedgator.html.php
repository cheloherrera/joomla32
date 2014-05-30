<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class TOOLBAR_feedgator
{
	public static function _EDIT()
	{
		$cid = JRequest::getVar('cid',array(),'get','array');
		$edit =  (int)@$cid[0];

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );
		JToolBarHelper::title( JText::_( 'Feed' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );

		if($edit) {
			$bar = JToolBar::getInstance('toolbar');
			$bar->appendButton( 'Link', 'preview', 'Preview', '#" onclick="javascript: importFunc(\'preview\')"', true, false);
		}
		$edit ? JToolBarHelper::apply() : JToolBarHelper::apply( 'apply', JText::_( 'Save and Add Another' ));
		JToolBarHelper::save();
		$edit ? JToolBarHelper::cancel( 'cancel', 'Close' ) : JToolBarHelper::cancel();
		JToolBarHelper::help( 'screen.content.edit' );
		self::_CPanel();
	}

	public static function _FEED_DEFAULT()
	{
		$text = JText::_( 'Edit Default Settings' );

		JToolBarHelper::title( JText::_( 'Default Feed Settings' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );
		JToolBarHelper::apply('applyDefault');
		JToolBarHelper::save('saveDefault');
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'screen.content.edit' );
		self::_CPanel();
	}

	public static function _SETTINGS()
	{
		JToolBarHelper::title( JText::_( 'FeedGator Global Settings' ), 'config.png' );
		JToolBarHelper::apply('applySettings');
		JToolBarHelper::save('saveSettings');
		JToolBarHelper::cancel();
		self::_CPanel();
	}

	public static function _PLUGINS()
	{
		JToolBarHelper::title( JText::_( 'FeedGator Plugins' ), ((J_VERSION < 1.6) ? 'config.png' : 'plugin') );
		self::_CPanel();
	}

	public static function _TOOLS()
	{
		JToolBarHelper::title( JText::_( 'FeedGator Tools' ), ((J_VERSION < 1.6) ? 'config.ong' : 'cpanel') );
		self::_CPanel();
	}

	public static function _IMPORTS()
	{
		global $filter_state;

		JToolBarHelper::title( JText::_( 'FeedGator Import History' ), ((J_VERSION < 1.6) ? 'config.png' : 'article') );
// The functions below cannot yet be supported for each content type and cause confusion for users
// The eventual aim will be to manipulate content from within FG

//		if ($filter_state == 'A' || $filter_state == NULL) {
//			JToolBarHelper::unarchiveList();
//		}
//		if ($filter_state != 'A') {
//			JToolBarHelper::archiveList();
//		}
//		JToolBarHelper::publishList();
//		JToolBarHelper::unpublishList();
//		JToolBarHelper::customX( 'movesect', 'move.png', 'move_f2.png', 'Move' );
//		JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
//		JToolBarHelper::trash();
//		JToolBarHelper::editListX();
//		JToolBarHelper::addNewX();

		self::_CPanel();
	}

	public static function _ABOUT()
	{
		JToolBarHelper::title( JText::_( 'About FeedGator' ), 'systeminfo.png' );
		self::_CPanel();
	}

	public static function _SUPPORT()
	{
		JToolBarHelper::title( JText::_( 'FeedGator Help and Support' ), 'help_header.png' );
		self::_CPanel();
	}

	public static function _FEEDS()
	{
		//fix for missing default style for refresh button
		$app = JFactory::getApplication();
		$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-32-refresh { background-image: url('.$templateDir.'/images/toolbar/icon-32-refresh.png); }');

		JToolBarHelper::title( JText::_( 'Manage RSS Feeds' ), ((J_VERSION < 1.6) ? 'addedit.png' : 'article') );

		// button hack

		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', 'preview', 'Preview', '#" onclick="javascript: importFunc(\'preview\')"', true, false);
		$bar->appendButton( 'Link', 'refresh', 'Import All', '#" onclick="javascript: importFunc(\'all\')"', false, false);
		$bar->appendButton( 'Link', 'upload', 'Import', '#" onclick="javascript: importFunc(\'feed\')"', true, false);
		$bar->appendButton( 'Separator' );
		$bar->appendButton( 'Separator' );
		//

		JToolBarHelper::publishList('publish', 'Enable');
		JToolBarHelper::unpublishList('unpublish', 'Disable');
		JToolBarHelper::addNew();
		JToolBarHelper::custom( 'copy', 'copy.png', 'copy_f2.png', 'Copy', false );
		JToolBarHelper::editList();
		$del_js = '#" onclick="if(document.adminForm.boxchecked.value==0){alert(\'Please first make a selection from the list\');}else if(confirm(\'Are you sure you want to delete this feed(s)?\')){ '. ((J_VERSION < 1.6) ? '' : 'Joomla.') .'submitbutton(\'remove\')}"';
		$bar->appendButton( 'Link', 'delete', 'Delete', $del_js);
	//	JToolBarHelper::deleteList();
		JToolBarHelper::custom( 'support', 'help.png', 'help_f2.png', 'Help', false );
		$bar->appendButton( 'Separator' );
		JToolBarHelper::custom( 'editdefault', 'edit.png', 'edit_f2.png', 'Edit Defaults', false );
		$bar->appendButton( 'Separator' );
		self::_CPanel();
	}

	public static function _DEFAULT()
	{
		JToolBarHelper::title( JText::_( 'FeedGator the RSS Feed Import Component' ), 'config.png' );
	}

	public static function _CPanel()
	{
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', ((J_VERSION < 1.6) ? 'config' : 'options'), 'Control Panel', 'index.php?option=com_feedgator&task=cpanel', true, false);
	}
}