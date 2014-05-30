<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################


defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class AGModelarticlegenerators extends JModelLegacy {

	## Empty data variabele
	var $_data			  = null;
	var $_item		 	  = null;
	var $_total     	= null;
	var $_pagination	= null;
   
   function __construct()
   {
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		parent::__construct();

		$this->id = JRequest::getVar('cid', 0); 

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');		
		

		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
   }



  

   function getData()
   {
		 // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
		
        return $this->_data;

   }



   function getTotal()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
			
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  }

  function getPagination()
  {
   
		// Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  }

   
	
 
	function publish($cid = array(), $publish = 1) {
		
		## Count the cids
		if (count( $cid )) {
		
			## Make cids safe, against SQL injections
			JArrayHelper::toInteger($cid);
			## Implode cids for more actions (when more selected)
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__articlegenerator'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )';
			
			## Do the query now	
			
			$this->_db->setQuery( $query );
			
			## When query goes wrong.. Show message with error.
			if (!$this->_db->execute()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}


	/**
	 * Method to build the query for the categories
	 *
	 * @access private
	 * @return integer
	 * @since 0.9
	 */
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
		
//		$query = 'SELECT SQL_CALC_FOUND_ROWS  id, title, feed_url, published, frontpage, validfor, sectionid, catid, ordering'
//					. ' FROM #__articlegenerator '
//					. $where
//					. $orderby
//					;
		$query = 'SELECT SQL_CALC_FOUND_ROWS  id, title, feed_url, published, frontpage, validfor, catid, ordering'
					. ' FROM #__articlegenerator '
					. $where
					. $orderby
					;
					
		return $query;
	}

	/**
	 * Method to build the orderby clause of the query for the categories
	 *
	 * @access private
	 * @return string
	 * @since 0.9
	 */
	function _buildContentOrderBy()
	{
		$mainframe = JFactory::getApplication();
		   $option = JRequest::getCmd('option');

		$filter_order		= $mainframe->getUserStateFromRequest($option.'.articlegenerators.filter_order', 		'filter_order', 	'ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'.articlegenerators.filter_order_Dir',	'filter_order_Dir',	'', 'word' );
		
		

		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.', ordering';

		return $orderby;
	}

	/**
	 * Method to build the where clause of the query for the categories
	 *
	 * @access private
	 * @return string
	 * @since 0.9
	 */
	function _buildContentWhere()
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');

		$filter_state = $mainframe->getUserStateFromRequest( $option.'.articlegenerators.filter_state', 'filter_articlegenerator', '', 'word' );
		$search 			= $mainframe->getUserStateFromRequest( $option.'.articlegenerators.search', 'search', '', 'string' );
		$search 			= $this->_db->escape( trim(JString::strtolower( $search ) ) );

		$where = array();

		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'published = 0';
			}
		}

		if ($search) {
			$where[] = ' LOWER(articlegenerator) LIKE \'%'.$search.'%\' ';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

		return $where;
	}

	
	/**
	 * Method to order categories
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.9
	 */
	function saveorder($cid = array(), $order)
	{
		$row = JTable::getInstance( 'articlegenerator' , 'articlegeneratorTable' );


		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );


			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		
		return true;
	}



	/**
	 * Method to remove a country
	 *
	 * @access	public
	 * @return	string $msg
	 * @since	0.9
	 */
	function remove($cid)
	{
		## If someone is trying to delete without $cid
		## If there is no cid provided, redirect the component.
		if(count($cid) < 1 ) {
		
			$mainframe->redirect('index.php?option='.$option.'&controller=articlegenerator&view=articlegenerators', JText::_( 'Please select at least one articlegenerator to remove!' ));
		}
		

		$cids = implode( ',', $cid );

		## Check if any state is added in the countries selected to re
		$query = 'DELETE FROM #__articlegenerator'
					. ' WHERE id IN ('. $cids .')';

		
		$this->_db->setQuery( $query );

		

		
		

		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__articlegenerator'
					. ' WHERE id IN ('. $cids .')';

			$this->_db->setQuery( $query );

			if(!$this->_db->execute()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		
	}
 
	}
?>