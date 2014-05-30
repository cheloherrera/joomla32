<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerEmailtemplates extends F0FController
{
    public function testtemplate()
    {
        require_once JPATH_SITE.'/components/com_ats/helpers/email.php';

        $id = $this->input->getInt('ats_emailtemplate_id', 0);

        $conf   = JFactory::getConfig();
        $mailer = AtsHelperEmail::getMailer();
        $model  = $this->getThisModel();
        $key    = $model->getKey($id);

        list($body, $subject) = $model->getEmailTemplate($key);

        $mailInfo = array(
            'id'				=> '12345',
            'title'				=> 'Template Test',
            'url'				=> JURI::root(),
            'attachment'		=> '',
            'poster_username'	=> 'Poster Username',
            'poster_name'		=> 'Poster Name',
            'user_username'		=> 'Notified user Username',
            'user_name'			=> 'Notified user Name',
            'text'				=> 'This is the text contained inside the post',
            'catname'			=> 'Category title',
            'sitename'			=> $conf->get('sitename'),
            'origin'			=> 'ORIGIN',
            'avatar'			=> '',
            'assigned_to'		=> 'Assigned user',
        );

        $parsed = $model->parseTemplate($body, $subject, $mailInfo);

        $mailer->addRecipient(JFactory::getUser()->email, JFactory::getUser()->name);
        $mailer->setSubject($parsed['subject']);
        $mailer->setBody($parsed['body']);

        $mailer->Send();

        $this->setRedirect('index.php?option=com_ats&view=emailtemplate&id='.$id, JText::_('COM_ATS_EMAILTEMPLATES_TEST_SENT'));
    }
}