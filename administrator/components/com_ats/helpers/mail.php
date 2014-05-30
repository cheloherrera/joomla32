<?php

/**
 * @package   ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license   GNU GPL v3 or later
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Mail download helper class
 */
class AtsHelperMail
{
	/** @var string Mailbox type; pop3 or imap */
	private $mailbox_type = 'pop3';

	/** @var string Mail server hostname */
	private $server = '';

	/** @var int Mail server port. Usually 110 for POP3, 143 for IMAP, 995 for POP3S and 993 for IMAPS */
	private $port = 110;

	/** @var bool Use SSL? */
	private $ssl = false;

	/** @var int Use TLS? 0 = no, 1 = if available, 2 = always */
	private $tls = '';

	/** @var bool Set to true ())default) to validate SSL certificates */
	private $validate_certificate = true;

	/** @var string Username to connect to the IMAP/POP3 server */
	private $username = '';

	/** @var string Password to connect to the IMAP/POP3 server */
	private $password = '';

	/** @var int Parameters to pass to imap_open. This is a bitmask. Useful value: OP_READONLY (open read-only) */
	private $options = 'NIL';

	/** @var int How many times to retry a connection */
	private $n_retries = 0;

	/** @var array Parameters to pass to imap_open. Currently, PHP supports only DISABLE_AUTHENTICATOR */
	private $params = array();

	/** @var string The mailbox connection string, used internally */
	private $mailbox = null;

	/** @var resource A mailbox connection */
	private $connection = null;

	/**
	 * Public constructor. The $params array can contain the following variables,
	 * corresponding to this class' private members of the same name:
	 * - mailbox_type            (required if not GMail) 'pop3' or 'imap'
	 * - server                    (required if not GMail) host name of the IMAP or POP3 mail server
	 * - port                    (optional) mail server port
	 * - ssl                    (optional) use SSL?
	 * - tls                    (optional) use TLS? 0 = no, 1 = if available, 2 = always
	 * - validate_certificate    (optional) true to validate the SSL certificates
	 * - gmail                    (optional) set to true and omit everything else if it's GMail / Google Apps
	 * - username                (required) Username
	 * - password                (required) Password
	 * - folder                    (optional) Folder containing email (only for IMAP), default is INBOX
	 * - options
	 * - n_retries
	 * - params
	 *
	 * @param array $params
	 */
	public function __construct($params = array())
	{
		$gmail = false;
		if (array_key_exists('gmail', $params))
		{
			if ($params['gmail'])
			{
				$this->mailbox_type = 'imap';
				$this->server = 'imap.gmail.com';
				$this->port = 993;
				$this->ssl = true;
				$this->tls = 1;
				$gmail = true;
			}
		}

		if (array_key_exists('mailbox_type', $params) && !$gmail)
		{
			if (strtolower($params['mailbox_type']) == 'pop3')
			{
				$this->mailbox_type = 'pop3';
			}
			else
			{
				$this->mailbox_type = 'imap';
			}
		}

		if (array_key_exists('server', $params) && !$gmail)
		{
			$this->server = $params['server'];
		}

		if (array_key_exists('ssl', $params) && !$gmail)
		{
			$this->ssl = $params['ssl'] ? true : false;
		}

		if (array_key_exists('tsl', $params))
		{
			$this->tls = (int)$params['tsl'];
			if (($this->tls < 0) || ($this->tls > 2))
			{
				$this->tls = 0;
			}
		}

		if (array_key_exists('port', $params) && !$gmail)
		{
			$this->port = (int)$params['port'];
		}
		elseif (!$gmail)
		{
			if ($this->mailbox_type == 'pop3')
			{
				if (!$this->ssl)
				{
					$this->port = 110;
				}
				else
				{
					$this->port = 995;
				}
			}
			else
			{
				if (!$this->ssl)
				{
					$this->port = 143;
				}
				else
				{
					$this->port = 993;
				}
			}
		}

		if (array_key_exists('username', $params))
		{
			$this->username = $params['username'];
		}

		if (array_key_exists('password', $params))
		{
			$this->password = $params['password'];
		}

		if (array_key_exists('validate_certificate', $params))
		{
			$this->validate_certificate = $params['validate_certificate'] ? true : false;
		}

		if (array_key_exists('options', $params))
		{
			$this->options = $params['options'];
		}

		if (array_key_exists('n_retries', $params))
		{
			$this->n_retries = (int)$params['n_retries'];
		}

		if (array_key_exists('params', $params))
		{
			$this->params = (array)$params['params'];
		}

		$email_folder = '';

		if (($this->mailbox_type == 'imap') && array_key_exists('folder', $params))
		{
			$email_folder = $params['folder'];
		}
		elseif (($this->mailbox_type == 'imap'))
		{
			$email_folder = 'INBOX';
		}

		$this->mailbox = '{' . $this->server . ':' . $this->port;

		if ($this->ssl)
		{
			$this->mailbox .= '/ssl';
		}

		if ($this->tls == 0)
		{
			$this->mailbox .= '/notls';
		}
		elseif ($this->tls == 2)
		{
			$this->mailbox .= '/tls';
		}

		$this->mailbox .= '/' . $this->mailbox_type;

		if ($this->validate_certificate)
		{
			$this->mailbox .= '/validate-cert';
		}
		else
		{
			$this->mailbox .= '/novalidate-cert';
		}

		$this->mailbox .= '}' . $email_folder;
	}

