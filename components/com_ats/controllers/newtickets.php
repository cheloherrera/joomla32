<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

/**
 *
 * @author tampe125
 * @TODO We should remove some code and put it in the model, so we can re-use the code in backend, too
 */
class AtsControllerNewtickets extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);

		$this->modelName = 'tickets';
		$this->cacheableTasks = array();
	}

	protected function onBeforeBrowse() {
		return false;
	}

	protected function onBeforeEdit() {
		return false;
	}

	protected function onBeforeApply() {
		return false;
	}

	public function onBeforeSave() {
		return true;
	}

	/**
	 * Save the incoming data and then return to the Browse task
	 */
	public function save()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		// Fetch page parameters
		$component = JComponentHelper::getParams('com_ats');
		$params    = JFactory::getApplication()->getPageParameters('com_ats');
		$session   = JFactory::getSession();

		// Fetch the category
		$category_id  = 0;
		$ticket 	  	  = $this->input->get('ticket', array(), 'array');
		// 'custom' index is used for validation, 'params' one is used to save it to database
		$ticket['custom'] = $this->input->get('custom', array(), 'array');
		$ticket['params'] = json_encode($this->input->get('custom', array(), 'array'));

		$post = $this->input->get('post', null, 'array', 2);
		if(is_array($ticket)) {
			if(array_key_exists('catid', $ticket)) {
				$category_id = $ticket['catid'];
			}
		}
		if(empty($category_id)) {
			$category_id = $params->get('category', 0);
		}
		$categories = F0FModel::getTmpInstance('Categories','AtsModel')
			->category($category_id)
			->getList();
		if(!empty($categories)) {
			$category = array_pop($categories);
		} else {
			// Category not found, this means that the user is not allowed to access it
			return false;
		}

		// Get ACL permissions
		$perms = $this->_getPostPermissions($category_id);

		// Can I post to the category? If I can't, throw a 403!
		if(!$perms['ticket']) return false;

		// Am I a manager?
		$user = JFactory::getUser();
		$isManager = $user->authorise('core.manage','com_ats');

		// -- If I am a manager allow specifying the created_by user (post as another user)
		if ($isManager && $this->input->getInt('created_by', 0))
		{
			$ticket['created_by'] = $this->input->getInt('created_by', 0);

			JLoader::import('joomla.utilities.date');
			$date = new JDate();

			if (version_compare(JVERSION, '3.0', 'ge'))
			{
				$ticket['created_on'] = $date->toSql();
			}
			else
			{
				$ticket['created_on'] = $date->toMysql();
			}
		}

		// Save everything in the session
		if(!array_key_exists('public', $ticket)) 	 $ticket['public'] = 1;
		if(!array_key_exists('content', $post)) 	 $post['content'] = '';
		if(!array_key_exists('content_html', $post)) $post['content_html'] = '';
		if(!array_key_exists('created_by', $post))   $post['created_by'] = null;

		$postcontent = empty($post['content']) ? $post['content_html'] : $post['content'];

		$session->set('ticket_title',	$ticket['title'],	'com_ats.newticket');
		$session->set('ticket_public',	$ticket['public'],	'com_ats.newticket');
		$session->set('custom',			$ticket['params'],	'com_ats.newticket');
		$session->set('post_content',	$postcontent,		'com_ats.newticket');
		if ($isManager)
		{
			$session->set('created_by',	$ticket['created_by'],	'com_ats.newticket');
		}

		// Check public status
		if(!$perms['private']) {
			$ticket['public'] = 1;
		}

		// Check title and content fields; fail if they're missing
		$error = false;

		if(empty($ticket['title']))
		{
			$error = JText::_('COM_ATS_ERR_NEWTICKET_NOTITLE');
		}
		if(!array_key_exists('content', $post)) $post['content'] = '';
		if(!array_key_exists('content_html', $post)) $post['content_html'] = '';
		if(empty($post['content']) && empty($post['content_html'])) {
			$error = JText::_('COM_ATS_ERR_NEWTICKET_NOCONTENT');
		}

		// Is the credit feature on?
		if($component->get('showcredits', 0))
		{
			require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/credits.php';

			$creditsLeft = AtsHelperCredits::creditsLeft(JFactory::getUser()->id);
			$hasCredits  = AtsHelperCredits::haveEnoughCredits(JFactory::getUser()->id, $ticket['catid'], true, $ticket['public'], $ticket['priority']);
			if(!$hasCredits)
			{
				$error = JText::_('COM_ATS_ERR_NEWTICKET_NOT_ENOUGH_CREDITS');
			}
		}

		// Add custom fields validation
		if($error === false)
		{
			// isValid wants a stdClass to check if property ats_ticket_id is set (aka is that a new ticket?)
			$dummy = new stdClass();
			$dummy->ats_ticket_id = 0;
			$isValid = $this->getThisModel()->isValid($dummy);
			if(!$isValid)
			{
				$error = JText::_('COM_ATS_ERR_NEWTICKET_CUSTOM_FIELDS');
			}
		}

		if($error !== false)
		{
			// Let's add a flag field to hide/show custom fields validation labels
			$url = JRoute::_('index.php?option=com_ats&view=newticket&category='.$category_id.'&Itemid='.$this->input->getInt('Itemid',0).'&formsubmit=1');
			$this->setRedirect($url, $error, 'error');
			return true;
		}

		$ticket['catid'] = $category_id;

		// --- Create the ticket
		$model = $this->getThisModel();
		$model->setId(0);

		// Save the ticket
		$this->onBeforeApplySave($ticket);
		$status = $model->save($ticket);

		if(!$status)
        {
			$url = JRoute::_('index.php?option=com_ats&view=newticket&category='.$category_id.'&Itemid='.$this->input->getInt('Itemid',0));
			$this->setRedirect($url, $model->getError(), 'error');
			return true;
		}

		$ats_ticket_id = $model->getId();
		$post['ats_ticket_id'] = $ats_ticket_id;

		// --- Create attachment
        $attErrors = array();
		$file      = JRequest::getVar('attachedfile', '', 'files', 'array');

		if($file['name'][0] != '' && $perms['attachment'])
        {
			$attachmentModel = F0FModel::getTmpInstance('Attachments','AtsModel');

            list($post['ats_attachment_id'], $attErrors) = $attachmentModel->manageUploads($file);
		}

		// --- Create post
		$post['enabled'] = 1;
        $status          = true;
        $pModel          = F0FModel::getTmpInstance('Posts','AtsModel');

		// Save the post (only if we didn't have any error with attachments)
        if(!$attErrors)
        {
            $status = $pModel->save($post);
        }


        // If I have any attachment, I have to check if they failed
        if(isset($post['ats_attachment_id']))
        {
            $status = $status && empty($attErrors);
        }

		if(!$status)
        {
			// Remove the attachments
			if(isset($post['ats_attachment_id']))
            {
                $attachments = explode(',', $post['ats_attachment_id']);
                $attTable    = F0FModel::getTmpInstance('Attachments','AtsModel')->getTable();

                foreach($attachments as $attachment)
                {
                    if($attachment)
                    {
                        $attTable->delete($attachment);
                    }
                }
			}

			// Remove the ticket
			$model->setId($ats_ticket_id)
				->getItem()
				->delete($ats_ticket_id);

			// Redirect
			$url = JRoute::_('index.php?option=com_ats&view=newticket&category='.$category_id.'&Itemid='.$this->input->getInt('Itemid',0), false);

            if($pModel->getError())
            {
                $this->setRedirect($url, $pModel->getError(), 'error');
            }
            else
            {
                $this->setRedirect($url);
            }
			return true;
		}

        // Update saved attachments with post id
        if(isset($post['ats_attachment_id']))
        {
            $attachmentModel = F0FModel::getTmpInstance('Attachments','AtsModel');
            $postTable       = $pModel->getSavedTable();

            $attachmentModel->updateSavedAttachments($post['ats_attachment_id'], $postTable->ats_post_id);
        }

		// Clear session
		$session->clear('ticket_title',	 'com_ats.newticket');
		$session->clear('ticket_public', 'com_ats.newticket');
		$session->clear('custom', 		 'com_ats.newticket');
		$session->clear('post_content',	 'com_ats.newticket');
		$session->clear('created_by',	 'com_ats.newticket');

		// Redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=tickets&category='.$category_id.'&Itemid='.$this->input->getInt('Itemid',0);
		$this->setRedirect($url, JText::_('COM_ATS_LBL_NEWTICKET_SAVED'),'info');
	}

    protected  function onAfterSave()
    {
        $ats_attempt_id = $this->input->getInt('ats_attempt_id');

        // Did ATS show up some instant reply, but the user ignored them?
        if($ats_attempt_id)
        {
            $attempt = F0FModel::getTmpInstance('Attempts', 'AtsModel')->getTable();
            $ticket  = $this->getThisModel()->getSavedTable();

            $attempt->load($ats_attempt_id);

            $bind['ats_ticket_id'] = $ticket->ats_ticket_id;
            $attempt->save($bind);
        }

        return true;
    }

	/*
	 * Make sure the user is allowed to post in this category
	 */
	protected function onBeforeAdd() {
		// Fetch page parameters
		$params  = JFactory::getApplication()->getPageParameters('com_ats');
		$session = JFactory::getSession();
		$view    = $this->getThisView();

		// Fetch the category
		$category_id = $this->input->getInt('category',0);
		if(empty($category_id)) {
			$category_id = $params->get('category', 0);
		}
		$categories = F0FModel::getTmpInstance('Categories','AtsModel')
			->category($category_id)
			->getList();
		if(!empty($categories)) {
			$category = array_pop($categories);
		} else {
			// Category not found, this means that the user is not allowed to access it
			return false;
		}

		// Get ACL permissions
		$perms = $this->_getPostPermissions($category_id);

		// Can I post to the category? If I can't, throw a 403!
		if(!$perms['ticket']) return false;

		// -- If I am a manager allow specifying the created_by user (post as another user)
		$user = JFactory::getUser();
		$isManager = $user->authorise('core.manage','com_ats') || $user->authorise('core.manage','com_ats.category.' . $category_id);

		// Load session and push data
		// @TODO Load everything inside the $cache variable, in the same way we do in Akeeba Subs
		$custom = $session->get('custom', array(), 'com_ats.newticket');

		// Make sure that it's an array, so it will be handled correctly by ats plugins (ie customfields)
		if(!is_array($custom))
		{
			$custom = json_decode($custom, true);
		}

		$cache['custom'] = $custom;

		$view->assign('ticket_title',		$session->get('ticket_title', '', 'com_ats.newticket'));
		$view->assign('ticket_public',		$session->get('ticket_public', null, 'com_ats.newticket'));
		$view->assign('post_content',		$session->get('post_content', '', 'com_ats.newticket'));
		$view->assign('cache',				$cache);
		if ($isManager)
		{
			$view->assign('created_by',		$session->get('created_by', JFactory::getUser()->id, 'com_ats.newticket'));
		}

		$session->clear('ticket_title',		'com_ats.newticket');
		$session->clear('ticket_public',	'com_ats.newticket');
		$session->clear('post_content',		'com_ats.newticket');

		// Push permissions
		$view->assign('allow_private',	  	$perms['private']);
		$view->assign('allow_attachment', 	$perms['attachment']);

		// Push page parameters
		$view->assign('pageparams',			$params);

		// Push category object
        $category->objParams = new JRegistry();
        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $category->objParams->loadString($category->params, 'JSON');
        }
        else
        {
            $category->objParams->loadJSON($category->params);
        }

		$view->assign('category',			$category);

		return true;
	}

	public function getcredits()
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/credits.php';

		// This function should belong to the category controller, but we're using the Joomla ones,
		// so I don't want to create any problem with F0F environment
		$catid    = $this->input->getInt('catid' , 0);
		$public   = $this->input->getInt('public', 1);
		$priority = $this->input->getInt('priority', 10);

		$credits = AtsHelperCredits::creditsRequired($catid, true, $public, $priority);

		echo json_encode(array('credits' => $credits));

		jexit();
	}

	private function _getPostPermissions($category_id)
	{
		// Can I post to the category?
		$canCreateTicket = false;
		if(JFactory::getUser()->authorise('core.create', 'com_ats')) {
			$canCreateTicket = true;
		} elseif(JFactory::getUser()->authorise('core.create', 'com_ats.category.'.$category_id)) {
			$canCreateTicket = true;
		}

		// Can I post private tickets?
		$canPostPrivately = false;
		if(JFactory::getUser()->authorise('ats.private', 'com_ats')) {
			$canPostPrivately = true;
		} elseif(JFactory::getUser()->authorise('ats.private', 'com_ats.category.'.$category_id)) {
			$canPostPrivately = true;
		}

		// Can I post private attachments?
		$canPostAttachments = false;
		if(JFactory::getUser()->authorise('ats.attachment', 'com_ats')) {
			$canPostAttachments = true;
		} elseif(JFactory::getUser()->authorise('ats.attachment', 'com_ats.category.'.$category_id)) {
			$canPostAttachments = true;
		}

		return array(
			'ticket'			=> $canCreateTicket,
			'private'			=> $canPostPrivately,
			'attachment'		=> $canPostAttachments
		);
	}
}