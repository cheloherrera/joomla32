<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.environment.browser');

JHTML::_('behavior.keepalive');
JHTML::_('behavior.modal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JLoader::import('joomla.plugin.helper');
JPluginHelper::importPlugin('ats');

$navigator = JBrowser::getInstance();
$component = JComponentHelper::getParams('com_ats');

F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
F0FTemplateUtils::addJS('media://com_ats/js/ticket.js?'.ATS_VERSIONHASH);
$throbber = F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');

// If I am using a WYSIWYG editor or I don't want AJAX or I'm using an IE version lower than 10, then disable AJAX posting
if($component->get('editor', 'bbcode') == 'wysiwyg' || !$component->get('ajaxreplies', 1) || ($navigator->isBrowser('msie') && $navigator->getVersion() < 10))
{
    $onClickSubmitPost = ' onclick="javascript:ticketDoSubmit()"';
}
else
{
    AkeebaStrapper::addJSfile('media://com_ats/js/ajax_posting.js?'.ATS_VERSIONHASH);
    AkeebaStrapper::addJSfile('media://com_ats/js/jquery.form.js?'.ATS_VERSIONHASH);
    AkeebaStrapper::addJSfile('media://com_ats/js/jquery.blockUI.js?'.ATS_VERSIONHASH);
    JText::script('COM_ATS_COMMON_RELOAD');
    JText::script('COM_ATS_COMMON_RELOADING');
    $onClickSubmitPost = '';
}

// If I'm not a manager and the ticket is not closed, let's add the javascript file to handle user feedback
if (!JFactory::getUser()->guest && $this->item->status != 'C' && !$this->perms['admin'])
{
	AkeebaStrapper::addJSfile('media://com_ats/js/userfeedback.js?'.ATS_VERSIONHASH);
}

$this->loadHelper('credits');
$this->loadHelper('format');
$this->loadHelper('html');
$this->loadHelper('modules');
$this->loadHelper('select');

$user      = JFactory::getUser();
$ownerUser = JFactory::getUser($this->item->created_by);

$returnURL = base64_encode(JURI::getInstance()->toString());
$adminActionsURL = 'index.php?option=com_ats&view=ticket&id='.$this->item->ats_ticket_id.'&returnurl='.$returnURL.'&Itemid='.$this->input->getInt('Itemid',0).'&'.JFactory::getSession()->getFormToken().'=1';

$printURL = clone JURI::getInstance();
$printURL->setVar('layout', 'print');
$printURL->setVar('tmpl', 'component');

$isManager = $user->authorise('core.manage','com_ats') || $user->authorise('core.manage','com_ats.category.' . $this->category->id);

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);

$show_credits     = JComponentHelper::getParams('com_ats')->get('showcredits', 0);
$credits_required = AtsHelperCredits::creditsRequired($this->item->catid, false, $this->item->public, $this->item->priority);
$enough_credits   = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $this->item->catid, false, $this->item->public, $this->item->priority);
$credits_charged  = AtsHelperCredits::creditsCharged('ticket', $this->item->ats_ticket_id);
$totalcredits	  = AtsHelperCredits::creditsCharged('all', $this->item->ats_ticket_id);

$return_url  = base64_encode(JFactory::getURI()->toString());
$token		 = JFactory::getSession()->getFormToken();

if($this->item->assigned_to)
{
	$class 		 = 'label-info';
	$assigned_to = JFactory::getUser($this->item->assigned_to)->name;
}
else
{
	$class 		 = 'label-important';
	$assigned_to = JText::_('COM_ATS_TICKETS_UNASSIGNED');
}

switch($this->item->status) {
    case 'O':
        $status_class = 'label-important';
        break;

    case 'C':
        $status_class = 'label-success';
        break;

    case 'P':
    default:
        $status_class = 'label-warning';
        break;
}
?>

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-posts-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1) || true) : ?>
	<h1 class="ats-ticket-view-title">
		#<?php echo $this->escape($this->item->ats_ticket_id); ?> &ndash;
		<?php echo $this->escape($this->item->title); ?>
	</h1>
	<div class="ats-ticket-view-postedin">
		<?php echo JText::sprintf('COM_ATS_TICKET_LBL_POSTEDIN', $this->escape($this->category->title)) ?>
	</div>
<?php endif; ?>

