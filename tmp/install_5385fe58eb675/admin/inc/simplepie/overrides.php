<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.2
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010-2011 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!

defined('_JEXEC') or die();

class SimplePie_Misc_FG extends SimplePie_Misc
{
	// allows proper conversion of encodings by checking if mb_convert_encoding can perform
	function change_encoding($data, $input, $output)
	{
		$input = SimplePie_Misc::encoding($input);
		$output = SimplePie_Misc::encoding($output);

		// We fail to fail on non US-ASCII bytes
		if ($input === 'US-ASCII')
		{
			static $non_ascii_octects = '';
			if (!$non_ascii_octects)
			{
				for ($i = 0x80; $i <= 0xFF; $i++)
				{
					$non_ascii_octects .= chr($i);
				}
			}
			$data = substr($data, 0, strcspn($data, $non_ascii_octects));
		}

		// This is first, as behaviour of this is completely predictable
		if ($input === 'Windows-1252' && $output === 'UTF-8')
		{
			return SimplePie_Misc::windows_1252_to_utf8($data);
		}
		// This is second, as behaviour of this varies only with PHP version (the middle part of this expression checks the encoding is supported).
		elseif (function_exists('mb_convert_encoding') && in_array($input,mb_list_encodings()) && @mb_convert_encoding("\x80", 'UTF-16BE', $input) !== "\x00\x80" && ($return = @mb_convert_encoding($data, $output, $input)))
		{
			return $return;
		}
		// This is last, as behaviour of this varies with OS userland and PHP version
		elseif (function_exists('iconv') && ($return = @iconv($input, $output, $data)))
		{
			return $return;
		}
		// If we can't do anything, just fail
		else
		{
			return false;
		}
	}
}

class SimplePieFG extends SimplePie
{
	/**
	 * This line and constructor added for possible compatibility with Joomla version less than 1.5.15
	 * @var string Class used for content-type sniffing
	 * @see SimplePie::set_content_type_sniffer_class()
	 * @access private
	 */
	var $content_type_sniffer_class = 'SimplePie_Content_Type_Sniffer';

	function SimplePieFG()
	{
		parent::SimplePie();
	}

