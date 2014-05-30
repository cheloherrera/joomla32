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


class ContentTableContent extends JTable {
  var $id=null;
  var $title=null;
  var $alias=null;
  var $introtext=null;
  var $fulltext=null;
  var $state=null;
  var $catid=null;
  var $created=null;
  var $created_by=null;
  var $created_by_alias=null;
  var $modified=null;
  var $modified_by=null;
  var $checked_out=null;
  var $checked_out_time=null;
  var $publish_up=null;
  var $publish_down=null;
  var $images=null;
  var $urls=null;
  var $attribs=null;
  var $version=null;
  var $ordering =null;
  var $metakey =null;
  var $metadesc =null;
  var $access =null;
  
  function __construct(&$db) {
    parent::__construct('#__content','id',$db);
  }
}
?>