<?php if($this->perms['admin'] || $this->perms['close']): ?>
<div class="btn-toolbar">
	<?php if($this->perms['admin']): ?>
	<div class="btn-group">
		<a href="<?php echo $printURL ?>" class="btn atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKETS_PRINTVIEW') ?>" target="_blank">
			<span class="icon-print"></span>
		</a>
	</div>

	<div class="btn-group">
		<?php if(!$this->item->public):?>
		<a class="btn atsTooltip" href="<?php echo JRoute::_($adminActionsURL.'&task=public_publish') ?>"
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_MAKEPUBLIC') ?>"
		>
			<span class="icon-eye-close"></span>
		</a>
		<?php else: ?>
		<a class="btn atsTooltip" href="<?php echo JRoute::_($adminActionsURL.'&task=public_unpublish') ?>"
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_MAKEPRIVATE') ?>"
		>
			<span class="icon-eye-open"></span>
		</a>
		<?php endif; ?>
	</div>
	<div class="btn-group">
		<?php if(!$this->item->enabled):?>
		<a class="btn atsTooltip btn-success" href="<?php echo JRoute::_($adminActionsURL.'&task=publish') ?>"
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_PUBLISH') ?>"
		>
			<span class="icon-lock icon-white"></span>
		</a>
		<?php else: ?>
		<a class="btn atsTooltip btn-warning" href="<?php echo JRoute::_($adminActionsURL.'&task=unpublish') ?>"
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_UNPUBLISH') ?>"
		>
			<span class="icon-lock icon-white"></span>
		</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>

    <div class="pull-right">
        <?php if($isManager):?>
            <img src="<?php echo $throbber?>" style="display:none" />
            <?php echo AtsHelperHtml::createStatusDropdown(array('div_style' => 'pull-right', 'btn_style' => '', 'title' => ''))?>
        <?php endif;?>
        <span class="label <?php echo $status_class?> pull-right">
				<?php echo AtsHelperHtml::decodeStatus($this->item->status)?>
			</span>
    </div>

	<?php if($this->perms['admin'] && ATS_PRO):?>
	<?php echo AtsHelperHtml::buildManagerdd($adminActionsURL.'&task=assign&assigned_to=', array('div' => 'assignto pull-right', 'a' => 'btn-mini'), $this->item->catid)?>
	<span class="pull-right label <?php echo $class?>"><?php echo $assigned_to?></span>
	<?php endif;?>

<?php
	if($this->item->status != 'C'):

        // I'm the admin or the user feedback is switched off
		if($this->perms['admin'] || !$component->get('userfeedback', 0) || !ATS_PRO)
        {
            $class = '';
            $href  = JRoute::_($adminActionsURL.'&task=close');
            $extra = '';
        }
        elseif($this->perms['close'])
        {
            $class = 'user-feedback';
            $href  = '#akeeba-modal';
            $extra = 'rel="boxed" data-submiturl="'.JRoute::_($adminActionsURL.'&task=close').'"';
        }
