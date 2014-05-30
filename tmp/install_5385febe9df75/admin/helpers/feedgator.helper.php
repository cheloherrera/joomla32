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

defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorHelper
{
	public static function processFeedItem(&$item,&$fgParams,&$plugin,$feedId,$channelTitle,$preview,$update)
	{
		FeedgatorUtility::profiling('Start SimplePie Item Processing');

		$user = JFactory::getUser();
		$model = FGFactory::getFeedModel();
		if($model->get('_id') != $fgParams->get('id')) {
			$model->setId($fgParams->get('id'));
		}
		$imports = $model->getImports();

		$hash = ( $fgParams->get('hash_type',0) ? $feedId.'_' : '' ) . md5($item->get_id());
		$fgParams->set('hash',$hash);

		$origLink = $item->get_permalink();
		$origLink = FeedgatorUtility::adjustLink($origLink,$fgParams);
		preg_match('#^[a-zA-Z\d\-+.]+://[^/]+#',$origLink,$matches);
		$fgParams->set('fBase',$matches[0].'/');
		unset($matches);

		if(!$fgParams->get('base')) { //if base isn't set don't allow processing with cron
			if(JRequest::getWord('task') != 'cron') {
				$fgParams->set('base',substr(JURI::base(),0,strpos(JURI::base(),'administrator/')));
			} else {
				jexit('FeedGator cron error: base not set');
			}
		}

		$fgParams->set('name_prefix',$fgParams->get('id').'_');
		$content = array();
		$content['id'] = 0;
		$content['introtext'] = '';
		$content['fulltext'] = '';
		$content['sectionid'] = $fgParams->get('sectionid');
		$content['catid'] = $fgParams->get('catid');
		$content['metakey'] = '';
		$content['metadesc'] = '';
		$content['images'] = array('feed'=>array(),'source'=>array(),'stack'=>array());

		// this will get full text if available in feed or return description if no full text
		FeedgatorUtility::profiling('Make Title and Alias');
		$text['feed'] = $fgParams->get('show_html') ? JString::trim($item->get_content()) : JString::trim($item->get_description());
		if(empty($text['feed'])) {
			$text['feed'] = $fgParams->get('show_html') ? JString::trim($item->get_description()) : JString::trim($item->get_content());
		}
		$text['feed'] = FeedgatorUtility::adjustText($text['feed'],$fgParams);
		$content = FeedgatorHelper::makeTitleAlias($item,$content,$text['feed'],$channelTitle,$hash,$fgParams);

		// initial duplicate checking
		// needs a next available for import preview option
		if(!$preview OR $preview) {
			FeedgatorUtility::profiling('Check For Duplicates');
			if(!$fgParams->get('check_existing')) {
				foreach($imports as &$import) {
					if($import['hash'] == $hash) { // we believe FG and skip this feed item
						FeedgatorUtility::profiling('Already Imported: Hash Check');
						return false;
					}
				}
			} else {
				if($fgParams->get('compare_existing') == 0) { // basic duplicate check
					foreach($imports as &$import) {
						if($import['hash'] == $hash) {
							if(FeedgatorHelper::findDuplicates($content,$imports,$hash,$import['content_id'],$fgParams,$plugin)) {
								FeedgatorUtility::profiling('Already Imported: Basic Duplicate Check');
								return false;
							}
							break;
						}
					}
				} elseif($fgParams->get('compare_existing') == 1) { // thorough duplicate check
					if(FeedgatorHelper::findDuplicates($content,$imports,$hash,$content['id'],$fgParams,$plugin,$thorough=true)) {
						FeedgatorUtility::profiling('Already Imported: Thorough Duplicate Check');
						return false;
					}
				} else {
					foreach($imports as &$import) {
						if($import['hash'] == $hash) {
							$content['id'] = $import['content_id'];
							break;
						}
					}
				}
			}
		}

		if($update) {
			if(!$content['id']) { // need to get an ID if it exists
				$content['id'] = FeedgatorHelper::findDuplicates($content,$imports,$hash,$content['id'],$fgParams,$plugin,$thorough=true);
			}
		}

		elseif (!$fgParams->get('create_art',1)) {
			// no article just enclosures
			$encs = $item->get_enclosures();
			FeedgatorHelper::processEnclosures($encs,$content,$fgParams,false,false);
			FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),$content['id'],'enclosure',$fgParams);

		} elseif(intval($content['id']) == 0 OR ($content['id'] AND $fgParams->get('compare_existing'))) { // article processing
			$text['source'] = $fgParams->get('fulltext') ? FeedgatorHelper::getFullText($origLink,$fgParams) : '';
			$text['source'] = FeedgatorUtility::adjustText($text['source'],$fgParams);
			if($alt_title = $fgParams->get('readability_title') AND $alt_title != 1 AND !empty($alt_title)) {
				$content['title'] = $alt_title;
				FeedgatorHelper::makeTitleAlias($item,$content,$text['feed'],$channelTitle,$hash,$fgParams);
			}

			//Check item filtering
			FeedgatorUtility::profiling('Check Filtering');
			if($fgParams->get('filtering')) {
				if($fgParams->get('filter_blacklist')) {
					foreach( explode(',',strtolower($fgParams->get('filter_blacklist',true))) as $value) {
						if(JString::strpos(strtolower($content['title'].' '.$text['feed'].' '.$text['source']),trim($value)) !== false) {
							FeedgatorUtility::profiling('Item Blacklisted');
							if($fgParams->get('save_filter_result')) FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),-1,$plugin->extension,$fgParams);
							return false; // found a blacklist word - stop
						}
					}
				}

				if($fgParams->get('filter_whitelist')) {
					foreach( explode(',',strtolower($fgParams->get('filter_whitelist',true))) as $value) {
						if(JString::strpos(strtolower($content['title'].' '.$text['feed'].' '.$text['source']),trim($value)) !== false) {
							FeedgatorUtility::profiling('Item Whitelisted');
							$white = 1;
							break; // found a whitelist word - carry on
						}
					}
					if(!isset($white)) {
						FeedgatorUtility::profiling('Item Failed Whitelist');
						if($fgParams->get('save_filter_result')) FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),-2,$plugin->extension,$fgParams);
						return false; // none of whitelist found - stop
					}
				}
			}

			FeedgatorUtility::profiling('Set Creator/Author');
			$content['created_by'] = (int)$fgParams->get('default_author') ? (int)$fgParams->get('default_author') : $user->get('id');
			if(!$content['created_by']) {
				$query = 	'SELECT u.*' .
							' FROM #__users AS u' .
							' INNER JOIN #__user_usergroup_map AS uum ON uum.user_id = u.id' .
							' WHERE uum.group_id = 8';
				$db->setQuery( $query );
				$admin = $db->loadObject();
				$content['created_by'] = $admin->get('id');
			}
			$author = $item->get_author();
			switch($fgParams->get('save_author'))
			{
				case 1:
				default:
				if(!isset($admin)) {
					$admin = JFactory::getUser($content['created_by']);
				}
				$content['created_by_alias'] = $admin->get('name');
				break;

				case 2:
				$content['created_by_alias'] = $fgParams->get('default_author_alias');
				break;

				case 3:
				if($author) {
					$content['created_by_alias'] = $author->get_name() ? $author->get_name() : $channelTitle;
				} else {
					$content['created_by_alias'] = $channelTitle;
				}
				break;

				case 4:
				if($author) {
					$content['created_by_alias'] = $author->get_name() ? $author->get_name() : $fgParams->get('default_author_alias');
				} else {
					$content['created_by_alias'] = $fgParams->get('default_author_alias');
				}
				break;
			}
			if ($fgParams->get('feed_author_article')) {
				$authors = '<p>'.JText::_('FG_AUTHORS').': '.$content['created_by_alias'].'</p>';
				if($text['source']) {
					$text['source'] = ($fgParams->get('feed_author_article') == 'top') ? $authors.$text['source'] : $text['source'].$authors;
				} else {
					$text['source'] = ($fgParams->get('feed_author_article') == 'top') ? $authors.$text['feed'] : $text['feed'].$authors;
				}
			}

			FeedgatorUtility::profiling('Process Feed Images');
			FeedgatorHelper::processImages($origLink,$text['feed'],$content,$plugin,$fgParams,$content['images']['feed']);

			FeedgatorUtility::profiling('Process Source Images');
			FeedgatorHelper::processImages($origLink,$text['source'],$content,$plugin,$fgParams,$content['images']['source']);

			// enclosures
			$enc_image = false;
			$thumb = false;
			if($encs = $item->get_enclosures()) {
				FeedgatorHelper::processEnclosures($encs,$content,$fgParams,$enc_image,$thumb,$text);
				if($encs AND $enc_image) {
					if($text['feed']) {
						FeedgatorUtility::profiling('Process Enclosure Images added to feed text');
						FeedgatorHelper::processImages($origLink,$text['feed'],$content,$plugin,$fgParams,$content['images']['feed']);
					} elseif($text['source']) {
						FeedgatorUtility::profiling('Process Enclosure Images added to source text');
						FeedgatorHelper::processImages($origLink,$text['source'],$content,$plugin,$fgParams,$content['images']['source']);
					}
				}
				if($encs AND $thumb) {
					if($text['feed']) {
						FeedgatorUtility::profiling('Process Thumbnail Images added to feed text');
						FeedgatorHelper::processImages($origLink,$text['feed'],$content,$plugin,$fgParams,$content['images']['feed']);
					} elseif($text['source']) {
						FeedgatorUtility::profiling('Process Thumbnail Images added to source text');
						FeedgatorHelper::processImages($origLink,$text['source'],$content,$plugin,$fgParams,$content['images']['source']);
					}
				}
			}

			FeedgatorHelper::balanceImages($text,$content,$fgParams);

			// make introtext,fulltext whilst cleaning
			FeedgatorUtility::profiling('Start Make Parts and Filter/Clean Text');
			$content = FeedgatorHelper::makeParts($content, $text, $fgParams);
			FeedgatorUtility::profiling('End Make Parts and Filter/Clean Text');

			// test for empty content and maybe abort
			if($fgParams->get('ignore_empty_intro') AND empty($content['introtext'])) {
				FeedgatorUtility::profiling('Intro Text Empty -> Aborting');
				return false;
			}

			//add default image if indicated
			if(!FeedgatorHelper::addDefaultImage($content,$plugin,$fgParams) AND ($fgParams->get('ignore_no_image') AND empty($content['images']['stack'])) ) {
				if($preview) {
					FeedgatorUtility::profiling('No Image Detected -> IMPORT WOULD BE ABORTED');
				} else {
					FeedgatorUtility::profiling('No Image Detected -> Aborting');
					return false;
				}
			}

			//moved to plugin
			//push images in the stack to the plugin for final handling
		//	if(!$preview) {
		//		foreach($content['images']['stack'] as $k => $image) {
		//			$plugin->saveImages($image,$k,$content,$fgParams);
		//		}
		//	}

			if ($fgParams->get('show_orig_link') OR !$content['introtext']) {
				FeedgatorUtility::profiling('Trackback Processing');

				$target = ($fgParams->get('target_frame') == 'none') ? '' : 'target="'.(($fgParams->get('target_frame') == 'custom') ? $fgParams->get('custom_frame') : $fgParams->get('target_frame')).'"';
				if (!empty($origLink)){
					if($fgParams->get('shortened_url')) {
						switch($fgParams->get('shortened_url'))
						{
							case 1: // Bit.ly
								FeedgatorUtility::profiling('Bit.ly URL Shortener');
								$origLink = FeedgatorUtility::getUrl('http://api.bitly.com/v3/shorten?login=feedgator&apiKey=R_9e7b64db664f89150100e95fbcaa6a85&longUrl='.FeedgatorUtility::encode_url($origLink).'&format=txt&x_login='.$fgParams->get('bitly_login').'&x_apiKey='.$fgParams->get('bitly_api_key'),$fgParams->get('scrape_type'),'noheader');
							break;

							case 2: // Goo.gl - we have to use fopen as cURL doesn't seem to work!
								FeedgatorUtility::profiling('Goo.gl URL Shortener');
								if($json = FeedgatorUtility::getUrl('https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyD4e2Kc67Thf6-dt7v0B1KcCn4RPRKjQyc','fopen','goo.gl',null,array($origLink))) {
									if(strpos($json,'error') === false) {
										$json = json_decode($json);
										$origLink = $json->id;
									}
									unset($json);
								}
							break;
						}
					}
					if ($fgParams->get('shortlink')){
						$readonlink = 	'<strong><a class="'.$fgParams->get('trackback_class').'"'.
										' rel="'.$fgParams->get('trackback_rel').'"' .
										' title="'.JString::trim(JString::substr($content['title'],0,50)).'"'.
										' href="'.$origLink.'" '.$target.'>'.$fgParams->get('orig_link_text').'</a></strong>';
					} else {
						$readonlink = 	'<strong>'.$fgParams->get('orig_link_text').'</strong>&nbsp;'.
										'<a class="'.$fgParams->get('trackback_class').'"'.
										' rel="'.$fgParams->get('trackback_rel').'"' .
										' title="'.JString::trim(JString::substr($content['title'],0,50)).'"'.
										' href="'.$origLink.'" '.$target.'>'.$origLink.'</a>';
					}
					$readonlink = '<p>'.$readonlink.'</p>';

					if($fgParams->get('onlyintro') OR !$content['fulltext'] OR !$content['introtext']) {
						if(!$content['introtext']) {
							$content['introtext'] .= '<p>'.$fgParams->get('default_introtext').'</p>';
						}
						$content['introtext'] .= $readonlink;
					} else {
						$content['fulltext'] .= $readonlink;
					}
				}
			}

			if ($fgParams->get('save_feed_cats')) {
				if ($category = $item->get_category())
				{
					$content['metakey'] .= $category->get_label();
				}
			}
			if ($fgParams->get('save_sect_cats')) {
				$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . $plugin->getFieldNames($content);
			}

			FeedgatorUtility::profiling('Start Tag/Keyword Processing');
			//add default tags
			if($fgParams->get('default_tags','')) {
				$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . $fgParams->get('default_tags');
			}

			switch($fgParams->get('compute_tags'))
			{
				case 0:
				break;

				case 1: //internal method
					FeedgatorUtility::profiling('FG Internal Tagging/Keyword Processing');
					$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::generateTags($content['introtext'].' '.$content['fulltext'],$fgParams);
				break;

				case 2: //Add Keywords
					FeedgatorUtility::profiling('AddKeywords Tagging/Keyword Processing');
					// need to add a check that AK is published!
					if(file_exists(JPATH_ROOT .DS.'plugins'.DS.'system'.DS.'addkeywords.php')) {
						$addkeywordmeta = plgSystemAddKeywords::generateMeta($content['introtext'].' '.$content['fulltext'], true, true, null);
						$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . $addkeywordmeta['keywords'];
						$content['metadesc'] .= (empty($content['metadesc']) ? '' : ',') . $addkeywordmeta['description'];
					} else {
						$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::generateTags($content['introtext'].' '.$content['fulltext'],$fgParams);
					}
				break;

				case 3: //Yahoo!
					FeedgatorUtility::profiling('Yahoo content.analyze Tagging/Keyword Processing');
					//should automatically fallback to internal method
					$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::extractTerms($origLink,$fgParams);
				break;

				case 4: //Reuters
					FeedgatorUtility::profiling('Reuters OpenCalais Tagging/Keyword Processing');
					$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::extractCalais($content['introtext'].' '.$content['fulltext'],$fgParams);
				break;
			}
			FeedgatorUtility::cleanMeta($content);
			FeedgatorUtility::profiling('End Tag/Keyword Processing');

			$itemDate = JFactory::getDate($item->get_date(), JFactory::getConfig()->getValue('config.offset'));
			$iDate = $itemDate->toMySQL();
			$today = gmdate('Y-m-d H:i:s');

			if($itemDate->toUnix() < JFactory::getDate('2000-01-01 00:00:00')->toUnix()) $iDate = $today;
			if(!$fgParams->get('advance_date')) {
				if($itemDate->toUnix() > JFactory::getDate('now')->toUnix()) $iDate = $today;
			}
			if ($iDate AND strlen(trim( $iDate )) <= 10) {
				$iDate 	.= ' 00:00:00';
			}

			$content['created'] = $fgParams->get('created_date') ? $today : $iDate;
			$content['publish_up'] = $fgParams->get('pub_date') ? $today : $iDate;

			$content['state'] = intval($fgParams->get('auto_publish'));
			$publishDays = intval($fgParams->get('publish_duration'));
			if ($content['state'] > 0 AND $publishDays) {
				switch($fgParams->get('pub_dur_type',0))
				{
					case 0: $publishDays = $publishDays * 24 * 60 * 60; break;
					case 1: $publishDays = $publishDays * 60 * 60; break;
					case 2: $publishDays = $publishDays * 60; break;
				}
				$content['publish_down'] = gmdate('Y-m-d H:i:s', time() + $publishDays);
			}
		} // end article processing
		FeedgatorUtility::profiling('End Item Processing');
		//$item->destroy();
		unset($item);
		FeedgatorUtility::profiling('SimplePie Item Unset');

		return $content;
	}

	public static function makeTitleAlias(&$item,&$content,&$feed_text,$channelTitle,$hash,&$fgParams)
	{
		if(!isset($content['title'])) {
			//jexit($item->get_title());
			$content['title'] = JString::trim($item->get_title());
			if(!$content['title']) { // see if feed text might have a likely candidate
				$regex = '#<(?:h1|h2|h3|b|strong)[^>]*>([\s\S]*?)<\/(?:h1|h2|h3|b|strong)>#i';
				preg_match($regex,$feed_text,$matches);
				$content['title'] = JFilterOutput::cleanText($matches[1]);
				if(empty($content['title'])) {
					$datenow = JFactory::getDate();
					$content['title'] = $channelTitle.' - '.$hash.' - '.$datenow->toFormat("%Y-%m-%d-%H-%M-%S");
				}
			}

			$content['title'] = str_replace(array("\n","\r","\t"),' ',$content['title']);
			$content['title'] = JFilterOutput::cleanText($content['title']);
			$content['title'] = preg_replace('#\s{2,}#',' ',$content['title']);
		}
		//text replacements and adjustments
		$content['title'] = FeedgatorUtility::adjustText($content['title'],$fgParams);

		$content['alias'] = FeedgatorUtility::stringURLSafe($content['title']);
		if($fgParams->get('translit',0) ) {
			$content['alias'] = FeedgatorUtility::transliterate($content['alias'],$fgParams->get('custom_translit'));
		}

		//fix for trailing alias dashes
		$length = strlen($content['alias']);
		if(strrpos($content['alias'],'-') == $length-1) {
			$content['alias'] = substr($content['alias'],0,$length-1);
		}

		//fix for long titles and htmlentities
		$content['title'] = html_entity_decode(substr($content['title'],0,255), ENT_QUOTES, 'UTF-8');
		$content['alias'] = substr($content['alias'],0,255);

		return $content;
	}

	public static function findDuplicates(&$content,&$imports,$hash,$id,&$fgParams,&$plugin,$thorough=false,$exhaustive=false)
	{
		$db = JFactory::getDBO();

		$debug = $fgParams->get('debug');

		if(!$thorough AND !$exhaustive) { // basic
			if($existId = $plugin->findDuplicates('id',$id,$content['catid'])) {
				if($debug) FeedgatorUtility::profiling('Basic Loaded ID:'.$existId.','.$content['alias'].','.$content['title']);
				return $existId;
			}
		}

		elseif($thorough and !$exhaustive) { // thorough
		// todo - add in a duplicates alert here by comparing IDs
			if ($content['title'] AND $content['alias']) {  // use alias in preference
				if($existId = $plugin->findDuplicates('alias',$content['alias'],$content['catid'])) {
					if($debug) FeedgatorUtility::profiling('Thorough Loaded ID using alias:'.$existId.','.$content['alias'].','.$content['title']);
					return $existId;
				} else {
					if($debug) FeedgatorUtility::profiling('Thorough Not Loaded ID using alias:'.$id.','.$content['alias'].','.$content['title']);
					foreach($imports as $import) {
						if($import['hash'] == $hash) {
							if($debug) self::findDuplicates($content,$imports,$hash,$import['content_id'],$fgParams,$plugin);
							break;
						}
					}
				}
			} elseif ($content['title']){ // ok, use the title
				if($existId = $plugin->findDuplicates('title',$content['title'],$content['catid'])) {
					if($debug) FeedgatorUtility::profiling('Thorough Loaded ID using title:'.$existId.','.$content['alias'].','.$content['title']);
					return $id;
				} else {
					if($debug) FeedgatorUtility::profiling('Thorough Not Loaded ID using title:'.$id.','.$content['alias'].','.$content['title']);
					foreach($imports as $import) {
						if($import['hash'] == $hash) {
							if($debug) self::findDuplicates($content,$imports,$hash,$import['content_id'],$fgParams,$plugin);
							break;
						}
					}
				}
			}
		}

		elseif($exhaustive) { // exhaustive
		// todo - add in a duplicates alert here by comparing IDs
			$type = $fgParams->get('check_text') ? 'introtext' : 'fulltext';
			if($existId = $plugin->findDuplicates($type,$content[$type],$content['catid'])) {
				if($debug) FeedgatorUtility::profiling('Exhaustive Loaded ID:'.$existId.','.$content['alias'].','.$content['title']);
				return $existId;
			} else {
				if($debug) FeedgatorUtility::profiling('Exhaustive Not Loaded ID:'.$id.','.$content['alias'].','.$content['title']);
				$query = 	'SELECT *' .
							' FROM ' . $table .
							' WHERE id = '. $db->Quote($id);
				$db->setQuery( $query );
				$exists = $db->loadAssoc();

				return $exists;
			}
		}

		if($debug) FeedgatorUtility::profiling('Not Loaded ID:'.$id.','.$content['alias'].','.$content['title']);

		foreach($imports as $import) {
			if($import['hash'] == $hash) {
				// doesn't exist so remove and allow importing again
				$row = JTable::getInstance('Import','Table');
				$row->delete($import['id']);
				unset($import);
				$model = FGFactory::getFeedModel();
				$model->_imports = $imports;
			}
		}

		return false;
	}

	public static function processImages($origLink,&$text,&$content,&$plugin,&$fgParams,&$images = array())
	{
		if(!is_array($images)) (array)$images;
		$replace = array();
		$rimages = array();
		$regex = '/<img[^>]*>/';

		// array containing disallowed image sources
		$disallowed = explode(',',$fgParams->get('blocked_images'));

		//this is inefficient and unpleasant...
		$dom = new DOMDocument();
		$dom2 = new DOMDocument();
		@$dom->loadHTML($text);
		$imgs = $dom->getElementsByTagName('img');
		$k = ( empty($images) ? 0 : count($images) );
		foreach($imgs as $img) {
			$saved = false;
			$first = true;
			if($src = $img->getAttribute('src') AND !FeedgatorUtility::in_array_recursive($src,$images) AND strpos($src,$fgParams->get('base')) === false) { // prevents repeat processing
				FeedgatorUtility::profiling('Processing Image SRC: '.$src);
				// fix rel and munged paths
				$src = FeedgatorUtility::encode_url(FeedgatorUtility::makeAbsUrl($origLink,$src));
				$images[$k]['image_details'] = array();
				$image_pass = 0;
				if(FeedgatorUtility::strpos_array($src,$disallowed) === false) {
					if($fgParams->get('img_check',1) AND function_exists('getimagesize')) {
						//checks for 1 and 2 pixel images and blocks them
						if($images[$k]['image_details'] = @getimagesize($src) AND ($images[$k]['image_details'][0] > 48) AND ($images[$k]['image_details'][1] > 48)) {
							FeedgatorUtility::profiling('Image Details: '.print_r($images[$k]['image_details'],true));
							$image_pass = 1;
						}
					} else {
						FeedgatorUtility::profiling('getimagesize not installed or over-ridden: image passed');
						$image_pass = 1;
					}
				}
				if($image_pass) {
					$images[$k]['title'] = $img->getAttribute('title') ? $k.'_'.$img->getAttribute('title') : '';
					$images[$k]['alt'] = $img->getAttribute('alt') ? $k.'_'.$img->getAttribute('alt') : '' ;
					$images[$k]['src'] = $src;
					$img->setAttribute('src',$src);

					if($fgParams->get('save_img')) {
						if($fgParams->get('preview')) {
							FeedgatorUtility::profiling('Skipping Image Saving for Preview');
						} else {
							// find image name and extension
							$image_data = array('title'=>$images[$k]['title'],'alt'=>$images[$k]['alt'],'src'=>$src,'name_type'=>$fgParams->get('img_name_type',0),'prefix'=>$fgParams->get('name_prefix'),'suffix'=>'_'.$k);
							$filename = FeedgatorHelper::getImageName($image_data,$images[$k]['image_details']);

							//upload image if desired
							if(FeedgatorHelper::imageUpload($src,$filename,$fgParams)) {
								FeedgatorUtility::profiling('Image Uploaded');
								$images[$k]['filename'] = $filename;
								$images[$k]['savepath'] = $fgParams->get('img_savepath').$filename;
								$images[$k]['old_src'] = $src;
								$images[$k]['src'] = $fgParams->get('img_srcpath').$filename;
								$img->setAttribute('src', $fgParams->get('img_srcpath').$filename);
							}
						}
					}
					FeedgatorUtility::profiling('Final Image SRC: '.$img->getAttribute('src'));
				//	$class = $img->getAttribute('class');
				//	$width = $img->getAttribute('width');
				//	$height = $img->getAttribute('height');
					if(strlen($images[$k]['alt']) >= JString::strlen($content['title']) OR !$images[$k]['alt']) {
						$img->setAttribute('alt',$content['title']);
					}
					if($fgParams->get('rmv_img_style') OR $fgParams->get('disallow_attribs')) {
						$img->removeAttribute('class');
						$img->removeAttribute('style');
						$img->removeAttribute('align');
						$img->removeAttribute('border');
						$img->removeAttribute('width');
						$img->removeAttribute('height');
					}
					if($fgParams->get('img_class')) {
						$img->setAttribute('class',$fgParams->get('img_class'));
					}
					$new_img = $dom2->importNode($imgs->item($k),true);
					$dom2->appendChild($new_img);
					$images[$k]['html'] = $dom2->saveHTML();
					$rimages[$k] = $images[$k]['html'];
					$dom2->removeChild($new_img);

					// hack to avoid encoding problems
					$text = preg_replace($regex,'fg_img'.$k,$text,$limit=1);
					$replace[$k] = 'fg_img'.$k;
					$k++;
				} else {
					FeedgatorUtility::profiling('Image Rejected');
					unset($images[$k]);
					$text = preg_replace($regex,'',$text,1);
				}
			}
		}
		$text = str_replace(array_reverse($replace),array_reverse($rimages),$text);

		if(!is_array($content['images']['stack'])) (array)$content['images']['stack'];
		foreach($images as $image) {
			if(!FeedgatorUtility::in_array_recursive($image['src'],$content['images']['stack'])) {
				$content['images']['stack'][] = $image;
			}
		}

		return $images;
	}

	public static function balanceImages(&$text,&$content,&$fgParams)
	{
		// balance first image from sources
		if($fgParams->get('alt_img_ext')) {
			FeedgatorUtility::profiling('Image Balancing');
			if(empty($content['images']['feed']) != empty($content['images']['source'])) {
				if(empty($content['images']['source']) AND $text['source']) { //source text images are missing
					$text['source'] = @$content['images']['feed'][0]['html'].$text['source'];
					FeedgatorUtility::profiling('Feed Image added to Source Text (image balancing)');
				} elseif(empty($content['images']['feed'])) { //feed text images are missing
					$text['feed'] = @$content['images']['source'][0]['html'].$text['feed'];
					FeedgatorUtility::profiling('Source Image added to Feed Text (image balancing)');
				}
			}
		}
	}

	public static function imageUpload($src,$filename,&$fgParams)
	{
		FeedgatorUtility::profiling('Saving Image');
		// consider restoring the JPath::clean()
		if(!JFolder::exists($fgParams->get('img_savepath'))) JFolder::create($fgParams->get('img_savepath'));

		$filepath = $fgParams->get('img_savepath').$filename;

		//create image file
		$saved = false;
		if(!file_exists($filepath)) {
			if($contents = FeedgatorUtility::getUrl($src,$fgParams->get('scrape_type'),'images',$filepath)) {
				$saved = true;
				//if(FeedgatorUtility::savefile($contents,$name,$update=false,$header=null,$fgParams->get('savepath').'images')) $saved = true;
			}
		} else {
			$saved = true;
		}

		return $saved;
	}

	public static function addDefaultImage(&$content,&$plugin,&$fgParams)
	{
		//add default feed image if required
		if($fgParams->get('default_img') != -1) {
			switch($fgParams->get('default_img'))
			{
				//add to introtext if no images
				case 1:
					if(empty($content['images']['feed'])) {
						$plugin->addDefaultImage('introtext',$content,$fgParams);
						return true;
					}
				break;

				//add to introtext and fulltext if no images
				case 2:
					if(empty($content['images']['stack'])) {
						$plugin->addDefaultImage('both',$content,$fgParams);
						return true;
					}
				break;

				//force add to introtext
				case 3:
					$plugin->addDefaultImage('introtext',$content,$fgParams);
					return true;
				break;

				//force add to introtext and fulltext
				case 4:
					$plugin->addDefaultImage('both',$content,$fgParams);
					return true;
				break;
			}
		}
		return false;
	}

	public static function getImageName($image_data,$image_details,$add_ext = 1)
	{
		extract($image_data);

		preg_match('#[/?&]([^/?&]*)(\.jpg|\.jpeg|\.gif|\.png)#i',$src,$matches);
		$ext = isset($matches[2]) ? trim(strtolower($matches[2])) : '';
		if(!$ext and !empty($image_details)) {
			switch ($image_details['mime']) {
				case 'image/pjpeg':
				case 'image/jpeg':
				case 'image/jpg':
					$ext = '.jpg';
					break;
				case 'image/x-png':
				case 'image/png':
					$ext = '.png';
					break;
				case 'image/gif':
					$ext = '.gif';
					break;
				case 'image/bmp':
					$ext = '.bmp';
					break;
			}
		}

		switch($name_type)
		{
			case 0: list($name) = $title ? FeedgatorUtility::splitText($title,50,'char',false) : FeedgatorUtility::splitText($alt,50,'char',false);
			break;

			case 1: if(isset($matches[1])) $name = $matches[1];
			break;

			case 2: $name = md5($src);
			break;

			case 3: jexit('Image name error');
			break;
		}
		$image_data['name_type']++;
		if(empty($name)) $name = FeedgatorHelper::getImageName($image_data,$image_details,0);
		$name = JFile::makeSafe(FeedgatorUtility::stringURLSafe($prefix.$name.$suffix));

		return $add_ext ? $name.$ext : $name;
	}

	// identifies if image enclosure
	// adds image html to text depending on FeedGator settings
	// triggers processing of all other enclosure types
	public static function processEnclosures(&$encs,&$content,&$fgParams,&$enc_image,&$thumb,&$text)
	{
		$enc_links = array();
		foreach($encs as &$enc) {
			if(!isset($enc_links[$enc->get_link()])) { // protects against duplicate enclosures
				$enc_links[$enc->get_link()] = 1;
				if($enc->get_type()) {
					// get any enclosure image only if no feed image
					if(stripos($enc->get_real_type(),'image') !== false AND empty($content['images']['feed']) AND $fgParams->get('process_enc_images')) {
						FeedgatorUtility::profiling('Enclosure Image added to feed text');
						$enc_image = '<img src="'.$enc->get_link().'" alt="'.$content['title'].'"/>';
						$text['feed'] = $enc_image.$text['feed'];
						if($text['source'] AND (empty($content['images']['source']) OR $fgParams->get('force_enc_image'))) {
							FeedgatorUtility::profiling('Enclosure Image added to source text');
							$text['source'] = $enc_image.$text['source'];
						}
					} else {
						FeedgatorUtility::profiling('Process Enclosures');
						$text['source'] ? FeedgatorHelper::extractEnclosures($enc,$text['source'],$content,$fgParams) : FeedgatorHelper::extractEnclosures($enc,$text['feed'],$content,$fgParams);
					}
				// use any thumbnail image only if no feed image
				} elseif($thumbnail = $enc->get_thumbnail() AND empty($content['images']['feed']) AND $fgParams->get('process_enc_images')) {
					FeedgatorUtility::profiling('Enclosure Thumbnail added to feed text');
					$thumb = '<img src="'.$thumbnail.'" alt="'.$content['title'].'"/>';
					$text['feed'] = $thumb.$text['feed'];
					if($text['source'] AND (empty($content['images']['source']) OR $fgParams->get('force_enc_image'))) {
						FeedgatorUtility::profiling('Enclosure Thumbnail added to source text');
						$text['source'] = $thumb.$text['source'];
					}
				}
			}
		}
	}

	public static function extractEnclosures(&$e,&$text,&$content,&$fgParams)
	{
		if(!$fgParams->get('process_enc')) return true;

		if(!JFolder::exists($fgParams->get('savepath'))) JFolder::create($fgParams->get('savepath'));

		$real_type = strtolower($e->get_real_type());
		$src = $e->get_link();
		$real_name = array_pop(explode('/',$src));
		$name = $e->get_title() ? $e->get_title() : $e->get_caption();
		if(!$name) $name = $real_name;
		$e_inf = '';
		$saved = false;

		if(strpos($real_type,'audio') !== false) { // audio
			$e_img = 'audio';
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'audio',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'audio/'.$name : $src).'">'.$name.'</a>';
			if($e->get_duration()) $e_inf .= 'Duration: '.$e->get_duration().' seconds<br />';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -1;
		}
		elseif(strpos($real_type,'video') !== false) { // videos
			$e_img = $e->get_thumbnail();
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'videos',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'videos/'.$name : $src).'">'.$name.'</a>';
			if($e->get_duration()) $e_inf .= 'Duration: '.$e->get_duration().' seconds<br />';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -2;
		}
		elseif(strpos($real_type,'image') !== false) { // images
			$e_img = 'image';
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'images',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? ($fgParams->get('save_enc_image_as_img') ? $fgParams->get('img_srcpath') : $fgParams->get('srcpath').'images/').$name : $src).'">'.$name.'</a>';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -3;
		}
		elseif(strpos($real_type,'pdf') !== false) { // is this needed - depends on user/dev requirements - possible google viewer link...
			$e_img = 'pdf';
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'attachments',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'attachments/'.$name : $src).'">'.$name.'</a>';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -4;
		}
		elseif(strpos($real_type,'doc') !== false) { // support various "serious" doctypes
			switch($e->get_extension())
			{
				case '.doc':
				case '.docx':
					$e_img = 'word';
					break;
				case '.xls':
				case '.xlsx':
					$e_img = 'xls';
					break;
				case '.ppt':
				case '.pptx':
					$e_img = 'ppt';
					break;
				case '.odf':
					$e_img = 'odf';
					break;
				default:
					$e_img = 'generic';
					break;
			}
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'attachments',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'attachments/'.$name : $src).'">'.$name.'</a>';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -5;
		}
		elseif(strpos($real_type,'zip') !== false) { // archives - need to look into how rar/gz etc are shown in enclosures
			$e_img = 'archive';
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'attachments',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'attachments/'.$name : $src).'">'.$name.'</a>';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -6;
		}
		else {
			$e_img = 'generic';
			if($fgParams->get('save_enc')) $saved = FeedgatorHelper::saveEnclosure($name,'attachments',$src,$fgParams);
			$e_lnk = '<a href="'.($saved ? $fgParams->get('srcpath').'attachments/'.$name : $src).'">'.$name.'</a>';
			if($e->get_size()) $e_inf .= 'Size: '.$e->get_size().' Mb';
			if($saved AND !$fgParams->get('create_art',1)) $content['id'] = -7;
		}
		$img = sprintf('<img class="fg_enclosure_img" src="%sadministrator/components/com_feedgator/images/%s.png" height="16" width="16" style="margin:8px 8px;">',$fgParams->get('base'),$e_img);
		$e_lnk = sprintf('<div class="fg_enclosure_lnk" style="padding-left:34px;white-space:nowrap;">%s</div>',$e_lnk);
		if($e_inf) $e_inf = sprintf('<div class="fg_enclosure_inf" style="padding-left:34px;white-space:nowrap;"">%s</div>',$e_inf);
		$e_out = sprintf('<div class="fg_enclosure" style="margin:10px 0px;"><div class="fg_enclosure_img" style="display:inline-block;position:absolute;">%s</div>%s%s</div>',$img,$e_lnk,$e_inf) ;
		$text .= $e_out;
	}

	public static function saveEnclosure($name,$type,$src,&$fgParams)
	{
		if($type == 'images') {
			$savepath = $fgParams->get('save_enc_image_as_img',1) ? $fgParams->get('img_savepath') : $fgParams->get('savepath').$type.DS;
			if(!JFolder::exists($savepath)) JFolder::create($savepath);
			$file_path = $savepath.$name;
		} else {
			$savepath = $fgParams->get('savepath').$type.DS;
			if(!JFolder::exists($savepath)) JFolder::create($savepath);
			$file_path = $savepath.$name;
		}

		if(!file_exists($file_path)) {
			//if(!FeedgatorUtility::savefile($contents,$name,$update=false,$header=null,$savepath.DS)) return false;
			if(!$contents = FeedgatorUtility::getUrl(FeedgatorUtility::encode_url($src),$fgParams->get('scrape_type'),$type,$file_path)) {
				FeedgatorUtility::profiling('Enclosure Not Saved');
				return false;
			} else {
				FeedgatorUtility::profiling('Enclosure Saved');
			}
		} else {
			FeedgatorUtility::profiling('Enclosure Already Saved');
		}
		return true;
	}

	public static function saveImport($hash,$feed_id,$content_id,$plugin,&$fgParams)
	{
		$import 				= array();
		$import['hash'] 		= $hash;
		$import['feed_id'] 		= $feed_id;
		$import['content_id'] 	= $content_id;
		$import['plugin'] 		= $plugin;

		$fgParams->get('irow') ? $irow = $fgParams->get('irow') : $irow = JTable::getInstance('Import','Table');
		$irow->save($import);
		$fgParams->set('hash','');
	}

	public static function getFullText($origLink,&$fgParams)
	{
		FeedgatorUtility::profiling('Get Source Full Text');

		require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'readability'.DS.'Readability.php');

		$page = FeedgatorUtility::getUrl($origLink,$fgParams->get('scrape_type'),'html');
		$parts = FeedgatorUtility::extractHTTP($page,$fgParams);
		$body = FeedgatorUtility::convert_to_utf8($parts['body'],$parts['header']);
		//echo $body;
		if($body) {
			$readability = new Readability($body,$origLink,$fgParams);
			$readability->convertLinksToFootnotes = $fgParams->get('link_table') ? true : false;
			if($readability->init()) {
				//FeedgatorHelper::cleanSpecifically($readability,$fgParams);
				$fgParams->set('rDebug',$readability->debugMsg);
				if($fgParams->get('readability_title')) $fgParams->set('readability_title',$readability->articleTitle->innerHTML);
				$return = $readability->articleContent->innerHTML;
				if($return == '<p>Sorry, Readability was unable to parse this page for content.</p>') {
					FeedgatorUtility::profiling('Failed to Get Source Full Text: Readability unable to parse');
					$return = '';
				} else {
					FeedgatorUtility::profiling('Got Source Full Text');
				}
				//jexit($readability->articleImages->innerHTML);
				//if($fgParams->get('max_image_extraction')) {
					$return = '<div id="fgimages">'.$readability->articleImages->innerHTML.'</div>'.$return;
					$return = '<div id="fgvideos">'.$readability->articleVideos->innerHTML.'</div>'.$return;
				//}
				return $return;
			}
		}
		FeedgatorUtility::profiling('Failed to Get Source Full Text: body empty');
		return false;
	}

	// Create article introtext, fulltext (based on maximum length for introtext)
	public static function makeParts($content, &$text, &$fgParams)
	{
		$dispatcher = JDispatcher::getInstance();

		//format br's as per HTML (not XHTML)
		$text['feed'] = str_replace(array('<br>','<br/>'),'<br />',$text['feed']);
		$text['source'] = str_replace(array('<br>','<br/>'),'<br />',$text['source']);

		if($fgParams->get('remove_dups_emp')) {
			while( (JString::strpos($text['feed'],'<br /><br />') !== false) ) {
				$text['feed'] = str_replace('<br /><br />','<br />',$text['feed']);
			}
			while( (JString::strpos($text['source'],'<br /><br />') !== false)) {
				$text['source'] = str_replace('<br /><br />','<br />',$text['source']);
			}
		}

		//set htmLawed to safe mode, allow specific html tags and attributes through
		$clean_config = array('safe' => 1, 'comment' => 1, 'abs_url' => ($fgParams->get('rel_src',0) ? 0 : 1), 'base_url' => $fgParams->get('fBase'));
		$spec = 'img=-*,src';
		if($fgParams->get('img_class')) $spec .= ',class(match=%'.$fgParams->get('img_class').'%)';
		if(!$fgParams->get('disallow_attribs')) $spec .= ',height,width';
		$spec .= 	';table=-*,border,width,cellspacing,cellpadding;';
		if(strpos($fgParams->get('strip_list'),'*iframe') !== false) $spec .= 'iframe=frameborder,height,width,src,srcdoc,seamless,scrolling,sandbox,name,longdesc;';
		if(strpos($fgParams->get('strip_list'),'*object') !== false) $spec .= 'object=border,height,width,classid,codebase,codetype,data,declare,type,usemap,archive,id;param=name,type,value,valuetype;';
		if(strpos($fgParams->get('strip_list'),'*embed') !== false) $spec .= 'embed=src,type,height,width;';
		// to adjust $spec for yourself see forum post http://joomlacode.org/gf/project/feedgator/forum/?action=ForumBrowse&forum_id=6709&_forum_action=ForumMessageBrowse&thread_id=20372

		if($fgParams->get('disallow_attribs')) { $clean_config['deny_attribute'] = '* -title -href -target -alt'; }
		//if($fgParams->get('remove_ms')) { $clean_config['clean_ms_char'] = 2; } // disabled as causes problems - need new method
		if($fgParams->get('xhtml_clean')) { $clean_config['valid_xhtml'] = 1; }
		if($fgParams->get('remove_bad')) { $clean_config['keep_bad'] = 6; }
		if($fgParams->get('link_nofollow')) { $clean_config["anti_link_spam"] = array('`.`',''); }
		$clean_config['tidy'] = $fgParams->get('tidy');
		if($fgParams->get('strip_html_tags')) {
			$text['feed'] = JString::trim(strip_tags($text['feed']));
			$text['source'] = JString::trim(strip_tags($text['source']));
		} elseif(list($tags,,$special) = FeedgatorHelper::getTagsToStrip()) {
			if($special) {
				$special = str_replace(array(' ','*'),'',$special);
				$special = '*+'.str_replace(',',' +',$special);
				if($tags) {
					$tags = str_replace(' ','',$tags);
					$tags = $special.' -'.str_replace(',',' -',$tags);
				} else {
					$tags = $special;
				}
			} else {
				if(strpos($tags,'+') !== false) {
					$tags = str_replace('+','',$tags);
				} elseif($tags) {
					$tags = str_replace(' ','',$tags);
					$tags = '*-'.str_replace(',',' -',$tags);
				}
			}
			if($tags) $clean_config['elements'] = $tags;
		}
		$clean_config['hook_tag'] = array('FeedgatorUtility','hook_tag_cleaning');

		if($fgParams->get('debug')) {
			$fgParams->set('clean_config',FeedgatorUtility::makeINIString($clean_config));
			$fgParams->set('spec',$spec);
		}

		// trim text to max length
		list($text['source']) = FeedgatorUtility::splitText($text['source'],$fgParams->get('max_length'),$fgParams->get('max_length_type'),$keep_tags=true);
		list($text['feed']) = FeedgatorUtility::splitText($text['feed'],$fgParams->get('max_length'),$fgParams->get('max_length_type'),$keep_tags=true);
		$trimTo = $fgParams->get('trim_to');

		if($fgParams->get('combine_text') AND !$fgParams->get('onlyintro')) {
			list($introText) = FeedgatorUtility::splitText($text['feed'],$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
			if(!$introText) list($introText) = FeedgatorUtility::splitText($text['source'],$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
			$fullText = $text['source'];
		} else {
			list($introText,$fullText) = $text['source'] ? FeedgatorUtility::splitText($text['source'],$trimTo,$fgParams->get('trim_type'),$keep_tags=true) : FeedgatorUtility::splitText($text['feed'],$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
		}

		//onBeforeFGCleanText -> $content array, $introText and $fullText strings
        $results = $dispatcher->trigger( 'onBeforeFGCleanText', array( $content, $introText, $fullText, $clean_config, $fgParams) );

		if($fgParams->get('onlyintro') OR !$trimTo OR !$fullText) {
			$content['introtext'] = FeedgatorUtility::cleanText($introText,$clean_config,$spec,$fgParams);
		} else {
			$content['introtext'] = FeedgatorUtility::cleanText($introText,$clean_config,$spec,$fgParams);
			$content['fulltext'] = FeedgatorUtility::cleanText($fullText,$clean_config,$spec,$fgParams);
		}

		if(empty($content['fulltext']) AND !$fgParams->get('onlyintro')) $content['fulltext'] = $content['introtext']; // in case intro is shorter than trim setting

		if($fgParams->get('dotdotdot')) {
			$content['introtext'] = preg_replace('/([^<])([\s]*(?:<[^>]*>[\s]*){0,})$/', '$1...$2', $content['introtext']);
		}

		//onAfterFGCleanText -> $content array, $introText and $fullText strings
        $results = $dispatcher->trigger( 'onAfterFGCleanText', array( $content, $fgParams) );

		return $content;
	}

	/**
	* returns an array
	*  - first element is tags to process through htmLawed as allowed/disallowed elements
	*  - second element is tags defined by attribute for processing through htmLawed hook_tag function
	*/
    public static function getTagsToStrip()
    {
    	global $fgParams;

    	$s = $fgParams->get('strip_list');
    	$ts = explode(',',$s);
    	$ht = array();
    	$sp = array();

		foreach($ts as $k => $t) {
			if(JString::strpos($t,'=')) {
				$ht[] = $t;
				unset($ts[$k]);
			}
			if(JString::strpos($t,'*') !== false) {
				$sp[] = $t;
				unset($ts[$k]);
			}
		}

    	return array(implode(',',$ts), implode(',',$ht), implode(',',$sp));
    }

    public static function extractCalais($text,&$fgParams)
	{
		$app = JFactory::getApplication();

		$text = utf8_encode(strip_tags($text));
		if (!JString::trim($text)) {
			return '';
		}

		$externalID = md5(JPATH_ADMINISTRATOR.microtime());
		$paramsXML = '<c:params xmlns:c="http://s.opencalais.com/1/pred/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<c:processingDirectives c:contentType="TEXT/RAW" c:enableMetadataType="GenericRelations,SocialTags" c:outputFormat="Application/JSON" c:docRDFaccesible="true" >
</c:processingDirectives>
<c:userDirectives c:allowDistribution="true" c:allowSearch="true" c:externalID="'.$externalID.'" c:submitter="'.$app->getCfg('sitename').'">
</c:userDirectives>
<c:externalMetadata>
</c:externalMetadata>
</c:params>';

		$request = 'https://api.opencalais.com/enlighten/rest/';
		$args[] = 'licenseID='.$fgParams->get('calais_app_id').'&content='.urlencode($text).'&paramsXML='.urlencode($paramsXML);

		$response = FeedgatorUtility::getURL($request,$fgParams->get('scrape_type'),'yql',null,$args);
		try
		{
			$respObj = json_decode($response);
		}
		catch(Exception $e)
		{
			// If no response, then try the internal tag generation.
			return self::generateTags($text);
		}
		$allowedEntities = array_flip(array('Anniversary','City','Company','Continent','Country','Currency','EntertainmentAwardEvent','Facility','Holiday','IndustryTerm','MedicalCondition','MedicalTreatment','Movie','MusicAlbum','MusicGroup','NaturalFeature','OperatingSystem','Organization','PoliticalEvent','Position','Product','ProgrammingLanguage','ProvinceOrState','PublishedMedium','RadioProgram','RadioStation','Region','SportsEvent','SportsGame','SportsLeague','Technology','TVShow','TVStation'));
		$allowedEvents = array_flip(array('Acquisition','Alliance','AnalystEarningsEstimate','AnalystRecommendation','ArmedAttack','ArmsPurchaseSale','Arrest','Bankruptcy','BonusSharesIssuance','BusinessRelation','Buybacks','CandidatePosition','CompanyAccountingChange','CompanyAffiliates','CompanyCompetitor','CompanyCustomer','CompanyEarningsAnnouncement','CompanyEarningsGuidance','CompanyEmployeesNumber','CompanyExpansion','CompanyForceMajeure','CompanyFounded','CompanyInvestment','CompanyLaborIssues','CompanyLayoffs','CompanyLegalIssues','CompanyListingChange','CompanyLocation','CompanyMeeting','CompanyNameChange','CompanyProduct','CompanyReorganization','CompanyRestatement','CompanyTechnology','CompanyTicker','CompanyUsingProduct','ConferenceCall','ContactDetails','Conviction','CreditRating','DebtFinancing','DelayedFiling','DiplomaticRelations','Dividend','EmploymentChange','EmploymentRelation','EnvironmentalIssue','EquityFinancing','Extinction','FamilyRelation','FDAPhase','IndicesChanges','Indictment','IPO','JointVenture','ManMadeDisaster','Merger','MilitaryAction','MovieRelease','MusicAlbumRelease','NaturalDisaster','PatentFiling','PatentIssuance','PersonAttributes','PersonCareer','PersonCommunication','PersonEducation','PersonEmailAddress','PersonLocation','PersonParty','PersonRelation','PersonTravel','PoliticalEndorsement','PoliticalRelationship','PollsResult','ProductIssues','ProductRecall','ProductRelease','Quotation','SecondaryIssuance','StockSplit','Trial','VotingResult'));
		foreach($respObj as $obj) {
			if(isset($obj->_typeGroup)) {
				if($obj->_typeGroup == 'socialTag') {
					$results[] = $obj->name;
				} elseif($obj->_typeGroup == 'entities' AND isset($allowedEntities[$obj->_type])) {
					$results[] = $obj->name;
				} elseif($obj->_typeGroup == 'relations' AND isset($allowedEntities[$obj->_type])) {
					$results[] = $obj->name;
				}
			}
		}

		$results = self::removeIgnoreWords($results, 1, $fgParams);
		$results = is_array($results) ? array_slice($results, 0, $fgParams->get('max_tags')) : array();

		$terms = implode(',', $results);
		//$terms = utf8_decode($terms);

		return $terms;

	}

	public static function extractTerms($url,&$fgParams)
	{
		$results = array();
		$text = "SELECT * FROM contentanalysis.analyze WHERE url='".utf8_encode(strip_tags($url))."'";

		if (!JString::trim($text)) {
			return '';
		}

		$request = 'https://query.yahooapis.com/v1/public/yql';
		$args[] = 'q='.urlencode($text).'&format=json'.( ($fgParams->get('yahoo_app_id')) ? '&appid='.$fgParams->get('yahoo_app_id') : '');

		$response = FeedgatorUtility::getURL($request,$fgParams->get('scrape_type'),'yql',null,$args);
		try
		{
			$respObj = json_decode($response);
		}
		catch(Exception $e)
		{
			// If no response, then try the internal tag generation.
			return self::generateTags($text);
		}
		if($respObj->query->count) {
			foreach($respObj->query->results->entities->entity as $entity) {
				$results[] = $entity->text->content;
			}
		}

		if(isset($respObj->query->results->yctCategories)) {
			foreach($respObj->query->results->yctCategories->yctCategory as $yctCat) {
				$results[] = $yctCat->content;
			}
		}
		$results = self::removeIgnoreWords($results, 1, $fgParams);
		$results = is_array($results) ? array_slice($results, 0, $fgParams->get('max_tags')) : array();

		$terms = implode(',', $results);
		//$terms = utf8_decode($terms);

		return $terms;
	}

	public static function removeIgnoreWords($results, $utf = false, &$fgParams)
	{
		if ($fgParams->get('use_ignore_list') == '1') {
			$ignore_words = $fgParams->get('ignore_list');
			$ignore_words = $utf ? utf8_encode($ignore_words) : $ignore_words;
			$ignoreArray = explode(',', str_replace(', ',',',$ignore_words));
			$results = array_diff($results, $ignoreArray);
		}

		return $results;
	}

	public static function filterTerms($var)
	{
		global $fgParams;

		$keep = !empty($var) AND $var != '' AND $var != NULL AND !preg_match('/^\s*$/', $var);
		$min_tag_chars = (int)$fgParams->get('min_tag_chars');
		if (!empty($min_tag_chars) AND $min_tag_chars > 0) {
			$keep = ($keep AND strlen($var) >= $min_tag_chars);
		}

		return $keep;
	}

	// use a simple frequency algorithm to compute meta tags
	public static function generateTags($text,&$fgParams)
	{
		$text = strtolower(html_entity_decode(strip_tags($text), ENT_QUOTES));
		if (!JString::trim($text)) {
			return '';
		}
		$words = explode(' ', $text);

		array_walk($words, array('FeedgatorHelper','trimTags'));
		$words = array_filter($words, array('FeedgatorHelper','filterTerms'));
		$words = self::removeIgnoreWords($words,false,$fgParams);
		$words = array_count_values($words);
		arsort($words);
		$words = is_array($words) ? array_slice($words, 0, $fgParams->get('max_tags')) : array();
		$words = implode(',', array_keys($words));

		return $words;
	}

	public static function trimTags(&$term, $key)
	{
		$term = JString::trim($term);
		$term = str_replace(array("\n","\r"), ' ', $term);
		$term = preg_replace('/[,.?:;!()=\\*\']/', '', $term);
	}

	public static function getDynaLists(&$fgParams,$default)
	{
		$db = JFactory::getDBO();

		$sectionid = $fgParams->get('sectionid');

		$contentsections 			= array();
		$contentsections[-1] 		= array();
		$contentsections[-1][] = JHTML::_('select.option', -1, JText::_( 'FG_SELECT_SECTION' ), 'id', 'title');

		$sectioncategories 			= array();

		$pluginModel = FGFactory::getPluginModel();
		$rows = $pluginModel->loadInstalledPlugins();
		foreach($rows as $row) {
			if($row->published AND $row->installed) {
				$row->plugin = $pluginModel->getPlugin($row->extension);
				$row->plugin->getParams();
				if($sectionList = $row->plugin->getSectionList($fgParams,$default) AND count($sectionList)) {
					foreach($sectionList as $section) {
						$contentsections[$row->plugin->extension][] = $section;
					}
					$sectioncategories = $sectioncategories + $row->plugin->getSectionCategories($fgParams,$default);
				} else {
					$sectioncategories = null;
				}
			}
		}

		if(!$fgParams->get('content_type')) {
			$feedModel		= FGFactory::getFeedModel();
			$fgdefParams 	= $feedModel->getDefaultParams();
			if($fgdefParams->get('content_type') AND isset($contentsections[$fgdefParams->get('content_type')])) {
				$contentsections[''] = $contentsections[$fgdefParams->get('content_type')];
			}
		}

		return array('contentsections' => $contentsections, 'sectioncategories' => $sectioncategories);
	}

	public static function getPreviewArticle(&$content,&$fgParams,$channelTitle)
	{
		global $p;

		$previewArticle  = 	'<h3 class="red">'.JText::_('FG_PREV_ART').' for <span class="blue"><strong>'.$fgParams->get('title').
							'</strong> ('.$channelTitle.')</span></h3>';
		$previewArticle .=	'<div id="title" class="fgprevdata"><h4 class="fgprevinfo">'.JText::_('FG_PREV_TITLEALIAS').'</h4><ul>'.
							'<li><strong>'.JText::_('FG_PREV_TITLE').':</strong> '.$content['title'].'</li>' .
							'<li><strong>'.JText::_('FG_PREV_ALIAS').':</strong> '.$content['alias'].'</li>' .
							'</ul></div><br />';
		$previewArticle .=	'<div id="introtext" class="fgprevdata"><h4 class="fgprevinfo">'.JText::_('FG_PREV_INTROTEXT_TITLE').
							'</h4>'.$content['introtext'].'</div><br />';
		$previewArticle .=	'<div id="fulltext" class="fgprevdata"><h4 class="fgprevinfo">'.JText::_('FG_PREV_FULLTEXT_TITLE').
							'</h4>'.$content['fulltext'].'</div><br />';
		$previewArticle .=	'<div id="metadata" class="fgprevdata">' .
							'<h4>'.JText::_('FG_PREV_DATA').'</h4>' .
							'<ul>';
		$previewArticle .=	isset($content['created_by_alias']) ? '<li><strong>'.JText::_('FG_PREV_AUTHOR').':</strong> '.$content['created_by_alias'].'</li>' : '';
		$previewArticle .=	'<li><strong>'.JText::_('FG_PREV_PUB').':</strong> ' .$content['publish_up'].'</li>' .
							'<li><strong>'.JText::_('FG_PREV_KEYS').':</strong> '.$content['metakey'].'</li>' .
							'<li><strong>'.JText::_('FG_PREV_DESC').':</strong> '.$content['metadesc'].'</li>' .
							'</ul>';
		if($fgParams->get('debug')) {
			$rDebug = $fgParams->get('rDebug');
			$fgParams->set('rDebug','');
			unset($content['introtext'],$content['fulltext']);
			$previewArticle .= '<h4 class="fgprevinfo">FG Debug Dump - Content</h4><pre>'.FeedgatorUtility::buffer($content).'</pre>';
			$previewArticle .= '<h4 class="fgprevinfo">FG Debug Dump - htmLawed config</h4><pre>'.FeedgatorUtility::buffer($fgParams->get('clean_config')).'<br/>'.
								FeedgatorUtility::buffer($fgParams->get('spec')).'</pre>';
								//'<h4 class="fgprevinfo">FG Debug Dump - fgParams</h4><pre>'.FeedgatorUtility::buffer($fgParams->data).'</pre>';
			$previewArticle .= $rDebug ? '<h4 class="fgprevinfo">FG Debug Dump - Readability processing</h4>'.$rDebug : '';
			$previewArticle .= '<h4 class="fgprevinfo">FG Profiling</h4><pre>'.FeedgatorUtility::buffer($p->getBuffer()).'</pre>';
		}

		$previewArticle .=	'</div>' .
							'<br /><a href="javascript:closeMsgArea();">Close this window</a><br />';

		return $previewArticle;
	}

	public static function renderCpanel($aAttribs=null,$iAttribs=null,$text='')
	{
		$a = '';
		$i = '';
		if(!empty($iAttribs)) {
			foreach($aAttribs as $k => $v) {
				$a .= $k.'="'.$v.'" ';
			}
		} else {
			$a = 'href="#"';
		}
		if(!empty($iAttribs)) {
			foreach($iAttribs as $k => $v) {
				$i .= $k.'="'.$v.'" ';
			}
		}
		?>
		<div style="float: left;">
			<div class="icon">
				<a <?php echo $a; ?>>
					<?php if(!empty($iAttribs)) { ?>
						<img <?php echo $i; ?>/>
					<?php }?>
					<span><?php echo $text ?></span>
				</a>
			</div>
		</div>
		<?php
	}

	public static function renderForm(&$data,$show_default=false,$options=array())
	{
		if($show_default) {
			// we're going to cache the default params and the option values
			static $deffgParams = null;
			static $optvalues = array();

			$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'views'.DS.'feedgator'.DS.'tmpl'.DS.'default_feed.xml';
			if(empty($deffgParams)) {
				$model = FGFactory::getFeedModel();
				$deffgParams = $model->getDefaultParams();
			}
			if(empty($optvalues)) {
				$xml = JFactory::getXML($xmlfile,true);
				$i = 0;
				foreach($xml->params as $params) {
					foreach($params as $param) {
						$j = 0;
						foreach($param as $value) {
							$name = (string)$param['name'];
							$optvalues[$name][$j] = (string)$value;
							$j++;
						}
					}
					$i++;
				}
			}
		}

		$obj = is_object($data) ? 1 : 0;
		if(!isset($options['legend'])) $options['legend']=null;
		if(!isset($options['fieldset_class'])) $options['fieldset_class']='adminform';
		if(!isset($options['ul_class'])) $options['ul_class']='adminformlist';
		if(!isset($options['control'])) $options['control']='params';

		//print_r($data);
		//if($fieldset) ?>
		<fieldset <?php if(isset($options['fieldset_id'])) { ?>id="<?php echo $options['fieldset_id']; ?>"<?php } ?> class="<?php echo $options['fieldset_class']; ?>">
	        <?php if($options['legend']) { ?><legend><?php echo JText::_( $options['legend'] ); ?></legend><?php } ?>
	        <ul class="<?php echo $options['ul_class']; ?>">
			<?php foreach($data as &$field):
				if($obj) { ?>
					<li><?php echo $field->label.$field->input;?></li>
				<?php } else { ?>
					<li><div class="col left"><?php echo $field[0]; ?></div>
						<div class="col middle">
						<?php if(strpos($field[1],'type="radio"')) { ?>
							<fieldset id="<?php echo $options['control'].$field[5]; ?>" class="radio inputbox"><?php echo $field[1];?></fieldset>
						<?php } else {
					//		if($field[5] == 'content_type') {
					//			$defoverrides = $deffgParams->getParams('data','feed_1');
					//			foreach($defoverrides as $defoverride) {
					//				if($defoverride[5] == 'content_type') {
					//					echo str_replace('</li>','',$defoverride[1]);
					//					break;
					//				}
					//			}
					//		} else {
								echo str_replace('</li>','',$field[1]);
					//		}
						} ?>
						</div>
						<div class="col right">
						<?php if($show_default AND strpos($field[3],'spacer') === false) {
							if($deffgParams->get($field[5]) == '') {
								if(!in_array(trim($field[5]),array('title','feed'))) { ?>
									<div>No Default Setting</div>
								<?php }
							}  elseif($field[5] == 'default_author') {
								$id = $deffgParams->get($field[5]);
								$user = JFactory::getUser($id);
								?>
								<div>Default Setting is: <em><?php echo $user->name; ?></em></div>
								<?php
							} elseif($field[5] == 'access') {
								$access = $deffgParams->get($field[5]);
								$db = JFactory::getDbo();
								if(J_VERSION < 1.6) {
									$query	= 'SELECT name'
											. ' FROM #__groups'
											. ' WHERE id = '.(int)$access;

								} else {
									$query	= 'SELECT title'
											. ' FROM #__viewlevels'
											. ' WHERE id = '.(int)$access;
								}
								$db->setQuery( $query );
								?>
								<div>Default Setting is: <em><?php echo $db->loadResult(); ?></em></div>
								<?php
							} elseif(!in_array($field[5],array('published','sectionid','catid'))) {
								if(in_array($field[5],array('link_target','target_frame','feed_author_article'))) {
									$default = isset($optvalues[$field[5]][$deffgParams->get($field[5])]) ? $optvalues[$field[5]][$deffgParams->get($field[5])] : $deffgParams->get($field[5]);
								} elseif($field[5] == 'feed_img' AND $deffgParams->get($field[5]) == -1) {
									$default = 'No default image';
								} else {
									$default = isset($optvalues[$field[5]][$deffgParams->get($field[5])+1]) ? $optvalues[$field[5]][$deffgParams->get($field[5])+1] : $deffgParams->get($field[5]);
								}								?>
								<div>Default Setting is: <em><?php echo $default; ?></em></div>
							<?php } ?>
						<?php } ?>
						</div>
					</li>
				<?php } ?>
			<?php endforeach; ?>
	        </ul>
		</fieldset>
        <?php
	}

	public static function renderVersionUpdatePanel(&$version_data)
	{
		?>
		<form name="adminForm" method="post">
		<p>Your Installed Version: <strong><?php echo FG_VERSION; ?></strong>
		<br />
		Latest Stable Version: <strong><span class="<?php echo $version_data['stable']['upgrade'] ? 'red' : ''; ?>">
			<?php if($version_data['stable']['upgrade']): ?>
				<a href="#" onclick="if(confirm('Do you wish to upgrade now?')) { pressbutton('<?php echo $version_data['dev']['link']; ?>'); return false; }" class="hasTip" title="Upgrade Available::Click here to upgrade automatically!">
					&gt;&gt; <?php echo $version_data['stable']['v']; ?> &lt;&lt;</a>
			<?php else: ?>
				<?php echo $version_data['stable']['v']; ?>
			<?php endif; ?>
			</span></strong>
		<br />
		<?php if(!empty($version_data['dev'])): ?>
			Latest Development Version: <strong><span class="<?php echo $version_data['dev']['upgrade'] ? 'red' : ''; ?>">
				<?php if($version_data['dev']['upgrade']): ?>
					<a href="#" onclick="if(confirm('Do you wish to upgrade now?')) { pressbutton('<?php echo $version_data['dev']['link']; ?>'); return false; }" class="hasTip" title="Upgrade Available::Click here to upgrade automatically!">
					&gt;&gt; <?php echo $version_data['dev']['v']; ?> &lt;&lt;</a>
				<?php else: ?>
					<?php echo $version_data['dev']['v']; ?>
				<?php endif; ?>
			</span></strong>
			</p>
		<?php endif; ?>
		<input type="hidden" name="install_url" value="">
		<input type="hidden" name="installtype" value="url">
		<input type="hidden" name="task" value="doInstall">
		<input type="hidden" name="option" value="com_installer">
		<?php echo JHTML::_('form.token');
	}
}