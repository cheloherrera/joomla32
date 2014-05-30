<?php
defined('_JEXEC') or die ("Restricted access");

function postallsourceitems($id)
{
    $mainframe = JFactory::getApplication();

    global $countFeedItem;

    // Check for request forgeries
    //JRequest::checkToken() or die( 'Invalid Token' );
    require_once (JPATH_COMPONENT_ADMINISTRATOR .DIRECTORY_SEPARATOR. "getsource.php");
    //require_once(JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR."articlegenerator.php");
    $queryFeeds = "SELECT * FROM #__articlegenerator WHERE id='$id' AND published='1'";
    $db =JFactory::getDBO();
    $db->setQuery($queryFeeds);
    $feeds = $db->loadObjectList();
    if ($db->getErrorNum() <> 0)
    {
        $msgout = "Error:" . $db->stderr();
        if (!isset($noreturn) || (isset($noreturn) && $noreturn != 1))
            $mainframe->redirect('index.php?option=' . $option, $msgout);
        else
            echo $msgout;
    }
    $rowConfig =JTable::getInstance( 'articlegeneratorconfig' , 'articlegeneratorconfigTable');
    $rowConfig->load('1');
    $msgout = "";
    //Process every feed
    foreach ($feeds as $feed)
    {
        $feedurl = $feed->feed_url;        
//        $sectionid = $feed->sectionid;
        $catid = $feed->catid;
        $valid = $feed->validfor; 
        $keyw = split(",", $feed->keywords);
        $keywords = implode("|", $keyw);
        $keywords = "/$keywords/i";
        if (strlen($feed->negkey) > 0)
        {
            $neg = split(",", $feed->negkey);
            $nkeywords = implode("|", $neg);
            $negkeywords = "/" . $nkeywords . "/i";
        } else
        {
            $negkeywords = "";
        }
        $advert = $feed->advert;
        $matches = rssutil($feedurl, array('keywords' => "$keywords", "negativekeywords" => "$negkeywords",
            "cuttag" => $feed->cutat, 'cache' => 0, "debug" => 0, "extractfulltext" => $feed->extractfulltext, "cutatcharacter" => $feed->cutatcharacter ,"ignoreitem" => $feed->ignoreitem ,"minimum_count" => $feed->minimum_count ,"allowabletags" => $feed->allowabletags), $rowConfig->getwith);
        $msgout .= "Processing: " . $feed->title . "\n";
        unset($matches[0]);
        $itemsmatch = $matches;
        unset($matches);
        foreach ($itemsmatch as $k => $val)
        {
            $parts = split("\|", $val);
            if ($feed->dupavoid!=254) {
		    	$sec_avoid=($feed->dupavoid==128);		    	
//		    	if (checkGuid($parts[5],$sec_avoid,$feed->sectionid,$feed->catid))
		    	if (checkGuid($parts[5],$sec_avoid,$feed->catid)) 
					$cid[$k]=$k; //new code to avoid duplicating a news...
    		} else {
				$cid[$k]=$k;
			}

            /*if (checkGuid($parts[5]))
                $cid[$k] = $k;*/
        }
        if (isset($cid))
            $itsav = saveItemsAuto($cid, $option, $itemsmatch, $feed->id);
        else
            $itsav = 0;
        $msgout .= "Saved: $itsav items\n<br>\n";
        unset($cid);
    }
//    if (!isset($noreturn) || (isset($noreturn) && $noreturn != 1))
//        $mainframe->redirect('index.php?option=' . $option, $msgout);
//    else
//        echo $msgout;

$countFeedItem = $itsav;
return true;
     
}

