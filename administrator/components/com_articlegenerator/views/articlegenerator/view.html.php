<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################

## No Direct Access - Kill this Script!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AGViewarticlegenerator extends JViewLegacy {

	public function display($tpl = null, $cachable = false, $urlparams = false) {
	
		$mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');	

		JSubMenuHelper::addEntry( JText::_( 'Source Manager' ), 'index.php?option=com_articlegenerator&controller=articlegenerator');	
		JSubMenuHelper::addEntry( JText::_( 'Post All / Cron Job' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=cronjob');
		JSubMenuHelper::addEntry( JText::_( 'Twitter' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=twitter&cid=1');
		JSubMenuHelper::addEntry( JText::_( 'Configuration' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=config&cid=1');
		JSubMenuHelper::addEntry( JText::_( 'Compatibility Test' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=compatibilitytest');
		
	
		$lists = array();
		
		
		## Model is defined in the controller / get data from Model
		$model	= $this->getModel();
		$db				= JFactory::getDBO();
		$item = $this->get('Item');		
		$itemconfig = $this->get('Itemconfig');		



/**	
 * build the html Lists for Source-Detail Form 
 *	 	
 *
 **/ 
/**	
 * build the html select list for extract Fulltext 
 *	 	
 *
 **/ 
    $extractfulltext[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$extractfulltext[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['extractfulltext'] = JHtml::_('select.genericlist',$extractfulltext, 'extractfulltext', 'class="inputbox" size="1"',"id","title", $item->extractfulltext);

/**	
 * build the html select list for switch intro full 
 *	 	
 *
 **/ 
    $switchintrofull[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$switchintrofull[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['switchintrofull'] = JHtml::_('select.genericlist',$switchintrofull, 'switchintrofull', 'class="inputbox" size="1"',"id","title", $item->switchintrofull);


/**	
 * build the html select list for Ignore Feed-Article 
 *	 	
 *
 **/ 
    $ignoreitem[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$ignoreitem[]=JHtml::_('select.option', '1', JText::_( 'Count only text' ), 'id', 'title');
  	$ignoreitem[]=JHtml::_('select.option', '2', JText::_( 'Count raw' ), 'id', 'title');
   	$lists['ignoreitem'] = JHtml::_('select.genericlist',$ignoreitem, 'ignoreitem', 'class="inputbox" size="1"',"id","title", $item->ignoreitem);

 
/**	
 * build the html select list for insert advertising-field 
 *	 	
 *
 **/    
  	$insertadvert[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $insertadvert[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
   	$lists['insertadvert'] = JHtml::_('select.genericlist',$insertadvert, 'insertadvert', 'class="inputbox" size="1"',"id","title", $item->insertadvert);

  	
  	
  		
/**	
 * build the html select list for Combination 
 *	 	
 *
 **/
  	$fulltexts[] = JHtml::_('select.option','1',JText::_('intro and full/advert in readmore'),'value','text');
  	$fulltexts[] = JHtml::_('select.option','0',JText::_('intro/advert and no readmore'),'value','text'); 	  
 	  $fulltexts[] = JHtml::_('select.option','2',JText::_('intro and advert in readmore'),'value','text');
 	  $lists['fulltext']  = JHtml::_('select.genericlist',$fulltexts,'fulltext','class="inputbox"','value','text',$item->fulltext);
 	

/**	
 * build the html select list for Show intro in readmore 
 *	 	
 *
 **/
    $showintro[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $showintro[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');  	
   	$lists['showintro'] = JHtml::_('select.genericlist',$showintro, 'showintro', 'class="inputbox" size="1"',"id","title", $item->showintro);


/**	
 * build the html select list for Link-Handling intro 
 *	 	
 *
 **/ 
  	$feedlinksintros[] = JHtml::_('select.option','0',JText::_('delete no links'),'value','text');
  	$feedlinksintros[] = JHtml::_('select.option','1',JText::_('delete links and linktext'),'value','text');
  	$feedlinksintros[] = JHtml::_('select.option','2',JText::_('delete links and leave linktext'),'value','text');
  	$lists['feedlinksintro']  = JHtml::_('select.genericlist',$feedlinksintros,'feedlinksintro','class="inputbox"','value','text',intval($item->feedlinksintro));
 	

/**	
 * build the html select list for Link-Handling full 
 *	 	
 *
 **/
  	$feedlinksfulls[] = JHtml::_('select.option','0',JText::_('delete no links'),'value','text');
 	  $feedlinksfulls[] = JHtml::_('select.option','1',JText::_('delete links and linktext'),'value','text');
  	$feedlinksfulls[] = JHtml::_('select.option','2',JText::_('delete links and leave linktext'),'value','text');
  	$lists['feedlinksfull']  = JHtml::_('select.genericlist',$feedlinksfulls,'feedlinksfull','class="inputbox"','value','text',intval($item->feedlinksfull));

 
/**	
 * build the html select list for Image-Handling intro 
 *	 	
 *
 **/
    $feedimageintros[] = JHtml::_('select.option','0',JText::_('delete no image'),'value','text');
  	$feedimageintros[] = JHtml::_('select.option','1',JText::_('delete image'),'value','text');
  	$lists['feedimageintro']  = JHtml::_('select.genericlist',$feedimageintros,'feedimageintro','class="inputbox"','value','text',intval($item->feedimageintro));
 	 
 
/**	
 * build the html select list for Image-Handling full 
 *	 	
 *
 **/
   	$feedimagefulls[] = JHtml::_('select.option','0',JText::_('delete no image'),'value','text');
  	$feedimagefulls[] = JHtml::_('select.option','1',JText::_('delete image'),'value','text');
  	$lists['feedimagefull']  = JHtml::_('select.genericlist',$feedimagefulls,'feedimagefull','class="inputbox"','value','text',intval($item->feedimagefull));


/**	
 * build the html select list for users 
 *	 	
 *
 **/
    $query="SELECT name,id FROM #__users WHERE 1";
    $db->setQuery($query);
    $users[] = JHtml::_('select.option', '0', JText::_('Please select'), 'id', 'name');
    $users = array_merge($users, $db->loadObjectList());
    $lists['users'] = JHtml::_('select.genericlist',  $users, 'posterid', 'class="inputbox" size="1" ', 'id', 'name', intval($item->posterid));

 
/**	
 * build the html select list for section and category 
 *	 	
 *
 **/
//		$query = 'SELECT s.id, s.title' .
//				' FROM #__sections AS s' .
//				' ORDER BY s.ordering';
//		$db->setQuery($query);
//
//		$sections[] = JHtml::_('select.option', '-1', '- '.JText::_('Select Section').' -', 'id', 'title');
//		$sections[] = JHtml::_('select.option', '0', JText::_('Uncategorized'), 'id', 'title');
//		$sections = array_merge($sections, $db->loadObjectList());
//	
//		$lists['sectionid'] = JHtml::_('select.genericlist',  $sections, 'sectionid', 'class="inputbox" size="1" onchange="changeDynaList();"', 'id', 'title', intval($item->sectionid));
//	
//		foreach ($sections as $section)
//		{
//			$section_list[] = (int) $section->id;
//		}
//
//		$sectioncategories = array ();
//		$sectioncategories[-1] = array ();
//		$sectioncategories[-1][] = JHtml::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
//		$section_list = implode('\', \'', $section_list);
//
//		 $query = 'SELECT id, title, section' .
//				' FROM #__categories' .
//				' WHERE section IN ( \''.$section_list.'\' )' .
//				' ORDER BY ordering';
//		$db->setQuery($query);
//		$cat_list = $db->loadObjectList();
//
//		// Uncategorized category mapped to uncategorized section
//		$uncat = new stdClass();
//		$uncat->id = 0;
//		$uncat->title = JText::_('Uncategorized');
//		$uncat->section = 0;
//		$cat_list[] = $uncat;
//		foreach ($sections as $section)
//		{
//			$sectioncategories[$section->id] = array ();
//			$rows2 = array ();
//			foreach ($cat_list as $cat)
//			{
//				if ($cat->section == $section->id) {
//					$rows2[] = $cat;
//				}
//			}
//			foreach ($rows2 as $row2) {
//				$sectioncategories[$section->id][] = JHtml::_('select.option', $row2->id, $row2->title, 'id', 'title');
//			}
//		}
//		$sectioncategories['-1'][] = JHtml::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
//		$categories = array();
//		foreach ($cat_list as $cat) {
//			if($cat->section == $item->sectionid)
//				$categories[] = $cat;
//		}
//
//		$categories[] = JHtml::_('select.option', '-1', JText::_( 'Select Category' ), 'id', 'title');
//		$lists['catid'] = JHtml::_('select.genericlist',  $categories, 'catid', 'class="inputbox" size="1"', 'id', 'title', intval($item->catid));


		$query = "SELECT id,title FROM  #__categories WHERE extension='com_content' ORDER BY lft";
		$db->setQuery($query);

		$categories[] = JHtml::_('select.option', '-1', '- '.JText::_('Select Category').' -', 'id', 'title');
		$categories = array_merge($categories, $db->loadObjectList());
	
		$lists['catid'] = JHtml::_('select.genericlist',  $categories, 'catid', 'class="inputbox" size="1"', 'id', 'title', intval($item->catid));






/**	
 * build the html select list for duplicate avoidance  
 *	 	
 *
 **/
    $dups[]=JHtml::_('select.option', '3',JText::_('No duplicates in Database'), 'id', 'title');
    $dups[]=JHtml::_('select.option', '128',JText::_('Duplicates only in other category'), 'id', 'title');
//    $dups[]=JHtml::_('select.option', '254',JText::_('Allow Duplicates'), 'id', 'title');
    $lists['avoiddup'] = JHtml::_('select.genericlist',  $dups, 'dupavoid', 'class="inputbox" size="1"', 'id', 'title', $item->dupavoid);


/**	
 * build the html select list for usergroups 
 *	 	
 *
 **/
 	  $query="Select id,title FROM #__viewlevels WHERE 1";
 	  $db->setQuery($query);
	  $group_list = $db->loadObjectList();
	  foreach ($group_list as $lrow) 
	  {
		  $optgrp[]=JHtml::_("select.option",$lrow->id,$lrow->title,"value","text");
	  }
	  $lists['accessgrp']=JHtml::_("select.genericlist",$optgrp,"acgroup","class='inputbox'","value","text",intval($item->acgroup));

 
/**	
 * build the html select list for Orig-Author 
 *	 	
 *
 **/
  	$author[]=JHtml::_('select.option', '0', JText::_( "Don't store"), 'id', 'title');
  	$author[]=JHtml::_('select.option', '1', JText::_( 'As article Auhtor alias' ), 'id', 'title');
  	$author[]=JHtml::_('select.option', '2', JText::_( 'As Text' ), 'id', 'title');
  	$lists['origauthor'] = JHtml::_('select.genericlist',$author, 'origauthor'	, 'class="inputbox" size="1"',"id","title", $item->origauthor);

 
/**	
 * build the html select list for Frontpage 
 *	 	
 *
 **/
    $frontpage[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $frontpage[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');  	
   	$lists['frontpage'] = JHtml::_('select.genericlist',$frontpage, 'frontpage', 'class="inputbox" size="1"',"id","title", $item->frontpage);
  
  
/**	
 * build the html select list for Valid For 
 *	 	
 *
 **/
  	$valids[] = JHtml::_('select.option','0',JText::_('Ever'),'value','text');
  	$valids[] = JHtml::_('select.option','86400',JText::_('1 Day'),'value','text');
  	$valids[] = JHtml::_('select.option','604800',JText::_('7 Days'),'value','text');
	  $valids[] = JHtml::_('select.option','1209600',JText::_('14 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','2592000',JText::_('30 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','5184000',JText::_('60 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','7776000',JText::_('90 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','15552000',JText::_('180 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','23328000',JText::_('270 Days'),'value','text');
  	$valids[] = JHtml::_('select.option','31536000',JText::_('365 Days'),'value','text');
  	$lists['validfor'] =JHtml::_('select.genericlist',$valids,'validfor','class="inputbox"','value','text',intval($item->validfor));


/**	
 * build the html select list for autopublish 
 *	 	
 *
 **/
    $autopublish[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $autopublish[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');  	
   	$lists['autopublish'] = JHtml::_('select.genericlist',$autopublish, 'autopublish', 'class="inputbox" size="1"',"id","title", $item->autopublish);

 
/**	
 * build the html select list for Include Feed-Original-Date 
 *	 	
 *
 **/
    $origdate[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$origdate[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['origdate'] = JHtml::_('select.genericlist',$origdate, 'origdate', 'class="inputbox" size="1"',"id","title", $item->origdate);
 

/**	
 * build the html select list for Set Feed-Date as created date 
 *	 	
 *
 **/
    $createddate[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$createddate[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['createddate'] = JHtml::_('select.genericlist',$createddate, 'createddate', 'class="inputbox" size="1"',"id","title", $item->createddate);


/**	
 * build the html select list for include link to original-article 
 *	 	
 *
 **/
    $includelink[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $includelink[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');  	
   	$lists['includelink'] = JHtml::_('select.genericlist',$includelink, 'includelink', 'class="inputbox" size="1"',"id","title", $item->includelink);
 
 
/**	
 * build the html select list for Open readmore link in JCE-Popup 
 *	 	
 *
 **/
    $jceboxlinks[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
    $jceboxlinks[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');  	
   	$lists['jceboxlinks'] = JHtml::_('select.genericlist',$jceboxlinks, 'jceboxlinks', 'class="inputbox" size="1"',"id","title", $item->jceboxlinks);
 

/**	
 * build the html select list for language 
 *	 	
 *
 **/		
		$query = "SELECT lang_code, title FROM  #__languages WHERE published=1";
    $db->setQuery($query);
    $language[]=JHtml::_('select.option', '*', JText::_('All'), 'lang_code', 'title');
    $language = array_merge($language, $db->loadObjectList());
    $lists['language'] = JHtml::_('select.genericlist',  $language, 'language', 'class="inputbox" size="1" ', 'lang_code', 'title', $item->language);














/**	
 * build the html Lists for Config Form 
 *	 	
 *
 **/
    $getwith[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$getwith[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['getwith'] = JHtml::_('select.genericlist',$getwith, 'getwith', 'class="inputbox" size="1"',"id","title", $itemconfig->getwith);

    $credit[]=JHtml::_('select.option', '0', JText::_( 'No' ), 'id', 'title');
  	$credit[]=JHtml::_('select.option', '1', JText::_( 'Yes' ), 'id', 'title');
   	$lists['credit'] = JHtml::_('select.genericlist',$credit, 'credit', 'class="inputbox" size="1"',"id","title", $itemconfig->credit);

  	$usetitle[] = JHtml::_('select.option','0',JText::_('Title'),'value','text');
 	  $usetitle[] = JHtml::_('select.option','1',JText::_('Content'),'value','text');
 	  $usetitle[] = JHtml::_('select.option','2',JText::_('Both'),'value','text');
 	  $lists['usetitle']  = JHtml::_('select.genericlist',$usetitle,'usetitle','class="inputbox"','value','text',intval($itemconfig->usetitle));
 	




/**	
 * give it to the tmpl Form 
 *	 	
 *
 **/
		

		$this->data=$item;
		$this->dataconfig=$itemconfig;
		$this->lists=$lists;
		$this->sectioncategories=$sectioncategories;
		parent::display($tpl);

	}
	
	
}
?>
