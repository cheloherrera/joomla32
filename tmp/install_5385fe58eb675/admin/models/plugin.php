<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.3
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'plugin.feedgator.installer.php');
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.simplexml' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorModelPlugin extends JModel
{
	var $_ext = null; // string
	var $_installed = null; // object containing all installed plugins
	var $_plugins = null; // object containing all loaded plugins
	var $_plugin = null; // object
	var $_data = null; // object

	function setExt($ext)
	{
		if($ext AND $ext != $this->_ext) {
			$this->_ext = $ext;
			$this->_plugin = null;
			$this->_data = null;

			return true;
		}
		return false;
	}

	function &getPlugin($ext = null)
	{
		if($ext) $this->setExt($ext);
		if(!$this->_plugin) {
			$this->_loadPlugin();
		}
		return $this->_plugin;
	}

	function &getPluginData()
	{
		if(!$this->_data) {
			$this->_loadPluginData();
		}
		return $this->_data;
	}

	function &getParams($feedId = '-1')
	{
		$params = null;
		$ext = $this->_ext;

		if (!$this->_data) {
			$this->getPluginData();
		}
		if(!isset($this->_data->paramsArray)) {
			$this->_ext = $ext; // fix for reset $ext
			$this->_parseParams();
		}
		if(isset($this->_data->paramsArray)) {
			empty($this->_data->paramsArray[$feedId]['--TXT--']) ? $params = $this->_data->paramsArray[-1]['--TXT--'] :	$params = $this->_data->paramsArray[$feedId]['--TXT--'];
		}

		return $params;
	}

	function _loadDefaultParams()
	{
		$xml = JFactory::getXMLParser('simple');
		$path = $this->getXmlPath();

		$params = null;
		$result = '';

		if(file_exists($path) AND $xml->loadFile( $path )) {
	        $root =& $xml->document;

	        if($root->name() == 'install' && $root->attributes( 'type' ) == 'fgplugin') {
	            $params = &$root->getElementByPath( 'params' );
	        }
        }
        if (is_object( $params )) {
			foreach ($params->children() as $param) {
				$key = $param->attributes( 'name' );
				$type = $param->attributes( 'type' );
				if ( $type != 'spacer' ) {
					$value = str_replace("\n",'\n',$param->attributes( 'default' ));
					$result .= "$key=$value\n";
				}
			}
		}
		return $result;
	}

	function _loadPlugin()
	{
		$ext = $this->_ext;
		if(!$this->_installed) $this->loadInstalledPlugins();
		if(isset($this->_installed->$ext)) {
			if(!isset($this->_plugins->$ext)) {
				$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'plugins'.DS.$ext.DS.$ext.'.php';
				if(file_exists( $file )) {
					require_once( $file );
					$classname = 'FeedgatorPlugin'.ucfirst(substr($ext,4));
					$this->_plugins->$ext = new $classname();
					$this->_plugins->$ext->setData($this->getPluginData());
					$this->_plugins->$ext->componentInstalled = $this->_plugins->$ext->componentCheck();
				}
			}
			$this->_plugin = $this->_plugins->$ext;
		} else {
			$this->_plugin = null;
		}

		return (boolean)$this->_plugin;
	}

	function _loadPluginData()
	{
		//$query = "SELECT * FROM #__feedgator_plugins WHERE extension = ".$this->_db->Quote($this->_ext);
		//$this->_db->setQuery( $query );
		$ext = $this->_ext;
		if(!isset($this->_installed->$ext)) {
			$this->loadInstalledPlugins();
		}
		if(isset($this->_installed->$ext)) $this->_data = $this->_installed->$ext;

		return (boolean)$this->_data;
	}

	function _parseParams()
	{
		if($this->_loadPluginData()) {
			//print_r($this->_data);
			//print_r($this->_installed);
			preg_match_all('/(.?[0-9]+){([^}]+)}/',$this->_data->params,$paramsList);
			$count = count($paramsList[1]);
			for ($i=0; $i < $count; $i++) {
				$this->_data->paramsArray[$paramsList[1][$i]] = $this->_paramsToArray($paramsList[2][$i]);
			}
			if(!isset($this->_data->paramsArray[-1])) {
				$this->_data->paramsArray[-1] = $this->_paramsToArray($this->_loadDefaultParams());
			}
		}
	}

	function _paramsToArray( &$paramsList )
	{
		$tmp = explode("\n", $paramsList);
		$res = array();
		foreach($tmp AS $a) {
			if($a) {
				@list($key, $val) = explode('=', $a, 2);
				$res[$key] = str_replace('\n',"\n",$val);
			}
		}
		$res['--TXT--'] = $paramsList;

		return $res;
    }

	function setParams($params,$feedId)
	{
		$this->_data->paramsArray[$feedId] = $params;
	}

	function store($feedId = null, $params = null)
	{
		if(!$feedId) $feedId = JRequest::getInt('feedId',-1);
		$id = JRequest::getInt('id');
		if(!$id) {
			$id = $this->getPluginData()->id;
		}

		$row = &JTable::getInstance('FGPlugin','Table');
		$row->load($id);
		if ( !$row->id ) {
			return false;
		}
		if(!$params) $params = JRequest::getVar('pluginparams', array() ,'post', 'array');
		if(empty($params)) {
			return false;
		}
		$paramsTxt = FeedgatorUtility::makeINIString($params);

		if(!$this->_data OR !isset($this->_data->paramsArray)) {
			$this->getParams();
		}
		$this->_data->paramsArray[$feedId] = $params;
		$this->_data->paramsArray[$feedId]['--TXT--'] = $paramsTxt;
		$this->_data->params = '';
		foreach ($this->_data->paramsArray as $tmpfeedId => $tmpparams) {
			$this->_data->params .= $tmpfeedId . '{' . $tmpparams['--TXT--'] . '}';
		}

		return $row->save($this->_data);
	}

	function getXmlPath ()
	{
		return JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'plugins'.DS.$this->_ext.DS.$this->_ext.'.xml';
	}

	function loadInstalledPlugins()
	{
		if(!$this->_installed) {
			$query = 	'SELECT *,'.
						' (SELECT SUM(published) FROM #__feedgator_plugins) as pub_count'.
						' FROM #__feedgator_plugins'.
						' ORDER BY extension';

			$this->_db->setQuery( $query );
			$rows = $this->_db->loadObjectList();

			$n = count( $rows );
			for ($i = 0; $i < $n; $i++) {
				$row = &$rows[$i];
				$ext = $row->extension;

				// path to plugin directory
				$pluginBaseDir = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'plugins'.DS.$ext;

				// xml file for plugin
				$xmlfile = $pluginBaseDir.DS.$ext.'.xml';

				if(J_VERSION < 1.6) {
					$xml = JFactory::getXMLParser('simple');

					if (file_exists( $xmlfile ) AND $xml->loadFile( $xmlfile )) {
						$root = &$xml->document;

						if ($root->name() != 'install' OR $root->attributes( 'type' ) != 'fgplugin') {
							continue;
						}

						$element 			= &$root->getElementByPath( 'name' );
						$row->name		 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'creationdate' );
						$row->creationdate 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'updateddate' );
						$row->updateddate 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'author' );
						$row->author 		= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'copyright' );
						$row->copyright 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'authoremail');
						$row->authorEmail 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'authorurl');
						$row->authorUrl 	= $element ? $element->data() : '';

						$element 			= &$root->getElementByPath( 'version');
						$row->version 		= $element ? $element->data() : '';

						// installed only set if in db and xml file
						$this->_installed->$ext = &$row;

						$this->getPlugin($ext); // loads plugin and checks if component installed
						$row->componentInstalled = $this->_plugins->$ext->componentInstalled;
					}
				} else {
					if (file_exists( $xmlfile ) AND $xml = JFactory::getXML( $xmlfile )) {

						if ($xml->name() != 'install' OR $xml->attributes()->type != "fgplugin") {
							continue;
						}

						$element 			= &$xml->name;
						$row->name		 	= $element ? $element->data() : '';

						$element 			= &$xml->creationDate;
						$row->creationdate 	= $element ? $element->data() : '';

						$element 			= &$xml->updatedDate;
						$row->updateddate 	= $element ? $element->data() : '';

						$element 			= &$xml->author;
						$row->author 		= $element ? $element->data() : '';

						$element 			= &$xml->copyright;
						$row->copyright 	= $element ? $element->data() : '';

						$element 			= &$xml->authorEmail;
						$row->authorEmail 	= $element ? $element->data() : '';

						$element 			= &$xml->authorUrl;
						$row->authorUrl 	= $element ? $element->data() : '';

						$element 			= &$xml->version;
						$row->version 		= $element ? $element->data() : '';

						// installed only set if in db and xml file
						$this->_installed->$ext = &$row;

						$this->getPlugin($ext); // loads plugin and checks if component installed
						$row->componentInstalled = $this->_plugins->$ext->componentInstalled;
					}
				}
			}

			$this->_loadPluginData();
			return $rows;
		}
		return $this->_installed;
	}

	function renderPluginParams($feedId = -1)
	{
		$ext = JRequest::getCmd('ext','','get');

		if(!$ext OR $ext == -1) {
			echo JText::_('FG_PLG_PARAMS_NOT_LOADED');
		} else {
			$this->getPlugin($ext);
			$this->_plugin->getParams($feedId);

			echo $this->_plugin->params->render('pluginparams');
		}
	}

	function uploadPlugin( )
	{
		$app = &JFactory::getApplication();
		$lang =& JFactory::getLanguage();
		$lang->load('com_installer',JPATH_ADMINISTRATOR);

		$installerModel = new InstallerModelInstall;

		 // Get an installer instance
		$installer =& JInstaller::getInstance();
		$feedgatorPluginInstaller = new FeedgatorPluginInstaller($installer);

        $installer->setAdapter('fgplugin',$feedgatorPluginInstaller);
		$feedgatorPluginInstaller->parent = &$installer;

		$install->_adapters['fgplugin'] = &$feedgatorPluginInstaller;
		/* End of the fix for PHP <= 4 */

        if($installerModel->install()) {
        	if(J_VERSION < 1.6) array_pop($app->_messageQueue); // removes Joomla internal success msg
			$app->redirect('index.php?option=com_feedgator&task=plugins',JText::_('FG_PLG_INSTALL_SUCCESS'));
        } else {
        	$app->redirect('index.php?option=com_feedgator&task=plugins');
        }
	}

	function uninstallPlugin( $pluginid )
	{
		$app = &JFactory::getApplication();

		// Get an installer instance
		$installer =& JInstaller::getInstance();
		$feedgatorPluginInstaller = new FeedgatorPluginInstaller($installer);
		$installer->setAdapter('fgplugin',$feedgatorPluginInstaller);
		$result = false;
		if ($pluginid) {
			$result = $installer->uninstall('fgplugin', $pluginid );
		}

		if (!$result) {
			$app->redirect('index.php?option=com_feedgator&task=plugins',$installer->getError());
		}
		$app->redirect('index.php?option=com_feedgator&task=plugins',JText::_('FG_PLG_UNINSTALL_SUCCESS'));
	}

	function installBasePlugins()
	{
		$fields = array();
		$fields[] = '`id` int NOT NULL primary key auto_increment';
		$fields[] = '`extension` varchar(100) NOT NULL';
		$fields[] = '`published` int(1) default 0';
		$fields[] = '`params` text NOT NULL';

		$query = "CREATE TABLE IF NOT EXISTS `#__feedgator_plugins` (". implode(', ', $fields) .") ENGINE=MyISAM;";
		$this->_db->setQuery( $query );
		$this->_db->query();

		$extensions = array (
			//	name			published
			array(	'com_content',		1),
			array(	'com_k2',     		0)
		);

		foreach ( $extensions as $ext ) {
			$query = "SELECT COUNT(*) FROM `#__feedgator_plugins` WHERE extension='{$ext[0]}'";
			$this->_db->setQuery($query);
			if ( $this->_db->loadResult() == 0 ) {
				$this->setExt($ext[0]);
				$xmlfile = $this->getXmlPath();

				$row = &JTable::getInstance('FGPlugin','Table');
				$row->extension = $ext[0];
				$row->published = $ext[1];
				$row->params = '-1{'.$this->_loadDefaultParams().'}';
				$row->store();
			}
		}

		return true;
	}
}