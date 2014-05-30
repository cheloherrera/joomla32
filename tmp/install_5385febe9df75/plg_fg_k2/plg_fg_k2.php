<?php

/**
* FeedGator K2 Importing Plugin
* @version 1.9.3
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_feedgator/tables');
JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/tables');
jimport('joomla.plugin.plugin');

class plgFeedgatorK2 extends JPlugin
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
		$jlang = JFactory::getLanguage();
		$jlang->load('plg_fg_k2', JPATH_ADMINISTRATOR, 'en-GB', true);

		$this->_db = JFactory::getDbo();
		$this->model = FGFactory::getPluginModel();
		$this->model->setExt($this->extension);
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

	function &getParams($feedId = -1,$force = false)
	{
		if(!$this->params OR $force) {
			$this->params = new JParameter($this->model->getParams($feedId), $this->model->getFilePath() );
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

	/**
	* This function is necessary to prevent strict errors with Joomla JTable::isCheckedOut being called statically by JHtml::('grid.checkedout',$row,$i)
	*/
	function bindContent(&$row)
	{
		$nrow = JTable::getInstance('K2Item', 'Table');
		$nrow->bind($row);

		return $nrow;
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
		$query = '(SELECT c.id AS id, c.title AS title, c.'.$this->state.' AS state, c.created AS created, c.ordering AS ordering,'.$this->_db->Quote($this->sectionid).' AS sectionid,c.catid AS catid,c.publish_up AS publish_up,c.publish_down AS publish_down,c.created_by_alias AS created_by_alias,c.created_by AS created_by,c.access AS access,c.checked_out AS checked_out, g.title AS groupname, cc.name AS cat_name, u.name AS editor, c.featured AS frontpage, '.$this->_db->Quote($this->section).' AS section_name, v.name AS author, fi.feed_id AS feedid, fg.title AS feed_title, fg.content_type AS content_type' .
				' FROM ' . $this->table . ' AS c' .
				' LEFT JOIN #__k2_categories AS cc ON cc.id = c.catid' .
		//		' LEFT JOIN #__sections AS s ON s.id = c.sectionid' .
				' LEFT JOIN #__viewlevels AS g ON g.id = c.access' .
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

	function findDuplicates($type,$string,$catid = null)
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
			$query = 	'SELECT c.id' .
						' FROM ' . $this->table .' AS c' .
				//		' INNER JOIN #__k2_categories AS cc ON cc.id = c.'.(int)$catid .
						' WHERE c.'. $type .' = '. (($type == 'id') ? (int)$string : $this->_db->Quote($string)) .
						' AND c.catid = '.(int)$catid .
						' AND (c.'.$this->state.' = 1 OR c.'.$this->state.' = 0) AND c.trash = 0';

			$this->_db->setQuery( $query );
			return $this->_db->loadResult();
		}
	}

	function getSectionList(&$fgParams,$default=false)
	{
		$options[] = JHTML::_('select.option', $this->sectionid, '- '.JText::_('Select K2 Category Below').' -', 'id', 'title');

		return $options;
	}

	function getCategoryList(&$fgParams,$default=false)
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
	 		if($default) {
				$options[] = JHTML::_('select.option', '', JText::_( 'Use Default' ), 'id', 'title');
			} else {
				$options = array(JHTML::_('select.option', -1, JText::_( 'Select K2 Category' ), 'id', 'title'));
			}
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

	function getSectionCategories(&$fgParams,$default=false)
	{
		// needs to have key set as the -ve plugin id if there are no sections
		return array($this->sectionid => $this->getCategoryList($fgParams,$default));
	}

	function addDefaultImage($position,&$content,&$fgParams,$img = null)
	{
		$this->getParams();

		if($img) {
		//to allow an over-ride
			//$img = '<img src="'.JURI::root().'/media/feedgator/images/feeds/'.$fgParams->get('feed_img').'" class="fgFeedImg" alt="'.$fgParams->get('title').'" />';
			//$content['default_img'] = $img;
			//need to add image to top of stack
			//array_unshift($content['images']['stack'],array('src'=>$src));
		} else {
			if($fgParams->get('feed_img')) {
				FeedgatorUtility::profiling('Adding Default Image');

				$base = $fgParams->get('rel_src',0) ? '/' : str_replace('administrator/','',JURI::base());
				$src = 'media/feedgator/images/feeds/'.$fgParams->get('feed_img');
				$savepath = JPATH_ROOT.'/'.$src;
				$img = '<img src="'.$base.$src.'" class="fgFeedImg" alt="'.$fgParams->get('title').'" />';
				$content['default_img'] = $src;
				$content['default_img_html'] = $img;

				//need to add image to top of stack
				array_unshift($content['images']['stack'],array('src'=>$src,'savepath'=>$savepath));

				if(!$this->params->get('save_k2_image')) {
					switch($position)
					{
						case 'introtext':
							$content['introtext'] = $content['default_img_html'].$content['introtext'];
						break;

						case 'both':
							$content['introtext'] = $content['default_img_html'].$content['introtext'];
							$content['fulltext'] = $content['default_img_html'].$content['fulltext'];
						break;

						default:
						break;
					}
				}
			}
		}
	}

	/*
	* $image is an array with filename, src, and savepath to image file on local server
	*/
	function saveImages($image,$id,&$content,&$fgParams)
	{
		$this->getParams($fgParams->get('id'));

		//only save first image
		if($id OR !$this->params->get('save_k2_image')) {
			FeedgatorUtility::profiling('Not Saving K2 Image');
			return false;
		}

		jimport('joomla.filesystem.file');

		$uPath	= JPATH_ADMINISTRATOR.'/components/com_k2/lib/class.upload.php';
		if (!class_exists('Upload') && is_file($uPath)) {
			require_once($uPath);
		}

		$k2params = JComponentHelper::getParams('com_k2');

		$handle = new Upload($image['savepath']);
		$handle->allowed = array('image/*');

		if ($handle->uploaded)
		{
			FeedgatorUtility::profiling('Saving K2 Image');

			//Image params
			$category = JTable::getInstance('K2Category', 'Table');
			$category->load($fgParams->get('catid'));
			$cparams = new JParameter($category->params);

			if ($cparams->get('inheritFrom'))
			{
				$masterCategoryID = $cparams->get('inheritFrom');
				$query = "SELECT * FROM #__k2_categories WHERE id=".(int)$masterCategoryID;
				$this->_db->setQuery($query, 0, 1);
				$masterCategory = $this->_db->loadObject();
				$cparams = new JParameter($masterCategory->params);
			}

			$k2params->merge($cparams);

			//Original image
			$savepath = JPATH_SITE.'/media/k2/items/src';
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 100;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = md5("Image".$content['id']);
			$handle->Process($savepath);

			$filename = $handle->file_dst_name_body;
			$savepath = JPATH_SITE.'/media/k2/items/cache';

			//XLarge image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_XL';
			if (JRequest::getInt('itemImageXL'))
			{
				$imageWidth = JRequest::getInt('itemImageXL');
			}
			else
			{
				$imageWidth = $k2params->get('itemImageXL', '800');
			}
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//Large image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_L';
			if (JRequest::getInt('itemImageL'))
			{
				$imageWidth = JRequest::getInt('itemImageL');
			}
			else
			{
				$imageWidth = $k2params->get('itemImageL', '600');
			}
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//Medium image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_M';
			if (JRequest::getInt('itemImageM'))
			{
				$imageWidth = JRequest::getInt('itemImageM');
			}
			else
			{
				$imageWidth = $k2params->get('itemImageM', '400');
			}
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//Small image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_S';
			if (JRequest::getInt('itemImageS'))
			{
				$imageWidth = JRequest::getInt('itemImageS');
			}
			else
			{
				$imageWidth = $k2params->get('itemImageS', '200');
			}
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//XSmall image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_XS';
			if (JRequest::getInt('itemImageXS'))
			{
				$imageWidth = JRequest::getInt('itemImageXS');
			}
			else
			{
				$imageWidth = $k2params->get('itemImageXS', '100');
			}
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//Generic image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = $k2params->get('imagesQuality');
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename.'_Generic';
			$imageWidth = $k2params->get('itemImageGeneric', '300');
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			//remove the FeedGator uploaded image unless it is the feed default image!
			if(strpos($image['src'],'media/feedgator/images/feeds/') === false) {
				FeedgatorUtility::profiling('K2 Plugin Removing FeedGator Uploaded Image');
				JFile::delete($image['savepath']);
			}

			return $savepath.$filename.'.jpg';
		} else {
			FeedgatorUtility::profiling('Error Saving K2 Image: '.$handle->error);

			return false;
		}
	}

	function save(&$content,&$fgParams)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');
		require_once (JPATH_ADMINISTRATOR.'/components/com_k2/lib/class.upload.php');

		$this->getParams($fgParams->get('id'));

		$k2_params = JComponentHelper::getParams('com_k2');
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('system');
		JPluginHelper::importPlugin('k2');

		// remove image that is going to be uploaded as K2 image
		if($this->params->get('save_k2_image')) {
			$content['introtext'] = preg_replace('/<img[^>]*?src="'.str_replace('/','\/',$content['images']['stack'][0]['src']).'"[^>]*>/','',$content['introtext']);
			$content['fulltext'] = preg_replace('/<img[^>]*?src="'.str_replace('/','\/',$content['images']['stack'][0]['src']).'"[^>]*>/','',$content['fulltext']);
		}
