<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.1
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();
$ajax	=& JRequest::getInt('ajax',0);
$app	=& JFactory::getApplication();
$admin_img = (J_VERSION < 1.6) ? 'images/' : JURI::base(true).'/templates/'.$app->getTemplate().'/images/admin/';
$menu_img = JURI::base(true).'/templates/'.$app->getTemplate().'/images/menu/';

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'section_name' || $this->lists['order'] == 'cat_name' || $this->lists['order'] == 'ordering');
JHTML::_('behavior.tooltip');

if(!$ajax) { ?>
<form action="index.php?option=com_feedgator" method="post" name="adminForm">
<?php } ?>
	<table>
		<tr>
			<td width="100%"><?php echo JText::_( 'Filter' ); ?>:<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->lists['search']);?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_( 'Filter by title or enter article ID' );?>"/><button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button><button onclick="document.getElementById('search').value='';this.form.getElementById('filter_feedid').value='-1';this.form.getElementById('filter_sectionid').value='-1';this.form.getElementById('catid').value='0';this.form.getElementById('filter_authorid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap"><?php
			if(!$ajax) {
				echo $this->lists['feed'];
				echo $this->lists['sectionid'];
				echo $this->lists['catid'];
				echo $this->lists['authorid'];
				echo $this->lists['state'];
			}
				?></td>
		</tr>
	</table>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'Num' ); ?></th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->rows ); ?>);" /></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   'Title', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Published', 'state', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Front Page', 'frontpage', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="8%"><?php echo JHTML::_('grid.sort','Order','ordering',@$this->lists['order_Dir'],@$this->lists['order'] ); ?><?php if($ordering) echo JHTML::_('grid.order',$this->rows ); ?></th>
			<th width="7%"><?php echo JHTML::_('grid.sort','Access','groupname', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="8%" class="title" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Feed', 'feed_title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="8%" class="title" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Section', 'section_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="8%" class="title" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Category', 'cat_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="8%" class="title" nowrap="nowrap"><?php echo JHTML::_('grid.sort',   'Author', 'author', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="10" align="center"><?php echo JHTML::_('grid.sort',   'Date', 'created', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
			<th width="1%" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
		</tr>
	</thead>
	<tfoot>
	<tr>
		<td colspan="15">
			<?php echo $this->page->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	$nullDate = $db->getNullDate();
	for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
	{
		$row = &$this->rows[$i];
	//	$row->content_link already JRoute'd
		$row->feed_link = JRoute::_( 'index.php?option=com_feedgator&task=edit&cid[]='. $row->feedid );
		$row->sect_link = JRoute::_( 'index.php?option=com_sections&task=edit&cid[]='. $row->sectionid );
		$row->cat_link 	= JRoute::_( 'index.php?option=com_categories&task=edit&cid[]='. $row->catid );

		$publish_up =& JFactory::getDate($row->publish_up);
		$publish_down =& JFactory::getDate($row->publish_down);
		$publish_up->setOffset($config->getValue('config.offset'));
		$publish_down->setOffset($config->getValue('config.offset'));
		$img = (J_VERSION < 1.6) ? 'images/' : $admin_img;
		if ( $now->toUnix() <= $publish_up->toUnix() && $row->state == 1 ) {
			$img .= 'publish_y.png';
			$alt = JText::_( 'Published' );
		} else if ( ( $now->toUnix() <= $publish_down->toUnix() || $row->publish_down == $nullDate ) && $row->state == 1 ) {
			$img .= 'publish_g.png';
			$alt = JText::_( 'Published' );
		} else if ( $now->toUnix() > $publish_down->toUnix() && $row->state == 1 ) {
			$img .= 'publish_r.png';
			$alt = JText::_( 'Expired' );
		} else if ( $row->state == 0 ) {
			$img .= 'publish_x.png';
			$alt = JText::_( 'Unpublished' );
		} else if ( $row->state == ((J_VERSION < 1.6) ? -1 : 2) ) {
			$img .= 'disabled.png';
			$alt = JText::_( 'Archived' );
		} else if ( $row->state == -2 ) {
			$img = $menu_img.'icon-16-trash.png';
			$alt = JText::_( 'Trashed' );
		}
		$times = '';
		if (isset($row->publish_up)) {
			if ($row->publish_up == $nullDate) {
				$times .= JText::_( 'Start: Always' );
			} else {
				$times .= JText::_( 'Start' ) .": ". $publish_up->toFormat();
			}
		}
		if (isset($row->publish_down)) {
			if ($row->publish_down == $nullDate) {
				$times .= "<br />". JText::_( 'Finish: No Expiry' );
			} else {
				$times .= "<br />". JText::_( 'Finish' ) .": ". $publish_down->toFormat();
			}
		}

		if ( $user->authorize( 'com_users', 'manage' ) ) {
			if ( $row->created_by_alias ) {
				$author = $row->created_by_alias;
			} else {
				$linkA 	= 'index.php?option=com_users&task=edit&cid[]='. $row->created_by;
				$author = '<a href="'. JRoute::_( $linkA ) .'" title="'. JText::_( 'Edit User' ) .'">'. $row->author .'</a>';
			}
		} else {
			if ( $row->created_by_alias ) {
				$author = $row->created_by_alias;
			} else {
				$author = $row->author;
			}
		}

		$access 	= JHTML::_('grid.access',   $row, $i, $row->state );
		$checked 	= JHTML::_('grid.checkedout',   $row, $i );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $this->page->getRowOffset( $i ); ?></td>
			<td align="center"><?php echo $checked; ?></td>
			<td>
			<?php
				if (  JTable::isCheckedOut($user->get ('id'), $row->checked_out ) ) {
					echo $row->title;
				} else if ($row->state == -1) {
					echo htmlspecialchars($row->title, ENT_QUOTES, 'UTF-8');
					echo ' [ '. JText::_( 'Archived' ) .' ]';
				} else {
					?>
					<a href="<?php echo $row->content_link; ?>">
						<?php echo htmlspecialchars($row->title, ENT_QUOTES); ?></a>
					<?php
				}
				?></td>
			<?php
			if ( $times ) {
				?><td align="center">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Publish Information' );?>::<?php echo $times; ?>"><a href="javascript:void(0);" onclick="return listContentItemTask('cb<?php echo $i;?>','<?php echo $row->state ? 'unpublish' : 'publish' ?>')">
						<img src="<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a></span></td><?php
			}
			?><td align="center"><a href="javascript:void(0);" onclick="return listContentItemTask('cb<?php echo $i;?>','toggle_frontpage')" title="<?php echo ( $row->frontpage ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>">
					<img src="<?php echo $admin_img.( ( $row->frontpage ) ? ((J_VERSION < 1.6) ? 'tick.png' : 'featured.png') : ( $row->state != -1 ? 'publish_x.png' : 'disabled.png' ));?>" width="16" height="16" border="0" alt="<?php echo ( $row->frontpage ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>" /></a>
			</td>
			<td class="order"><span><?php echo $this->page->orderUpIcon( $i, ($row->catid == @$this->rows[$i-1]->catid), 'orderup', 'Move Up', $ordering); ?></span><span><?php echo $this->page->orderDownIcon( $i, $n, ($row->catid == @$this->rows[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span><?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?><input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?> class="text_area" style="text-align: center" />
			</td>
			<td align="center"><?php echo $access;?></td>
			<td><a href="<?php echo $row->feed_link; ?>" title="<?php echo JText::_( 'Edit Feed' ); ?>"><?php echo $row->feed_title; ?></a></td>
			<td><a href="<?php echo $row->sect_link; ?>" title="<?php echo JText::_( 'Edit Section' ); ?>"><?php echo $row->section_name; ?></a></td>
			<td><a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>"><?php echo $row->cat_name; ?></a></td>
			<td><?php echo $author; ?></td>
			<td nowrap="nowrap"><?php echo JHTML::_('date',  $row->created, JText::_('DATE_FORMAT_LC4') ); ?></td>
			<td><?php echo $row->id; ?></td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
	<?php //JHTML::_('content.legend'); ?>

<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="fgtab" value="11" />
<?php if(!$ajax) { ?>
<input type="hidden" name="option" value="com_feedgator" />
<input type="hidden" name="task" value="imports" />
<input type="hidden" name="redirect" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php }