<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

$this->loadHelper('select');
$this->loadHelper('format');
$this->loadHelper('modules');

$user		= JFactory::getUser();
$ownerUser = JFactory::getUser($this->item->created_by);

$returnURL = base64_encode(JURI::getInstance()->toString());
$adminActionsURL = 'index.php?option=com_ats&view=bucket&id='.$this->item->ats_bucket_id.'&returnurl='.$returnURL.'&Itemid='.$this->input->getInt('Itemid',0).'&'.JFactory::getSession()->getFormToken().'=1';

$isManager = $user->authorise('core.manage','com_ats') || $user->authorise('core.manage','com_ats.category.' . $this->category->id);

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);

$tickets = F0FModel::getTmpInstance('Tickets','AtsModel')
	->bucket($this->item->ats_bucket_id)
	->getList();

$this->loadHelper('credits');
?>
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-posts-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1 class="ats-bucket-view-title">
		#<?php echo $this->escape($this->item->ats_bucket_id); ?> &ndash;
		<?php echo $this->escape($this->item->title); ?>
	</h1>
<?php endif; ?>

<?php if($this->perms['admin'] || $this->perms['close']): ?>
<div class="btn-toolbar">
	<?php if($this->perms['admin']): ?>
	<div class="btn-group">
		<?php if(!$this->item->enabled):?>
		<a class="btn btn-success" href="<?php echo JRoute::_($adminActionsURL.'&task=publish') ?>">
			<i class="icon-lock icon-white"></i>
			<?php echo JText::_('COM_ATS_BUCKET_LBL_PUBLISH') ?>
		</a>
		<?php else: ?>
		<a class="btn btn-warning" href="<?php echo JRoute::_($adminActionsURL.'&task=unpublish') ?>">
			<i class="icon-lock icon-white"></i>
			<?php echo JText::_('COM_ATS_BUCKET_LBL_UNPUBLISH') ?>
		</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if($this->item->status != 'C'):?>
	<div class="btn-group">
		<a class="btn btn-inverse" href="<?php echo JRoute::_($adminActionsURL.'&task=close') ?>">
			<i class="icon-off icon-white"></i>
			<?php echo JText::_('COM_ATS_BUCKET_LBL_CLOSE') ?>
		</a>
	</div>
	<?php elseif($this->perms['admin']): // Only administrators can re-open a closed issue ?>
	<div class="btn-group">
		<a class="btn" href="<?php echo JRoute::_($adminActionsURL.'&task=reopen') ?>">
			<i class="icon-retweet"></i>
			<?php echo JText::_('COM_ATS_BUCKET_LBL_REOPEN') ?>
		</a>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php
$showTicketList = count($tickets) > 0;
$showReplyArea = $this->item->status != 'C' && count($tickets) > 0 &&
		((($this->item->status != 'C') && $this->perms['post']) || $this->perms['admin']);
$showTabs = $isManager && $showReplyArea && $showTicketList;
?>

<?php if($showTabs):?>
<ul id="atsTab"	class="nav nav-tabs">
	<li>
		<a href="#ats_bucket_reply" data-toggle="tab">
			<?php echo JText::_('COM_ATS_BUCKETS_LEGEND_REPLY') ?>
		</a>
	</li>
	<li>
		<a href="#ats_bucket_tickets" data-toggle="tab">
			<?php echo JText::_('COM_ATS_BUCKETS_LEGEND_TICKETLIST') ?>
		</a>
	</li>
</ul>
<div id="atsTabContent" class="tab-content">
	<div class="tab-pane fade" id="ats_bucket_reply">
<?php endif; ?>

<?php if($showTabs):?>
<?php if($showReplyArea):?>
<h3 class="ats-bucket-reply-header"><?php echo JText::_('COM_ATS_POSTS_HEADING_REPLYAREA')?></h3>
<form name="ats_reply_form" action="<?php echo JURI::base() ?>index.php" method="post" onsubmit="bucketBeforeSubmit()" enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="post" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_bucket_id" value="<?php echo $this->item->ats_bucket_id ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $itemId ?>" />
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

<?php if( $this->perms['admin'] && ($this->item->status == 'C') ): ?>
<div class="alert alert-error">
	<?php echo JText::_('COM_ATS_BUCKET_MSG_CLOSEDNOTICE_CLOSED_ADMIN') ?>
</div>
<?php endif; ?>


<?php
	echo $this->loadAnyTemplate('site:com_ats/bucketreply/form',array(
			'ats_bucket_id'	=> $this->item->ats_bucket_id,
			'returnURL'		=> base64_encode(JURI::getInstance()->toString()),
			'item'			=> null,
			'savestate'		=> 0,
		));
?>
</form>

<?php if($showTabs): ?>
	</div>
	<div class="tab-pane fade" id="ats_bucket_tickets">
<?php endif; ?>
<?php if($showTicketList):?>
					<h3><?php echo JText::_('COM_ATS_BUCKETS_HEADING_TICKETLIST'); ?></h3>
					<table class="table table-striped">
						<thead>
						<?php foreach($tickets as $ticket):?>
						<?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/tickets/default_ticket')  ?>
						<?php endforeach; ?>
						</thead>
					</table>
<?php else: ?>
					<div class="alert alert-info">
						<?php echo JText::_('COM_ATS_BUCKETS_NO_TICKETS_INFO') ?>
					</div>
<?php endif; ?>
<?php if($showTabs):?>
			</div>
		</div>
<?php endif; ?>
<?php
JFactory::getDocument()->addScriptDeclaration( <<<JS
(function($) {
	$('#atsTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})
	$(document).ready(function(){
		$('#atsTab a:first').tab('show');
	});
})(akeeba.jQuery);
JS
);
endif; ?>

<?php JFactory::getDocument()->addScriptDeclaration( <<<JS
var ats_bucket_cansubmit = false;

function bucketBeforeSubmit()
{
	if(!ats_bucket_cansubmit) return false;
	return true;
}

function bucketDoSubmit()
{
	ats_bucket_cansubmit = true;
	document.forms.ats_reply_form.submit();
}

(function($) {
	$(document).ready(function()	{
		document.getElementById('ats-reply-postbutton-nojs').style.display = 'none';
	});

})(akeeba.jQuery);
JS
);
?>

<?php elseif($this->item->status == 'C'): ?>
<div class="ats-bucket-closednotice">
	<?php echo JText::_('COM_ATS_BUCKET_MSG_CLOSEDNOTICE_CLOSED') ?>
</div>
<?php elseif(! $showTicketList): ?>
<div class="alert alert-info">
	<?php echo JText::_('COM_ATS_BUCKETS_NO_TICKETS_INFO') ?>
</div>
<?php endif; ?>

<?php echo AtsHelperModules::loadposition('ats-posts-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

</div>