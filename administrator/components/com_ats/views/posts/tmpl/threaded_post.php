<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

$this->loadHelper('filter');
$this->loadHelper('signature');

// Should I show unpublished posts?
if(!$item->enabled && !JFactory::getUser()->authorise('core.manage', 'com_ats')) return;

// The user who created this post
if($item->created_by == -1) {
	$postUser = clone JFactory::getUser();
	$postUser->username = 'system';
	$postUser->email = 'noreply@example.com';
	$postUser->name = JText::_('COM_ATS_CLI_SYSTEMUSERLABEL');
} else {
	$postUser = JFactory::getUser($item->created_by);
}
$user = JFactory::getUser();

// Determine custom magic classes (determined by user groups, a la NinjaBoard - thank you Stian for the inspiration!)
$this->loadHelper('filter');
$customClasses = array();
foreach($postUser->groups as $groupName => $groupID) {
	$customClasses[] = 'ats-post-group-'.AtsHelperFilter::toSlug($groupName);
}

// Get the return URL to point back to ourselves
$permalink = JFactory::getURI();
$permalink->setFragment('p'.$item->ats_post_id);

if($item->origin == 'web') {
	$origin_icon = '<i class="icon-globe"></i> ';
} elseif ($item->origin == 'email') {
	$origin_icon = '<i class="icon-envelope"></i> ';
} else {
	$origin_icon = '';
}

// Get the token
$token = JFactory::getSession()->getFormToken().'=1';

?>
<div class="ats-post <?php echo implode(' ',$customClasses) ?> ats-post-status-<?php echo $item->enabled ? 'published' : 'unpublished' ?>" id="p<?php echo $item->ats_post_id ?>">
	<div class="ats-post-header">
		<span class="ats-post-header-date">
			<?php echo $origin_icon ?>
			<a href="<?php echo $permalink ?>">
				<?php echo AtsHelperFormat::date2($item->created_on,'',true); ?>
			</a>
		</span>
		<?php if(!$item->enabled): ?>
		<span class="ats-post-header-unpublished">
			<?php echo JText::_('COM_ATS_TICKETS_MSG_UNPUBLISHEDPOSTNOTICE'); ?>
		</span>
		<?php endif; ?>
	</div>
	<div class="ats-post-userinfo">
		<?php echo $this->loadAnyTemplate('admin:com_ats/posts/threaded_user',array('user' => $postUser));?>
	</div>
	<div class="ats-post-body">
		<div class="ats-post-content">
			<div class="ats-post-content-html">
				<?php echo $item->content_html ?>
			</div>
            <?php
            if($item->attachments): ?>
                <div class="ats-post-attachments">
				<span class="ats-post-attachments-head">
					<?php echo JText::_('COM_ATS_TICKETS_HEADING_ATTACHMENT') ?>
				</span>
                    <?php
                    foreach($item->attachments as $attachment):

                        // A negative if statement would make more sense, but I don't dare to change this huge one!
                        if($attachment->ats_attachment_id && !empty($attachment->original_filename) && ($attachment->enabled || (!$attachment->enabled && $user->authorise('core.manage','com_ats')) || $this->isManager || (!$attachment->enabled && $user->authorise('core.edit.own','com_ats') && ($user->id == $item->created_by)))):
                            ?>
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
                </div>
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
			<?php if($user->authorise('core.edit.state','com_ats') || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->id)) ): ?>
			<?php if($item->enabled): ?>
			<a class="btn" href="index.php?option=com_ats&view=post&task=unpublish&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-lock"></i>
				<?php echo JText::_('COM_ATS_COMMON_UNPUBLISH') ?>
			</a>
			<?php else: ?>
			<a class="btn" href="index.php?option=com_ats&view=post&task=publish&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-lock"></i>
				<?php echo JText::_('COM_ATS_COMMON_PUBLISH') ?>
			</a>
			<?php endif; ?>
			<?php endif; ?>

			<?php if($user->authorise('core.manage','com_ats') || $user->authorise('core.edit','com_ats') || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->id)) || ($withinEditingTime) ): ?>
			<a class="btn" href="index.php?option=com_ats&view=post&task=edit&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-pencil"></i>
				<?php echo JText::_('COM_ATS_COMMON_EDIT') ?>
			</a>
			<?php endif ?>

			<?php if(JFactory::getUser()->authorise('core.delete','com_ats')): ?>
			<a class="btn btn-danger" href="index.php?option=com_ats&view=post&task=remove&id=<?php echo $item->ats_post_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>" onclick="return confirm('<?php echo JText::_('COM_ATS_POSTS_MSG_DELETEPROMPT') ?>')">
				<i class="icon-trash icon-white"></i>
				<?php echo JText::_('COM_ATS_COMMON_DELETE') ?>
			</a>
			<?php endif; ?>

			<?php if( ($user->authorise('core.manage','com_ats') || $user->authorise('core.edit.state','com_ats')) && ATS_PRO ): ?>
			<?php $returnurl = base64_encode(JURI::getInstance()->toString()); ?>
			<?php if($creditsCharged = AtsHelperCredits::creditsCharged('post', $item->ats_ticket_id, $item->ats_post_id)): ?>
			<a href="index.php?option=com_ats&view=post&task=creditsrefund&id=<?php echo $item->ats_post_id ?>&<?php echo JFactory::getSession()->getFormToken() ?>=1&returnurl=<?php echo $returnURL?>" class="btn btn-danger">
				<i class="icon-white icon-remove-sign"></i>
				<?php echo JText::sprintf('COM_ATS_POSTS_CREDITS_REFUND', $creditsCharged); ?>
			</a>
			<?php else: ?>
			<a href="index.php?option=com_ats&view=post&task=creditscharge&id=<?php echo $item->ats_post_id ?>&<?php echo JFactory::getSession()->getFormToken() ?>=1&returnurl=<?php echo $returnURL?>" class="btn btn-success">
				<i class="icon-white icon-plus-sign"></i>
				<?php echo JText::_('COM_ATS_POSTS_CREDITS_CHARGE'); ?>
			</a>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>