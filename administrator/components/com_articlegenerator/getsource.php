<?php
function rssutil($rssurlorig, $el_params, $curl = false, $iconv = false)
{
    $mainframe = JFactory::getApplication();
    $keywords = $el_params['keywords'];
    $negativekeywords = $el_params['negativekeywords'];
    $cutAt = $el_params['cuttag'];
    $extractfulltext = $el_params['extractfulltext'];
    $cutAtCharacter = $el_params['cutatcharacter'];
    $ignoreitem = $el_params['ignoreitem'];
    $minimum_count = $el_params['minimum_count'];
    $allowabletags = $el_params['allowabletags'];
    
    if ($extractfulltext == 1)
		{
			$path = str_replace('components/com_articlegenerator/cronjob/', 'administrator/', JUri::base()); //get path and change if cronjob is running
			$rssurl = $path."components/com_articlegenerator/fulltextrss/makefulltextfeed.php?url=".$rssurlorig;
		} 
		else
		{
			$rssurl = $rssurlorig;
		}
    

    $cacheDir = JPATH_BASE .DIRECTORY_SEPARATOR. 'cache/';

    // full RSS parser used to access image information
    if (!class_exists('SimplePie')) {     require_once (JPATH_COMPONENT_ADMINISTRATOR .DIRECTORY_SEPARATOR. "fulltextrss" .DIRECTORY_SEPARATOR. "libraries" .DIRECTORY_SEPARATOR. "simplepie" .DIRECTORY_SEPARATOR. "simplepie.inc"); }

//    $rssDoc = new SimplePie(null, $cacheDir, 900); //cache will last 15 minutes.
      $rssDoc = new SimplePie(); 
      $rssDoc->set_cache_location($cacheDir);
      $rssDoc->set_cache_duration(900); //cache will last 15 minutes.
      

    $rssurl = html_entity_decode($rssurl);
    if (!$curl)
    {
        $rssDoc->set_feed_url($rssurl);
        $rssDoc->force_fsockopen(true);
    } else
    {
        //curl set, check the feed password
        if (isset($el_params['username']) && isset($el_params['password']) && strlen($el_params['username']) >
            0)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $rssurl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_USERPWD, "$el_params[username]:$el_params[password]");
            $data = curl_exec($ch);
            $rssDoc->set_raw_data($data);
            if (strlen($el_params['username']) > 0)
                echo "Fetching with username: $el_params[username] and pass: " . preg_replace("/./",
                    "*", $el_params['password']) . "<br/>";
            curl_close($ch);
        } else
        {
            $rssDoc->set_timeout(120);
            $rssDoc->enable_cache(true); //cache all the resulting files
            $rssDoc->set_feed_url($rssurl);
        }
    }

    //convert RSS feed to default joomla 1.5 encoding
    $rssDoc->set_output_encoding(strtoupper("UTF-8"));
    //After setting all, initialize rss parsing
    $rssDoc->strip_attributes(array('bgsound', 'class', 'expr', 'style', 'onclick',
        'onerror', 'onfinish', 'onmouseover', 'onmouseout', 'onfocus', 'onblur', 'lowsrc',
        'dynsrc'));
    $rssDoc->init();
    if (isset($rssDoc->error))
    {
        echo $rssDoc->error;
    }
    $iTitle = "";
    $descrip = 0;
    $iUrl = 0;
    $iUrl = $rssDoc->get_image_url();
    $iTitle = $rssDoc->get_title();
    $link = JRoute::_($rssDoc->get_link());
    ob_start();
?>
<style type="text/css">
<!--
#head_feed ul li {
 display: inline;
}
-->
</style>
<div id="head_feed">
 <ul>
	 <li>
	  <img src='<?php echo $iUrl ?>' alt='<?php echo $iTitle ?>'/>
	 </li>
	 <li style="vertical-align: middle;">
	  <a href='<?php echo $link ?>'>
	   <span style="font-size: 18px"><?php echo $rssDoc->get_title() ?></span>
	  </a>
	 </li>
 </ul>
 <ul>
 	 <li>
	  <?php echo $rssDoc->get_description() ?>
	 </li>
 </ul>
