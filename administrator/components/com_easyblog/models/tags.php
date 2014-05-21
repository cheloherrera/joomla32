<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Restricted access');

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'parent.php' );

class EasyBlogModelTags extends EasyBlogModelParent
{
	/**
	 * Category total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Category data array
	 *
	 * @var array
	 */
	var $_data = null;

	function __construct()
	{
		parent::__construct();


		$mainframe	= JFactory::getApplication();

		$limit		= $mainframe->getUserStateFromRequest( 'com_easyblog.tags.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		//$limitstart = $mainframe->getUserStateFromRequest( 'com_easyblog.limitstart', 'limitstart', 0, 'int' );
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Method to get the total nr of the categories
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the categories
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	/**
	 * Method to build the query for the tags
	 *
	 * @access private
	 * @return string
	 */
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildQueryWhere();
		$orderby	= $this->_buildQueryOrderBy();
		$db			= EasyBlogHelper::db();

		$query	= 'SELECT * FROM ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( '#__easyblog_tag' )
				. $where . ' '
				. $orderby;

		return $query;
	}

	function _buildQueryWhere()
	{
		$mainframe			= JFactory::getApplication();
		$db					= EasyBlogHelper::db();

		$filter_state 		= $mainframe->getUserStateFromRequest( 'com_easyblog.tags.filter_state', 'filter_state', '', 'word' );
		$search 			= $mainframe->getUserStateFromRequest( 'com_easyblog.tags.search', 'search', '', 'string' );
		$search 			= $db->getEscaped( trim(JString::strtolower( $search ) ) );

		$where = array();

		if ( $filter_state )
		{
			if ( $filter_state == 'P' )
			{
				$where[] = EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'published' ) . '=' . $db->Quote( '1' );
			}
			else if ($filter_state == 'U' )
			{
				$where[] = EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'published' ) . '=' . $db->Quote( '0' );
			}
		}

		if ($search)
		{
			$where[] = ' LOWER( title ) LIKE \'%' . $search . '%\' ';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

		return $where;
	}

	function _buildQueryOrderBy()
	{
		$mainframe			= JFactory::getApplication();

		$filter_order		= $mainframe->getUserStateFromRequest( 'com_easyblog.tags.filter_order', 		'filter_order', 	'ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'com_easyblog.tags.filter_order_Dir',	'filter_order_Dir',	'', 'word' );

		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.', ordering';

		return $orderby;
	}

	/**
	 * Method to get categories item data
	 *
	 * @access public
	 * @return array
	 */
	function getData( $usePagination = true)
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			if($usePagination)
				$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
			else
				$this->_data = $this->_getList($query);
		}

		return $this->_data;
	}

	/**
	 * Method to publish or unpublish tags
	 *
	 * @access public
	 * @return array
	 */
	function publish( &$tags , $publish = 1 )
	{
		if( count( $tags ) > 0 )
		{
			$db		= EasyBlogHelper::db();

			$tags	= implode( ',' , $tags );

			$query	= 'UPDATE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( '#__easyblog_tag' ) . ' '
					. 'SET ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'published' ) . '=' . $db->Quote( $publish ) . ' '
					. 'WHERE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'id' ) . ' IN (' . $tags . ')';
			$db->setQuery( $query );

			if( !$db->query() )
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

	function searchTag($title)
	{
		$db	= EasyBlogHelper::db();

		$query	= 'SELECT ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote('id') . ' '
				. 'FROM ' 	. EasyBlogHelper::getHelper( 'SQL' )->nameQuote('#__easyblog_tag') . ' '
				. 'WHERE ' 	. EasyBlogHelper::getHelper( 'SQL' )->nameQuote('title') . ' = ' . $db->quote($title) . ' '
				. 'LIMIT 1';
		$db->setQuery($query);

		$result	= $db->loadObject();

		return $result;
	}


	/**
	 * Returns the number of blog entries created within this category.
	 *
	 * @return int	$result	The total count of entries.
	 * @param boolean	$published	Whether to filter by published.
	 */
	function getUsedCount( $tagId , $published = false )
	{
		$db			= EasyBlogHelper::db();

		$query  = 'SELECT COUNT(a.tag_id) FROM `#__easyblog_post_tag` as a';
		$query  .= ' INNER JOIN `#__easyblog_post` as b ON a.post_id = b.id';
		$query  .= ' WHERE `tag_id` = ' . $db->Quote( $tagId );

		if( $published )
		{
			$query	.= ' AND a.`published` = ' . $db->Quote( 1 );
		}

		$db->setQuery( $query );

		$result	= $db->loadResult();

		return $result;
	}

	function setDefault( $cid )
	{
		$db		= EasyBlogHelper::db();
		$tagIds	= implode( ',' , $cid );

		$query	= 'UPDATE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( '#__easyblog_tag' ) . ' '
				. 'SET ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'default' ) . '=' . $db->Quote( 1 ) . ' '
				. 'WHERE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'id' ) . ' IN (' . $tagIds . ')';
		$db->setQuery( $query );

		if( !$db->query() )
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	function unsetDefault( $cid )
	{
		$db		= EasyBlogHelper::db();
		$tagIds	= implode( ',' , $cid );

		$query	= 'UPDATE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( '#__easyblog_tag' ) . ' '
				. 'SET ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'default' ) . '=' . $db->Quote( 0 ) . ' '
				. 'WHERE ' . EasyBlogHelper::getHelper( 'SQL' )->nameQuote( 'id' ) . ' IN (' . $tagIds . ')';
		$db->setQuery( $query );

		if( !$db->query() )
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
}
