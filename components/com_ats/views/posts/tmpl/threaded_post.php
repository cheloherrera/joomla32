<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

/*
 * Params coming from including this layout with loadAnyTemplate:
 *
 * $item				: Post information
 * $returnURL			: URL to return after every "moderator" action (ie unpublish attachment)
 * $showCustomFields	: Should I display custom fields? Usually made on first post only
 */

// No direct access
defined('_JEXEC') or die;

$this->loadHelper('credits');
$this->loadHelper('filter');
$this->loadHelper('signature');

// Get the category ID from the request
$category_id = $this->input->getInt('category_id', 0);

// Should I show unpublished posts?
if(!$item->enabled && !JFactory::getUser()->authorise('core.manage', 'com_ats')) return;

// The user who created this post
if($item->created_by == -1)
{
	$postUser 			= clone JFactory::getUser();
	$postUser->username = 'system';
	$postUser->email 	= 'noreply@example.com';
	$postUser->name 	= JText::_('COM_ATS_CLI_SYSTEMUSERLABEL');
}
else
{
	$postUser = JFactory::getUser($item->created_by);
}
$user = JFactory::getUser();
$ticket_owner = $this->input->getInt('ticket_owner', 0);

// Determine custom magic classes (determined by user groups, a la NinjaBoard - thank you Stian for the inspiration!)
$customClasses = array();
foreach($postUser->groups as $groupName => $groupID)
{
	$customClasses[] = 'ats-post-group-'.AtsHelperFilter::toSlug($groupName);
}

// Get the return URL to point back to ourselves
$permalink = JFactory::getURI();
$permalink->setFragment('p'.$item->ats_post_id);

if($item->origin == 'web') {
	$origin_icon = '<span class="icon-globe"></span> ';
} elseif ($item->origin == 'email') {
	$origin_icon = '<span class="icon-envelope"></span> ';
} else {
	$origin_icon = '';
}

// Get the token
$token = JFactory::getSession()->getFormToken().'=1';

// Load the Format helper
require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/format.php';

JLoader::import('joomla.application.component.helper');
$params = JComponentHelper::getParams('com_ats');

// Are we withing the editing time limit?
$withinEditingTime = false;
if(($item->modified_by == JFactory::getUser()->id) || ($item->created_by == JFactory::getUser()->id)) {
	JLoader::import('joomla.utilities.date');
	if(($item->modified_by == JFactory::getUser()->id)) {
		$editedOn = new JDate($item->modified_on);
	} else {
		$editedOn = new JDate($item->created_on);
	}
	$now = new JDate();
	$editedAgo = abs($now->toUnix() - $editedOn->toUnix());

	$editeableforxminutes = $params->get('editeableforxminutes', 15);
	$withinEditingTime = $editedAgo < 60 * $editeableforxminutes;
}

// I save this info in the object so it could be shared with other layouts
$this->isManager = JFactory::getUser()->authorise('core.manage','com_ats') || JFactory::getUser()->authorise('core.manage','com_ats.category.' . $category_id);

