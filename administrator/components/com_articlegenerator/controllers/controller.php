<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class AGController extends JControllerLegacy
{

	public function display($cachable = false, $urlparams = false) {
		JRequest::setVar( 'layout', 'default');
		JRequest::setVar( 'view', 'articlegenerators');
		parent::display();		
	}


	


}	
?>