</div>
<!--feed image-->
<br/>
<?php
    $head_feed = ob_get_contents();
    ob_end_clean();
    $return_str = array();
    $return_str[0] = $head_feed;
    $indexRetrn = 1;

    if ($rssDoc->get_item_quantity())
    { //if there is something to process...
        $items = $rssDoc->get_items();
        foreach ($items as $item)
        {
            // Title
            $item_title = Trim($item->get_title());
            $item_link = JRoute::_($item->get_permalink());
            $item_date = $item->get_date('Y-m-d H:i:s');
 

				if ($allowabletags=="none"){
					$item_text = strip_tags(parselinks($item->get_description()));
					$item_full = strip_tags(parselinks($item->get_content(true)));
				}else{
					if ($allowabletags=="all"){
						$item_text = parselinks($item->get_description());
         		$item_full = parselinks($item->get_content(true));
					}else
					{
						$item_text = strip_tags(parselinks($item->get_description()),$allowabletags);
				 		$item_full = strip_tags(parselinks($item->get_content(true)),$allowabletags);
					}
					 
                }
                $item_guid = $item->get_id();
                if ($auth = $item->get_author()) $item_author = $auth->get_name(); else $item_author = "...";
					
					$introT =strip_tags($item_text);
					if (($ignoreitem==0) || (($ignoreitem==1) && (strlen($introT)>$minimum_count)) || (($ignoreitem==2) && (strlen($item_text)>$minimum_count))){
						if ($cutAtCharacter > 0) {

								$item  =truncate($item_text,0,$cutAtCharacter, '...', false, true); 
								$text_full = rawurlencode($item_text). $item_full;
								$text_item = rawurlencode($item);	
									
						}else{ 
 
 
            if (strlen($cutAt) > 0)
            {
                $pos = strpos($item_text, $cutAt, 0);
                $item = substr($item_text, 0, $pos);
                $text_full = rawurlencode(substr($item_text, $pos + strlen($cutAt), strlen($item_text)));
                $text_item = rawurlencode($item);
            } else
            {
                $text_item = rawurlencode($item_text);
                $text_full = rawurlencode($item_full);
            }
               			}
            if (preg_match($keywords, $item_text." ".$item_title))
            {

                if (strlen($negativekeywords) > 0 && !preg_match($negativekeywords, $item_text . " " . $item_title))
                {
                    $return_str[$indexRetrn] = rawurlencode("$item_link") . "|" . rawurlencode("$item_title") .
                        "|" . rawurlencode("$item_date") . "|" . $text_item . "|" . $text_full . "|" .
                        rawurlencode($item_guid). rawurlencode($item_author);
                    $indexRetrn++;
                } else
                    if (strlen($negativekeywords) <= 0)
                    {
                        $return_str[$indexRetrn] = rawurlencode("$item_link") . "|" . rawurlencode("$item_title") .
                            "|" . rawurlencode("$item_date") . "|" . $text_item . "|" . $text_full . "|" .
                            rawurlencode($item_guid). "|". rawurlencode($item_author);
                        $indexRetrn++;
                    }
            }
        }
      }  
    } else
    {
        echo JText::_("Error getting Items from feed, check feed url and/or data");
    }
    unset($indexRetrn);
    unset($items);
    unset($rssDoc);
    return $return_str;
}

function parselinks($datatext)
{
    $text = preg_replace("/<a\s+/", "<a target=\"_blank\" rel=\"nofollow\" ", $datatext);
    return $text;
}

/**
* Truncates text.
*
* Cuts a string to the length of $length and replaces the last characters
* with the ending if the text is longer than length.
*
* @param string  $text String to truncate.
* @param integer $length Length of returned string, including ellipsis.
* @param mixed $ending If string, will be used as Ending and appended to the trimmed string. Can also be an associative array that can contain the last three params of this method.
* @param boolean $exact If false, $text will not be cut mid-word
* @param boolean $considerHtml If true, HTML tags would be handled correctly
* @return string Trimmed string.
*/
function truncate($text, $start,$length = 100, $ending = '...', $exact = true, $considerHtml = false) {
    if (is_array($ending)) {
        extract($ending);
    }
    if ($considerHtml) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen($ending);
        $openTags = array();
        $truncate = '';
        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];
 
            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }
 
                $truncate .= mb_substr($tag[3], $start , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
 
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, $start,$length - strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($considerHtml) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, $start, $spacepos);
        }
    }
 
    $truncate .= $ending;
 
    if ($considerHtml) {
        foreach ($openTags as $tag) {
            //$truncate .= '';
            $truncate .= "</$tag>";
        }
    }
 
    return $truncate;
}


?>
