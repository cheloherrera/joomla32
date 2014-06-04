<?php
/**
 * @version   $Id: date.php 16836 2013-12-12 18:12:27Z arifin $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');
gantry_import('core.utilities.gantrydate');
/**
 * @package     gantry
 * @subpackage  features
 */
class GantryFeatureDate extends GantryFeature
{
	var $_feature_name = 'date';

	function render($position)
	{
		/** @var $gantry Gantry */
		global $gantry;
		ob_start();
		$now    = new GantryDate();
		$format = $this->get('formats');
		?>
    <div class="rt-block date-block">
    	<div id="rt-date">
    		<span class="date"><?php echo $now->toFormat($format); ?></span>
    	</div>
    </div>
	<?php
		return ob_get_clean();
	}

}
