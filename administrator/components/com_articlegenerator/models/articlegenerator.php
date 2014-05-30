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


class AGModelarticlegenerator extends JModelLegacy {

   ## Empty data variabele
   var $_data  = null;
   var $_dataconfig  = null;
   var $_id = null;
   
  
   function __construct()
   {
    $mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');
	  parent::__construct();

      $this->id = JRequest::getVar('cid', 0);  
	  
   }


   function getItem()
   {
		if (empty($this->_data))
		{
			$row = JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable' );
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			$id = $cid[0]; 
			$row->load($id);
		}
		
		$this->data = $row;
		return $this->data;
   }



	function store($data)
	{
	
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$row = JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable' );
		
		
		/* Get proper HTML-code for your HTML-encoded field now by using JREQUEST_ALLOWHTML*/
    $data['articleintrostyle']=JRequest::getVar( 'articleintrostyle', '', 'post', 'string', JREQUEST_ALLOWHTML );
    $data['articlefullstyle']=JRequest::getVar( 'articlefullstyle', '', 'post', 'string', JREQUEST_ALLOWHTML );
    /* now proceed as suggested */

		/* Does not do any filtering at all on the field now by using JREQUEST_ALLOWRAW. Use with extreme caution.*/
    $data['advert']=JRequest::getVar( 'advert', '', 'post', 'string', JREQUEST_ALLOWRAW );
    $data['allowabletags']=JRequest::getVar( 'allowabletags', '', 'post', 'string', JREQUEST_ALLOWRAW );
    /* now proceed as suggested */



		# For ordering
		if(!$data['id']){
			$query = "SELECT MAX(ordering) AS lastOrder FROM #__articlegenerator ";
			$db->setQuery($query);
			$maxOrdering = $db->loadObject();
			$data['ordering'] = $maxOrdering->lastOrder +1;
		}
		## Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		

		## Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} 

		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	
		return true;
		}		
   



  
 
 
  /**	
   * Functions for config 
   *	 	
   *
   **/ 
 
   function getItemconfig()
   {
		if (empty($this->_dataconfig))
		{
			$row = JTable::getInstance( 'articlegeneratorconfig' , 'articlegeneratorconfigTable' );
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			$id = $cid[0]; 
			$row->load($id);
		}
		
		$this->dataconfig = $row;
		return $this->dataconfig;
   }
 
 
 	function storeconfig($dataconfig)
	{
	
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$row = JTable::getInstance( 'articlegeneratorconfig' , 'articlegeneratorconfigTable' );
		
		# For ordering
		if(!$dataconfig['id']){
			$query = "SELECT MAX(ordering) AS lastOrder FROM #__articlegenerator_config ";
			$db->setQuery($query);
			$maxOrdering = $db->loadObject();
			$dataconfig['ordering'] = $maxOrdering->lastOrder +1;
		}
		## Bind the form fields to the table
		if (!$row->bind($dataconfig)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		

		## Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} 

		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	
		return true;
		}		
 
 
 
 
 
 
}
?>