	function init()
	{
		// Check absolute bare minimum requirements.
		if ((function_exists('version_compare') && version_compare(PHP_VERSION, '4.3.0', '<')) || !extension_loaded('xml') || !extension_loaded('pcre'))
		{
			return false;
		}
		// Then check the xml extension is sane (i.e., libxml 2.7.x issue on PHP < 5.2.9 and libxml 2.7.0 to 2.7.2 on any version) if we don't have xmlreader.
		elseif (!extension_loaded('xmlreader'))
		{
			static $xml_is_sane = null;
			if ($xml_is_sane === null)
			{
				$parser_check = xml_parser_create();
				xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
				xml_parser_free($parser_check);
				$xml_is_sane = isset($values[0]['value']);
			}
			if (!$xml_is_sane)
			{
				return false;
			}
		}

		if (isset($_GET[$this->javascript]))
		{
			SimplePie_Misc::output_javascript();
			exit;
		}

		// Pass whatever was set with config options over to the sanitizer.
		$this->sanitize->pass_cache_data($this->cache, $this->cache_location, $this->cache_name_function, $this->cache_class);
		$this->sanitize->pass_file_data($this->file_class, $this->timeout, $this->useragent, $this->force_fsockopen);

		if ($this->feed_url !== null || $this->raw_data !== null)
		{
			$this->data = array();
			$this->multifeed_objects = array();
			$cache = false;

			if ($this->feed_url !== null)
			{
				$parsed_feed_url = SimplePie_Misc::parse_url($this->feed_url);
				// Decide whether to enable caching
				if ($this->cache && $parsed_feed_url['scheme'] !== '')
				{
					$cache = call_user_func(array($this->cache_class, 'create'), $this->cache_location, call_user_func($this->cache_name_function, $this->feed_url), 'spc');
				}
				// If it's enabled and we don't want an XML dump, use the cache
				if ($cache && !$this->xml_dump)
				{
					// Load the Cache
					$this->data = $cache->load();
					if (!empty($this->data))
					{
						// If the cache is for an outdated build of SimplePie
						if (!isset($this->data['build']) || $this->data['build'] !== SIMPLEPIE_BUILD)
						{
							$cache->unlink();
							$this->data = array();
						}
						// If we've hit a collision just rerun it with caching disabled
						elseif (isset($this->data['url']) && $this->data['url'] !== $this->feed_url)
						{
							$cache = false;
							$this->data = array();
						}
						// If we've got a non feed_url stored (if the page isn't actually a feed, or is a redirect) use that URL.
						elseif (isset($this->data['feed_url']))
						{
							// If the autodiscovery cache is still valid use it.
							if ($cache->mtime() + $this->autodiscovery_cache_duration > time())
							{
								// Do not need to do feed autodiscovery yet.
								if ($this->data['feed_url'] === $this->data['url'])
								{
									$cache->unlink();
									$this->data = array();
								}
								else
								{
									$this->set_feed_url($this->data['feed_url']);
									return $this->init();
								}
							}
						}
						// Check if the cache has been updated
						elseif ($cache->mtime() + $this->cache_duration < time())
						{
							// If we have last-modified and/or etag set
							if (isset($this->data['headers']['last-modified']) || isset($this->data['headers']['etag']))
							{
								$headers = array();
								if (isset($this->data['headers']['last-modified']))
								{
									$headers['if-modified-since'] = $this->data['headers']['last-modified'];
								}
								if (isset($this->data['headers']['etag']))
								{
									$headers['if-none-match'] = '"' . $this->data['headers']['etag'] . '"';
								}
								$file = new $this->file_class($this->feed_url, $this->timeout/10, 5, $headers, $this->useragent, $this->force_fsockopen);
								if ($file->success)
								{
									if ($file->status_code === 304)
									{
										$cache->touch();
										return true;
									}
									else
									{
										$headers = $file->headers;
									}
								}
								else
								{
									unset($file);
								}
							}
						}
						// If the cache is still valid, just return true
						else
						{
							return true;
						}
					}
					// If the cache is empty, delete it
					else
					{
						$cache->unlink();
						$this->data = array();
					}
				}
				// If we don't already have the file (it'll only exist if we've opened it to check if the cache has been modified), open it.
				if (!isset($file))
				{
					if (is_a($this->file, 'SimplePie_File') && $this->file->url === $this->feed_url)
					{
						$file =& $this->file;
					}
					else
					{
						$file = new $this->file_class($this->feed_url, $this->timeout, 5, null, $this->useragent, $this->force_fsockopen);
					}
				}
				// If the file connection has an error, set SimplePie::error to that and quit
				if (!$file->success && !($file->method & SIMPLEPIE_FILE_SOURCE_REMOTE === 0 || ($file->status_code === 200 || $file->status_code > 206 && $file->status_code < 300)))
				{
					$this->error = $file->error;
					if (!empty($this->data))
					{
						return true;
					}
					else
					{
						return false;
					}
				}

				if (!$this->force_feed)
				{
					// Check if the supplied URL is a feed, if it isn't, look for it.
					$locate = new $this->locator_class($file, $this->timeout, $this->useragent, $this->file_class, $this->max_checked_feeds, $this->content_type_sniffer_class);
					if (!$locate->is_feed($file))
					{
						// We need to unset this so that if SimplePie::set_file() has been called that object is untouched
						unset($file);
						if ($file = $locate->find($this->autodiscovery, $this->all_discovered_feeds))
						{
							if ($cache)
							{
								$this->data = array('url' => $this->feed_url, 'feed_url' => $file->url, 'build' => SIMPLEPIE_BUILD);
								if (!$cache->save($this))
								{
									trigger_error("$this->cache_location is not writeable", E_USER_WARNING);
								}
								$cache = call_user_func(array($this->cache_class, 'create'), $this->cache_location, call_user_func($this->cache_name_function, $file->url), 'spc');
							}
							$this->feed_url = $file->url;
						}
						else
						{
							$this->error = "A feed could not be found at $this->feed_url";
							SimplePie_Misc::error($this->error, E_USER_NOTICE, __FILE__, __LINE__);
							return false;
						}
					}
					$locate = null;
				}

				$headers = $file->headers;
				$data = $file->body;
				$sniffer = new $this->content_type_sniffer_class($file);
				$sniffed = $sniffer->get_type();
			}
			else
			{
				$data = $this->raw_data;
			}

			// Set up array of possible encodings
			$encodings = array();

			// First check to see if input has been overridden.
			if ($this->input_encoding !== false)
			{
				$encodings[] = $this->input_encoding;
			}

			$application_types = array('application/xml', 'application/xml-dtd', 'application/xml-external-parsed-entity');
			$text_types = array('text/xml', 'text/xml-external-parsed-entity');

			// RFC 3023 (only applies to sniffed content)
			if (isset($sniffed))
			{
				if (in_array($sniffed, $application_types) || substr($sniffed, 0, 12) === 'application/' && substr($sniffed, -4) === '+xml')
				{
					if (isset($headers['content-type']) && preg_match('/;\x20?charset=([^;]*)/i', $headers['content-type'], $charset))
					{
						$encodings[] = strtoupper($charset[1]);
					}
					$encodings = array_merge($encodings, SimplePie_Misc::xml_encoding($data));
					$encodings[] = 'UTF-8';
				}
				elseif (in_array($sniffed, $text_types) || substr($sniffed, 0, 5) === 'text/' && substr($sniffed, -4) === '+xml')
				{
					if (isset($headers['content-type']) && preg_match('/;\x20?charset=([^;]*)/i', $headers['content-type'], $charset))
					{
						$encodings[] = $charset[1];
					}
					$encodings = array_merge($encodings, SimplePie_Misc::xml_encoding($data));
					$encodings[] = 'US-ASCII';
				}
				// Text MIME-type default
				elseif (substr($sniffed, 0, 5) === 'text/')
				{
					$encodings[] = 'US-ASCII';
				}
			}

			// Fallback to XML 1.0 Appendix F.1/UTF-8/ISO-8859-1
			$encodings = array_merge($encodings, SimplePie_Misc::xml_encoding($data));
			$encodings[] = 'UTF-8';
			$encodings[] = 'ISO-8859-1';

			// There's no point in trying an encoding twice
			$encodings = array_unique($encodings);

			// If we want the XML, just output that with the most likely encoding and quit
			if ($this->xml_dump)
			{
				header('Content-type: text/xml; charset=' . $encodings[0]);
				echo $data;
				exit;
			}

			// Loop through each possible encoding, till we return something, or run out of possibilities
			foreach ($encodings as $encoding)
			{
				// Change the encoding to UTF-8 (as we always use UTF-8 internally)
				if ($utf8_data = SimplePie_Misc_FG::change_encoding($data, $encoding, 'UTF-8'))
				{
					// Create new parser
					$parser = new $this->parser_class();

					// If it's parsed fine
					if ($parser->parse($utf8_data, 'UTF-8'))
					{
						$this->data = $parser->get_data();
						if ($this->get_type() & ~SIMPLEPIE_TYPE_NONE)
						{
							if (isset($headers))
							{
								$this->data['headers'] = $headers;
							}
							$this->data['build'] = SIMPLEPIE_BUILD;

							// Cache the file if caching is enabled
							if ($cache && !$cache->save($this))
							{
								trigger_error("$cache->name is not writeable", E_USER_WARNING);
							}
							return true;
						}
						else
						{
							$this->error = "A feed could not be found at $this->feed_url";
							SimplePie_Misc::error($this->error, E_USER_NOTICE, __FILE__, __LINE__);
							return false;
						}
					}
				}
			}
			if(isset($parser))
			{
				// We have an error, just set SimplePie_Misc::error to it and quit
				$this->error = sprintf('XML error: %s at line %d, column %d', $parser->get_error_string(), $parser->get_current_line(), $parser->get_current_column());
			}
			else
			{
				$this->error = 'The data could not be converted to UTF-8';
			}
			SimplePie_Misc::error($this->error, E_USER_NOTICE, __FILE__, __LINE__);
			return false;
		}
		elseif (!empty($this->multifeed_url))
		{
			$i = 0;
			$success = 0;
			$this->multifeed_objects = array();
			foreach ($this->multifeed_url as $url)
			{
				if (SIMPLEPIE_PHP5)
				{
					// This keyword needs to defy coding standards for PHP4 compatibility
					$this->multifeed_objects[$i] = clone($this);
				}
				else
				{
					$this->multifeed_objects[$i] = $this;
				}
				$this->multifeed_objects[$i]->set_feed_url($url);
				$success |= $this->multifeed_objects[$i]->init();
				$i++;
			}
			return (bool) $success;
		}
		else
		{
			return false;
		}
	}
}