<?php
/**
 * Element: 		FGFeeds
 * Displays FeedGator feeds and the plugin settings associated
 *
 * @package         FeedGator
 * @version         0.1
 *
 * @author          Matthew Faulds
 * @authorEmail		matt@trafalgardesign.com
 * @link            http://www.trafalgardesign.com
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;

/**
 * FGFeeds Element
 */
class FGFeeds
{
	var $_version = '0.1';

	function getInput($name, $id, $value, $params, $children)
	{
		$this->params = $params;

		if (!file_exists(JPATH_ADMINISTRATOR.'/components/com_feedgator/admin.feedgator.php')) {
			return 'FeedGator not installed...';
		}

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__feedgator_plugins as fp');
		$query->where("fp.extension = '$params->value'");
		$db->setQuery($query);
		$plugins = $db->loadObjectList();
		print_r($plugins);

		/*$tables = $db->getTableList();
		if (!in_array($db->getPrefix().'k2_categories', $tables)) {
			return 'K2 category table not found in database...';
		}

		$size = (int) $this->def('size');
		$multiple = $this->def('multiple');
		$get_categories = $this->def('getcategories', 1);
		$show_ignore = $this->def('show_ignore');

		if (!is_array($value)) {
			$value = explode(',', $value);
		}

		$query = $db->getQuery(true);
		$query->select('c.id, c.parent, c.parent AS parent_id, c.name AS title');
		$query->from('#__k2_categories AS c');
		$query->where('c.published = 1');
		if (!$get_categories) {
			$query->where('c.parent = 0');
		}
		$db->setQuery($query);
		$menuItems = $db->loadObjectList();

		// establish the hierarchy of the menu
		// TODO: use node model
		$children = array();

		if ($menuItems) {
			// first pass - collect children
			foreach ($menuItems as $v) {
				$pt = $v->parent;
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push($list, $v);
				$children[$pt] = $list;
			}
		}

		// second pass - get an indent list of the items
		require_once JPATH_LIBRARIES.'/joomla/html/html/menu.php';
		$list = JHTMLMenu::treerecurse(0, '', array(), $children, 9999, 0, 0);

		// assemble items to the array
		$options = array();
		if ($show_ignore) {
			if (in_array('-1', $value)) {
				$value = array('-1');
			}
			$options[] = JHtml::_('select.option', '-1', '- '.JText::_('NN_IGNORE').' -', 'value', 'text', 0);
		}
		foreach ($list as $item) {
			$item_name = preg_replace('#^((&nbsp;)*)- #', '\1', str_replace('&#160;', '&nbsp;', $item->treename));
			$options[] = JHtml::_('select.option', $item->id, $item_name, 'value', 'text', 0);
		}

		require_once JPATH_PLUGINS.'/system/nnframework/helpers/html.php';
		return nnHTML::selectlist($options, $name, $value, $id, $size, $multiple, '');*/
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}

class JFormFieldFG_FGFeeds extends JFormField
{
	/**
	 * The form field type
	 *
	 * @var		string
	 */
	public $type = 'FGFeeds';

	protected function getLabel()
	{
		return 'Not yet used';
	}

	protected function getInput()
	{
		$this->_field = new FGFeeds();
		return $this->_field->getInput($this->name, $this->id, $this->value, $this->element->attributes(), $this->element->children());
	}
}