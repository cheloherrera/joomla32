<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/select.php';

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
F0FTemplateUtils::addJS('media://com_ats/js/cannedreply-keyboard.js?'.ATS_VERSIONHASH);

// Load the bbCode helper
$this->loadHelper('bbcode');

?>

<div class="akeeba-bootstrap">

<form action="<?php echo JRoute::_('index.php?option=com_ats&view=cannedreplies') ?>" method="post" class="adminform" name="adminForm" id="adminForm">
<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<table class="table table-striped" id="ats-cannedreplies" tabindex="0" width="100%">
		<thead>
			<tr>
				<th width="60px">
					<?php echo JText::_('COM_ATS_COMMON_ID')?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'COM_ATS_CANNEDREPLIES_FIELD_TITLE', 'title', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="20">
					<?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if(count($this->items)): ?>
			<?php $m = 1; $i = 0; ?>
			<?php foreach($this->items as $item):?>
			<?php
				$i++;
				$m = 1 - $m;
			?>
			<tr class="ats-cannedreply-row row<?php echo $m?>" data-cannedreplyid="<?php echo $item->ats_cannedreply_id ?>" data-cannedreplysequence="<?php echo $i ?>">
				<td>
					<?php echo $item->ats_cannedreply_id ?>
				</td>
				<td>
					<a href="javascript:atsUseReply(<?php echo $item->ats_cannedreply_id ?>)">
						<?php echo $this->escape($item->title) ?>
					</a><br/>
					<a href="javascript:atsExpandReply(<?php echo $item->ats_cannedreply_id ?>)">[ + ]</a>
					<div id="atsreply<?php echo $item->ats_cannedreply_id ?>" class="ats-cannedreply-raw">
						<?php echo AtsHelperBbcode::parseBBCode($item->reply) ?>
					</div>
					<div id="atsrawreply<?php echo $item->ats_cannedreply_id ?>" class="ats-cannedreply-raw"><?php echo $item->reply ?></div>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="20">
					<?php echo JText::_('COM_ATS_COMMON_NORECORDS') ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</form>

<script type="text/javascript">
function atsExpandReply(id)
{
	(function($) {
		var divID = '#atsreply' + id;
		$(divID).toggle('fast');
	})(akeeba.jQuery)
}

function atsUseReply(id) {
	var divID = '#atsrawreply' + id;
	var HTMLdivID = '#atsreply' + id;
	var replyText = akeeba.jQuery(divID).html();
	var replyHTML = akeeba.jQuery(HTMLdivID).html();
	window.parent.useCannedReply(replyText, replyHTML);
}
</script>

</div>