	/**
	 * Tries to connect to the specified mail server
	 *
	 * @throws Exception
	 */
	public function open()
	{
		// The mailbox is in this format:
		// {www.example.com:143/imap/ssl/notls/novalidate-cert}Folder/subfolder

		if (version_compare(PHP_VERSION, '5.3.2', 'ge'))
		{
			// PHP 5.3.2 or later
			$this->connection = @imap_open(
				$this->mailbox, $this->username, $this->password
			//,$this->options, $this->n_retries, $this->params
			);
		}
		else
		{
			// PHP 5.2.0 - 5.3.1
			$this->connection = @imap_open(
				$this->mailbox, $this->username, $this->password, $this->options, $this->n_retries
			);
		}
		if (empty($this->connection))
		{
			$errors = imap_errors();
			$error = array_pop($errors);
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTCONNECT') . ' : ' . $error, 500);
		}
	}

	/**
	 * Reopens the connection to the mail server
	 *
	 * @param string $mailbox (optional) Mailbox string to connect to, or empty to retry connecting using this object's connection parameters
	 *
	 * @throws Exception
	 */
	public function reopen($mailbox = null)
	{
		if (empty($mailbox))
		{
			$mailbox = $this->mailbox;
		}
		$result = @imap_reopen($this->connection, $mailbox);
		if (!$result)
		{
			$errors = imap_errors();
			$error = array_pop($errors);
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTCONNECT') . ' : ' . $error, 500);
		}
	}

	/**
	 * Closes the connection to the mail server
	 *
	 * @throws Exception
	 */
	public function close()
	{
		if (is_resource($this->connection))
		{
			$result = @imap_close($this->connection);
		}
		else
		{
			$result = true;
		}

		if (!$result)
		{
			$errors = imap_errors();
			$error = is_array($errors) && !empty($errors) ? array_pop($errors) : "";
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTCLOSE') . ' : ' . $error);
		}
	}

	/**
	 * Expunges the mailbox and closes the connection to the mail server. This
	 * should be called *instead* of close() if you don't want your mailbox to
	 * fill up.
	 *
	 * @throws Exception
	 */
	public function expunge()
	{
		$result = @imap_expunge($this->connection);
		if (!$result)
		{
			$errors = imap_errors();
			$error = is_array($errors) && !empty($errors) ? array_pop($errors) : "";
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTEXPUNGE') . ' : ' . $error);
		}
		$this->close();
	}

	/**
	 * Returns a mailbox connection info object. See imap_check() for more info.
	 *
	 * @return object
	 */
	public function check()
	{
		$info = imap_check($this->connection);

		return $info;
	}

