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

defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'tables');

class FeedgatorUtility
{
	/*
	*
	*/
	public static function adjustLink(&$link,&$fgParams)
	{
		if($qstring = parse_url($link,PHP_URL_QUERY)) {
			$qarray = parse_str($qstring);
			if(false) {
				if($url) {
					$link = urldecode($url);
				}
			}
		}

		//to be added - the ability to add query strings to the trackback URL
		//probably best to add this in using the first part of the function after parse_url
		//if($fgParams->get('link_append')) {

		return $link;
	}

	/*
	* Applies adjustments to text using FeedGator feed parameters settings
	*/
	public static function adjustText(&$text,&$fgParams)
	{
		//clean out unwanted text
		if($fgParams->get('text_filter')) {
			if($fgParams->get('text_filter_remove')) {
				$search = explode(',',$fgParams->get('text_filter_remove'));
				foreach($search as &$s) {
					$s = str_replace('[[comma]]',',',$s);
					$replace[] = '';
				}
			}
			if($fgParams->get('text_filter_replace')) {
				$pairs = explode("\n",$fgParams->get('text_filter_replace'));
				foreach($pairs as &$pair) {
					$pair = explode('===',$pair);
					$search[] = trim($pair[0]);
					$replace[] = trim($pair[1]);
				}
			}
			if($fgParams->get('text_filter_regex')) {
				$pairs = explode("\n",$fgParams->get('text_filter_regex'));
				foreach($pairs as &$pair) {
					$pair = explode('===',$pair);
					$regex[] = trim($pair[0]);
					$regplace[] = trim($pair[1]);
				}
			}
			if(isset($search)) {
				$text = str_replace($search,$replace,$text); // may cause UTF-8 issues but needed to allow capitalisation to propagate
			}
			if(isset($regex)) {
				$text = preg_replace($regex,$regplace,$text);
			}
		}

		return $text;
	}

	/*
	* cleanup and htmLawed text cleaning
	*/
	public static function cleanText($text,$clean_config,$spec,&$fgParams)
	{
		require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'htmLawed'.DS.'htmLawed.php');

		//one downside of this may be removal of clearing divs..
		$text = FeedgatorUtility::stripEmptyTags($text);

		//ok, so htmLawed doesn't allow complete removal of the content of script tags!
		if(strpos($fgParams->get('strip_list'),'*script') === false) {
			$text = preg_replace('/<script[^>]*?>[\s\S]*?<\/script>/i','',$text);
		}

		$text = htmLawed($text,$clean_config,$spec);

		//remove br at end of text
		$text = preg_replace('#(<br[^>]*>)*$#u','',$text);

