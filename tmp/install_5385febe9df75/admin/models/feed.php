<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JPluginHelper::importPlugin( 'feedgator' );
jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorModelFeed extends JModel
{
	var $_id = null; // feed id
	var $_data = null; // per feed data
	var $_imports = null; // per feed imports
	var $_plugin = null; // per feed plugin
	var $_params = null; // per feed params
	var $_defaultParams = null; // global feed params
	var $_defaultParamData = null; // global feed default data

	function __construct()
	{
		parent::__construct();

		if(in_array(JRequest::getWord('task'),array('new','add'))) {
			$this->setId(0);
		} else {
			$array	= JRequest::getVar('cid', array(0), '', 'array');
			if($array[0]) {
				$this->setId((int)$array[0]);
			}
		}
	}

	function setId($id,$force=false)
	{
		if($id != $this->_id OR $force == true) {
			$this->_id				= $id;
			$this->_data			= null;
			$this->_imports			= null;
			$this->_plugin			= null;
			$this->_params			= null;
			$this->_defaultParams	= null;
		}
	}

	function &getData()
	{
		$this->_loadData();

		return $this->_data;
	}

	function &getImports()
	{
		$this->_loadImports();
		return $this->_imports;
	}

	function &getParams($defaults = false)
	{
		if(!$this->_params) {
			// get $fgConfig
			$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'views'.DS.'feedgator'.DS.'tmpl'.DS.'default_feed.xml';
			$fg = JComponentHelper::getComponent('com_feedgator');
			$fgParams = new JParameter($fg->params, $xmlfile);
			if((int)$fgParams->get('default_type') OR (int)$fgParams->get('content_type')) $fgParams->set('content_type','com_content');
			if($this->getData()) {
				$tmpParams = (J_VERSION < 1.6) ? FeedgatorUtility::parseINIString($this->_data->params) : json_decode($this->_data->params,true);
				$tmpParams = array_merge($tmpParams,(array)$this->_data);
				if($defaults) {
					$tmpParams = FeedgatorUtility::array_overlay($tmpParams,$this->getDefaultParamData());
				}
				unset($tmpParams['params']);

				$fgParams->bind($tmpParams);
			}

			$this->_params = $fgParams;
		}

		return $this->_params;
	}

	function &getDefaultParams()
	{
		if(!$this->_defaultParams) {
			$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'views'.DS.'feedgator'.DS.'tmpl'.DS.'default_feed.xml';
			$fg = JComponentHelper::getComponent('com_feedgator');
			$fgParams = new JParameter($fg->params,$xmlfile);
			$defParamData = $this->getDefaultParamData();
			$fgParams->bind($defParamData);
			$this->_defaultParams = $fgParams;
		}

		return $this->_defaultParams;
	}

	// returns array of params for merging with JParameter object
	function &getDefaultParamData()
	{
		if(!$this->_defaultParamData) {
			$this->_loadData(-2);
			$defaultParams = (J_VERSION < 1.6) ? FeedgatorUtility::parseINIString($this->_defaultData->params) : json_decode($this->_defaultData->params,true);
			$defaultParams = array_merge($defaultParams,(array)$this->_defaultData);
			unset($defaultParams['params']);
			$this->_defaultParamData = $defaultParams;
		}
		return $this->_defaultParamData;
	}

	function _setFolderParams($preview,&$fgParams)
	{
		if(in_array(JRequest::getWord('task'),array('import','importall','cron','fgautomator'))) {
			switch($fgParams->get('sub_folder',0)) {
				case 0: $sub = ''; break;
				case 1: $sub = 'daily/'.gmdate('Y/m/d/'); break; //day
				case 2: $sub = 'weekly/'.gmdate('Y/W/'); break; //week
				case 3: $sub = 'monthly/'.gmdate('Y/m/'); break; //month
			}
			$fgParams->set('img_folder',$fgParams->get('img_folder','media/feedgator/images/').$sub);
			$fgParams->set('img_srcpath',($fgParams->get('rel_src',0) ? ($preview ? '../' : '') : $fgParams->get('base')).$fgParams->get('img_folder'));
			$fgParams->set('img_savepath',JPATH_ROOT.DS.JFolder::makeSafe( str_replace('/',DS,$fgParams->get('img_folder'))) );
			$fgParams->set('srcpath',($fgParams->get('rel_src',0) ? ($preview ? '../' : '') : $fgParams->get('base')).$fgParams->get('media_folder','media/feedgator/'));
			$fgParams->set('savepath',JPATH_ROOT.DS.JFolder::makeSafe( str_replace('/',DS,$fgParams->get('media_folder','media/feedgator/'))) );
		}
	}

	function &getPlugin($ext = null, $preview = false)
	{
	//this must be an error
		$fgParams = $this->getParams();
		if(!$ext) {
			$ext = $fgParams->get('content_type') ? $fgParams->get('content_type') : '- '.JText::_('Content Type Not Set');
		}

		$pluginModel = FGFactory::getPluginModel();
		$this->_plugin = $pluginModel->getPlugin($ext);
		if(!isset($this->_plugin->title)) {
			$this->_plugin = new stdClass();
			$this->_plugin->errorMsg = JText::_('Unable to load plugin') ." $ext.";
		} elseif(!@$this->_plugin->data->published) {
			$this->_plugin->errorMsg = JText::_('Plugin not published for') ." $ext.";
		}
		return $this->_plugin;
	}

	function isCheckedOut( $uid=0 )
	{
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	function checkin()
	{
		if ($this->_id) {
			$feed = JTable::getInstance('Feed','Table');

			if(! $feed->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());

				return false;
			}
		}
		return false;
	}

	function checkout($uid = null)
	{
		if ($this->_id) {
			if (is_null($uid)) {
				$user	= JFactory::getUser();
				$uid	= $user->get('id');
			}

			$feed = JTable::getInstance('Feed','Table');
			if(!$feed->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

	function store($post)
	{
		$row = JTable::getInstance('Feed','Table');

		$post['id'] 		= $this->_id;
		$post['params'] 	= (J_VERSION < 1.6) ? FeedgatorUtility::makeINIString($post['params']) : json_encode($post['params']);
		$post['created'] 	= gmdate('Y-m-d H:i:s');

		foreach($post as $k => $v) {
			if($v == '') {
				$post[$k] = null;
			}
		}

		if($this->_id == -2 AND !$this->_loadData(-2)) {
			$this->_db->setQuery( 'INSERT INTO #__feedgator (id) VALUES (-2)' );
			$this->_db->query();
		}

		if (!$row->save($post)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	function copy($cid = array())
	{
		$user 	= JFactory::getUser();

		$row = JTable::getInstance('Feed','Table');
		$now = gmdate('Y-m-d H:i:s');

		if (count( $cid )) {
			foreach($cid as $id) {
				$row->load($id);
				$row->id 		= 0;
				$row->title		= 'Copy of '.$row->title;
				$row->created 	= $now;
				$row->imports	= '';
				if(!$row->save($row)) {
					return false;
				}
			}
		}

		return true;
	}

	function delete($cid = array())
	{
		$result = false;

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'DELETE FROM #__feedgator'
			. ' WHERE id IN ( '.$cids.' )';

			$this->_db->setQuery( $query );

			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());

				return false;
			}
		}

		return true;
	}

	function publish($cid = array(), $publish = 1)
	{
		$user 	= JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__feedgator'
			. ' SET published = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'
			. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;

			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());

				return false;
			}
		}
		return true;
	}

	function frontpage($cid = array(), $frontpage = 1)
	{
		$user 	= JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__feedgator'
			. ' SET front_page = '.(int) $frontpage
			. ' WHERE id IN ( '.$cids.' )'
			. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;

			$this->_db->setQuery( $query );

			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());

				return false;
			}
		}
		return true;
	}

	function import($formData,$preview,$update)
	{
		global $fgParams, $p; // temporary fix for cron issue

		$dispatcher = JDispatcher::getInstance();
		$fgConfig = JComponentHelper::getParams ('com_feedgator');
		$tzOffset = JFactory::getConfig()->getValue('config.offset');
		$task = JRequest::getWord('task','');

		$mosMsg = '';
		$initTime = JFactory::getDate('now', $tzOffset)->toFormat('D F j, Y, H:i:s T');

		$adminMsg = '';
		$feedMsg = '';
		$innerMsg = '';
		$feedsProc = 0;
		$totTime = 0;
		$totItems = 0;

		$cacheDir = JPATH_ROOT.DS.'cache';
		$cache_exists = ( !$fgConfig->get('use_sp_cache') OR !is_writable( $cacheDir ) ) ? false : true;

		if(!ini_get('allow_url_fopen')) ini_set('allow_url_fopen', 1); //allows importing images and text

		//process each feed
		foreach($formData as $feedId) {
			FeedgatorUtility::profiling('Start Process Feed: '.$feedId);
			$addItems = 0;
			$procItems = 0;
			$errors = array();
			$this->setId($feedId);
			// gets params with defaults overloaded
			$fgParams = $this->getParams(true);
			$fgParams->set('preview',$preview);
		//	echo '<pre>';
		//	jexit(print_r($fgParams));
			$this->_setFolderParams($preview,$fgParams);

			if ( !$fgParams->get('published') ) return JText::_('Feed Not Published');
			if (get_magic_quotes_gpc()){
				$fgParams->set('feed',stripslashes($fgParams->get('feed',true)));
			}

			// if cron check if should continue based on feed processing interval
			if($task == 'cron' OR $task == 'fgautomator') {
				$now = JFactory::getDate();

				if($last = $fgParams->get('last_run')) {
					$last = JFactory::getDate($last);
					$diff = $now->toUnix() - $last->toUnix();
				} else {
					$diff = -1;
				}

				if ($diff < 0 OR $diff > ( ($task == 'cron') ? $fgParams->get('cron_interval')*60 : $fgParams->get('pseudocron_interval')*60 ) ) {
					$doImport = 1;
				} else {
					$doImport = 0;
				}
			} else {
				$doImport = 1;
			}

			if($doImport) {
				$startTime = round(microtime(true),2);
				// attempt to stop timeouts and errors stopping all imports in cron/pseudo-cron
				try {
					// load internal plugin
					$this->getPlugin(null,$preview);
					if(isset($this->_plugin->errorMsg)) {
						return $this->_plugin->errorMsg;
					}

					// process the feed with SimplePie
					$rssDoc = new SimplePieFG();
					$rssDoc->set_input_encoding('utf-8');
					if($fgParams->get('feed_encoding')) {
						$rssDoc->set_input_encoding($fgParams->get('feed_encoding'));
					}
					$rssDoc->set_feed_url($fgParams->get('feed'));
					if ($fgParams->get('force_fsockopen')) {
						$rssDoc->force_fsockopen(true);
					}
					if($cache_exists) {
						$rssDoc->set_cache_location($cacheDir);
						$rssDoc->enable_cache(true);
						$rssDoc->set_cache_duration(60 * SPIE_CACHE_AGE);
					} else {
						$rssDoc->enable_cache(false);
					}
					$rssDoc->set_stupidly_fast(true);
					$rssDoc->enable_order_by_date(true);
					if($fgParams->get('set_sp_timeout')) {
						$rssDoc->set_timeout((int)$fgParams->get('set_sp_timeout'));
					}
					try {
						$rssDoc->init();
					}
					catch(Exception $e)
					{
						$feedsProc++;
						$feedMsg .= '<b>Feed import failed with error: '.$e->getMessage().'</b>';
						continue;
					}

					//$rssDoc->handle_content_type();
					if ($rssDoc->get_type() & SIMPLEPIE_TYPE_NONE) {
						return JText::sprintf('FG_UNABLE_TO_PROCESS',$fgParams->get('title').' ('.$fgParams->get('feed').')');
					} elseif($rssDoc->error) {
						return 'SimplePie error: '.$rssDoc->error.' for '.$fgParams->get('title').' ('.$fgParams->get('feed').')';
					} else {
						$channelTitle = $rssDoc->get_title();
						$itemArray = $rssDoc->get_items();

						if (is_array($itemArray)) {
							$num = count($itemArray)-1;
							for($i=$num;$i>=0;$i--) { //traverse items backwards to get the oldest item first
							//if($i == 1) break;
								$item = &$itemArray[$i];
								if($task == 'fgautomator') {
									$process = (boolean)(!$fgParams->get('pseudocron_import_limit',1) OR $addItems < $fgParams->get('pseudocron_import_limit',1));
								} elseif($task == 'cron') {
									$process = (boolean)(!$fgParams->get('cron_import_limit') OR $addItems < $fgParams->get('cron_import_limit'));
								} else {
									$process = (boolean)(!$fgParams->get('import_limit') OR $addItems < $fgParams->get('import_limit'));
								}
								if($process) {
									FeedgatorUtility::profiling('Start Process SimplePie Items: '.$item->get_id());
									$procItems++;
									if(!$content = FeedgatorHelper::processFeedItem($item,$fgParams,$this->_plugin,$this->_id,$channelTitle,$preview,$update)) {
										if($procItems == $num) {
											//preview new article has failed so show the first one in the stack
											FeedgatorUtility::profiling('Force Preview of Next Item');
											$i = $num+1;
										}
										continue; // move to next item if no content generated
									}
									if(!$update AND $fgParams->get('create_art',1)) {
										//onBeforeFGSaveArticle -> $content contains the full article ready to save
								        $results = $dispatcher->trigger( 'onBeforeFGSaveArticle', array( $content, $fgParams) );

										if($preview) return FeedgatorHelper::getPreviewArticle($content,$fgParams,$channelTitle); // generate preview

										FeedgatorUtility::profiling('Start Save Content Item');
										// changed behaviour to stop errors quitting the processing of feed items
										if($this->_saveArticle($content,$fgParams)) {
											$addItems++;
										} else {
											$errors[] = $content['mosMsg'];
										}
										FeedgatorUtility::profiling('End Save Content Item');

										//onAfterFGSave -> $content contains the full article after saving with the new ID if applicable
								        $results = $dispatcher->trigger( 'onAfterFGSaveArticle', array( $content, $fgParams) );
									}
								}
								unset($content);
								if($i==0 AND $fgParams->get('create_art',1)) {
									$this->_plugin->reorder($fgParams->get('catid'),$fgParams);
								}
							}
						}
					} // end SimplePie processing
					FeedgatorUtility::profiling('End Process SimplePie Items');
					$rssDoc->__destruct();
					unset($itemArray,$rssDoc);
					FeedgatorUtility::profiling('Destroy SimplePie');

					// update last_run status
					$last_run = gmdate('Y-m-d H:i:s');
					$procTime = round(microtime(true),2) - $startTime;

					if(!$update) {
						if($fgParams->get('imports')) {
							$imports = explode(',',$fgParams->get('imports'));
							$imports[0] += $addItems;
							$imports[1] += $procItems;
							$imports[2] += $procTime;
							if(!$imports[3]) $imports[3] = $channelTitle;
						} else {
							if(!isset($imports)) $imports = array(0,0,0,'');
							$imports[0] += $addItems;
							$imports[1] += $procItems;
							$imports[2] += $procTime;
							$imports[3] = $channelTitle;
						}
						$this->_db->setQuery( 'UPDATE #__feedgator SET last_run = '.$this->_db->Quote($last_run).',imports = '.$this->_db->Quote(implode(',',$imports)).' WHERE id = '.(int)$feedId );
						$this->_db->query();
					}

					$feedMsg .= sprintf('<b>%d</b> new content item(s) imported (<i>%d processed</i>) in %ds for <b>%s</b> (%s).',$addItems,$procItems,$procTime,$fgParams->get('title'),$channelTitle);
					$feedMsg .= $fgParams->get('filtering') ? 'This feed import was filtered.<br />' : '<br />';
					$feedMsg .= !empty($errors) ? implode('<br/>',$errors).'<br />' : '';

					$feedsProc++;
					$totTime += $procTime;
					$totItems += $addItems;

					FeedgatorUtility::profiling('End Process Feed: '.$feedId);
					if($fgParams->get('debug')) {
						FeedgatorUtility::log(var_export($p->getBuffer()));
						if(J_VERSION < 1.6) unset($p->_buffer);
					}
				}
				catch(Exception $e)
				{
					$feedsProc++;
					$feedMsg .= '<b>Feed import failed with error: '.$e->getMessage().'</b>';
					continue;
				}
			}
		} // end foreach($formData as $feedId)

		if (!$feedsProc) {
			$adminMsg .= 'Nothing to process. Check your settings.';
			return $adminMsg;
		}

		$ajax = JRequest::getInt('ajax',0,'get');
		if ($fgConfig->get('email_admin')) {
			FeedgatorUtility::profiling('Process For Admin Email');
			$eProc = 0;
			$eItems = 0;
			$eTime = 0;
			$eMsg = '';
			// check for digest mode, compile email if necessary and then update imports/last sent status
			$last = (boolean)($ajax AND JRequest::getInt('last',0,'get'));
			if($fgConfig->get('email_digest',1) AND ($last OR $task == 'cron')) {
				$query = 'SELECT * FROM #__feedgator WHERE published = 1';
				$this->_db->setQuery($query);
				$rows = $this->_db->loadObjectList();
				$now = time();
				FeedgatorUtility::profiling('Process Digest Email');
				foreach($rows as &$row) {
					if(($last OR ($now >= ($row->last_email + ((int)$fgConfig->get('digest_period','24') *3600)))) AND $row->imports ) {
						$in[] = $row->id;
						$digest = explode(',',$row->imports); // imports contains $addItems,$procItems,$procTime,$channelTitle;
						if($fgConfig->get('send_if_null') OR $digest[0]) {
							$eMsg .= sprintf('<b>%d</b> new content item(s) imported (<i>%d processed</i>) in %ds for <b>%s</b> (%s). ',$digest[0],$digest[1],$digest[2],$row->title,$digest[3]);
							$eMsg .= $row->filtering ? 'This feed import was filtered.<br />' : '<br />';
							//$eMsg .= 'Now:'.$now.' Last email:'.($row->last_email + ((int)$fgConfig->get('digest_period','24') *360));
						}
						$eItems += $digest[0];
						$eTime += $digest[2];
						$eProc++;
					}
				}
				FeedgatorUtility::profiling('End Process Digest Email');
			}
			if (($eItems OR $fgConfig->get('send_if_null')) AND (!$fgConfig->get('email_digest',1) OR ($fgConfig->get('email_digest',1) AND isset($digest)))) {
				$exitTime  = JFactory::getDate('now', $tzOffset)->toFormat('D F j, Y, H:i:s T');
				$adminMsg .= ( $fgConfig->get('email_digest',1) ? '<b>Feed Gator import digest report:</b>' : '<b>Results of the last Feed Gator import run:</b>')."\n\n";
				$adminMsg .= '<div id="feedinfo">'.($fgConfig->get('email_digest',1) ? '' : '<h1>START Feed Gator Import Processing: '.$initTime.'</h1>')."\n";
				$adminMsg .= '<span class="feedmsg">' . (isset($eMsg) ? $eMsg : $feedMsg) . "</span>\n";
				$adminMsg .= ($fgConfig->get('email_digest',1) ? '' : '<h1>END: '.$exitTime.'</h1>').'</div>'."\n";
				$adminMsg .= sprintf('<h2>%d content items imported in %d seconds (%d feeds processed)</h2>',$eItems,$eTime,$eProc);
				$adminMsg .= $ajax ? "\n".'<h4>May include imports which have not been notified by email earlier</h4>' : '';
				if(FeedgatorUtility::sendAdminEmail($adminMsg)) {
					$in = isset($in) ? implode(',',$in) : implode(',',$formData);
					$this->_db->setQuery( 'UPDATE #__feedgator SET last_email = '.$this->_db->Quote(time()).',imports = '.$this->_db->Quote('').' WHERE published = 1 AND id IN ('.$in.')');
					$this->_db->query();
				}
				FeedgatorUtility::profiling('Admin Email Sent');
			}
		}

		if($fgParams->get('debug')) {
			if(isset($p->_buffer)) {
				FeedgatorUtility::log(var_export($p->getBuffer()));
				if(J_VERSION < 1.6) unset($p->_buffer);
			}
		}

		$msg = $ajax ? sprintf('<div res="result" count="%d" proc="%d" time="%d">%s</div>',$totItems,$procItems,$totTime,$feedMsg) : sprintf('%s<br /><br /><b>%d</b> content items imported in %d seconds.<br /><br /><a href="javascript:closeMsgArea();">Close this window</a><br />',$feedMsg,$totItems,$totTime);
		return $msg;
	}

	function getLatestImports()
	{
		$query = 'SELECT * FROM #__feedgator_imports ORDER BY id DESC LIMIT 0,10';
		$this->_db->setQuery($query);
		$imports = $this->_db->loadAssocList();
		$rows = null;

		if(!empty($imports)) {
			foreach($imports as $import) {
				// at present we ignore enclosure only imports
				if($import['plugin'] != 'enclosure') {
					$this->setId($import['feed_id']);
					$this->getData();
					$ids[$import['plugin']]['ids'][] = $import['content_id'];
				}
			}
			if(isset($ids)) {
				foreach($ids as $content_type => &$data) {
					$plugin = $this->getPlugin($content_type);
					$where = ' WHERE c.id IN ('.implode(',',$data['ids']).')';
					$rparts[] = $plugin->getContentItemsQuery($where);
					$order = ' ORDER BY id DESC';
				}
				$rparts = (count($rparts) > 1) ? implode(' UNION ',$rparts) : $rparts[0];

				$this->_db->setQuery($rparts.$order);
				$rows = $this->_db->loadObjectList();
				if(is_array($rows)) {
					foreach($rows as &$row) {
						$plugin = $this->getPlugin($row->content_type);
						$row->content_link = $plugin->getContentLink($row->id);
						$row->feed_link = JRoute::_( 'index.php?option=com_feedgator&task=edit&cid[]='. $row->feedid );
					}
				}
			}
		}
		return $rows;
	}

	function upgradeComponentParams()
	{
		$crow = JTable::getInstance('component');

		// fix blank component entries error
		$query = 	"SELECT id " .
					"FROM #__components ".
					"WHERE name = '' " .
					"AND link = '' ".
					"AND menuid = '' ".
					"AND parent = '' ".
					"AND admin_menu_link = '' ".
					"AND admin_menu_alt = ''";
		$this->_db->setQuery($query);
		$rows = $this->_db->loadResultArray();

		foreach($rows as $row) {
			$crow->delete($row);
		}

		$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE ' . $this->_db->nameQuote( 'option' ) . '=' . $this->_db->Quote( 'com_feedgator' ) .
				' AND parent = 0';
		$this->_db->setQuery( $query, 0, 1 );
		$comp = $this->_db->loadObject();

		$params = FeedgatorUtility::parseINIString($comp->params);
		foreach ($params as $k => &$v) {
			switch($k)
			{
				case 'default_type':
					if(is_numeric($v)) {
						$v = ($v == '-2') ? 'com_k2' : 'com_content';
					}
				break 2;
			}
		}
		$params = FeedgatorUtility::makeINIString($params);
		$comp->params = $params;
		if($this->_db->updateObject('#__components',$comp,'id')) {
			return true;
		}
		return false;
	}

	function upgradeFeedParams($formData)
	{
		$frow = JTable::getInstance('Feed','Table');
		$irow = JTable::getInstance('Import','Table');

		foreach($formData as $feedId) {
			$frow->reset();
			$irow->reset();
			$this->setId($feedId);
			$data = $this->getData();

			$msg = '';

			// this needs improving to cover for other plugins/content types
			$frow->content_type = ($data->sectionid == -2) ? 'com_k2' : 'com_content';

			if(!empty($data->params)) {
				$params = FeedgatorUtility::parseINIString($data->params);
				//check params
				$nParams = array();
				$txt = array ();
				foreach ($params as $k => &$v) {
					switch($k)
					{
						case 'default_type':

						if(is_numeric($v)) {
							$nParams['content_type'] = ($v == '-2') ? 'com_k2' : 'com_content';
						}

						break;

						case 'save_img':

						if(!isset($params['alt_img_ext'])) {
							$nParams['alt_img_ext'] = $v;
							$nParams[$k] = 0;
						}

						break;

						case 'save_img_type':

						$nParams['alt_img_ext_type'] = $v;

						break;

						default:

						$nParams[$k] = $v;

						break;
					}
				}
				$data->params = FeedgatorUtility::makeINIString($nParams);
			}

			$imports = FeedgatorUtility::parseINIString($data->imports);
			$imports = array_unique($imports);

			foreach($imports as $hash => $content_id) {
				$tmpImp = array();
				$irow->id = null;
				$tmpImp['content_id'] = $content_id;
				$tmpImp['plugin'] = $this->_data->content_type;
				$tmpImp['hash'] = $hash;
				$tmpImp['feed_id'] = $this->_id;
				$irow->save($tmpImp);
			}
			$data->imports = '';
			if(!$frow->save($data)) $data_up = true;
		}
		if(isset($data_up)) {
			$msg =  '<br /><br /><strong class="red">There was a problem upgrading your feeds. Please check your parameters carefully</strong><br />'.
					'<br /><br /><strong><a href="index.php?option=com_feedgator">Click here to set up your feeds</a></strong>';
		} else {
			$msg = 	'<br /><br /><strong class="green">Old feeds upgrade successful!</strong>'.
					'<br /><br /><strong><a href="index.php?option=com_feedgator">Click here to set up your feeds</a></strong>';
		}
		return $msg;
	}

	function _loadImports()
	{
		if (empty($this->_imports) AND $this->_id)
		{
			$query = 'SELECT *'.
			' FROM #__feedgator_imports ' .
			' WHERE feed_id = '.(int) $this->_id;

			$this->_db->setQuery($query);
			$this->_imports = $this->_db->loadAssocList();

			return (boolean) $this->_imports;
		}
		return (boolean) $this->_id;
	}

	function _loadData($id = null)
	{
		if ((empty($this->_data) AND $this->_id) OR $id)
		{
			$query = 'SELECT *'.
			' FROM #__feedgator ' .
			' WHERE id = '.(int) ($id ? $id : $this->_id);

			$this->_db->setQuery($query);
			$data = $this->_db->loadObject();

			$id ? $this->_defaultData = $data : $this->_data = $data;

			return (boolean) $data;
		}
		return (boolean) $this->_id;
	}

	function _saveArticle(&$content,&$fgParams)
	{
		global $p;

		$user = JFactory::getUser();
		$imports = $this->getImports();

		if($content['id'] AND $fgParams->get('compare_existing') == 2) { // exhaustive duplicate check
			$exists = FeedgatorHelper::findDuplicates($content,$imports,$fgParams->get('hash'),$content['id'],$fgParams,$this->_plugin,$thorough=true,$exhaustive=true);

			if($exists AND is_int($exists)) {  // exists and no change
				FeedgatorUtility::profiling('Already Imported: Exhaustive Duplicate Check');
				return false;
			}

			//so now see what to do with new article
			switch($fgParams->get('merging'))
			{
				case 0: //don't merge, make new

					FeedgatorUtility::profiling('Already Imported: Ignore and Make New');
					break;

				case 1: //attempt to merge, makes new if fails

					if(JString::strpos($exists['introtext'].$exists['fulltext'], $content['introtext'].$content['fulltext']) !== false) {
						$exists['introtext'] = $content['introtext'];
						$exists['fulltext'] = $content['fulltext'];

						if($this->_plugin->save( $exists, $fgParams )) {
							FeedgatorUtility::profiling('Already Imported: Merged Article');
							return true;
						}
					}
					FeedgatorUtility::profiling('Already Imported: Failed Merge and Make New');
					break;

				case 2: // over-write

					$exists['introtext'] = $content['introtext'];
					$exists['fulltext'] = $content['fulltext'];

					$this->_plugin->save( $exists, $fgParams );
					FeedgatorUtility::profiling('Already Imported: Overwritten');

					return true;
			}
		}
		return $this->_plugin->save( $content, $fgParams );
	}
}