	/**
	 * Deletes a message
	 *
	 * @param int $messageId Message ID to delete
	 *
	 * @throws Exception
	 */
	public function delete($messageId)
	{
		$result = @imap_delete($this->connection, $messageId);
		if (!$result)
		{
			$errors = imap_errors();
			$error = is_array($errors) && !empty($errors) ? array_pop($errors) : "";
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTDELETE') . ' ' . $messageId . ' : ' . $error, 500);
		}
	}

	/**
	 * Marks one or several messages as read
	 *
	 * @param int|array|string $messageIds A message ID, or an array of message IDs or a string with a comma-separated list of message IDs
	 *
	 * @throws Exception
	 */
	public function markRead($messageIds)
	{
		if (is_array($messageIds))
		{
			$messageIds = implode(',', $messageIds);
		}

		$result = @imap_setflag_full($this->connection, $messageIds, '\\Seen');
		if (!$result)
		{
			$errors = imap_errors();
			$error = is_array($errors) && !empty($errors) ? array_pop($errors) : "";
			throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTMARKREAD') . ' ' . $messageIds . ' : ' . $error, 500);
		}
	}

	/**
	 * Returns the headers of messages received since a specific date
	 *
	 * @param string $date
	 *
	 * @return array
	 */
	public function getHeadersSince($date = '')
	{
		$mids = $this->getMIDsSince($date);
		$ret = array();
		foreach ($mids as $k => $mid)
		{
			$ret[] = $this->getHeader($mid);
		}

		return $ret;
	}

	/**
	 * Returns the full messages received since a specific date
	 *
	 * @param string $date
	 *
	 * @return array
	 */
	public function getMessagesSince($date = '')
	{
		$mids = $this->getMIDsSince($date);
		$ret = array();

		if (!empty($mids))
		{
			foreach ($mids as $k => $mid)
			{
				$ret[] = $this->getMessage($mid);
			}
		}

		return $ret;
	}

	/**
	 * Gets the Message IDs since a specific date
	 *
	 * @param string $date An IMAP-compatible date, e.g. 31-12-1998
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getMIDsSince($date = '')
	{
		if (is_null($date))
		{
			$messages = @imap_search($this->connection, 'UNDELETED');
		}
		elseif (empty($date))
		{
			$messages = @imap_search($this->connection, 'RECENT UNDELETED');
		}
		else
		{
			$messages = @imap_search($this->connection, 'SINCE "' . $date . '" UNDELETED');
		}

		if ($messages === false)
		{
			$errors = imap_errors();
			$error = is_array($errors) && !empty($errors) ? array_pop($errors) : "";
			$messages = array();

			if (!empty($error))
			{
				throw new Exception(JText::_('COM_ATS_ERR_MAIL_CANNOTRETRIEVE') . ' ' . $error);
			}
		}

		return $messages;
	}

	/**
	 * Returns the headers of a message
	 *
	 * @param int $mid Message ID
	 *
	 * @return array
	 */
	public function getHeader($mid)
	{
		$header = @imap_headerinfo($this->connection, $mid);
		$struct = @imap_fetchstructure($this->connection, $mid);

		$message = array(
			'subject'     => $header->subject,
			'fromaddress' => $header->fromaddress,
			'fromemail'   => $header->from[0]->mailbox . '@' . $header->from[0]->host,
			'toaddress'   => $header->toaddress,
			'toemail'     => $header->to[0]->mailbox . '@' . $header->to[0]->host,
			'date'        => $header->MailDate, // email delivery date
			'sentdate'    => $header->date,
			'unixdate'    => $header->udate,
			'mid'         => $mid
		);

		return $message;
	}

