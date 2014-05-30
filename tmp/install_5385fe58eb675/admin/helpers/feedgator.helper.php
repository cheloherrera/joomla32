<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.7
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
	function processFeedItem(&$item,&$fgParams,&$plugin,$channelTitle,$preview,$update)
	{
		FeedgatorUtility::profiling('Start SimplePie Item Processing');

		$user = &JFactory::getUser();
		$model = &FGFactory::getFeedModel();
		if($model->get('_id') != $fgParams->get('id')) {
			$model->setId($fgParams->get('id'));
		}
		$imports = $model->getImports();
		$hash = md5($item->get_id());
		$fgParams->set('hash',$hash);

		$origLink = $item->get_permalink();
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

		// this will get full text if available in feed or return description if no full text
		FeedgatorUtility::profiling('Make Title and Alias');
		$feed_text = $fgParams->get('show_html') ? JString::trim($item->get_content()) : JString::trim($item->get_description());
		if(empty($feed_text)) {
			$feed_text = $fgParams->get('show_html') ? JString::trim($item->get_description()) : JString::trim($item->get_content());
		}
		$feed_text = FeedgatorUtility::adjustText($feed_text,$fgParams);
		$content = FeedgatorHelper::makeTitleAlias($item,$content,$feed_text,$channelTitle,$hash,$fgParams);

		// initial duplicate checking
		if(!$preview) {
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
			FeedgatorHelper::preProcessEnclosures($encs,$content,$fgParams,false,false);
			FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),$content['id'],'enclosure',$fgParams);

		} elseif(intval($content['id']) == 0 OR ($content['id'] AND $fgParams->get('compare_existing'))) { // article processing
			$source_text = $fgParams->get('fulltext') ? FeedgatorHelper::getFullText($origLink,$fgParams) : '';
			$source_text = FeedgatorUtility::adjustText($source_text,$fgParams);
//			jexit($source_text);
			if($alt_title = $fgParams->get('readability_title') AND $alt_title != 1 AND !empty($alt_title)) {
				$content['title'] = $alt_title;
				FeedgatorHelper::makeTitleAlias($item,$content,$feed_text,$channelTitle,$hash,$fgParams);
			}

			//Check item filtering
			FeedgatorUtility::profiling('Check Filtering');
			if($fgParams->get('filtering')) {
				if($fgParams->get('filter_blacklist')) {
					foreach( explode(',',strtolower($fgParams->get('filter_blacklist',true))) as $value) {
						if(JString::strpos(strtolower($content['title'].' '.$feed_text.' '.$source_text),$value) !== false) {
							FeedgatorUtility::profiling('Item Blacklisted');
							if($fgParams->get('save_filter_result')) FeedgatorHelper::saveImport($fgParams->get('hash'),$fgParams->get('id'),-1,$plugin->extension,$fgParams);
							return false; // found a blacklist word - stop
						}
					}
				}

				if($fgParams->get('filter_whitelist')) {
					foreach( explode(',',strtolower($fgParams->get('filter_whitelist',true))) as $value) {
						if(JString::strpos(strtolower($content['title'].' '.$feed_text.' '.$source_text),$value) !== false) {
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
			if(!$content['created_by']) $content['created_by'] = 62;
			$author = $item->get_author();
			switch($fgParams->get('save_author'))
			{
				case 1:
				default:
				$admin = &JFactory::getUser($content['created_by']);
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
				if($source_text) {
					$source_text = ($fgParams->get('feed_author_article') == 'top') ? $authors.$source_text : $source_text.$authors;
				} else {
					$source_text = ($fgParams->get('feed_author_article') == 'top') ? $authors.$feed_text : $feed_text.$authors;
				}
			}

			FeedgatorUtility::profiling('Process Feed Images');
			$feed_images = FeedgatorHelper::processImages($origLink,$feed_text,$content,$fgParams);
			$f = empty($feed_images);
			FeedgatorUtility::profiling('Process Source Images');
			$source_images = FeedgatorHelper::processImages($origLink,$source_text,$content,$fgParams);
			$s = empty($source_images);

			$enc_image = false;
			$thumb = false;
			if($encs = $item->get_enclosures()) {
				FeedgatorHelper::preProcessEnclosures($encs,$content,$fgParams,$enc_image,$thumb,$f,$s,$feed_text,$source_text);
			}
			if($encs AND $enc_image) {
				if($feed_text) {
					FeedgatorUtility::profiling('Process Feed Images (+enclosure)');
					FeedgatorHelper::processImages($origLink,$feed_text,$content,$fgParams,$feed_images);
				} elseif($source_text) {
					FeedgatorUtility::profiling('Process Source Images (+enclosure)');
					FeedgatorHelper::processImages($origLink,$source_text,$content,$fgParams,$source_images);
				}
			}
			if($encs AND $thumb) {
				if($feed_text) {
					FeedgatorUtility::profiling('Process Feed Images (+thumbnail)');
					FeedgatorHelper::processImages($origLink,$feed_text,$content,$fgParams,$feed_images);
				} elseif($source_text) {
					FeedgatorUtility::profiling('Process Source Images (+thumbnail)');
					FeedgatorHelper::processImages($origLink,$source_text,$content,$fgParams,$source_images);
				}
			}

			// save image from HTML need to make this more efficient
			if($fgParams->get('alt_img_ext')) {
				FeedgatorUtility::profiling('Image Balancing');
				if($f != $s) {
					if($s AND $source_text) {
						$source_text = @$feed_images[0].$source_text;
						FeedgatorUtility::profiling('Feed Image added to Feed (image balancing)');
						//FeedgatorHelper::processImages($origLink,$source_text,$content,$fgParams,array_merge($feed_images,$source_images));
					} elseif($f) {
						$feed_text = @$source_images[0].$feed_text;
						FeedgatorUtility::profiling('Source Image added to Feed (image balancing)');
						//FeedgatorHelper::processImages($origLink,$feed_text,$content,$fgParams,array_merge($feed_images,$source_images));
					}
				} elseif( (!$f AND !$s) AND @$feed_images[0] != @$source_images[0]) {
					$feed_text = @$source_images[0].$feed_text;
					FeedgatorUtility::profiling('Source Image added to Feed (image balancing)');
				}
			}

			// make introtext,fulltext whilst cleaning
			FeedgatorUtility::profiling('Start Make Parts and Filter/Clean Text');
			$content = FeedgatorHelper::makeParts($content, $feed_text, $source_text, $fgParams);
			FeedgatorUtility::profiling('End Make Parts and Filter/Clean Text');

			// test for empty content and maybe abort
			if($fgParams->get('ignore_empty_intro') AND empty($content['introtext'])) return false;

			if ($fgParams->get('show_orig_link') OR !$content['introtext']) {
				FeedgatorUtility::profiling('Trackback Processing');
				$target = ($fgParams->get('target_frame') == 'none') ? '' : 'target="'.(($fgParams->get('target_frame') == 'custom') ? $fgParams->get('custom_frame') : $fgParams->get('target_frame')).'"';
				if (!empty($origLink)){
					if($fgParams->get('shortened_url')) {
						switch($fgParams->get('shortened_url'))
						{
							case 1: // Bit.ly
								$origLink = FeedgatorUtility::getUrl('http://api.bitly.com/v3/shorten?login=feedgator&apiKey=R_9e7b64db664f89150100e95fbcaa6a85&longUrl='.FeedgatorUtility::encode_url($origLink).'&format=txt&x_login='.$fgParams->get('bitly_login').'&x_apiKey='.$fgParams->get('bitly_api_key'),$fgParams->get('scrape_type'),'noheader');
							break;

							case 2: // Goo.gl - we have to use fopen as cURL doesn't seem to work!
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

			if ($fgParams->get('compute_tags')) {
				FeedgatorUtility::profiling('Start Tag/Keyword Processing');
				if ($fgParams->get('use_yahoo_te') AND $fgParams->get('yahoo_app_id')){
					$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::extractTerms($content['introtext'].' '.$content['fulltext']);
				} else {
					if ($fgParams->get('use_addkeywords')) { // need to add a check that AK is published!
						if(file_exists(JPATH_ROOT .DS.'plugins'.DS.'system'.DS.'addkeywords.php')) {
							$addkeywordmeta = plgSystemAddKeywords::generateMeta($content['introtext'].' '.$content['fulltext'], true, true, null);
							$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . $addkeywordmeta['keywords'];
							$content['metadesc'] .= (empty($content['metadesc']) ? '' : ',') . $addkeywordmeta['description'];
						} else {
							$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::generateTags($content['introtext'].' '.$content['fulltext']);
						}
					} else {
						$content['metakey'] .= (empty($content['metakey']) ? '' : ',') . FeedgatorHelper::generateTags($content['introtext'].' '.$content['fulltext']);
					}
				}
					FeedgatorUtility::cleanMeta($content);
				FeedgatorUtility::profiling('End Tag/Keyword Processing');
			}

			$itemDate =& JFactory::getDate($item->get_date(), JFactory::getConfig()->getValue('config.offset'));
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

	function makeTitleAlias(&$item,&$content,&$feed_text,$channelTitle,$hash,&$fgParams)
	{
		if(!isset($content['title'])) {
			//jexit($item->get_title());
			$content['title'] = JString::trim($item->get_title());
			if(!$content['title']) { // see if feed text might have a likely candidate
				$regex = '#<(?:h1|h2|h3|b|strong)[^>]*>([\s\S]*?)<\/(?:h1|h2|h3|b|strong)>#i';
				preg_match($regex,$feed_text,$matches);
				$content['title'] = JFilterOutput::cleanText($matches[1]);
				if(empty($content['title'])) {
					$datenow =& JFactory::getDate();
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

	function findDuplicates(&$content,&$imports,$hash,$id,&$fgParams,&$plugin,$thorough=false,$exhaustive=false)
	{
		$db = &JFactory::getDBO();

		$debug = $fgParams->get('debug');

		if(!$thorough AND !$exhaustive) { // basic
			if($existId = $plugin->findDuplicates('id',$id)) {
				if($debug) FeedgatorUtility::profiling('Basic Loaded ID:'.$existId.','.$content['alias'].','.$content['title']);
				return $existId;
			}
		}

		elseif($thorough and !$exhaustive) { // thorough
		// todo - add in a duplicates alert here by comparing IDs
			if ($content['title'] AND $content['alias']) {
				if($existId = $plugin->findDuplicates('alias',$content['alias'])) {
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
			} elseif ($content['title']){
				if($existId = $plugin->findDuplicates('title',$content['title'])) {
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
			if($existId = $plugin->findDuplicates($type,$content[$type])) {
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
				$row = &JTable::getInstance('Import','Table');
				$row->delete($import['id']);
				unset($import);
				$model = &FGFactory::getFeedModel();
				$model->_imports = $imports;
			}
		}

		return false;
	}

	function processImages($origLink,&$text,&$content,&$fgParams,&$images = array())
	{
		$replace = array();
		$regex = '/<img[^>]*>/';

		// string containing disallowed image sources to help prevent small images
		$disallowed = 'images.pheedo.com';

		$dom = new DOMDocument();
		$dom2 = new DOMDocument();
		@$dom->loadHTML($text);
		$imgs = $dom->getElementsByTagName('img');
		$k = 0;
		foreach($imgs as $img) {
			$saved = false;
			if($src = $img->getAttribute('src') AND !in_array($src,$images) AND strpos($src,$fgParams->get('base')) === false) { // prevents repeat processing
				FeedgatorUtility::profiling('Processing Image SRC: '.$src);
				// fix rel and munged paths
				$src = FeedgatorUtility::encode_url(FeedgatorUtility::makeAbsUrl($origLink,$src));
				$image_details = array();
				$image_pass = 0;
				if(strpos($src,$disallowed) === false) {
					if($fgParams->get('img_check',1) AND function_exists('getimagesize')) {
						if($image_details = @getimagesize($src) AND !in_array($image_details[0],array(1,2)) AND !in_array($image_details[1],array(1,2))) {
						FeedgatorUtility::profiling('Image Details: '.print_r($image_details,true));
						$image_pass = 1;
						}
					} else {
						FeedgatorUtility::profiling('getimagesize not installed or over-ridden: image passed');
						$image_pass = 1;
					}
				}
				if($image_pass) {
					$title = $img->getAttribute('title') ? $k.'_'.$img->getAttribute('title') : '';
					$alt = $img->getAttribute('alt') ? $k.'_'.$img->getAttribute('alt') : '' ;
					if($fgParams->get('save_img')) { // consider restoring the JPath::clean()
						if(!JFolder::exists($fgParams->get('img_savepath'))) JFolder::create($fgParams->get('img_savepath'));
						// find image name and extension
						$filename = $fgParams->get('name_prefix').FeedgatorHelper::getImageName($title,$alt,$src,$fgParams->get('img_name_type',0),$image_details);
						$filepath = $fgParams->get('img_savepath').$filename;
						//create image file
						if(!file_exists($filepath)) {
							if($contents = FeedgatorUtility::getUrl($src,$fgParams->get('scrape_type'),'images',$filepath)) {
								$saved = true;
								//if(FeedgatorUtility::savefile($contents,$name,$update=false,$header=null,$fgParams->get('savepath').'images')) $saved = true;
							}
						} else {
							$saved = true;
						}
						if($saved) $img->setAttribute('src', $fgParams->get('img_srcpath').$filename);
					} else {
						$img->setAttribute('src',$src);
					}
					FeedgatorUtility::profiling('Final Image SRC: '.$img->getAttribute('src'));
				//	$class = $img->getAttribute('class');
				//	$width = $img->getAttribute('width');
				//	$height = $img->getAttribute('height');
					if(strlen($alt) >= JString::strlen($content['title']) OR !$alt) {
						$img->setAttribute('alt',$content['title']);
					}
					if($fgParams->get('rmv_img_style')) {
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
					$images[$k] = $dom2->saveHTML();
					$dom2->removeChild($new_img);

					// hack to avoid encoding problems
					$text = preg_replace($regex,'fg_img'.$k,$text,$limit=1);
					$replace[$k] = 'fg_img'.$k;
					$k++;
				} else {
					FeedgatorUtility::profiling('Image Rejected');
					$text = preg_replace($regex,'',$text,1);
				}
			}
		}
		$text = str_replace(array_reverse($replace),array_reverse($images),$text);

		return $images;
	}

	function getImageName($title,$alt,$src,$name_type,$image_details,$add_ext = 1)
	{
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
		$name_type++;
		if(empty($name)) $name = FeedgatorHelper::getImageName($title,$alt,$src,$name_type,$image_details,0);
		$name = JFile::makeSafe(FeedgatorUtility::stringURLSafe($name));

		return $add_ext ? $name.$ext : $name;
	}

	function preProcessEnclosures(&$encs,&$content,&$fgParams,&$enc_image,&$thumb,$f=false,$s=false,&$feed_text='',&$source_text='')
	{
		$enc_links = array();
		foreach($encs as &$enc) {
			if(!isset($enc_links[$enc->get_link()])) { // protects against duplicate enclosures
				$enc_links[$enc->get_link()] = 1;
				if($enc->get_type()) {
					// get any enclosure image only if no feed image
					if(stripos($enc->get_real_type(),'image') !== false AND $f AND $fgParams->get('process_enc_images')) {
						FeedgatorUtility::profiling('Process Enclosure Image');
						$enc_image = '<img src="'.$enc->get_link().'" alt="'.$content['title'].'"/>';
						$feed_text = $enc_image.$feed_text;
						if($source_text AND ($s OR $fgParams->get('force_enc_image'))) {
							$source_text = $enc_image.$source_text;
						}
					} else {
						FeedgatorUtility::profiling('Process Enclosures');
						$source_text ? FeedgatorHelper::processEnclosures($enc,$source_text,$content,$fgParams) : FeedgatorHelper::processEnclosures($enc,$feed_text,$content,$fgParams);
					}
				// use any thumbnail image only if no feed image
				} elseif($thumbnail = $enc->get_thumbnail() AND $f AND $fgParams->get('process_enc_images')) {
					FeedgatorUtility::profiling('Process Enclosure Thumbnail');
					$thumb = '<img src="'.$thumbnail.'" alt="'.$content['title'].'"/>';
					$feed_text = $thumb.$feed_text;
					if($source_text AND ($s OR $fgParams->get('force_enc_image'))) {
						$source_text = $thumb.$source_text;
					}
				}
			}
		}
	}

	function processEnclosures(&$e,&$text,&$content,&$fgParams)
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

	function saveEnclosure($name,$type,$src,&$fgParams)
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

	function saveImport($hash,$feed_id,$content_id,$plugin,&$fgParams)
	{
		$import 				= array();
		$import['hash'] 		= $hash;
		$import['feed_id'] 		= $feed_id;
		$import['content_id'] 	= $content_id;
		$import['plugin'] 		= $plugin;

		$fgParams->get('irow') ? $irow = &$fgParams->get('irow') : $irow = &JTable::getInstance('Import','Table');
		$irow->save($import);
		$fgParams->set('hash','');
	}

	function getFullText($origLink,&$fgParams)
	{
		FeedgatorUtility::profiling('Get Source Full Text');

		require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'readability'.DS.'Readability.php');

		$page = FeedgatorUtility::getUrl($origLink,$fgParams->get('scrape_type'),'html');
		$parts = FeedgatorUtility::extractHTTP($page,$fgParams);
		$body = FeedgatorUtility::convert_to_utf8($parts['body'],$parts['header']);
//		echo $body;
		if($body) {
			$readability = new Readability($body,$origLink);
			$readability->convertLinksToFootnotes = $fgParams->get('link_table') ? true : false;
			if($readability->init()) {
				FeedgatorHelper::cleanSpecifically($readability,$fgParams);
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
				$return .= '<div id="fgimages">'.$readability->articleImages->innerHTML.'</div>';
				return $return;
			}
		}
		FeedgatorUtility::profiling('Failed to Get Source Full Text: body empty');
		return false;
	}

	/**
	* Apply filtering to a Readability node looking at all elements of type "tag" with attribute(s) set in params
	*/
	function cleanSpecifically(&$readability,&$fgParams)
	{
		$e = $readability->articleContent;

		$clean_config = array();
		$regex = '/(?:\-|\+|\*)?([\S]*)\s+([^=]*)=([\s\S]*)/';

		$parts = $fgParams->get('remove_by_attrib');
		$parts = explode(',',$parts);

		foreach($parts as $part) {
			if(strpos($part,'+') === false) {
				preg_match($regex,$part,$matches);
				if(!empty($matches)) { // this is seriously ugly!
					$clean_config[$matches[1]][$matches[2]] = empty($clean_config[$matches[1]][$matches[2]]) ? array($matches[3]) : array_merge($clean_config[$matches[1]][$matches[2]],array($matches[3]));
				}
			}
		}

		foreach($clean_config as $tag => $attribs) {
			$targetList = $e->getElementsByTagName($tag);
			for ($y=$targetList->length-1; $y >= 0; $y--) {
				foreach($attribs as $k => $v) {
					if(in_array($targetList->item($y)->getAttribute($k),$v)) {
						$readability->dbg('Cleaning Specifically: removed ' . $tag . ' (' . $k . ':' . $targetList->item($y)->getAttribute($k) . ')');
						$targetList->item($y)->parentNode->removeChild($targetList->item($y));
						continue;
					}
				}
			}
		}
	}

	// Create article introtext, fulltext (based on maximum length for introtext)
	function makeParts($content, $feed_text, $source_text, &$fgParams)
	{
		//$dispatcher =& JDispatcher::getInstance();
		//format br's as per HTML (not XHTML)
		$feed_text = str_replace(array('<br>','<br/>'),'<br />',$feed_text);
		$source_text = str_replace(array('<br>','<br/>'),'<br />',$source_text);

		if($fgParams->get('remove_dups_emp')) {
			while( (JString::strpos($feed_text,'<br /><br />') !== false) ) {
				$feed_text = str_replace('<br /><br />','<br />',$feed_text);
			}
			while( (JString::strpos($source_text,'<br /><br />') !== false)) {
				$source_text = str_replace('<br /><br />','<br />',$source_text);
			}
		}

		$clean_config = array('safe' => 1, 'comment' => 1, 'abs_url' => ($fgParams->get('rel_src',0) ? 0 : 1), 'base_url' => $fgParams->get('fBase'));
		$spec = 'img=src,height,width;table=border,width,cellspacing,cellpadding;'; // not used at present but see forum post http://joomlacode.org/gf/project/feedgator/forum/?action=ForumBrowse&forum_id=6709&_forum_action=ForumMessageBrowse&thread_id=20372

		if($fgParams->get('disallow_attribs')) { $clean_config['deny_attribute'] = '* -title -href -target -alt'; }
		//if($fgParams->get('remove_ms')) { $clean_config['clean_ms_char'] = 2; } // disabled as causes problems - need new method
		if($fgParams->get('xhtml_clean')) { $clean_config['valid_xhtml'] = 1; }
		if($fgParams->get('remove_bad')) { $clean_config['keep_bad'] = 6; }
		if($fgParams->get('link_nofollow')) { $clean_config["anti_link_spam"] = array('`.`',''); }
		$clean_config['tidy'] = $fgParams->get('tidy');
		if($fgParams->get('strip_html_tags')) {
			$feed_text = JString::trim(strip_tags($feed_text));
			$source_text = JString::trim(strip_tags($source_text));
		} elseif(list($tags) = FeedgatorHelper::getTagsToStrip()) {
			if(strpos($tags,'+') !== false) {
				$tags = str_replace('+','',$tags);
			} else {
				$tags = str_replace(' ','',$tags);
				$tags = '*-'.str_replace(',',' -',$tags);
			}
			$clean_config['elements'] = $tags;
		}
		$clean_config['hook_tag'] = array('FeedgatorUtility','hook_tag_cleaning');

		if($fgParams->get('debug')) $fgParams->set('clean_config',FeedgatorUtility::makeINIString($clean_config));

		// trim text to max length
		list($source_text) = FeedgatorUtility::splitText($source_text,$fgParams->get('max_length'),$fgParams->get('max_length_type'),$keep_tags=true);
		list($feed_text) = FeedgatorUtility::splitText($feed_text,$fgParams->get('max_length'),$fgParams->get('max_length_type'),$keep_tags=true);
		$trimTo = $fgParams->get('trim_to');

		if($fgParams->get('combine_text') AND !$fgParams->get('onlyintro')) {
			list($introText) = FeedgatorUtility::splitText($feed_text,$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
			if(!$introText) list($introText) = FeedgatorUtility::splitText($source_text,$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
			$fullText = $source_text;
		} else {
			list($introText,$fullText) = $source_text ? FeedgatorUtility::splitText($source_text,$trimTo,$fgParams->get('trim_type'),$keep_tags=true) : FeedgatorUtility::splitText($feed_text,$trimTo,$fgParams->get('trim_type'),$keep_tags=true);
		}

		//onBeforeFGCleanText -> $content array, $introText and $fullText strings
        //$results = $dispatcher->trigger( 'onBeforeFGCleanText', array( $content, $introText, $fullText, $fgParams) );

		if($fgParams->get('onlyintro') OR !$trimTo OR !$fullText) {
			$content['introtext'] = FeedgatorUtility::cleanText($introText,$clean_config,$spec);
		} else {
			$content['introtext'] = FeedgatorUtility::cleanText($introText,$clean_config,$spec);
			$content['fulltext'] = FeedgatorUtility::cleanText($fullText,$clean_config,$spec);
		}

		if(empty($content['fulltext']) AND !$fgParams->get('onlyintro')) $content['fulltext'] = $content['introtext']; // in case intro is shorter than trim setting

		if($fgParams->get('dotdotdot')) {
			if (strpos(substr($content['introtext'], -1),'>') !== false) {
				$content['introtext'] = preg_replace('/(.*?)(<[^>]*?>)$/', '$1...$2', $content['introtext']);
			} else {
				$content['introtext'] .= '...';
			}
		}

		//onAfterFGCleanText -> $content array, $introText and $fullText strings
        //$results = $dispatcher->trigger( 'onAfterFGCleanText', array( $content, $introText, $fullText, $fgParams) );

		return $content;
	}

    function getTagsToStrip()
    {
    	global $fgParams;

    	$s = $fgParams->get('strip_list');
    	$w = '';
    	if(strpos($s,'+') === 0) {
    		$s = FeedgatorUtility::str_replace_first('+','',$s);
    		$w = '+';
    	}
    	$ts = explode(',',$s);
    	$ht = array();

		foreach($ts as $k => $t) {
			if(JString::strpos($t,'=')) {
				$ht[] = $t;
				unset($ts[$k]);
			}
		}

    	return array($w.implode(',',$ts),$w.implode(',',$ht));
    }

	function getPreviewArticle(&$content,&$fgParams,$channelTitle)
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
			$previewArticle .=	'<h4 class="fgprevinfo">FG Debug Dump - Content</h4><pre>'.print_r($content,true).'</pre>' .
								'<h4 class="fgprevinfo">FG Debug Dump - fgParams</h4><pre>'.print_r($fgParams->_registry['_default']['data'],true).'</pre>';
			$previewArticle .=	$rDebug ? '<h4 class="fgprevinfo">FG Debug Dump - Readability processing</h4>'.$rDebug : '';
			$previewArticle .=	'<h4 class="fgprevinfo">FG Profiling</h4><pre>'.print_r($p->getBuffer(),true).'</pre>';
		}

		$previewArticle .=	'</div>' .
							'<br /><a href="javascript:closeMsgArea();">Close this window</a><br />';

		return $previewArticle;
	}

	function extractTerms($text)
	{
		$fgConfig = JComponentHelper::getParams ('com_feedgator');

		$text = html_entity_decode( $text, ENT_QUOTES );
		$text = urlencode(utf8_encode(strip_tags($text)));

		if (!JString::trim($text)) {
			return '';
		}

		$request = 'http://api.search.yahoo.com/ContentAnalysisService/V1/termExtraction';
		$request .= '?context='.$text.'&output=php&appid='.$fgConfig->get('yahoo_app_id');

		$response = FeedgatorUtility::getURL($request,$fgConfig->get('scrape_type'),'noheader');

		// If no response, then try the internal tag generation.
		if ($response === false) return self::generateTags($text);
		$respArray = unserialize($response);
		$results = $respArray['ResultSet']['Result'];
		$results = self::removeIgnoreWords($results, 1);
		$results = is_array($results) ? array_slice($results, 0, $fgConfig->get('max_tags')) : array();

		$terms = implode(',', $results);
		//$terms = utf8_decode($terms);

		return $terms;

	}

	function removeIgnoreWords($results, $utf = false)
	{
		$fgConfig = JComponentHelper::getParams ('com_feedgator');

		if ($fgConfig->get('use_ignore_list') == '1') {
			$ignore_words = $fgConfig->get('ignore_list');
			$ignore_words = $utf ? utf8_encode($ignore_words) : $ignore_words;
			$ignoreArray = explode(',', $ignore_words);
			$results = array_diff($results, $ignoreArray);
		}

		return $results;
	}

	function filterTerms($var)
	{
		$fgConfig = JComponentHelper::getParams ('com_feedgator');
		$keep = !empty($var) AND $var != '' AND $var != NULL AND !preg_match('/^\s*$/', $var);
		$min_tag_chars = $fgConfig->get('min_tag_chars');
		if (!empty($min_tag_chars) AND intval($fgConfig->get('min_tag_chars')) > 0) {
			$keep = $keep AND strlen($var) >= intval($fgConfig->get('min_tag_chars'));
		}

		return($keep);
	}

	// use a simple frequency algorithm to compute meta tags
	function generateTags($text)
	{
		$fgConfig = JComponentHelper::getParams ('com_feedgator');

		$text = strtolower(html_entity_decode(strip_tags($text), ENT_QUOTES));
		if (!JString::trim($text)) {
			return '';
		}
		$words = explode(' ', $text);

		array_walk($words, array('FeedgatorHelper','trimTags'));
		$words = array_filter($words, array('FeedgatorHelper','filterTerms'));
		$words = self::removeIgnoreWords($words);
		$words = array_count_values($words);
		arsort($words);
		$words = is_array($words) ? array_slice($words, 0, $fgConfig->get('max_tags')) : array();
		$words = implode(',', array_keys($words));

		return $words;
	}

	function trimTags(&$term, $key)
	{
		$term = JString::trim($term);
		$term = str_replace(array("\n","\r"), ' ', $term);
		$term = preg_replace('/[,.?:;!()=\\*\']/', '', $term);
	}

	function getDynaLists(&$fgParams)
	{
		$db = &JFactory::getDBO();

		$sectionid = $fgParams->get('sectionid');

		$contentsections 			= array();
		$contentsections[-1] 		= array();
		$contentsections[-1][] = JHTML::_('select.option', -1, JText::_( 'FG_SELECT_SECTION' ), 'id', 'title');

		$sectioncategories 			= array();

		$pluginModel = &FGFactory::getPluginModel();
		$rows = $pluginModel->loadInstalledPlugins();
		foreach($rows as $row) {
			if($row->published) {
				$row->plugin = &$pluginModel->getPlugin($row->extension);
				$row->plugin->getParams();
				if($sectionList = $row->plugin->getSectionList($fgParams) AND count($sectionList)) {
					foreach($sectionList as $section) {
						$contentsections[$row->plugin->extension][] = $section;
					}
					$sectioncategories = $sectioncategories + $row->plugin->getSectionCategories($fgParams);
				} else {
					$sectioncategories = null;
				}
			}
		}

		return array('contentsections' => $contentsections, 'sectioncategories' => $sectioncategories);
	}

	function renderCpanel($aAttribs=null,$iAttribs=null,$text='')
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

	function renderForm(&$data,$options=array())
	{
		$obj = is_object($data) ? 1 : 0;
		if(!isset($options['legend'])) $options['legend']=null;
		if(!isset($options['fieldset_class'])) $options['fieldset_class']='adminform';
		if(!isset($options['ul_class'])) $options['ul_class']='adminformlist';
		if(!isset($options['control'])) $options['control']='params';

		//print_r($data);
		//if($fieldset) ?>
		<fieldset class="<?php echo $options['fieldset_class']; ?>">
	        <?php if($options['legend']) { ?><legend><?php echo JText::_( $options['legend'] ); ?></legend><?php } ?>
	        <ul class="<?php echo $options['ul_class']; ?>">
			<?php foreach($data as &$field):
				if($obj) { ?>
					<li><?php echo $field->label.$field->input;?></li>
				<?php } else { ?>
					<li><?php echo $field[0]; ?>
						<?php if(strpos($field[1],'type="radio"')) { ?>
							<fieldset id="<?php echo $options['control'].$field[5]; ?>" class="radio inputbox"><?php echo $field[1];?></fieldset></li>
						<?php } else {
							echo $field[1];
						} ?>
				<?php } ?>
			<?php endforeach; ?>
	        </ul>
		</fieldset>
        <?php
	}

	function renderVersionUpdatePanel(&$version_data)
	{
		?>
		<form name="adminForm" method="post">
		<p>Your Installed Version: <strong><?php echo FG_VERSION; ?></strong>
		<br />
		Latest Stable Version: <strong><span class="<?php echo $version_data['stable']['upgrade'] ? 'red' : ''; ?>">
			<?php if($version_data['stable']['upgrade']): ?>
				<a href="#" onclick="pressbutton('<?php echo $version_data['stable']['link']; ?>'); return false;"
				&gt;&gt; <?php echo $version_data['stable']['v']; ?> &lt;&lt;</a>
			<?php else: ?>
				<?php echo $version_data['stable']['v']; ?>
			<?php endif; ?>
			</span></strong>
		<br />
		<?php if(!empty($version_data['dev'])): ?>
			Latest Development Version: <strong><span class="<?php echo $version_data['dev']['upgrade'] ? 'red' : ''; ?>">
				<?php if($version_data['dev']['upgrade']): ?>
					<a href="#" onclick="pressbutton('<?php echo $version_data['dev']['link']; ?>'); return false;" class="hasTip" title="Upgrade Available::Click here to upgrade automatically!">
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