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

class AGControllerarticlegenerator extends JControllerLegacy
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		
		## Register Extra tasks
		
		$this->registerTask( 'addarticlegenerator' , 'editarticlegenerator' );
		$this->registerTask( 'articlegeneratorunpublish' , 'articlegeneratorpublish' );
		$this->registerTask( 'applyarticlegenerator' , 'savearticlegenerator' );
		
		
		
	}
	

	public function display($cachable = false, $urlparams = false) {
		$view = JRequest::getVar( 'view','articlegenerators','request','word');
		JRequest::setVar( 'layout', 'default');
		JRequest::setVar( 'view', $view);
		parent::display();		
	}

	

	/**
	 * Logic to mass ordering articlegenerators
	 *
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	function saveOrderarticlegenerators()
	{
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));

		$model = $this->getModel('articlegenerators');
		$model->saveorder($cid, $order);

		$msg = 'New ordering saved';
		$this->setRedirect( 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators', $msg );
	}


   
	

	/**	
	 * Save the ordering of the one record.
	 *	 	
	 * @access public
	 *
	 **/	 
	function orderUp()
	{
		
		$mainframe = JFactory::getApplication();
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;
		
		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];

			// Load the JTable Object.
			$table	= JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable' );			
			$table->load( $id );
			$table->move( $direction );

			$cache	= JFactory::getCache( 'com_articlegenerator');
			$cache->clean();
			
			$mainframe->redirect( 'index.php?option=com_articlegenerator&controller=articlegenerator' );
		}
		
	}


	/**	
 	 * Save the ordering of the one record.
	 *	 	
	 * @access public
	 *
	 **/
	 
	function orderDown()
	{
		
		$mainframe = JFactory::getApplication();
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;
		
		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];

			// Load the JTable Object.
			$table	= JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable' );	

			$table->load( $id );
			$table->move( $direction );

			$cache	= JFactory::getCache( 'com_articlegenerator');
			$cache->clean();
			
			$mainframe->redirect( 'index.php?option=com_articlegenerator&controller=articlegenerator' );
		}
		
	}


	function removearticlegenerator() {
	
		
		$mainframe = JFactory::getApplication();
    $option = JRequest::getCmd('option');
	
		$cid = JRequest::getVar('cid', 0);
		$model = $this->getModel('articlegenerators');

		if(!($msg = $model->remove($cid))) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		## Nothing went wrong, redirect now to the overview.
		$mainframe->redirect('index.php?option='.$option.'&controller=articlegenerator&view=articlegenerators', $msg);	
		
	}




	/**	
	 * This function will publish or unpublish articlegenerators
	 *	 	
	 * @access public
	 *
	 **/	

	function articlegeneratorPublish()
	{
		
		$mainframe = JFactory::getApplication();

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		
		## Getting the task (publish/upnpublish)
		if ($this->getTask() == 'articlegeneratorpublish') {
			$publish = 1;
		} else {
			$publish = 0;
		}		
	
		if (count( $cid ) < 1) {
			$link = 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators';
			$this->setRedirect($link, 'Select a articlegenerator to publish');
		}

		$model = $this->getModel('articlegenerators');

		if(!$model->publish($cid, $publish)) {
			$link = 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators';
			$this->setRedirect($link, 'The Model Doesn\'t Exists');
		}

		$link = 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators';
		$this->setRedirect($link, "Status of the selected articlegenerator(s) changed!");
	}

		

	/**	
	 * This function will save   articlegenerators
	 *	 	
	 * @access public
	 *
	 **/

	
	function savearticlegenerator() {
		$mainframe = JFactory::getApplication();
		$post	            = JRequest::get('post');
	
		
		$model	= $this->getModel('articlegenerator');

		if ($model->store($post)) {
			$msg = JText::_( 'articlegenerator Saved' );
		} else {
			$msg = JText::_( 'Error Saving...' );
		}
	
		$link = 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators';
		$this->setRedirect($link, $msg);

	}

	

	


	/**	
	 * This function will edit articlegenerators
	 *	 	
	 * @access public
	 *
	 **/

	

	function editarticlegenerator() {
		
	  JRequest::setVar( 'layout', 'form');
	  JRequest::setVar( 'view', 'articlegenerator');		
	  JRequest::setVar( 'hidemainmenu', 1 );

		
  	$model= $this->getModel('articlegenerator');
	  $task= JRequest::getVar('task');
	  if ($task == 'addarticlegenerator'){
		  JRequest::setVar( 'cid', 0 );
		  }
		
	  	 parent::display();
		  }

		
		
	/**	
	 * This function will get data  articlegenerators  and save all to database 
	 *	 	
	 * @access public
	 *
	 **/

	
	function postAll(){
		set_time_limit(0);
		$mainframe = JFactory::getApplication();
		global $countFeedItem;
		$feedid = JRequest::getVar('feedid', 0);
		
		if($feedid=='end'){
		sleep(5);
		echo '';
		}
		else{
			if (!$feedid) {
			$msg = JText::_('Error:  Select a articlegenerator to Post All');
			echo $msg;
			}
		
			$model = $this->getModel('showsourceitem');
			
			
			if($model->feedDataInfo($feedid)) {

				echo '<br><img src="administrator/components/com_articlegenerator/assets/images/save_f2.png" width="20" height="20" border="0"  />';
				echo ' '.$countFeedItem .' Item Saved ';
				echo "<br> Saved  Feed ID: ". $feedid;
			}
			else{
				echo " Error Processing Feed ID: ". $feedid;
			}
	
		}

	}







		
  /**	
   * This functions are for the other tabs
   *	 	
   *
   **/		
  /**	
   * Function showsource 
   *	 	
   *
   **/
  function showsource(){

		
		JRequest::setVar( 'layout', 'showsource');
		JRequest::setVar( 'view', 'articlegenerator');	
		parent::display();	
  }


  /**	
   * Function cronjob 
   *	 	
   *
   **/
  function cronjob(){


		JRequest::setVar( 'layout', 'cronjob');
		JRequest::setVar( 'view', 'articlegenerator');	
		parent::display();	
  }


  /**	
   * Function twitter 
   *	 	
   *
   **/
  function twitter(){


		JRequest::setVar( 'layout', 'twitter');
		JRequest::setVar( 'view', 'articlegenerator');	
		parent::display();	
  }



  /**	
   * Function config 
   *	
   *
   **/
  function config(){


		JRequest::setVar( 'layout', 'config');
		JRequest::setVar( 'view', 'articlegenerator');	
		parent::display();	
  }

  function savearticlegeneratorconfig() {
		$mainframe = JFactory::getApplication();
		$post	            = JRequest::get('post');
		
		$model	= $this->getModel('articlegenerator');

		if ($model->storeconfig($post)) {
			$msg = JText::_( 'articlegeneratorconfig Saved' );
		} else {
			$msg = JText::_( 'Error Saving...' );
		}
	
		$link = 'index.php?option=com_articlegenerator&controller=articlegenerator&view=articlegenerators';
		$this->setRedirect($link, $msg);

	}
	

	
	
  /**	
   * Function compatibilitytest 
   *	 	
   *
   **/
  function compatibilitytest(){


		JRequest::setVar( 'layout', 'compatibilitytest');
		JRequest::setVar( 'view', 'articlegenerator');	
		parent::display();	
  }




}


?>