?>
	<?php if($this->perms['admin']): ?>
	<div class="btn-group">
		<a class="btn atsTooltip btn-inverse <?php echo $class?>" href="<?php echo $href?>" <?php echo $extra ?>
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_CLOSE') ?>"
		>
			<span class="icon-off icon-white"></span>
		</a>
	</div>
	<?php else: ?>
	<div class="btn-group">
		<a class="btn btn-inverse <?php echo $class?>" href="<?php echo $href?>" <?php echo $extra ?> >
			<span class="icon-off icon-white"></span>
			<?php echo JText::_('COM_ATS_TICKET_LBL_CLOSE') ?>
		</a>
	</div>
	<?php endif; ?>
	<?php elseif($this->perms['admin']): // Only administrators can re-open a closed issue ?>
	<div class="btn-group">
		<a class="btn atsTooltip" href="<?php echo JRoute::_($adminActionsURL.'&task=reopen') ?>"
		   data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_TICKET_LBL_REOPEN') ?>"
		>
			<span class="icon-retweet"></span>
		</a>
	</div>
	<?php endif; ?>

	<?php if($this->perms['admin']):?>
	<div class="btn-group">
		<form name="ats_moveticket_form" id="ats_moveticket_form" action="<?php echo JURI::base() ?>index.php" method="post" class="form form-inline">
			<input type="hidden" name="option" value="com_ats" />
			<input type="hidden" name="view" value="ticket" />
			<input type="hidden" name="task" value="move" />
			<input type="hidden" name="id" value="<?php echo $this->item->ats_ticket_id ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $itemId ?>" />
			<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
			<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
			<?php echo AtsHelperSelect::getCategories($this->item->catid, 'catid', array('class' => 'input-medium')); ?>
			<button class="btn btn-primary">
				<span class="icon-white icon-arrow-right"></span>
			</button>
		</form>
	</div>
	<?php endif;?>

	<?php if($this->perms['admin'] && $show_credits && ATS_PRO ):?>
	<?php if($credits_charged): ?>
	<a href="index.php?option=com_ats&view=ticket&task=creditsrefund&id=<?php echo $this->item->ats_ticket_id ?>&<?php echo $token ?>=1&returnurl=<?php echo $return_url ?>"
	   class="btn btn-danger atsTooltip" data-toggle="tooltip" title="<?php echo JText::sprintf('COM_ATS_TICKETS_CREDITS_REFUND', $credits_charged) ?>">
		<span class="icon-white icon-minus-sign"></span>
		<?php echo $credits_charged; ?>
	</a>
	<?php else: ?>
	<a href="index.php?option=com_ats&view=ticket&task=creditscharge&id=<?php echo $this->item->ats_ticket_id ?>&<?php echo $token ?>=1&returnurl=<?php echo $return_url ?>"
	   class="btn btn-success atsTooltip" data-toggle="tooltip" title="<?php echo JText::sprintf('COM_ATS_TICKETS_CREDITS_CHARGE', AtsHelperCredits::creditsRequired($this->item->catid, true, $this->item->public, $this->item->priority)) ?>">
		<span class="icon-white icon-plus-sign"></span>
		<?php echo AtsHelperCredits::creditsRequired($this->item->catid, true, $this->item->public, $this->item->priority); ?>
	</a>
	<?php endif; ?>
	<?php endif; ?>
</div>
<?php if($show_credits && ATS_PRO): ?>
<div class="alert alert-info">
	<?php echo JText::sprintf('COM_ATS_COMMON_USERCREDITSLEFT', AtsHelperCredits::creditsLeft($this->item->created_by)) ?>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if($this->perms['admin'] && ATS_PRO ):?>
<div class="alert alert-success">
	<?php echo JText::sprintf('COM_ATS_TICKET_TIMESPENT_MSG', $this->item->timespent); ?>
	<?php if ($show_credits): ?>
	<br/>
	<?php echo JText::sprintf('COM_ATS_TICKET_TOTALCREDITS_MSG', $totalcredits); ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if($this->item->public): ?>
<div class="alert" id="ats-newticket-pubnote-public">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PUBLIC') ?>
</div>
<?php else: ?>
<div class="alert alert-success" id="ats-newticket-pubnote-private">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PRIVATE') ?>
</div>
<?php endif; ?>

<?php
// HTML displayed right before the posts (ie Social Buttons)
$results = JFactory::getApplication()->triggerEvent('onBeforeTicketConversationDisplay', array($this->item));

if($results)
{
    $html = array();

    foreach($results as $result)
    {
        if($result)
        {
            $html[] = $result;
        }
    }

    if($html)
    {
        echo '<div class="ats-before-ticketconversation">'.implode("\n", $html).'</div>';
    }
}
?>

<?php if($isManager):?>
<ul id="atsTab"	class="nav nav-tabs">
	<li>
		<a href="#atsTabConvo" data-toggle="tab">
			<?php echo JText::_('COM_ATS_TICKETS_LEGEND_CONVO'); ?>
		</a>
	</li>
	<li>
		<a href="#atsTabManager" data-toggle="tab">
			<?php echo JText::_('COM_ATS_TICKETS_LEGEND_MANAGERNOTES'); ?>
		</a>
	</li>
</ul>
<div id="atsTabContent" class="tab-content">
	<div class="tab-pane fade" id="atsTabConvo">
<?php endif; ?>
		<div id="atsPostList">
<?php
	F0FDispatcher::getTmpInstance('com_ats', 'posts', array('input'=>array(
		'category_id'		=> $this->category->id,
		'ats_ticket_id'		=> $this->item->ats_ticket_id,
		'ticket_owner'		=> $this->item->created_by,
		'layout'			=> 'threaded',
		'limit'				=> 0,
		'limitstart'		=> 0,
		'render.toolbar'	=> 0,
		'filter_order'		=> 'created_on',
		'filter_order_Dir'	=> 'ASC',
        'bootstrap'         => false
	)))->dispatch();

