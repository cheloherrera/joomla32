<?php
/**
* @version		1.0 RokComments
* @package		RokComments
* @copyright	Copyright (C) 2008 RocketTheme, LLC. All rights reserved.
* @license		GNU/GPL, see RT-LICENSE.php
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Editor Comments button
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonRokComments extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgButtonRokComments(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * @return array A two element array of ( imageName, textToInsert )
	 */
	function onDisplay($name)
	{
		$mainframe = JFactory::getApplication();;

		$doc 		= JFactory::getDocument();
		$template 	= $mainframe->getTemplate();

		// button is not active in specific content components

		$getContent = $this->_subject->getContent($name);
		$present = JText::_('There is already a RokComments tag in this article', true) ;
		$js = "
			function insertComments(editor) {
				var content = $getContent
				if (content.match(/{rokcomments}/i)) {
					alert('$present');
					return false;
				} else {
					jInsertEditorText(\"{rokcomments}\", editor);
				}
			}
			";

		$doc->addScriptDeclaration($js);

        $version = new JVersion();

        if (version_compare($version->getShortVersion(), '3.0', '>=')) {
            $style =" .btn .icon-linkrokcomments 	{ background: url(".JURI::root(true) . "/plugins/content/rokcomments/css/comment_icon_14.png) 100% 0 no-repeat; } ";

        } else {
            $style = " .button2-left .linkrokcomments { background: url(" . JURI::root(true) . "/plugins/content/rokcomments/css/rokcomments-button.png) 100% 0 no-repeat; } ";
        }
        $doc->addStyleDeclaration($style);

		$button = new JObject();
		$button->set('modal', false);
		$button->set('onclick', 'insertComments(\''.$name.'\');return false;');
		$button->set('text', JText::_('RokComments'));
		$button->set('name', 'linkrokcomments');
		// TODO: The button writer needs to take into account the javascript directive
		//$button->set('link', 'javascript:void(0)');
		$button->set('link', '#');

		return $button;
	}
}