		return $text;
	}

	/*
	* remove any empty HTML tags - taken from http://stackoverflow.com/questions/4721729/reg-expression-to-remove-empty-tags-any-of-them
	*/
	function stripEmptyTags ($result)
	{
		$regexps = array (
		'~<(\w+)\b[^\>]*>\s*</\\1>~',
		'~<\w+\s*/>~'
		);

		do
		{
			$string = $result;
			$result = preg_replace ($regexps, '', $string);
		}
		while ($result != $string);

		return $result;
	}

	/*
	* hook_tag function for htmLawed
	*/
	public static function hook_tag_cleaning($element, $attribute_array=0)
	{
		global $fgParams;

		// If second argument is not received, it means a closing tag is being handled
		if(is_numeric($attribute_array)){
			return "</$element>";
        }

		$selfclose = array('hr','br','img','input');
		$string = '';

		list(,$hook_tag) = FeedgatorHelper::getTagsToStrip();

		$regex = '/([\S]+)\s*?([^=]*)?=?([\S]*)?/';
		if(!empty($hook_tag)) {
			$white = (strpos($hook_tag,'+')) ? 1 : 0;
	    	$hook_tag = str_replace('+','',$hook_tag);
			$parts = explode(',',$hook_tag);
			foreach($parts as $part) {
				preg_match($regex,$part,$matches);
				if(isset($matches[1]) AND $element == $matches[1]) {
					//we block elements whose attributes that are not in the whitelist
					if(empty($matches[2])) $block = $white;
					if(isset($attribute_array[trim($matches[2])]) AND @$attribute_array[trim($matches[2])] == trim($matches[3])) $block = !$white;
				}
				unset($matches);
			}
			if($block) return '';
		}

		if($element == 'a' AND $fgParams->get('link_target',0)) {
			@$attribute_array['target'] = $fgParams->get('link_target');
		}

	    foreach($attribute_array as $k=>$v){
		    $string .= " {$k}=\"{$v}\"";
	    }

		return "<{$element}{$string}". (in_array($element, $selfclose) ? ' /' : ''). '>';
	}

	/*
	* Clean metadata
	*/
	public static function cleanMeta(&$content)
	{
		if(!empty($content['metakey'])) { // only process if not empty
			$bad_characters = array("\n", "\r", "\"", "<", ">"); // array of characters to remove
			$after_clean = JString::str_ireplace($bad_characters, "", $content['metakey']); // remove bad characters
			$keys = array_unique(explode(',', $after_clean)); // create array using commas as delimiter
			$clean_keys = array();
			foreach($keys as $key) {
				if(trim($key)) {  // ignore blank keywords
					$clean_keys[] = trim($key);
				}
			}
			$content['metakey'] = implode(", ", $clean_keys); // put array back together delimited by ", "
		}

		// clean up description -- eliminate quotes and <> brackets
		if(!empty($content['metadesc'])) { // only process if not empty
			$bad_characters = array("\"", "<", ">");
			$content['metadesc'] = JString::str_ireplace($bad_characters, "", $content['metadesc']);
		}
	}

	/*
	* Method to split a string by char, word and sentence but preserving HTML if needed
	*/
	public static function splitText($text,$trimTo,$type='char',$keep_tags=true)
	{
	//	echo '<pre>';
	//	echo $text.' '.$trimTo.' '.$type.' '.$keep_tags;
		$textArray = array(0 => '', 1 => '', 2 => '');  //0 = pre-split(introtext), 1 = fulltext, 2 = post-split
		if(!$keep_tags) strip_tags($text);

		if(!$trimTo) { // trimTo = 0 so return untrimmed introtext... should have just used strip_tags!
			$textArray[0] = $text;
			return $textArray;
		}

		$length = 0;
		$split = false;

		if(!$keep_tags) {
			$matches = explode(' ',$text);
			$matches[0] = (array)$matches[0];
		} else {
			//html safe split text function
			$regex = '#<[^<^>]*>|[^<]*|<[^<^>]*#u';
			$text = preg_replace('/>\s*</','><',$text); // remove whitespace to prevent it being counted
			preg_match_all($regex,$text,$matches);
	//		print_r($matches);
		}

		$textArray[1] = $text;

		switch($type)
		{
			case 'char':

				foreach($matches[0] as $match) {
					if(!$split) {
						$m = JString::strlen($match);
						if(JString::strpos($match,'<') !== 0 OR JString::strpos($match,'>') !== ($m-1)) {
							$length += $m;
						}
						if($length <= $trimTo) {
							$textArray[0] .= $match;
						} else {
							$offset = $trimTo - ($length-$m);
							$match = JString::substr($match, 0, $offset);
							$lastSpace = strrpos($match, ' ');	// end neatly at the end of a word
							if($lastSpace) $match = JString::substr($match, 0, $lastSpace);
							$textArray[0] .= $match;
							$split = true;
						}
					}
					unset($lastSpace);
				}

			break;

			case 'word':

		    	$string = '';
		    	$i = 0;
				foreach($matches[0] as $match) {
					if(JString::strpos($match,'<') !== 0 OR JString::strpos($match,'>') !== (JString::strlen($match)-1)) {
						$explode = explode(' ',JString::trim($match));
						foreach($explode as $ematch) {
							if($i < $trimTo) {
						        	$string .= $ematch." ";
						        	$i++;
							} else {
								$textArray[0] = JString::trim($string);
								break 2;
							}
						}
						if(empty($textArray[0])) $textArray[0] = JString::trim($string);
			    	} else {
		    			$string .= $match;
		    		}
		    	}

			break;

			case 'sent':

				// Setup pattern to find sentences and create description depending on defined number of sentences
				$string = '';
				$pattern = '#([\s\S]*?[\.|\!|\?])(?:[\s]+|$)#u';

				$i=0;
				foreach($matches[0] as $match) {
					if(JString::strpos($match,'<') !== 0 OR JString::strpos($match,'>') !== (JString::strlen($match)-1)) {
						for($i; $i<$trimTo; $i++) {
							$offset = "";
							if(!preg_match($pattern,$match,$smatches)) break;

							$textArray[0] .= ($i == 0) ? $smatches[1] : ' '.$smatches[1];

							$offset = JString::strpos($match,$smatches[1]);
							$offset += strlen($smatches[1])-1;
							$match = JString::substr($match,$offset);
							if(!$match) break;
						}
						if($i >= $trimTo) break;
					} else {
						$textArray[0] .= $match;
					}
				}

			break;

		}
		array_walk($textArray, create_function('&$val', '$val = trim($val);'));

		return $textArray;
	}

	/*
	* Send email to feed admin
	*/
	public static function sendAdminEmail($message = '')
	{
		$app = JFactory::getApplication();

		$db		= JFactory::getDBO();
		$fgConfig = JComponentHelper::getParams ('com_feedgator');

		$mailfrom 		= $app->getCfg( 'mailfrom' );
		$fromname 		= $app->getCfg( 'fromname' );

		if ( !$mailfrom  OR ! $fromname ) {

			$query = 	'SELECT name, email, sendEmail' .
						' FROM #__users' .
						' WHERE LOWER( usertype ) = "super administrator"';
			$db->setQuery( $query );
			$rows = $db->loadObjectList();


			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}

		$subject = html_entity_decode($fgConfig->get('email_subject'), ENT_QUOTES);
		$email = $fgConfig->get('admin_email');

		if ($fgConfig->get('html_email') == '1') {

			$css = '<style type="text/css">'

			. 'body { color:#000000; font-size: 12px; font-family:Arial, Helvetica, sans-serif;}'
			. '.feedmsg { color:#0400A2; line-height: 1.4em;}'
			. '#feedinfo { border:1px solid #bababa; padding:0 10px;}'
			. 'h1 { color:#618700; font-size: 16px; margin:10px 0 5px 0;}'
			. 'h2 { color:#e56d02; font-size: 14px; margin:5px 10px 0 10px;}'
			. 'h3 { color:#e56d02; font-size: 12px; margin:5px 10px 0 10px;}'
			. 'h4 { color:#e56d02; font-size: 8px; margin:5px 10px 0 10px;}'
			. '.small { color:#999999; font-size: 10px;}'
			. '#feedinfo a:link, #feedinfo a:visited { color:#990000;}'

			. '</style>';

			$message = $css . nl2br($message);
		} else {
			$message = strip_tags($message);
		}
		if(JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message, $fgConfig->get('html_email'))) {
			return true;
		}
		return false;
	}

	/*
	* FeedGator method for logging using Joomla
	*/
	public static function log($msg,$priority = '',$category = '')
	{
		$fg_logfile = 'com_feedgator.log.php';
		if(!$priority) $priority = 1;
		if(!$category) $category = 'Some Error:';

		if(J_VERSION < 1.6) {
			jimport('joomla.error.log');
			$log = JLog::getInstance($fg_logfile);
			$log->addEntry(array('LEVEL' => $priority,'STATUS' => $category,'COMMENT' => $msg));
		} else {
			jimport('joomla.log.log');
			JLog::addLogger(array('text_file' => $fg_logfile));
			JLog::add($msg,$priority,$category);
		}
	}

	/*
	* FeedGator method for profiling
	*/
	public static function profiling($string)
	{
		// this to be changed to a developer mode and "profiling" changed to logging
		global $p,$fgDebug;

		if(empty($fgDebug)) {
			$fgConfig = JComponentHelper::getParams ('com_feedgator');
			$fgDebug = $fgConfig->get('debug');
		}

		if($fgDebug) {
			if(empty($p)) {
				jimport( 'joomla.error.profiler' );
				$p = JProfiler::getInstance('FG');
				$p->mark('Start');
			} else {
				$p->mark($string);
			}
		}
	}

	/*
	* FeedGator custom method to parse INI string
	*/
	public static function parseINIString($string)
    {
    	// Parse INI formatted text
		$registry = new JRegistry();
		$registry->loadINI($string);
		$array = $registry->toArray();
		// can use toObject();
		return $array;
    }

    /*
	* FeedGator custom method to create INI string
	*/
	public static function makeINIString($array)
    {
    	$registry = new JRegistry();
		$registry->loadArray($array);
		$string = $registry->toString();

		return $string;
    }

	/**
	* from Phil Bauer via the forum
	* http://joomlacode.org/gf/project/feedgator/forum/?action=ForumBrowse&forum_id=6709&thread_id=22171&_forum_action=ForumMessageBrowse
	*/
    public static function strpos_array($haystack, $needle)
    {
		if(!is_array($needle)) {
			$needle = array($needle);
		}
		foreach($needle as $what) {
			if($what) {
				if(($pos = strpos($haystack, $what))!==false) {
					return $pos;
				}
			}
		}
		return false;
	}

	/*
	* finds $needle in $haystack array recursively until no further array sub-values
	*/
	public static function in_array_recursive($needle,$haystack)
	{
		foreach($haystack as &$value) {
			if(is_array($value)) {
				if(self::in_array_recursive($needle,$value)) {
					return true;
				}
			} else {
				if($value == $needle) {
					return true;
				}
			}
		}
		return false;
	}

	/*
	* adds in second array only where corresponding element in first array is empty
	*/
	public static function array_overlay($a1,$a2)
    {
        foreach($a1 as $k => $v) {
			if($a1[$k] == '' AND isset($a2[$k])){
                $a1[$k] = $a2[$k];
            }
        }
        return $a1;
    }

	/*
	* Method to replace the first occurrence of $search in $string with $replace
	*/
	public static function str_replace_first($search, $replace, $string)
	{
	    $pos = strpos($string, $search);
	    if ($pos !== false) {
	        $string = substr_replace($string, $replace, $pos, strlen($search));
	    }
	    return $string;
	}

	/*
	* Method to grab data from a URL using cURL (preferred) or fopen
	*/
	public static function getUrl($url,$type = null,$expected_result = 'html',$file_path = null, $parts = null) // fgParams->get('scrape_type'). If file_path given, will automatically save resource to file
	{
		if(function_exists('curl_init') AND (!$type OR $type == 'cURL')) {
			if(JString::strpos($url,'//')) {
				$url = implode('/',array_slice(explode('/',$url),2));
			}
			$url = html_entity_decode(JString::trim($url), ENT_QUOTES );
			$url = utf8_encode(strip_tags($url)); // are these url cleaning methods really necessary??

			//$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
			$userAgent = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.4) Gecko/20091030 Gentoo Firefox/3.5.4';
			$cookie_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'helpers'.DS.'cookies.txt';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
			if (!ini_get('open_basedir')) {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				//curl_setopt($ch, CURLOPT_MAXREDIRS, 3);  //set this if you need to
			}
			switch($expected_result)
			{
				case 'html':
					curl_setopt($ch, CURLOPT_HEADER, 1);
				break;

				case 'noheader':
					// this is same as html above but with no header
					curl_setopt($ch, CURLOPT_HEADER, 0);
				break;

				case 'header':
					// returns headers only
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch, CURLOPT_NOBODY, 1);
				break;

				case 'goo.gl':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
				//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				//	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_CAINFO, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'curl'.DS.'cacert.pem');
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('longUrl' => $parts[0])));
				//	jexit(print_r( curl_getinfo($ch)));
				break;

				case 'yql':
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
				//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				//	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_CAINFO, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS.'inc'.DS.'curl'.DS.'cacert.pem');
					curl_setopt($ch, CURLOPT_POSTFIELDS, $parts[0]);
				//	jexit(print_r( curl_getinfo($ch)));
				break;

				case 'images':
				default:
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
				break;
			}
		//	curl_setopt($ch, CURLOPT_FAILONERROR, true);
			if($file_path) {
				FeedgatorUtility::profiling('Saving File (fopen): '.$file_path);
				$fp = fopen($file_path,'w');
				curl_setopt($ch, CURLOPT_FILE, $fp);
			}
		//	jexit(print_r( curl_getinfo($ch)));
			FeedgatorUtility::profiling('Accessing URL (cURL): '.$url);
			$page = curl_exec($ch); // UTF-8 and cleaning done later
		//	jexit( curl_error($ch));
		//	jexit($page);

			// close cURL resource, and free up system resources
			curl_close($ch);
			if(isset($fp)) fclose($fp);
		} else {
			// use fopen wrapper
			FeedgatorUtility::profiling('Accessing URL (fopen): '.$url);
			if($file_path) {
				FeedgatorUtility::profiling('Saving File (fopen): '.$file_path);
				$stream = fopen($url,'r');
				if(file_put_contents($file_path, $stream)) $saved = 1;
				fclose($stream);
				return $saved ? true : false;
			} else {
				if($expected_result == 'goo.gl') {
					$context_options = array (
					       	'http' => array (     // this will allways be http!!!
					            'method' => 'POST',
					            'header'=> "Content-type: application/json\r\n",
					            'content' => json_encode(array('longUrl' => $parts[0]))
					            )
					        );

					$context = stream_context_create($context_options);
				}
				$page = file_get_contents($url,false,(isset($context) ? $context : null) );  // UTF-8 and cleaning done later
			}
		}

		return $page;
	}

	/*
	* Get the main part of the page from a cURL/fopen scrape
	*/
	public static function extractHTTP($string,&$fgParams)
	{
		$parts = array('headers'=>array(0=>''),'body'=>'');

		$lines = explode("\r\n", $string);
		if(empty($lines)) $lines = explode("\n", $string);

		$splittingheaders = true;
		$header = 0;

		for ($i=0;$i<count($lines);$i++) {

			if ($splittingheaders) {
				$parts['headers'][$header] .= $lines[$i]."\n";
			} else {
				$parts['body'] .= $lines[$i]."\n";
			}

			if (trim($lines[$i])=="") {
				if(@strpos($lines[$i+1],'HTTP/') === false) {
					// empty line, header section has ended
					$splittingheaders = false;
				} else {
					// next header
					$header++;
					$parts['headers'][$header] = '';
				}
			}

		}

		//ensures only last header used
		$parts['header'] = array_pop($parts['headers']);

		//inflate gzipped pages
		if(strpos($parts['header'],'Content-Encoding: gzip') !== false) {
			$parts['body'] = gzinflate(substr($parts['body'],10,-8));
		}
/*
		//why reinvent the wheel? - cos it didn't always work!
		$parser = new SimplePie_HTTP_Parser($string);
		if ($parser->parse())
		{
			$parts['header'] = $parser->headers;
			$parts['body'] = $parser->body;
			jexit(print_r($parts['header']));
			//$this->status_code = $parser->status_code;
		}
*/
		return $parts;
	}

	/*
	* Save a file to the local server
	*/
	public static function savefile($contents,$name,$update=false,$header='',$path=null)
	{
		$name = JFile::makeSafe($name);
		if(!$path) $path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedgator'.DS;
		$path = JFolder::makeSafe($path); // watch out - strips dots too
		set_include_path($path);

		if($update) {
			if (file_exists($name)) {
				$out = fopen($name,'a');
			} else {
				$out = fopen($name,'w',true);
				fwrite($out, $header);
			}
		} else {
			$out = fopen($name,'w',true);
		}
		fwrite($out, $contents);
		fclose($out);
	}


	/*
	* Make a relative URL absolute
	*/
	public static function makeAbsUrl($base, $rel)
	{
		// rules: if relative URL contains
		// 1) no slash or dot at beginning - relative to current directory
		// 2) containing slashes - subdirectory relative to current directory
		// 3) ../ relative to the parent directory
		// 4) ./ same as no dot or slash - relative to current directory
		// 5) / relative to server root

        $r = parse_url($rel);
        if(isset($r['scheme'])) return $rel; // no need to process

        if(strpos($rel,'//') === 0) return 'http:'.$rel; // no need to process - maybe cloud or scheme agnostic

        extract(parse_url($base));
        if(strrpos($path,'/') != strlen($path)-1) $path = dirname($path); // gets current directory
        if(strpos($rel,'/') === 0) {
        	$path = $host.$rel;
        } else {
            $aparts = array_filter(explode('/', $path));
            $rparts = array_filter(explode('/', $rel));
            $cparts = array_merge($aparts,$rparts);
            foreach($cparts as $i => &$part) {
                if($part == '.') {
                    unset($cparts[$i]);
                }
                if($part == '..') {
                    unset($cparts[$i],$cparts[$i - 1]);
                }
            }
	        $path = $host.'/'.implode('/', $cparts);
        }
        $url = isset($scheme) ? "$scheme://" : '';

        return $url.$path;
    }

	/**
	* Convert $html to UTF8
	* (uses HTTP headers and HTML to find encoding)
	* adapted from http://stackoverflow.com/questions/910793/php-detect-encoding-and-make-everything-utf-8
	* borrowed from Five Filters https://code.launchpad.net/~keyvan/fivefilters/content-only
	*/
	public static function convert_to_utf8($html, $header=null)
	{
		$accept = array(
			'type' => array('application/rss+xml', 'application/xml', 'application/rdf+xml', 'text/xml'),
			/*'charset' => array_diff(mb_list_encodings(), array('pass', 'auto', 'wchar', 'byte2be', 'byte2le', 'byte4be', 'byte4le', 'BASE64', 'UUENCODE', 'HTML-ENTITIES', 'Quoted-Printable', '7bit', '8bit'))*/
		);
		//jexit($header);
		$encoding = null;
		if ($html OR $header) {
			if (is_array($header)) $header = implode("\n", $header);
			if (!$header OR !preg_match_all('/^Content-Type:\s+([^;]+)(?:;\s*charset=["]?([^"^\s]*))?/im', $header, $match, PREG_SET_ORDER)) {
				// error parsing the response
			} else {
				$match = end($match); // get last matched element (in case of redirects)
				if (!in_array(strtolower($match[1]), $accept['type'])) {
					// type not accepted
					// todo avoid conversion
				}
				if (isset($match[2])) $encoding = JString::trim($match[2], '"\'');
			}
			if (!$encoding) {
				if (preg_match('/^<\?xml\s+version=(?:"[^"]*"|\'[^\']*\')\s+encoding=("[^"]*"|\'[^\']*\')/s', $html, $match)) {
					$encoding = JString::trim($match[1], '"\'');
				} elseif(preg_match('/<meta\s+http-equiv="Content-Type" content="([^;]+)(?:;\s*charset=["]?([^"^\s]*))?"/i', $html, $match)) {
					if (isset($match[2])) $encoding = JString::trim($match[2], '"\'');
				}
			}
			if (!$encoding) {
				$encoding = 'utf-8';
			} else {
				$encoding = JString::trim(strtolower($encoding));
				//if (!in_array($encoding, array_map('strtolower', $accept['charset']))) {
					// encoding not accepted
					// todo avoid conversion
				//}
				if ($encoding != 'utf-8') {
					if (strtolower($encoding) == 'iso-8859-1') {
						// replace MS Word smart qutoes
						$trans = array();
						$trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
						$trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
						$trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
						$trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
						$trans[chr(134)] = '&dagger;';    // Dagger
						$trans[chr(135)] = '&Dagger;';    // Double Dagger
						$trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
						$trans[chr(137)] = '&permil;';    // Per Mille Sign
						$trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
						$trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
						$trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
						$trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
						$trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
						$trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
						$trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
						$trans[chr(149)] = '&bull;';    // Bullet
						$trans[chr(150)] = '&ndash;';    // En Dash
						$trans[chr(151)] = '&mdash;';    // Em Dash
						$trans[chr(152)] = '&tilde;';    // Small Tilde
						$trans[chr(153)] = '&trade;';    // Trade Mark Sign
						$trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
						$trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
						$trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
						$trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
						$html = strtr($html, $trans);
					}
					if (function_exists('iconv')) { // iconv appears to handle certain character encodings better than mb_convert_encoding
						$html = @iconv($encoding, 'utf-8', $html);
					} elseif (function_exists('mb_convert_encoding')) {
						$html = @mb_convert_encoding($html, 'utf-8', $encoding);
					} elseif (function_exists('recode_string')) {
					    $html = @recode_string($encoding . '..utf-8', $html);
					}
				}
			}
		}
		return $html;
	}

  	/**
  	 * Adapted from:
	 * JFilterOutput - Modified by infograf768 for unicode slug plugin (http://extensions.joomla.org/extensions/site-management/sef/10275)
	 * This method processes a string and replaces all accented UTF-8 characters by unaccented //overriden
	 * ASCII-7 "equivalents", whitespaces are replaced by hyphens and the string is lowercased. //overidden
	 * Changed to fit to unicode slugs
	 */
	public static function stringURLSafe($string)
	{
		//replace double byte whitespaces to single byte
		$str = preg_replace('/\xE3\x80\x80/', ' ', $string);


		// remove any '-' from the string as they will be used as concatenator.
		// Would be great to let the spaces in but only Firefox is friendly with this

		$str = str_replace('-', ' ', $str);

		//replace forbidden characters by whitespaces
		//$forbidden = array('/:/','/#/','/\*/','/"/','/&/','/%/','/\./','/\;/','/]/','/\@/','/\+/','/\=/','/\!/','/\//','/\'/','/\\\/','/\|/','/\[/');
		//$str = preg_replace($forbidden,' ', $str);
		$str = preg_replace( '#[:\#\*"@+=;!&%\.,\]\/\'\\\\|\[]#',"\x20", $str );

		//delete all '?'
		$str = str_replace('?', '', $str);

		//trim white spaces at beginning and end of alias
		$str = JString::trim(JString::strtolower($str));

		// remove any duplicate whitespace and replace whitespaces by hyphens
		$str = preg_replace('#\x20+#','-', $str);
		return $str;
	}

	/**
	 * Adapted from http://docs.joomla.org/Making_a_Language_Pack_for_Joomla_1.6#Example_of_the_function_to_add_when_custom_transliteration_is_desired
	 *
	 * Returns a lowercase transliterated string - for use in aliases (SEF)
	 */
	public static function transliterate($string,$custom)
	{
		$glyph_array = array();

		if($custom) {
			$array = explode("\n",$custom);
			foreach($array as &$v) {
				$v = explode('=',$v);
				$glyph_array[$v[0]] = $v[1];
			}
		} else {

			$glyph_array = array(
			'a'		=>	'à,á,â,ã,ä,å,ā,ă,ą,ḁ,α,ά',
			'ae'	=>	'æ',
			'b'		=>	'β,б',
			'c'		=>	'ç,ć,ĉ,ċ,č,ч,ћ,ц',
			'ch'	=>	'ч',
			'd'		=>	'ď,đ,Ð,д,ђ,δ,ð',
			'dz'	=>	'џ',
			'e'		=>	'è,é,ê,ë,ē,ĕ,ė,ę,ě,э,ε,έ',
			'f'		=>	'ƒ,ф',
			'g'		=>	'ğ,ĝ,ğ,ġ,ģ,г,γ',
			'h'		=>	'ĥ,ħ,Ħ,х',
			'i'		=>	'ì,í,î,ï,ı,ĩ,ī,ĭ,į,и,й,ъ,ы,ь,η,ή',
			'ij'	=>	'ĳ',
			'j'		=>	'ĵ',
			'ja'	=>	'я',
			'ju'	=>	'яю',
			'k'		=>	'ķ,ĸ,κ',
			'l'		=>	'ĺ,ļ,ľ,ŀ,ł,л,λ',
			'lj'	=>	'љ',
			'm'		=>	'μ',
			'n'		=>	'ñ,ņ,ň,ŉ,ŋ,н,ν',
			'nj'	=>	'њ',
			'o'		=>	'ò,ó,ô,õ,ø,ō,ŏ,ő,ο,ό,ω,ώ',
			'oe'	=>	'œ,ö',
			'p'		=>	'п,π',
			'ph'	=>	'φ',
			'ps'	=>	'ψ',
			'r'		=>	'ŕ,ŗ,ř,р,ρ,σ,ς',
			's'		=>	'ş,ś,ŝ,ş,š,с',
			'ss'	=>	'ß,ſ',
			'sh'	=>	'ш',
			'shch'	=>	'щ',
			't'		=>	'ţ,ť,ŧ,τ,т',
			'th'	=>	'θ',
			'u'		=>	'ù,ú,û,ü,ũ,ū,ŭ,ů,ű,ų,у',
			'v'		=>	'в',
			'w'		=>	'ŵ',
			'x'		=>	'χ,ξ',
			'y'		=>	'ý,þ,ÿ,ŷ',
			'z'		=>	'ź,ż,ž,з,ж,ζ'
			);
		}

		foreach( $glyph_array as $letter => $glyphs ) {
			$glyphs = explode( ',', $glyphs );
			$string = str_replace( $glyphs, $letter, $string );
		}

		return $string;
	}

	/**
	 * Based on a function by Nitin at http://publicmind.in/blog/url-encoding/ - proper urlencode
	 */
	public static function encode_url($url)
	{
		$reserved = array(
		":" => '!%3A!ui',
		"/" => '!%2F!ui',
		"?" => '!%3F!ui',
		"#" => '!%23!ui',
		"[" => '!%5B!ui',
		"]" => '!%5D!ui',
		"@" => '!%40!ui',
		"!" => '!%21!ui',
		"$" => '!%24!ui',
		"&" => '!%26!ui',
		"'" => '!%27!ui',
		"(" => '!%28!ui',
		")" => '!%29!ui',
		"*" => '!%2A!ui',
		"+" => '!%2B!ui',
		"," => '!%2C!ui',
		";" => '!%3B!ui',
		"=" => '!%3D!ui',
		"%" => '!%25!ui',
		);

		$url = str_replace(array('%09','%0A','%0B','%0D'),'',$url); // removes nasty whitespace
		$url = rawurlencode($url);
		$url = preg_replace(array_values($reserved), array_keys($reserved), $url);
		return $url;
	}

	/*
	* Function to ensure that the output when printing a variable is captured as a string
	*/
	public static function buffer($var)
	{
		ob_start();
		print_r($var);
		$ret = ob_get_contents();
		ob_clean();

		return $ret;
	}
}