?>
<div class="ats-post <?php echo implode(' ',$customClasses) ?> ats-post-status-<?php echo $item->enabled ? 'published' : 'unpublished' ?>" id="p<?php echo $item->ats_post_id ?>">
	<div class="ats-post-header">
		<span class="ats-post-header-date">
			<?php echo $origin_icon ?>
			<a href="<?php echo $permalink ?>">
				<?php echo AtsHelperFormat::date2($item->created_on,'',true); ?>
			</a>
			<?php if ($item->timespent): ?>
			<span class="badge badge-info">
				<?php echo JText::sprintf('COM_ATS_POSTS_TIMESPENT_MSG', $item->timespent); ?>
			</span>
			<?php endif; ?>
		</span>
		<?php if(!$item->enabled): ?>
		<span class="ats-post-header-unpublished">
			<?php echo JText::_('COM_ATS_TICKETS_MSG_UNPUBLISHEDPOSTNOTICE'); ?>
		</span>
		<?php endif; ?>
		<?php if ($this->isManager): ?>
		<span class="ats-post-header-fullname pull-right">
			<?php echo $postUser->name; ?>
		</span>
		<?php endif; ?>
	</div>
	<div class="ats-post-userinfo">
		<?php echo $this->loadAnyTemplate('site:com_ats/posts/threaded_user',array('user' => $postUser));?>
	</div>
	<div class="ats-post-body">
		<div class="ats-post-content">
			<div class="ats-post-content-html">
				<?php echo $item->content_html ?>
			</div>
		<?php
			if($showCustomFields && ATS_PRO):
				$customFields = F0FModel::getTmpInstance('Tickets', 'AtsModel')
									->setId($item->ats_ticket_id)
									->loadCustomFields();
				if($customFields):
		?>
			<div class="ats-post-customfields">
				<h6><?php echo JText::_('COM_ATS_TITLE_CUSTOMFIELDS')?></h6>
				<dl class="dl-horizontal" style="margin-bottom:5px">
		<?php foreach ($customFields as $field):?>
					<dt style="width:320px;margin-right:10px"><?php echo $field['label']?></dt>
					<dd><?php echo $field['value'] ? $field['value'] : '&nbsp;'?></dd>
		<?php endforeach;?>
				</dl>
			</div>
			<?php endif;?>
		<?php endif;?>
			<?php if($item->attachments): $shownAttachmentsHeader = false; ?>
                <?php
                    foreach($item->attachments as $attachment):
                        // If the "private attachment" flag is on, skip records if we're not manager or we're not the owner
                        if ($params->get('attachments_private', 0))
                        {
                            if (
								// If this is not a manager
								!$this->isManager
								// and he doesn't own the attachment
								&& ($user->id != $attachment->created_by)
								// and he doesn't own the ticket
								&& ($user->id != $ticket_owner)
							)
                            {
								// do not show the attachment
                                continue;
                            }
                        }

                        if (
								// If the attachment ID is not empty
								$attachment->ats_attachment_id
								// and we really have an original attachment filename
								&& !empty($attachment->original_filename)
								// and the attachment is enabled, or the user is a manager or the user is allowed to edit his own attachment
								&& (
									// the attachment is enabled
									$attachment->enabled
									// or the attachment is not enabled and the user is a manager (superfluous)
									/*
									|| (
										!$attachment->enabled &&
										$user->authorise('core.manage','com_ats')
									)
									*/
									// or the user is a manager
									|| $this->isManager
									// or the attachment is not enabled but the user can edit his own attachment and this is his own attachment
									|| (
										!$attachment->enabled &&
										$user->authorise('core.edit.own','com_ats')
										&& ($user->id == $item->created_by)
									)
								)
						):
                ?>
				<?php if (!$shownAttachmentsHeader):
				$shownAttachmentsHeader = true; ?>
			<div class="ats-post-attachments">
				<span class="ats-post-attachments-head">
					<?php echo JText::_('COM_ATS_TICKETS_HEADING_ATTACHMENT') ?>
				</span>
				<?php endif; ?>

                <div style="margin-bottom: 3px">
                    <span class="ats-post-attachments-filename">
                        <a href="index.php?option=com_ats&view=attachment&task=read&id=<?php echo $attachment->ats_attachment_id ?>&format=raw&<?php echo $token ?>" >
                            <?php echo $this->escape($attachment->original_filename) ?>
                        </a>
                    </span>

                    <?php if($user->authorise('core.edit.state','com_ats') || $this->isManager || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->created_by)) ): ?>
                    &nbsp;
                    <?php if($attachment->enabled): ?>
                    <a class="btn btn-mini atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_UNPUBLISH') ?>"
                        href="index.php?option=com_ats&view=attachment&task=unpublish&id=<?php echo $attachment->ats_attachment_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
                        <span class="icon-lock"></span>
                    </a>
                    <?php else: ?>
                    <a class="btn btn-mini atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_PUBLISH') ?>"
                        href="index.php?option=com_ats&view=attachment&task=publish&id=<?php echo $attachment->ats_attachment_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
                        <span class="icon-lock"></span>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(JFactory::getUser()->authorise('core.delete','com_ats') || $this->isManager): ?>
                    &nbsp;
                    <a class="btn btn-danger btn-mini" href="index.php?option=com_ats&view=attachment&task=remove&id=<?php echo $attachment->ats_attachment_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>"  onclick="return confirm('<?php echo JText::_('COM_ATS_ATTACHMENTS_MSG_DELETEPROMPT') ?>')">
                        <span class="icon-trash icon-white"></span>
                        <?php echo JText::_('COM_ATS_COMMON_DELETE') ?>
                    </a>
                    <?php endif; ?>
                </div>
				<?php endif; ?>
                <?php endforeach; ?>
			<?php if ($shownAttachmentsHeader): ?>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="ats-post-content-signature">
				<?php echo nl2br(AtsHelperSignature::getSignature($postUser)) ?>
			</div>
		</div>
	</div>
	<div class="ats-post-footer">
		<?php if(($item->modified_on != '0000-00-00 00:00:00') && !empty($item->modified_on)): ?>
		<div class="ats-post-edits">
			<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_EDITEDBYON', JFactory::getUser($item->modified_by)->username, AtsHelperFormat::date($item->modified_on) ) ?>
		</div>
		<?php endif; ?>
		<div class="ats-post-buttons">
			<div class="btn-group pull-left">

				<?php if($user->authorise('core.edit.state','com_ats') || $this->isManager || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->created_by)) ): ?>
				<?php if($item->enabled): ?>
				<a class="btn btn-warning atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_UNPUBLISH') ?>"
					href="index.php?option=com_ats&view=post&task=unpublish&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
					<span class="icon-lock icon-white"></span>
				</a>
				<?php else: ?>
				<a class="btn btn-warning atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_PUBLISH') ?>"
					href="index.php?option=com_ats&view=post&task=publish&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
					<span class="icon-lock icon-white"></span>
				</a>
				<?php endif; ?>
				<?php endif; ?>

				<?php if($user->authorise('core.manage','com_ats') || $this->isManager || $user->authorise('core.edit','com_ats') || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->created_by)) || ($withinEditingTime) ): ?>
				<a class="btn atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_EDIT') ?>"
					href="index.php?option=com_ats&view=post&task=edit&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
					<span class="icon-pencil"></span>
				</a>
				<?php endif ?>

				<?php if(JFactory::getUser()->authorise('core.delete','com_ats') || $this->isManager): ?>
				<a class="btn btn-danger atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_COMMON_DELETE') ?>"
					href="index.php?option=com_ats&view=post&task=remove&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>" onclick="return confirm('<?php echo JText::_('COM_ATS_POSTS_MSG_DELETEPROMPT') ?>')">
					<span class="icon-trash icon-white"></span>
				</a>
				<?php endif; ?>
			</div>

			<?php if( ($user->authorise('core.manage','com_ats') || $this->isManager || $user->authorise('core.edit.state','com_ats')) && ATS_PRO ): ?>
				&nbsp;
				<?php $returnurl = base64_encode(JURI::getInstance()->toString()); ?>
				<?php
					// Please note that if the category doesn't charge the user to post, the following statements always fails, so the
					// "Charge credits" button is displayed, even if we won't charge anything ever! Should we change this behaviour?
					// Should we display them only when the credit feature is on?
				?>
				<?php if($creditsCharged = AtsHelperCredits::creditsCharged('post', $item->ats_ticket_id, $item->ats_post_id)): ?>
				<a href="index.php?option=com_ats&view=post&task=creditsrefund&id=<?php echo $item->ats_post_id ?>&<?php echo $token ?>&returnurl=<?php echo $returnURL?>"
					class="btn btn-danger atsTooltip" data-toggle="tooltip" title="<?php echo JText::sprintf('COM_ATS_POSTS_CREDITS_REFUND', $creditsCharged); ?>">
					<span class="icon-white icon-remove-sign"></span>
					<?php echo $creditsCharged; ?>
				</a>
				<?php else: ?>
				<a href="index.php?option=com_ats&view=post&task=creditscharge&id=<?php echo $item->ats_post_id ?>&<?php echo $token ?>&returnurl=<?php echo $returnURL?>"
					class="btn btn-success atsTooltip" data-toggle="tooltip" title="<?php echo JText::_('COM_ATS_POSTS_CREDITS_CHARGE'); ?>">
					<span class="icon-white icon-plus-sign"></span>
				</a>
				<?php endif; ?>
			<?php endif; ?>
            <div class="clearfix"></div>
		</div>
	</div>
</div>