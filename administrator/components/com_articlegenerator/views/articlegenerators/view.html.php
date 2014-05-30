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

class AGViewarticlegenerators extends JViewLegacy {

	public function display($tpl = null, $cachable = false, $urlparams = false) {
		
		$mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');
		
		$db    = JFactory::getDBO();	
		
		JSubMenuHelper::addEntry( JText::_( 'Source Manager' ), 'index.php?option=com_articlegenerator&controller=articlegenerator');	
		JSubMenuHelper::addEntry( JText::_( 'Post All / Cron Job' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=cronjob');
		JSubMenuHelper::addEntry( JText::_( 'Twitter' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=twitter&cid=1');
		JSubMenuHelper::addEntry( JText::_( 'Configuration' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=config&cid=1');
		JSubMenuHelper::addEntry( JText::_( 'Compatibility Test' ), 'index.php?option=com_articlegenerator&controller=articlegenerator&task=compatibilitytest');
		
		$lists = array();

		## Model is defined in the controller
		$model	= $this->getModel();
		
		
		
		
		## Getting the items into a variable
		$states	= $this->get('Data');
		
		
		
		$pagination = $this->get('Pagination');
		
		
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.articlegenerators.filter_order', 		'filter_order', 	'ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.articlegenerators.filter_order_Dir',	'filter_order_Dir',	'', 'word' );


		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order']		= $filter_order;

		$this->lists=$lists;
		$this->items=$states;
		$orderby="";
		$this->orderby=$orderby;
		$order="";
		$this->order=$order;		
		$this->page=$pagination;
		
		
    JHtml::_('behavior.framework');
		// Load// the form validation behavior
		JHtml::_('behavior.formvalidation');

		parent::display($tpl);

	}
	
	
}
?>
