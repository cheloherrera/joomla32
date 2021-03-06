<?php
/**
 * @package   AdminTools
 * @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 * @version   $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die;

// Load framework base classes
JLoader::import('joomla.application.component.view');

if (!class_exists('JoomlaCompatView'))
{
	if (interface_exists('JView'))
	{
		abstract class JoomlaCompatView extends JViewLegacy
		{
		}
	}
	else
	{
		class JoomlaCompatView extends JView
		{
		}
	}
}

class AdmintoolsViewHtmaker extends JoomlaCompatView
{
	public function display($tpl = null)
	{
		$model = $this->getModel();
		$htaccess = $model->makeHtaccess();

		$this->htaccess = $htaccess;

		$this->setLayout('plain');

		parent::display();
	}
}