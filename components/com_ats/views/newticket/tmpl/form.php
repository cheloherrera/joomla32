<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHTML::_('behavior.keepalive');
JPluginHelper::importPlugin('ats');
$component = JComponentHelper::getParams('com_ats');

// Load template helpers
$this->loadHelper('format');
$this->loadHelper('modules');
$this->loadHelper('select');

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
JFactory::getDocument()->addScriptDeclaration("function addToValidationFetchQueue(myfunction){}");
JFactory::getDocument()->addScriptDeclaration("function addToValidationQueue(myfunction){}");
$throbber = F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');

if($component->get('showcredits', 0) && $component->get('ticketPriorities', 0))
{
	AkeebaStrapper::addJSfile('media://com_ats/js/priority_credits.js?'.ATS_VERSIONHASH);
}
else
{
	JFactory::getDocument()->addScriptDeclaration(
'akeeba.jQuery(document).ready(function($){
	akeeba.jQuery("#privateticket").change(function(){
		if(akeeba.jQuery("#privateticket").val() == 0){
			akeeba.jQuery("#ats-newticket-pubnote-public").hide();
			akeeba.jQuery("#ats-newticket-pubnote-private").show();
		}
		else{
			akeeba.jQuery("#ats-newticket-pubnote-private").hide();
			akeeba.jQuery("#ats-newticket-pubnote-public").show();
		}
	})
})
'
	);
}

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);
if($itemId != 0) {
	$actionURL = 'index.php?Itemid='.$itemId;
} else {
	$actionURL = 'index.php';
}

$params = new JRegistry();
if(version_compare(JVERSION, '3.0', 'ge')) {
	$params->loadString($this->category->params, 'JSON');
} else {
	$params->loadJSON($this->category->params);
}

if($params->get('instantreply',0))
{
	$proxyURL  = JRoute::_('index.php?option=com_ats&view=instantreply&task=browse&catid='.$this->category->id, false);
	$proxyURL .= strpos($proxyURL, '?') !== false ? '&' : '?';
	$proxyURL .= 'format=json';
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("var ats_instantreply_proxy = '".$proxyURL."';\n");
	AkeebaStrapper::addJSfile('media://com_ats/js/instantreply.js?'.ATS_VERSIONHASH);
}

$ticketPrivate  = false;
$defaultPrivate = $params->get('defaultprivate', 0);

// Do I have a stored visibility coming from the session?
if(!is_null($this->ticket_public))
{
	$ticketPrivate = !$this->ticket_public;
}
else
{
	$ticketPrivate = $defaultPrivate;
}

?>
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-newticket-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo JText::sprintf('COM_ATS_NEWTICKET_TITLE', $this->escape($this->category->title)); ?>
	</h1>
<?php endif; ?>

<form name="ats_newticket_form" class="form-horizontal" action="<?php echo $actionURL ?>" method="post" onsubmit="ticketBeforeSubmit()" enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="newticket" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ticket[catid]" id="ticket_catid" value="<?php echo $this->category->id ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $itemId ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

    <?php if($params->get('instantreply',0)) :?>
        <input type="hidden" name="ats_attempt_id" value="" />
    <?php endif;?>

	<?php if ($this->isManager): ?>
	<input type="hidden" name="created_by" id="created_by" value="<?php echo $this->created_by ?>" />
	<div class="control-group">
		<label class="control-label" for="created_by_visible"><?php echo JText::_('COM_ATS_COMMON_USERSELECT_LBL') ?></label>
		<div class="controls">
			<input type="text" class="input-medium" name="xxx_userid" id="created_by_visible" value="<?php echo $this->created_by ? JFactory::getUser($this->created_by)->username : '' ?>" disabled="disabled" />
			<button onclick="return false;" class="btn btn-mini modal"><?php echo JText::_('COM_ATS_COMMON_SELECTUSER')?></button>
			<a class="modal" style="display: none" id="userselect" href="index.php?option=com_ats&view=jusers&tmpl=component&field=created_by" rel="{handler: 'iframe', size: {x: 800, y: 500}}">Select</a>
		</div>
	</div>
	<?php endif; ?>

	<div class="control-group">
		<label class="control-label" for="tickettitle"><?php echo JText::_('COM_ATS_NEWTICKET_LBL_TITLE') ?></label>
		<div class="controls">
			<input type="text" class="span6" id="tickettitle" name="ticket[title]" value="<?php echo $this->ticket_title ?>" required="required" />
		</div>
	</div>

