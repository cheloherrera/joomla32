<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die();

class AtsHelperHtml
{
	/**
	 * Creates a dropdown list containing managers. If $baselink param is not passed, we assume
	 * we're using it in AJAX mode, ie no link is created
	 *
	 * @param   string   $baselink    Baselink used to create urls. If null, a dummy link is created (javascript:void(0))
	 * @param   array    $class       Array containing classes for the holding div (index 'div') and for the links (index 'a')
	 * @param   int      $category    Ticket category
	 *
	 * @return  string   Dropdown html code
	 */
	public static function buildManagerdd($baselink = null, $class = null, $category = null)
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$managers = AtsHelper::getManagers($category);

		$div	= isset($class['div']) ? $class['div'] : '';
		$a		= isset($class['a']) ? $class['a'] : '';

		$html  = '<div class="btn-group '.$div.'">';
		// I have to hardcode the fontsize, since in backend it's overrided by template css
		$html .= 	'<a class="btn '.$a.' dropdown-toggle" data-toggle="dropdown" href="#" style="font-size:11px">';
		//$html .= 		JText::_('COM_ATS_TICKETS_ASSIGN_TO').'&nbsp;';
		$html .= 		'<span class="caret"></span>';
		$html .= 	'</a>';
		$html .= 	'<ul class="dropdown-menu">';

		// Create options at the top of the managers list
		$fakeManagers = array();
		$myId = JFactory::getUser()->id;
		// -- Assign to me
		if (array_key_exists($myId, $managers))
		{
			$fakeManagers[] = (object)array('id' => $myId, 'name' => '<span class="label label-info"><span class="icon icon-flag"></span></span> ' . JText::_('COM_ATS_TICKET_ASSIGN_TOME'));
		}
		// -- Unassign
		$fakeManagers[] = (object)array('id' => 0, 'name' => '<span class="label label-important"><span class="icon icon-white icon-fire"></span></span> ' . JText::_('COM_ATS_TICKET_UNASSIGN'));

		$merged = array_merge($fakeManagers, $managers);

		foreach ($merged as $manager)
		{
			if (is_null($baselink))
			{
				$link  = '#';
				$class = $manager->id > 0 ? 'assignto' : 'unassign';
				$input = '<input type="hidden" class="' . $class . '" value="' . $manager->id . '" />';
			}
			else
			{
				if (!is_null($manager->id))
				{
					$link  = $baselink . $manager->id;
				}
				else
				{
					$link  = '#';
				}
				$input = '';
			}

			// I have to hardcode the fontsize, since in backend it's overrided by template css
			$html .= '<li><a href="' . $link . '">' . $manager->name . '</a>' . $input . '</li>';
		}

		$html .=	'</ul>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Decode ticket status, including custom ones defined by the user
	 *
	 * @param   string|int   $status       Status to decode
	 * @param   boolean      $create_span  Should I wrap the output in a span?
	 *
	 * @return  string       Decoded HTML
	 */
	public static function decodeStatus($status, $create_span = false)
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$standard = array('O', 'P', 'C');
		$custom   = AtsHelper::getCustomTicketStatuses();

		if(in_array($status, $standard))
		{
			$text  = JText::_('COM_ATS_TICKETS_STATUS_'.$status);
			$class = 'ats-ticket-status-'.$status;
		}
		elseif(isset($custom[$status]))
		{
			$text = $custom[$status];
			// Custom status are always considered "pending"
			$class = 'ats-ticket-status-P';
		}
		else
		{
			return '';
		}

		if($create_span)
		{
			return '<span class="'.$class.'">'.$text.'</span>';
		}
		else
		{
			return $text;
		}
	}

    /**
     * Creates a dropdown list of statuses, including the custom ones created by the user
     *
     * @param    array    $config
     *
     * @return   string   HTML to create a dropdown list
     */
	public static function createStatusDropdown($config = array())
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$custom = AtsHelper::getCustomTicketStatuses();

		if (!array_key_exists('title', $config))
		{
			$config['title'] = JText::_('COM_ATS_TICKETS_STATUS_SELECT');
		}

		if (!array_key_exists('btn_style', $config))
		{
			$config['btn_style'] = 'btn-inverse' ;
		}

		if (!array_key_exists('div_style', $config))
		{
			$config['div_style'] = '' ;
		}

		$html  = '<div class="btn-group select-status ' . $config['div_style'] . '">';
		$html .= 	'<a class="btn btn-mini dropdown-toggle ' . $config['btn_style'] . '" data-toggle="dropdown" href="#" style="font-size:11px">';
		$html .=		$config['title'];
		$html .=		'<span class="caret"></span>';
		$html .=	'</a>';
		$html .=	'<ul class="dropdown-menu">';
		// Standard statuses
		$html .=		'<li><a href="#" data-status="O"><span class="badge badge-important">O</span> '.JText::_('COM_ATS_TICKETS_STATUS_O').'</a></li>';
		$html .=		'<li><a href="#" data-status="P"><span class="badge badge-warning">P</span> '.JText::_('COM_ATS_TICKETS_STATUS_P').'</a></li>';

		foreach($custom as $value => $text)
		{
			$html .=	'<li><a href="#" data-status="'.$value.'">'.$text.'</a></li>';
		}

		$html .=		'<li><a href="#" data-status="C"><span class="badge badge-success">C</span> '.JText::_('COM_ATS_TICKETS_STATUS_C').'</a></li>';
		$html .=	'</ul>';
		$html .= '</div>';

		return $html;

	}
}