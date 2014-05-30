<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################


// Disallow Direct Access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

## Require the base controller
require_once( JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'controller.php' );

## Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php';
	
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_articlegenerator'.DIRECTORY_SEPARATOR.'tables'.DIRECTORY_SEPARATOR); 


## Create the controller
$classname    = 'articlegeneratorController'.ucfirst($controller);
$controller   = new $classname( );

## Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

## Redirect if set by the controller
$controller->redirect();
?>