function saveItemsAuto($cids, $option, $matches, $id)
{
    $mainframe = JFactory::getApplication();
    
    $content = $matches;

    $config_fp =JTable::getInstance( 'articlegeneratorconfig' , 'articlegeneratorconfigTable');
    $config_fp->load('1');

    $db =JFactory::getDBO();
    $user =JFactory::getUser();
    $row_feed =JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable');
    $row_feed->load($id);
    $count = 0;
    if (is_array($content) && is_array($cids))
    {
        foreach ($cids as $iden)
        {
            $item = $content[$iden];
            $parts1 = split("\|", $item);
            $parts = array_map('rawurldecode', $parts1);
            if ($row_feed->dupavoid!=254) {
 			   	$sec_avoid=($row_feed->dupavoid==128);
//    			if (checkGuid($parts[5],$sec_avoid,$row_feed->sectionid,$row_feed->catid)) 
          if (checkGuid($parts[5],$sec_avoid,$row_feed->catid))
					$itemToSave[]=$item; //new code to avoid duplicating a news...
    		} else {
				$itemToSave[]=$item;
			}

            /*if (checkGuid($parts[5]))
                $itemToSave[$iden] = $item; //new code to avoid duplicating a news...*/

        }

        if (isset($itemToSave) && count($itemToSave) > 0)
        {
            $count = count($itemToSave);
            $nullDate = $db->getNullDate();
            $site = $mainframe->getCfg('live_site') . "/components/com_articlegenerator/articlegenerator.php";
            $advertisement = html_entity_decode(urldecode(JRoute::_($row_feed->advert)));
            foreach ($itemToSave as $item)
            {
                $parts1 = split("\|", $item);
                $parts = array_map('rawurldecode', $parts1);
                $link = $parts[0];
                $title = html_entity_decode($parts[1]);
                $date = $parts[2];
                $content = $parts[4];
                $guid = $parts[5];
                //continue;
                $introText = "<div id='article_intro_ag'>" . stripslashes($parts[3]) . "</div>";
                $fullText = $content;
                $fullText .= ($row_feed->origdate == 1) ? "<br/>\n" . JText::_("Posted:") . " $date" :
                    "";
                if ($row_feed->includelink == "1")
                {
                    $site = $mainframe->getCfg('live_site') . "/components/com_articlegenerator/articlegenerator.php";
                    if ($row_feed->jceboxlinks == 1)
                    {
                        $linkback="<div id='article_full_ag'><br/><a style=\"font-size:14pt\" href='$link' class='jcepopup' rel='".$row_feed->jceparams."' target='_self'>".JText::_("$row_feed->readfullarticle $row_feed->title")." </a></div><br/><br/>";

                        ;
                    } else
                    {
                        $linkback = "<div id='article_full_ag'><br/><a style=\"font-size:14pt\" href='$link' target='_blank'>" .JText::_("$row_feed->readfullarticle $row_feed->title")." </a></div><br/><br/>";
                        
                    }
                }

                // Check for request forgeries
                //JRequest::checkToken() or die( 'Invalid Token' );

                jimport('joomla.utilities.date');

                // Initialize variables
                $row =JTable::getInstance('content' , 'contentTable');
                $config =JFactory::getConfig();
                $tzoffset = $config->get('config.offset');
                //$date = new JDate($row->created, $tzoffset);
                $tmpdate = new JDate($row->created, $tzoffset);

//problem                $row->checkout($user->get('id')); //checkit out by me.
                if ($row_feed->createddate == 1)
                {
                    $date_cr = strtotime($date);
                    if ($date_cr === -1)
                    {
                        $created = $tmpdate->toSql();
                    } else
                    {
                        //$tmp=new JDate($date,$tzoffset);
                        $created = $date;
                    }
                } else
                {
                    $created = $tmpdate->toSql();
                }
                $row->created = $created;
//                $row->sectionid = $row_feed->sectionid;
                $row->catid = $row_feed->catid;
                $row->version = 0;
                if ($row_feed->autopublish == 0)
                {  $row->state = 0;
                } else
                   $row->state = 1;
                $row->ordering = 0;
                $row->images = array();
                // Append time if not added to publish date
								
								$offset_timezone = date('Z');
                $publish_up = ($row_feed->delay > 0) ? date('Y-m-d H:i:s', time() + $row_feed->delay *
                    6 - $offset_timezone) : date("Y-m-d 00:00:00", time());  
                                 
                if ($row_feed->validfor != 0)
                {
                    $publish_down = date('Y-m-d H:i:s', time() + $row_feed->validfor);
                    $date = new JDate($publish_down, $tzoffset);
                    $row->publish_down = $date->toSql();
                } else
                    $row->publish_down = $nullDate;
                $dateup = new JDate($publish_up, $tzoffset);
                $row->publish_up = $dateup->toSql();
                $row->created_by = $row_feed->posterid;
                $row->access=$row_feed->acgroup;
                // Is the article featured? in #__content (see alsow "viewable on the frontpage" in #__content_frontpage below)
                if ($row_feed->frontpage == 1)
                {  $row->featured = 1;
                } else
                   $row->featured = 0;
                $row->language = $row_feed->language;
                
                $row->images = '
{"image_intro":"",
"float_intro":"",
"image_intro_alt":"",
"image_intro_caption":"",
"image_fulltext":"",
"float_fulltext":"",
"image_fulltext_alt":"",
"image_fulltext_caption":""}
';              
 
                $row->urls = '
{"urla":null,
"urlatext":"",
"targeta":"",
"urlb":null,
"urlbtext":"",
"targetb":"",
"urlc":null,
"urlctext":"",
"targetc":""}
';

                $row->attribs = '
{"show_title":"",
"link_titles":"",
"show_intro":"'.$row_feed->showintro.'",
"show_category":"",
"link_category":"",
"show_parent_category":"",
"link_parent_category":"",
"show_author":"",
"link_author":"",
"show_create_date":"",
"show_modify_date":"",
"show_publish_date":"",
"show_item_navigation":"",
"show_icons":"",
"show_print_icon":"",
"show_email_icon":"",
"show_vote":"",
"show_hits":"",
"show_noauth":"",
"urls_position":"",
"alternative_readmore":"",
"article_layout":"",
"show_publishing_options":"",
"show_article_options":"",
"show_urls_images_backend":"",
"show_urls_images_frontend":""}
';                         

                

                $row->metadata = '
{"robots":"",
"author":"",
"rights":"",
"xreference":"'.$guid.'"}
';


                $row->modified = $nullDate;
                $row->modified_by = $row_feed->posterid;
                  
                if ($row_feed->feedlinksintro == "0"):
                // delete no links from feed-text and feed-image
                $intro = $introText;
                
                elseif ($row_feed->feedlinksintro == "1"): 
                // delete all links from feed-text and feed-image and delete link-texts
                $intro = preg_replace('/<a.*\\/a>/Uis', '\\2', $introText);
                
                elseif ($row_feed->feedlinksintro == "2"): 	
                // delete all links from feed-text and feed-image and leave link-texts
                $intro = preg_replace('#<a(.*)>(.*)</a>#Uis', '\\2', $introText);
                  
                endif;  
                  
                if ($row_feed->feedlinksfull == "0"):
                // delete no links from feed-text and feed-image
                $full = $fullText;
                
                elseif ($row_feed->feedlinksfull == "1"): 
                // delete all links from feed-text and feed-image and delete link-texts
                $full = preg_replace('/<a.*\\/a>/Uis', '\\2', $fullText);
                
                elseif ($row_feed->feedlinksfull == "2"): 	
                // delete all links from feed-text and feed-image and leave link-texts
                $full = preg_replace('#<a(.*)>(.*)</a>#Uis', '\\2', $fullText);
                  
                endif;  
                
                
                if ($row_feed->feedimageintro == "0"):
                // delete no image from feed-text
                $intros = $intro;
                
                elseif ($row_feed->feedimageintro == "1"): 
                // delete all images from feed-text
                $intros = preg_replace('/<img.*>/Uis', '\\2', $intro);
                                                
                endif;  
                  
                if ($row_feed->feedimagefull == "0"):
                // delete no image from feed-text
                $fulls = $full;
                
                elseif ($row_feed->feedimagefull == "1"): 
                // delete all images from feed-text
                $fulls = preg_replace('/<img.*>/Uis', '\\2', $full);
                                      
                endif;
               
            
                  if ($row_feed->switchintrofull == "0")
                  {
             
                    $row->introtext = str_replace('<br>', '<br />', $intros);
                             
                    if ($row_feed->fulltext == "0"):
                    //No full text, all into introtext and no readmore
                        $row->introtext .= ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->introtext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->introtext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                   
                    elseif ($row_feed->fulltext == "1" || strlen(trim($row_feed->cutat)) > 0):
                    //introtext and fulltext in readmore
                        $row->fulltext = ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->fulltext .= "<br/>\n" . str_replace('<br>', '<br />', $fulls);
                        $row->fulltext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->fulltext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                 
                    elseif ($row_feed->fulltext == "2" || strlen(trim($row_feed->cutat)) > 0):
                    //introtext and advertisement in readmore
                        $row->fulltext = ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->fulltext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->fulltext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                    endif;
             
                  } else 
                  {
                  	                 	
                    $row->introtext = str_replace('<br>', '<br />', $fulls);
                              
                    if ($row_feed->fulltext == "0"):
                    //No full text, all into introtext and no readmore but switched
                        $row->introtext .= ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->introtext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->introtext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                  
                    elseif ($row_feed->fulltext == "1" || strlen(trim($row_feed->cutat)) > 0):
                    //introtext and fulltext in readmore but switched
                        $row->fulltext = ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->fulltext .= "<br/>\n" . str_replace('<br>', '<br />', $intros);
                        $row->fulltext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->fulltext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                  
                    elseif ($row_feed->fulltext == "2" || strlen(trim($row_feed->cutat)) > 0):
                    //introtext and advertisement in readmore but switched
                        $row->fulltext = ($row_feed->insertadvert == "1") ? $advertisement : "";
                        $row->fulltext .= ($row_feed->includelink == "1") ? $linkback : "";
                        $row->fulltext .= ($row_feed->origauthor==1)? JText::_("Author:").$parts[6]:"";
                    endif;
                
                  }

                    // minimize images introtext
                    $imgs = preg_match_all('/<img.*>/Uis', $row->introtext, $matches);
                    if ( count( $matches ) > 0 ) {
                    	foreach ( $matches as $match ) {
                    		$_img = $match[0];
                    		$_img_parts = split( " ", $_img );
                    		$_img_width = 0;
                    		$_img_height = 0;
                    		foreach ( $_img_parts as $_img_part) {
                    			if ( preg_match( "/^width=/", $_img_part ) ) {
                    				$_tmp = split( "=", $_img_part );
                    				$_img_width = (int)str_replace( "\"", "", $_tmp[1] );
                    			}
                    			if ( preg_match( "/^height=/", $_img_part ) ) {
                    				$_tmp = split( "=", $_img_part );
                    				$_img_height = (int)str_replace( "\"", "", $_tmp[1] );
                    			}
                    		}
                    		if ( $_img_width > 400 ) {
                    			$_new_width = ceil( $_img_width * 40 / 100 );
                    			$_new_height = ceil( $_img_height * 40 / 100 );
                    			$row->introtext = str_replace( 'width="'. $_img_width .'"', 'width="'. $_new_width .'"', $row->introtext);
                    			$row->introtext = str_replace( 'height="'. $_img_height .'"', 'height="'. $_new_height .'"', $row->introtext);
                    		}
                    	}
                    }

                    // minimize images fulltext
                    $imgs = preg_match_all('/<img.*>/Uis', $row->fulltext, $matches);
                    if ( count( $matches ) > 0 ) {
                    	foreach ( $matches as $match ) {
                    		$_img = $match[0];
                    		$_img_parts = split( " ", $_img );
                    		$_img_width = 0;
                    		$_img_height = 0;
                    		foreach ( $_img_parts as $_img_part) {
                    			if ( preg_match( "/^width=/", $_img_part ) ) {
                    				$_tmp = split( "=", $_img_part );
                    				$_img_width = (int)str_replace( "\"", "", $_tmp[1] );
                    			}
                    			if ( preg_match( "/^height=/", $_img_part ) ) {
                    				$_tmp = split( "=", $_img_part );
                    				$_img_height = (int)str_replace( "\"", "", $_tmp[1] );
                    			}
                    		}
                    		if ( $_img_width > 400 ) {
                    			$_new_width = ceil( $_img_width * 40 / 100 );
                    			$_new_height = ceil( $_img_height * 40 / 100 );
                    			$row->fulltext = str_replace( 'width="'. $_img_width .'"', 'width="'. $_new_width .'"', $row->fulltext);
                    			$row->fulltext = str_replace( 'height="'. $_img_height .'"', 'height="'. $_new_height .'"', $row->fulltext);
                    		}
                    	}
                    }						


            
                
                if ($config_fp->credit == 1)
                {
                
                $linknumber = rand(0, 9);
                if ($linknumber == 0):
                $poweredlink = ("title=\"B&ouml;rsen-Handelssysteme\" href=\"http://www.mctrading.de/\">B&ouml;rsen-Handelssysteme");
                elseif ($linknumber == 1):
                $poweredlink = ("title=\"Finanznachrichten\" href=\"http://www.finanzen-nachrichten.com/\">Finanznachrichten");
                elseif ($linknumber == 2):
                $poweredlink = ("title=\"Preisvergleich\" href=\"http://www.preisvergleich.org.uk/\">Preisvergleich");
                elseif ($linknumber == 3):
                $poweredlink = ("title=\"Steuernachrichten\" href=\"http://www.steuer-nachrichten.com/\">Steuernachrichten");
                elseif ($linknumber == 4):
                $poweredlink = ("title=\"Suchmaschinenoptimierung\" href=\"http://www.suchmaschinen-optimierung-seo.org/\">Suchmaschinenoptimierung");
                elseif ($linknumber == 5):
                $poweredlink = ("title=\"Versicherungsvergleich\" href=\"http://www.versicherungsvergleich.org.uk/\">Versicherungsvergleich");
                elseif ($linknumber == 6):
                $poweredlink = ("title=\"Versicherungsvergleich\" href=\"http://www.altersvorsorge-nachrichten.com/\">Versicherungsvergleich");
                elseif ($linknumber == 7):
                $poweredlink = ("title=\"Versicherungsvergleich\" href=\"http://www.versicherungen-nachrichten.com/\">Versicherungsvergleich");
                elseif ($linknumber == 8):
                $poweredlink = ("title=\"Versicherungsvergleich\" href=\"http://www.versicherung-nachrichten.com/\">Versicherungsvergleich");
                elseif ($linknumber == 9):
                $poweredlink = ("title=\"Versicherungsvergleich\" href=\"http://www.versicherungsnachrichten.com/\">Versicherungsvergleich");
                endif;
                $row->fulltext .= ("<div><p align=\"right\" style=\"padding:0 6 0 0;margin:6 6 6 0\"><span style=\"color:#c0c0c0;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: 100;\">Powered by </span><a style=\"color:#c0c0c0;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: 100;\" $poweredlink</a></p></div><br/>"); 
                
                }
                
                
                $row->alias = JFilterOutput::stringURLSafe($title);
                $row->title = JRoute::_(html_entity_decode($title));
                
                
                
                // generate keywords
                $blackListkeys = $config_fp->blackListkeys;
                $countkeys = $config_fp->countkeys;
                $minLengthkeys = $config_fp->minLengthkeys;
                $usetitle = $config_fp->usetitle;
                $thetitle  = $title;
                $thecontent  = $introText;
                $thecontent .= $fullText;

                // Clean things up
                $thetitle = agCleanText($thetitle);
		            $thecontent = agCleanText($thecontent);

             		// check if title or content used for keywords
                if ($usetitle == 0):
                 $keys = $thetitle; 
                elseif ($usetitle == 1):
                 $keys = $thecontent;
                elseif ($usetitle == 2):
                 $keys = $thetitle . ' ' . $thecontent;
                endif; 
                    
			          $setkeywords = aggeneratekeywords($keys, $blackListkeys, $countkeys, $minLengthkeys);
		
                //set keywords 
                $row->metakey .= $setkeywords;
                
                
                
                if (strlen($row->title) <= 0)
                {
                    $row->title = rand(1, 9) . " - " . Date("Y-m-d H:i:s") . " - ";
                }
                if (!$row->check())
                {
                    JError::raiseError(500, $db->stderr());
                    return false;
                }
                // Increment the content version number
                $row->version++;

                // Store the content to the database
                if (!$row->store())
                {
                    JError::raiseError(502, $db->stderr());
                    return false;
                }

                // Check the article and update item order
                $row->checkin();
                $row->reorder('catid = ' . (int)$row->catid . ' AND state >= 0');


                //This is extracted from com_content...
                /*
                * We need to update frontpage status for the article.
                *
                * First we include the frontpage table and instantiate an instance of it.
                */
                require_once (JPATH_ADMINISTRATOR .DIRECTORY_SEPARATOR. 'components' .DIRECTORY_SEPARATOR. 'com_content' .DIRECTORY_SEPARATOR. 'tables' .DIRECTORY_SEPARATOR. 'featured.php');
                $fp = new  ContentTableFeatured($db);

                // Is the article viewable on the frontpage?
                if ($row_feed->frontpage == 1)
                {
                    // Is the item already viewable on the frontpage?
                    if (!$fp->load($row->id))
                    {
                        // Insert the new entry
                        $query = 'INSERT INTO #__content_frontpage' . ' VALUES ( ' . (int)$row->id . ', 1 )';
                        $db->setQuery($query);
                        if (!$db->execute())
                        {
                            JError::raiseError(500, "Error sorting frontpage:" . $db->stderr());
                            return false;
                        }
                        $fp->ordering = 1;
                    }
                } else
                {
                    // Delete the item from frontpage if it exists
                    if (!$fp->delete($row->id))
                    {
                        $msg .= $fp->stderr();
                    }
                    $fp->ordering = 0;
                }
                $fp->reorder();
            

 
                /*
                * We need to update the table #__assets 
                */

		
								$assetsname	= "com_content.article.{$row->id}";
								$assetsquery = "SELECT `id` FROM `#__assets`  WHERE `name` = '{$assetsname}'";
								$db->setQuery($assetsquery);
								$assets_id	= $db->LoadResult();
								if(!$assets_id){
									$assetsquery = "SELECT `asset_id` FROM `#__categories`  WHERE `id` = '{$row->catid}'";			
									$db->setQuery($assetsquery);
									$parent_id	= $db->LoadResult();
									
									$rules	= '{"core.delete":[],"core.edit":[],"core.edit.state":[]}';
									$assetsquery = "UPDATE `#__assets` SET `parent_id` = {$parent_id}, `level` = 3,"
									." `name` = '{$assetsname}', `title` = '".addslashes($row->title)."', `rules` = '{$rules}'"
									."\nWHERE `id` = {$row->asset_id}";
					
									$db->setQuery($assetsquery);
									if(!$db->execute()){
										echo '<br />'.$db->getErrorMsg();
									}			
								}
		


            
            
            
            } //end foreach
        } // this means it has no items to store
    }
    return $count;
} // end function

