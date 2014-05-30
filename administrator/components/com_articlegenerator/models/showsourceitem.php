<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################

## Direct access is not allowed.
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AGModelshowsourceitem extends JModelLegacy {

   ## Empty data variabele
   var $_data  = null;
   var $_id = null;
  
  
   function __construct()
   {
    $mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');
	  parent::__construct();

      $this->id = JRequest::getVar('cid', 0);  
	  
   }

  
  
	
	
	function feedDataInfo($id){
			
			require_once (JPATH_COMPONENT_ADMINISTRATOR .DIRECTORY_SEPARATOR. "postsource.php");
			
			postallsourceitems($id);
			
			return true;
			
}
	
	
}	
	
?>