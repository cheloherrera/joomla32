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

class articlegeneratorconfigTablearticlegeneratorconfig extends JTable {
  

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */	
  var $getwith=null;  
  var $credit=null;  
  var $countkeys=null;
  var $minLengthkeys=null;
  var $usetitle=null;
  var $blackListkeys=null;
  
  
  function __construct(&$db) {
    parent::__construct('#__articlegenerator_config','id',$db);
	
  }
}
?>