?>
		</div>
<?php
// HTML displayed right before the posts (ie Social Buttons)
$results = JFactory::getApplication()->triggerEvent('onAfterTicketConversationDisplay', array($this->item));

if($results)
{
    $html = array();

    foreach($results as $result)
    {
        if($result)
        {
            $html[] = $result;
        }
    }

    if($html)
    {
        echo '<div class="ats-after-ticketconversation">'.implode("\n", $html).'</div>';
    }
}

?>
<?php if( (($this->item->status != 'C') && $this->perms['post']) || $this->perms['admin'] ): ?>
<?php
	// Let's get the last post stored in session (it's set inside the previous F0FDispatcher call
	$session = JFactory::getSession();
	$last_post = $session->get($this->item->ats_ticket_id.'.last_post', 0, 'com_ats');
?>
<h3 class="ats-ticket-reply-header"><?php echo JText::_('COM_ATS_POSTS_HEADING_REPLYAREA')?></h3>
<form name="ats_reply_form" action="<?php echo JURI::base() ?>index.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="post" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_ticket_id" value="<?php echo $this->item->ats_ticket_id ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $itemId ?>" />
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" id="token" value="1" />
	<input type="hidden" name="last_ats_post_id" value="<?php echo $last_post?>" />
    <input type="hidden" id="category_id" value="<?php echo $this->category->id ?>" />

<?php if($show_credits && !$this->perms['admin']):
$creditsleft = AtsHelperCredits::creditsLeft(JFactory::getUser()->id, true) ?>
<div class="alert alert-info" id="ats-newticket-pubnote-public">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<?php echo JText::sprintf('COM_ATS_COMMON_CREDITSLEFT', $creditsleft) ?>
</div>
<?php endif; ?>

<?php if($this->perms['admin'] && ATS_PRO ):?>
<div class="alert alert-success">
	<?php echo JText::sprintf('COM_ATS_TICKET_TIMESPENT_MSG', $this->item->timespent); ?>
	<?php if ($show_credits): ?>
	<br/>
	<?php echo JText::sprintf('COM_ATS_TICKET_TOTALCREDITS_MSG', $totalcredits); ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if($this->item->public): ?>
<div class="alert" id="ats-newticket-pubnote-public">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PUBLIC') ?>
<?php else: ?>
<div class="alert alert-success" id="ats-newticket-pubnote-private">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PRIVATE') ?>
<?php endif; ?>
	<?php if($show_credits && ATS_PRO){
		if($credits_required) {
			echo JText::sprintf('COM_ATS_NEWPOST_LBL_COST', $credits_required);
		} else {
			echo JText::_('COM_ATS_NEWPOST_LBL_NOCOST');
		}
	}?>
</div>

<?php if( $this->perms['admin'] && ($this->item->status == 'C') ): ?>
<div class="alert alert-error">
	<?php echo JText::_('COM_ATS_TICKET_MSG_CLOSEDNOTICE_CLOSED_ADMIN') ?>
</div>
<?php endif; ?>

<?php if($this->input->getInt('warn_reply', 0)):?>
<div class="alert">
	<?php echo JText::_('COM_ATS_TICKET_REPLY_POSTED_WRITING');?>
</div>
<?php endif;?>

<?php
// @todo This IF statement is getting quite huge and tricky to understand. I suggest to move it inside the view
if((!$enough_credits && !$isManager))
{
    echo $this->loadAnyTemplate('site:com_ats/post/notenoughcredits');
}
elseif((!$isManager && JComponentHelper::getParams('com_ats')->get('noreplies', 0)))
{
    echo $this->loadAnyTemplate('site:com_ats/post/noreplies');
}
else
{
    // If the ticket is already assigned to another manager, warn the user
    if($this->item->assigned_to && $isManager && $this->item->assigned_to != $user->id):?>
        <div class="alert alert-danger">
            <?php echo JText::sprintf('COM_ATS_TICKET_ALREADY_ASSIGNED_WARN', $assigned_to)?>
        </div>
    <?php endif;?>
    <div id="ats-reply-form-area">
        <?php
        echo $this->loadAnyTemplate('site:com_ats/post/post',array(
            'post_content'		=> $this->post_content,
            'allow_attachment'	=> $this->perms['attachment'],
            'direct'			=> true,
        ));
        ?>

        <div id="ats-reply-postbutton-nojs">
            <button type="submit"><?php echo JText::_('COM_ATS_TICKET_LBL_DOPOST')?></button>
        </div>
        <?php if(!JComponentHelper::getParams('com_ats')->get('noreplies', 0) || $isManager):?>
            <div class="ats-buttonbar">
                <div class="ats-button ats-button-action-postticket">
                    <button class="btn btn-primary" type="submit" <?php echo $onClickSubmitPost ?>>
                        <?php echo JText::_('COM_ATS_TICKET_LBL_DOPOST') ?>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
}
?>
</form>