function checkGuid($guid,$sec_avoid=false,$categ=false)
{
    $mainframe = JFactory::getApplication();
    $db =JFactory::getDBO();
    //$tit=substr($db->escape(JRoute::_(html_entity_decode( $title ))),0,100);
    $guid = $db->escape(rawurldecode(html_entity_decode($guid)));
    

    /*
     * metadata-xreference is generated by $guid (is $parts[5] from feed) and automaticlally saved like this http://www....
     * after changing and saving articles manually the urls are saved by joomla into metadata-xreference like this http:\/\/www....
     * LIKE is checking mysql-db with $guid like this http://www....
     * for http:\/\/www.... we need $guid2 which is checking http:\\\\/\\\\/www....
     * we need 3 backslash more for like
     * to generate these 4 backlslashed we nee 8 (see below)
     */
     $guid2 = str_replace("/", "\\\\\\\\/",$guid);

    

    $categ = $db->escape(rawurldecode($categ));
    
    if (!$sec_avoid) {
		$query = "SELECT id FROM #__content WHERE (metadata LIKE '%$guid%' OR metadata LIKE '%$guid2%') AND state>-1";
    } else {
		$query= "SELECT id FROM #__content WHERE ((metadata LIKE '%$guid%' OR metadata LIKE '%$guid2%') AND catid='$categ') AND state>-1";
	}
    $db->setQuery($query);
    $db->execute();
    $elements = $db->loadObjectList();
    if (count($elements) > 0 || $db->getErrorNum())
    {
        return false;
    } else
        return true;
}








