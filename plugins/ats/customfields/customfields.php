<?php
/**
 * @package		ats
 * @copyright	Copyright (c)2010-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

defined('_JEXEC') or die();

class plgAtsCustomfields extends JPlugin
{
	private $fieldTypes = array();

	function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);

		$this->_loadFields();
	}

	/**
	 * Renders per-category custom fields
	 *
	 * @param   array   $cache
	 * @param   array   $userparams
	 *
	 * @return  array
	 */
	public function onTicketFormRenderPerCatFields($cache, $userparams = null)
	{
		$db   = JFactory::getDbo();
		$lang = JFactory::getLanguage();
		$lang->load('plg_ats_customfields', JPATH_ADMINISTRATOR, 'en-GB', true);
		$lang->load('plg_ats_customfields', JPATH_ADMINISTRATOR, null, true);

		// Init the fields array which will be returned
		$fields = array();

		if(!isset($cache['custom'])) $cache['custom'] = array();

		// No catid? Stop here
		if(!isset($cache['catid']) || !$cache['catid'])
		{
			return $fields;
		}

		// Load field definitions
		$items = F0FModel::getTmpInstance('Customfields','AtsModel')
			->enabled(1)
			->filter_order('ordering')
			->filter_order_Dir('ASC')
			->limit(0)
			->limitStart(0)
			->getList();

		if(empty($items)) return $fields;

		$query = $db->getQuery(true)
					->select('ats_customfield_id')
					->from('#__ats_customfields_cats')
					->where('catid = '.$cache['catid']);
		$customcats = $db->setQuery($query)->loadColumn();

		// Loop through the items
		foreach($items as $item)
		{
			// If it's not something shown in this category, skip it
			if($item->show == 'category')
			{
				if(is_null($cache['catid'])) continue;
				if(!in_array($item->ats_customfield_id, $customcats)) continue;
			}

			// Get the names of the methods to use
			$type  = $item->type;
			$class = 'AtsCustomField' . ucfirst($type);

			if (!class_exists($class))
			{
				continue;
			}
			$object = new $class;

			// Add the field to the list
			if (empty($userparams))
			{
				$userparams = (object)array(
					'params'	=> null
				);
			}

			$result = $object->getField($item, $cache, $userparams);

			if(is_null($result) || empty($result)) {
				continue;
			} else {
				$fields[] = $result;
			}

			// Add Javascript for the field
			$object->getJavascript($item);
		}

		return $fields;
	}

	public function onValidate($data)
	{
		$db = JFactory::getDbo();

		$response = array(
			'valid'				=> true,
			'isValid'			=> true,
			'custom_validation'	=> array()
		);

		// Fetch the custom data
		$custom = $data->custom;

		// Load field definitions
		$items = F0FModel::getTmpInstance('Customfields','AtsModel')
			->enabled(1)
			->filter_order('ordering')
			->filter_order_Dir('ASC')
			->getItemList(true);

		// If there are no custom fields return true (all valid)
		if(empty($items)) return $response;

		$query = $db->getQuery(true)
					->select('ats_customfield_id')
					->from('#__ats_customfields_cats')
					->where('catid = '.$data->category);
		$customcats = $db->setQuery($query)->loadColumn();

		// Loop through each custom field
		foreach($items as $item)
		{
			// Make sure it's supposed to be shown in the particular level
			if($item->show == 'category')
			{
				if(is_null($data->category)) continue;
				if(!in_array($item->ats_customfield_id, $customcats)) continue;
			}

			// Make sure there is a validation method for this type of field
			$type = $item->type;
			$class = 'AtsCustomField' . ucfirst($type);

			if (!class_exists($class))
			{
				continue;
			}
			$object = new $class;

			// Get the validation result and save it in the $response array
			$response['custom_validation'][$item->slug] = $object->validate($item, $custom);

			if(is_null($response['custom_validation'][$item->slug]))
			{
				unset($response['custom_validation'][$item->slug]);
			}
			elseif(!$item->allow_empty)
			{
				$response['isValid'] = $response['isValid'] && $response['custom_validation'][$item->slug];
			}
		}

		// Update the master "valid" reponse. If one of the fields is invalid,
		// the entire plugin's result is invalid (the form should not be submitted)
		$response['valid'] = $response['isValid'];

		return $response;
	}

	private function _loadFields()
	{
		JLoader::import('joomla.filesystem.folder');

		$this->fieldTypes = array();

		$basepath = JPATH_ADMINISTRATOR.'/components/com_ats/assets/customfields';
		$files 	  = JFolder::files($basepath, '.php');

		foreach($files as $file)
		{
			if ($file === 'abstract.php')
			{
				continue;
			}

			require_once $basepath.'/'.$file;

			$type  = substr($file, 0, -4);
			$class = 'AtsCustomField' . ucfirst($type);

			if (class_exists($class))
			{
				$this->fieldTypes[] = $type;
			}
		}
	}
}