<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

	$response = array('labels' => array(), 'data' => array());
	$data     = array();

	foreach($this->items as $ticket)
	{
		$assigned = $ticket->poster_name ? $ticket->poster_name : JText::_('COM_ATS_TICKETS_UNASSIGNED');

		if(!in_array($assigned, $response['labels']))
		{
			$response['labels'][] = $assigned;
		}

		$data[] = (float)$ticket->tot_timespent;
	}

	$response['data'] = array($data);

	echo json_encode($response);