//echo '<pre>';
//print_r($content);
//jexit();
		if(!isset($this->row)) {
			$row = JTable::getInstance('K2Item', 'Table');
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
		if ($fgParams->get('front_page')) {
			$row->featured_ordering = $row->getNextOrder("featured = 1 AND trash = 0", 'featured_ordering');
		}

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

		$isNew = 1;

        $result = $dispatcher->trigger('onBeforeK2Save', array($row, $isNew));
        if (in_array(false, $result, true)) {
            JError::raiseError( $this->title . '***ERROR:' , $row->getError());
			return false;
        }

    	if (version_compare(phpversion(), '5.0') < 0) {
			$tmpRow = $row;
		}
		else {
			$tmpRow = clone($row);
		}

        if (!$row->store()) {
            JError::raiseError( $this->title . '***ERROR:' , $this->_db->stderr());
			return false;
        }
		$content['id'] = $row->id;
        $row = $tmpRow;
        $row->id = $content['id'];

		//push images in the stack for final handling
		foreach($content['images']['stack'] as $k => $image) {
			$this->saveImages($image,$k,$content,$fgParams);
		}

		if($this->params->get('save_tags')) {
			$this->saveTags($content['id'],$content['metakey']);
		}

        $cache = JFactory::getCache('com_k2');
        $cache->clean();

        $dispatcher->trigger('onAfterK2Save', array($row, $isNew));

		FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),$content['id'],$this->extension,$fgParams);

		return true;
	}

	function reorder($catid,&$fgParams)
	{
		$k2_params = JComponentHelper::getParams('com_k2');

		if(!$this->row) {
			$row = JTable::getInstance('content');
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

	//Adapted from solution by Mahir mahir78[at]gmail.com
	function saveTags($cid,$metakey)
	{
		if($metakey=='')return;
		$tags=explode(",",$metakey);
		if(count($tags)>0){
			foreach($tags as $tag){

				$query="select id,name from #__k2_tags where name='".trim($tag)."'";
				$this->_db->setQuery($query);
				$component = $this->_db->loadObject();
				if($component){
					$tagid=$component->id;
				}
				elseif($this->params->get('add_tags')) {
					$query="insert into #__k2_tags(name,published) values('".trim($tag)."',1)";
					$this->_db->setQuery($query);
					$this->_db->query();
					$tagid=$this->_db->insertid();
				}

				if(isset($tagid)) {

					$query="insert into #__k2_tags_xref(tagID,itemID) values(".$tagid.",".$cid.")";
					$this->_db->setQuery($query);
					$this->_db->query();

					//This doesn't work don't know the reason
					//$query="update #__k2_items set catid=(select (case when count(id)>0 then id else 1 end) id from #__k2_categories where name='".trim($tag)."') where id=".$cid;
					//echo $query;
					//$this->_db->setQuery( $query );
					//$this->_db->query();

					unset($tagid);
				}
			}
		}
	}
}