<?php if($params->get('instantreply',0)): ?>
<div id="ats-instantreply-wrapper" class="control-group" style="display:none;">
	<label id="ats-instantreply-title" class="control-label"><?php echo JText::_('COM_ATS_NEWTICKET_INSTANTREPLY_HEADER') ?></label>
	<div class="controls">
		<div id="ats-instantreply-grid" style="display:none">
		</div>
		<div id="ats-instantreply-noresults" class="alert alert-error" style="display:none"><?php echo JText::_('COM_ATS_NEWTICKET_INSTANTREPLY_NORESULTS') ?></div>
		<div id="ats-instantreply-wait" class="label label-important" style="display:none"><?php echo JText::_('COM_ATS_NEWTICKET_INSTANTREPLY_LOADING') ?></div>
	</div>

</div>
<div id="ats-instantreply-lightbox-wrapper" style="display:none">
	<div id="ats-instantreply-lightbox-shader">
		<div id="ats-instantreply-lightbox-innerbox">
			<span id="ats-instantreply-lightbox-close" class="btn">
				<i class="icon-ok icon-ok"></i>
				<?php echo JText::_('COM_ATS_NEWTICKET_INSTANTREPLY_CLOSETHIS') ?>
			</span>
			<iframe id="ats-instantreply-lightbox-iframe"></iframe>
		</div>
	</div>
</div>
<?php endif; ?>
<?php
    // Am I forcing a ticket type (public private)?
    $forcetype = $this->category->objParams->get('forcetype');
    if($forcetype)
    {
        $ticketPrivate = (int)($forcetype == 'PRIV');
        echo '<input type="hidden" name="ticket[public]" value="'.(int)($forcetype == 'PUB').'" />';
    }
    elseif($this->allow_private){ ?>
	<?php
		// I always display the public/private select list, even if I know I can't post using a status, but at least I can inform the user
		// how much it will cost to do so... ?>
	<div class="control-group">
		<label class="control-label" for="privateticket"><?php echo JText::_('COM_ATS_NEWTICKET_LBL_VISIBILITY') ?></label>
		<div class="controls">
			<select id="privateticket" name="ticket[public]">
				<option value="1" <?php if(!$ticketPrivate): ?>selected="selected"<?php endif; ?>><?php echo JText::_('COM_ATS_NEWTICKET_LBL_PUBLIC')?></option>
				<option value="0" <?php if($ticketPrivate): ?>selected="selected"<?php endif; ?>><?php echo JText::_('COM_ATS_NEWTICKET_LBL_PRIVATE')?></option>
			</select>
		</div>
	</div>
<?php } ?>

<?php // Can users choose ticket priorities? If they can't, I'll automatically put the value in F0FTable check ?>
<?php if($component->get('ticketPriorities', 0) && ATS_PRO):?>
	<div class="control-group">
		<label class="control-label" for="priority"><?php echo JText::_('COM_ATS_TICKET_PRIORITY') ?></label>
		<div class="controls">
			<?php echo AtsHelperSelect::priorities('ticket[priority]', $defaultPrivate ? 1 : 5)?>
		</div>
	</div>
<?php endif;?>

<?php if($this->show_credits && ATS_PRO):
$creditsleft = AtsHelperCredits::creditsLeft(JFactory::getUser()->id, true) ?>
<div class="controls">
	<div class="alert alert-info">
		<a class="close" data-dismiss="alert" href="#">×</a>
		<?php echo JText::sprintf('COM_ATS_COMMON_CREDITSLEFT', $creditsleft) ?>
	</div>
</div>
<?php endif; ?>

<div class="controls">
	<div id="loading" style="text-align:center;display:none;margin-bottom:20px">
		<img src="<?php echo $throbber ?>" />
	</div>
	<div class="alert" id="ats-newticket-pubnote-public" <?php if($ticketPrivate): ?>style="display: none"<?php endif; ?>>
		<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PUBLIC') ?>
		<?php if($this->show_credits && ATS_PRO) {
			if($this->credits_public) {
				echo JText::sprintf('COM_ATS_NEWTICKET_LBL_COST', '<span class="credits">'.$this->credits_public.'</span>');
			} else {
				echo JText::_('COM_ATS_NEWTICKET_LBL_NOCOST');
			}
		} ?>
	</div>
	<div class="alert alert-success" id="ats-newticket-pubnote-private" <?php if(!$ticketPrivate): ?>style="display: none"<?php endif; ?>>
		<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PRIVATE') ?>
		<?php if($this->show_credits && ATS_PRO) {
			if($this->credits_private) {
				echo JText::sprintf('COM_ATS_NEWTICKET_LBL_COST', '<span class="credits">'.$this->credits_private.'</span>');
			} else {
				echo JText::_('COM_ATS_NEWTICKET_LBL_NOCOST');
			}
		} ?>
	</div>