	/**
	 * Returns a message's headers and body
	 *
	 * @param int $mid The message ID
	 *
	 * @return array
	 */
	public function getMessage($mid)
	{
		$header = @imap_headerinfo($this->connection, $mid);
		$struct = @imap_fetchstructure($this->connection, $mid);
		$uid = @imap_uid($this->connection, $mid);

		$ticketid = 0;
		$rawheaders = @imap_fetchheader($this->connection, $mid);
		$rawheaders = explode("\n", $rawheaders);
		if (is_array($rawheaders) && count($rawheaders))
		{
			foreach ($rawheaders as $line)
			{
				$line = trim($line);
				$line = strtolower($line);
				if (substr($line, 0, 14) == 'x-ats-ticketid')
				{
					$parts = explode(':', $line, 2);
					$ticketid = $parts[1];
				}
			}
		}

		$message = array(
			'subject'     => $header->subject,
			'fromaddress' => $header->fromaddress,
			'fromemail'   => $header->from[0]->mailbox . '@' . $header->from[0]->host,
			'toaddress'   => $header->toaddress,
			'toemail'     => $header->to[0]->mailbox . '@' . $header->to[0]->host,
			'date'        => $header->MailDate, // email delivery date
			'sentdate'    => $header->date,
			'unixdate'    => $header->udate,
			'mid'         => $mid,
			'uid'         => $uid,
			'ticketid'    => $ticketid,
			'parts'       => array(),
		);

		$plainText = $this->get_part($this->connection, $mid, "TEXT/PLAIN");
		$HTML = $this->get_part($this->connection, $mid, "TEXT/HTML");

		if (!empty($HTML))
		{
			$message['body'] = $HTML;
		}
		elseif (!empty($plainText))
		{
			$message['body'] = $plainText;
		}
		else
		{
			$message['body'] = '[EMAIL CONTAINS NO MESSAGE BODY]';
		}

		// Get attachments
		$attachments = array();
		$this->extractAttachments($struct, $mid, $attachments);
		$message['parts'] = $attachments;

		return $message;
	}

	private function extractAttachments($struct, $mid, &$attachments, $prefix = '')
	{
		if (!empty($struct->parts))
		{
			foreach ($struct->parts as $partNo => $p)
			{
				$params = array();
				$filename = null;

				// Get all parameters of the messages into a single array

				if (property_exists($p, 'parameters'))
				{
					foreach ($p->parameters as $x)
					{
						$params[strtolower($x->attribute)] = $x->value;
					}
				}

				if (property_exists($p, 'dparameters'))
				{
					foreach ($p->dparameters as $x)
					{
						$params[strtolower($x->attribute)] = $x->value;
					}
				}

				// Do we have an attachment filename?
				if (array_key_exists('filename', $params))
				{
					$filename = $params['filename'];
				}
				elseif (array_key_exists('name', $params))
				{
					$filename = $params['name'];
				}

				// What to do if this part is not an attachment?
				if (is_null($filename))
				{
					// If it has sub-parts try to extract attachments from it
					if (property_exists($p, 'parts'))
					{
						$tempPrefix = ($prefix ? $prefix . '.' : '') . ($partNo + 1) . '.';
						$this->extractAttachments($p, $mid, $attachments, $tempPrefix);
					}

					continue;
				}

				$mime = $this->get_mime_type($p);
				$data = $this->get_part($this->connection, $mid, false, $p, $prefix . ($partNo + 1));

				$attachments[] = (object)array(
					'filename' => $filename,
					'data'     => $data,
					'mime'     => $mime,
				);
			}
		}
	}

	private function get_mime_type(&$structure)
	{
		$primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
		if ($structure->subtype)
		{
			return $primary_mime_type[(int)$structure->type] . '/' . $structure->subtype;
		}

		return "TEXT/PLAIN";
	}

	private function get_part($stream, $msg_number, $mime_type = false, $structure = false, $part_number = false)
	{
		if (!$structure)
		{
			$structure = imap_fetchstructure($stream, $msg_number);
		}

		if ($structure)
		{
			if ($structure->type == 1) /* multipart */
			{
				$data = '';

				while (list($index, $sub_structure) = each($structure->parts))
				{
					if ($part_number)
					{
						$prefix = $part_number . '.';
					}
					else
					{
						$prefix = '';
					}

					$data .= $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
				}

				return $data;
			}
			elseif (($mime_type === false) || ($mime_type == $this->get_mime_type($structure)))
			{
				if (!$part_number)
				{
					$part_number = "1";
				}

				$text = imap_fetchbody($stream, $msg_number, $part_number);

				if ($structure->encoding == 3)
				{
					return imap_base64($text);
				}
				else if ($structure->encoding == 4)
				{
					return imap_qprint($text);
				}
				else
				{
					return $text;
				}
			}
		}

		return false;
	}
}