<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

if(version_compare(JVERSION, '3.0', 'ge')){
	JHTML::_('behavior.framework');
}
else{
	JHTML::_('behavior.mootools');
}

AkeebaStrapper::addJSfile('media://com_ats/js/buckets_choose.js');

?>
<div>
<?php
	echo $this->loadAnyTemplate('site:com_ats/buckets/default', array(
				'assignTickets' => 1,
				'hideLinks'		=> 1
			));
?>
	<input type="hidden" id="ats_ticket_id" value="<?php echo $this->input->getInt('ats_ticket_id')?>" />
	<input type="hidden" id="chooseone" value="<?php echo JText::_('COM_ATS_BUCKETS_CHOOSE_ONE')?>" />
	<input type="hidden" id="chooseonlyone" value="<?php echo JText::_('COM_ATS_BUCKETS_CHOOSE_ONLY_ONE')?>" />
</div>