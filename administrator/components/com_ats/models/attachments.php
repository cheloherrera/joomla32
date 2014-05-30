<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelAttachments extends F0FModel
{
	private function getFilterValues()
	{
		return (object)array(
			'enabled'		=> $this->getState('enabled',null,'int'),
			'since'			=> $this->getState('since',null,'string'),
			'until'			=> $this->getState('until',null,'string'),
			'filename'		=> $this->getState('filename',null,'string'),
			'mime'			=> $this->getState('mime',null,'string'),
		);
	}

	public function buildQuery($overrideLimits = false)
    {
		$db = $this->getDbo();

		$state = $this->getFilterValues();

		$query = $db->getQuery(true)
				->select('*')
				->from($db->qn('#__ats_attachments'));

		JLoader::import('joomla.utilities.date');

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
				$db->qn('enabled').' = '.$db->q($state->enabled)
			);
		}

		// Filter by original filename
		if($state->filename) {
			$fn = '%'.$state->filename.'%';
			$query->where(
				$db->qn('original_filename').' LIKE '.$db->q($fn)
			);
		}

		// Filter by MIME type
		if($state->mime) {
			$query->where(
				$db->qn('mime_type').' = '.$db->q($state->mime)
			);
		}

		// "Created Since" queries
		$since = trim($state->since);
		if(empty($since) || ($since == '0000-00-00') || ($since == '0000-00-00 00:00:00')) {
			$since = '';
		} else {
			$jFrom = new JDate($since);
			$since = $jFrom->toUnix();
			if($since == 0) {
				$since = '';
			} else {
				$since = $jFrom->toSql();
			}
			// Filter from-to dates
			$query->where(
				$db->qn('created_on').' >= '.$db->q($since)
			);
		}

		// "Created Until" queries
		$until = trim($state->until);
		if(empty($until) || ($until == '0000-00-00') || ($until == '0000-00-00 00:00:00')) {
			$until = '';
		} else {
			$jFrom = new JDate($until);
			$until = $jFrom->toUnix();
			if($until == 0) {
				$until = '';
			} else {
				$until = $jFrom->toSql();
			}
			$query->where(
				$db->qn('created_on').' <= '.$db->q($until)
			);
		}

		$order = $this->getState('filter_order', 'ats_attachment_id', 'cmd');
		if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'ats_attachment_id';
		$dir = strtoupper($this->getState('filter_order_Dir', 'DESC', 'cmd'));
		if(!in_array($dir,array('ASC','DESC'))) $dir = 'ASC';
		$query->order($order.' '.$dir);

		return $query;
	}

    public function updateSavedAttachments($attachments, $post)
    {
        if(!is_array($attachments))
        {
            $attachments = explode(',', $attachments);
        }

        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
                    ->update('#__ats_attachments')
                    ->set('ats_post_id = '.$post)
                    ->where('ats_attachment_id IN('.implode(',', $attachments).')');
        $db->setQuery($query)->query();
    }

    public function manageUploads($files)
    {
        if(!is_array($files))
        {
            return false;
        }

        if(!isset($files['name']))
        {
            return false;
        }

        JLoader::import('joomla.utilities.date');

        $w_files    = array();
        $errors     = array();
        $return     = array();
        $attachment = F0FModel::getTmpInstance('Attachments','AtsModel')->getTable();

        // Rearrange files array for better handling
        // We allow only 10 attachments maximum
        for($i = 0; $i < 10; $i++)
        {
            if(!isset($files['name'][$i]))
            {
                break;
            }

            // Remove whitespaces or MediaManager will report an error
            $w_files[] = array(
                'name'      => str_replace(' ', '_', $files['name'][$i]),
                'type'      => $files['type'][$i],
                'tmp_name'  => $files['tmp_name'][$i],
                'error'     => $files['error'][$i],
                'size'      => $files['size'][$i],
            );
        }

        $files = $w_files;

        foreach($files as $file)
        {
            $filedef = $this->uploadFile($file, true);

            if($filedef === false)
            {
                $errors[] = JText::sprintf('COM_ATS_ATTACHMENTS_ERR_UPLOAD', $file['name'], $this->getError());

                continue;
            }

            $attachment->reset();
            $attachment->ats_attachment_id = null;

            $jdate = new JDate();

            $filedef['created_by'] = JFactory::getUser()->id;
            $filedef['created_on'] = $jdate->toSql();
            $filedef['enabled']    = 1;

            if(!$attachment->save($filedef))
            {
                $errors[] = JText::sprintf('COM_ATS_ATTACHMENTS_ERR_UPLOAD', $file['name'], $attachment->getError());

                continue;
            }

            $return[] = $attachment->ats_attachment_id;
        }

        return array(
			implode(',', $return),
			$errors
		);
    }

	/**
	 * Moves an uploaded file to the media://com_ats/attachments directory
	 * under a random name and returns a full file definition array, or false if
	 * the upload failed for any reason.
	 *
	 * @param array $file The file descriptor returned by PHP
	 * @param boolean $checkUpload Should I check if upload is alloed for this file?
	 * @return array|bool
	 */
	public function uploadFile($file, $checkUpload = true)
	{
		if (isset($file['name']))
        {
            JLoader::import('joomla.filesystem.file');

			// Can we upload this file type?
			if ($checkUpload)
			{
				if(!class_exists('MediaHelper')) {
					require_once(JPATH_ADMINISTRATOR.'/components/com_media/helpers/media.php');
				}

                $err   = '';
				$paths = array(JPATH_ROOT, JPATH_ADMINISTRATOR);
				$jlang = JFactory::getLanguage();
				$jlang->load('com_media', $paths[0], 'en-GB', true);
				$jlang->load('com_media', $paths[0], null, true);
				$jlang->load('com_media', $paths[1], 'en-GB', true);
				$jlang->load('com_media', $paths[1], null, true);

				if (!MediaHelper::canUpload($file, $err))
                {
					if (!empty($err))
					{
						$err = JText::_($err);
					}
					else
					{
						$app = JFactory::getApplication();
						$errors = $app->getMessageQueue();

						if (count($errors))
						{
							$error = array_pop($errors);
							$err = $error['message'];
						}
						else
						{
							$err = '';
						}
					}

					if (!empty($err))
					{
						$this->setError(JText::_('COM_ATS_ATTACHMENTS_ERR_MEDIAHELPERERROR').' '.$err);
					}
					else
					{
						$this->setError(JText::_('COM_ATS_POSTS_ERR_ATTACHMENTERRORGENERIC'));
					}

					return false;
				}
			}

			// Get a (very!) randomised name
            $serverkey = JFactory::getConfig()->get('secret','');
			$sig       = $file['name'].microtime().$serverkey;

			if(function_exists('sha256'))
            {
				$mangledname = sha256($sig);
			}
            elseif(function_exists('sha1'))
            {
				$mangledname = sha1($sig);
			}
            else
            {
				$mangledname = md5($sig);
			}

			// ...and its full path
			$filepath = JPath::clean(JPATH_ROOT.'/media/com_ats/attachments/'.$mangledname);

			// If we have a name clash, abort the upload
			if (JFile::exists($filepath))
            {
				$this->setError(JText::_('COM_ATS_ATTACHMENTS_ERR_NAMECLASH'));
				return false;
			}

			// Do the upload
			if ($checkUpload)
			{
				if (!JFile::upload($file['tmp_name'], $filepath))
                {
					$this->setError(JText::_('COM_ATS_ATTACHMENTS_ERR_CANTJFILEUPLOAD'));
					return false;
				}
			}
			else
			{
				if (!JFile::copy($file['tmp_name'], $filepath))
				{
					$this->setError(JText::_('COM_ATS_ATTACHMENTS_ERR_CANTJFILEUPLOAD'));
					return false;
				}
			}

			// Get the MIME type
			if(function_exists('mime_content_type'))
            {
				$mime = mime_content_type($filepath);
			}
            elseif(function_exists('finfo_open'))
            {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($finfo, $filepath);
			}
            else
            {
				$mime = 'application/octet-stream';
			}

			// Return the file info
			return array(
				'original_filename'	=> $file['name'],
				'mangled_filename'	=> $mangledname,
				'mime_type'			=> $mime
			);
		}
        else
        {
			$this->setError(JText::_('COM_ATS_ATTACHMENTS_ERR_NOFILE'));

			return false;
		}
	}

	function doDownload()
	{
		$item = $this->getItem();

		// Calculate the Etag
		$etagContent = $item->mangled_filename.$item->mime_type.$item->original_filename.$item->created_on.$item->created_by;
		if(function_exists('sha1')) {
			$eTag = sha1($etagContent);
		} else {
			$eTag = md5($etagContent);
		}

		// Do we have an If-None-Match header?
		$inm = '';
		if(function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
			if(array_key_exists('If-None-Match', $headers)) $inm = $headers['If-None-Match'];
		}
		if(empty($inm)) {
			if(array_key_exists('HTTP-IF-NONE-MATCH', $_SERVER)) $inm = $_SERVER['HTTP-IF-NONE-MATCH'];
		}
		if($inm == $eTag) {
			while (@ob_end_clean());
			header('HTTP/1.0 304 Not Modified');
			jexit();
		}

		JLoader::import('joomla.filesystem.folder');
		JLoader::import('joomla.filesystem.file');

		$filepath = JPath::clean(JPATH_ROOT.'/media/com_ats/attachments/'.$item->mangled_filename);
		$basename = $item->original_filename;

		if(!JFile::exists($filepath)) {
			header('HTTP/1.0 404 Not Found');
			jexit();
		}

		JRequest::setVar('format','raw');

		// Disable error reporting and error display
		if(function_exists('error_reporting')) {
			$oldErrorReporting = error_reporting(0);
		}
		if(function_exists('ini_set')) {
			@ini_set('display_error', 0);
		}

		// Clear cache
		while (@ob_end_clean());

		// Fix IE bugs
		if (isset($_SERVER['HTTP_USER_AGENT']) && strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
			$header_file = preg_replace('/\./', '%2e', $basename, substr_count($basename, '.') - 1);

			if (ini_get('zlib.output_compression'))  {
				ini_set('zlib.output_compression', 'Off');
			}
		}
		else {
			$header_file = $basename;
		}

		@clearstatcache();

		// Disable caching for regular attachment disposition
		if($this->getState('disposition','attachment') !== 'attachment') {
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public", false);
		}

		// Send a Date header
		JLoader::import('joomla.utilities.date');
		$jDate = new JDate($item->created_on);
		header('Date: '.$jDate->toRFC822());

		// Send an Etag
		header('Etag: '.$eTag);

		// Send MIME headers
		header("Content-Description: File Transfer");
		if(empty($item->mime_type)) {
			header('Content-Type: application/octet-stream');
		} else {
			header('Content-Type: '.$item->mime_type);
		}
		header("Accept-Ranges: bytes");
		if($this->getState('disposition','attachment') != 'attachment') {
			header('Content-Disposition: inline; filename="'.$header_file.'"');
		} else {
			header('Content-Disposition: attachment; filename="'.$header_file.'"');
		}
		header('Content-Transfer-Encoding: binary');

		// Notify of filesize, if this info is available
		$filesize = @filesize($filepath);
		if($filesize > 0) header('Content-Length: '.(int)$filesize);

		// Disable time limits
		if ( ! ini_get('safe_mode') ) {
			set_time_limit(0);
		}

		// Use 1M chunks for echoing the data to the browser
		@flush();
		$chunksize = 1024*1024; //1M chunks
		$buffer = '';
		/**/
		$handle = @fopen($filepath, 'rb');
		if($handle !== false)
		{
			while (!feof($handle)) {
				$buffer = fread($handle, $chunksize);
				echo $buffer;
				@ob_flush();
				flush();
			}
			@fclose($handle);
		}
		else
		{
			@readfile($filepath);
			@flush();
		}
		/**/

		// Ungraceful application exit -- so that any plugins won't screw up the
		// download...
		jexit(0);
	}
}