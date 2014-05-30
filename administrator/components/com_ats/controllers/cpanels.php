<?php
/**
 * @package   ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerCpanels extends F0FController
{
	public function execute($task)
	{
		if(!in_array($task, array('updateinfo'))) {
			$task = 'browse';
		}
		parent::execute($task);
	}

	public function onBeforeBrowse()
	{
		$result = parent::onBeforeBrowse();
		if ($result)
		{
			/** @var AtsModelCpanels $model */
			$model = F0FModel::getTmpInstance('Cpanels', 'AtsModel');

			// Do we need a download ID?
			$this->getThisView()->needsdlid = $model->needsDownloadID();

			// Run the automatic update site refresh
			/** @var AtsModelUpdates $updateModel */
			$updateModel = F0FModel::getTmpInstance('Updates', 'AtsModel');
			$updateModel->refreshUpdateSite();

			// Is the update plugin enabled?
			$this->getThisView()->update_plugin = $model->isUpdatePluginEnabled();

			// Store the site URL in the component options
			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
				->select('params')
				->from($db->qn('#__extensions'))
				->where($db->qn('element') . '=' . $db->q('com_ats'))
				->where($db->qn('type') . '=' . $db->q('component'));
			$db->setQuery($query);
			$rawparams = $db->loadResult();
			$params = new JRegistry();
			$params->loadString($rawparams, 'JSON');

			$siteURL_stored = $params->get('siteurl', '');
			$siteURL_target = str_replace('/administrator', '', JURI::base());

			if ($siteURL_target != $siteURL_stored)
			{
				$params->set('siteurl', $siteURL_target);
				$query = $db->getQuery(true)
					->update($db->qn('#__extensions'))
					->set($db->qn('params') . '=' . $db->q($params->toString()))
					->where($db->qn('element') . '=' . $db->q('com_ats'))
					->where($db->qn('type') . '=' . $db->q('component'));
				$db->setQuery($query);
				$db->execute();
			}

			// Auto-fix the database schema
			F0FModel::getTmpInstance('Cpanels', 'AtsModel')->checkAndFixDatabase();
		}

		return $result;
	}

	public function updateinfo()
	{
		/** @var AtsModelUpdates $updateModel */
		$updateModel = F0FModel::getTmpInstance('Updates', 'AtsModel');
		$updateInfo = (object)$updateModel->getUpdates();

		$result = '';

		if ($updateInfo->hasUpdate)
		{
			$strings = array(
				'header'		=> JText::sprintf('COM_ATS_CPANEL_MSG_UPDATEFOUND', $updateInfo->version),
				'button'		=> JText::sprintf('COM_ATS_CPANEL_MSG_UPDATENOW', $updateInfo->version),
				'infourl'		=> $updateInfo->infoURL,
				'infolbl'		=> JText::_('COM_ATS_CPANEL_MSG_MOREINFO'),
			);

			$result = <<<ENDRESULT
	<div class="alert alert-warning">
		<h3>
			<span class="icon icon-exclamation-sign glyphicon glyphicon-exclamation-sign"></span>
			{$strings['header']}
		</h3>
		<p>
			<a href="index.php?option=com_installer&view=update" class="btn btn-primary">
				{$strings['button']}
			</a>
			<a href="{$strings['infourl']}" target="_blank" class="btn btn-small btn-info">
				{$strings['infolbl']}
			</a>
		</p>
	</div>
ENDRESULT;
		}

		echo '###' . $result . '###';

		// Cut the execution short
		JFactory::getApplication()->close();
	}
}