<?php if($isManager): ?>
	</div>
	<div class="tab-pane fade" id="atsTabManager">
	<?php
		echo F0FDispatcher::getTmpInstance('com_ats', 'managernotes', array('input'=>array(
			'ats_ticket_id'		=> $this->item->ats_ticket_id,
			'layout'			=> 'threaded',
			'limit'				=> 0,
			'limitstart'		=> 0,
			'render.toolbar'	=> 0,
			'category'			=> $this->category->id,
			'bootstrap'         => false
		)))->dispatch();
	?>

<h3 class="ats-ticket-reply-header"><?php echo JText::_('COM_ATS_POSTS_HEADING_MANAGERNOTEAREA')?></h3>
<?php echo $this->loadAnyTemplate('site:com_ats/managernote/form',array(
	'ats_ticket_id'	=> $this->input->getInt('id',0),
	'returnURL'		=> base64_encode(JURI::getInstance()->toString()),
	'item'			=> null
));?>

	</div>
</div>
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
var ats_ticket_cansubmit = false;

function ticketBeforeSubmit()
{
	if(!ats_ticket_cansubmit) return false;
	return true;
}

function ticketDoSubmit()
{
	ats_ticket_cansubmit = true;
	document.forms.ats_reply_form.submit();
}

(function($) {
	$(document).ready(function()	{
		document.getElementById('ats-reply-postbutton-nojs').style.display = 'none';
		$('div.akeeba-bootstrap .atsTooltip').tooltip({placement: 'bottom'});
	});

})(akeeba.jQuery);
JS
);

elseif($this->item->status == 'C'): ?>
<div class="ats-ticket-closednotice">
	<?php echo JText::_('COM_ATS_TICKET_MSG_CLOSEDNOTICE_CLOSED') ?>
</div>
<?php endif; ?>

<?php echo AtsHelperModules::loadposition('ats-posts-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

<?php if($component->get('userfeedback', 0) && $this->item->status != 'C' && !$this->perms['admin'] && ATS_PRO):?>
    <div style="display: none">
        <div id="akeeba-modal">
            <div class="akeeba-bootstrap" style="text-align: center">
                <h3><?php echo JText::_('COM_ATS_TICKET_PLEASE_RATE')?></h3>
                <p><?php echo JText::_('COM_ATS_TICKET_PLEASE_RATE_EXPLAIN')?></p>
                <div class="btn-group" data-toggle="buttons-radio" style="margin:20px 0 40px">
                    <button type="button" class="btn rating" data-rating="1">1 <?php echo JText::_('COM_ATS_TICKET_PLEASE_RATE_BAD') ?></button>
                    <button type="button" class="btn rating" data-rating="2">2</button>
                    <button type="button" class="btn rating" data-rating="3">3</button>
                    <button type="button" class="btn rating" data-rating="4">4</button>
                    <button type="button" class="btn rating" data-rating="5">5 <?php echo JText::_('COM_ATS_TICKET_PLEASE_RATE_GREAT') ?></button>
                </div>

                <div style="text-align: right">
                    <button type="button" class="btn" onclick="javascript:closeModal()"><?php echo JText::_('JCANCEL')?></button>
                    <button type="button" class="btn btn-inverse" onclick="javascript:submitFeedback()"><?php echo JText::_('JSUBMIT')?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div style="display: none">
	<div id="ajaxFormFeedback">
		<div>
			<div class="progress progress-striped">
				<div class="bar" style="width:0;"></div>
			</div>
			<div class="messageHolder" style="display:none;text-align: center">
				<div class="message"></div>
				<input type="button" class="closeUpload btn" value="Ok"/>
                <input type="button" class="reloadTicketList btn" style="display: none" value="<?php echo JText::_('COM_ATS_COMMON_RELOAD')?>"/>
			</div>
		</div>
	</div>
</div>
