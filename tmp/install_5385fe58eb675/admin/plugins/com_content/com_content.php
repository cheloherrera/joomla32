<?php

/**
* FeedGator Content Importing Plugin for Joomla Content
* @version 1.8.3
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorPluginContent
{
	// Title for use in menus etc
	var $title = 'Joomla Content';
	// Name of extension that plugin enable FeedGator to save to
	var $extension = 'com_content';
	// DB table to above extension
	var	$table = '#__content';
	// Name for "published' column in content items - com_content uses 'state'
	var $state = 'state';
	// Name for section column in content items or alias for section
	var $section = 's.title';
	// Section ID over-ride for content components without sections
	var $sectionid = null;
	// Object containing plugin data - id,extension,published,params(INI)
	var $data = null;
	// JParameter object with plugin parameters
	var $params = null;

	function __construct()
	{
		$this->section = (J_VERSION < 1.6) ? 's.title' : '\'null\'';
		$this->model = &FGFactory::getPluginModel();
		$this->model->setExt($this->extension);
		$this->_db = &JFactory::getDBO();
	}

	function setData($data)
	{
		$this->data = $data;
		if(J_VERSION >= 1.6) {
			$this->sectionid = -1*$this->data->id;
		}
	}

	function &getData()
	{
		if(!$this->data) {
			$this->model->setExt($this->extension);
			$this->setData($this->model->getPluginData());
		}
		return $this->data;
	}

	function &getParams($feedId = -1)
	{
		if(!$this->params) {
			$this->params = new JParameter( $this->model->getParams($feedId), $this->model->getXmlPath() );
		}
		return $this->params;
	}

	function componentCheck()
    {
		return true;
	}

	function countContentItems($where)
	{
		$this->_buildWhere($where);
		// Get the total number of records specified by where clause
		$query = '(SELECT COUNT(*)' .
				' FROM ' . $this->table .' AS c' .
				' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
				((J_VERSION < 1.6) ? ' LEFT JOIN #__sections AS s ON s.id = c.sectionid' : '').
				' LEFT JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '. $this->_db->Quote($this->extension) .
				' LEFT JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
				$where.')';
		return $query;
		//$this->_db->setQuery($query);
		//return $this->_db->loadResult();
	}

	function countContentQuery()
	{
		// Get the total number of records in range (added later)
		$query = 'SELECT COUNT(*)' .
				' FROM ' . $this->table .
				' WHERE id IN (%s)' .
				' AND ('.$this->state.' = 1 OR '.$this->state.' = 0)';
		return $query;
	}

	function getContentItem($id)
	{
		$query = 	'SELECT *' .
					' FROM ' . $this->table .
					' WHERE id = '. $this->_db->Quote($id) .
					' AND ('.$this->state.' = 1 OR '.$this->state.' = 0)';
		$this->_db->setQuery( $query );
		if(!$content = $this->_db->loadAssoc()) {
			return false;
		}

		return $content;
	}

	function getContentLink($id)
	{
	    return JRoute::_( 'index.php?option='.$this->extension.'&task=edit&cid[]='. $id );
	}

	function getContentItemsQuery($where)
	{
		if(J_VERSION < 1.6) {
			$this->_buildWhere($where);

			// Get the articles
			$query = '(SELECT c.id AS id, c.title AS title, c.'.$this->state.' AS state, c.created AS created, c.ordering AS ordering,c.sectionid AS sectionid, c.catid AS catid,c.publish_up AS publish_up,c.publish_down AS publish_down,c.created_by_alias AS created_by_alias,c.created_by AS created_by,c.access AS access,c.checked_out AS checked_out, g.name AS groupname, cc.title AS cat_name, u.name AS editor, f.content_id AS frontpage, '.$this->section.' AS section_name, v.name AS author, fi.feed_id AS feedid, fg.title AS feed_title, fg.content_type AS content_type' .
					' FROM ' . $this->table . ' AS c' .
					' LEFT JOIN #__categories AS cc ON cc.id = c.catid' .
					' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
					' LEFT JOIN #__groups AS g ON g.id = c.access' .
					' LEFT JOIN #__users AS u ON u.id = c.checked_out' .
					' LEFT JOIN #__users AS v ON v.id = c.created_by' .
					' LEFT JOIN #__content_frontpage AS f ON f.content_id = c.id' .
					' LEFT JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '. $this->_db->Quote($this->extension) .
					' LEFT JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
					$where.')';
		} else {
			require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_content'.DS.'models'.DS.'articles.php');
			require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'plugins'.DS.'com_content'.DS.'contentmodel.php');
			$articlesModel = new ContentModelArticlesFG;
			$query = $articlesModel->getContentItems($where);
		}

		return $query;
	}

	function getFeedItems($where)
	{
		$this->_buildWhere($where);
		$query =	'SELECT fg.*, cc.title AS cat_name, '.$this->section.' AS section_name, u.name AS editor FROM #__feedgator fg'.
					' LEFT JOIN #__categories AS cc ON cc.id = fg.catid' .
					((J_VERSION < 1.6) ? ' LEFT JOIN #__sections AS s ON s.id = fg.sectionid' : '' ) .
					' LEFT JOIN #__users AS u ON u.id = fg.checked_out '.
					$where;
		$this->_db->setQuery($query);

		return $this->_db->loadObjectList();
	}

	function findDuplicates($type,$string)
	{
		// type can be id, alias, title or internal
		if($type == 'internal') { // for com_content we use the alias to find internal duplicates
			$this->getParams();
			$query =	'SELECT '. $this->_db->Quote($this->extension) .' AS content_type, fg.title AS feed_title,c.title,c.alias,COUNT(*) AS num,' .
						' GROUP_CONCAT(CONCAT_WS(\'|\',CONVERT(c.id,CHAR(11)),CONVERT(c.sectionid,CHAR(11)),CONVERT(c.catid,CHAR(11)),c.title) ORDER BY c.id ASC SEPARATOR \'||\') AS results' .
						' FROM ' . $this->table . ' AS c' .
						' INNER JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '. $this->_db->Quote($this->extension) .
						' INNER JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
						' WHERE (c.'.$this->state.' = 1 OR c.'.$this->state.' = 0)' .
						($this->params->get('ignore') ? ' AND c.id NOT IN ('.$this->params->get('ignore').')' : '' ).
						' GROUP BY alias' .
						' HAVING ( COUNT(*) > 1 )';
			return '('.$query.')';
		} else {
			// need to add per category checking
			$query = 	'SELECT id' .
						' FROM ' . $this->table .
						' WHERE '. $type .' = '. $this->_db->Quote($string) .
						' AND ('.$this->state.' = 1 OR '.$this->state.' = 0)';
			$this->_db->setQuery( $query );
			return $this->_db->loadResult();
		}
	}

	function getSectionList(&$fgParams)
	{
		if(J_VERSION < 1.6) {
			$query = 	'SELECT s.id, '.$this->section.
					' FROM #__sections AS s' .
					' WHERE s.alias != '.$this->_db->Quote('flexicontent') .
					' ORDER BY s.ordering';
			$this->_db->setQuery( $query );
			$sections = $this->_db->loadObjectList();
			$options[] = JHTML::_('select.option', -1, '- '.JText::_('Select Joomla Section').' -', 'id', 'title');
			$options = array_merge( $options, $sections );
		} else {
			$options[] = JHTML::_('select.option', -1, '- '.JText::_('J! 1.6 Doesn\'t Have Sections!').' -', 'id', 'title');
		}

		return $options;
	}

	function getCategoryList(&$fgParams)
	{
		$where = ' WHERE extension = \'com_content\' ';
		$order = '';
		$sectionid = 0;

		if(J_VERSION < 1.6) {
			$sectionid = $fgParams->get('sectionid');
			$order = ' ORDER BY ordering';

			if ( $sectionid == 0 ) {
				$where = ' WHERE section NOT LIKE \'%com_%\' ';
			} else {
				$where = ' WHERE section = '.(int)$sectionid.' ';
			}
		}
		//Joomla categories
		$query = 	'SELECT id, title' .
					' FROM #__categories' .
					$where .
					$order;
		$this->_db->setQuery( $query );
		$categories = $this->_db->loadObjectList();
	//	print_r($categories);

		if($sectionid == 0) {
			$options[] = JHTML::_('select.option', -1, JText::_( 'Select Joomla Category' ), 'id', 'title');
		} else {
			$options = array();
		}

		$options = array_merge( $options, $categories );

		return $options;
	}

	function getCatSelectLists($filter,&$fgParams)
	{
		$this->getData(); // ensure plugin loaded
		$prefix = $this->data->id.'_';

		$categories[] = JHTML::_('select.option', $prefix.'0', '- '.JText::_('Select Joomla Category').' -');

		// get list of categories for dropdown filter
		$query = 'SELECT CONCAT(\''.$prefix.'\', cc.id) AS value, cc.title AS text' . ((J_VERSION < 1.6) ? ', section' : '' ) .
				' FROM #__categories AS cc' .
				((J_VERSION < 1.6) ? ' INNER JOIN #__sections AS s ON s.id = cc.section ' : '' ) .
				$filter . // this is null except for Joomla sections
				((J_VERSION < 1.6) ? ' ORDER BY s.ordering, cc.ordering' : '' );
		$this->_db->setQuery($query);
		$categories = array_merge($categories,$this->_db->loadObjectList());

		return $categories;
	}

	function getSecSelectLists(&$fgParams)
	{
		$this->getData(); // ensure plugin loaded

		$sections[] = JHTML::_('select.option',  '-1', '- '. JText::_( 'Select Joomla Section' ) .' -' );

		if(J_VERSION < 1.6) {
			$query = 'SELECT id AS value, title AS text'
			. ' FROM #__sections'
			. ' WHERE published = 1'
			. ' AND scope = \'content\''
			. ' AND alias != '.$this->_db->Quote('flexicontent')
			. ' ORDER BY id'
			;
			$this->_db->setQuery( $query );
			$sections = array_merge( $sections, $this->_db->loadObjectList() );
		}

		return $sections;
	}

	function getFieldNames(&$content)
	{
		$query = 	'SELECT CONCAT_WS(\', \', s.title, c.title)' .
					' FROM #__categories AS c' .
					' LEFT JOIN #__sections AS s ON s.id = c.section' .
					' WHERE c.id = '. $this->_db->Quote($content['catid']);
		$this->_db->setQuery( $query );

		return $this->_db->loadResult();
	}

	function getSectionCategories(&$fgParams)
	{
		if(J_VERSION < 1.6) {
			$sectionid = $fgParams->get('sectionid');

			if ( $sectionid == 0 ) {
				$where = ' WHERE section NOT LIKE \'%com_%\' ';
			} else {
				$where = ' WHERE section = '.(int)$sectionid.' ';
			}

			$query = 	'SELECT s.id, '. $this->section .
						' FROM #__sections AS s ' .
						' ORDER BY s.ordering';
			$this->_db->setQuery( $query );
			$sections = $this->_db->loadObjectList();

			$sectioncategories 			= array();
			$sectioncategories[-1] 		= array();
			$sectioncategories[-1][] = JHTML::_('select.option', -1, JText::_( 'Select Category' ), 'id', 'title');

			foreach($sections as $section) {
				$sectioncategories[$section->id] = array();
				$query = 	'SELECT id, title' .
							' FROM #__categories' .
							' WHERE section = '.(int)$section->id .
							' ORDER BY ordering';
				$this->_db->setQuery( $query );
				$rows2 = $this->_db->loadObjectList();
				foreach($rows2 as $row2) {
					$sectioncategories[$section->id][] = JHTML::_('select.option', $row2->id, $row2->title, 'id', 'title');
				}
			}
		} else {
			$sectioncategories = array($this->sectionid => $this->getCategoryList($fgParams));
		}

		return $sectioncategories;
	}

	function save(&$content,&$fgParams)
	{
		if(!isset($this->row)) {
			$row = &JTable::getInstance('content');
			$this->row = $row;
		} else {
			$row = $this->row;
		}
		$dispatcher = &JDispatcher::getInstance();
		JPluginHelper::importPlugin('system');
		JPluginHelper::importPlugin('content');
		if (!$row->bind( $content )) {
			$content['mosMsg'] = $this->title . '***ERROR: bind' . $this->_db->getErrorMsg();
			return false;
		}
		$row->id = (int) $row->id;
		$isNew = ($row->id < 1);

		if(J_VERSION >= 1.6) {
			$row->featured = $fgParams->get('front_page');
			$row->language = '*';
		}

		$row->access = (J_VERSION < 1.6) ? ($fgParams->get('access') ? $fgParams->get('access') : 0) : $fgParams->get('access'); //J1.6 uses 1 for public…

		// Make sure the data is valid
		/*if (!$row->check()) {
			$e = '';
			foreach ($row->getErrors() as $error) {
				$e .= $error.'<br/>';
			}
			$content['mosMsg'] = '***ERROR*(check)*  Feed - '.$content['title'].':' . $this->_db->getErrorMsg().'<br/>'.$e;
			return false;
			//continue;
		}*/

		//set to hide introtext when viewing full article unless only making introtext
		$row->attribs = 'show_intro=0';
		if($fgParams->get('onlyintro')) {
			$row->attribs = '';
		}

		//Trigger OnBeforeContentSave
		if(J_VERSION < 1.6) {
			$result = $dispatcher->trigger( 'onBeforeContentSave', array(&$row, $isNew));
		} else {
			$result = $dispatcher->trigger( 'onContentBeforeSave', array('com_content',&$row, $isNew));
		}
		// Store the content to the database
		if(J_VERSION >= 1.6) {
			// Make sure the article does not already exist
			$exists = $this->findDuplicates('alias',$row->alias);
			$stored = false;
			if(!$exists) {
				$stored = $row->store();
			} elseif($fgParams->get('force_new') AND $row->load(array('alias'=>$content['alias'],'catid'=>$content['catid'])) AND ($row->id != $content['id'] OR $content['id']==0)) { // 1.6 won't let articles with same alias import!
				$datenow =& JFactory::getDate();
				$row->alias .= '_'.$datenow->toFormat("%Y-%m-%d-%H-%M-%S");
				$row->id = $content['id'];
				$row->state = (int)$fgParams->get('auto_publish');
				$stored = $row->store();
			}
		} else {
			$stored = $row->store();
		}
		if(!$stored) {
			if(J_VERSION >= 1.6 AND $exists) {
				$content['mosMsg'] = $this->title .' error saving '. $row->title . ' - article may already exist. ' . $this->_db->stderr();
				return false;
			} else {
				$content['mosMsg'] = $this->title . ' ***ERROR:' . $this->_db->stderr();
				return false;
			}
		}
		$content['id'] = $row->id;

		// Check the article and update item order
		//$row->checkin();
		//$row->reorder('catid = '.(int) $row->catid.' AND state >= 0');

		if(J_VERSION < 1.6) {
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_frontpage'.DS.'tables'.DS.'frontpage.php');
			$fp = new TableFrontPage($this->_db);
		} else {
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_content'.DS.'tables'.DS.'featured.php');
			$fp = new ContentTableFeatured($this->_db);
		}
			if ($fgParams->get('front_page')) {
				// Is the item already viewable on the frontpage?
				if (!$fp->load($row->id))
				{
					// Insert the new entry
					$query = 'INSERT INTO #__content_frontpage' .
							' VALUES ( '. (int) $row->id .', 1 )';
					$this->_db->setQuery($query);
					if (!$this->_db->query())
					{
						JError::raiseError( 500, $this->_db->stderr() );
						return false;
					}
					$fp->ordering = 1;
				}
				$fp->reorder();
			}
		//}

		//Trigger OnAfterContentSave
		if(J_VERSION < 1.6) {
			$dispatcher->trigger( 'onAfterContentSave', array(&$row, $isNew));
		} else {
			$dispatcher->trigger( 'onContentAfterSave', array('com_content',&$row, $isNew));
		}

		$cache = & JFactory::getCache('com_content');
		$cache->clean();

		FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),$content['id'],$this->extension,$fgParams);

		return true;
	}

	function reorder($catid,&$fgParams)
	{
		if(!$this->row) {
			$row = &JTable::getInstance('content');
			$this->row = $row;
		} else {
			$row = $this->row;
		}
		if($row->reorder('catid = '.(int) $catid.' AND state >= 0')) {
			return true;
		}
		return false;
	}

	function _buildWhere(&$where,$w=true)
	{
		if($this->state != 'state' AND strpos($where,'state') !== false) {
			$where = str_replace('state',$this->state,$where);
		}
		$a = ' AND ';
		$w = $w ? 'WHERE ' : '';
		$where ? $where .= $a.'fg.content_type = '.$this->_db->Quote($this->extension) : $where = $w.'fg.content_type = '.$this->_db->Quote($this->extension);
	}
}