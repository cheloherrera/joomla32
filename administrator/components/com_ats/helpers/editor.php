<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

class AtsHelperEditor
{
	public static function showEditor($name, $id = null, $contents, $width, $height, $cols, $rows, $params = array())
	{
		if(self::isEditorBBcode()) {
			self::showEditorBBcode($name, $id, $contents, $width, $height, $cols, $rows, $params);
		} else {
			self::showEditorJoomla($name, $id, $contents, $width, $height, $cols, $rows, $params);
		}
	}

	public static function isEditorBBcode()
	{
		static $ret = null;
		if(is_null($ret)) {
			$cparams = self::_getComponentParams();
			$editor = $cparams->get('editor', 'bbcode');
			$ret = ($editor == 'bbcode');

			// When we detect a mobile device User Agent string we force the use of the BBcode editor
			$default = '; Android,iPad;,iPhone;,; Windows Phone OS,Windows Phone,; Windows CE,BlackBerry;,; Blazer,; BOLT/,/SymbianOS,(Symbian),Fennec/,GoBrowser/,Iris/,Maemo Browser,MIB/,Minimo/,NetFront/,Opera Mobi/,Opera Mini/,SEMC-Browser/,Skyfire/,TeaShark/,Teleca Q,uZardWeb/';
			$rawUAs = $cparams->get('bbcodeuas', $default);
			if (!empty($rawUAs)) {
				$forcedUAs = explode(',', $rawUAs);
				$ua = $_SERVER['HTTP_USER_AGENT'];
				foreach ($forcedUAs as $fua)
				{
					if (strpos($ua, $fua) !== false)
					{
						$ret = true;
						break;
					}
				}
			}
		}
		return $ret;
	}

	public static function showEditorBBcode($name, $id = null, $contents, $width, $height, $cols, $rows, $params = array(), $returnHTML = false)
	{
		static $injectedFiles = false;

		if (!$injectedFiles)
		{
			// Load the required Javascript
			AkeebaStrapper::addJSfile('media://com_ats/js/jquery.markitup.js?'.ATS_VERSIONHASH);
			AkeebaStrapper::addJSfile('media://com_ats/js/bbcode-set.js?'.ATS_VERSIONHASH);
            AkeebaStrapper::addJSfile('media://com_ats/js/preview.js?'.ATS_VERSIONHASH);

			// Load the required CSS
			F0FTemplateUtils::addCSS('media://com_ats/css/markitup/skin/style.css?'.ATS_VERSIONHASH);
			F0FTemplateUtils::addCSS('media://com_ats/css/markitup/bbcode/style.css?'.ATS_VERSIONHASH);

			$injectedFiles = true;
		}

		if(is_null($id) || empty($id)) {
			$id = $name;
		}

		$extras 	   = '';
		$cannedReplies = false;
		$bucket 	   = false;
		if(is_array($params) && !empty($params))
		{
			foreach($params as $k => $v)
			{
				if($k == 'cannedreplies')
				{
					if($v) $cannedReplies = true;
				}
				elseif($k == 'buckets' && $v)
				{
					$bucket = true;
				}
				else
				{
					$extras .= $k.'="'.$v.'"';
				}
			}
		}

        $throbber = F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');
		$html  = '<textarea id="'.$id.'" '.$extras.'rows="'.$rows.'" cols="'.$cols.'" name="'.$name.'">'.$contents.'</textarea>';

        // Setup a preview area
        $html .= '<div id="atsPreviewArea">';
        $html .=    '<div id="atsPreviewLoading" style="display:none;text-align:center"><img src="'.$throbber.'" /></div>';
        $html .=    '<div id="atsPreviewHolder" class="well well-small" style="display: none">';
        $html .=        '<h3>'.JText::_('COM_ATS_POSTS_PREVIEW').'</h3>';
        $html .=        '<div id="atsPreviewHtml"></div>';
        $html .=    '</div>';
        $html .= '</div>';

		JFactory::getDocument()->addScriptDeclaration( <<<JS

akeeba.jQuery(document).ready(function()	{
	akeeba.jQuery('#$id').markItUp(myBBCodeSettings);
});

JS
		);

		if($cannedReplies && ATS_PRO) {
			AkeebaStrapper::addJSfile('media://com_ats/js/cannedreply.js?'.ATS_VERSIONHASH);
			$siterootURL = JURI::base().'index.php';
			JFactory::getDocument()->addScriptDeclaration( <<<JS
var ats_siteroot_url = '$siterootURL';

function useCannedReply(newText, htmlContent)
{
	var allText = akeeba.jQuery('#bbcode').val();
	allText += newText;
	akeeba.jQuery('#bbcode').val(allText);

	try {
		document.getElementById('sbox-window').close();
	} catch(err) {
		SqueezeBox.close();
	}
}

JS
			);
			$url = 'index.php?option=com_ats&amp;view=cannedreplies&amp;enabled=1&amp;tmpl=component';
			if (isset($params['category']))
			{
				$url .= '&amp;category=' . $params['category'];
			}
			$html .= '<a class="modal" style="display: none" id="atsCannedReplyDialog" href="' . $url . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Select</a>';

		}

		if($bucket && ATS_PRO)
		{
			AkeebaStrapper::addJSfile('media://com_ats/js/editor_buckets.js?'.ATS_VERSIONHASH);
			$url = JRoute::_('index.php?option=com_ats&view=buckets&task=choosebucket&layout=choose&tmpl=component');

			// Warning, we ALWAYS need the ticket
			if(isset($params['ats_ticket_id']))
			{
				$url .= '&ats_ticket_id='.$params['ats_ticket_id'];
			}

			$html .= '<a class="modal" style="display: none" id="atsBucketsDialog" href="' . $url . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Select</a>';
		}

        $html .= '<a class="" style="display: none" id="atsPreview">Select</a>';

        // Preview button

		if($returnHTML)
		{
			return $html;
		}
		else
		{
			echo $html;
		}
	}

