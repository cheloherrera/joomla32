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

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'table.php' );

class EasyBlogTableLikes extends EasyBlogTable
{
	/*
	 * The id of the category
	 * @var int
	 */
	var $id 					= null;

	/*
	 * The type
	 * @var string
	 */
	var $type					= null;

	/*
	 * Content ID
	 * @var int
	 */
	var $content_id				= null;

	/*
	 * creator ID
	 * @var int
	 */
	var $created_by				= null;

	/*
	 * Created datetime of the category
	 * @var datetime
	 */
	var $created				= null;



	/**
	 * Constructor for this class.
	 *
	 * @return
	 * @param object $db
	 */
	function __construct(& $db )
	{
		parent::__construct( '#__easyblog_likes' , 'id' , $db );
	}
}
