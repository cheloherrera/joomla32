<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsHelperSelect
{
	protected static function genericlist($list, $name, $attribs, $selected, $idTag)
	{
		if(empty($attribs))
		{
			$attribs = null;
		}
		else
		{
			$temp = '';
			foreach($attribs as $key=>$value)
			{
				$temp .= $key.' = "'.$value.'"';
			}
			$attribs = $temp;
		}

		return JHTML::_('select.genericlist', $list, $name, $attribs, 'value', 'text', $selected, $idTag);
	}

	public static function booleanlist( $name, $attribs = null, $selected = null )
	{
		$options = array(
			JHTML::_('select.option','','---'),
			JHTML::_('select.option',  '0', JText::_( 'JNo' ) ),
			JHTML::_('select.option',  '1', JText::_( 'JYes' ) )
		);
		return self::genericlist($options, $name, $attribs, $selected, $name);
	}

	public static function published($selected = null, $id = 'enabled', $attribs = array())
	{
		$options = array();
		$options[] = JHTML::_('select.option',null,'- '.JText::_('COM_ATS_COMMON_SELECTSTATE').' -');
		$options[] = JHTML::_('select.option',0,JText::_('JUNPUBLISHED'));
		$options[] = JHTML::_('select.option',1,JText::_('JPUBLISHED'));

		return self::genericlist($options, $id, $attribs, $selected, $id);
	}

	public static function buckets($selected = '', $id = 'ats_bucket_id', $attribs = array())
	{
		$options = array();
		$options[] = JHTML::_('select.option',null,'- '.JText::_('COM_ATS_TICKETS_BUCKET_SELECT').' -');
		$buckets = F0FModel::getTmpInstance('Buckets','AtsModel')
			->status('O,P')
			->getList();
		foreach($buckets as $bucket) {
			$options[] = JHTML::_('select.option',$bucket->ats_bucket_id,$bucket->title);
		}
		return self::genericlist($options, $id, $attribs, $selected, $id);
	}

	public static function ticketstatuses($selected = '', $name = 'status', $attribs = array(), $id = 'status')
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$options = array();
		$options[] = JHTML::_('select.option','','- '.JText::_('COM_ATS_TICKETS_STATUS_SELECT').' -');
		$options[] = JHTML::_('select.option','O',JText::_('COM_ATS_TICKETS_STATUS_O'));
		$options[] = JHTML::_('select.option','P',JText::_('COM_ATS_TICKETS_STATUS_P'));

		$statuses = AtsHelper::getCustomTicketStatuses();

		foreach($statuses as $value => $text)
		{
			$options[] = JHTML::_('select.option', $value, $text);
		}

		$options[] = JHTML::_('select.option','C',JText::_('COM_ATS_TICKETS_STATUS_C'));

		return self::genericlist($options, $name, $attribs, $selected, $id);
	}

	public static function bucketstatuses($selected = '', $id = 'status', $attribs = array())
	{
		return self::ticketstatuses($selected, $id, $attribs);
	}

	public static function publicstate($selected = '', $id = 'status', $attribs = array())
	{
		$options = array(
			JHTML::_('select.option','','- '.JText::_('COM_ATS_TICKETS_PUBLIC_SELECT').' -'),
			JHTML::_('select.option',  '0', JText::_( 'COM_ATS_TICKETS_PUBLIC_PRIVATE' ) ),
			JHTML::_('select.option',  '1', JText::_( 'COM_ATS_TICKETS_PUBLIC_PUBLIC' ) )
		);
		return self::genericlist($options, $id, $attribs, $selected, $id);
	}

	public static function languages($selected = null, $id = 'language', $attribs = array() )
	{
		JLoader::import('joomla.language.helper');
		$languages = JLanguageHelper::getLanguages('lang_code');
		$options = array();

		if (isset($attribs['allow_empty']))
		{
			if ($attribs['allow_empty'])
			{
				$options[] = JHTML::_('select.option','', '- '.JText::_('JALL_LANGUAGE').' -');
			}
		}

		$options[] = JHTML::_('select.option','*',JText::_('JALL_LANGUAGE'));
		if(!empty($languages)) foreach($languages as $key => $lang)
		{
			$options[] = JHTML::_('select.option',$key,$lang->title);
		}

		return self::genericlist($options, $id, $attribs, $selected, $id);
	}

	public static function renderlanguage($langCode)
	{
		static $langs = array();

		if(empty($langs)) {
			JLoader::import('joomla.language.helper');
			$languages = JLanguageHelper::getLanguages('lang_code');

			$langs['*'] = JText::_('JALL_LANGUAGE');
			if(!empty($languages)) foreach($languages as $key => $lang) {
				$langs[$key] = $lang->title;
			}
		}

		if(array_key_exists($langCode, $langs)) {
			return $langs[$langCode];
		} else {
			return $langCode;
		}
	}

	public static function getCategories($selected = null, $name = 'category', $attribs = array(), $default_option = null)
	{
        $options = self::getCategoriesOptions($default_option, true);

		return JHTML::_('select.genericlist', $options, $name, $attribs, 'value', 'text', $selected, $name);
	}

    /**
     * Static method that return only the options for a category select list.
     * In this way we can use it in a F0FForm list field.
     */
    public static function getCategoriesOptions($default_option = null, $asObject = false)
    {
        if(is_null($default_option)) {
            $default_option = 'COM_ATS_CONFIG_DEFAULTCAT_MSG';
        }

        $options	= array();

        if($asObject)
        {
            $options[]	= JHTML::_('select.option','0',JText::_( $default_option ));
        }
        else
        {
            $options[] = array('value' => 0, 'text' => JText::_($default_option));
        }


        if(!class_exists('CategoriesModelCategories'))
        {
            require_once JPATH_ADMINISTRATOR.'/components/com_categories/models/categories.php';
        }

        $model = new CategoriesModelCategories();
        $model->getState()->set('list.select', 'a.id, a.title, a.level');
        $model->getState()->set('filter.extension',	'com_ats');
        $model->getState()->set('filter.access',		null);
        $model->getState()->set('filter.published',	1);
        $items = $model->getItems();

        if(count($items)) foreach($items as $item)
        {
            $id     = $item->id;
            $title  = $item->title;

            if($item->level > 1)
            {
                $title = str_repeat('–', $item->level - 1).' '.$title;
            }

            if($asObject)
            {
                $options[] = JHTML::_('select.option', $id, $title);
            }
            else
            {
                $options[] = array('value' => $id, 'text' => $title);
            }

        }

        return $options;
    }

	public static function getManagers($selected = '', $id = 'user_id', $attribs = array(), $category = null)
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$options[] = JHTML::_('select.option','','- '.JText::_('COM_ATS_TICKETS_ASSIGN_TO').' -');

		$managers = AtsHelper::getManagers($category);
		foreach ($managers as $manager)
		{
			$options[] = JHTML::_('select.option', $manager->id, $manager->name);
		}

		return self::genericlist($options, $id, $attribs, $selected, $id);
	}

	public static function fieldtypesList()
	{
		static $fieldTypes = null;

		if (is_null($fieldTypes))
		{
			$fieldTypes = array();

			JLoader::import('joomla.filesystem.folder');
			$basepath = JPATH_ROOT.'/administrator/components/com_ats/assets/customfields';
			$files = JFolder::files($basepath, '.php');
			foreach($files as $file)
			{
				if ($file === 'abstract.php')
				{
					continue;
				}

				require_once $basepath.'/'.$file;
				$type = substr($file, 0, -4);
				$class = 'AtsCustomField' . ucfirst($type);
				if (class_exists($class))
				{
					$fieldTypes[] = array(
						'value'	=> 'COM_ATS_CUSTOMFIELDS_FIELD_TYPE_'.strtoupper($type),
						'key'	=> $type,
					);
				}
			}
		}

		return $fieldTypes;
	}

	/**
	 * Drop down list of custom field types
	 */
	public static function fieldtypes($name = 'type', $selected = 'text', $attribs = array())
	{
		$fieldTypes = self::fieldtypesList();

		$options = array();
		$options[] = JHTML::_('select.option','','- '.JText::_('COM_ATS_COMMON_SELECT').' -');
		foreach ($fieldTypes as $field)
		{
			$options[] = JHTML::_('select.option', $field['key'], JText::_($field['value']));
		}

		return self::genericlist($options, $name, $attribs, $selected, $name);
	}

	/**
	 * Drop down list of when to show custom fields
	 */
	public static function fieldshow($name = 'show', $selected = 'all', $attribs = array())
	{
		$options = array();
		$options[] = JHTML::_('select.option', ''		 ,'- '.JText::_('COM_ATS_COMMON_SELECT').' -');
		$options[] = JHTML::_('select.option', 'all'	 ,JText::_('COM_ATS_CUSTOMFIELDS_FIELD_SHOW_ALL'));
		$options[] = JHTML::_('select.option', 'category',JText::_('COM_ATS_CUSTOMFIELDS_FIELD_SHOW_CATEGORY'));

		return self::genericlist($options, $name, $attribs, $selected, $name);
	}

    /**
     * Ticket priorities select list
     *
     * @param   string       $name      Select list name and id
     * @param   string       $selected  Selected value
     * @param   array|string $attribs   Associative array of attributes
     *
     * @return  string   Select list HTML
     */
	public static function priorities($name = 'priority', $selected = '', $attribs = array())
	{
		$options = array();

		// Priority is a 1-5-10 list, so in the future we can add more items for fine-tuning
		$options[] = JHTML::_('select.option', ''   ,'- '.JText::_('COM_ATS_COMMON_SELECT').' -');
		$options[] = JHTML::_('select.option', '1'  ,JText::_('COM_ATS_PRIORITIES_HIGH'));
		$options[] = JHTML::_('select.option', '5'  ,JText::_('COM_ATS_PRIORITIES_NORMAL'));
		$options[] = JHTML::_('select.option', '10' ,JText::_('COM_ATS_PRIORITIES_LOW'));

		return self::genericlist($options, $name, $attribs, $selected, $name);
	}

    /**
     * User tag select list
     *
     * @param   string  $name       Select list name and id
     * @param   int     $selected   Selected value
     * @param   array   $attribs    Associative array of attributes
     *
     * @return string   Select list HTML
     */
    public static function usertags($name, $selected, $attribs = array())
    {
        $options = array();

        $tags = F0FModel::getTmpInstance('Usertags', 'AtsModel')
                    ->enabled(1)
                    ->filter_Order('ordering')
                    ->filter_Order_Dir('ASC')
                    ->limit(0)
                    ->getList();

        foreach($tags as $tag)
        {
            $options[] = JHTML::_('select.option', $tag->ats_usertag_id, $tag->title);
        }

        return self::genericlist($options, $name, $attribs, $selected, $name);
    }
}