	public static function showEditorJoomla($name, $id = null, $contents, $width, $height, $cols, $rows, $params = array())
	{
		$editor  	   = JFactory::getEditor();
		$buttons 	   = false;
		$asset   	   = null;
		$author  	   = null;
		$other_buttons = '';

		if(array_key_exists('buttons', $params)) {
			$buttons = $params['buttons'];
			unset($params['buttons']);
		}
		if(array_key_exists('asset', $params)) {
			$asset = $params['asset'];
			unset($params['asset']);
		}
		if(array_key_exists('author', $params)) {
			$author = $params['author'];
			unset($params['author']);
		}

		$cannedReplies = false;
		if(array_key_exists('cannedreplies', $params)) {
			$cannedReplies = $params['cannedreplies'];
			unset($params['cannedreplies']);
		}

		$buckets = false;
		if(array_key_exists('buckets', $params)) {
			$buckets = $params['buckets'];
			unset($params['buckets']);
			if(array_key_exists('ats_ticket_id', $params)) {
				$ticket_id = $params['ats_ticket_id'];
				unset($params['ats_ticket_id']);

			}
		}


		$html =  $editor->display( $name,  $contents, $width, $height, $cols, $rows, $buttons, $id, $asset, $author, $params );

		$html .= '<div>';
		if($cannedReplies && ATS_PRO) {
			$siterootURL = JURI::base().'index.php';
			JFactory::getDocument()->addScriptDeclaration( <<<JS
var ats_siteroot_url = '$siterootURL';

function useCannedReply(newText, htmlContent)
{
	jInsertEditorText(htmlContent, 'ats-content');

	try {
		document.getElementById('sbox-window').close();
	} catch(err) {
		SqueezeBox.close();
	}
}

JS
			);
			$url = 'index.php?option=com_ats&amp;view=cannedreplies&amp;enabled=1&amp;tmpl=component';
			if (isset($params['category']))
			{
				$url .= '&amp;category=' . $params['category'];
			}
			$other_buttons .= '<span class="pull-left ats-canned-reply-button"><a class="modal btn btn-small" id="atsCannedReplyDialog" href="' . $url . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">'.
					'<i class="icon-book"></i> '.
					JText::_('COM_ATS_POST_INSERTCANNEDREPLY_LBL').
					'</a></span>';

		}

		if($buckets && ATS_PRO)
		{
			$url = JRoute::_('index.php?option=com_ats&view=buckets&task=choosebucket&layout=choose&tmpl=component');

			// Warning, we ALWAYS need the ticket
			if(isset($ticket_id))
			{
				$url .= '&ats_ticket_id='.$ticket_id;
			}

			$other_buttons .= '<span class="pull-left ats-canned-reply-button"><a class="modal btn btn-small" id="atsBucketsDialog" href="' . $url . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">'.
					'<i class="icon-bookmark"></i> '.
					JText::_('COM_ATS_ADD_TO_BUCKET').
					'</a></span>';
		}

		$html .= $other_buttons.'</div>';

		echo $html;
	}

	private static function &_getComponentParams()
	{
		static $component_params = null;

		if(!is_object($component_params))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
				->select('params')
				->from($db->qn('#__extensions'))
				->where($db->qn('element').'='.$db->q('com_ats'))
				->where($db->qn('type').'='.$db->q('component'));
			$db->setQuery($query);
			$rawparams = $db->loadResult();
			$component_params = new JRegistry();
			$component_params->loadString($rawparams, 'JSON');
		}

		return $component_params;
	}
}