/* cleanText function - Thx owed to eXtplorer, joomSEO and Jean-Marie Simonet */
	function agcleanText( $text ) {
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );
		$text = preg_replace( '/<!--.+?-->/', '', $text );
		$text = preg_replace( '/{.+?}/', '', $text );

		// convert html entities to chars (with conditional for PHP4 users
		if(( version_compare( phpversion(), '5.0' ) < 0 )) {
			require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'html_entity_decode_php4.php');
			$text = html_entity_decode_php4($text,ENT_QUOTES,'UTF-8');
		}else{
			$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		}

		$text = strip_tags( $text ); // Last check to kill tags
		$text = str_replace('"', '\'', $text); //Make sure all quotes play nice with meta.
        $text = str_replace(array("\r\n", "\r", "\n", "\t"), " ", $text); //Change spaces to spaces

        // remove any extra spaces
		while (strchr($text,"  ")) {
			$text = str_replace("  ", " ",$text);
		}
		
		// general sentence tidyup
		for ($cnt = 1; $cnt < JString::strlen($text); $cnt++) {
			// add a space after any full stops or comma's for readability
			// added as strip_tags was often leaving no spaces
			if ( ($text{$cnt} == '.') || (($text{$cnt} == ',') && !(is_numeric($text{$cnt+1})))) {
				if ($text{$cnt+1} != ' ') {
					$text = substr_replace($text, ' ', $cnt + 1, 0);
				}
			}
		}
			
		return $text;
	}
	


  // generate keywords
  function aggeneratekeywords($keys, $blackListkeys, $countkeys, $minLengthkeys) {

	  $keys = preg_replace('/<[^>]*>/', ' ', $keys);	
	  $keys = preg_replace('/[\.;:!?|\'|\"|\`|\,|\(|\)]/', ' ', $keys);	
	  $keysArray = explode(" ", $keys);
	  $keysArray = array_count_values(array_map('utf8_strtolower', $keysArray));
	
  	$blackArray = explode(",", $blackListkeys);
	
	  foreach($blackArray as $blackWord){
		  if(isset($keysArray[trim($blackWord)]))
			  unset($keysArray[trim($blackWord)]);
	  }
	
	  arsort($keysArray);
	
	  $i = 1;
	
	  foreach($keysArray as $word=>$instances){
		  if($i > $countkeys)
			  break;
		  if(strlen(trim($word)) >= $minLengthkeys ) {
			  $keywords .= $word . ", ";
			  $i++;
		  }
	  }
	
	  $keywords = rtrim($keywords, ", ");
	  return($keywords);
  }








?>
