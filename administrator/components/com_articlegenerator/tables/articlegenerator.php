<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################

defined ('_JEXEC') or die('Restricted Access');

class articlegeneratorTablearticlegenerator extends JTable {
  

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */	
  var $feed_url=null;
  var $keywords=null;
  var $published=null;
  var $extractfulltext=null;
  var $checked_out=null;
  var $checked_out_time=null;
//  var $sectionid=null;
  var $catid=null;
  var $validfor=null;
  var $advert='{loadposition user99}';
  var $insertadvert=null;
  var $autopublish=null;
  var $frontpage=null;
  var $delay=null;
  var $fulltext=null;
  var $feedlinksintro=null;
  var $feedlinksfull=null;
  var $feedimageintro=null;
  var $feedimagefull=null;
  var $posterid=null;
  var $title=null;
  var $origdate=null;
  var $jceboxlinks=null;
  var $jceparams=null;
  var $negkey=null;
  var $username=null;
  var $password=null;
  var $createddate=null;
  var $cutat=null;
  var $showintro=null;
  var $switchintrofull=null;
  var $origauthor=null;
  var $includelink=null;
  var $readfullarticle='Read full article on';
  var $dupavoid=null;
  var $acgroup=null;
  var $ordering =null;
  var $cutatcharacter=null;
  var $ignoreitem=null;
  var $minimum_count=null;
  var $allowabletags='all';
  var $articleintrostyle='[intro]';
  var $articlefullstyle='[full]';
  var $language='*';
  
  
  function __construct(&$db) {
    parent::__construct('#__articlegenerator','id',$db);
	$this->published=1;
  }
}
?>
