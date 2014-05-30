<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

$tickets = $this->input->get('ats_ticket_id', array(), 'array');

// Server-side check to ensure that I have some tickets to add to a bucket
if(!$tickets)
{
	JFactory::getApplication()->enqueueMessage(JText::_('COM_ATS_BUCKETS_NO_TICKET_SELECTED'), 'notice');
	return;
}

if(version_compare(JVERSION, '3.0', 'ge')) {
	JHTML::_('behavior.framework');
} else {
	JHTML::_('behavior.mootools');
}

AkeebaStrapper::addJSfile('media://com_ats/js/adm_buckets_choose.js');
?>
<div>
	<div style="margin-bottom:10px;text-align:right">
		<button id="addTickets" class="btn"><?php echo JText::_('COM_ATS_BUCKETS_ADD_TICKETS')?></button>
	</div>
<?php

// Sometimes happens to have duplicates inside the ticket array, let's remove them!
$tickets      = array_unique($tickets);
$otherFields  = '<input type="hidden" name="layout" value="choose" />';
$otherFields .= '<input type="hidden" name="tmpl" value="component" />';

foreach ($tickets as $ticket)
{
	$otherFields .= '<input type="hidden" name="ats_ticket_id[]" value="'.$ticket.'" />';
}

// Load the deafult template, but hide publish and state columns (we want to display open buckets only)
echo $this->loadAnyTemplate('admin:com_ats/buckets/default',
			array('hideStatus'  => 1,
				  'hidePublish' => 1,
				  'otherFields' => $otherFields)
		);
?>
	<input type="hidden" id="chooseone" value="<?php echo JText::_('COM_ATS_BUCKETS_CHOOSE_ONE')?>" />
	<input type="hidden" id="chooseonlyone" value="<?php echo JText::_('COM_ATS_BUCKETS_CHOOSE_ONLY_ONE')?>" />
</div>