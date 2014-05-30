<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerPosts extends F0FController
{
	public function __construct($config = array())
    {
		parent::__construct($config);

		$this->cacheableTasks = array();
	}

	protected function onBeforeBrowse()
    {
		$result = parent::onBeforeBrowse();

		if($result && JFactory::getApplication()->isSite() )
        {
			$ticket_id = $this->input->getInt('ats_ticket_id', 0);

			$this->getThisModel()->ticket($ticket_id);
		}

		return $result;
	}

	protected function onBeforeAdd()
    {
		return false;
	}

	protected function onBeforeEdit()
    {
		$result = parent::onBeforeEdit();

		// Are we withing the editing time limit?
		$withinEditingTime  = false;
		$view				= $this->getThisView();
		$item 				= $this->getThisModel()->getItem();

		$ticket				= F0FTable::getAnInstance('Ticket', 'AtsTable');
		$ticket->load($item->ats_ticket_id);
		$view->assign('ticket', $ticket);

        // The standard check failed, maybe we're category manager?
        if(!$result)
        {
            $result = JFactory::getUser()->authorise('core.manage', 'com_ats.category.'.$ticket->catid);
        }

		if(($item->modified_by == JFactory::getUser()->id) || ($item->created_by == JFactory::getUser()->id))
		{
			JLoader::import('joomla.utilities.date');
			if(($item->modified_by == JFactory::getUser()->id)) {
				$editedOn = new JDate($item->modified_on);
			} else {
				$editedOn = new JDate($item->created_on);
			}
			$now = new JDate();
			$editedAgo = abs($now->toUnix() - $editedOn->toUnix());

			JLoader::import('joomla.application.component.helper');
			$params = JComponentHelper::getParams('com_ats');
			$editeableforxminutes = $params->get('editeableforxminutes', 15);
			$withinEditingTime = $editedAgo < 60 * $editeableforxminutes;
		}

		return $result || $withinEditingTime;
	}

	/**
	 * Perform a complex ACL check
	 * @return boolean
	 */
	protected function onBeforeSave()
	{
		$component = JComponentHelper::getParams('com_ats');
		$format    = $this->input->getCmd('format', '');

		// Model can't fetch the ats_post_id name, so I have to manually set it
		$thisModel = $this->getThisModel();
		$thisModel->setId($this->input->getInt('ats_post_id', ''));

		// Check if it's a new post
		$newPost = $thisModel->getItem()->ats_post_id <= 0;

		$user = JFactory::getUser();
		$post = $thisModel->getItem();

		// Check if it's a new ticket
		if($newPost)
        {
			$ticket_id = $this->input->getInt('ats_ticket_id',0);
		}
        else
        {
			$ticket_id = $post->ats_ticket_id;
		}

		if($ticket_id <= 0)
        {
			return false;
		}

		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
					->setId($ticket_id)
					->getItem();

		// Allow new ticket posting only for managers, or owner, if the ticket is not closed
		if($newPost)
		{
			require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

			if(
				!$user->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
				!$user->authorise('core.manage','com_ats')
			){
				if($user->id != $ticket->created_by) {
					return false;
				} elseif($ticket->status == 'C') {
					return false;
				}
			}

			// If the user is a manager and there isn't an assigned user, let's assign him to the ticket
			if(!$ticket->assigned_to && AtsHelper::isManager($ticket->catid))
			{
				$ticket->assigned_to = $user->id;
				$ticket->store();
			}
		}
		else
		{
			// Allow ticket editing for owner, if he has edit.own and the ticket is not closed,
			// or if it's an administrator
			if(
				!$user->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
				!$user->authorise('core.manage','com_ats') &&
				!$user->authorise('core.admin','com_ats')
			){
				if($user->id != $ticket->created_by)
                {
					return false;
				}
                elseif($ticket->status == 'C')
                {
					return false;
				}
                elseif(
					!$user->authorise('core.edit.own','com_ats.category.'.$ticket->catid) &&
					!$user->authorise('core.edit.own','com_ats')
				)
                {
					JLoader::import('joomla.utilities.date');
                    JLoader::import('joomla.application.component.helper');

					$editedOn    = new JDate($post->created_on);
					$altEditedOn = new JDate($post->modified_on);

					if ($altEditedOn->toUnix() > $editedOn->toUnix())
					{
						$editedOn = $altEditedOn;
					}
					$now        = new JDate();
					$editedAgo  = abs($now->toUnix() - $editedOn->toUnix());

					$params = JComponentHelper::getParams('com_ats');
					$editeableforxminutes = $params->get('editeableforxminutes', 15);

					return ($editedAgo < 60 * $editeableforxminutes);
				}
			}
		}

		// If we are still here, the user is allowed to post

		// Handle uploads
		$canPostAttachments = false;

		if(JFactory::getUser()->authorise('ats.attachment', 'com_ats'))
        {
			$canPostAttachments = true;
		}
        elseif(JFactory::getUser()->authorise('ats.attachment', 'com_ats.category.'.$ticket->catid))
        {
			$canPostAttachments = true;
		}

		// Get return URL
		if ($customURL = $this->input->getString('returnurl',''))
		{
			$customURL = base64_decode($customURL);
		}

		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$ticket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '');

		// Let's check if any custom field is not valid.
		// If so, redirect to the edit page, preventing attachment upload (data is not valid)
		// I need to do this check here or I can't redirect to the single post page ;(
		$custom = $this->input->get('custom', array(), 'array');

		if($custom)
		{
			// Grab ticket info and inject them into the model, so I can use the model function
			// without messing up any existing data
			$m_ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel');

			$m_ticket->category($ticket->catid)
					 ->custom($custom);

			// Failed validation!
			if(!$m_ticket->isValid())
			{
				// If custom fields are not ok
				$err_url  = 'index.php?option=com_ats&view=post&task=edit&id='.$post->ats_post_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '');
				$err_url .= '&formsubmit=1&returnurl='.base64_encode($url);

                // I don't worry about AJAX requests, since I'll do that only with existing tickets
				$this->setRedirect($err_url, JText::_('COM_ATS_ERR_NEWTICKET_CUSTOM_FIELDS'), 'error');
				$this->redirect();
			}
			else
			{
				// If I'm here ticket could be saved (ACL checks and above custom fields validations)
				$ticket->params = json_encode($custom);
				$ticket->store();
			}
		}

		$file = JRequest::getVar('attachedfile', '', 'files', 'array');

        if(isset($file['name']) && ($file['name'][0] != '') && $canPostAttachments)
        {
			/** @var AtsModelAttachments $attachmentModel */
            $attachmentModel = F0FModel::getTmpInstance('Attachments','AtsModel');

            list($attachIds, $attachmentErrors) = $attachmentModel->manageUploads($file);
			$this->getThisModel()->setState('attachment_errors', $attachmentErrors);

            $this->input->set('ats_attachment_id', $attachIds);
        }
		if(isset($file['name']) && ($file['name'][0] != '') && !$canPostAttachments)
		{
			$this->getThisModel()->setState('attachment_errors', array(JText::_('COM_ATS_POSTS_ERR_ATTACHMENTNOTALLOWED')));
		}

		// Let's check if anyone posted a reply while we were writing
		$last_post_req = $this->input->getInt('last_ats_post_id', 0);

		// Let's load the entire list, so I'll get the last post id
		$model = F0FModel::getAnInstance('Posts', 'AtsModel')
					->ticket($ticket_id)
					->filter_order('created_on')
					->filter_order_Dir('ASC')
					->limit(0)
					->limitstart(0);
		$model->getList();

		$session = JFactory::getSession();

		if($last_post_req && $last_post_req != $model->_last_ats_post_id)
		{
			// It's a different one from the incoming one, a new answer has been posted
			// Let's warn the user and save his previous post
            if($format == 'json')
            {
                AtsHelper::redirect('json', '', JText::_('COM_ATS_TICKET_REPLY_POSTED_WRITING'), 'error', array('forceReload' => 1, 'lastPost' => $model->_last_ats_post_id));
            }
            else
            {
                $url = 'index.php?option=com_ats&view=ticket&id='.$ticket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '') . '&warn_reply=1';
                $url = JRoute::_($url) . '#p'.$model->_last_ats_post_id;
                $session->set('post_content', $this->input->getHtml('content', ''), 'com_ats.newticket');

                JFactory::getApplication()->redirect($url);
            }
		}
		else
		{
			// Everything is ok, let's delete any saved data into the session
			$session->clear('post_content', 'com_ats.newticket');

			$url = 'index.php?option=com_ats&view=ticket&id='.$ticket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '');

			// Some servers and backend can't read encoded '&' . Let's make it work, despite XHTML compliance
			$url = JRoute::_($url, false);
		}

		// Do I have to charge any extra credits?
		$extra_cred = $this->input->getInt('extracredits', 0);
		if($extra_cred && $component->get('showcredits', 0))
		{
			require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';

			// User hasn't enough credits, let's stop here and warn the manager
			if(AtsHelperCredits::creditsLeft($ticket->created_by) < $extra_cred)
			{
				$err_url  = 'index.php?option=com_ats&view=ticket&id='.$ticket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '');
				$err_url .= '&formsubmit=1&returnurl='.base64_encode($url);
				$this->setRedirect($err_url, JText::_('COM_ATS_POSTS_ERR_EXTRA_CREDITS'), 'error');
				$this->redirect();
			}
		}

		$this->input->set('returnurl', base64_encode($url));

		return true;
	}

	public function save()
	{
		$result = parent::save();

        // Update saved attachments with post id
        $attachments = $this->input->getString('ats_attachment_id', '');

        if($attachments)
        {
			/** @var AtsModelAttachments $attachmentModel */
            $attachmentModel = F0FModel::getTmpInstance('Attachments','AtsModel');
            $postTable       = $this->getThisModel()->getSavedTable();

            $attachmentModel->updateSavedAttachments($attachments, $postTable->ats_post_id);
        }

		// Frontend AJAX requests need a special handling
		if(F0FPlatform::getInstance()->isFrontend() && $this->input->getCmd('format', '') == 'json')
		{
			header('Content-type: application/json');

			$id = $this->getThisModel()->getId();

			$response = array(
				'result' 			=> $result,
				'id'     			=> $id,
				'error'  			=> $this->getError(),
				'attachment_errors'	=> $this->getThisModel()->getState('attachment_errors', array())
			);

			echo json_encode($response);

			JFactory::getApplication()->close();
		}

		return $result;
	}

	public function browse($cachable = false) {
		// When groupbydate is set to 1 we force a JSON view which returns the
		// stats grouped by date. You can use the since/until or other filter in
		// the URL to filter the whole lot
		if($this->input->getInt('groupbydate',0) == 1) {
			if(JFactory::getUser()->guest) {
				return false;
			} else {
				$list = $this->getThisModel()
					->savestate(0)
					->limit(0)
					->limitstart(0)
					->getItemList();
				header('Content-type: application/json');
				echo json_encode($list);
				jexit();
			}
		}

		// If it's the back-end CSV view, force no limits
		if(JFactory::getApplication()->isAdmin() && ($this->input->getCmd('format','html') == 'csv')) {
			$this->getThisModel()
				->savestate(0)
				->limit(0)
				->limitstart(0);
		}

		// Limit what a front-end user can do
		if(JFactory::getApplication()->isSite()) {
			if(JFactory::getUser()->guest) {
				$ticket = $this->getThisModel()->ticket;
				if(!$ticket) return false;
			}
		}

		return parent::browse($cachable);
	}

	public function creditsrefund()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$status = false;

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$post = $model->getItem();
		if($post->ats_post_id) {
			$ticket_id = $post->ats_ticket_id;
			$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
				->setId($ticket_id)
				->getItem();
			if($ticket->ats_ticket_id) {
				if(
					!JFactory::getUser()->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
					!JFactory::getUser()->authorise('core.manage','com_ats')
				) {
					return false;
				}

				if(!class_exists('AtsHelperCredits')) {
					require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
				}
				AtsHelperCredits::refundCredits($ticket->catid, $ticket->ats_ticket_id, $post->ats_post_id, 'post');
				$status = true;
			}
		}

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::singularize($this->view).'&id='.$post->ats_post_id;
		if(!$status)
		{
			$this->setRedirect($url, JText::_('COM_ATS_POSTS_CREDITS_REFUND_ERROR'), 'error');
		}
		else
		{
			$this->setRedirect($url, JText::_('COM_ATS_POSTS_CREDITS_REFUND_SUCCESS'));
		}
		$this->redirect();
	}

	public function creditscharge()
	{
		// CSRF prevention
		if($this->csrfProtection)
        {
			if($this->_csrfProtection() === false) return false;
		}

		$status = false;

		$model = $this->getThisModel();

		if(!$model->getId())
        {

        } $model->setIDsFromRequest();

		$post = $model->getItem();

		if($post->ats_post_id)
        {
			$ticket_id = $post->ats_ticket_id;
			$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
				->setId($ticket_id)
				->getItem();

			if($ticket->ats_ticket_id)
            {
				if(
					!JFactory::getUser()->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
					!JFactory::getUser()->authorise('core.manage','com_ats')
				)
                {
					return false;
				}

				if(!class_exists('AtsHelperCredits'))
                {
					require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
				}

				AtsHelperCredits::chargeCredits($ticket->created_by, $ticket->catid, $ticket->ats_ticket_id, $post->ats_post_id, false, $ticket->public);
				$status = true;
			}
		}

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::singularize($this->view).'&id='.$post->ats_post_id;

		if(!$status)
		{
			$this->setRedirect($url, JText::_('COM_ATS_POSTS_CREDITS_CHARGE_ERROR'), 'error');
		}
		else
		{
			$this->setRedirect($url, JText::_('COM_ATS_POSTS_CREDITS_CHARGE_SUCCESS'));
		}

		$this->redirect();
	}

    /**
     *
     */
    public function parsebbcode()
    {
        require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/bbcode.php';

        $content = $this->input->getHtml('content', '');
        $html    = AtsHelperBbcode::parseBBCode($content);

        echo json_encode($html);

        JFactory::getApplication()->close();
    }
}