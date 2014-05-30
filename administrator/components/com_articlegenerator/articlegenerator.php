<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################

## no direct access
defined('_JEXEC') or die('Restricted access');

// Load necessary language file since we dont store it in the language folder
$lang = JFactory::getLanguage();
$lang->load( 'com_articlegenerator', JPATH_COMPONENT );

// Load any helpers
//require_once( JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'helpers' .DIRECTORY_SEPARATOR. 'treatment.php' );


// Require the base controller
require_once( JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'controllers' .DIRECTORY_SEPARATOR. 'controller.php' );

// Set the tables path
JTable::addIncludePath( JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'tables' );

// Get the task
$task	= JRequest::getCmd( 'task' , 'display' );

## Require specific controller if requested.
if($controller = JRequest::getWord('controller', 'application')) {
	$path = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

## Create the controller
$classname	= 'AGController'.ucfirst($controller);
$controller	= new $classname( );

## Perform the Request task, display will be loaded automatically.
$controller->execute($task);
$controller->redirect();

?>