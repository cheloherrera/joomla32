<?php

/**
* FeedGator Content Importing Plugin for K2 Content
* @version 1.7.3
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

class FeedgatorPluginK2
{
	// Title for use in menus etc
	var $title = 'K2 Content';
	// Name of extension that plugin enable FeedGator to save to
	var $extension = 'com_k2';
	// DB table to above extension
	var $table = '#__k2_items';
	// Name for "published' column in content items - com_content uses 'state'
	var $state = 'published';
	// Name for section column in content items or alias for section
	var $section = '<i>K2 Category</i>';
	// Section ID over-ride for content components without sections
	var $sectionid = null;
	// Object containing plugin data
	var $data = null;
	// JParameter object with plugin parameters
	var $params = null;

	function __construct()
	{
		$this->model = &FGFactory::getPluginModel();
		$this->model->setExt($this->extension);
		$this->_db = &JFactory::getDBO();
	}

	function setData($data)
	{
		$this->data = $data;
		$this->sectionid = -1*$this->data->id;
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
		if(J_VERSION < 1.6) {
			$components = JComponentHelper::_load();

			$return = (boolean)isset($components[$this->extension]);
		} else {
			$query	= $this->_db->getQuery(true);
			$query->select('extension_id AS "id", element AS "option", params, enabled');
			$query->from('#__extensions');
			$query->where('`type` = '.$this->_db->quote('component'));
			$query->where('`element` = '.$this->_db->quote($this->extension));
			$this->_db->setQuery($query);

			$component = $this->_db->loadObject();

			$return = $component ? (boolean)$component->enabled : false;
		}

		return $return;
	}

	function countContentItems($where)
	{
		$this->_buildWhere($where);
		// Get the total number of records specified by where clause
		$query = '(SELECT COUNT(*)' .
				' FROM ' . $this->table .' AS c' .
				' LEFT JOIN #__k2_categories AS cc ON cc.id = c.catid' .
		//		' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
				' LEFT JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '.$this->_db->Quote($this->extension) .' AND c.trash = 0' .
				' LEFT JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
				$where.')';
		return $query;
//		$this->_db->setQuery($query);
//		return $this->_db->loadResult();
	}

	function countContentQuery()
	{
		// Get the total number of records in range (added later)
		$query = 'SELECT COUNT(*)' .
				' FROM ' . $this->table .
				' WHERE id IN (%s)' .
				' AND trash = 0';
		return $query;
	}

	function getContentItem($id)
	{
		$query = 	'SELECT *' .
					' FROM ' . $this->table .
					' WHERE id = '. $this->_db->Quote($id) .
					' AND trash = 0';
		$this->_db->setQuery( $query );
		if(!$content = $this->_db->loadAssoc()) {
		    return false;
		}

		return $content;
	}

	function getContentLink($id)
	{
	    return JRoute::_( 'index.php?option='.$this->extension.'&view=item&cid='. $id );
	}

	function getContentItemsQuery($where)
	{
		$this->_buildWhere($where);
		$this->getData();
		// Get the articles
		$query = '(SELECT c.id AS id, c.title AS title, c.'.$this->state.' AS state, c.created AS created, c.ordering AS ordering,'.$this->_db->Quote($this->sectionid).' AS sectionid,c.catid AS catid,c.publish_up AS publish_up,c.publish_down AS publish_down,c.created_by_alias AS created_by_alias,c.created_by AS created_by,c.access AS access,c.checked_out AS checked_out, g.name AS groupname, cc.name AS cat_name, u.name AS editor, c.featured AS frontpage, '.$this->_db->Quote($this->section).' AS section_name, v.name AS author, fi.feed_id AS feedid, fg.title AS feed_title, fg.content_type AS content_type' .
				' FROM ' . $this->table . ' AS c' .
				' LEFT JOIN #__k2_categories AS cc ON cc.id = c.catid' .
		//		' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
				' LEFT JOIN #__groups AS g ON g.id = c.access' .
				' LEFT JOIN #__users AS u ON u.id = c.checked_out' .
				' LEFT JOIN #__users AS v ON v.id = c.created_by' .
		//		' LEFT JOIN #__content_frontpage AS f ON f.content_id = c.id' .
				' LEFT JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '. $this->_db->Quote($this->extension) .
				' LEFT JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
				$where.')';

		return $query;
	}

	function getFeedItems($where)
	{
		$this->_buildWhere($where);
		$query ='SELECT fg.*,cc.name AS cat_name, '.$this->_db->Quote($this->section).' AS section_name, u.name AS editor FROM #__feedgator fg'.
				' LEFT JOIN #__k2_categories AS cc ON cc.id = fg.catid'.
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
						' GROUP_CONCAT(CONCAT_WS(\'|\',CONVERT(c.id,CHAR(11)),'.$this->_db->Quote($this->section).',CONVERT(c.catid,CHAR(11)),c.title) ORDER BY c.id ASC SEPARATOR \'||\') AS results' .
						' FROM ' . $this->table . ' AS c' .
						' LEFT JOIN #__feedgator_imports AS fi ON fi.content_id = c.id AND fi.plugin = '. $this->_db->Quote($this->extension) .
						' LEFT JOIN #__feedgator AS fg ON fg.id = fi.feed_id' .
						' WHERE (c.'.$this->state.' = 1 OR c.'.$this->state.' = 0) AND trash = 0' .
						($this->params->get('ignore') ? ' AND c.id NOT IN ('.$this->params->get('ignore').')' : '' ).
						' GROUP BY alias' .
						' HAVING ( COUNT(*) > 1 )';
			return '('.$query.')';
		} else {
			$query = 	'SELECT id' .
						' FROM ' . $this->table .
						' WHERE '. $type .' = '. $this->_db->Quote($string) .
						' AND ('.$this->state.' = 1 OR '.$this->state.' = 0) AND trash = 0';

			$this->_db->setQuery( $query );
			return $this->_db->loadResult();
		}
	}

	function getSectionList(&$fgParams)
	{
		$options[] = JHTML::_('select.option', $this->sectionid, '- '.JText::_('Select K2 Category Below').' -', 'id', 'title');

		return $options;
	}

	function getCategoryList(&$fgParams)
	{
		//K2 categories
		$query = 	'SELECT id, name AS title' .
					' FROM #__k2_categories' .
					' WHERE published = 1 AND trash = 0' .
					' ORDER BY ordering';
		$this->_db->setQuery( $query );
		$categories = $this->_db->loadObjectList();

	 	if(!$categories) {
			$options = array(JHTML::_('select.option', -1, JText::_( 'K2 is not installed' ), 'id', 'title'));
	 	} else {
			$options = array(JHTML::_('select.option', -1, JText::_( 'Select K2 Category' ), 'id', 'title'));
			$options = array_merge( $options, $categories );
	 	}

	 	return $options;
	}

	function getCatSelectLists($filter,&$fgParams)
	{
		$this->getData(); // ensure plugin data loaded
		$prefix = $this->data->id.'_';

		$categories[] = JHTML::_('select.option', $prefix.'0', '- '.JText::_('Select K2 Category').' -');

		// get list of categories for dropdown filter
		$query = 'SELECT CONCAT(\''.$prefix.'\', cc.id) AS value, cc.name AS text, \''.$this->sectionid.'\' as section' .
				' FROM #__k2_categories AS cc' .
				$filter . // this is null except for Joomla sections
				' ORDER BY cc.ordering';
		$this->_db->setQuery($query);
		$categories = array_merge($categories,$this->_db->loadObjectList());

		return $categories;
	}

	function getSecSelectLists(&$fgParams)
	{
		$this->getData(); // ensure plugin data loaded

		$sections[] = JHTML::_('select.option', $this->sectionid, '- '.JText::_('K2 Section').' -', 'value', 'text');

		return $sections;
	}

	function getFieldNames(&$content)
	{
		//consider expanding this to contain parent categories also
		$query = "SELECT name FROM #__k2_categories WHERE id = ". $this->_db->Quote($content['catid']);
		$this->_db->setQuery( $query );

		return $this->_db->loadResult();
	}

	function getSectionCategories(&$fgParams)
	{
		// needs to have key set as the -ve plugin id if there are no sections
		return array($this->sectionid => $this->getCategoryList($fgParams));
	}

	function save(&$content,&$fgParams)
	{
		$k2_params = &JComponentHelper::getParams('com_k2');
		$dispatcher = &JDispatcher::getInstance();
		JPluginHelper::importPlugin('system');
		JPluginHelper::importPlugin('k2');

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'tables');
		if(!isset($this->row)) {
			$row = &JTable::getInstance('K2Item', 'Table');
			$this->row = $row;
		} else {
			$row = $this->row;
		}

		if (!$row->bind( $content )) {
			$content['mosMsg'] = $this->title . '***ERROR: bind' . $this->_db->getErrorMsg();
			return false;
		}
	//	$row->id = (int) $row->id;

		//cleaning
		if($k2_params->get('xssFiltering')){
            $filter = new JFilterInput(array(), array(), 1, 1, 0);
            $row->introtext = $filter->clean( $row->introtext );
            $row->fulltext = $filter->clean( $row->fulltext );
        }

        $row->ordering = $row->getNextOrder("catid = {$row->catid} AND trash = 0");
		if ($fgParams->get('front_page'))
        $row->featured_ordering = $row->getNextOrder("featured = 1 AND trash = 0", 'featured_ordering');

		// Make sure the data is valid
		if (!$row->check()) {
			$e = '';
			foreach ($row->getErrors() as $error) {
				$e .= $error.'<br/>';
			}
			$content['mosMsg'] = '***ERROR*(check)*  Feed - '.$content['title'].':' . $this->_db->getErrorMsg().'<br/>'.$e;
			return false;
			//continue;
		}

		//fix for different db column names
		$row->published = $content['state'];
		$row->access = (J_VERSION < 1.6) ? ($fgParams->get('access') ? $fgParams->get('access') : 0) : $fgParams->get('access'); //J1.6 uses 1 for public…
		if ($fgParams->get('front_page')) {
			$row->featured = 1;
		}

		//set to hide introtext when viewing full article unless only making introtext
		$row->params = 'itemIntroText=0';
		if($fgParams->get('onlyintro')) {
			$row->params = '';
		}

		//consider adding K2 tag support

		$isNew = 1;

        $result = $dispatcher->trigger('onBeforeK2Save', array(&$row, $isNew));
        if (in_array(false, $result, true)) {
            $content['mosMsg'] = $this->title . '***ERROR:' . $row->getError();
			return false;
        }

    	if (version_compare(phpversion(), '5.0') < 0) {
			$tmpRow = $row;
		}
		else {
			$tmpRow = clone($row);
		}

        if (!$row->store()) {
            $content['mosMsg'] = $this->title . '***ERROR:' . $this->_db->stderr();
			return false;
        }
		$content['id'] = $row->id;
        $row = $tmpRow;
        $row->id = $content['id'];

        //$row->checkin();

        $cache = &JFactory::getCache('com_k2');
        $cache->clean();

        $dispatcher->trigger('onAfterK2Save', array(&$row, $isNew));

		FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),$content['id'],$this->extension,$fgParams);

		return true;
	}

	function reorder($catid,&$fgParams)
	{
		$k2_params = &JComponentHelper::getParams('com_k2');

		if(!$this->row) {
			$row = &JTable::getInstance('content');
			$this->row = $row;
		} else {
			$row = $this->row;
		}
		if(!$k2_params->get('disableCompactOrdering'))
        	$row->reorder('catid = '.(int)$catid.' AND trash = 0');

        if ($fgParams->get('front_page') AND !$k2_params->get('disableCompactOrdering'))
            $row->reorder('featured = 1 AND trash = 0', 'featured_ordering');
        return true;
	}

	function _buildWhere(&$where)
	{
		if($this->state != 'state' AND strpos($where,'state') !== false) {
			$where = str_replace('state',$this->state,$where);
		}
		$where ? $where .= ' AND fg.content_type = '.$this->_db->Quote($this->extension) : $where = 'WHERE fg.content_type = '.$this->_db->Quote($this->extension);
	}
}