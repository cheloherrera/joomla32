<?php
/**
 * @version   $Id: locationsfield.php 8820 2013-03-27 14:02:53Z steph $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports a modal article picker.
 *
 * @package        RSEvents!
 * @subpackage     com_rsevents
 * @since          1.6
 */
class JFormFieldLocationsField extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since    1.6
	 */
	protected $type = 'LocationsField';

	/**
	 * Method to get the field input markup.
	 *
	 * @return    string    The field input markup.
	 * @since    1.6
	 */
    protected function getInput() {

        if (!class_exists('rseventsproHelper')) {
   			require_once JPATH_SITE.'/components/com_rseventspro/helpers/rseventspro.php';
   		}

   		$locations	= rseventsproHelper::getLocations(true);

        $options   = array();
        $options[] = JHTML::_('select.option', '0', JText::_('ROKMINIEVENTS_RSEVENTS_ALL_LOCATIONS'));
        foreach ($locations as $option) {
                $options[] = JHTML::_('select.option', $option->value, $option->text);
            }
            return JHTML::_('select.genericlist', $options, $this->name, 'multiple="multiple" class="inputbox"', 'value', 'text', $this->value, $this->name);
        }
}