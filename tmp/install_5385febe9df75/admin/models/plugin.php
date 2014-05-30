<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.4
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport( 'joomla.utilities.simplexml' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorModelPlugin extends JModel
{
	var $_ext = null; // string
	var $_file = null; // file name string
	var $_installed = null; // object containing all installed plugins
	var $_plugins = null; // object containing all loaded plugins
	var $_plugin = null; // object
	var $_data = null; // object

	function setExt($ext)
	{
		if($ext AND $ext != $this->_ext) {
			$this->_ext = $ext;
			$this->_file = $this->getFilename($ext);
			$this->_plugin = null;
			$this->_data = null;

			return true;
		}
		return false;
	}

	function getFilename($ext) {
		return 'plg_fg_'.substr($ext,strrpos($ext,'_')+1);
	}

	function getFilePath ($ext = null,$type = 'xml')
	{
		$file = $ext ? $this->getFilename($ext) : $this->_file;

		switch($type)
		{
			case 'xml':

			$ret = JPATH_SITE.'/plugins/feedgator/'.$file. ((J_VERSION < 1.6) ? '' : '/'.$file ) .'_config.'.$type;
			break;

			default:

			$ret = JPATH_SITE.'/plugins/feedgator/'.$file. ((J_VERSION < 1.6) ? '' : '/'.$file ) .'.'.$type;
			break;

		}

		return $ret;
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

	function &getParams($feedId = '-2')
	{
		$params = null;

		if (!$this->_data) {
			$this->getPluginData();
		}
		if(!isset($this->_data->paramsArray)) {
			$this->_parseParams();
		}
		if(isset($this->_data->paramsArray)) {
			$params = empty($this->_data->paramsArray[$feedId]['--TXT--']) ? $this->_data->paramsArray[-2]['--TXT--'] :	$this->_data->paramsArray[$feedId]['--TXT--'];
		}

		return $params;
	}

	function _loadDefaultParams()
	{
		$xml = JFactory::getXMLParser('simple');
		$path = $this->getFilePath($this->_ext);

		$params = null;
		$result = '';

		if(file_exists($path) AND $xml->loadFile( $path )) {
	        $root = $xml->document;

	        if($root->name() == 'feedgator' && $root->attributes( 'type' ) == 'plugin') {
	            $params = $root->getElementByPath( 'params' );
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
		if(!$this->_installed) $this->loadInstalledPlugins();
		if(isset($this->_installed->{$this->_ext})) {
			if(!is_object($this->_plugins)) {
				$this->_plugins = new stdClass();
			}
			if(!isset($this->_plugins->{$this->_ext})) {
				$file = $this->getFilePath($this->_ext,'php');
				if(file_exists( $file )) {
					require_once( $file );
					$classname = 'plgFeedgator'.ucfirst(substr($this->_ext,4));
					$this->_plugins->{$this->_ext} = new $classname();
					$this->_plugins->{$this->_ext}->setData($this->getPluginData());
					$this->_plugins->{$this->_ext}->componentInstalled = $this->_plugins->{$this->_ext}->componentCheck();
				}
			}
			$this->_plugin = $this->_plugins->{$this->_ext};
		} else {
			$this->_plugin = null;
		}

		return (boolean)$this->_plugin;
	}

	function _loadPluginData()
	{
		//$query = "SELECT * FROM #__feedgator_plugins WHERE extension = ".$this->_db->Quote($this->_ext);
		//$this->_db->setQuery( $query );
		if(!isset($this->_installed->{$this->_ext})) {
			$this->loadInstalledPlugins();
		}
		if(isset($this->_installed->{$this->_ext})) $this->_data = $this->_installed->{$this->_ext};

		return (boolean)$this->_data;
	}

	function _parseParams()
	{
		if($this->_loadPluginData()) {
			//print_r($this->_data);
			//print_r($this->_installed);
			preg_match_all('/(.?[0-9]+){{?([^}]+)}}?/',$this->_data->params,$paramsList);
			$count = count($paramsList[1]);
			for ($i=0; $i < $count; $i++) {
				$this->_data->paramsArray[$paramsList[1][$i]] = $this->_paramsToArray($paramsList[2][$i]);
			}
			if(!isset($this->_data->paramsArray[-2])) {
				$def_params = $this->_loadDefaultParams();
				$this->_data->paramsArray[-2] = $this->_paramsToArray($def_params);
			}
		}
	}

	function _paramsToArray( &$paramsList )
	{
		if(strpos($paramsList,"\n") === false) {
			$res = json_decode($paramsList,true);
			//horrible fix for INI string expected but json used in Joomla 1.6+
			$res['--TXT--'] = str_replace(array('":"','","','"'),array('=',"\n",''),$paramsList);
		} else {
			$tmp = explode("\n", $paramsList);
			$res = array();
			foreach($tmp AS $a) {
				if($a) {
					@list($key, $val) = explode('=', $a, 2);
					$res[$key] = str_replace('\n',"\n",$val);
				}
			}
			$res['--TXT--'] = $paramsList;
		}

		return $res;
    }

	function setParams($params,$feedId)
	{
		$this->_data->paramsArray[$feedId] = $params;
	}

	function store($feedId = null, $params = null)
	{
		if(!$feedId) $feedId = JRequest::getInt('feedId',-2);
		$id = JRequest::getInt('id');
		if(!$id) {
			$id = $this->getPluginData()->id;
		}

		$row = JTable::getInstance('FGPlugin','Table');
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
			if(!$n) {
				$this->completePluginInstallation();
				$this->loadInstalledPlugins();
			}
			for ($i = 0; $i < $n; $i++) {
				$row = &$rows[$i];

				$row->installed = false;

				// xml file for plugin
				$xmlfile = $this->getFilePath($row->extension);

				if(J_VERSION < 1.6) {
					$xml = JFactory::getXMLParser('simple');

					if (file_exists( $xmlfile ) AND $xml->loadFile( $xmlfile )) {
						$root = &$xml->document;

						if ($root->name() != 'feedgator' OR $root->attributes( 'group' ) != 'feedgator') {
							continue;
						}

						// set temporary ext var so can reset model after loading plugins
						$this->_temp_ext = $this->_ext;
						$this->setExt($row->extension);

						// installed only set if in db and xml file
						$this->_installed->{$this->_ext} = &$row;

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

						$row->icon			= JURI::root().'plugins/feedgator/'.$this->_file.'.png';

						$row->xmlfile		= $xmlfile;

						$row->params		= $this->_parseParams();

						$pquery = "SELECT published FROM #__plugins WHERE element='".$this->getFilename($row->extension)."' AND folder='feedgator'";
						$this->_db->setQuery($pquery);
						$row->published		= $this->_db->loadResult();

						$this->getPlugin($this->_ext); // loads plugin and checks if component installed

						$row->componentInstalled = $this->_plugins->{$this->_ext}->componentInstalled;

						$row->installed 	= true; // confirms plugin fully loaded

						//return to model to original state
						$this->setExt($this->_temp_ext);
					}

				} else {

					if (file_exists( $xmlfile ) AND $xml = JFactory::getXML( $xmlfile )) {
						if ($xml->attributes()->group != 'feedgator') {
							continue;
						}

						// set temporary ext var so can reset model after loading plugins
						$this->_temp_ext = $this->_ext;
						$this->setExt($row->extension);

						// installed only set if in db and xml file
						$this->_installed->{$this->_ext} = &$row;

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

						$row->icon			= JURI::root().'plugins/feedgator/'.$this->_file.'/'.$this->_file.'.png';

						$row->xmlfile		= $xmlfile;

						$row->params		= $this->_parseParams();

						$pquery = "SELECT enabled FROM #__extensions WHERE element='".$this->getFilename($row->extension)."' AND folder='feedgator'";
						$this->_db->setQuery($pquery);
						$row->published		= $this->_db->loadResult();

						$this->getPlugin($this->_ext); // loads plugin and checks if component installed

						$row->componentInstalled = $this->_plugins->{$this->_ext}->componentInstalled;

						$row->installed 	= true; // confirms plugin fully loaded

						//return to model to original state
						$this->setExt($this->_temp_ext);
					}
				}
			}

			$this->_loadPluginData();
			return $rows;
		}
		return $this->_installed;
	}

	/**
	* This is a fix for plugin installation on Joomla 1.5.x
	*/
	function completePluginInstallation()
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$plugins = JFolder::files( JPATH_ROOT.'/plugins/feedgator/', $filter = '.install.php', $recurse = true, $fullpath = true);
		foreach($plugins as $plugin) {
			include($plugin);
		}
	}

	function renderPluginParams($feedId = -2)
	{
		$ext = JRequest::getCmd('ext','','get');

		if(!$ext OR $ext == -2) {
			echo JText::_('FG_PLG_PARAMS_NOT_LOADED');
		} else {
			$this->getPlugin($ext);
			$this->_plugin->getParams($feedId);

			if(J_VERSION < 1.6) {
				$return = $this->_plugin->params->render('pluginparams');
			} else {
				$pdata = $this->_plugin->params->getParams('pluginparams');
				$return = FeedgatorHelper::renderForm($pdata);
			}
			echo $return;
		}
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
				$xmlfile = $this->getFilePath();

				$row = JTable::getInstance('FGPlugin','Table');
				$row->extension = $ext[0];
				$row->published = $ext[1];
				$row->params = '-2{'.$this->_loadDefaultParams().'}';
				$row->store();
			}
		}

		return true;
	}
}