</div>

<?php
if(!$this->item->ats_ticket_id)
{
// @TODO Load everything inside the $cache variable, in the same way we do in Akeeba Subs
$app  = JFactory::getApplication();
$args = array_merge($this->item->getProperties(), array('catid' => $this->category->id), $this->cache);
unset($args['input']);
$jResponse = $app->triggerEvent('onTicketFormRenderPerCatFields', array($args));
if(is_array($jResponse) && !empty($jResponse)) foreach($jResponse as $customFields):
	if(is_array($customFields) && !empty($customFields)) foreach($customFields as $field):
		if(array_key_exists('isValid', $field) && $this->input->getInt('formsubmit', 0))
		{
			$customField_class = $field['isValid'] ? (array_key_exists('validLabel', $field) ? 'success' : '') : 'error';
		}
		else
		{
			$customField_class = '';
		}
	?>
		<div class="control-group <?php echo $customField_class ?>">
			<label for="<?php echo $field['id']?>" class="control-label">
				<?php echo $field['label']?>
			</label>
			<div class="controls">
				<?php echo $field['elementHTML']?>
				<?php if(array_key_exists('validLabel', $field) && $this->input->getInt('formsubmit', 0)):?>
				<span id="<?php echo $field['id']?>_valid" class="help-inline"
					  style="<?php if(!$field['isValid']):?>display:none<?php endif?>">
						  <?php echo $field['validLabel']?>
				</span>
				<?php endif;?>
				<?php if(array_key_exists('invalidLabel', $field) && $this->input->getInt('formsubmit', 0)):?>
				<span id="<?php echo $field['id']?>_invalid" class="help-inline"
					  style="<?php if($field['isValid']):?>display:none<?php endif?>">
						  <?php echo $field['invalidLabel']?>
				</span>
				<?php endif;?>
			</div>
		</div>

	<?php
			endforeach;
		endforeach;
}
	?>

<div class="control-group">
	<label class="control-label" for="bbcode"><?php echo JText::_('COM_ATS_NEWTICKET_LBL_YOURREQUEST') ?></label>
	<?php
		if(empty($this->post_content)) {
			$this->post_content = $params->get('defposttext','');
			$this->loadHelper('editor');
			$this->loadHelper('bbcode');
			if(!AtsHelperEditor::isEditorBBcode()) {
				$this->post_content = AtsHelperBbcode::parseBBCode($this->post_content);
			}
		}
		echo $this->loadAnyTemplate('site:com_ats/post/post',array(
			'post_content'		=> $this->post_content,
			'allow_attachment'	=> $this->allow_attachment,
			'category'			=> $this->category->id,
		));
	?>
</div>

<div id="ats-newticket-postbutton-nojs">
	<button type="submit"><?php echo JText::_('COM_ATS_NEWTICKET_LBL_DOPOST')?></button>
</div>

<a href="javascript:ticketDoSubmit()" class="btn btn-primary">
	<i class="icon-comment icon-white"></i>
	<?php echo JText::_('COM_ATS_NEWTICKET_LBL_DOPOST') ?>
</a>

</form>

<?php echo AtsHelperModules::loadposition('ats-newticket-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

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
	document.forms.ats_newticket_form.submit();
}

(function($) {
	$(document).ready(function()	{
		document.getElementById('ats-newticket-postbutton-nojs').style.display = 'none';
	});

})(akeeba.jQuery);
JS
);
?>

<?php if ($this->isManager): ?>
<script type="text/javascript">
function jSelectUser_userid(id, username)
{
	document.getElementById('created_by').value = id;
	document.getElementById('created_by_visible').value = username;
	try {
		document.getElementById('sbox-window').close();
	} catch(err) {
		SqueezeBox.close();
	}
}

window.addEvent("domready", function() {
	$$("button.modal").each(function(el) {
		el.addEvent("click", function(e) {
			try {
				new Event(e).stop();
			} catch(anotherMTUpgradeIssue) {
				try {
					e.stop();
				} catch(WhateverIsWrongWithYouIDontCare) {
					try {
						DOMEvent(e).stop();
					} catch(NoBleepinWay) {
						alert('If you see this message, your copy of Joomla! is FUBAR');
					}
				}
			}
			SqueezeBox.fromElement(document.getElementById('userselect'), {
				parse: 'rel'
			});
		});
	});
});
</script>
<?php endif; ?>
</div>