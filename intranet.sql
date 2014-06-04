CREATE DATABASE  IF NOT EXISTS `nstest` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nstest`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: nstest
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `nstest_admintools_acl`
--

DROP TABLE IF EXISTS `nstest_admintools_acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_acl` (
  `user_id` bigint(20) unsigned NOT NULL,
  `permissions` mediumtext,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_acl`
--

LOCK TABLES `nstest_admintools_acl` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_acl` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_adminiplist`
--

DROP TABLE IF EXISTS `nstest_admintools_adminiplist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_adminiplist` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_adminiplist`
--

LOCK TABLES `nstest_admintools_adminiplist` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_adminiplist` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_adminiplist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_badwords`
--

DROP TABLE IF EXISTS `nstest_admintools_badwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_badwords` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_badwords`
--

LOCK TABLES `nstest_admintools_badwords` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_badwords` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_badwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_cookies`
--

DROP TABLE IF EXISTS `nstest_admintools_cookies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_cookies` (
  `series` varchar(255) NOT NULL,
  `client_hash` varchar(255) NOT NULL,
  `valid_to` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`series`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_cookies`
--

LOCK TABLES `nstest_admintools_cookies` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_cookies` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_cookies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_customperms`
--

DROP TABLE IF EXISTS `nstest_admintools_customperms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_customperms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `perms` varchar(4) DEFAULT '0644',
  UNIQUE KEY `id` (`id`),
  KEY `path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_customperms`
--

LOCK TABLES `nstest_admintools_customperms` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_customperms` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_customperms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_filescache`
--

DROP TABLE IF EXISTS `nstest_admintools_filescache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_filescache` (
  `admintools_filescache_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `path` varchar(2048) NOT NULL,
  `filedate` int(11) NOT NULL DEFAULT '0',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `data` blob,
  `checksum` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`admintools_filescache_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_filescache`
--

LOCK TABLES `nstest_admintools_filescache` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_filescache` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_filescache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_ipautoban`
--

DROP TABLE IF EXISTS `nstest_admintools_ipautoban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_ipautoban` (
  `ip` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT 'other',
  `until` datetime DEFAULT NULL,
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_ipautoban`
--

LOCK TABLES `nstest_admintools_ipautoban` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_ipautoban` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_ipautoban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_ipautobanhistory`
--

DROP TABLE IF EXISTS `nstest_admintools_ipautobanhistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_ipautobanhistory` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT 'other',
  `until` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_ipautobanhistory`
--

LOCK TABLES `nstest_admintools_ipautobanhistory` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_ipautobanhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_ipautobanhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_ipblock`
--

DROP TABLE IF EXISTS `nstest_admintools_ipblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_ipblock` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_ipblock`
--

LOCK TABLES `nstest_admintools_ipblock` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_ipblock` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_ipblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_log`
--

DROP TABLE IF EXISTS `nstest_admintools_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logdate` datetime NOT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `reason` enum('other','adminpw','ipwl','ipbl','sqlishield','antispam','tpone','tmpl','template','muashield','csrfshield','badbehaviour','geoblocking','rfishield','dfishield','uploadshield','xssshield','httpbl','loginfailure','securitycode','external','awayschedule','admindir') DEFAULT NULL,
  `extradata` mediumtext,
  UNIQUE KEY `id` (`id`),
  KEY `idx_admintools_log_logdate_reason` (`logdate`,`reason`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_log`
--

LOCK TABLES `nstest_admintools_log` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_profiles`
--

DROP TABLE IF EXISTS `nstest_admintools_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `configuration` longtext,
  `filters` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_profiles`
--

LOCK TABLES `nstest_admintools_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_profiles` DISABLE KEYS */;
INSERT INTO `nstest_admintools_profiles` VALUES (1,'Default PHP Change Scanner Profile','','');
/*!40000 ALTER TABLE `nstest_admintools_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_redirects`
--

DROP TABLE IF EXISTS `nstest_admintools_redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_redirects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(255) DEFAULT NULL,
  `dest` varchar(255) DEFAULT NULL,
  `ordering` bigint(20) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `keepurlparams` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_redirects`
--

LOCK TABLES `nstest_admintools_redirects` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_redirects` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_redirects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_scanalerts`
--

DROP TABLE IF EXISTS `nstest_admintools_scanalerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_scanalerts` (
  `admintools_scanalert_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `path` varchar(2048) NOT NULL,
  `scan_id` bigint(20) NOT NULL DEFAULT '0',
  `diff` mediumtext,
  `threat_score` int(11) NOT NULL DEFAULT '0',
  `acknowledged` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admintools_scanalert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_scanalerts`
--

LOCK TABLES `nstest_admintools_scanalerts` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_scanalerts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_scanalerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_scans`
--

DROP TABLE IF EXISTS `nstest_admintools_scans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_scans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `comment` longtext,
  `backupstart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backupend` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('run','fail','complete') NOT NULL DEFAULT 'run',
  `origin` varchar(30) NOT NULL DEFAULT 'backend',
  `type` varchar(30) NOT NULL DEFAULT 'full',
  `profile_id` bigint(20) NOT NULL DEFAULT '1',
  `archivename` longtext,
  `absolute_path` longtext,
  `multipart` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `filesexist` tinyint(3) NOT NULL DEFAULT '1',
  `remote_filename` varchar(1000) DEFAULT NULL,
  `total_size` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fullstatus` (`filesexist`,`status`),
  KEY `idx_stale` (`status`,`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_scans`
--

LOCK TABLES `nstest_admintools_scans` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_scans` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_scans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_storage`
--

DROP TABLE IF EXISTS `nstest_admintools_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_storage` (
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_storage`
--

LOCK TABLES `nstest_admintools_storage` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_storage` DISABLE KEYS */;
INSERT INTO `nstest_admintools_storage` VALUES ('atoolsjupdatecheck_lastrun','1401882653');
/*!40000 ALTER TABLE `nstest_admintools_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_wafexceptions`
--

DROP TABLE IF EXISTS `nstest_admintools_wafexceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_wafexceptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_wafexceptions`
--

LOCK TABLES `nstest_admintools_wafexceptions` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_wafexceptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_admintools_wafexceptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_admintools_waftemplates`
--

DROP TABLE IF EXISTS `nstest_admintools_waftemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_admintools_waftemplates` (
  `admintools_waftemplate_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) NOT NULL,
  `language` varchar(10) NOT NULL DEFAULT '*',
  `subject` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `email_num` tinyint(3) unsigned NOT NULL,
  `email_numfreq` tinyint(3) unsigned NOT NULL,
  `email_freq` enum('','second','minute','hour','day') NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admintools_waftemplate_id`),
  UNIQUE KEY `admintools_waftemplate_keylang` (`reason`,`language`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_admintools_waftemplates`
--

LOCK TABLES `nstest_admintools_waftemplates` WRITE;
/*!40000 ALTER TABLE `nstest_admintools_waftemplates` DISABLE KEYS */;
INSERT INTO `nstest_admintools_waftemplates` VALUES (1,'all','*','Security exception on [SITENAME]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello,</p>\r\n<p>We would like to notify you that a security exception was detected on your site, [SITENAME], with the following details:</p>\r\n<p>IP Address: [IP] (IP Lookup: [LOOKUP])<br />Reason: [REASON]</p>\r\n<p>If this kind of security exception repeats itself, please log in to your site\'s back-end and add this IP address to your Admin Tools\'s Web Application Firewall feature in order to completely block the misbehaving user.</p>\r\n<p>Best regards,</p>\r\n<p>The [SITENAME] team</p>\r\n</div>\r\n<p style=\"font-size: x-small; color: #667;\">You are receiving this automatic email message because you have a subscription in <em>[SITENAME]</em>. <span style=\"line-height: 1.3em;\">Do not reply to this email, it\'s sent from an unmonitored email address.</span></p>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a style=\"color: #ccf; text-decoration: none;\" href=\"https://www.akeebabackup.com/products/admin-tools.html\">Akeeba AdminTools</a></p>',1,5,1,'hour','2014-04-14 14:36:34',800,'2014-04-14 14:42:38',800),(2,'user-reactivate','*','User deactivated on [SITENAME]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello,</p>\r\n<p>on [DATE] the user [USER] has been de-activated since he failed too many logins (recorded IP: [IP]).</p>\r\n<p>Please click on the following link to activate the user again:<br />[ACTIVATE]</p>\r\n<p>If this kind of security exception repeats itself, please log in to your site\'s back-end and add this IP address to your Admin Tools\'s Web Application Firewall feature in order to completely block the misbehaving user.</p>\r\n<p>Best regards,</p>\r\n<p>The [SITENAME] team</p>\r\n</div>\r\n<p style=\"font-size: x-small; color: #667;\">You are receiving this automatic email message because you have a subscription in <em>[SITENAME]</em>. <span style=\"line-height: 1.3em;\">Do not reply to this email, it\'s sent from an unmonitored email address.</span></p>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a style=\"color: #ccf; text-decoration: none;\" href=\"https://www.akeebabackup.com/products/admin-tools.html\">Akeeba AdminTools</a></p>',1,0,0,'','2014-04-24 14:44:49',800,'0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `nstest_admintools_waftemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ak_profiles`
--

DROP TABLE IF EXISTS `nstest_ak_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ak_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `configuration` longtext,
  `filters` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ak_profiles`
--

LOCK TABLES `nstest_ak_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_ak_profiles` DISABLE KEYS */;
INSERT INTO `nstest_ak_profiles` VALUES (1,'Default Backup Profile','###AES128###+5pX+r6mS3+m10DH5hRkswLANU7fQAKizpl0OvzTraNLLI9xQT81ZjKl/zPmMftiJhuOYvZG8ZPUhyhzaTYcN0i4R1My3W0qC2HeZS6OKnJhHzBMLgpd7r+IbNDhLR706mOf9dYndAC98ho3dYKj8sn4ydFO+VVndUP/Q4HbQRiUWqwKZs8OZAatGc3umIhRXiwhF3Gx9KyBxFucIMn7ij5gNzRhhR1hLeUk1hDyRdMBssK3B4aySmrevih02Rf0K44fkzJKfhkQsJAZuFIdQsaQZ90G9UCccT9VAwmUjc1Xx8/OjpcPLFPz3B8WRsi5IRs2NgaaqeTjtKrphfuJGJVlFAtQbX0S2jp+qKN8dWTpyb+1y6BdOSn90OynyEXDxcNrQxXeF9eD+CrF56eToz0eDOe3+8aPygpikLl4+s9FgKHJU5fE+SkwbawlfKTleY1W5nbktk0NUchBqA0tJN4QfWgBJ9Y1kx8zKqkmj0i6Bw7Agk1Mxq+GfCVK+kp2fe9VBNS88IjU5+ZEmYLsJbjEiCYeraANXHAfrwPIa/7zPjgmVF2CDIpyFZf6zrR1rrHkQjih9rzMohzgdyCnDTOHW1eqaAH9jtCztq2+lG6mN/p/Bl/ix9LTksAv2OcJYZzXMJCzWUpyNntTL/OJLpyCqymu8OLNGUgtO2RW1yFMgnsTsRSZ3MD6AC9OdpiA4pIalDMLwv2Orud8+4NOuWlq22bkJFhgKum8NrEjtevfq232w9IYqTyQP0Q/2XvHmtKC29qdgQaX7Ba5LORRSElrE76Bd7g7EMgaxldH3/Ywdbdx3yVFZzo23ER64C+2QR5NFrZXIsKyA4vqAiPlqVZxPDn2XCD13WbxFFOf91X58pk7XyTF7U/Bzj/ht2VAkwRnNwwxu2G03Z1AvfRR0dCzewY5yiqPYt8uPbkUG+YbOrHkuA+XPxHA2FRSLiJ81o1ESsHg+ZCYOud1z8I7+3u7ZrYOF+iFF4jGKKhIVj8e6oHGOkdXsL5Css68YA4UQxfFVrkOpHgZKIK2BU6pnUYp5fOxx3Y91cUos8iJHoSm/ztAyGFt/FW622rfNfe2NthgH1mMHwwxtWuZ6uLwQ2JgkOOTjaz5xJDKZ4gor6IIL0hN49BgnK7ve82sj3R4PMNVnHyXeaS3lG8gayg1zsyYxTTi6Uy+e7OF5npu58YAlL0rP6bEealrSuR2hNF/NGgVp6mGf+Ii4f1KmLMtpGuq3M9B4K4gLAN+k/9+eKPQr+qsBgWJesmGoN5LD6Qg//s2zZzzKBBleJRDo18GRPQyQruGAiSs9eWXPWxMEG99uf33vMYP3rAlc1+Tq192YUYyUtOVwM5wk2pwonrYTe4gzhhxgc9+JW+qvUO4iDUAyufOytqMIg0gWf33+LvMyxgGzc9lMekYKsQRuoGIuaCI4szCIH1ATBx89emJ5hIY7Cz74WEDyxIDtGhXY8xyA1J9aeiGZEdj2SIAauSdLTTQQboJVsD2nYK1shN9aUOi3JpKMjtNO73ExPLmBGnP17ThYGoCS/7d6LPSTeusXt+ytbnXIKAFWyMInTn73szSUkq9xcIxW4begVzx2UX6LJkcm1HQRejGN7ETww8dRQzkzZKnkMZC56JduWIWkZaMe7uXFWBo6mQxHtFOvbDEPhpWhL3Zvxm3IM5QyCqXwS6cOCO0h0Cib3DEfxk/UZfp9OXi5tF/+Gb6yxyqhrcZAtnSNp5VtZ9NymeRAyNfydiuZ4JqRD4uQbZEk1HnsnReyy9nGyhcA0rZv9sbniqGyAZrOFvXk1DZFT88JB1Ea1X9ttpcCAc81mf0qAtOJ+xI32rnyBIRp8xqrrRWsxiA2E+zfgKzHCvlxZVV/dS+787kSDc922jwxtensugFMN7aJaFx3I91BfcjOxDvrMMgA2EJ/48VJDaT7NAruiSw18sC7Cx2LB3P1eCGtLvb6nhL201q+Q5Rl6QJ3HnM2x2230lDgkY+NgmQrd9TnVqGq5kKpuhda7HLa4Nj+as2vOXhq00GaApYzSbY4dD//FFRRgn/rCEW2mJtfvGohFgLhk4K1UQO/Yvn8YlkAsH4TkF9vm8A2sMYBdzKhldDID+tFt5yGRNjw85krzbe4dn4ivB1c9aF/9Bn6FaZ6aThkeM2EWfvP3uJrfcgakLBBIyzEXwGUR5lraFViJOKKOC2iYpssZ6NonNlg5dEPu7bXrIkZ2+k6x0wrOeLcT5umw6V4cDGfoluhOVHyYRi88VWCQItFEuHhpchyxItQkG8aysKhUPlhGzoYYHBFHBD/OZ0e7lDoT7F+p7npuwOWrnloh2wl1Eag2TfexmpRbDmH7dB1sO1ZTiW23szzzX4AcXOyvPDz2N6H9ru302PzRjq1wRlYWEzygcEhtlMvfyIvDeewiJ0edBAxsQBl7fnh7Cz0pNjyX/bOV5CreNvFwQWPKfhGukjR9YVLHXZ8Hah9MEqtfMdIKXp0VnpMr1N8wuyYw40W4qydpM3p+4r1Z197Uonr7BinBJRQAs53njOza+eFo7tgjTW2sgL03aGGUnOR3yF0GkDJeDXDWXxvrdEh49S/rInkNUTRMctBp4opYY0WTAmjv5auKvyJYJo5S1pw3/lZZ9vWVztf75KCBjneZnjfVYsGwUll5C8VxK1zfdexcRuUqVGR4ulSqal9WinkQUIbfTTKYP6oT5YqU9YCH7ez8JSN9s6s7N0sqycWTJ40hVcV3KwJn850D43+VOBqZR52pikQYj/9gWseK6NV4IQjra0WnhRhnq8jWVlZrNy+MyQX2EmT8OOdbtNrME9A5b/b+8yr3oHar7KTxdPdbrxWuZoe9eNWruOM+dm1cv1OkF783/kFPSR382x/HPxIq7TTpKz+Xg4RU7kMxSaYF1YXiTe5LkJVB+NsiU2k1pWE9FIT6s6WszzH67DGfYh7O9ZktRSMkWQWTgH0XnDKt9W/fXIzNGKGayRawJpL2kDNwyUZt1qDamIdUtCXTewtnZEyPerSxYiAxGJ4DFCmXaSz/Zih1vc4uRO4N2e3QY4rHLZO1sn83B11BzIeCJQdZJgMJIalGN8ZxVNZtiM+XTVb4012fv1i3aIs82iUaH9XqTYgpgCqAEPU7lGrv6iCLme4RHT+BcbP4h4RdKxGjSZBXtpsdAyM8buExvZTZlpxYW0wUa6PzkrN4qdiLS/eDQyo4FEn/YyMOhTM4+4AxSocUEw/N8uz5xx2mOEa7/QR8k0pJVYBBk+fLvrmUELPfh6x1D1EsiFcCEDFlz5ioY98S9dq0hZC/GmOB0MxSjSq+wNSlcrJmUs/1XBk+N7VtkinboygX6BLfNp20pizlqKo+lA3gWsZ7jtLwBtPetXpx0RcBYmi+GY6j+GP1or/2K77SOC3GZwDjdZ8yYzV4EBsSXO6+0H2GI8PUVBi08Id1qFDG5ZWIq17Ea5Qssc18wd+KTInUfcduugsEkNy6Fx2uOYDXmqFBAvyVSFUBKmBCTX7RDvVL7V+UctAXOTzxg4JkLUzplnq3DYSqX5oXvZsTn61SnFHaHNTaISTIpC3vD0OmFiQmsCSAbAHFRVw+bJOBZTDOcMDvtWR/V4vuBSGPfcIcgWQbqin6SUoOmDWnoUEHdzGBxVIKDTQhZW6Zi7MDp74qaW8aZtFT4g3nLgn0gIExP6iZKxmbBq06T6zyl9XQE4FnDSZuR6RAWh5n9nZRkE3A8qderkgCjL6U4DkAWPfFjdrpFtmTNRoSW1XCpWCLygZBicT10K5ul0J/jnQCceI+La67GZxJySYVV36RwJ2UEMeeHfOWc0m4E5Vl/J1RsqMn4ZlT/58JrirjCpF7JsXXmk0rfTGGD4Btc3EuqhrZet86FcpjTRyMR5Cul4PoTgMJ3AT5m0fs3mHdgY453xWpwuNHUSDkLgKXyrX3FAWnodt+Pnx/lnrSoq3lVzrS9NkzGyjCtvu67IKX7isqEdedqGTSEKjfGf8BW8LORdYB6MylvIKAMIx6Jv8RXAuVd4DtAZYYupDA/+pX28owXdeTPbhSDrGogzY81yoiPGzrU1NwsSTs937PnXG0MzVPtB0GWAnO4uF7qbvJNvn9wfgxYgmgWZ0azDx8ddcSBe3QZUJqJF26p0jUd2BFci6Kw+wZVC2Ejd13/2ANXK6p5ToGUCL5bQgODpMXxSOZ+LTN2vtJNYQTYUowpgm6nFhSDqWK3Ev8uqP06tKzsJskffMnX9Fc6pjj8HvHsJaCIC9NLEOyeOo/4ZWA5Uev8uPF9gN6mO15CsrIHkVZyeyYYnatLdCI5nX9362vmtHsirZYP+yTGOTDty4TAiu+7VVK2lWHZrq3/fZ7MgUHHZAZwmY0VFHHlmpUqVp0znkghonJkYAXnjS1w2eg3PoOldLyqpqEQIiJTmTsxMWIa8T1euADbG/80LJ3quRglmo6Burv+Ppn7BU70dSBLPCNydfVQOWi9fjInLRzSjUiaBhjJlhpvA/AA4YWH0jekxu0VbfgQohLkidXgOjaI7DcT9Xv1XFXjL8JCndm1voc5UjyxX6UNm8ct+NpHzUdgru9c015OGYkCHU/7JxbOyUeZvpISU2wp4kWzuQ+kxANbpJ8iI6hkSTBKrYx33E0JKwyWC2zy11qHemPePtsUeVWfdlgmln0fjE0ZL3gsCHMzKovj/DAD/Jb9QzmvrPLSFtKFFO7FWI5YOXX1k9dIYil3BH4Bf6rNuYNwxIVaXHO9xR/TbPhMkLHl0e4mxohfsBVPuPFRoP65wQXCsVIdlNaN8Oap9HzRDRmT8UcF7mUgcuH+KDj1ByEerMTaAHGHn8k7od+eub3+4HtvRHyYbch8iPTfRyBpAA8yxwsoc0d+oMicHBUPBniHKOGqLuBwdHPM8jpdhnkD0jGpUdDGs5Rcr38/KALjopDdCyStj17BOmEq0UEUoZF8/dKRVLuw1WBdKQv5pKxX/ytbIQoOwpa4ohENG2hm8jx2pyBScDvhRTCOzQU6v67DiiQ+Hw2qChJzgjXCKGUXrAZ7ccadpp1uqV8ItVEJyuBZruxS4kj4CF5RbOI2GE1X83Ty2tIDXSHVdd/2TLrudX/XLbdp4JFe/LbAUJRUT44XMkn2sHv8loAn2OxqEFOjU07dVAeavf0bpL2HEQczSXDkxvhPVELPENnsNUcpBj+8nthObrEiqJFBg+0v66tV06U03zDUYeCciEAumXz1FBo/ct2nbVf1f7aO69l8LehKuNWjC8UVVXVVXcMasMf8zU3TDG/B7V4aMnVjvUzXPwMlunIzkTG19pbh8bFpOpPAdfwKcFYrraH+gvNvorl/pyrZn4xAVxWcbyx0Y07DTEIEF6zCpvvAGqQbWK9M5LQTgTEuklN9q8PpP5+dJs61Lr41wLNzsqXJXl+EkyG05yTHAKcKXBjvYjg4Bgw+i5Mb7JMv6MOLhl8tJpapXd/B6arvHYPvO1nh5uBhTZyfeTSaE+JtuOvmEPxFgLoj6Oj0W4qnpK2um4KUjObzXPF0VFEgBySLZqttlMEw7YUeMDrET4Eptpu2APc2IjdbQCJVp/9/3AgaB7piRPtCfvw586dGxTf+ufMGQcT6grPa3tGWnZ91NhK5divlwd0TB7JtLbBDmM0Ht8v0TRNL7n0iX1wA9xGHVITjRZfNrpVldJo8RhtCfD82yT8oeMW+8emb/YRVSZTyW4hzK8tPWgaQQitVx4MQ0Ut10b/nBOmBUtB5tJXvb0W5SzMTlJrMzizeQY+GQaAgUEi6R8lSXKRQ1SB7WxRSNlvhGTI0pDDSpWEFqSAKM3jKQsn7zL+JdXFIyP9/lQ4FjERhWlGRi+xWA+FM76sMihZBgboA8aF0C2MMdGExSpk2d2MNfKSvsc59dig6CSW7w45zG3WwjNt67jeW3fMBmYo2bz3gII0klBBdRVgkdh22V1Z8RA96JAYOSgGDdrn3l4/pWMCQMYBaexEiBWasDilSWqAVf4YXQS+aveHccKPUSH2CVD7ZBuih5KSx+727mDzUFFhicPBWim/mVInKxzB9mNEcEtmr5L4fkmYaUc1VQJyvFQTV3MmYrPWQLrdypUBkwgewM0gsJnX4mUN4RAAA=','');
/*!40000 ALTER TABLE `nstest_ak_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ak_stats`
--

DROP TABLE IF EXISTS `nstest_ak_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ak_stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `comment` longtext,
  `backupstart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backupend` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('run','fail','complete') NOT NULL DEFAULT 'run',
  `origin` varchar(30) NOT NULL DEFAULT 'backend',
  `type` varchar(30) NOT NULL DEFAULT 'full',
  `profile_id` bigint(20) NOT NULL DEFAULT '1',
  `archivename` longtext,
  `absolute_path` longtext,
  `multipart` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `filesexist` tinyint(3) NOT NULL DEFAULT '1',
  `remote_filename` varchar(1000) DEFAULT NULL,
  `total_size` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fullstatus` (`filesexist`,`status`),
  KEY `idx_stale` (`status`,`origin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ak_stats`
--

LOCK TABLES `nstest_ak_stats` WRITE;
/*!40000 ALTER TABLE `nstest_ak_stats` DISABLE KEYS */;
INSERT INTO `nstest_ak_stats` VALUES (2,'System Restore Point - component: com_akeeba','---BEGIN SRP---\n{\"type\":\"component\",\"name\":\"akeeba\",\"group\":\"\",\"version\":\"3.11.0\",\"date\":\"2014-05-06\"}\n---END SRP---','2014-05-28 17:48:20','0000-00-00 00:00:00','fail','restorepoint','full',1,'restore-point-20140528-144820.jpa','C:/xampp/htdocs/joomla32/administrator/components/com_akeeba/backup/restore-point-20140528-144820.jpa',0,'restorepoint',1,'',27),(3,'System Restore Point - component: com_akeeba','---BEGIN SRP---\n{\"type\":\"component\",\"name\":\"akeeba\",\"group\":\"\",\"version\":\"3.11.0\",\"date\":\"2014-05-06\"}\n---END SRP---','2014-05-28 18:08:26','2014-05-28 18:09:00','complete','restorepoint','full',1,'restore-point-20140528-150826.jpa','C:/xampp/htdocs/joomla32/administrator/components/com_akeeba/backup/restore-point-20140528-150826.jpa',1,'restorepoint',1,NULL,2310856);
/*!40000 ALTER TABLE `nstest_ak_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ak_storage`
--

DROP TABLE IF EXISTS `nstest_ak_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ak_storage` (
  `tag` varchar(255) NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` longtext,
  PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ak_storage`
--

LOCK TABLES `nstest_ak_storage` WRITE;
/*!40000 ALTER TABLE `nstest_ak_storage` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ak_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_articlegenerator`
--

DROP TABLE IF EXISTS `nstest_articlegenerator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_articlegenerator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `feed_url` text COLLATE utf8_unicode_ci NOT NULL,
  `extractfulltext` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `catid` int(11) NOT NULL,
  `validfor` int(11) unsigned NOT NULL DEFAULT '0',
  `insertadvert` tinyint(4) NOT NULL DEFAULT '1',
  `advert` text COLLATE utf8_unicode_ci NOT NULL,
  `autopublish` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `frontpage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `delay` tinyint(4) NOT NULL DEFAULT '10',
  `fulltext` int(11) unsigned NOT NULL DEFAULT '1',
  `feedlinksintro` int(11) unsigned NOT NULL DEFAULT '0',
  `feedlinksfull` int(11) unsigned NOT NULL DEFAULT '0',
  `feedimageintro` int(11) unsigned NOT NULL DEFAULT '0',
  `feedimagefull` int(11) unsigned NOT NULL DEFAULT '0',
  `posterid` int(11) NOT NULL,
  `origdate` tinyint(1) NOT NULL DEFAULT '0',
  `jceboxlinks` tinyint(1) NOT NULL DEFAULT '1',
  `jceparams` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `negkey` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createddate` tinyint(1) NOT NULL DEFAULT '0',
  `cutat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `showintro` tinyint(1) NOT NULL DEFAULT '1',
  `switchintrofull` tinyint(1) NOT NULL DEFAULT '0',
  `origauthor` tinyint(1) NOT NULL DEFAULT '0',
  `includelink` tinyint(4) NOT NULL DEFAULT '1',
  `readfullarticle` text COLLATE utf8_unicode_ci NOT NULL,
  `dupavoid` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '3',
  `useiconv` tinyint(4) NOT NULL DEFAULT '1',
  `acgroup` int(11) NOT NULL DEFAULT '1',
  `ordering` tinyint(3) NOT NULL,
  `cutatcharacter` int(11) NOT NULL,
  `ignoreitem` int(11) NOT NULL DEFAULT '0',
  `minimum_count` int(11) NOT NULL,
  `allowabletags` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all',
  `articleintrostyle` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[intro]',
  `articlefullstyle` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[full]',
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Feeds and data for ArticleGenerator';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_articlegenerator`
--

LOCK TABLES `nstest_articlegenerator` WRITE;
/*!40000 ALTER TABLE `nstest_articlegenerator` DISABLE KEYS */;
INSERT INTO `nstest_articlegenerator` VALUES (1,'CNN',0,'http://rss.cnn.com/rss/cnn_topstories.rss',0,'2014-05-28 19:04:53','',0,'0000-00-00 00:00:00',9,0,1,'',1,1,10,1,0,0,0,0,0,0,1,'','','','',0,'',1,0,0,1,'','3',1,1,1,0,0,0,'all','[intro]','[full]','*'),(5,'Evangelio del Día',1,'http://evangeliodeldia.org/rss/v2/evangelizo_rss-sp.xml',0,'2014-05-28 19:10:16','',0,'0000-00-00 00:00:00',13,0,1,'{loadposition user99}',1,0,10,1,0,0,0,0,868,0,1,'','','Chelo','Selvat1974',0,'',1,0,0,1,'Read full article on','3',1,2,2,0,0,0,'all','<p>[intro]</p>','<p>[full]</p>','*');
/*!40000 ALTER TABLE `nstest_articlegenerator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_articlegenerator_config`
--

DROP TABLE IF EXISTS `nstest_articlegenerator_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_articlegenerator_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `getwith` tinyint(4) NOT NULL DEFAULT '1',
  `credit` tinyint(4) NOT NULL DEFAULT '1',
  `countkeys` tinyint(4) NOT NULL DEFAULT '20',
  `minLengthkeys` tinyint(4) NOT NULL DEFAULT '3',
  `usetitle` int(11) unsigned NOT NULL DEFAULT '0',
  `blackListkeys` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ArticleGenerator options';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_articlegenerator_config`
--

LOCK TABLES `nstest_articlegenerator_config` WRITE;
/*!40000 ALTER TABLE `nstest_articlegenerator_config` DISABLE KEYS */;
INSERT INTO `nstest_articlegenerator_config` VALUES (1,1,1,20,3,0,'ab, aber');
/*!40000 ALTER TABLE `nstest_articlegenerator_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_assets`
--

DROP TABLE IF EXISTS `nstest_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_assets`
--

LOCK TABLES `nstest_assets` WRITE;
/*!40000 ALTER TABLE `nstest_assets` DISABLE KEYS */;
INSERT INTO `nstest_assets` VALUES (1,0,0,235,0,'root.1','Root Asset','{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.login.offline\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(2,1,1,2,1,'com_admin','com_admin','{}'),(3,1,3,6,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(4,1,7,8,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(5,1,9,10,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(6,1,11,12,1,'com_config','com_config','{}'),(7,1,13,18,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(8,1,19,48,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(9,1,49,50,1,'com_cpanel','com_cpanel','{}'),(10,1,51,52,1,'com_installer','com_installer','{\"core.admin\":[],\"core.manage\":{\"7\":0},\"core.delete\":{\"7\":0},\"core.edit.state\":{\"7\":0}}'),(11,1,53,54,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(12,1,55,56,1,'com_login','com_login','{}'),(13,1,57,58,1,'com_mailto','com_mailto','{}'),(14,1,59,60,1,'com_massmail','com_massmail','{}'),(15,1,61,62,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1}}'),(16,1,63,64,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(17,1,65,66,1,'com_messages','com_messages','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(18,1,67,164,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(19,1,165,168,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(20,1,169,170,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(21,1,171,172,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1},\"core.manage\":[]}'),(22,1,173,174,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(23,1,175,176,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(24,1,177,180,1,'com_users','com_users','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(25,1,181,184,1,'com_weblinks','com_weblinks','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(26,1,185,186,1,'com_wrapper','com_wrapper','{}'),(27,8,20,21,2,'com_content.category.2','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(28,3,4,5,2,'com_banners.category.3','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(29,7,14,15,2,'com_contact.category.4','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(30,19,166,167,2,'com_newsfeeds.category.5','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(31,25,182,183,2,'com_weblinks.category.6','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(32,24,178,179,1,'com_users.category.7','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(33,1,187,188,1,'com_finder','com_finder','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(34,1,189,190,1,'com_joomlaupdate','com_joomlaupdate','{\"core.admin\":[],\"core.manage\":[],\"core.delete\":[],\"core.edit.state\":[]}'),(35,1,191,192,1,'com_tags','com_tags','{\"core.admin\":[],\"core.manage\":[],\"core.manage\":[],\"core.delete\":[],\"core.edit.state\":[]}'),(36,1,193,194,1,'com_contenthistory','com_contenthistory','{}'),(37,1,195,196,1,'com_ajax','com_ajax','{}'),(38,1,197,198,1,'com_postinstall','com_postinstall','{}'),(39,18,68,69,2,'com_modules.module.1','Main Menu','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(40,18,70,71,2,'com_modules.module.2','Login','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(41,18,72,73,2,'com_modules.module.3','Popular Articles','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(42,18,74,75,2,'com_modules.module.4','Recently Added Articles','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(43,18,76,77,2,'com_modules.module.8','Toolbar','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(44,18,78,79,2,'com_modules.module.9','Quick Icons','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(45,18,80,81,2,'com_modules.module.10','Logged-in Users','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(46,18,82,83,2,'com_modules.module.12','Admin Menu','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(47,18,84,85,2,'com_modules.module.13','Admin Submenu','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(48,18,86,87,2,'com_modules.module.14','User Status','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(49,18,88,89,2,'com_modules.module.15','Title','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(50,18,90,91,2,'com_modules.module.16','Identificación','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(51,18,92,93,2,'com_modules.module.17','Breadcrumbs','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(52,18,94,95,2,'com_modules.module.79','Multilanguage status','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(53,18,96,97,2,'com_modules.module.86','Joomla Version','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(54,1,199,200,1,'com_gantry','gantry','{}'),(55,18,98,99,2,'com_modules.module.87','RokWeather',''),(56,8,22,31,2,'com_content.category.8','Contenido Institucional','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(57,7,16,17,2,'com_contact.category.9','Institutional Contacts','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(58,56,23,24,3,'com_content.article.1','Contact Information','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(59,56,25,26,3,'com_content.article.2','Product & Services','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(60,56,27,28,3,'com_content.article.3','Industry Expertise','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(61,56,29,30,3,'com_content.article.4','About Us','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(62,18,100,101,2,'com_modules.module.88','RokStock',''),(63,18,102,103,2,'com_modules.module.89','Eventos','{\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(64,1,201,202,1,'com_rokgallery','rokgallery','{}'),(65,18,104,105,2,'com_modules.module.90','DPCalendar Upcoming',''),(66,1,203,204,1,'com_easydiscuss','com_easydiscuss','{}'),(67,1,205,206,1,'com_easyblog','com_easyblog','{}'),(68,18,106,107,2,'com_modules.module.91','DPCalendar Counter',''),(69,18,108,109,2,'com_modules.module.92','DPCalendar Mini',''),(70,1,207,210,1,'com_dpcalendar','com_dpcalendar','{}'),(71,70,208,209,2,'com_dpcalendar.category.10','Uncategorised',''),(72,1,211,212,1,'com_kunena','com_kunena','{}'),(73,1,213,214,1,'com_community','community','{}'),(74,18,110,111,2,'com_modules.module.93','Community - Active Groups',''),(75,18,112,113,2,'com_modules.module.94','Community - Activity Stream',''),(76,18,114,115,2,'com_modules.module.95','Community - Events Module',''),(77,18,116,117,2,'com_modules.module.96','Community - Groups Module',''),(78,18,118,119,2,'com_modules.module.97','Community - Members Module',''),(79,18,120,121,2,'com_modules.module.98','Community - Photos Module',''),(80,18,122,123,2,'com_modules.module.99','Community - Quick Search Module',''),(81,18,124,125,2,'com_modules.module.100','Community - Videos Module',''),(82,18,126,127,2,'com_modules.module.101','Community - Whos Online',''),(83,18,128,129,2,'com_modules.module.102','Community - Dating Search',''),(84,18,130,131,2,'com_modules.module.103','Community - Hello Me',''),(85,18,132,133,2,'com_modules.module.104','Community - JomSocial Connect',''),(86,18,134,135,2,'com_modules.module.105','Community - Latest Discussion',''),(87,18,136,137,2,'com_modules.module.106','Community - Latest group posts',''),(88,18,138,139,2,'com_modules.module.107','Community - Jomsocial Notification',''),(89,18,140,141,2,'com_modules.module.108','Community - Photo Comments',''),(90,18,142,143,2,'com_modules.module.109','Community - JomSocial Statistics',''),(91,18,144,145,2,'com_modules.module.110','Community - Top Members',''),(92,18,146,147,2,'com_modules.module.111','Community - Video Comments',''),(93,1,215,216,1,'com_ijoomlainstaller','com_ijoomlainstaller','{}'),(94,1,217,218,1,'com_oziogallery3','com_oziogallery3','{}'),(95,8,32,33,2,'com_content.category.11','Noticias de Eventos Internos','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(96,8,34,35,2,'com_content.category.12','Noticias de Viajes','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(97,8,36,37,2,'com_content.category.13','Evangelio del Día','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(98,8,38,43,2,'com_content.category.14','Documentación Interna','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(99,98,39,40,3,'com_content.category.15','Reglamento Interno Aymara','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(100,98,41,42,3,'com_content.category.16','Notificaciones','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(101,8,44,47,2,'com_content.category.17','Banner Principal','{\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(102,1,219,220,1,'com_phocadownload','com_phocadownload','{}'),(103,1,221,222,1,'com_admintools','admintools','{\"core.admin\":[],\"core.manage\":[],\"admintools.utils\":[],\"admintools.security\":[],\"admintools.maintenance\":[]}'),(104,1,223,224,1,'com_akeeba','akeeba','{\"core.admin\":[],\"core.manage\":[],\"akeeba.backup\":[],\"akeeba.configure\":[],\"akeeba.download\":[]}'),(105,1,225,230,1,'com_ats','com_ats','{\"core.admin\":[],\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.own\":[],\"core.edit.state\":[],\"ats.private\":[],\"ats.attachment\":[]}'),(106,18,148,149,2,'com_modules.module.112','Akeeba Ticket System - Credits info',''),(107,1,231,232,1,'com_jce','jce','{}'),(108,1,233,234,1,'com_articlegenerator','com_articlegenerator','{}'),(109,18,150,151,2,'com_modules.module.114','Evangelio del Día','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(110,101,45,46,3,'com_content.article.5','Intranet Publicada','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(112,18,152,153,2,'com_modules.module.115','RokSprocket Module',''),(113,18,154,155,2,'com_modules.module.116','Banner Principal',''),(114,105,226,227,2,'com_ats.category.18','Preguntas Sobre Receptivo','{\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"ats.private\":[],\"ats.attachment\":[]}'),(115,105,228,229,2,'com_ats.category.19','Preguntas sobre Viajes de Egresados','{\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"ats.private\":[],\"ats.attachment\":[]}'),(117,18,156,157,2,'com_modules.module.117','RokSprocket Module',''),(118,18,158,159,2,'com_modules.module.118','Banner Principal',''),(119,18,160,161,2,'com_modules.module.119','Vinaora Nivo Slider',''),(120,18,162,163,2,'com_modules.module.120','Banner principal','{\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}');
/*!40000 ALTER TABLE `nstest_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_associations`
--

DROP TABLE IF EXISTS `nstest_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_associations` (
  `id` int(11) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_associations`
--

LOCK TABLES `nstest_associations` WRITE;
/*!40000 ALTER TABLE `nstest_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_attachments`
--

DROP TABLE IF EXISTS `nstest_ats_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_attachments` (
  `ats_attachment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ats_post_id` int(11) NOT NULL,
  `original_filename` varchar(1024) NOT NULL,
  `mangled_filename` varchar(1024) NOT NULL,
  `mime_type` varchar(255) NOT NULL DEFAULT 'application/octet-stream',
  `origin` varchar(20) DEFAULT 'web',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ats_attachment_id`),
  KEY `ats_post_id` (`ats_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_attachments`
--

LOCK TABLES `nstest_ats_attachments` WRITE;
/*!40000 ALTER TABLE `nstest_ats_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_attempts`
--

DROP TABLE IF EXISTS `nstest_ats_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_attempts` (
  `ats_attempt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ats_category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ats_ticket_id` int(11) NOT NULL,
  `ticket_clicks` int(11) NOT NULL,
  `docimport_clicks` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`ats_attempt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_attempts`
--

LOCK TABLES `nstest_ats_attempts` WRITE;
/*!40000 ALTER TABLE `nstest_ats_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_autoreplies`
--

DROP TABLE IF EXISTS `nstest_ats_autoreplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_autoreplies` (
  `ats_autoreply_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `reply` text NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `run_after_manager` tinyint(1) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `min_after` int(11) NOT NULL,
  `attachment` tinyint(4) NOT NULL,
  `keywords_title` text NOT NULL,
  `keywords_text` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`ats_autoreply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_autoreplies`
--

LOCK TABLES `nstest_ats_autoreplies` WRITE;
/*!40000 ALTER TABLE `nstest_ats_autoreplies` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_autoreplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_buckets`
--

DROP TABLE IF EXISTS `nstest_ats_buckets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_buckets` (
  `ats_bucket_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` enum('O','P','C','1','2','3','4','5','6','7','8','9') NOT NULL DEFAULT 'O',
  `title` varchar(1024) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ats_bucket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_buckets`
--

LOCK TABLES `nstest_ats_buckets` WRITE;
/*!40000 ALTER TABLE `nstest_ats_buckets` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_buckets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_cannedreplies`
--

DROP TABLE IF EXISTS `nstest_ats_cannedreplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_cannedreplies` (
  `ats_cannedreply_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `reply` text NOT NULL,
  `ordering` bigint(20) unsigned NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ats_cannedreply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_cannedreplies`
--

LOCK TABLES `nstest_ats_cannedreplies` WRITE;
/*!40000 ALTER TABLE `nstest_ats_cannedreplies` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_cannedreplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_creditconsumptions`
--

DROP TABLE IF EXISTS `nstest_ats_creditconsumptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_creditconsumptions` (
  `ats_creditconsumption_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ats_credittransaction_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `type` enum('ticket','post') NOT NULL DEFAULT 'ticket',
  `ats_ticket_id` bigint(20) NOT NULL,
  `ats_post_id` bigint(20) NOT NULL,
  PRIMARY KEY (`ats_creditconsumption_id`),
  KEY `nstest_ats_creditconsumptions_transaction` (`ats_credittransaction_id`),
  KEY `nstest_ats_creditconsumptions_userid` (`user_id`),
  KEY `nstest_ats_creditconsumptions_ticketpost` (`type`,`ats_ticket_id`,`ats_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_creditconsumptions`
--

LOCK TABLES `nstest_ats_creditconsumptions` WRITE;
/*!40000 ALTER TABLE `nstest_ats_creditconsumptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_creditconsumptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_credittransactions`
--

DROP TABLE IF EXISTS `nstest_ats_credittransactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_credittransactions` (
  `ats_credittransaction_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `transaction_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(70) NOT NULL DEFAULT 'ats',
  `unique_id` varchar(180) NOT NULL DEFAULT '',
  `value` int(11) NOT NULL DEFAULT '10',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ats_credittransaction_id`),
  KEY `nstest_ats_creditstransactions_userid` (`user_id`),
  KEY `nstest_ats_creditstransactions_foreignids` (`type`,`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_credittransactions`
--

LOCK TABLES `nstest_ats_credittransactions` WRITE;
/*!40000 ALTER TABLE `nstest_ats_credittransactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_credittransactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_customfields`
--

DROP TABLE IF EXISTS `nstest_ats_customfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_customfields` (
  `ats_customfield_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `show` enum('all','category') NOT NULL DEFAULT 'all',
  `type` varchar(100) NOT NULL DEFAULT 'text',
  `options` mediumtext,
  `default` varchar(255) DEFAULT '',
  `allow_empty` tinyint(3) NOT NULL DEFAULT '0',
  `valid_label` varchar(255) DEFAULT '',
  `invalid_label` varchar(255) DEFAULT '',
  `params` mediumtext,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `ordering` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ats_customfield_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_customfields`
--

LOCK TABLES `nstest_ats_customfields` WRITE;
/*!40000 ALTER TABLE `nstest_ats_customfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_customfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_customfields_cats`
--

DROP TABLE IF EXISTS `nstest_ats_customfields_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_customfields_cats` (
  `ats_customfield_id` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  PRIMARY KEY (`ats_customfield_id`,`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_customfields_cats`
--

LOCK TABLES `nstest_ats_customfields_cats` WRITE;
/*!40000 ALTER TABLE `nstest_ats_customfields_cats` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_customfields_cats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_emailtemplates`
--

DROP TABLE IF EXISTS `nstest_ats_emailtemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_emailtemplates` (
  `ats_emailtemplate_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT 'manager',
  `language` varchar(10) NOT NULL DEFAULT '*',
  `subject` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ats_emailtemplate_id`),
  UNIQUE KEY `ats_emailtemplate_keylang` (`key`,`language`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_emailtemplates`
--

LOCK TABLES `nstest_ats_emailtemplates` WRITE;
/*!40000 ALTER TABLE `nstest_ats_emailtemplates` DISABLE KEYS */;
INSERT INTO `nstest_ats_emailtemplates` VALUES (1,'manager-public-new','en-GB','New public ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new <strong>public</strong> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" has been created by [POSTER_NAME] ([POSTER_USERNAME]) with the following contents:</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you are a manager of the \"[CATNAME]\" category in <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,'manager-private-new','en-GB','New private ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new <em><strong>private</strong></em> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" has been created by [POSTER_NAME] ([POSTER_USERNAME]) with the following contents:</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you are a manager of the \"[CATNAME]\" category in <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,'manager-public-old','en-GB','Reply to public ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new message was posted in the <strong>public</strong> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" by [POSTER_NAME] ([POSTER_USERNAME]):</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you are a manager of the \"[CATNAME]\" category in <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,'manager-private-old','en-GB','Reply to private ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new message was posted in the <em><strong>private</strong></em> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" by [POSTER_NAME] ([POSTER_USERNAME]):</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you are a manager of the \"[CATNAME]\" category in <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,'owner-public-new','en-GB','Your new public ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>You have submitted a new <strong>public</strong> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" with the following contents:</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you submitted the ticket #[ID] in the \"[CATNAME]\" category on <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(6,'owner-private-new','en-GB','Your new private ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>You have submitted a new <strong>private</strong> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" with the following contents:</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you submitted the ticket #[ID] in the \"[CATNAME]\" category on <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,'owner-public-old','en-GB','Reply to your public ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new message was posted in your <strong>public</strong> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" by [POSTER_NAME] ([POSTER_USERNAME]):</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you submitted the ticket #[ID] in the \"[CATNAME]\" category on <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(8,'owner-private-old','en-GB','Reply to your private ticket #[ID] [TITLE] [[CATNAME]]','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new message was posted in your <em><strong>private</strong></em> ticket #<strong>[ID]</strong> &mdash; \"<em>[TITLE]</em>\" by [POSTER_NAME] ([POSTER_USERNAME]):</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you submitted the ticket #[ID] in the \"[CATNAME]\" category on <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,'mailgateway-invaliduser','en-GB','Sorry, you do not seem to be a user of our site','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello,</p>\r\n<p>You tried sending us an email to an email address used by our users to submit support tickets. Unfortunately, you are not a user of our site yet. As a result your email was automatically deleted and you shall not receive any reply.</p>\r\n<p>If you are a user of our site, please make sure that you are sending the email from the email address associated with your user account. There is no way to allow you to use multiple email addresses per user account or otherwise authenticate you.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,'mailgateway-noaccess','en-GB','You are not allowed to create a ticket','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>You tried sending us an email to an email address used by our users to submit support tickets. Unfortunately, you are not allowed to post new tickets by email.</p>\r\n<p>If you believe you are receiving this message in error, please visit our site for further information. Please do not reply to this email. It is sent from the same address which generated this error notice. If you try replying to it you will receive the same automated reply.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,'mailgateway-nonewtickets','en-GB','New ticket creation is temporarily suspended','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>We have temporarily suspended the new tickets creation feature on our site. Please visit our site for more information.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,'mailgateway-nonewreplies','en-GB','Reply to tickets is temporarily suspended','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>We have temporarily suspended the ticket reply feature on our site. Please visit our site for more information.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,'mailgateway-newticketfailed','en-GB','New ticket creation failed','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>Oops! Something went wrong trying to create your new ticket. It\'s probably not your fault. Please visit our site and try posting your ticket there.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,'mailgateway-newpostfailed','en-GB','New post creation failed','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>Oops! Something went wrong trying to create your post. It\'s probably not your fault. Please visit our site and try posting your ticket or ticket reply there.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,'mailgateway-newticketdisabled','en-GB','New ticket creation by email is not allowed','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>We do not accept the creation of new tickets via email. Please visit our site and submit your ticket there.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(16,'mailgateway-newreplydisabled','en-GB','Reply by email is not allowed','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>We do not accept replies to tickets via email. Please visit our site and submit your ticket there.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(17,'mailgateway-noreplyline','en-GB','Your ticket reply is missing some necessary information','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>You seem to be trying to reply to a ticket, but we are not sure which ticket is that. You have to include the \"Please reply above this line\" line in your email and place your reply text above it. Alternatively, make sure your email application or your webmail client retain custom email headers. If your system administrator asks you which header you want to retain in your reply, it\'s the X-ATS-ticketid header.</p>\r\n<p>You can try replying by email again, making sure the reply line is present in your email and not altered in any way. Alternatively you can always visit our site and submit your ticket reply there.</p>\r\n<p>We sincerely apologise for the inconvenience.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(18,'mailgateway-nocredits-ticket','en-GB','You do not have enough credits to post a new ticket','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>You tried creating a new ticket but you do not have enough credits. Your ticket has <em>not</em> been created. Creating a new ticket requires [CREDITS_REQUIRED] credits. You have [CREDITS_LEFT] credit(s) in your account.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(19,'mailgateway-nocredits-post','en-GB','You do not have enough credits to post a reply','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [NAME],</p>\r\n<p>You tried replying to a ticket but you do not have enough credits. Your reply has <em>not</em> been registered. Replying to the ticket requires [CREDITS_REQUIRED] credits. You have [CREDITS_LEFT] credit(s) in your account.</p>\r\n<hr />\r\n<p><a href=\"[SITEURL]\" style=\"font-weight: bold;\">Visit \"[SITENAME]\"</a></p>\r\n</div>\r\n</div>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(20,'manager-assignedticket','en-GB','New assigned ticket: #[ID] [TITLE] ([CATNAME])','<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [USER_NAME],</p>\r\n<p>A new ticket #<strong>[ID]</strong> — \"<em>[TITLE]</em>\" has been assigned to you.</p>\r\n<hr />\r\n<div style=\"background-color: #fff; margin: 5px 10px; padding: 3px 6px; border-radius: 5px; border: thin solid gray;\">[TEXT]</div>\r\n<span style=\"font-size: small;\">[ATTACHMENT]</span><hr />\r\n<p><a href=\"[URL]\" style=\"font-weight: bold;\">View and reply on [SITENAME]</a></p>\r\n</div>\r\n</div>\r\n<p style=\"font-size: x-small; color: #999;\">You are receiving this email message because you are a manager of the \"[CATNAME]\" category in <em>[SITENAME]</em>.</p>\r\n<p style=\"text-align: right; font-size: 7pt; color: #ccc;\">Powered by <a href=\"https://www.akeebabackup.com/products/ats.html\" style=\"color: #ccf; text-decoration: none;\">Akeeba Ticket System</a></p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `nstest_ats_emailtemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_managernotes`
--

DROP TABLE IF EXISTS `nstest_ats_managernotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_managernotes` (
  `ats_managernote_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ats_ticket_id` bigint(20) unsigned NOT NULL,
  `note` text NOT NULL,
  `note_html` longtext,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ats_managernote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_managernotes`
--

LOCK TABLES `nstest_ats_managernotes` WRITE;
/*!40000 ALTER TABLE `nstest_ats_managernotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_managernotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_offlineschedules`
--

DROP TABLE IF EXISTS `nstest_ats_offlineschedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_offlineschedules` (
  `ats_offlineschedule_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `timestart` time NOT NULL DEFAULT '00:00:00',
  `timeend` time NOT NULL DEFAULT '00:00:00',
  `weekdays` varchar(255) NOT NULL DEFAULT '*',
  `days` varchar(255) NOT NULL DEFAULT '*',
  `months` varchar(255) NOT NULL DEFAULT '*',
  `years` varchar(255) NOT NULL DEFAULT '*',
  `notickets` tinyint(3) NOT NULL DEFAULT '1',
  `noreplies` tinyint(3) NOT NULL DEFAULT '1',
  `ordering` bigint(20) unsigned NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ats_offlineschedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_offlineschedules`
--

LOCK TABLES `nstest_ats_offlineschedules` WRITE;
/*!40000 ALTER TABLE `nstest_ats_offlineschedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_offlineschedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_posts`
--

DROP TABLE IF EXISTS `nstest_ats_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_posts` (
  `ats_post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ats_attachment_id` varchar(512) NOT NULL DEFAULT '0',
  `ats_ticket_id` bigint(20) NOT NULL,
  `content` longtext NOT NULL,
  `content_html` longtext NOT NULL,
  `origin` varchar(20) DEFAULT 'web',
  `timespent` float NOT NULL DEFAULT '0',
  `email_uid` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ats_post_id`),
  KEY `ats_posts_email_uid` (`email_uid`),
  FULLTEXT KEY `content_html` (`content_html`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_posts`
--

LOCK TABLES `nstest_ats_posts` WRITE;
/*!40000 ALTER TABLE `nstest_ats_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_tickets`
--

DROP TABLE IF EXISTS `nstest_ats_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_tickets` (
  `ats_ticket_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `catid` bigint(20) NOT NULL,
  `status` enum('O','P','C','1','2','3','4','5','6','7','8','9') NOT NULL DEFAULT 'O',
  `rating` tinyint(4) NOT NULL DEFAULT '0',
  `ats_bucket_id` bigint(20) DEFAULT NULL,
  `title` varchar(1024) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `public` tinyint(3) NOT NULL DEFAULT '1',
  `priority` tinyint(4) NOT NULL,
  `origin` varchar(10) NOT NULL DEFAULT 'web',
  `assigned_to` bigint(20) NOT NULL DEFAULT '0',
  `timespent` float NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `params` text,
  PRIMARY KEY (`ats_ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_tickets`
--

LOCK TABLES `nstest_ats_tickets` WRITE;
/*!40000 ALTER TABLE `nstest_ats_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ats_usertags`
--

DROP TABLE IF EXISTS `nstest_ats_usertags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ats_usertags` (
  `ats_usertag_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`ats_usertag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ats_usertags`
--

LOCK TABLES `nstest_ats_usertags` WRITE;
/*!40000 ALTER TABLE `nstest_ats_usertags` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ats_usertags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_banner_clients`
--

DROP TABLE IF EXISTS `nstest_banner_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_banner_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_banner_clients`
--

LOCK TABLES `nstest_banner_clients` WRITE;
/*!40000 ALTER TABLE `nstest_banner_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_banner_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_banner_tracks`
--

DROP TABLE IF EXISTS `nstest_banner_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_banner_tracks`
--

LOCK TABLES `nstest_banner_tracks` WRITE;
/*!40000 ALTER TABLE `nstest_banner_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_banner_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_banners`
--

DROP TABLE IF EXISTS `nstest_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_banners`
--

LOCK TABLES `nstest_banners` WRITE;
/*!40000 ALTER TABLE `nstest_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_categories`
--

DROP TABLE IF EXISTS `nstest_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_categories`
--

LOCK TABLES `nstest_categories` WRITE;
/*!40000 ALTER TABLE `nstest_categories` DISABLE KEYS */;
INSERT INTO `nstest_categories` VALUES (1,0,0,0,37,0,'','system','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'{}','','','{}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(2,27,1,1,2,1,'uncategorised','com_content','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(3,28,1,3,4,1,'uncategorised','com_banners','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(4,29,1,5,6,1,'uncategorised','com_contact','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(5,30,1,7,8,1,'uncategorised','com_newsfeeds','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(6,31,1,9,10,1,'uncategorised','com_weblinks','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(7,32,1,11,12,1,'uncategorised','com_users','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-01-01 00:00:01',0,'0000-00-00 00:00:00',0,'*',1),(8,56,1,13,14,1,'institutional-content','com_content','Contenido Institucional','institutional-content','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-04-11 14:38:22',868,'2014-05-20 14:22:53',0,'*',1),(9,57,1,15,16,1,'institutional-contacts','com_contact','Institutional Contacts','institutional-contacts','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-04-11 15:21:43',0,'0000-00-00 00:00:00',0,'*',1),(10,71,1,17,18,1,'uncategorised','com_dpcalendar','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\",\"color\":\"3366CC\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-14 17:20:19',0,'0000-00-00 00:00:00',0,'*',1),(11,95,1,19,20,1,'noticias-de-eventos-internos','com_content','Noticias de Eventos Internos','noticias-de-eventos-internos','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:23:11',0,'0000-00-00 00:00:00',0,'*',1),(12,96,1,21,22,1,'noticias-de-viajes','com_content','Noticias de Viajes','noticias-de-viajes','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:23:29',0,'0000-00-00 00:00:00',0,'*',1),(13,97,1,23,24,1,'evangelio-del-dia','com_content','Evangelio del Día','evangelio-del-dia','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:23:49',0,'0000-00-00 00:00:00',0,'*',1),(14,98,1,25,30,1,'documentacion-interna','com_content','Documentación Interna','documentacion-interna','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:24:15',0,'0000-00-00 00:00:00',0,'*',1),(15,99,14,26,27,2,'documentacion-interna/reglamento-interno-aymara','com_content','Reglamento Interno Aymara','reglamento-interno-aymara','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:25:12',0,'0000-00-00 00:00:00',0,'*',1),(16,100,14,28,29,2,'documentacion-interna/notificaciones','com_content','Notificaciones','notificaciones','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:28:17',0,'0000-00-00 00:00:00',0,'*',1),(17,101,1,31,32,1,'banner-principal','com_content','Banner Principal','banner-principal','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-20 14:28:51',0,'0000-00-00 00:00:00',0,'*',1),(18,114,1,33,34,1,'preguntas-sobre-receptivo','com_ats','Preguntas Sobre Receptivo','preguntas-sobre-receptivo','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\",\"defposttext\":\"\\u00a0\",\"instantreply\":\"0\",\"category_email\":\"\",\"defaultprivate\":\"0\",\"forcetype\":\"\",\"notify_managers\":[\"all\"],\"credits_newpublic\":\"0\",\"credits_replypublic\":\"0\",\"credits_newprivate\":\"0\",\"credits_replyprivate\":\"0\",\"modifier_lowpriority\":\"0\",\"modifier_normalpriority\":\"0\",\"modifier_highpriority\":\"0\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-30 14:28:12',0,'0000-00-00 00:00:00',0,'*',1),(19,115,1,35,36,1,'preguntas-sobre-viajes-de-egresados','com_ats','Preguntas sobre Viajes de Egresados','preguntas-sobre-viajes-de-egresados','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\",\"defposttext\":\"\\u00a0\",\"instantreply\":\"0\",\"category_email\":\"\",\"defaultprivate\":\"0\",\"forcetype\":\"\",\"notify_managers\":[\"all\"],\"credits_newpublic\":\"0\",\"credits_replypublic\":\"0\",\"credits_newprivate\":\"0\",\"credits_replyprivate\":\"0\",\"modifier_lowpriority\":\"0\",\"modifier_normalpriority\":\"0\",\"modifier_highpriority\":\"0\"}','','','{\"author\":\"\",\"robots\":\"\"}',868,'2014-05-30 14:28:26',0,'0000-00-00 00:00:00',0,'*',1);
/*!40000 ALTER TABLE `nstest_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_activities`
--

DROP TABLE IF EXISTS `nstest_community_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `actor` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `app` varchar(200) NOT NULL,
  `verb` varchar(200) NOT NULL,
  `cid` int(10) NOT NULL,
  `groupid` int(10) DEFAULT NULL,
  `eventid` int(10) DEFAULT NULL,
  `group_access` tinyint(4) NOT NULL DEFAULT '0',
  `event_access` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `access` tinyint(3) unsigned NOT NULL,
  `params` text NOT NULL,
  `points` int(4) NOT NULL DEFAULT '1',
  `archived` tinyint(3) NOT NULL,
  `location` text NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `comment_id` int(10) NOT NULL,
  `comment_type` varchar(200) NOT NULL,
  `like_id` int(10) NOT NULL,
  `like_type` varchar(200) NOT NULL,
  `actors` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `actor` (`actor`),
  KEY `target` (`target`),
  KEY `app` (`app`),
  KEY `created` (`created`),
  KEY `archived` (`archived`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_activities`
--

LOCK TABLES `nstest_community_activities` WRITE;
/*!40000 ALTER TABLE `nstest_community_activities` DISABLE KEYS */;
INSERT INTO `nstest_community_activities` VALUES (1,868,0,'','','profile.avatar.upload','',0,0,0,0,0,'2014-05-20 18:06:21',0,'{\"attachment\":\"images\\/avatar\\/stream_1a34ce90e9b9209177743282.jpg\"}',1,0,'',255.000000,255.000000,1,'profile.avatar.upload',1,'profile.avatar.upload',''),(2,868,0,'','','profile.avatar.upload','',0,0,0,0,0,'2014-05-20 18:06:46',0,'{\"attachment\":\"images\\/avatar\\/stream_fb2fb08d05c20e55480806bb.jpg\"}',1,0,'',255.000000,255.000000,2,'profile.avatar.upload',2,'profile.avatar.upload',''),(3,868,0,'','','cover.upload','',1,0,0,0,0,'2014-05-20 18:24:07',0,'{\"attachment\":\"images\\/cover\\/profile\\/868\\/dabb019f50b98c651a075b5e64b388e0.jpg\",\"type\":\"profile\"}',1,0,'',255.000000,255.000000,3,'cover.upload',3,'cover.upload','');
/*!40000 ALTER TABLE `nstest_community_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_activities_hide`
--

DROP TABLE IF EXISTS `nstest_community_activities_hide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_activities_hide` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_activities_hide`
--

LOCK TABLES `nstest_community_activities_hide` WRITE;
/*!40000 ALTER TABLE `nstest_community_activities_hide` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_activities_hide` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_apps`
--

DROP TABLE IF EXISTS `nstest_community_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `apps` varchar(200) NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `position` varchar(50) NOT NULL DEFAULT 'content',
  `params` text NOT NULL,
  `privacy` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_userid` (`userid`),
  KEY `idx_user_apps` (`userid`,`apps`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_apps`
--

LOCK TABLES `nstest_community_apps` WRITE;
/*!40000 ALTER TABLE `nstest_community_apps` DISABLE KEYS */;
INSERT INTO `nstest_community_apps` VALUES (1,868,'kunenagroups',0,'content|sidebar-top|sidebar-bottom','','0');
/*!40000 ALTER TABLE `nstest_community_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_avatar`
--

DROP TABLE IF EXISTS `nstest_community_avatar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_avatar` (
  `id` int(10) unsigned NOT NULL,
  `apptype` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '0 = small, 1 = medium, 2=large',
  UNIQUE KEY `id` (`id`,`apptype`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_avatar`
--

LOCK TABLES `nstest_community_avatar` WRITE;
/*!40000 ALTER TABLE `nstest_community_avatar` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_avatar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_blocklist`
--

DROP TABLE IF EXISTS `nstest_community_blocklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_blocklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `blocked_userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `blocked_userid` (`blocked_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_blocklist`
--

LOCK TABLES `nstest_community_blocklist` WRITE;
/*!40000 ALTER TABLE `nstest_community_blocklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_blocklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_config`
--

DROP TABLE IF EXISTS `nstest_community_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_config` (
  `name` varchar(64) NOT NULL,
  `params` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_config`
--

LOCK TABLES `nstest_community_config` WRITE;
/*!40000 ALTER TABLE `nstest_community_config` DISABLE KEYS */;
INSERT INTO `nstest_community_config` VALUES ('dbversion','14'),('config','{\"enablereporting\":\"1\",\"maxReport\":\"50\",\"notifyMaxReport\":\"\",\"enableguestreporting\":\"0\",\"predefinedreports\":\"Spamming \\/ Advertisement\\\\nProfanity \\/ Inappropriate content.\\\\nAbusive.\",\"guestsearch\":\"0\",\"privacy_search_email\":\"0\",\"sendemailonpageload\":\"0\",\"archive_activity_max_day\":\"1\",\"archive_activity_limit\":\"100\",\"enableterms\":\"0\",\"registrationTerms\":\"Estos son los t\\u00e9rminos y condiciones... quiz\\u00e1s habr\\u00eda que completarlo, no? :)\",\"recaptcha\":\"0\",\"recaptcha_secure\":\"0\",\"recaptchapublic\":\"\",\"recaptchaprivate\":\"\",\"profile_deletion\":\"1\",\"recaptchatheme\":\"red\",\"recaptchalang\":\"en\",\"alloweddomains\":\"\",\"denieddomains\":\"\",\"respectactivityprivacy\":\"1\",\"newtab\":\"0\",\"allmemberactivitycomment\":\"0\",\"alphabetfiltering\":\"1\",\"likes_groups\":\"1\",\"likes_events\":\"1\",\"likes_photo\":\"1\",\"likes_videos\":\"1\",\"likes_profile\":\"1\",\"sitename\":\"Aymara Intranet\",\"redirect_login\":\"profile\",\"redirect_logout\":\"frontpage\",\"enablesharethis\":\"0\",\"shareviaemail\":\"1\",\"enablepm\":\"1\",\"wallediting\":\"1\",\"lockprofilewalls\":\"1\",\"lockvideoswalls\":\"1\",\"lockgroupwalls\":\"1\",\"lockeventwalls\":\"1\",\"enable_refresh\":\"1\",\"stream_refresh_interval\":\"30000\",\"daylightsavingoffset\":\"0\",\"htmlemail\":\"1\",\"copyrightemail\":\"Aymara. Intranet\",\"statusmaxchar\":\"400\",\"profile_multiprofile\":\"1\",\"profile_multiprofile_lock\":\"0\",\"antispam_enable\":\"0\",\"antispam_akismet_key\":\"\",\"antispam_akismet_messages\":\"1\",\"antispam_akismet_friends\":\"1\",\"antispam_akismet_walls\":\"1\",\"antispam_akismet_status\":\"1\",\"antispam_akismet_discussions\":\"1\",\"pmperday\":\"30\",\"limit_groups_perday\":\"30\",\"limit_photos_perday\":\"30\",\"limit_videos_perday\":\"30\",\"limit_friends_perday\":\"50\",\"limit_files_perday\":\"30\",\"enablephotos\":\"1\",\"photouploadlimit\":\"500\",\"photopaginationlimit\":\"100\",\"photosmapdefault\":\"0\",\"photosgalleryslider\":\"1\",\"maxuploadsize\":\"8\",\"deleteoriginalphotos\":\"0\",\"magickPath\":\"\",\"autoalbumcover\":\"1\",\"photos_auto_rotate\":\"1\",\"output_image_quality\":\"80\",\"enable_photos_location\":\"1\",\"enablevideos\":\"1\",\"enableguestsearchvideos\":\"1\",\"enableprofilevideo\":\"1\",\"enablevideosupload\":\"0\",\"videouploadlimit\":\"500\",\"videosmapdefault\":\"0\",\"deleteoriginalvideos\":\"0\",\"videofolder\":\"images\",\"maxvideouploadsize\":\"8\",\"ffmpegPath\":\"\",\"flvtool2\":\"\",\"qscale\":\"11\",\"videosSize\":\"480x360\",\"customCommandForVideo\":\"\",\"enablevideopseudostream\":\"0\",\"videodebug\":\"0\",\"enable_zencoder\":\"0\",\"zencoder_api_key\":\"\",\"enablegroups\":\"1\",\"enableguestsearchgroups\":\"1\",\"moderategroupcreation\":\"0\",\"creategroups\":\"1\",\"groupcreatelimit\":\"300\",\"groupphotouploadlimit\":\"500\",\"groupvideouploadlimit\":\"500\",\"createannouncement\":\"1\",\"creatediscussion\":\"1\",\"groupphotos\":\"1\",\"groupvideos\":\"1\",\"group_events\":\"1\",\"groupdiscussnotification\":\"0\",\"discussionfilelimit\":\"500\",\"groupdiscussfilesharing\":\"1\",\"filemaxuploadsize\":\"8\",\"groupbulletinfilesharing\":\"1\",\"enableevents\":\"1\",\"enableguestsearchevents\":\"1\",\"event_moderation\":\"0\",\"createevents\":\"1\",\"enablerepeat\":\"0\",\"eventcreatelimit\":\"300\",\"eventexportical\":\"1\",\"event_import_ical\":\"1\",\"eventshowmap\":\"1\",\"eventradiusmeasure\":\"miles\",\"event_nearby_radius\":\"5\",\"event_calendar_firstday\":\"Monday\",\"eventdateformat\":\"M d Y\",\"eventshowampm\":\"1\",\"eventshowtimezone\":\"0\",\"enablekarma\":\"1\",\"defaultpoint\":\"0\",\"point1\":\"50\",\"point2\":\"100\",\"point3\":\"200\",\"point4\":\"350\",\"point5\":\"600\",\"show_featured\":\"1\",\"featuredalbumscroll\":\"1\",\"featuredvideoscroll\":\"1\",\"featuredeventscroll\":\"3\",\"featuredgroupscroll\":\"3\",\"featuredmemberscroll\":\"3\",\"featureduserslimit\":\"10\",\"featuredvideoslimit\":\"10\",\"featuredgroupslimit\":\"10\",\"featuredalbumslimit\":\"10\",\"featuredeventslimit\":\"10\",\"listlimit\":\"16\",\"show_toolbar\":\"1\",\"displayname\":\"name\",\"activitydateformat\":\"lapse\",\"allowhtml\":\"1\",\"htmleditor\":\"tinymce\",\"showactivityavatar\":\"1\",\"showactivitycontent\":\"1\",\"streamcontentlength\":\"150\",\"singularnumber\":\"1\",\"profileDateFormat\":\"%d\\/%m\\/%Y\",\"maxactivities\":\"20\",\"frontpageactivitydefault\":\"all\",\"showactivitystream\":\"1\",\"custom_activity\":\"1\",\"privacyprofile\":\"0\",\"privacyfriends\":\"0\",\"privacyphotos\":\"0\",\"privacyvideos\":\"0\",\"privacy_groups_list\":\"0\",\"maxnotification\":\"20\",\"etype_groups_notify_admin\":\"1\",\"notif_groups_notify_admin\":\"1\",\"etype_user_profile_delete\":\"1\",\"notif_user_profile_delete\":\"1\",\"etype_system_reports_threshold\":\"1\",\"notif_system_reports_threshold\":\"1\",\"etype_profile_activity_add_comment\":\"1\",\"notif_profile_activity_add_comment\":\"1\",\"etype_profile_activity_reply_comment\":\"1\",\"notif_profile_activity_reply_comment\":\"1\",\"etype_profile_status_update\":\"1\",\"notif_profile_status_update\":\"1\",\"etype_profile_like\":\"1\",\"notif_profile_like\":\"1\",\"etype_profile_stream_like\":\"1\",\"notif_profile_stream_like\":\"1\",\"etype_friends_request_connection\":\"1\",\"notif_friends_request_connection\":\"1\",\"etype_friends_create_connection\":\"1\",\"notif_friends_create_connection\":\"1\",\"etype_inbox_create_message\":\"1\",\"notif_inbox_create_message\":\"1\",\"etype_groups_invite\":\"1\",\"notif_groups_invite\":\"1\",\"etype_groups_discussion_reply\":\"1\",\"notif_groups_discussion_reply\":\"1\",\"etype_groups_wall_create\":\"1\",\"notif_groups_wall_create\":\"1\",\"etype_groups_create_discussion\":\"1\",\"notif_groups_create_discussion\":\"1\",\"etype_groups_create_news\":\"1\",\"notif_groups_create_news\":\"1\",\"etype_groups_create_album\":\"1\",\"notif_groups_create_album\":\"1\",\"etype_groups_create_video\":\"1\",\"notif_groups_create_video\":\"1\",\"etype_groups_create_event\":\"1\",\"notif_groups_create_event\":\"1\",\"etype_groups_sendmail\":\"1\",\"notif_groups_sendmail\":\"1\",\"etype_groups_member_approved\":\"1\",\"notif_groups_member_approved\":\"1\",\"etype_groups_member_join\":\"1\",\"notif_groups_member_join\":\"1\",\"etype_groups_notify_creator\":\"1\",\"notif_groups_notify_creator\":\"1\",\"etype_groups_discussion_newfile\":\"1\",\"notif_groups_discussion_newfile\":\"1\",\"etype_groups_activity_add_comment\":\"0\",\"notif_groups_activity_add_comment\":\"0\",\"etype_events_notify_admin\":\"1\",\"notif_events_notify_admin\":\"1\",\"etype_events_invite\":\"1\",\"notif_events_invite\":\"1\",\"etype_events_invitation_approved\":\"1\",\"notif_events_invitation_approved\":\"1\",\"etype_events_sendmail\":\"1\",\"notif_events_sendmail\":\"1\",\"etype_event_notify_creator\":\"0\",\"notif_event_notify_creator\":\"0\",\"etype_event_join_request\":\"1\",\"notif_event_join_request\":\"1\",\"etype_events_activity_add_comment\":\"0\",\"notif_events_activity_add_comment\":\"0\",\"etype_videos_submit_wall\":\"1\",\"notif_videos_submit_wall\":\"1\",\"etype_videos_reply_wall\":\"1\",\"notif_videos_reply_wall\":\"1\",\"etype_videos_tagging\":\"1\",\"notif_videos_tagging\":\"1\",\"etype_videos_like\":\"1\",\"notif_videos_like\":\"1\",\"etype_photos_submit_wall\":\"1\",\"notif_photos_submit_wall\":\"1\",\"etype_photos_reply_wall\":\"1\",\"notif_photos_reply_wall\":\"1\",\"etype_photos_tagging\":\"1\",\"notif_photos_tagging\":\"1\",\"etype_photos_like\":\"1\",\"notif_photos_like\":\"1\",\"etype_system_messaging\":\"1\",\"notif_system_messaging\":\"1\",\"privacy_show_admins\":\"1\",\"fbconnectkey\":\"\",\"fbconnectsecret\":\"\",\"usejfbc\":\"0\",\"fbsignupimport\":\"1\",\"fbwatermark\":\"1\",\"fbloginimportprofile\":\"1\",\"fbloginimportavatar\":\"1\",\"fbconnectupdatestatus\":\"1\",\"fbconnectpoststatus\":\"1\",\"photostorage\":\"file\",\"videostorage\":\"file\",\"user_avatar_storage\":\"file\",\"groups_avatar_storage\":\"file\",\"file_storage\":\"file\",\"storages3bucket\":\"\",\"storages3accesskey\":\"\",\"storages3secretkey\":\"\",\"amazon_storage_class\":\"STANDARD\",\"fieldcodestreet\":\"FIELD_ADDRESS\",\"fieldcodecity\":\"FIELD_CITY\",\"fieldcodestate\":\"FIELD_STATE\",\"fieldcodecountry\":\"FIELD_COUNTRY\",\"network_keywords\":\"\"}');
/*!40000 ALTER TABLE `nstest_community_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_connect_users`
--

DROP TABLE IF EXISTS `nstest_community_connect_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_connect_users` (
  `connectid` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_connect_users`
--

LOCK TABLES `nstest_community_connect_users` WRITE;
/*!40000 ALTER TABLE `nstest_community_connect_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_connect_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_connection`
--

DROP TABLE IF EXISTS `nstest_community_connection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_connection` (
  `connection_id` int(11) NOT NULL AUTO_INCREMENT,
  `connect_from` int(11) NOT NULL,
  `connect_to` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `group` int(11) NOT NULL,
  `msg` text NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`connection_id`),
  KEY `connect_from` (`connect_from`,`connect_to`,`status`,`group`),
  KEY `idx_connect_to` (`connect_to`),
  KEY `idx_connect_from` (`connect_from`),
  KEY `idx_connect_tofrom` (`connect_to`,`connect_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_connection`
--

LOCK TABLES `nstest_community_connection` WRITE;
/*!40000 ALTER TABLE `nstest_community_connection` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_events`
--

DROP TABLE IF EXISTS `nstest_community_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL COMMENT 'parent for recurring event',
  `catid` int(11) unsigned NOT NULL,
  `contentid` int(11) unsigned DEFAULT '0' COMMENT '0 - if type == profile, else it hold the group id',
  `type` varchar(255) NOT NULL DEFAULT 'profile' COMMENT 'profile, group',
  `title` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `summary` text NOT NULL,
  `description` text,
  `creator` int(11) unsigned NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `permission` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0 - Open (Anyone can mark attendence), 1 - Private (Only invited can mark attendence)',
  `avatar` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `cover` text NOT NULL,
  `invitedcount` int(11) unsigned DEFAULT '0',
  `confirmedcount` int(11) unsigned DEFAULT '0' COMMENT 'treat this as member count as well',
  `declinedcount` int(11) unsigned DEFAULT '0',
  `maybecount` int(11) unsigned DEFAULT '0',
  `wallcount` int(11) unsigned DEFAULT '0',
  `ticket` int(11) unsigned DEFAULT '0' COMMENT 'Represent how many guest can be joined or invited.',
  `allowinvite` tinyint(1) unsigned DEFAULT '1' COMMENT '0 - guest member cannot invite thier friends to join. 1 - yes, guest member can invite any of thier friends to join.',
  `created` datetime DEFAULT NULL,
  `hits` int(11) unsigned DEFAULT '0',
  `published` int(11) unsigned DEFAULT '1',
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `offset` varchar(5) DEFAULT NULL,
  `allday` tinyint(11) NOT NULL DEFAULT '0',
  `repeat` varchar(50) DEFAULT NULL COMMENT 'null,daily,weekly,monthly',
  `repeatend` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_creator` (`creator`),
  KEY `idx_period` (`startdate`,`enddate`),
  KEY `idx_type` (`type`),
  KEY `idx_catid` (`catid`),
  KEY `idx_published` (`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_events`
--

LOCK TABLES `nstest_community_events` WRITE;
/*!40000 ALTER TABLE `nstest_community_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_events_category`
--

DROP TABLE IF EXISTS `nstest_community_events_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_events_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_events_category`
--

LOCK TABLES `nstest_community_events_category` WRITE;
/*!40000 ALTER TABLE `nstest_community_events_category` DISABLE KEYS */;
INSERT INTO `nstest_community_events_category` VALUES (1,0,'General','General events'),(2,0,'Birthday','Birthday events'),(3,0,'Party','Party events');
/*!40000 ALTER TABLE `nstest_community_events_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_events_members`
--

DROP TABLE IF EXISTS `nstest_community_events_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_events_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `eventid` int(11) unsigned NOT NULL,
  `memberid` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '[Join / Invite]: 0 - [pending approval/pending invite], 1 - [approved/confirmed], 2 - [rejected/declined], 3 - [maybe/maybe], 4 - [blocked/blocked]',
  `permission` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '1 - creator, 2 - admin, 3 - member',
  `invited_by` int(11) unsigned DEFAULT '0',
  `approval` tinyint(1) unsigned DEFAULT '0' COMMENT '0 - no approval required, 1 - required admin approval',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_eventid` (`eventid`),
  KEY `idx_status` (`status`),
  KEY `idx_invitedby` (`invited_by`),
  KEY `idx_permission` (`eventid`,`permission`),
  KEY `idx_member_event` (`eventid`,`memberid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_events_members`
--

LOCK TABLES `nstest_community_events_members` WRITE;
/*!40000 ALTER TABLE `nstest_community_events_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_events_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_featured`
--

DROP TABLE IF EXISTS `nstest_community_featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_featured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_featured`
--

LOCK TABLES `nstest_community_featured` WRITE;
/*!40000 ALTER TABLE `nstest_community_featured` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_featured` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_fields`
--

DROP TABLE IF EXISTS `nstest_community_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `min` int(5) NOT NULL,
  `max` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tips` text NOT NULL,
  `visible` tinyint(1) DEFAULT '0',
  `required` tinyint(1) DEFAULT '0',
  `searchable` tinyint(1) DEFAULT '1',
  `registration` tinyint(1) DEFAULT '1',
  `options` text,
  `fieldcode` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldcode` (`fieldcode`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_fields`
--

LOCK TABLES `nstest_community_fields` WRITE;
/*!40000 ALTER TABLE `nstest_community_fields` DISABLE KEYS */;
INSERT INTO `nstest_community_fields` VALUES (1,'group',1,1,10,100,'Basic Information','Basic information for user',1,1,1,1,'','',''),(2,'gender',2,1,10,100,'Gender','Select gender',1,1,1,1,'COM_COMMUNITY_MALE\nFEMALE','FIELD_GENDER',''),(3,'birthdate',3,1,10,100,'Birthdate','Enter your date of birth so other users can know when to wish you happy birthday ',1,0,1,1,'','FIELD_BIRTHDATE',''),(4,'textarea',4,1,1,800,'About me','Tell us more about yourself',1,1,1,1,'','FIELD_ABOUTME',''),(5,'group',5,1,10,100,'Contact Information','Specify your contact details',1,1,1,1,'','',''),(6,'text',6,1,10,100,'Mobile phone','Mobile carrier number that other users can contact you.',1,0,1,1,'','FIELD_MOBILE',''),(7,'text',7,1,10,100,'Land phone','Contact number that other users can contact you.',1,0,1,1,'','FIELD_LANDPHONE',''),(8,'textarea',8,1,10,100,'Address','Your Address',1,1,1,1,'','FIELD_ADDRESS',''),(9,'text',9,1,10,100,'State','Your state',1,1,1,1,'','FIELD_STATE',''),(10,'text',10,1,10,100,'City / Town','Your city or town name',1,1,1,1,'','FIELD_CITY',''),(11,'country',11,1,10,100,'Country','Your country',1,1,1,1,'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nAustralia\nAustria\nAzerbaijan\nBahamas\nBahrain\nBangladesh\nBarbados\nBelarus\nBelgium\nBelize\nBenin\nBermuda\nBhutan\nBolivia\nBosnia and Herzegovina\nBotswana\nBouvet Island\nBrazil\nBritish Indian Ocean Territory\nBrunei Darussalam\nBulgaria\nBurkina Faso\nBurundi\nCambodia\nCameroon\nCanada\nCape Verde\nCayman Islands\nCentral African Republic\nChad\nChile\nChina\nChristmas Island\nCocos (Keeling) Islands\nColombia\nComoros\nCongo\nCook Islands\nCosta Rica\nCote D\'Ivoire (Ivory Coast)\nCroatia (Hrvatska)\nCuba\nCyprus\nCzechoslovakia (former)\nCzech Republic\nDenmark\nDjibouti\nDominica\nDominican Republic\nEast Timor\nEcuador\nEgypt\nEl Salvador\nEquatorial Guinea\nEritrea\nEstonia\nEthiopia\nFalkland Islands (Malvinas)\nFaroe Islands\nFiji\nFinland\nFrance\nFrance, Metropolitan\nFrench Guiana\nFrench Polynesia\nFrench Southern Territories\nGabon\nGambia\nGeorgia\nGermany\nGhana\nGibraltar\nGreat Britain (UK)\nGreece\nGreenland\nGrenada\nGuadeloupe\nGuam\nGuatemala\nGuinea\nGuinea-Bissau\nGuyana\nHaiti\nHeard and McDonald Islands\nHonduras\nHong Kong\nHungary\nIceland\nIndia\nIndonesia\nIran\nIraq\nIreland\nIsrael\nItaly\nJamaica\nJapan\nJordan\nKazakhstan\nKenya\nKiribati\nKorea, North\nSouth Korea\nKuwait\nKyrgyzstan\nLaos\nLatvia\nLebanon\nLesotho\nLiberia\nLibya\nLiechtenstein\nLithuania\nLuxembourg\nMacau\nMacedonia\nMadagascar\nMalawi\nMalaysia\nMaldives\nMali\nMalta\nMarshall Islands\nMartinique\nMauritania\nMauritius\nMayotte\nMexico\nMicronesia\nMoldova\nMonaco\nMongolia\nMontserrat\nMorocco\nMozambique\nMyanmar\nNamibia\nNauru\nNepal\nNetherlands\nNetherlands Antilles\nNeutral Zone\nNew Caledonia\nNew Zealand\nNicaragua\nNiger\nNigeria\nNiue\nNorfolk Island\nNorthern Mariana Islands\nNorway\nOman\nPakistan\nPalau\nPanama\nPapua New Guinea\nParaguay\nPeru\nPhilippines\nPitcairn\nPoland\nPortugal\nPuerto Rico\nQatar\nReunion\nRomania\nRussian Federation\nRwanda\nSaint Kitts and Nevis\nSaint Lucia\nSaint Vincent and the Grenadines\nSamoa\nSan Marino\nSao Tome and Principe\nSaudi Arabia\nSenegal\nSeychelles\nS. Georgia and S. Sandwich Isls.\nSierra Leone\nSingapore\nSlovak Republic\nSlovenia\nSolomon Islands\nSomalia\nSouth Africa\nSpain\nSri Lanka\nSt. Helena\nSt. Pierre and Miquelon\nSudan\nSuriname\nSvalbard and Jan Mayen Islands\nSwaziland\nSweden\nSwitzerland\nSyria\nTaiwan\nTajikistan\nTanzania\nThailand\nTogo\nTokelau\nTonga\nTrinidad and Tobago\nTunisia\nTurkey\nTurkmenistan\nTurks and Caicos Islands\nTuvalu\nUganda\nUkraine\nUnited Arab Emirates\nUnited Kingdom\nUnited States\nUruguay\nUS Minor Outlying Islands\nUSSR (former)\nUzbekistan\nVanuatu\nVatican City State (Holy Sea)\nVenezuela\nViet Nam\nVirgin Islands (British)\nVirgin Islands (U.S.)\nWallis and Futuna Islands\nWestern Sahara\nYemen\nYugoslavia\nZaire\nZambia\nZimbabwe','FIELD_COUNTRY',''),(12,'url',12,1,10,100,'Website','Your website',1,1,1,1,'','FIELD_WEBSITE',''),(13,'group',13,1,10,100,'Education','Educations',1,1,1,1,'','',''),(14,'text',14,1,10,200,'College / University','Your college or university name',1,1,1,1,'','FIELD_COLLEGE',''),(15,'text',15,1,5,100,'Graduation Year','Graduation year',1,1,1,1,'','FIELD_GRADUATION','');
/*!40000 ALTER TABLE `nstest_community_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_fields_values`
--

DROP TABLE IF EXISTS `nstest_community_fields_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_fields_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `field_id` int(10) NOT NULL,
  `value` text NOT NULL,
  `access` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_user_fieldid` (`user_id`,`field_id`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_fields_values`
--

LOCK TABLES `nstest_community_fields_values` WRITE;
/*!40000 ALTER TABLE `nstest_community_fields_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_fields_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_files`
--

DROP TABLE IF EXISTS `nstest_community_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL,
  `discussionid` int(11) NOT NULL,
  `bulletinid` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  `profileid` int(11) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `storage` varchar(64) NOT NULL,
  `creator` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discussionid` (`discussionid`),
  KEY `groupid` (`groupid`),
  KEY `creator` (`creator`),
  KEY `bulletinid` (`bulletinid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_files`
--

LOCK TABLES `nstest_community_files` WRITE;
/*!40000 ALTER TABLE `nstest_community_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups`
--

DROP TABLE IF EXISTS `nstest_community_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(1) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `approvals` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `avatar` text NOT NULL,
  `thumb` text NOT NULL,
  `cover` text NOT NULL,
  `discusscount` int(11) NOT NULL DEFAULT '0',
  `wallcount` int(11) NOT NULL DEFAULT '0',
  `membercount` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `hits` int(11) NOT NULL,
  `storage` varchar(64) NOT NULL DEFAULT 'file',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups`
--

LOCK TABLES `nstest_community_groups` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups_bulletins`
--

DROP TABLE IF EXISTS `nstest_community_groups_bulletins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups_bulletins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups_bulletins`
--

LOCK TABLES `nstest_community_groups_bulletins` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups_bulletins` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_groups_bulletins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups_category`
--

DROP TABLE IF EXISTS `nstest_community_groups_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups_category`
--

LOCK TABLES `nstest_community_groups_category` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups_category` DISABLE KEYS */;
INSERT INTO `nstest_community_groups_category` VALUES (1,0,'General','General group category.'),(2,0,'Internet','Internet group category.'),(3,0,'Business','Business groups category'),(4,0,'Automotive','Automotive groups category'),(5,0,'Music','Music groups category');
/*!40000 ALTER TABLE `nstest_community_groups_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups_discuss`
--

DROP TABLE IF EXISTS `nstest_community_groups_discuss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups_discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `groupid` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `lastreplied` datetime NOT NULL,
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups_discuss`
--

LOCK TABLES `nstest_community_groups_discuss` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups_discuss` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_groups_discuss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups_invite`
--

DROP TABLE IF EXISTS `nstest_community_groups_invite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups_invite` (
  `groupid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `creator` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups_invite`
--

LOCK TABLES `nstest_community_groups_invite` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups_invite` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_groups_invite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_groups_members`
--

DROP TABLE IF EXISTS `nstest_community_groups_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_groups_members` (
  `groupid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `permissions` int(1) NOT NULL,
  KEY `groupid` (`groupid`),
  KEY `idx_memberid` (`memberid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_groups_members`
--

LOCK TABLES `nstest_community_groups_members` WRITE;
/*!40000 ALTER TABLE `nstest_community_groups_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_groups_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_invitations`
--

DROP TABLE IF EXISTS `nstest_community_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `callback` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `users` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_invitations`
--

LOCK TABLES `nstest_community_invitations` WRITE;
/*!40000 ALTER TABLE `nstest_community_invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_likes`
--

DROP TABLE IF EXISTS `nstest_community_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `element` varchar(200) NOT NULL,
  `uid` int(10) NOT NULL,
  `like` text NOT NULL,
  `dislike` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `element` (`element`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_likes`
--

LOCK TABLES `nstest_community_likes` WRITE;
/*!40000 ALTER TABLE `nstest_community_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_location_cache`
--

DROP TABLE IF EXISTS `nstest_community_location_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_location_cache` (
  `address` varchar(255) NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `data` text NOT NULL,
  `status` varchar(2) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_location_cache`
--

LOCK TABLES `nstest_community_location_cache` WRITE;
/*!40000 ALTER TABLE `nstest_community_location_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_location_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_mailq`
--

DROP TABLE IF EXISTS `nstest_community_mailq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_mailq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient` text NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `template` varchar(64) NOT NULL,
  `email_type` text,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_mailq`
--

LOCK TABLES `nstest_community_mailq` WRITE;
/*!40000 ALTER TABLE `nstest_community_mailq` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_mailq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_memberlist`
--

DROP TABLE IF EXISTS `nstest_community_memberlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_memberlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `condition` varchar(255) NOT NULL,
  `avataronly` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_memberlist`
--

LOCK TABLES `nstest_community_memberlist` WRITE;
/*!40000 ALTER TABLE `nstest_community_memberlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_memberlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_memberlist_criteria`
--

DROP TABLE IF EXISTS `nstest_community_memberlist_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_memberlist_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listid` int(11) NOT NULL,
  `field` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `listid` (`listid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_memberlist_criteria`
--

LOCK TABLES `nstest_community_memberlist_criteria` WRITE;
/*!40000 ALTER TABLE `nstest_community_memberlist_criteria` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_memberlist_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_msg`
--

DROP TABLE IF EXISTS `nstest_community_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `deleted` tinyint(3) unsigned DEFAULT '0',
  `from_name` varchar(45) NOT NULL,
  `posted_on` datetime DEFAULT NULL,
  `subject` tinytext NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_msg`
--

LOCK TABLES `nstest_community_msg` WRITE;
/*!40000 ALTER TABLE `nstest_community_msg` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_msg_recepient`
--

DROP TABLE IF EXISTS `nstest_community_msg_recepient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_msg_recepient` (
  `msg_id` int(10) unsigned NOT NULL,
  `msg_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `bcc` tinyint(3) unsigned DEFAULT '0',
  `is_read` tinyint(3) unsigned DEFAULT '0',
  `deleted` tinyint(3) unsigned DEFAULT '0',
  UNIQUE KEY `un` (`msg_id`,`to`),
  KEY `msg_id` (`msg_id`),
  KEY `to` (`to`),
  KEY `idx_isread_to_deleted` (`is_read`,`to`,`deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_msg_recepient`
--

LOCK TABLES `nstest_community_msg_recepient` WRITE;
/*!40000 ALTER TABLE `nstest_community_msg_recepient` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_msg_recepient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_notifications`
--

DROP TABLE IF EXISTS `nstest_community_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(200) NOT NULL,
  `cmd_type` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `target` (`target`),
  KEY `actor` (`actor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_notifications`
--

LOCK TABLES `nstest_community_notifications` WRITE;
/*!40000 ALTER TABLE `nstest_community_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_oauth`
--

DROP TABLE IF EXISTS `nstest_community_oauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_oauth` (
  `userid` int(11) NOT NULL,
  `requesttoken` text NOT NULL,
  `accesstoken` text NOT NULL,
  `app` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_oauth`
--

LOCK TABLES `nstest_community_oauth` WRITE;
/*!40000 ALTER TABLE `nstest_community_oauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_oauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_photos`
--

DROP TABLE IF EXISTS `nstest_community_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `albumid` int(11) NOT NULL,
  `caption` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `creator` int(11) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `original` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL DEFAULT '0',
  `storage` varchar(64) NOT NULL DEFAULT 'file',
  `created` datetime NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `status` varchar(200) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `albumid` (`albumid`),
  KEY `idx_storage` (`storage`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_photos`
--

LOCK TABLES `nstest_community_photos` WRITE;
/*!40000 ALTER TABLE `nstest_community_photos` DISABLE KEYS */;
INSERT INTO `nstest_community_photos` VALUES (1,1,'IMG_20131129_231403.jpg',1,868,'','images/cover/profile/868/dabb019f50b98c651a075b5e64b388e0.jpg','images/cover/profile/868/thumb_dabb019f50b98c651a075b5e64b388e0.jpg','',1665564,'file','2014-05-20 18:24:07',0,0,'','{}');
/*!40000 ALTER TABLE `nstest_community_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_photos_albums`
--

DROP TABLE IF EXISTS `nstest_community_photos_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_photos_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `eventid` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `location` text NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `idx_type` (`type`),
  KEY `idx_albumtype` (`id`,`type`),
  KEY `idx_creatortype` (`creator`,`type`),
  KEY `idx_groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_photos_albums`
--

LOCK TABLES `nstest_community_photos_albums` WRITE;
/*!40000 ALTER TABLE `nstest_community_photos_albums` DISABLE KEYS */;
INSERT INTO `nstest_community_photos_albums` VALUES (1,1,868,'Profile\'s cover','','40','2014-05-20 18:24:07','images/cover/profile/868/','profile.Cover',0,0,0,'',255.000000,255.000000,0,'{\"count\":\"1\",\"lastupdated\":\"2014-05-20 18:24:07\",\"thumbnail\":\"http:\\/\\/localhost\\/joomla32\\/images\\/cover\\/profile\\/868\\/thumb_dabb019f50b98c651a075b5e64b388e0.jpg\",\"thumbnail_id\":1}');
/*!40000 ALTER TABLE `nstest_community_photos_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_photos_tag`
--

DROP TABLE IF EXISTS `nstest_community_photos_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_photos_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_photoid` (`photoid`),
  KEY `idx_userid` (`userid`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_photo_user` (`photoid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_photos_tag`
--

LOCK TABLES `nstest_community_photos_tag` WRITE;
/*!40000 ALTER TABLE `nstest_community_photos_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_photos_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_photos_tokens`
--

DROP TABLE IF EXISTS `nstest_community_photos_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_photos_tokens` (
  `userid` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_photos_tokens`
--

LOCK TABLES `nstest_community_photos_tokens` WRITE;
/*!40000 ALTER TABLE `nstest_community_photos_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_photos_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_profiles`
--

DROP TABLE IF EXISTS `nstest_community_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `approvals` tinyint(3) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `avatar` text NOT NULL,
  `watermark` text NOT NULL,
  `watermark_hash` varchar(255) NOT NULL,
  `watermark_location` text NOT NULL,
  `thumb` text NOT NULL,
  `created` datetime NOT NULL,
  `create_groups` tinyint(1) DEFAULT '1',
  `create_events` int(11) DEFAULT '1',
  `profile_lock` tinyint(1) DEFAULT '0',
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `approvals` (`approvals`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_profiles`
--

LOCK TABLES `nstest_community_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_community_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_profiles_fields`
--

DROP TABLE IF EXISTS `nstest_community_profiles_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `multiprofile_id` (`parent`),
  KEY `field_id` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_profiles_fields`
--

LOCK TABLES `nstest_community_profiles_fields` WRITE;
/*!40000 ALTER TABLE `nstest_community_profiles_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_profiles_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_register`
--

DROP TABLE IF EXISTS `nstest_community_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_register` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `firstname` varchar(180) NOT NULL,
  `lastname` varchar(180) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `ip` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_register`
--

LOCK TABLES `nstest_community_register` WRITE;
/*!40000 ALTER TABLE `nstest_community_register` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_register_auth_token`
--

DROP TABLE IF EXISTS `nstest_community_register_auth_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_register_auth_token` (
  `token` varchar(200) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `auth_key` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`token`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_register_auth_token`
--

LOCK TABLES `nstest_community_register_auth_token` WRITE;
/*!40000 ALTER TABLE `nstest_community_register_auth_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_register_auth_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_reports`
--

DROP TABLE IF EXISTS `nstest_community_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniquestring` varchar(200) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_reports`
--

LOCK TABLES `nstest_community_reports` WRITE;
/*!40000 ALTER TABLE `nstest_community_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_reports_actions`
--

DROP TABLE IF EXISTS `nstest_community_reports_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_reports_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reportid` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `parameters` varchar(255) NOT NULL,
  `defaultaction` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_reports_actions`
--

LOCK TABLES `nstest_community_reports_actions` WRITE;
/*!40000 ALTER TABLE `nstest_community_reports_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_reports_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_reports_reporter`
--

DROP TABLE IF EXISTS `nstest_community_reports_reporter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_reports_reporter` (
  `reportid` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_reports_reporter`
--

LOCK TABLES `nstest_community_reports_reporter` WRITE;
/*!40000 ALTER TABLE `nstest_community_reports_reporter` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_reports_reporter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_storage_s3`
--

DROP TABLE IF EXISTS `nstest_community_storage_s3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_storage_s3` (
  `storageid` varchar(255) NOT NULL,
  `resource_path` varchar(255) NOT NULL,
  UNIQUE KEY `storageid` (`storageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_storage_s3`
--

LOCK TABLES `nstest_community_storage_s3` WRITE;
/*!40000 ALTER TABLE `nstest_community_storage_s3` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_storage_s3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_tags`
--

DROP TABLE IF EXISTS `nstest_community_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `element` varchar(200) NOT NULL,
  `userid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `tag` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_tags`
--

LOCK TABLES `nstest_community_tags` WRITE;
/*!40000 ALTER TABLE `nstest_community_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_tags_words`
--

DROP TABLE IF EXISTS `nstest_community_tags_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_tags_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(200) NOT NULL,
  `count` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_tags_words`
--

LOCK TABLES `nstest_community_tags_words` WRITE;
/*!40000 ALTER TABLE `nstest_community_tags_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_tags_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_user_status`
--

DROP TABLE IF EXISTS `nstest_community_user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `status` text NOT NULL,
  `posted_on` int(11) NOT NULL,
  `location` text NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_user_status`
--

LOCK TABLES `nstest_community_user_status` WRITE;
/*!40000 ALTER TABLE `nstest_community_user_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_userpoints`
--

DROP TABLE IF EXISTS `nstest_community_userpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_userpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(255) NOT NULL DEFAULT '',
  `rule_description` text NOT NULL,
  `rule_plugin` varchar(255) NOT NULL DEFAULT '',
  `action_string` varchar(255) NOT NULL DEFAULT '',
  `component` varchar(255) NOT NULL DEFAULT '',
  `access` tinyint(1) NOT NULL DEFAULT '1',
  `points` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_userpoints`
--

LOCK TABLES `nstest_community_userpoints` WRITE;
/*!40000 ALTER TABLE `nstest_community_userpoints` DISABLE KEYS */;
INSERT INTO `nstest_community_userpoints` VALUES (1,'Add Application','Give points when registered user add new application.','com_community','application.add','',1,0,0,1),(2,'Remove Application','Deduct points when registered user remove application.','com_community','application.remove','',1,0,0,1),(3,'Upload Photo','Give points when registered user upload photos.','com_community','photo.upload','',1,0,1,1),(4,'Add New Group','Give points when registered user created new group.','com_community','group.create','',1,3,1,1),(5,'Add New Group\'s Discussion','Give points when registered user created new discussion on group.','com_community','group.discussion.create','',1,2,1,1),(6,'Leave Group','Deduct points when registered user leave a group.','com_community','group.leave','',1,-1,1,1),(7,'Approve Friend Request','Give points when registered user approved friend request.','com_community','friends.request.approve','',1,1,1,1),(8,'Add New Photo Album','Give points when registered user added new photo album.','com_community','album.create','',1,1,1,1),(9,'Post Group Wall','Give points when registered user post wall on group.','com_community','group.wall.create','',1,1,1,1),(10,'Join Group','Give points when registered user joined a group.','com_community','group.join','',1,1,1,1),(11,'Reply Group\'s Discussion','Give points when registered user replied on group\'s discussion.','com_community','group.discussion.reply','',1,1,1,1),(12,'Post Wall','Give points when registered user post a wall on profile.','com_community','profile.wall.create','',1,1,1,1),(13,'Profile Status Update','Give points when registered user update their profile status.','com_community','profile.status.update','',1,1,1,1),(14,'Profile Update','Give points when registered user update their profile.','com_community','profile.save','',1,1,1,1),(15,'Update group','Give points when registered user update the group.','com_community','group.updated','',1,1,1,1),(16,'Upload group avatar','Give points when registered user upload avatar to group.','com_community','group.avatar.upload','',1,0,1,1),(17,'Create Group\'s News','Give points when registered user add group\'s news.','com_community','group.news.create','',1,1,1,1),(18,'Post Wall for photos','Give points when registered user post wall at photos.','com_community','photos.wall.create','',1,1,1,1),(19,'Remove Friend','Deduct points when registered user remove a friend.','com_community','friends.remove','',1,0,1,1),(20,'Upload profile avatar','Give points when registered user upload profile avatar.','com_community','profile.avatar.upload','',1,0,1,1),(21,'Update privacy','Give points when registered user updated privacy.','com_community','profile.privacy.update','',1,0,1,1),(22,'Reply Messages','Give points when registered user reply a message.','com_community','inbox.message.reply','',1,0,1,1),(23,'Send Messages','Give points when registered user send a message.','com_community','inbox.message.send','',1,0,1,1),(24,'Remove Group member','Deduct points when registered user remove a group memeber.','com_community','group.member.remove','',1,0,1,1),(25,'Delete news','Deduct points when registered user remove a news.','com_community','group.news.remove','',1,0,1,1),(26,'Remove Wall','Deduct points to original poster when registered user remove a wall.','com_community','wall.remove','',1,0,1,1),(27,'Remove Photo album','Deduct points when registered user remove a photo album.','com_community','album.remove','',1,0,1,1),(28,'Remove photos','Deduct points when registered user remove a photo.','com_community','photo.remove','',1,0,1,1),(29,'Update Event','Give points when registered user update the event.','com_community','events.update','',1,1,1,1);
/*!40000 ALTER TABLE `nstest_community_userpoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_users`
--

DROP TABLE IF EXISTS `nstest_community_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_users` (
  `userid` int(11) NOT NULL,
  `status` text NOT NULL,
  `status_access` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL,
  `posted_on` datetime NOT NULL,
  `avatar` text NOT NULL,
  `thumb` text NOT NULL,
  `cover` text NOT NULL,
  `invite` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `friends` text NOT NULL,
  `groups` text NOT NULL,
  `events` text NOT NULL,
  `friendcount` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `storage` varchar(64) NOT NULL DEFAULT 'file',
  `watermark_hash` varchar(255) NOT NULL,
  `search_email` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_users`
--

LOCK TABLES `nstest_community_users` WRITE;
/*!40000 ALTER TABLE `nstest_community_users` DISABLE KEYS */;
INSERT INTO `nstest_community_users` VALUES (868,'',0,0,'0000-00-00 00:00:00','images/avatar/fb2fb08d05c20e55480806bb.jpg','images/avatar/thumb_fb2fb08d05c20e55480806bb.jpg','images/cover/profile/868/dabb019f50b98c651a075b5e64b388e0.jpg',0,'{\"notifyEmailSystem\":1,\"privacyProfileView\":0,\"privacyPhotoView\":0,\"privacyFriendsView\":0,\"privacyGroupsView\":\"\",\"privacyVideoView\":0,\"notifyEmailMessage\":1,\"notifyEmailApps\":1,\"notifyWallComment\":0,\"notif_groups_notify_admin\":1,\"etype_groups_notify_admin\":1,\"notif_user_profile_delete\":1,\"etype_user_profile_delete\":1,\"notif_system_reports_threshold\":1,\"etype_system_reports_threshold\":1,\"notif_profile_activity_add_comment\":1,\"etype_profile_activity_add_comment\":1,\"notif_profile_activity_reply_comment\":1,\"etype_profile_activity_reply_comment\":1,\"notif_profile_status_update\":1,\"etype_profile_status_update\":1,\"notif_profile_like\":1,\"etype_profile_like\":1,\"notif_profile_stream_like\":1,\"etype_profile_stream_like\":1,\"notif_friends_request_connection\":1,\"etype_friends_request_connection\":1,\"notif_friends_create_connection\":1,\"etype_friends_create_connection\":1,\"notif_inbox_create_message\":1,\"etype_inbox_create_message\":1,\"notif_groups_invite\":1,\"etype_groups_invite\":1,\"notif_groups_discussion_reply\":1,\"etype_groups_discussion_reply\":1,\"notif_groups_wall_create\":1,\"etype_groups_wall_create\":1,\"notif_groups_create_discussion\":1,\"etype_groups_create_discussion\":1,\"notif_groups_create_news\":1,\"etype_groups_create_news\":1,\"notif_groups_create_album\":1,\"etype_groups_create_album\":1,\"notif_groups_create_video\":1,\"etype_groups_create_video\":1,\"notif_groups_create_event\":1,\"etype_groups_create_event\":1,\"notif_groups_sendmail\":1,\"etype_groups_sendmail\":1,\"notif_groups_member_approved\":1,\"etype_groups_member_approved\":1,\"notif_groups_member_join\":1,\"etype_groups_member_join\":1,\"notif_groups_notify_creator\":1,\"etype_groups_notify_creator\":1,\"notif_groups_discussion_newfile\":1,\"etype_groups_discussion_newfile\":1,\"notif_groups_activity_add_comment\":0,\"etype_groups_activity_add_comment\":0,\"notif_events_notify_admin\":1,\"etype_events_notify_admin\":1,\"notif_events_invite\":1,\"etype_events_invite\":1,\"notif_events_invitation_approved\":1,\"etype_events_invitation_approved\":1,\"notif_events_sendmail\":1,\"etype_events_sendmail\":1,\"notif_event_notify_creator\":0,\"etype_event_notify_creator\":0,\"notif_event_join_request\":1,\"etype_event_join_request\":1,\"notif_events_activity_add_comment\":0,\"etype_events_activity_add_comment\":0,\"notif_videos_submit_wall\":1,\"etype_videos_submit_wall\":1,\"notif_videos_reply_wall\":1,\"etype_videos_reply_wall\":1,\"notif_videos_tagging\":1,\"etype_videos_tagging\":1,\"notif_videos_like\":1,\"etype_videos_like\":1,\"notif_photos_submit_wall\":1,\"etype_photos_submit_wall\":1,\"notif_photos_reply_wall\":1,\"etype_photos_reply_wall\":1,\"notif_photos_tagging\":1,\"etype_photos_tagging\":1,\"notif_photos_like\":1,\"etype_photos_like\":1,\"notif_system_messaging\":1,\"etype_system_messaging\":1,\"postFacebookStatus\":1,\"daylightsavingoffset\":\"0\",\"lastnotificationlist\":\"2014-05-21 15:29:46\"}',0,'','','',0,'868:super-user',255.000000,255.000000,0,'file','',1);
/*!40000 ALTER TABLE `nstest_community_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_videos`
--

DROP TABLE IF EXISTS `nstest_community_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_videos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL DEFAULT 'file',
  `video_id` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `creator` int(11) unsigned NOT NULL,
  `creator_type` varchar(200) NOT NULL DEFAULT 'user',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `permissions` varchar(255) NOT NULL DEFAULT '0',
  `category_id` int(11) unsigned NOT NULL,
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '1',
  `featured` tinyint(3) NOT NULL DEFAULT '0',
  `duration` float unsigned DEFAULT '0',
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `thumb` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `groupid` int(11) unsigned NOT NULL DEFAULT '0',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `storage` varchar(64) NOT NULL DEFAULT 'file',
  `location` text NOT NULL,
  `latitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `longitude` float(10,6) NOT NULL DEFAULT '255.000000',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `idx_groupid` (`groupid`),
  KEY `idx_storage` (`storage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_videos`
--

LOCK TABLES `nstest_community_videos` WRITE;
/*!40000 ALTER TABLE `nstest_community_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_videos_category`
--

DROP TABLE IF EXISTS `nstest_community_videos_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_videos_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_videos_category`
--

LOCK TABLES `nstest_community_videos_category` WRITE;
/*!40000 ALTER TABLE `nstest_community_videos_category` DISABLE KEYS */;
INSERT INTO `nstest_community_videos_category` VALUES (1,0,'General','General video channel',1);
/*!40000 ALTER TABLE `nstest_community_videos_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_videos_tag`
--

DROP TABLE IF EXISTS `nstest_community_videos_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_videos_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `position` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_videos_tag`
--

LOCK TABLES `nstest_community_videos_tag` WRITE;
/*!40000 ALTER TABLE `nstest_community_videos_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_videos_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_community_wall`
--

DROP TABLE IF EXISTS `nstest_community_wall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_community_wall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contentid` int(10) unsigned NOT NULL DEFAULT '0',
  `post_by` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(45) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(45) NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contentid` (`contentid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_community_wall`
--

LOCK TABLES `nstest_community_wall` WRITE;
/*!40000 ALTER TABLE `nstest_community_wall` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_community_wall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_contact_details`
--

DROP TABLE IF EXISTS `nstest_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_contact_details`
--

LOCK TABLES `nstest_contact_details` WRITE;
/*!40000 ALTER TABLE `nstest_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_content`
--

DROP TABLE IF EXISTS `nstest_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_content`
--

LOCK TABLES `nstest_content` WRITE;
/*!40000 ALTER TABLE `nstest_content` DISABLE KEYS */;
INSERT INTO `nstest_content` VALUES (1,58,'Contact Information','contact-information','<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">For general inquiries, please contact our corporate headquarters at (555) 555-5555 or <a href=\"mailto:info@bitstew.com\" target=\"_blank\">info@nottinghamsquared.com</a>.</p>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">For sales or product information, please contact us at <a href=\"mailto:sales@bitstew.com\" target=\"_blank\">sales@nottinghamsquared.com</a></p>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">If you are an existing customer and require technical support, please contact <a href=\"mailto:support@bitstew.com\" target=\"_blank\">support@nottinghamsquared.com</a></p>\r\n<h3 style=\"font-size: 1.17em; color: #333333; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Send us a message</h3>','',0,8,'2014-04-11 15:22:46',868,'','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','2014-04-11 15:22:46','0000-00-00 00:00:00','{\"image_intro\":\"\",\"float_intro\":\"\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"\",\"float_fulltext\":\"\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}','{\"urla\":false,\"urlatext\":\"\",\"targeta\":\"\",\"urlb\":false,\"urlbtext\":\"\",\"targetb\":\"\",\"urlc\":false,\"urlctext\":\"\",\"targetc\":\"\"}','{\"show_title\":\"\",\"link_titles\":\"\",\"show_tags\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_vote\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"urls_position\":\"\",\"alternative_readmore\":\"\",\"article_layout\":\"\",\"show_publishing_options\":\"\",\"show_article_options\":\"\",\"show_urls_images_backend\":\"\",\"show_urls_images_frontend\":\"\"}',1,3,'','',1,0,'{\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}',0,'*',''),(2,59,'Product & Services','product-services','<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">Widespread adoption of social and mobile technology is having a profound impact on how companies interact with customers, employees and stakeholders across the supply chain. A more connected marketplace has made managing business more complicated. Massive amounts of data now available to the business are both a problem to address and an opportunity to pursue.</p>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">These changes are forcing enterprise-wide digital transformation with information technology moving from solely a back office support function to a critical interaction point. The standard approaches to application development and management no longer suffice as the message to be more agile and deliver solutions faster with higher quality outcomes at a lower price—is now stronger than ever.</p>\r\n<ul style=\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">\r\n<li>Human Capital\r\n<ul>\r\n<li>SAP</li>\r\n<li>Oracle</li>\r\n<li>Itron</li>\r\n<li>L&amp;G</li>\r\n<li>Elster</li>\r\n<li>Smart Grid</li>\r\n</ul>\r\n</li>\r\n<li>Consulting Services (on-shore and off-shore)\r\n<ul>\r\n<li>SAP</li>\r\n<li>Oracle</li>\r\n<li>Itron</li>\r\n<li>L&amp;G</li>\r\n<li>Elster</li>\r\n<li>Smart Grid</li>\r\n<li>Cyber Security</li>\r\n<li>Analystics</li>\r\n</ul>\r\n</li>\r\n<li>Outsourcing / Managed Services (on-shore and off-shore)\r\n<ul>\r\n<li>Help Desk</li>\r\n<li>Entire IT Department</li>\r\n<li>application management</li>\r\n<li>application development</li>\r\n<li>SaaS</li>\r\n</ul>\r\n</li>\r\n</ul>','',0,8,'2014-04-11 15:23:55',868,'','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','2014-04-11 15:23:55','0000-00-00 00:00:00','{\"image_intro\":\"\",\"float_intro\":\"\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"\",\"float_fulltext\":\"\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}','{\"urla\":false,\"urlatext\":\"\",\"targeta\":\"\",\"urlb\":false,\"urlbtext\":\"\",\"targetb\":\"\",\"urlc\":false,\"urlctext\":\"\",\"targetc\":\"\"}','{\"show_title\":\"\",\"link_titles\":\"\",\"show_tags\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_vote\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"urls_position\":\"\",\"alternative_readmore\":\"\",\"article_layout\":\"\",\"show_publishing_options\":\"\",\"show_article_options\":\"\",\"show_urls_images_backend\":\"\",\"show_urls_images_frontend\":\"\"}',1,2,'','',1,0,'{\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}',0,'*',''),(3,60,'Industry Expertise','industry-expertise','<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">Excelling in technology is more important than ever in the new global economy.   Partnering with a proven resource that gives your organization a competitive advantage has never been more important.  Nottingham Squared provides a broad, deep spectrum of knowledge around information technology.  We have the best and brightest minds in North and South America working on the most complex issues in multiple industries.  See how we can help you meet your strategic goals and objectives. </p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td> <img src=\"images/notthingamsquared/8554301672_f76436a9ca_b.jpg\" alt=\"\" width=\"288\" height=\"133\" /></td>\r\n<td>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Utilities</h4>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">We provide strong reliable servicies...</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td> <img src=\"images/notthingamsquared/Work.1.png\" alt=\"\" width=\"297\" height=\"91\" /></td>\r\n<td>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Oil &amp; Energy</h4>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">We provide strong reliable servicies...</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td> <img src=\"images/notthingamsquared/catedral.png\" alt=\"\" width=\"291\" height=\"89\" /></td>\r\n<td>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Healthcare</h4>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">We provide strong reliable servicies...</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td> <img src=\"images/notthingamsquared/TechTiles.png\" alt=\"\" width=\"291\" height=\"89\" /></td>\r\n<td>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Financial Services</h4>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">We provide strong reliable servicies...</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td> <img src=\"images/notthingamsquared/Solder.png\" alt=\"\" width=\"288\" height=\"88\" /></td>\r\n<td>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Manufacturing</h4>\r\n<p style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">We provide strong reliable servicies...</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>','',0,8,'2014-04-11 16:39:23',868,'','2014-04-11 16:55:49',868,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','{\"image_intro\":\"\",\"float_intro\":\"\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"\",\"float_fulltext\":\"\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}','{\"urla\":false,\"urlatext\":\"\",\"targeta\":\"\",\"urlb\":false,\"urlbtext\":\"\",\"targetb\":\"\",\"urlc\":false,\"urlctext\":\"\",\"targetc\":\"\"}','{\"show_title\":\"\",\"link_titles\":\"\",\"show_tags\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_vote\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"urls_position\":\"\",\"alternative_readmore\":\"\",\"article_layout\":\"\",\"show_publishing_options\":\"\",\"show_article_options\":\"\",\"show_urls_images_backend\":\"\",\"show_urls_images_frontend\":\"\"}',3,1,'','',1,0,'{\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}',0,'*',''),(4,61,'About Us','about-us','<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Mission Statement</h4>\r\n<p class=\"MsoNoSpacing\" style=\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\"><span style=\"font-size: 10.0pt; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;\">Partnering with our clients to give their overall business a strategic competitive advantage through Information Technology.<span>  </span>Bringing our partners the best and brightest minds from multiple industries giving their Information Technology organization a fresh perspective.</span></p>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Our Team</h4>\r\n<ul style=\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">\r\n<li>Members</li>\r\n</ul>\r\n<h4 style=\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\">Partners</h4>\r\n<ul style=\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\">\r\n<li>Partners</li>\r\n</ul>','',1,8,'2014-04-11 16:56:26',868,'','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','2014-04-11 16:56:26','0000-00-00 00:00:00','{\"image_intro\":\"\",\"float_intro\":\"\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"\",\"float_fulltext\":\"\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}','{\"urla\":false,\"urlatext\":\"\",\"targeta\":\"\",\"urlb\":false,\"urlbtext\":\"\",\"targetb\":\"\",\"urlc\":false,\"urlctext\":\"\",\"targetc\":\"\"}','{\"show_title\":\"\",\"link_titles\":\"\",\"show_tags\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_vote\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"urls_position\":\"\",\"alternative_readmore\":\"\",\"article_layout\":\"\",\"show_publishing_options\":\"\",\"show_article_options\":\"\",\"show_urls_images_backend\":\"\",\"show_urls_images_frontend\":\"\"}',1,0,'','',1,0,'{\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}',0,'*',''),(5,110,'Intranet Publicada','intranet-publicada','<p><img src=\"images/banners/shadow_image_106722.png\" alt=\"\" width=\"956\" height=\"410\" /></p>\r\n<p>&nbsp;</p>','',1,17,'2014-05-30 14:00:19',868,'','2014-06-04 15:21:27',868,0,'0000-00-00 00:00:00','2014-05-30 14:00:19','0000-00-00 00:00:00','{\"image_intro\":\"\",\"float_intro\":\"\",\"image_intro_alt\":\"\",\"image_intro_caption\":\"\",\"image_fulltext\":\"\",\"float_fulltext\":\"\",\"image_fulltext_alt\":\"\",\"image_fulltext_caption\":\"\"}','{\"urla\":false,\"urlatext\":\"\",\"targeta\":\"\",\"urlb\":false,\"urlbtext\":\"\",\"targetb\":\"\",\"urlc\":false,\"urlctext\":\"\",\"targetc\":\"\"}','{\"show_title\":\"\",\"link_titles\":\"\",\"show_tags\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_vote\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"urls_position\":\"\",\"alternative_readmore\":\"\",\"article_layout\":\"\",\"show_publishing_options\":\"\",\"show_article_options\":\"\",\"show_urls_images_backend\":\"\",\"show_urls_images_frontend\":\"\"}',2,0,'','',1,0,'{\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}',1,'*','');
/*!40000 ALTER TABLE `nstest_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_content_frontpage`
--

DROP TABLE IF EXISTS `nstest_content_frontpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_content_frontpage`
--

LOCK TABLES `nstest_content_frontpage` WRITE;
/*!40000 ALTER TABLE `nstest_content_frontpage` DISABLE KEYS */;
INSERT INTO `nstest_content_frontpage` VALUES (5,1);
/*!40000 ALTER TABLE `nstest_content_frontpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_content_rating`
--

DROP TABLE IF EXISTS `nstest_content_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_content_rating`
--

LOCK TABLES `nstest_content_rating` WRITE;
/*!40000 ALTER TABLE `nstest_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_content_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_content_types`
--

DROP TABLE IF EXISTS `nstest_content_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_content_types` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_title` varchar(255) NOT NULL DEFAULT '',
  `type_alias` varchar(255) NOT NULL DEFAULT '',
  `table` varchar(255) NOT NULL DEFAULT '',
  `rules` text NOT NULL,
  `field_mappings` text NOT NULL,
  `router` varchar(255) NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) DEFAULT NULL COMMENT 'JSON string for com_contenthistory options',
  PRIMARY KEY (`type_id`),
  KEY `idx_alias` (`type_alias`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_content_types`
--

LOCK TABLES `nstest_content_types` WRITE;
/*!40000 ALTER TABLE `nstest_content_types` DISABLE KEYS */;
INSERT INTO `nstest_content_types` VALUES (1,'Article','com_content.article','{\"special\":{\"dbtable\":\"#__content\",\"key\":\"id\",\"type\":\"Content\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"state\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"introtext\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"attribs\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"urls\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"asset_id\"}, \"special\":{\"fulltext\":\"fulltext\"}}','ContentHelperRoute::getArticleRoute','{\"formFile\":\"administrator\\/components\\/com_content\\/models\\/forms\\/article.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(2,'Weblink','com_weblinks.weblink','{\"special\":{\"dbtable\":\"#__weblinks\",\"key\":\"id\",\"type\":\"Weblink\",\"prefix\":\"WeblinksTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"state\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"urls\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"null\"}, \"special\":{}}','WeblinksHelperRoute::getWeblinkRoute','{\"formFile\":\"administrator\\/components\\/com_weblinks\\/models\\/forms\\/weblink.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"featured\",\"images\"], \"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\"], \"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"], \"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(3,'Contact','com_contact.contact','{\"special\":{\"dbtable\":\"#__contact_details\",\"key\":\"id\",\"type\":\"Contact\",\"prefix\":\"ContactTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"address\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"image\", \"core_urls\":\"webpage\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"null\"}, \"special\":{\"con_position\":\"con_position\",\"suburb\":\"suburb\",\"state\":\"state\",\"country\":\"country\",\"postcode\":\"postcode\",\"telephone\":\"telephone\",\"fax\":\"fax\",\"misc\":\"misc\",\"email_to\":\"email_to\",\"default_con\":\"default_con\",\"user_id\":\"user_id\",\"mobile\":\"mobile\",\"sortname1\":\"sortname1\",\"sortname2\":\"sortname2\",\"sortname3\":\"sortname3\"}}','ContactHelperRoute::getContactRoute','{\"formFile\":\"administrator\\/components\\/com_contact\\/models\\/forms\\/contact.xml\",\"hideFields\":[\"default_con\",\"checked_out\",\"checked_out_time\",\"version\",\"xreference\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"], \"displayLookup\":[ {\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ] }'),(4,'Newsfeed','com_newsfeeds.newsfeed','{\"special\":{\"dbtable\":\"#__newsfeeds\",\"key\":\"id\",\"type\":\"Newsfeed\",\"prefix\":\"NewsfeedsTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"link\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"null\"}, \"special\":{\"numarticles\":\"numarticles\",\"cache_time\":\"cache_time\",\"rtl\":\"rtl\"}}','NewsfeedsHelperRoute::getNewsfeedRoute','{\"formFile\":\"administrator\\/components\\/com_newsfeeds\\/models\\/forms\\/newsfeed.xml\",\"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(5,'User','com_users.user','{\"special\":{\"dbtable\":\"#__users\",\"key\":\"id\",\"type\":\"User\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"null\",\"core_alias\":\"username\",\"core_created_time\":\"registerdate\",\"core_modified_time\":\"lastvisitDate\",\"core_body\":\"null\", \"core_hits\":\"null\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"access\":\"null\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"null\", \"core_language\":\"null\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"null\", \"core_ordering\":\"null\", \"core_metakey\":\"null\", \"core_metadesc\":\"null\", \"core_catid\":\"null\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{}}','UsersHelperRoute::getUserRoute',''),(6,'Article Category','com_content.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','ContentHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(7,'Contact Category','com_contact.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','ContactHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(8,'Newsfeeds Category','com_newsfeeds.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','NewsfeedsHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(9,'Weblinks Category','com_weblinks.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','WeblinksHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(10,'Tag','com_tags.tag','{\"special\":{\"dbtable\":\"#__tags\",\"key\":\"tag_id\",\"type\":\"Tag\",\"prefix\":\"TagsTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"urls\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"null\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\"}}','TagsHelperRoute::getTagRoute','{\"formFile\":\"administrator\\/components\\/com_tags\\/models\\/forms\\/tag.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\", \"lft\", \"rgt\", \"level\", \"path\", \"urls\", \"publish_up\", \"publish_down\"],\"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}]}'),(11,'Banner','com_banners.banner','{\"special\":{\"dbtable\":\"#__banners\",\"key\":\"id\",\"type\":\"Banner\",\"prefix\":\"BannersTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"description\", \"core_hits\":\"null\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"link\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{\"imptotal\":\"imptotal\", \"impmade\":\"impmade\", \"clicks\":\"clicks\", \"clickurl\":\"clickurl\", \"custombannercode\":\"custombannercode\", \"cid\":\"cid\", \"purchase_type\":\"purchase_type\", \"track_impressions\":\"track_impressions\", \"track_clicks\":\"track_clicks\"}}','','{\"formFile\":\"administrator\\/components\\/com_banners\\/models\\/forms\\/banner.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\", \"reset\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"imptotal\", \"impmade\", \"reset\"], \"convertToInt\":[\"publish_up\", \"publish_down\", \"ordering\"], \"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"cid\",\"targetTable\":\"#__banner_clients\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(12,'Banners Category','com_banners.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\": {\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"], \"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(13,'Banner Client','com_banners.client','{\"special\":{\"dbtable\":\"#__banner_clients\",\"key\":\"id\",\"type\":\"Client\",\"prefix\":\"BannersTable\"}}','','','','{\"formFile\":\"administrator\\/components\\/com_banners\\/models\\/forms\\/client.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\"], \"ignoreChanges\":[\"checked_out\", \"checked_out_time\"], \"convertToInt\":[], \"displayLookup\":[]}'),(14,'User Notes','com_users.note','{\"special\":{\"dbtable\":\"#__user_notes\",\"key\":\"id\",\"type\":\"Note\",\"prefix\":\"UsersTable\"}}','','','','{\"formFile\":\"administrator\\/components\\/com_users\\/models\\/forms\\/note.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\", \"publish_up\", \"publish_down\"],\"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\"], \"convertToInt\":[\"publish_up\", \"publish_down\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}]}'),(15,'User Notes Category','com_users.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"], \"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}');
/*!40000 ALTER TABLE `nstest_content_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_contentitem_tag_map`
--

DROP TABLE IF EXISTS `nstest_contentitem_tag_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_contentitem_tag_map` (
  `type_alias` varchar(255) NOT NULL DEFAULT '',
  `core_content_id` int(10) unsigned NOT NULL COMMENT 'PK from the core content table',
  `content_item_id` int(11) NOT NULL COMMENT 'PK from the content type table',
  `tag_id` int(10) unsigned NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint(8) NOT NULL COMMENT 'PK from the content_type table',
  UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`content_item_id`,`tag_id`),
  KEY `idx_tag_type` (`tag_id`,`type_id`),
  KEY `idx_date_id` (`tag_date`,`tag_id`),
  KEY `idx_tag` (`tag_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_core_content_id` (`core_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maps items from content tables to tags';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_contentitem_tag_map`
--

LOCK TABLES `nstest_contentitem_tag_map` WRITE;
/*!40000 ALTER TABLE `nstest_contentitem_tag_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_contentitem_tag_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_core_log_searches`
--

DROP TABLE IF EXISTS `nstest_core_log_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_core_log_searches`
--

LOCK TABLES `nstest_core_log_searches` WRITE;
/*!40000 ALTER TABLE `nstest_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_core_log_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_acl`
--

DROP TABLE IF EXISTS `nstest_discuss_acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_acl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `public` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `discuss_post_acl_action` (`action`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_acl`
--

LOCK TABLES `nstest_discuss_acl` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_acl` DISABLE KEYS */;
INSERT INTO `nstest_discuss_acl` VALUES (1,'add_reply',1,'COM_EASYDISCUSS_ACL_OPTION_ADD_REPLY_DESC',1,0,1),(2,'add_question',1,'COM_EASYDISCUSS_ACL_OPTION_ADD_QUESTION_DESC',1,0,1),(3,'add_attachment',1,'COM_EASYDISCUSS_ACL_OPTION_ADD_ATTACHMENT_DESC',1,0,1),(4,'add_tag',1,'COM_EASYDISCUSS_ACL_OPTION_ADD_TAG_DESC',1,0,1),(5,'edit_reply',0,'COM_EASYDISCUSS_ACL_OPTION_EDIT_REPLY_DESC',1,0,0),(6,'delete_reply',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_REPLY_DESC',1,0,0),(7,'mark_answered',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_ANSWERED_DESC',1,0,0),(8,'lock_discussion',0,'COM_EASYDISCUSS_ACL_OPTION_LOCK_DISCUSSION_DESC',1,0,0),(9,'edit_question',0,'COM_EASYDISCUSS_ACL_OPTION_EDIT_QUESTION_DESC',1,0,0),(10,'delete_question',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_QUESTION_DESC',1,0,0),(11,'delete_attachment',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_ATTACHMENT_DESC',1,0,0),(12,'add_comment',0,'COM_EASYDISCUSS_ACL_OPTION_ADD_COMMENT_DESC',1,0,1),(13,'delete_comment',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_COMMENT_DESC',1,0,0),(14,'feature_post',0,'COM_EASYDISCUSS_ACL_OPTION_FEATURE_POST_DESC',1,0,0),(15,'send_report',0,'COM_EASYDISCUSS_ACL_OPTION_SEND_REPORT_DESC',1,0,1),(16,'mark_on_hold',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_ON_HOLD_DESC',1,0,0),(17,'mark_accepted',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_ACCEPTED_DESC',1,0,0),(18,'mark_working_on',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_WORKING_ON_DESC',1,0,0),(19,'mark_rejected',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_REJECTED_DESC',1,0,0),(20,'mark_no_status',0,'COM_EASYDISCUSS_ACL_OPTION_MARK_NO_STATUS_DESC',1,0,0),(21,'edit_branch',0,'COM_EASYDISCUSS_ACL_OPTION_EDIT_BRANCH_DESC',1,0,0),(22,'show_signature',0,'COM_EASYDISCUSS_ACL_OPTION_SHOW_SIGNATURE_DESC',1,0,1),(23,'delete_own_question',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_OWN_QUESTION_DESC',1,0,0),(24,'delete_own_replies',0,'COM_EASYDISCUSS_ACL_OPTION_DELETE_OWN_REPLIES_DESC',1,0,0);
/*!40000 ALTER TABLE `nstest_discuss_acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_acl_group`
--

DROP TABLE IF EXISTS `nstest_discuss_acl_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_acl_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `acl_id` bigint(20) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_post_acl_content_type` (`content_id`,`type`),
  KEY `discuss_post_acl` (`acl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_acl_group`
--

LOCK TABLES `nstest_discuss_acl_group` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_acl_group` DISABLE KEYS */;
INSERT INTO `nstest_discuss_acl_group` VALUES (1,1,1,0,'group'),(2,1,2,0,'group'),(3,1,3,0,'group'),(4,1,4,0,'group'),(5,1,5,0,'group'),(6,1,6,0,'group'),(7,1,7,0,'group'),(8,1,8,0,'group'),(9,1,9,0,'group'),(10,1,10,0,'group'),(11,1,11,0,'group'),(12,1,12,0,'group'),(13,1,13,0,'group'),(14,1,14,0,'group'),(15,1,15,0,'group'),(16,1,16,0,'group'),(17,1,17,0,'group'),(18,1,18,0,'group'),(19,1,19,0,'group'),(20,1,20,0,'group'),(21,1,21,0,'group'),(22,1,22,0,'group'),(23,1,23,0,'group'),(24,1,24,0,'group'),(25,9,1,1,'group'),(26,9,2,1,'group'),(27,9,3,1,'group'),(28,9,4,1,'group'),(29,9,5,1,'group'),(30,9,6,0,'group'),(31,9,7,0,'group'),(32,9,8,0,'group'),(33,9,9,0,'group'),(34,9,10,0,'group'),(35,9,11,0,'group'),(36,9,12,0,'group'),(37,9,13,0,'group'),(38,9,14,0,'group'),(39,9,15,0,'group'),(40,9,16,0,'group'),(41,9,17,0,'group'),(42,9,18,0,'group'),(43,9,19,0,'group'),(44,9,20,0,'group'),(45,9,21,0,'group'),(46,9,22,0,'group'),(47,9,23,0,'group'),(48,9,24,0,'group'),(49,6,1,1,'group'),(50,6,2,1,'group'),(51,6,3,1,'group'),(52,6,4,1,'group'),(53,6,5,1,'group'),(54,6,6,0,'group'),(55,6,7,0,'group'),(56,6,8,0,'group'),(57,6,9,0,'group'),(58,6,10,0,'group'),(59,6,11,0,'group'),(60,6,12,0,'group'),(61,6,13,0,'group'),(62,6,14,0,'group'),(63,6,15,0,'group'),(64,6,16,0,'group'),(65,6,17,0,'group'),(66,6,18,0,'group'),(67,6,19,0,'group'),(68,6,20,0,'group'),(69,6,21,0,'group'),(70,6,22,0,'group'),(71,6,23,0,'group'),(72,6,24,0,'group'),(73,7,1,1,'group'),(74,7,2,1,'group'),(75,7,3,1,'group'),(76,7,4,1,'group'),(77,7,5,1,'group'),(78,7,6,1,'group'),(79,7,7,1,'group'),(80,7,8,1,'group'),(81,7,9,1,'group'),(82,7,10,1,'group'),(83,7,11,1,'group'),(84,7,12,1,'group'),(85,7,13,1,'group'),(86,7,14,1,'group'),(87,7,15,1,'group'),(88,7,16,1,'group'),(89,7,17,1,'group'),(90,7,18,1,'group'),(91,7,19,1,'group'),(92,7,20,1,'group'),(93,7,21,1,'group'),(94,7,22,1,'group'),(95,7,23,1,'group'),(96,7,24,1,'group'),(97,2,1,1,'group'),(98,2,2,1,'group'),(99,2,3,1,'group'),(100,2,4,1,'group'),(101,2,5,1,'group'),(102,2,6,0,'group'),(103,2,7,0,'group'),(104,2,8,0,'group'),(105,2,9,0,'group'),(106,2,10,0,'group'),(107,2,11,0,'group'),(108,2,12,0,'group'),(109,2,13,0,'group'),(110,2,14,0,'group'),(111,2,15,0,'group'),(112,2,16,0,'group'),(113,2,17,0,'group'),(114,2,18,0,'group'),(115,2,19,0,'group'),(116,2,20,0,'group'),(117,2,21,0,'group'),(118,2,22,0,'group'),(119,2,23,0,'group'),(120,2,24,0,'group'),(121,3,1,1,'group'),(122,3,2,1,'group'),(123,3,3,1,'group'),(124,3,4,1,'group'),(125,3,5,1,'group'),(126,3,6,0,'group'),(127,3,7,0,'group'),(128,3,8,0,'group'),(129,3,9,0,'group'),(130,3,10,0,'group'),(131,3,11,0,'group'),(132,3,12,0,'group'),(133,3,13,0,'group'),(134,3,14,0,'group'),(135,3,15,0,'group'),(136,3,16,0,'group'),(137,3,17,0,'group'),(138,3,18,0,'group'),(139,3,19,0,'group'),(140,3,20,0,'group'),(141,3,21,0,'group'),(142,3,22,0,'group'),(143,3,23,0,'group'),(144,3,24,0,'group'),(145,4,1,1,'group'),(146,4,2,1,'group'),(147,4,3,1,'group'),(148,4,4,1,'group'),(149,4,5,1,'group'),(150,4,6,0,'group'),(151,4,7,0,'group'),(152,4,8,0,'group'),(153,4,9,0,'group'),(154,4,10,0,'group'),(155,4,11,0,'group'),(156,4,12,0,'group'),(157,4,13,0,'group'),(158,4,14,0,'group'),(159,4,15,0,'group'),(160,4,16,0,'group'),(161,4,17,0,'group'),(162,4,18,0,'group'),(163,4,19,0,'group'),(164,4,20,0,'group'),(165,4,21,0,'group'),(166,4,22,0,'group'),(167,4,23,0,'group'),(168,4,24,0,'group'),(169,5,1,1,'group'),(170,5,2,1,'group'),(171,5,3,1,'group'),(172,5,4,1,'group'),(173,5,5,1,'group'),(174,5,6,0,'group'),(175,5,7,0,'group'),(176,5,8,0,'group'),(177,5,9,0,'group'),(178,5,10,0,'group'),(179,5,11,0,'group'),(180,5,12,0,'group'),(181,5,13,0,'group'),(182,5,14,0,'group'),(183,5,15,0,'group'),(184,5,16,0,'group'),(185,5,17,0,'group'),(186,5,18,0,'group'),(187,5,19,0,'group'),(188,5,20,0,'group'),(189,5,21,0,'group'),(190,5,22,0,'group'),(191,5,23,0,'group'),(192,5,24,0,'group'),(193,8,1,1,'group'),(194,8,2,1,'group'),(195,8,3,1,'group'),(196,8,4,1,'group'),(197,8,5,1,'group'),(198,8,6,1,'group'),(199,8,7,1,'group'),(200,8,8,1,'group'),(201,8,9,1,'group'),(202,8,10,1,'group'),(203,8,11,1,'group'),(204,8,12,1,'group'),(205,8,13,1,'group'),(206,8,14,1,'group'),(207,8,15,1,'group'),(208,8,16,1,'group'),(209,8,17,1,'group'),(210,8,18,1,'group'),(211,8,19,1,'group'),(212,8,20,1,'group'),(213,8,21,1,'group'),(214,8,22,1,'group'),(215,8,23,1,'group'),(216,8,24,1,'group');
/*!40000 ALTER TABLE `nstest_discuss_acl_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_assignment_map`
--

DROP TABLE IF EXISTS `nstest_discuss_assignment_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_assignment_map` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `assignee_id` bigint(20) unsigned NOT NULL,
  `assigner_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_assignment_map`
--

LOCK TABLES `nstest_discuss_assignment_map` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_assignment_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_assignment_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_attachments`
--

DROP TABLE IF EXISTS `nstest_discuss_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` text NOT NULL,
  `type` varchar(200) NOT NULL,
  `path` text NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  `mime` text NOT NULL,
  `size` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_attachments`
--

LOCK TABLES `nstest_discuss_attachments` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_badges`
--

DROP TABLE IF EXISTS `nstest_discuss_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_badges` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rule_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `avatar` text NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  `rule_limit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_badges_alias` (`alias`),
  KEY `discuss_badges_published` (`published`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_badges`
--

LOCK TABLES `nstest_discuss_badges` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_badges` DISABLE KEYS */;
INSERT INTO `nstest_discuss_badges` VALUES (1,1,'Motivator','motivator','Voted replies 100 times.','motivator.png','2014-05-14 14:00:45',1,100),(2,2,'Hole-in-One','hole-in-one','Accepted 50 replies as answers.','hole-in-one.png','2014-05-14 14:00:45',1,50),(3,3,'Smile Seeker','busybody','Liked 100 discussions.','busybody.png','2014-05-14 14:00:45',1,100),(4,4,'Love Fool','love-fool','Liked 100 replies.','love-fool.png','2014-05-14 14:00:45',1,100),(5,5,'Vanity Monster','vanity-monster','Updated 5 avatars in profile.','vanity-monster.png','2014-05-14 14:00:45',1,5),(6,6,'Sherlock Holmes','sherlock-holmes','Started 10 discussions.','sherlock-holmes.png','2014-05-14 14:00:45',1,10),(7,7,'The Voice','the-voice','Posted 100 replies.','the-voice.png','2014-05-14 14:00:45',1,100),(8,8,'Bookworm','bookworm','Read 50 discussions.','bookworm.png','2014-05-14 14:00:45',1,50),(9,9,'Peacemaker','peacemaker','Updated 50 discussions to resolved.','peacemaker.png','2014-05-14 14:00:45',1,50),(10,10,'Attention!','attention','Updated profile 50 times.','attention.png','2014-05-14 14:00:45',1,50),(11,11,'Firestarter','firestarter','Posted 100 comments.','firestarter.png','2014-05-14 14:00:45',1,100);
/*!40000 ALTER TABLE `nstest_discuss_badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_badges_history`
--

DROP TABLE IF EXISTS `nstest_discuss_badges_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_badges_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `command` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_badges_history`
--

LOCK TABLES `nstest_discuss_badges_history` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_badges_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_badges_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_badges_rules`
--

DROP TABLE IF EXISTS `nstest_discuss_badges_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_badges_rules` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `command` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `callback` text NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_badges_rules`
--

LOCK TABLES `nstest_discuss_badges_rules` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_badges_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_badges_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_badges_users`
--

DROP TABLE IF EXISTS `nstest_discuss_badges_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_badges_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `badge_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  `custom` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `badge_id` (`badge_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_badges_users`
--

LOCK TABLES `nstest_discuss_badges_users` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_badges_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_badges_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_captcha`
--

DROP TABLE IF EXISTS `nstest_discuss_captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response` varchar(5) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_captcha`
--

LOCK TABLES `nstest_discuss_captcha` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_category`
--

DROP TABLE IF EXISTS `nstest_discuss_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `private` int(11) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `params` text NOT NULL,
  `container` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `discuss_cat_published` (`published`),
  KEY `discuss_cat_parentid` (`parent_id`),
  KEY `discuss_cat_mod_categories1` (`published`,`private`,`id`),
  KEY `discuss_cat_mod_categories2` (`published`,`private`,`ordering`),
  KEY `discuss_cat_acl` (`parent_id`,`published`,`ordering`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_category`
--

LOCK TABLES `nstest_discuss_category` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_category` DISABLE KEYS */;
INSERT INTO `nstest_discuss_category` VALUES (1,868,'General','','general','2014-05-14 14:00:44',0,1,0,NULL,0,2,1,0,1,2,'{\"show_description\":\"1\",\"maxlength\":\"0\",\"maxlength_size\":\"1000\",\"cat_notify_custom\":\"\",\"cat_email_parser\":\"Chelo\",\"cat_email_parser_password\":\"Selvat1974\",\"cat_email_parser_switch\":\"0\"}',0),(2,868,'Consultas Técnicas','','consultas-técnicas','2014-05-20 18:32:29',0,1,0,NULL,0,2,0,NULL,3,4,'{\"show_description\":\"1\",\"maxlength\":\"0\",\"maxlength_size\":\"1000\",\"cat_notify_custom\":\"marcelo.herrera@tmsgroup.com.ar\",\"cat_email_parser\":\"Chelo\",\"cat_email_parser_password\":\"Selvat1974\",\"cat_email_parser_switch\":\"0\"}',0),(3,868,'Gerencia de Aymará','','gerencia-de-aymará','2014-05-20 18:33:23',0,1,0,NULL,0,2,0,NULL,5,6,'{\"show_description\":\"1\",\"maxlength\":\"0\",\"maxlength_size\":\"1000\",\"cat_notify_custom\":\"\",\"cat_email_parser\":\"Chelo\",\"cat_email_parser_password\":\"Selvat1974\",\"cat_email_parser_switch\":\"0\"}',0);
/*!40000 ALTER TABLE `nstest_discuss_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_category_acl_item`
--

DROP TABLE IF EXISTS `nstest_discuss_category_acl_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_category_acl_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `description` text,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_category_acl_item`
--

LOCK TABLES `nstest_discuss_category_acl_item` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_category_acl_item` DISABLE KEYS */;
INSERT INTO `nstest_discuss_category_acl_item` VALUES (1,'select','can select the category during question creation.',1,1),(2,'view','can view the category posts.',1,1),(3,'reply','can reply to category posts.',1,1),(4,'viewreply','can view the category replies.',1,1),(5,'moderate','can moderate this category.',1,1);
/*!40000 ALTER TABLE `nstest_discuss_category_acl_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_category_acl_map`
--

DROP TABLE IF EXISTS `nstest_discuss_category_acl_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_category_acl_map` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) NOT NULL,
  `acl_id` bigint(20) NOT NULL,
  `type` varchar(25) NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `discuss_category_acl` (`category_id`),
  KEY `discuss_category_acl_id` (`acl_id`),
  KEY `discuss_content_type` (`content_id`,`type`),
  KEY `discuss_category_content_type` (`category_id`,`content_id`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_category_acl_map`
--

LOCK TABLES `nstest_discuss_category_acl_map` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_category_acl_map` DISABLE KEYS */;
INSERT INTO `nstest_discuss_category_acl_map` VALUES (1,2,1,'group',1,1),(2,2,1,'group',9,1),(3,2,1,'group',6,1),(4,2,1,'group',7,1),(5,2,1,'group',2,1),(6,2,1,'group',3,1),(7,2,1,'group',4,1),(8,2,1,'group',5,1),(9,2,1,'group',8,1),(10,2,2,'group',1,1),(11,2,2,'group',9,1),(12,2,2,'group',6,1),(13,2,2,'group',7,1),(14,2,2,'group',2,1),(15,2,2,'group',3,1),(16,2,2,'group',4,1),(17,2,2,'group',5,1),(18,2,2,'group',8,1),(19,2,3,'group',1,1),(20,2,3,'group',9,1),(21,2,3,'group',6,1),(22,2,3,'group',7,1),(23,2,3,'group',2,1),(24,2,3,'group',3,1),(25,2,3,'group',4,1),(26,2,3,'group',5,1),(27,2,3,'group',8,1),(28,2,4,'group',1,1),(29,2,4,'group',9,1),(30,2,4,'group',6,1),(31,2,4,'group',7,1),(32,2,4,'group',2,1),(33,2,4,'group',3,1),(34,2,4,'group',4,1),(35,2,4,'group',5,1),(36,2,4,'group',8,1),(37,3,1,'group',1,1),(38,3,1,'group',6,1),(39,3,1,'group',7,1),(40,3,1,'group',2,1),(41,3,1,'group',3,1),(42,3,1,'group',4,1),(43,3,1,'group',5,1),(44,3,1,'group',8,1),(45,1,1,'group',1,1),(46,1,1,'group',9,1),(47,1,1,'group',6,1),(48,1,1,'group',7,1),(49,1,1,'group',2,1),(50,1,1,'group',3,1),(51,1,1,'group',4,1),(52,1,1,'group',5,1),(53,1,1,'group',8,1);
/*!40000 ALTER TABLE `nstest_discuss_category_acl_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_comments`
--

DROP TABLE IF EXISTS `nstest_discuss_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment` text,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) unsigned DEFAULT '0',
  `ordering` tinyint(1) unsigned DEFAULT '0',
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `discuss_comment_postid` (`post_id`),
  KEY `discuss_comment_post_created` (`post_id`,`created`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_comments`
--

LOCK TABLES `nstest_discuss_comments` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_configs`
--

DROP TABLE IF EXISTS `nstest_discuss_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `params` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_configs`
--

LOCK TABLES `nstest_discuss_configs` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_configs` DISABLE KEYS */;
INSERT INTO `nstest_discuss_configs` VALUES (1,'config','main_moderatepost=0\nmain_allowcreatetag=1\nmain_allowvote=1\nmain_allowsticky=1\nmain_sitesubscription=1\nmain_postsubscription=1\nmain_autopostsubscription=1\nmain_allowguestsubscribe=1\nmain_mailqueueonpageload=0\nmain_filterbadword=1\nmain_filtertext=\"\"\nmain_comment=1\nmain_comment_tnc=1\nmain_comment_tnctext=\"You hereby agree with the following terms:\\n\\na. To accept full responsibility for the comment that you submit.\\nb. To use this function only for lawful purposes.\\nc. Not to post defamatory, abusive, offensive, racist, sexist, threatening, vulgar, obscene, hateful or otherwise inappropriate comments, or to post comments which will constitute a criminal offence or give rise to civil liability.\\nd. Not to post or make available any material which is protected by copyright, trade mark or other proprietary right without the express permission of the owner of the copyright, trade mark or any other proprietary right.\\ne. To evaluate for yourself the accuracy of any opinion, advice or other content.\"\nmain_comment_pagination=1\nmain_comment_pagination_count=5\nmain_report=0\nmain_reportthreshold=15\nmain_upload_maxsize=2000000\nmain_avatarpath=\"images/discuss_avatar/\"\nmain_categoryavatarpath=\"images/discuss_cavatar/\"\nmain_orphanitem_ownership=\"\"\nmain_syntax_highlighter=1\nmain_allowed_tags=\"a,abbr,acronym,address,area,b,big,blockquote,br,caption,center,cite,code,col,colgroup,dd,del,dfn,dir,div,dl,dt,em,fieldset,font,h1,h2,h3,h4,h5,h6,hr,i,img,input,ins,label,legend,li,map,menu,ol,optgroup,option,p,pre,q,s,select,small,span,strike,strong,sub,tfoot,th,thead,tr,tt,u,ul,sup,table,tbody,td\"\nmain_allowed_attr=\"abbr,accept,accept-charset,accesskey,action,align,alt,axis,border,cellpadding,cellspacing,char,charoff,charset,checked,cite,class,clear,cols,colspan,color,compact,coords,datetime,dir,disabled,enctype,for,frame,headers,height,href,hreflang,hspace,id,ismap,label,lang,longdesc,maxlength,media,method,multiple,name,nohref,noshade,nowrap,prompt,readonly,rel,rev,rows,rowspan,rules,scope,selected,shape,size,span,src,start,style,summary,tabindex,target,title,type,valign,value,vspace,width\"\nmain_notifications=1\nmain_notifications_limit=5\nmain_likes_replies=1\nmain_likes_discussions=1\nmain_notifications_interval=30\nmain_notifications_comments=1\nmain_ranking=1\nmain_ranking_calc_type=\"posts\"\nmain_tags=1\nintegration_aup=0\nmain_viewingpage=1\nmain_password_protection=1\nmain_rss=1\nmain_private_post=0\nmain_polls=1\nmain_polls_replies=0\nmain_polls_multiple=1\nmain_polls_avatars=0\nbbcode_video_width=350\nbbcode_video_height=350\nmain_similartopic=1\nmain_similartopic_limit=5\nmain_similartopic_privatepost=0\nmain_login_provider=\"joomla\"\nlayout_site_theme=\"simplistic\"\nlayout_site_theme_base=\"simplistic\"\nlayout_admin_theme=\"default\"\nlayout_admin_theme_base=\"default\"\nlayout_compile_mode=\"off\"\nlayout_compile_external_asset_path_type=\"relative\"\nlayout_compile_allow_template_override=1\nlayout_enabletoolbar=1\nlayout_toolbarsearch=1\nlayout_toolbartags=1\nlayout_toolbarcategories=1\nlayout_toolbardiscussion=1\nlayout_toolbarmoderate=1\nlayout_toolbarprofile=1\nlayout_toolbarlogin=1\nlayout_toolbarbadges=1\nlayout_toolbarfavourites=1\nlayout_dateformat=\"%A, %B %d %Y, %I:%M %p\"\nlayout_autominimisepost=-5\nlayout_daystostaynew=7\nlayout_nameformat=\"name\"\nlayout_ordering_category=\"ordering\"\nlayout_zero_as_plural=1\nlayout_featuredpost_limit=5\nlayout_featuredpost_style=0\nlayout_featuredpost_frontpage=1\nlayout_featuredpost_sort=\"date_latest\"\nlayout_list_limit=20\nlayout_category_description_hidden=0\nlayout_replies_sorting=\"oldest\"\nlayout_editor=\"bbcode\"\nlayout_category_stats=1\nlayout_category_tree=1\nlayout_user_online=1\nlayout_toolbar_searchbar=1\nlayout_toolbarcreate=1\nlayout_avatar=1\nlayout_avatar_in_post=1\nlayout_avatarwidth=160\nlayout_avatarheight=160\nlayout_avatarthumbwidth=60\nlayout_avatarthumbheight=60\nlayout_avatarIntegration=\"default\"\nlayout_avatarLinking=1\nlayout_phpbb_path=\"\"\nlayout_phpbb_url=\"\"\nnotify_admin=1\nnotify_owner=1\nnotify_subscriber=1\nnotify_owner_answer=1\nnotify_html_format=1\nnotify_custom=\"\"\nnotify_all=0\nnotify_participants=1\nmain_notifications_reply=1\nmain_notifications_locked=1\nmain_notifications_resolved=1\nmain_notifications_accepted=1\nintegration_twitter_enable=0\nintegration_twitter_consumer_key=\"335TmyRf0TOwcarqSa6vQ\"\nintegration_twitter_consumer_secret_key=\"oDX874XNdyM2UJSP9s6CerP8JQf1kdnY6TpW9zidNwM\"\nintegration_twitter_button=1\nintegration_twitter_button_style=\"vertical\"\nintegration_facebook_like_admin=\"\"\nintegration_facebook_like_appid=\"\"\nintegration_facebook_like=0\nintegration_facebook_like_send=0\nintegration_facebook_like_faces=0\nintegration_facebook_like_layout=\"box_count\"\nintegration_facebook_like_width=350\nintegration_facebook_like_verb=\"like\"\nintegration_facebook_like_theme=\"light\"\nintegration_googleone=1\nintegration_googleone_layout=\"tall\"\nintegration_googlebuzz=0\nintegration_pingomatic=0\nmain_badges=1\nintegration_jomsocial_toolbar=0\nintegration_jomsocial_activity_new_question=0\nintegration_jomsocial_activity_reply_question=0\nintegration_jomsocial_activity_reply_question_content=0\nintegration_jomsocial_activity_content_length=350\nintegration_jomsocial_activity_title_length=30\nintegration_jomsocial_points=0\nintegration_jomsocial_activity_likes=0\nintegration_jomsocial_activity_badges=0\nintegration_jomsocial_activity_ranks=0\nintegration_jomsocial_activity_comment=0\nintegration_toolbar_jomsocial_profile=0\nintegration_jomsocial_messaging=0\nantispam_akismet=0\nantispam_akismet_key=\"\"\nantispam_recaptcha=0\nantispam_recaptcha_ssl=0\nantispam_recaptcha_public=\"\"\nantispam_recaptcha_private=\"\"\nantispam_recaptcha_theme=\"clean\"\nantispam_recaptcha_lang=\"en\"\nantispam_recaptcha_registered_members=1\nantispam_skip_recaptcha=5\nattachment_questions=1\nattachment_maxsize=2\nattachment_path=\"attachments\"\nmain_attachment_extension=\"gif,jpg,png,zip,rar\"\nattachment_image_title=1\nattachment_limit=0\nenable_attachment_limit=0\nreply_field_references=1\nintegration_google_adsense_enable=1\nintegration_google_adsense_code=\"\"\nintegration_google_adsense_display=\"both\"\nintegration_google_adsense_display_access=\"both\"\nlayout_headers=0\nmain_title=\"EasyDiscuss\"\nmain_description=\"Social Collaboration Tool, powerful Joomla Forum Extension\"\nlayout_enableintrotext=0\nlayout_introtextlength=250\nmain_sef_unicode=1\nmain_sef_user=\"username\"\nlayout_toolbarusers=1\nmain_allowselfvote=1\nmain_allowquestionvote=1\nintegration_linkedin=1\nintegration_linkedin_button=\"vertical\"\nintegration_digg=1\nintegration_digg_button=\"medium\"\nmain_email_parser=0\nmain_email_parser_server=\"imap.gmail.com\"\nmain_email_parser_mailbox=\"INBOX\"\nmain_email_parser_port=993\nmain_email_parser_service=\"imap\"\nmain_email_parser_limit=10\nmain_email_parser_receipt=1\nmain_email_parser_validate=1\nmain_email_parser_ssl=1\nmain_email_parser_username=\"\"\nmain_email_parser_password=\"\"\nmain_email_parser_category=1\nmain_email_parser_moderation=0\nmain_autopost_twitter_message=\"New discussion created {title} {url} ...\"\nlayout_wrapper_sfx=\"\"\nintegration_facebook_scripts=1\nnotification_sender_name=\"\"\nnotification_sender_email=\"\"\nmain_content_trigger_posts=0\nmain_content_trigger_replies=0\nmain_content_trigger_comments=0\nsh_theme=\"googlecode\"\nmain_post_min_length=0\nmain_allowguestview_whovoted=0\nlayout_favourite_description_hidden=0\nmain_daystolock_afterlastreplied=0\nmain_daystolock_aftercreated=0\nmain_lock_newpost_only=1\nmain_mailqueuenumber=5\nmain_reference_link_new_window=1\nmain_qna=1\nmax_tags_allowed=10\nlayout_tags_listing=1\nlayout_replies_list_limit=\"20\"\nmail_reply_breaker=\"\"\nlayout_profile_roles=1\nlayout_enablefilter_new=1\nlayout_enablefilter_unresolved=1\nlayout_enablefilter_unanswered=1\nlayout_enablefilter_resolved=1\nnotifications_history=30\nprune_notifications_cron=1\nprune_notifications_onload=1\ntab_site_question=0\ntab_site_reply=0\ntab_site_access=\"\"\nmain_signature_visibility=1\nmain_maxview_vote=4\nmain_customfields_type=1\nmain_customfields=1\nmain_customfields_input=0\nmain_notification_max_length=0\nmain_location_discussion=1\nmain_location_reply=1\nmain_location_language=\"en\"\nmain_location_static=0\nmain_location_map_type=\"ROADMAP\"\nmain_location_default_zoom=5\nmain_location_min_zoom=3\nmain_location_max_zoom=10\nmain_location_map_width=450\nmain_location_map_height=300\nlayout_show_moderators=1\nmain_assign_user=1\nlayout_category_selection=\"select\"\neasydiscuss_environment=\"static\"\neasydiscuss_mode=\"compressed\"\nmain_favorite=1\nmain_allowguest_vote=0\nintegrations_easyblog_profile=1\nintegrations_komento_profile=1\nmain_conversations=1\nmain_conversations_notification=1\nmain_conversations_notification_interval=60\nmain_conversations_notification_items=10\nmain_routing=\"currentactive\"\nmain_routing_itemid=\"\"\nlayout_profile_showbiography=1\nlayout_profile_showaccount=1\nlayout_profile_showlocation=1\nlayout_profile_showurl=1\nmain_discussion_labels=1\nlayout_board_stats=1\nlayout_replies_pagination=\"1\"\nantispam_honeypot=\"0\"\nantispam_honeypot_key=\"\"\nantispam_honeypot_block=\"type\"\nantispam_honeypot_threatvalue=\"\"\nantispam_honeypot_threat_searchengine=\"0\"\nantispam_honeypot_threat_suspicious=\"0\"\nantispam_honeypot_threat_harvester=\"0\"\nantispam_honeypot_threat_spammer=\"0\"\nmain_allowdelete=1\nsystem_update_interval=30\nnotify_moderator=1\nnotify_admin_onreply=0\nnotify_moderator_onreply=0\nmain_link_new_window=0\nmain_backend_statistics=1\ndiscuss_debugjs=1\nlayout_originalavatarwidth=\"400\"\nlayout_originalavatarheight=\"400\"\nlayout_reply_editor=\"bbcode\"\nmain_polls_guests=\"0\"\nmain_polls_lock=\"1\"\nlayout_category_one_level=\"0\"\nmain_allowguest_vote_question=0\nmain_allowguest_vote_reply=0\nantispam_easydiscuss_captcha=0\nantispam_easydiscuss_captcha_registered=0\nlayout_profile_showsite=1\nlayout_profile_showsocial=1\nmain_master_tags=1\nmain_frontend_statistics=1\nmain_exclude_frontend_statistics=\"\"\nlayout_category_toggle=0\nmain_post_redirection=\"default\"\nmain_exclude_members=\"\"\nmain_responsive=1\nlayout_sort_category=\"asc\"\nlayout_toolbar_cat_filter=0\nmain_members_small=0\nlayout_ask_color=\"primary\"\nlayout_show_classic=0\nlayout_post_types=1\nmigrator_vBulletin_prefix=\"\"\nmain_moderateguestpost=0\nmain_enable_print=1\nlayout_show_all_subcategories=1\nmain_messages_limit=5\nmoderation_threshold=0\nmigrator_vBulletin_driver=\"\"\nmigrator_vBulletin_host=\"\"\nmigrator_vBulletin_user=\"\"\nmigrator_vBulletin_password=\"\"\nmigrator_vBulletin_name=\"\"\nintegration_googleshare=1\nintegration_googleshare_layout=\"bubble\"\nguest_usergroup=1\nintegration_easysocial_toolbar=1\nintegration_easysocial_toolbar_profile=1\nintegration_easysocial_messaging=1\nintegration_easysocial_activity_new_question=1\nintegration_easysocial_activity_reply_question=1\nintegration_easysocial_activity_content_length=350\nintegration_easysocial_activity_title_length=30\nintegration_easysocial_activity_comment=1\nintegration_easysocial_activity_likes=1\nintegration_easysocial_activity_badges=1\nintegration_easysocial_activity_ranks=1\nintegration_easysocial_activity_favourite=1\nintegration_easysocial_activity_vote=1\nintegration_easysocial_activity_accepted=1\nintegration_easysocial_notify_create=1\nintegration_easysocial_notify_reply=1\nintegration_easysocial_notify_comment=1\nintegration_easysocial_notify_accepted=1\nintegration_easysocial_notify_likes=1\nintegration_easysocial_points=1\nintegration_easysocial_popbox=1');
/*!40000 ALTER TABLE `nstest_discuss_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_conversations`
--

DROP TABLE IF EXISTS `nstest_discuss_conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_conversations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `lastreplied` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_conversations`
--

LOCK TABLES `nstest_discuss_conversations` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_conversations_message`
--

DROP TABLE IF EXISTS `nstest_discuss_conversations_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_conversations_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint(20) NOT NULL,
  `message` text,
  `created` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_conversations_message`
--

LOCK TABLES `nstest_discuss_conversations_message` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_conversations_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_conversations_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_conversations_message_maps`
--

DROP TABLE IF EXISTS `nstest_discuss_conversations_message_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_conversations_message_maps` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `conversation_id` bigint(20) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `isread` tinyint(1) NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `node_id` (`user_id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_conversations_message_maps`
--

LOCK TABLES `nstest_discuss_conversations_message_maps` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_conversations_message_maps` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_conversations_message_maps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_conversations_participants`
--

DROP TABLE IF EXISTS `nstest_discuss_conversations_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_conversations_participants` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_conversations_participants`
--

LOCK TABLES `nstest_discuss_conversations_participants` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_conversations_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_conversations_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_customfields`
--

DROP TABLE IF EXISTS `nstest_discuss_customfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_customfields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `params` text,
  `ordering` bigint(20) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_customfields`
--

LOCK TABLES `nstest_discuss_customfields` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_customfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_customfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_customfields_acl`
--

DROP TABLE IF EXISTS `nstest_discuss_customfields_acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_customfields_acl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `acl_published` tinyint(1) unsigned NOT NULL,
  `default` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_customfields_acl`
--

LOCK TABLES `nstest_discuss_customfields_acl` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_customfields_acl` DISABLE KEYS */;
INSERT INTO `nstest_discuss_customfields_acl` VALUES (1,'view','Who can view the custom fields at front end.',1,1),(2,'input','Who can input the custom fields at front end.',1,1);
/*!40000 ALTER TABLE `nstest_discuss_customfields_acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_customfields_rule`
--

DROP TABLE IF EXISTS `nstest_discuss_customfields_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_customfields_rule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` bigint(20) unsigned NOT NULL,
  `acl_id` bigint(20) NOT NULL,
  `content_id` int(10) NOT NULL,
  `content_type` varchar(25) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cf_rule_field_id` (`field_id`),
  KEY `cf_rule_acl_types` (`content_type`,`acl_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_customfields_rule`
--

LOCK TABLES `nstest_discuss_customfields_rule` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_customfields_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_customfields_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_customfields_value`
--

DROP TABLE IF EXISTS `nstest_discuss_customfields_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_customfields_value` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` bigint(20) unsigned NOT NULL,
  `value` text NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cf_value_field_id` (`field_id`),
  KEY `cf_value_field_post` (`field_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_customfields_value`
--

LOCK TABLES `nstest_discuss_customfields_value` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_customfields_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_customfields_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_favourites`
--

DROP TABLE IF EXISTS `nstest_discuss_favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_favourites` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_favourites`
--

LOCK TABLES `nstest_discuss_favourites` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_favourites` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_favourites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_hashkeys`
--

DROP TABLE IF EXISTS `nstest_discuss_hashkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_hashkeys` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_hashkeys`
--

LOCK TABLES `nstest_discuss_hashkeys` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_hashkeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_hashkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_likes`
--

DROP TABLE IF EXISTS `nstest_discuss_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `discuss_content_type` (`type`,`content_id`),
  KEY `discuss_contentid` (`content_id`),
  KEY `discuss_createdby` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_likes`
--

LOCK TABLES `nstest_discuss_likes` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_mailq`
--

DROP TABLE IF EXISTS `nstest_discuss_mailq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_mailq` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mailfrom` varchar(255) DEFAULT NULL,
  `fromname` varchar(255) DEFAULT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ashtml` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_mailq_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_mailq`
--

LOCK TABLES `nstest_discuss_mailq` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_mailq` DISABLE KEYS */;
INSERT INTO `nstest_discuss_mailq` VALUES (1,'marcebarcelona@gmail.com','ns','marcelo.herrera@tmsgroup.com.ar','[#3]: New question asked - Será posible tener \"Dicussions\" en castellano?','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<link rel=\"stylesheet\" href=\"http://localhost/joomla32/components/com_easydiscuss/themes/simplistic/styles/style.css\" type=\"text/css\" />\n</head>\n\n<body style=\"margin:0;padding:0\">\n<div style=\"width:100%;background:#ddd;margin:0;padding:50px 0 80px;color:#798796;font-family:\'Lucida Grande\',Tahoma,Arial;font-size:11px;\">\n	<center>\n		<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:720px;background:#fff;border:1px solid #b5bbc1;border-bottom-color:#9ba3ab;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;\">\n			<tbody>\n				<tr>\n					<td style=\"padding:20px;border-bottom:1px solid #b5bbc1;;background:#f5f5f5;border-radius:3px 3px 0 0;-moz-border-radius:3px 3px 0 0;-webkit-border-radius:3px 3px 0 0;\">\n						<b style=\"font-family:Arial;font-size:17px;font-weight:bold;color:#333;display:inline-block;\">Aymara Intranet</b>\n					</td>\n				</tr>\n				<tr>\n					<td style=\"padding:15px 20px;line-height:19px;color:#555;font-family:\'Lucida Grande\',Tahoma,Arial;font-size:12px;text-align:left\">\n						<b>Marcelo Herrera - TMS Group</b> created a new discussion <b>Será posible tener \"Dicussions\" en castellano?</b>\n<br />\n<hr style=\"clear:both;margin:10px 0 15px;padding:0;border:0;border-top:1px solid #ddd\" />\n<img src=\"http://localhost/joomla32/images/discuss_avatar/868_2f4af95c6d33a815dd765f98ae6391ea.jpg\" width=\"80\" alt=\"Marcelo Herrera - TMS Group\" style=\"width:80px;height:80px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;float:left;margin:0 15px 0 0\" />\n	Sería bueno intentar descubrir traducciones en el paquete original.<br style=\"clear:both\" />\n<br />\n<br />\nYou may view the discussion by clicking on the button below.<div style=\"padding:20px;border-top:1px solid #ccc;padding:20px 0 10px;margin-top:20px;line-height:19px;color:#555;font-family:\'Lucida Grande\',Tahoma,Arial;font-size:12px;text-align:left\">\n	<div>\n	<!--[if mso]>\n	  <v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://localhost/joomla32/index.php/discussions/será-posible-tener-dicussions-en-castellano\" style=\"height:30px;padding-left:15px;padding-right:15px;v-text-anchor:middle;\" arcsize=\"7%\" strokecolor=\"#caa200\" fillcolor=\"#ffcc00\">\n	    <w:anchorlock/>\n	    <center style=\"color:#534200;font-family:sans-serif;font-size:13px;font-weight:bold;\">Read this discussion &nbsp; &raquo;</center>\n	  </v:roundrect>\n	<![endif]-->\n	<![if !mso]>\n	<a href=\"http://localhost/joomla32/index.php/discussions/será-posible-tener-dicussions-en-castellano\"\n	style=\"background-color:#ffcc00;border:1px solid #caa200;padding-left:15px;padding-right:15px;border-radius:2px;color:#534200;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:30px;text-align:center;text-decoration:none;-webkit-text-size-adjust:none;\" target=\"_blank\">Read this discussion &nbsp; &raquo;</a>\n	<![endif]>\n	</div>\n</div>\n\n\n\n					</td>\n				</tr>\n			</tbody>\n		</table>\n\n		\n			</center>\n</div>\n</body>\n</html>\n','2014-05-21 13:14:21',0,1);
/*!40000 ALTER TABLE `nstest_discuss_mailq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_migrators`
--

DROP TABLE IF EXISTS `nstest_discuss_migrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_migrators` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `internal_id` bigint(20) NOT NULL,
  `external_id` bigint(20) NOT NULL,
  `component` text NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_external_id` (`external_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_migrators`
--

LOCK TABLES `nstest_discuss_migrators` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_migrators` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_migrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_notifications`
--

DROP TABLE IF EXISTS `nstest_discuss_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `cid` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `target` bigint(20) NOT NULL,
  `author` bigint(20) NOT NULL,
  `permalink` text NOT NULL,
  `state` tinyint(4) NOT NULL,
  `favicon` text NOT NULL,
  `component` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_notification_created` (`created`),
  KEY `discuss_notification` (`target`,`state`,`cid`,`created`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_notifications`
--

LOCK TABLES `nstest_discuss_notifications` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_oauth`
--

DROP TABLE IF EXISTS `nstest_discuss_oauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_oauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `request_token` text NOT NULL,
  `access_token` text NOT NULL,
  `message` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_oauth_type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_oauth`
--

LOCK TABLES `nstest_discuss_oauth` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_oauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_oauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_oauth_posts`
--

DROP TABLE IF EXISTS `nstest_discuss_oauth_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_oauth_posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `oauth_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_oauth_posts`
--

LOCK TABLES `nstest_discuss_oauth_posts` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_oauth_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_oauth_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_points`
--

DROP TABLE IF EXISTS `nstest_discuss_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_points` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rule_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  `rule_limit` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_points_rule` (`rule_id`),
  KEY `discuss_points_published` (`published`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_points`
--

LOCK TABLES `nstest_discuss_points` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_points` DISABLE KEYS */;
INSERT INTO `nstest_discuss_points` VALUES (1,1,'Vote a reply','2014-05-14 14:00:45',1,1),(2,2,'Reply accepted as answer','2014-05-14 14:00:45',1,1),(3,3,'Like a discussion','2014-05-14 14:00:45',1,1),(4,4,'Like a reply','2014-05-14 14:00:45',1,1),(5,5,'Updates profile picture','2014-05-14 14:00:45',1,1),(6,6,'New Discussion','2014-05-14 14:00:45',1,2),(7,7,'New Reply','2014-05-14 14:00:45',1,1),(8,8,'Read a discusison','2014-05-14 14:00:45',1,0),(9,9,'Update discussion to resolved','2014-05-14 14:00:45',1,0),(10,10,'Updates profile','2014-05-14 14:00:45',1,0),(11,11,'New Comment','2014-05-14 14:00:45',1,1),(12,12,'Unlike a discussion','2014-05-14 14:00:45',1,-1),(13,13,'Unlike a reply','2014-05-14 14:00:45',1,-1),(14,14,'Remove a reply','2014-05-14 14:00:45',1,0),(15,15,'Vote an answer','2014-05-14 14:00:45',1,1),(16,16,'Unvote an answer','2014-05-14 14:00:45',1,-1),(17,17,'Vote a question','2014-05-14 14:00:45',1,1),(18,18,'Unvote a question','2014-05-14 14:00:45',1,-1),(19,19,'Unvote a reply','2014-05-14 14:00:45',1,-1);
/*!40000 ALTER TABLE `nstest_discuss_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_polls`
--

DROP TABLE IF EXISTS `nstest_discuss_polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_polls` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `value` text NOT NULL,
  `count` bigint(20) NOT NULL DEFAULT '0',
  `multiple_polls` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `polls_posts` (`post_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_polls`
--

LOCK TABLES `nstest_discuss_polls` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_polls_question`
--

DROP TABLE IF EXISTS `nstest_discuss_polls_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_polls_question` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `multiple` tinyint(1) DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_polls_question`
--

LOCK TABLES `nstest_discuss_polls_question` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_polls_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_polls_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_polls_users`
--

DROP TABLE IF EXISTS `nstest_discuss_polls_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_polls_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `poll_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_polls_users`
--

LOCK TABLES `nstest_discuss_polls_users` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_polls_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_polls_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_post_types`
--

DROP TABLE IF EXISTS `nstest_discuss_post_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_post_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_alias` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_post_types`
--

LOCK TABLES `nstest_discuss_post_types` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_post_types` DISABLE KEYS */;
INSERT INTO `nstest_discuss_post_types` VALUES (1,'Bug','','2014-05-14 14:00:45',1,'bug'),(2,'Issue','','2014-05-14 14:00:45',1,'issue'),(3,'Task','','2014-05-14 14:00:45',1,'task');
/*!40000 ALTER TABLE `nstest_discuss_post_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_posts`
--

DROP TABLE IF EXISTS `nstest_discuss_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `alias` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `replied` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` longtext NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote` int(11) unsigned DEFAULT '0',
  `hits` int(11) unsigned DEFAULT '0',
  `islock` tinyint(1) unsigned DEFAULT '0',
  `lockdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `featured` tinyint(1) unsigned DEFAULT '0',
  `isresolve` tinyint(1) unsigned DEFAULT '0',
  `isreport` tinyint(1) unsigned DEFAULT '0',
  `answered` tinyint(1) unsigned DEFAULT '0',
  `user_id` bigint(20) unsigned DEFAULT '0',
  `parent_id` bigint(20) unsigned DEFAULT '0',
  `user_type` varchar(255) NOT NULL,
  `poster_name` varchar(255) NOT NULL,
  `poster_email` varchar(255) NOT NULL,
  `num_likes` int(11) DEFAULT '0',
  `num_negvote` int(11) DEFAULT '0',
  `sum_totalvote` int(11) DEFAULT '0',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `password` text,
  `legacy` tinyint(1) DEFAULT '1',
  `address` text,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `content_type` varchar(25) DEFAULT NULL,
  `post_status` tinyint(1) NOT NULL DEFAULT '0',
  `post_type` varchar(255) NOT NULL DEFAULT '0',
  `private` tinyint(3) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_post_published` (`published`),
  KEY `discuss_post_user_id` (`user_id`),
  KEY `discuss_post_vote` (`vote`),
  KEY `discuss_post_isreport` (`isreport`),
  KEY `discuss_post_answered` (`answered`),
  KEY `discuss_post_category` (`category_id`),
  KEY `discuss_post_query1` (`published`,`parent_id`,`answered`,`id`),
  KEY `discuss_post_query2` (`published`,`parent_id`,`answered`,`replied`),
  KEY `discuss_post_query3` (`published`,`parent_id`,`category_id`,`created`),
  KEY `discuss_post_query4` (`published`,`parent_id`,`category_id`,`id`),
  KEY `discuss_post_query5` (`published`,`parent_id`,`created`),
  KEY `discuss_post_query6` (`published`,`parent_id`,`id`),
  KEY `unread_category_posts` (`published`,`parent_id`,`legacy`,`category_id`,`id`),
  KEY `discuss_post_last_reply` (`parent_id`,`id`),
  KEY `idx_post_type` (`post_type`),
  KEY `discuss_post_parentid` (`published`,`parent_id`),
  FULLTEXT KEY `discuss_post_titlecontent` (`title`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_posts`
--

LOCK TABLES `nstest_discuss_posts` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_posts` DISABLE KEYS */;
INSERT INTO `nstest_discuss_posts` VALUES (3,'Será posible tener \"Dicussions\" en castellano?','será-posible-tener-dicussions-en-castellano','2014-05-21 13:14:21','2014-05-21 13:14:21','2014-05-21 13:14:21','Sería bueno intentar descubrir traducciones en el paquete original.',1,0,0,2,0,'0000-00-00 00:00:00',0,0,0,0,868,0,'member','','',0,0,0,2,'','',0,'','','','bbcode',0,'task',0,'::1');
/*!40000 ALTER TABLE `nstest_discuss_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_posts_labels`
--

DROP TABLE IF EXISTS `nstest_discuss_posts_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_posts_labels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` bigint(20) NOT NULL DEFAULT '0',
  `creator` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_posts_labels`
--

LOCK TABLES `nstest_discuss_posts_labels` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_posts_labels` DISABLE KEYS */;
INSERT INTO `nstest_discuss_posts_labels` VALUES (1,'New','New',1,0,0,'0000-00-00 00:00:00'),(2,'Accepted','Accepted',1,0,0,'0000-00-00 00:00:00'),(3,'In Progress','In Progress',1,0,0,'0000-00-00 00:00:00'),(4,'Completed','Completed',1,0,0,'0000-00-00 00:00:00'),(5,'Invalid','Invalid',1,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `nstest_discuss_posts_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_posts_labels_map`
--

DROP TABLE IF EXISTS `nstest_discuss_posts_labels_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_posts_labels_map` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `post_label_id` bigint(20) unsigned NOT NULL,
  `creator_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_posts_labels_map`
--

LOCK TABLES `nstest_discuss_posts_labels_map` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_posts_labels_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_posts_labels_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_posts_references`
--

DROP TABLE IF EXISTS `nstest_discuss_posts_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_posts_references` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `reference_id` bigint(20) NOT NULL,
  `extension` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`reference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_posts_references`
--

LOCK TABLES `nstest_discuss_posts_references` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_posts_references` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_posts_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_posts_tags`
--

DROP TABLE IF EXISTS `nstest_discuss_posts_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_posts_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `tag_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_tag` (`post_id`,`tag_id`),
  KEY `discuss_posts_tags_tagid` (`tag_id`),
  KEY `discuss_posts_tags_postid` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_posts_tags`
--

LOCK TABLES `nstest_discuss_posts_tags` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_posts_tags` DISABLE KEYS */;
INSERT INTO `nstest_discuss_posts_tags` VALUES (3,3,5);
/*!40000 ALTER TABLE `nstest_discuss_posts_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_ranks`
--

DROP TABLE IF EXISTS `nstest_discuss_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_ranks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `start` bigint(20) NOT NULL DEFAULT '0',
  `end` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `discuss_ranks_range` (`start`,`end`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_ranks`
--

LOCK TABLES `nstest_discuss_ranks` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_ranks` DISABLE KEYS */;
INSERT INTO `nstest_discuss_ranks` VALUES (1,'New Member',1,50),(2,'Junior Member',51,150),(3,'Senior Member',151,350),(4,'Expert Member',351,600);
/*!40000 ALTER TABLE `nstest_discuss_ranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_ranks_users`
--

DROP TABLE IF EXISTS `nstest_discuss_ranks_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_ranks_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rank_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ranks_users` (`rank_id`,`user_id`),
  KEY `ranks_id` (`rank_id`),
  KEY `ranks_userid` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_ranks_users`
--

LOCK TABLES `nstest_discuss_ranks_users` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_ranks_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_ranks_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_reports`
--

DROP TABLE IF EXISTS `nstest_discuss_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `reason` text,
  `created_by` bigint(20) unsigned DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `discuss_reports_post` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_reports`
--

LOCK TABLES `nstest_discuss_reports` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_roles`
--

DROP TABLE IF EXISTS `nstest_discuss_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `usergroup_id` int(10) unsigned NOT NULL,
  `colorcode` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` bigint(20) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_roles`
--

LOCK TABLES `nstest_discuss_roles` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_rules`
--

DROP TABLE IF EXISTS `nstest_discuss_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_rules` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `command` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `callback` text NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_rules_command` (`command`(255))
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_rules`
--

LOCK TABLES `nstest_discuss_rules` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_rules` DISABLE KEYS */;
INSERT INTO `nstest_discuss_rules` VALUES (1,'easydiscuss.vote.reply','Vote a reply','This rule allows you to assign a badge for a user when they vote a reply.','','2014-05-14 14:00:45',1),(2,'easydiscuss.answer.reply','Reply accepted as answer','This rule allows you to assign a badge for a user when their reply is accepted as an answer.','','2014-05-14 14:00:45',1),(3,'easydiscuss.like.discussion','Like a discussion','This rule allows you to assign a badge for a user when they like a discussion.','','2014-05-14 14:00:45',1),(4,'easydiscuss.like.reply','Like a reply','This rule allows you to assign a badge for a user when they like a reply.','','2014-05-14 14:00:45',1),(5,'easydiscuss.new.avatar','Updates profile picture','This rule allows you to assign a badge for a user when they upload a profile picture.','','2014-05-14 14:00:45',1),(6,'easydiscuss.new.discussion','New Discussion','This rule allows you to assign a badge for a user when they create a new discussion.','','2014-05-14 14:00:45',1),(7,'easydiscuss.new.reply','New Reply','This rule allows you to assign a badge for a user when they reply to discussion.','','2014-05-14 14:00:45',1),(8,'easydiscuss.read.discussion','Read a discusison','This rule allows you to assign a badge for a user when they read a discussion.','','2014-05-14 14:00:45',1),(9,'easydiscuss.resolved.discussion','Update discussion to resolved','This rule allows you to assign a badge for a user when they mark their discussion as resolved.','','2014-05-14 14:00:45',1),(10,'easydiscuss.update.profile','Updates profile','This rule allows you to assign a badge for a user when they update their profile.','','2014-05-14 14:00:45',1),(11,'easydiscuss.new.comment','New Comment','This rule allows you to assign a badge for a user when they create a new comment.','','2014-05-14 14:00:45',1),(12,'easydiscuss.unlike.discussion','Unlike a discussion','This rule allows you to deduct points for a user when they unlike a discussion.','','2014-05-14 14:00:45',1),(13,'easydiscuss.unlike.reply','Unlike a reply','This rule allows you to deduct points for a user when they unlike a reply.','','2014-05-14 14:00:45',1),(14,'easydiscuss.remove.reply','Remove a reply','This rule allows you to assign a badge for a user when they remove a reply.','','2014-05-14 14:00:45',1),(15,'easydiscuss.vote.answer','Vote an answer','This rule allows you to assign points for a user when they vote an answer.','','2014-05-14 14:00:45',1),(16,'easydiscuss.unvote.answer','Unvote an answer','This rule allows you to assign points for a user when they vote down an answer.','','2014-05-14 14:00:45',1),(17,'easydiscuss.vote.question','Vote a question','This rule allows you to assign points for a user when they vote a question.','','2014-05-14 14:00:45',1),(18,'easydiscuss.unvote.question','Unvote a question','This rule allows you to assign points for a user when they vote down a question.','','2014-05-14 14:00:45',1),(19,'easydiscuss.unvote.reply','Unvote a reply','This rule allows you to assign a badge or points for a user when they vote down a reply.','','2014-05-14 14:00:45',1);
/*!40000 ALTER TABLE `nstest_discuss_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_subscription`
--

DROP TABLE IF EXISTS `nstest_discuss_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_subscription` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `member` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT 'daily',
  `cid` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `interval` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `sent_out` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_subscription`
--

LOCK TABLES `nstest_discuss_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_tags`
--

DROP TABLE IF EXISTS `nstest_discuss_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `published` tinyint(1) unsigned DEFAULT '0',
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_tags_alias` (`alias`),
  KEY `discuss_tags_user_id` (`user_id`),
  KEY `discuss_tags_published` (`published`),
  KEY `discuss_tags_query1` (`published`,`id`),
  FULLTEXT KEY `discuss_tags_title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_tags`
--

LOCK TABLES `nstest_discuss_tags` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_tags` DISABLE KEYS */;
INSERT INTO `nstest_discuss_tags` VALUES (1,'General','general','2014-05-14 14:00:44',1,868),(2,'Automotive','automotive','2014-05-14 14:00:44',1,868),(3,'Sharing','sharing','2014-05-14 14:00:44',1,868),(4,'Info','info','2014-05-14 14:00:44',1,868),(5,'Discussions','discussions','2014-05-14 14:00:44',1,868),(6,'Thank You','thank-you','2014-05-14 14:00:44',1,868),(7,'Congratulations','congratulations','2014-05-14 14:00:44',1,868);
/*!40000 ALTER TABLE `nstest_discuss_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_users`
--

DROP TABLE IF EXISTS `nstest_discuss_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_users` (
  `id` bigint(20) unsigned NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `params` text,
  `alias` varchar(255) DEFAULT NULL,
  `points` bigint(20) NOT NULL DEFAULT '0',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `location` text NOT NULL,
  `signature` text NOT NULL,
  `edited` text NOT NULL,
  `posts_read` text,
  `site` text,
  PRIMARY KEY (`id`),
  KEY `discuss_users_alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_users`
--

LOCK TABLES `nstest_discuss_users` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_users` DISABLE KEYS */;
INSERT INTO `nstest_discuss_users` VALUES (868,'Marcelo','868_2f4af95c6d33a815dd765f98ae6391ea.jpg','Mi nombre es Marcelo Herrera, soy Gerente de Operaciones de TMS Group. \r\nEstoy a disposición de ustedes!\r\n\r\nGracias por confiar en TMS Group.','http://','{\"facebook\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"skype\":\"\",\"website\":\"Chelo\"}','marcelo',3,'','','','','1','a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}','{\"siteUrl\":\"\",\"siteUsername\":\"\",\"sitePassword\":\"\",\"ftpUrl\":\"\",\"ftpUsername\":\"\",\"ftpPassword\":\"\",\"optional\":\"\"}'),(870,'Alejandro Weber','default.png','','','','aweber',0,NULL,NULL,'','','',NULL,NULL);
/*!40000 ALTER TABLE `nstest_discuss_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_users_history`
--

DROP TABLE IF EXISTS `nstest_discuss_users_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_users_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `command` text NOT NULL,
  `created` datetime NOT NULL,
  `content_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_users_history`
--

LOCK TABLES `nstest_discuss_users_history` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_users_history` DISABLE KEYS */;
INSERT INTO `nstest_discuss_users_history` VALUES (1,868,'Blog post, Congratulations! You have successfully installed EasyBlog! deleted.','easyblog.delete.blog','2014-05-20 17:59:21',0),(2,868,'Updated their profile picture','easydiscuss.new.avatar','2014-05-20 18:29:18',0),(3,868,'Updated their profile','easydiscuss.update.profile','2014-05-20 18:29:18',0),(4,868,'Updated their profile','easydiscuss.update.profile','2014-05-20 18:30:07',0),(5,868,'Updated their profile','easydiscuss.update.profile','2014-05-20 18:30:33',0),(6,868,'Created a new discussion Será posible tener \"Dicussions\" en castellano?','easydiscuss.new.discussion','2014-05-21 13:14:21',3);
/*!40000 ALTER TABLE `nstest_discuss_users_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_views`
--

DROP TABLE IF EXISTS `nstest_discuss_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_views` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_views`
--

LOCK TABLES `nstest_discuss_views` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_views` DISABLE KEYS */;
INSERT INTO `nstest_discuss_views` VALUES (1,868,'5c3c2c1d74ba31bd6622a13de00610a8','2014-06-03 12:28:26','::1');
/*!40000 ALTER TABLE `nstest_discuss_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_discuss_votes`
--

DROP TABLE IF EXISTS `nstest_discuss_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_discuss_votes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `ipaddress` varchar(15) DEFAULT NULL,
  `value` tinyint(2) DEFAULT '0',
  `session_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discuss_user_post` (`user_id`,`post_id`),
  KEY `discuss_post_id` (`post_id`),
  KEY `discuss_user_id` (`user_id`),
  KEY `discuss_session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_discuss_votes`
--

LOCK TABLES `nstest_discuss_votes` WRITE;
/*!40000 ALTER TABLE `nstest_discuss_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_discuss_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_attendees`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_attendees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_attendees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `attend_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remind_time` int(11) NOT NULL,
  `remind_type` tinyint(1) NOT NULL DEFAULT '1',
  `reminder_sent_date` datetime DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `processor` varchar(255) DEFAULT NULL,
  `net_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_percent` float DEFAULT NULL,
  `txn_type` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `idx_notify` (`reminder_sent_date`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_attendees`
--

LOCK TABLES `nstest_dpcalendar_attendees` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_attendees` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_attendees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_caldav_calendarobjects`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_caldav_calendarobjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_caldav_calendarobjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `calendardata` mediumblob,
  `uri` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `calendarid` int(10) unsigned NOT NULL,
  `lastmodified` int(11) unsigned DEFAULT NULL,
  `etag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) unsigned NOT NULL,
  `componenttype` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstoccurence` int(11) unsigned DEFAULT NULL,
  `lastoccurence` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calendarid` (`calendarid`,`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_caldav_calendarobjects`
--

LOCK TABLES `nstest_dpcalendar_caldav_calendarobjects` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_calendarobjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_calendarobjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_caldav_calendars`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_caldav_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_caldav_calendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `principaluri` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctag` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `calendarorder` int(10) unsigned NOT NULL DEFAULT '0',
  `calendarcolor` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `components` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `transparent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `principaluri` (`principaluri`,`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_caldav_calendars`
--

LOCK TABLES `nstest_dpcalendar_caldav_calendars` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_caldav_groupmembers`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_caldav_groupmembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_caldav_groupmembers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `principal_id` (`principal_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_caldav_groupmembers`
--

LOCK TABLES `nstest_dpcalendar_caldav_groupmembers` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_groupmembers` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_groupmembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_caldav_principals`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_caldav_principals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_caldav_principals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayname` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vcardurl` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uri` (`uri`),
  KEY `external_id` (`external_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_caldav_principals`
--

LOCK TABLES `nstest_dpcalendar_caldav_principals` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_principals` DISABLE KEYS */;
INSERT INTO `nstest_dpcalendar_caldav_principals` VALUES (1,'principals/Chelo','marcebarcelona@gmail.com','Marcelo Herrera - TMS Group',NULL,868),(2,'principals/Chelo/calendar-proxy-read','marcebarcelona@gmail.com','Marcelo Herrera - TMS Group',NULL,868),(3,'principals/Chelo/calendar-proxy-write','marcebarcelona@gmail.com','Marcelo Herrera - TMS Group',NULL,868),(4,'principals/dnieto','diego.nieto@tmsgroup.com.ar','Diego Nieto',NULL,869),(5,'principals/dnieto/calendar-proxy-read','diego.nieto@tmsgroup.com.ar','Diego Nieto',NULL,869),(6,'principals/dnieto/calendar-proxy-write','diego.nieto@tmsgroup.com.ar','Diego Nieto',NULL,869),(7,'principals/aweber','alejandro.weber@tmsgroup.com.ar','Alejandro Weber',NULL,870),(8,'principals/aweber/calendar-proxy-read','alejandro.weber@tmsgroup.com.ar','Alejandro Weber',NULL,870),(9,'principals/aweber/calendar-proxy-write','alejandro.weber@tmsgroup.com.ar','Alejandro Weber',NULL,870);
/*!40000 ALTER TABLE `nstest_dpcalendar_caldav_principals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_events`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `original_id` int(11) DEFAULT NULL,
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `rrule` varchar(255) DEFAULT NULL,
  `recurrence_id` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `all_day` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `color` varchar(250) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `capacity` int(11) DEFAULT NULL,
  `capacity_used` int(11) DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` tinyint(1) NOT NULL DEFAULT '0',
  `ordertext` text NOT NULL,
  `orderurl` varchar(255) DEFAULT NULL,
  `canceltext` text NOT NULL,
  `cancelurl` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) NOT NULL DEFAULT '1',
  `access_content` int(11) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `plugintype` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_start_date` (`start_date`),
  KEY `idx_end_date` (`end_date`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_events`
--

LOCK TABLES `nstest_dpcalendar_events` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_events_location`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_events_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_events_location` (
  `event_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_events_location`
--

LOCK TABLES `nstest_dpcalendar_events_location` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_events_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_events_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_extcalendars`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_extcalendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_extcalendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `plugin` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(250) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `version` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_plugin` (`plugin`),
  KEY `idx_state` (`state`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_extcalendars`
--

LOCK TABLES `nstest_dpcalendar_extcalendars` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_extcalendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_extcalendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_dpcalendar_locations`
--

DROP TABLE IF EXISTS `nstest_dpcalendar_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_dpcalendar_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `province` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `room` varchar(255) NOT NULL DEFAULT '',
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `version` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_dpcalendar_locations`
--

LOCK TABLES `nstest_dpcalendar_locations` WRITE;
/*!40000 ALTER TABLE `nstest_dpcalendar_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_dpcalendar_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_acl`
--

DROP TABLE IF EXISTS `nstest_easyblog_acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_acl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_post_acl_action` (`action`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_acl`
--

LOCK TABLES `nstest_easyblog_acl` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_acl` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_acl` VALUES (1,'add_entry',1,'If allowed, user is allowed to post a new blog post.',1,0),(2,'publish_entry',1,'If allowed, user is allowed to publish their blog post on the site. ',1,0),(3,'allow_feedburner',1,'If allowed, user can set their own Feedburner URL which will be linked to their own blog.',1,0),(4,'upload_avatar',1,'If allowed, user can upload their avatar.',1,0),(5,'manage_comment',1,'If allowed, user can manage any comments that are posted throughout the site.',1,0),(6,'update_twitter',1,'If allowed, user can post updates to their own Twitter account.',1,0),(7,'update_tweetmeme',1,'If allowed, user can update Tweetmeme settings. **Deprecated**',0,0),(8,'delete_entry',1,'If allowed, user can delete their own blog post.',1,0),(9,'add_trackback',1,'If allowed, user can specify trackback urls when creating a new blog post.',1,0),(10,'contribute_frontpage',1,'If allowed, user can publish their blog post on the front page of EasyBlog.',1,0),(11,'create_category',1,'If allowed, user can create a new category on the site.',1,0),(12,'create_tag',1,'If allowed, user can create new tags on the site.',1,0),(13,'add_adsense',1,'If allowed, user can set their own Google Adsense codes.',1,0),(14,'allow_shortcode',1,'If allowed, user can use short code URLs. **Deprecated**',0,0),(15,'allow_rss',1,'If allowed, user can use use custom RSS. **Deprecated**',0,0),(16,'custom_template',1,'If allowed, user can use a custom template. **Deprecated**',0,0),(17,'enable_privacy',1,'If allowed, user can specify a custom privacy option for their blog posts.',1,0),(18,'allow_comment',1,'If allowed, user can post a comment on the site.',1,0),(19,'allow_subscription',1,'If allowed, user can subscribe to the blog on the site.',1,0),(20,'manage_pending',1,'If allowed, user can manage pending blog posts.',1,0),(21,'upload_image',1,'If allowed, user can upload new images via the media manager.',1,0),(23,'upload_cavatar',1,'If allowed, user can upload a new avatar for the category.',1,0),(24,'update_linkedin',1,'If allowed, user can post updates to their own LinkedIn account.',1,0),(25,'change_setting_comment',1,'If allowed, user can toggle the ability to comment on their blog post.',1,0),(26,'change_setting_subscription',1,'If allowed, user can toggle the ability to allow subscriptions for their blog post.',1,0),(27,'update_facebook',1,'If allowed, user can post updates to their own Facebook account.',1,0),(28,'delete_category',1,'If allowed, user can delete their category.',1,0),(29,'moderate_entry',1,'If allowed, user can moderate all blog entries from the site.',1,0),(30,'edit_comment',1,'If allowed, user can edit comments from their dashboard area.',1,0),(31,'delete_comment',1,'If allowed, user can delete comments on their blogs.',1,0),(32,'feature_entry',1,'If allowed, user can feature blog posts on the site.',1,0),(33,'media_places_album',1,'If allowed, user can utilize the Albums in media manager.',1,0),(34,'media_places_flickr',1,'If allowed, user can utilize Flickr in media manager.',1,0),(35,'media_places_shared',1,'If allowed, user can access the shared folder in media manager.',1,0),(36,'allow_seo',1,'If allowed, user can set custom SEO options e.g. meta description and meta keywords in their pages.',1,0),(37,'access_toolbar',1,'If allowed, user can view the toolbar on the site.',1,0);
/*!40000 ALTER TABLE `nstest_easyblog_acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_acl_filters`
--

DROP TABLE IF EXISTS `nstest_easyblog_acl_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_acl_filters` (
  `content_id` bigint(20) unsigned NOT NULL,
  `disallow_tags` text NOT NULL,
  `disallow_attributes` text NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_acl_filters`
--

LOCK TABLES `nstest_easyblog_acl_filters` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_acl_filters` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_acl_filters` VALUES (1,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(9,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(6,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(7,'','','group'),(2,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(3,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(4,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(5,'script,applet,iframe','onclick,onblur,onchange,onfocus,onreset,onselect,onsubmit,onabort,onkeydown,onkeypress,onkeyup,onmouseover,onmouseout,ondblclick,onmousemove,onmousedown,onmouseup,onerror,onload,onunload','group'),(8,'','','group');
/*!40000 ALTER TABLE `nstest_easyblog_acl_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_acl_group`
--

DROP TABLE IF EXISTS `nstest_easyblog_acl_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_acl_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `acl_id` bigint(20) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `easyblog_post_acl_content_type` (`content_id`,`type`),
  KEY `easyblog_post_acl` (`acl_id`),
  KEY `acl_grp_acl_type` (`acl_id`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_acl_group`
--

LOCK TABLES `nstest_easyblog_acl_group` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_acl_group` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_acl_group` VALUES (1,1,1,0,'group'),(2,1,2,0,'group'),(3,1,3,0,'group'),(4,1,4,0,'group'),(5,1,5,0,'group'),(6,1,6,0,'group'),(7,1,7,0,'group'),(8,1,8,0,'group'),(9,1,9,0,'group'),(10,1,10,0,'group'),(11,1,11,0,'group'),(12,1,12,0,'group'),(13,1,13,0,'group'),(14,1,14,0,'group'),(15,1,15,0,'group'),(16,1,16,0,'group'),(17,1,17,0,'group'),(18,1,18,0,'group'),(19,1,19,1,'group'),(20,1,20,0,'group'),(21,1,21,0,'group'),(22,1,23,0,'group'),(23,1,24,0,'group'),(24,1,25,0,'group'),(25,1,26,0,'group'),(26,1,27,0,'group'),(27,1,28,0,'group'),(28,1,29,0,'group'),(29,1,30,0,'group'),(30,1,31,0,'group'),(31,1,32,0,'group'),(32,1,33,0,'group'),(33,1,34,0,'group'),(34,1,35,0,'group'),(35,1,36,0,'group'),(36,1,37,1,'group'),(37,9,1,1,'group'),(38,9,2,1,'group'),(39,9,3,1,'group'),(40,9,4,1,'group'),(41,9,5,1,'group'),(42,9,6,1,'group'),(43,9,7,1,'group'),(44,9,8,1,'group'),(45,9,9,1,'group'),(46,9,10,1,'group'),(47,9,11,1,'group'),(48,9,12,1,'group'),(49,9,13,1,'group'),(50,9,14,1,'group'),(51,9,15,1,'group'),(52,9,16,1,'group'),(53,9,17,1,'group'),(54,9,18,1,'group'),(55,9,19,1,'group'),(56,9,20,0,'group'),(57,9,21,1,'group'),(58,9,23,1,'group'),(59,9,24,1,'group'),(60,9,25,1,'group'),(61,9,26,1,'group'),(62,9,27,1,'group'),(63,9,28,1,'group'),(64,9,29,0,'group'),(65,9,30,0,'group'),(66,9,31,0,'group'),(67,9,32,0,'group'),(68,9,33,1,'group'),(69,9,34,1,'group'),(70,9,35,1,'group'),(71,9,36,1,'group'),(72,9,37,1,'group'),(73,6,1,1,'group'),(74,6,2,1,'group'),(75,6,3,1,'group'),(76,6,4,1,'group'),(77,6,5,1,'group'),(78,6,6,1,'group'),(79,6,7,1,'group'),(80,6,8,1,'group'),(81,6,9,1,'group'),(82,6,10,1,'group'),(83,6,11,1,'group'),(84,6,12,1,'group'),(85,6,13,1,'group'),(86,6,14,1,'group'),(87,6,15,1,'group'),(88,6,16,1,'group'),(89,6,17,1,'group'),(90,6,18,1,'group'),(91,6,19,1,'group'),(92,6,20,0,'group'),(93,6,21,1,'group'),(94,6,23,1,'group'),(95,6,24,1,'group'),(96,6,25,1,'group'),(97,6,26,1,'group'),(98,6,27,1,'group'),(99,6,28,1,'group'),(100,6,29,0,'group'),(101,6,30,0,'group'),(102,6,31,0,'group'),(103,6,32,0,'group'),(104,6,33,1,'group'),(105,6,34,1,'group'),(106,6,35,1,'group'),(107,6,36,1,'group'),(108,6,37,1,'group'),(109,7,1,1,'group'),(110,7,2,1,'group'),(111,7,3,1,'group'),(112,7,4,1,'group'),(113,7,5,1,'group'),(114,7,6,1,'group'),(115,7,7,1,'group'),(116,7,8,1,'group'),(117,7,9,1,'group'),(118,7,10,1,'group'),(119,7,11,1,'group'),(120,7,12,1,'group'),(121,7,13,1,'group'),(122,7,14,1,'group'),(123,7,15,1,'group'),(124,7,16,1,'group'),(125,7,17,1,'group'),(126,7,18,1,'group'),(127,7,19,1,'group'),(128,7,20,1,'group'),(129,7,21,1,'group'),(130,7,23,1,'group'),(131,7,24,1,'group'),(132,7,25,1,'group'),(133,7,26,1,'group'),(134,7,27,1,'group'),(135,7,28,1,'group'),(136,7,29,1,'group'),(137,7,30,1,'group'),(138,7,31,1,'group'),(139,7,32,1,'group'),(140,7,33,1,'group'),(141,7,34,1,'group'),(142,7,35,1,'group'),(143,7,36,1,'group'),(144,7,37,1,'group'),(145,2,1,1,'group'),(146,2,2,1,'group'),(147,2,3,1,'group'),(148,2,4,1,'group'),(149,2,5,1,'group'),(150,2,6,1,'group'),(151,2,7,1,'group'),(152,2,8,1,'group'),(153,2,9,1,'group'),(154,2,10,1,'group'),(155,2,11,1,'group'),(156,2,12,1,'group'),(157,2,13,1,'group'),(158,2,14,1,'group'),(159,2,15,1,'group'),(160,2,16,1,'group'),(161,2,17,1,'group'),(162,2,18,1,'group'),(163,2,19,1,'group'),(164,2,20,0,'group'),(165,2,21,1,'group'),(166,2,23,1,'group'),(167,2,24,1,'group'),(168,2,25,1,'group'),(169,2,26,1,'group'),(170,2,27,1,'group'),(171,2,28,1,'group'),(172,2,29,0,'group'),(173,2,30,0,'group'),(174,2,31,0,'group'),(175,2,32,0,'group'),(176,2,33,1,'group'),(177,2,34,1,'group'),(178,2,35,1,'group'),(179,2,36,1,'group'),(180,2,37,1,'group'),(181,3,1,1,'group'),(182,3,2,1,'group'),(183,3,3,1,'group'),(184,3,4,1,'group'),(185,3,5,1,'group'),(186,3,6,1,'group'),(187,3,7,1,'group'),(188,3,8,1,'group'),(189,3,9,1,'group'),(190,3,10,1,'group'),(191,3,11,1,'group'),(192,3,12,1,'group'),(193,3,13,1,'group'),(194,3,14,1,'group'),(195,3,15,1,'group'),(196,3,16,1,'group'),(197,3,17,1,'group'),(198,3,18,1,'group'),(199,3,19,1,'group'),(200,3,20,0,'group'),(201,3,21,1,'group'),(202,3,23,1,'group'),(203,3,24,1,'group'),(204,3,25,1,'group'),(205,3,26,1,'group'),(206,3,27,1,'group'),(207,3,28,1,'group'),(208,3,29,0,'group'),(209,3,30,0,'group'),(210,3,31,0,'group'),(211,3,32,0,'group'),(212,3,33,1,'group'),(213,3,34,1,'group'),(214,3,35,1,'group'),(215,3,36,1,'group'),(216,3,37,1,'group'),(217,4,1,1,'group'),(218,4,2,1,'group'),(219,4,3,1,'group'),(220,4,4,1,'group'),(221,4,5,1,'group'),(222,4,6,1,'group'),(223,4,7,1,'group'),(224,4,8,1,'group'),(225,4,9,1,'group'),(226,4,10,1,'group'),(227,4,11,1,'group'),(228,4,12,1,'group'),(229,4,13,1,'group'),(230,4,14,1,'group'),(231,4,15,1,'group'),(232,4,16,1,'group'),(233,4,17,1,'group'),(234,4,18,1,'group'),(235,4,19,1,'group'),(236,4,20,0,'group'),(237,4,21,1,'group'),(238,4,23,1,'group'),(239,4,24,1,'group'),(240,4,25,1,'group'),(241,4,26,1,'group'),(242,4,27,1,'group'),(243,4,28,1,'group'),(244,4,29,0,'group'),(245,4,30,0,'group'),(246,4,31,0,'group'),(247,4,32,0,'group'),(248,4,33,1,'group'),(249,4,34,1,'group'),(250,4,35,1,'group'),(251,4,36,1,'group'),(252,4,37,1,'group'),(253,5,1,1,'group'),(254,5,2,1,'group'),(255,5,3,1,'group'),(256,5,4,1,'group'),(257,5,5,1,'group'),(258,5,6,1,'group'),(259,5,7,1,'group'),(260,5,8,1,'group'),(261,5,9,1,'group'),(262,5,10,1,'group'),(263,5,11,1,'group'),(264,5,12,1,'group'),(265,5,13,1,'group'),(266,5,14,1,'group'),(267,5,15,1,'group'),(268,5,16,1,'group'),(269,5,17,1,'group'),(270,5,18,1,'group'),(271,5,19,1,'group'),(272,5,20,0,'group'),(273,5,21,1,'group'),(274,5,23,1,'group'),(275,5,24,1,'group'),(276,5,25,1,'group'),(277,5,26,1,'group'),(278,5,27,1,'group'),(279,5,28,1,'group'),(280,5,29,0,'group'),(281,5,30,0,'group'),(282,5,31,0,'group'),(283,5,32,0,'group'),(284,5,33,1,'group'),(285,5,34,1,'group'),(286,5,35,1,'group'),(287,5,36,1,'group'),(288,5,37,1,'group'),(289,8,1,1,'group'),(290,8,2,1,'group'),(291,8,3,1,'group'),(292,8,4,1,'group'),(293,8,5,1,'group'),(294,8,6,1,'group'),(295,8,7,1,'group'),(296,8,8,1,'group'),(297,8,9,1,'group'),(298,8,10,1,'group'),(299,8,11,1,'group'),(300,8,12,1,'group'),(301,8,13,1,'group'),(302,8,14,1,'group'),(303,8,15,1,'group'),(304,8,16,1,'group'),(305,8,17,1,'group'),(306,8,18,1,'group'),(307,8,19,1,'group'),(308,8,20,1,'group'),(309,8,21,1,'group'),(310,8,23,1,'group'),(311,8,24,1,'group'),(312,8,25,1,'group'),(313,8,26,1,'group'),(314,8,27,1,'group'),(315,8,28,1,'group'),(316,8,29,1,'group'),(317,8,30,1,'group'),(318,8,31,1,'group'),(319,8,32,1,'group'),(320,8,33,1,'group'),(321,8,34,1,'group'),(322,8,35,1,'group'),(323,8,36,1,'group'),(324,8,37,1,'group');
/*!40000 ALTER TABLE `nstest_easyblog_acl_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_adsense`
--

DROP TABLE IF EXISTS `nstest_easyblog_adsense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_adsense` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `display` varchar(255) NOT NULL DEFAULT 'both',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_adsense`
--

LOCK TABLES `nstest_easyblog_adsense` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_adsense` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_adsense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_autoarticle_map`
--

DROP TABLE IF EXISTS `nstest_easyblog_autoarticle_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_autoarticle_map` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `content_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autoarticle_map_post_id` (`post_id`),
  KEY `autoarticle_map_content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_autoarticle_map`
--

LOCK TABLES `nstest_easyblog_autoarticle_map` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_autoarticle_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_autoarticle_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_blogger_subscription`
--

DROP TABLE IF EXISTS `nstest_easyblog_blogger_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_blogger_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blogger_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_blogger_subscription_blogger_id` (`blogger_id`),
  KEY `easyblog_blogger_subscription_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_blogger_subscription`
--

LOCK TABLES `nstest_easyblog_blogger_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_blogger_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_blogger_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_captcha`
--

DROP TABLE IF EXISTS `nstest_easyblog_captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response` varchar(5) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_captcha`
--

LOCK TABLES `nstest_easyblog_captcha` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_category`
--

DROP TABLE IF EXISTS `nstest_easyblog_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `private` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `level` int(11) unsigned DEFAULT '0',
  `lft` int(11) unsigned DEFAULT '0',
  `rgt` int(11) unsigned DEFAULT '0',
  `default` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_cat_published` (`published`),
  KEY `easyblog_cat_parentid` (`parent_id`),
  KEY `easyblog_cat_private` (`private`),
  KEY `easyblog_cat_lft` (`lft`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_category`
--

LOCK TABLES `nstest_easyblog_category` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_category` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_category` VALUES (1,868,'Uncategorized','','uncategorized',NULL,0,0,'2014-05-14 14:03:56',0,1,0,0,1,2,1);
/*!40000 ALTER TABLE `nstest_easyblog_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_category_acl`
--

DROP TABLE IF EXISTS `nstest_easyblog_category_acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_category_acl` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) NOT NULL,
  `acl_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_category_acl` (`category_id`),
  KEY `easyblog_category_acl_id` (`acl_id`),
  KEY `easyblog_content_type` (`content_id`,`type`),
  KEY `easyblog_category_content_type` (`category_id`,`content_id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_category_acl`
--

LOCK TABLES `nstest_easyblog_category_acl` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_category_acl` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_category_acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_category_acl_item`
--

DROP TABLE IF EXISTS `nstest_easyblog_category_acl_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_category_acl_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `description` text,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_category_acl_item`
--

LOCK TABLES `nstest_easyblog_category_acl_item` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_category_acl_item` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_category_acl_item` VALUES (1,'view','can view the category blog posts.',1,1),(2,'select','can select the category during blog post creation',1,1);
/*!40000 ALTER TABLE `nstest_easyblog_category_acl_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_category_subscription`
--

DROP TABLE IF EXISTS `nstest_easyblog_category_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_category_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_category_subscription_category_id` (`category_id`),
  KEY `easyblog_category_subscription_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_category_subscription`
--

LOCK TABLES `nstest_easyblog_category_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_category_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_category_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_comment`
--

DROP TABLE IF EXISTS `nstest_easyblog_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `comment` text,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  `created_by` bigint(20) unsigned DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `sent` tinyint(1) DEFAULT '1',
  `parent_id` int(11) unsigned DEFAULT '0',
  `lft` int(11) unsigned NOT NULL DEFAULT '0',
  `rgt` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_comment_postid` (`post_id`),
  KEY `easyblog_comment_parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_comment`
--

LOCK TABLES `nstest_easyblog_comment` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_configs`
--

DROP TABLE IF EXISTS `nstest_easyblog_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_configs` (
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Store any configuration in key => params maps';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_configs`
--

LOCK TABLES `nstest_easyblog_configs` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_configs` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_configs` VALUES ('config','main_global_title_enable=1\nmain_title=\"Intranet Aymara - Blogs\"\nmain_description=\"Blogs Interno de Aymará. Compartan sus experiencias, sus vivencias, sus inquietudes.\"\nmain_multiblogger=1\nmain_comment=\"1\"\nmain_comment_multiple=\"0\"\nmain_trackbacks=\"0\"\nmain_hits_session=\"1\"\nmain_technorati=0\nmain_joomlauserparams=\"0\"\nmain_hideintro_entryview=\"0\"\nmain_twitter_message=\"Published a new blog entry {title} in {category}. {link}\"\nmain_linkedin_message=\"Published a new blog entry {title} in {category}. {link}\"\nmain_twitter_shorten_url=0\nmain_twitter_urlshortener_login=\"\"\nmain_twitter_urlshortener_apikey=\"\"\nmain_twitter_button=\"1\"\nmain_twitter_button_style=\"vertical\"\nmain_twitter_cards=\"1\"\nmain_feedburner=\"1\"\nmain_feedburnerblogger=\"1\"\nmain_feedburnerurl=\"\"\nmain_feedburnerfeedcount=\"\"\nmain_feedburner_url=\"\"\nmain_commentmoderatecomment=0\nmain_commentmoderateguestcomment=1\nmain_subscription=\"1\"\nmain_mailqueueonpageload=\"1\"\nmain_avatarpath=\"images/easyblog_avatar/\"\nmain_bloggersubscription=\"1\"\nmain_url_translation=\"0\"\nmain_newblogonfrontpage=\"1\"\nmain_showauthorinfo=\"1\"\nmain_showauthorposts=\"1\"\nmain_showauthorpostscount=\"3\"\nmain_orphanitem_ownership=\"868\"\nmain_dstoffset=\"0\"\nmain_categorysubscription=\"1\"\nmain_registeronsubscribe=\"0\"\nmain_autofeatured=\"1\"\nmain_image_path=\"images/easyblog_images/\"\nmain_shared_path=\"images/easyblog_shared/\"\nmain_categoryavatarpath=\"images/easyblog_cavatar/\"\nmain_teamavatarpath=\"images/easyblog_tavatar/\"\nmain_mailqueuehtmlformat=\"1\"\nmain_blogpublishing=\"1\"\nmain_ratings=\"1\"\nmain_ratings_guests=\"0\"\nmain_ratings_frontpage=\"1\"\nmain_ratings_frontpage_locked=\"0\"\nmain_ratings_display_raters=\"1\"\nmain_ratings_display_raters_max=5\nmain_tags_sorting=\"ASC\"\nmain_password_protect=\"1\"\nmain_autodraft=\"1\"\nmain_autodraft_interval=\"90\"\nmain_blogprivacy=\"0\"\nmain_blogprivacy_override=\"1\"\nmain_allowguestcomment=\"1\"\nmain_allowguestviewcomment=\"1\"\nmain_allowguestsubscribe=\"1\"\nmain_googlebuzz=1\nmain_googlebuzz_position=\"right\"\nmain_relatedpost=\"1\"\nmain_max_relatedpost=\"5\"\nmain_sitesubscription=\"1\"\nmain_teamsubscription=\"1\"\nmain_includeteamblogpost=\"1\"\nmain_listprivateteamblog=\"1\"\nmain_meta_autofillkeywords=\"1\"\nmain_bloggerlistingoption=\"1\"\nmain_dashboard_editaccount=\"1\"\nmain_googleone=\"1\"\nmain_googleone_layout=\"tall\"\nmain_categories_hideempty=\"1\"\nmain_login_read=\"1\"\nmain_meta_autofilldescription=\"1\"\nmain_meta_autofilldescription_length=\"250\"\nmain_google_profiles=\"1\"\nmain_teaser_image_align=\"center\"\nmain_locations_blog_language=\"en\"\nmain_nonblogger_profile=\"1\"\nmain_image_gallery_frontpage=\"1\"\nmain_image_gallery_rowitems=3\nmain_image_gallery_maxwidth=\"128\"\nmain_mailtitle_length=\"25\"\nmain_mail_total=\"5\"\nmain_blocked_words=\"fuck,suck,bastard,shit,bitch,slut\"\nmain_copyrights=\"0\"\nmain_login_provider=\"jomsocial\"\nmain_anchor_nofollow=\"0\"\nmain_multi_language=\"1\"\nteamblog_allow_join=\"1\"\nmain_reporting=\"1\"\nmain_reporting_maxip=\"10\"\nmain_reporting_guests=\"0\"\nmain_truncate_ellipses=\"1\"\nmain_truncate_media_position=\"top\"\nmain_truncate_video_position=\"top\"\nmain_truncate_image_position=\"top\"\nmain_truncate_type=\"paragraph\"\nmain_truncate_maxtag=\"5\"\nmain_locations=\"1\"\nmain_locations_static_maps=\"0\"\nmain_locations_blog_map_width=\"450\"\nmain_locations_blog_map_height=\"300\"\nmain_locations_blog_frontpage=\"0\"\nmain_locations_blog_entry=\"1\"\nmain_locations_map_type=\"ROADMAP\"\nmain_locations_default_zoom_level=\"5\"\nmain_locations_max_zoom_level=\"10\"\nmain_locations_min_zoom_level=\"3\"\nmain_teaser_image=0\nlayout_dashboard_blogimage=\"1\"\nmain_post_min=\"0\"\nmain_post_length=\"50\"\nmain_sef=\"default\"\nmain_sef_unicode=\"0\"\nmain_sef_custom=\"%year_num%/%month_num%\"\nsubscription_mailchimp=\"0\"\nsubscription_mailchimp_key=\"\"\nsubscription_mailchimp_listid=\"\"\nsubscription_mailchimp_welcome=\"1\"\nmailchimp_campaign=\"0\"\nmailchimp_from_email=\"marcebarcelona@gmail.com\"\nmailchimp_from_name=\"ns\"\nmain_rss_content=\"introtext\"\nmain_digg_button=\"0\"\nmain_digg_button_frontpage=\"0\"\nmain_digg_button_style=\"medium\"\nlayout_theme=\"default\"\nlayout_comment_theme=\"default\"\nlayout_dashboard_theme=\"system\"\nlayout_exclude_bloggers=\"\"\nlayout_exclude_categories=\"\"\nlayout_toolbar=\"1\"\nlayout_headers=\"1\"\nlayout_headers_respect_author=\"1\"\nlayout_nameformat=\"name\"\nlayout_shortdateformat=\"%b %d\"\nlayout_dateformat=\"%A, %d %B %Y\"\nlayout_timeformat=\"%I:%M:%S %p\"\nlayout_avatar=\"1\"\nlayout_avatarIntegration=\"default\"\nlayout_phpbb_path=\"\"\nlayout_avatar_in_read_blog=1\nlayout_editor=\"tinymce\"\nlayout_editor_author=0\nlayout_latest=\"1\"\nlayout_categories=\"1\"\nlayout_tags=\"1\"\nlayout_bloggers=\"1\"\nlayout_teamblog=\"1\"\nlayout_archive=\"0\"\nlayout_search=\"1\"\nlayout_option_toolbar=\"1\"\nlayout_showcomment=\"0\"\nlayout_showcommentcount=\"3\"\nlayout_blogasintrotext=\"0\"\nlayout_maxlengthasintrotext=\"150\"\nlayout_categoryavatar=\"1\"\nlayout_teamavatar=\"1\"\nlayout_hits=1\nlayout_dashboarddisable=0\nlayout_dashboardhome=\"1\"\nlayout_dashboardmain=\"1\"\nlayout_dashboardblogs=\"1\"\nlayout_dashboardcomments=\"1\"\nlayout_dashboardcategories=\"1\"\nlayout_dashboardtags=\"1\"\nlayout_dashboardnewpost=\"1\"\nlayout_dashboardsettings=\"1\"\nlayout_dashboardlogout=\"1\"\nlayout_enablebloggertheme=\"1\"\nlayout_dashboarddrafts=\"1\"\nlayout_dashboardintro=1\nlayout_dashboardseo=\"1\"\nlayout_dashboardtrackback=\"1\"\nlayout_dashboardquickpost=1\nlayout_availablebloggertheme=\"default\"\nlayout_featured=\"1\"\nlayout_featured_autorotate=\"1\"\nlayout_featured_autorotate_interval=\"8\"\nlayout_featured_pin=\"1\"\nlayout_enabledashboardtoolbar=\"1\"\nlayout_googlefont=\"site\"\nlayout_postorder=\"latest\"\nlayout_postsort=\"desc\"\nlayout_dashboard_show_headers=0\nlayout_enableprint=\"1\"\nlayout_enablepdf=\"1\"\nlayout_enablebookmark=\"1\"\nlayout_dashboardanchor=\"0\"\nlayout_dashboard_zemanta=\"0\"\nlayout_dashboard_zemanta_api=\"\"\nlayout_respect_readmore=\"0\"\nlayout_blogger_breadcrumb=\"1\"\nlayout_login=\"1\"\ntoolbar_logout=\"1\"\nlayout_dashboardcategoryselect=\"select\"\nlayout_featured_allpages=\"1\"\nlayout_featured_intro_limit=\"250\"\nlayout_dashboardstats=\"1\"\nlayout_navigation=\"1\"\nlayout_avatar_link_name=\"1\"\nlayout_featured_frontpage=\"0\"\nlayout_dashboard_biography_editor=\"0\"\ntoolbar_editprofile=\"1\"\nlayout_listlength=\"0\"\nlayout_pagination_bloggers=\"5\"\nlayout_pagination_categories=\"5\"\nlayout_pagination_categories_per_page=\"5\"\nlayout_pagination_archive=\"5\"\nmain_facebook_status=1\nmain_facebook_api=\"\"\nmain_facebook_secret=\"\"\nmain_facebook_like=\"1\"\nmain_facebook_like_layout=\"standard\"\nmain_facebook_like_faces=\"1\"\nmain_facebook_like_send=\"1\"\nmain_facebook_like_width=\"450\"\nmain_facebook_like_verb=\"like\"\nmain_facebook_like_theme=\"light\"\nmain_facebook_scripts=\"1\"\nmain_facebook_opengraph=\"1\"\nmain_facebook_like_position=\"0\"\nlayout_sorting_category=\"ordering\"\nnotification_from_name=\"ns\"\nnotification_from_email=\"marcebarcelona@gmail.com\"\nnotifications_title=\"ns\"\nnotification_email=\"\"\ncustom_email_as_admin=\"0\"\nnotification_blogadmin=\"1\"\nnotification_allmembers=\"0\"\nnotification_blogsubscriber=\"1\"\nnotification_commentadmin=\"1\"\nnotification_commentauthor=\"1\"\nnotification_commentid=1\nnotification_commentsubscriber=\"1\"\nnotification_categorysubscriber=\"1\"\nnotification_sitesubscriber=\"1\"\nnotification_teamsubscriber=\"1\"\nmain_comment_email=0\ncomment_facebook=\"0\"\ncomment_facebook_colourscheme=\"light\"\ncomment_mollom=0\ncomment_mollom_public=\"\"\ncomment_mollom_private=\"\"\ncomment_autopublish=1\ncomment_autohyperlink=\"1\"\ncomment_moderatecomment=\"0\"\ncomment_moderateauthorcomment=\"0\"\ncomment_moderateguestcomment=\"1\"\ncomment_tnc=\"0\"\ncomment_tnc_users=\"2\"\ncomment_tnctext=\"Before submitting the comment, you agree that:\\n\\na. To accept full responsibility for the comment that you submit.\\nb. To use this function only for lawful purposes.\\nc. Not to post defamatory, abusive, offensive, racist, sexist, threatening, vulgar, obscene, hateful or otherwise inappropriate comments, or to post comments which will constitute a criminal offence or give rise to civil liability.\\nd. Not to post or make available any material which is protected by copyright, trade mark or other proprietary right without the express permission of the owner of the copyright, trade mark or any other proprietary right.\\ne. To evaluate for yourself the accuracy of any opinion, advice or other content.\"\ncomment_recaptcha=\"0\"\ncomment_recaptcha_ssl=\"0\"\ncomment_recaptcha_public=\"\"\ncomment_recaptcha_private=\"\"\ncomment_recaptcha_theme=\"clean\"\ncomment_recaptcha_lang=\"en\"\ncomment_requiretitle=\"0\"\ncomment_likes=\"1\"\ncomment_maxthreadedlevel=\"5\"\ncomment_autotitle=\"0\"\ncomment_registeroncomment=\"1\"\ncomment_bbcode=\"1\"\ncomment_captcha=\"0\"\ncomment_captcha_registered=\"0\"\nprm_blogger=18\ncomment_intensedebate=\"0\"\ncomment_disqus=\"0\"\ncomment_livefyre=\"0\"\ncomment_livefyre_siteid=\"\"\ncomment_jomcomment=0\ncomment_jcomments=0\ncomment_rscomments=0\ncomment_easydiscuss=0\ncomment_komento=0\ncomment_akismet=\"0\"\ncomment_akismet_trackback=\"0\"\ncomment_require_email=\"0\"\ncomment_require_website=\"0\"\ncomment_show_email=\"1\"\ncomment_show_website=\"1\"\ncomment_compojoom=\"0\"\nsocial_rtl=\"1\"\nmain_socialbutton_position=\"right\"\nsocial_show_frontpage=false\nfile_path=\"images\"\nupload_extensions=\"bmp,gif,jpg,png,BMP,GIF,JPG,PNG\"\ncheck_mime=1\nimage_extensions=\"bmp,gif,jpg,png\"\nignore_extensions=\"\"\nupload_mime=\"image/jpeg,image/gif,image/png,image/bmp\"\nupload_mime_illegal=\"text/html\"\nrestrict_uploads=1\nlayout_systemdateformat=\"%Y-%m-%d %H:%M:%S\"\nsocial_provider=\"addthis\"\nsocial_addthis_customcode=\"xa-4be11e1875bf6363\"\nsocial_addthis_style=\"2\"\nsocial_sharethis_publishers=\"42b7151d-c982-4f69-8414-846243c5c7ca\"\nmain_alpha_userpoint=\"1\"\nmain_alpha_userpoint_points=\"1\"\nmain_alpha_userpoint_medals=\"1\"\nmain_alpha_userpoint_ranks=\"1\"\nmain_rss=\"0\"\nintegrations_linkedin=0\nintegrations_linkedin_api_key=\"\"\nintegrations_linkedin_secret_key=\"\"\nintegrations_linkedin_company=\"\"\nintegrations_facebook=0\nintegrations_facebook_api_key=\"\"\nintegrations_facebook_secret_key=\"\"\nintegrations_facebook_default_message=\"\"\nintegrations_facebook_show_in_listing=\"0\"\nintegrations_facebook_page_id=\"\"\nintegrations_facebook_blogs_length=350\nintegrations_facebook_impersonate_page=0\nintegrations_facebook_source=\"content\"\nintegrations_twitter=0\nintegrations_twitter_api_key=\"\"\nintegrations_twitter_secret_key=\"\"\nintegrations_twitter_microblog=\"1\"\nintegrations_twitter_microblog_hashes=\"#blogs,#easyblog\"\nintegrations_twitter_microblog_category=\"1\"\nintegrations_twitter_microblog_publish=\"1\"\nintegrations_twitter_microblog_frontpage=\"1\"\nintegrations_easydiscuss_points=\"1\"\nintegrations_easydiscuss_badges=\"1\"\nintegrations_easydiscuss_notification_blog=\"1\"\nintegrations_easydiscuss_notification_comment=\"1\"\nintegrations_easydiscuss_notification_rating=\"1\"\nintegrations_easydiscuss_notification_comment_follower=\"1\"\nintegrations_easysocial_album=\"1\"\nintegrations_easysocial_toolbar=0\nintegrations_easysocial_friends=\"1\"\nintegrations_easysocial_followers=\"1\"\nintegrations_easysocial_badges=\"1\"\nintegrations_easysocial_conversations=\"1\"\nintegrations_easysocial_stream_newpost=\"1\"\nintegrations_easysocial_stream_newcomment=\"1\"\nintegrations_easysocial_stream_newpost_source=\"intro\"\nintegrations_easysocial_stream_featurepost=\"1\"\nintegrations_easysocial_stream_updatepost=\"1\"\nintegrations_easysocial_notifications_newpost=\"1\"\nintegrations_easysocial_notifications_newcomment=\"1\"\nintegrations_easysocial_notifications_ratings=\"1\"\nintegrations_easysocial_editprofile=\"1\"\nintegrations_easysocial_registration=1\nintegrations_easysocial_indexer_newpost=\"1\"\nintegrations_easysocial_indexer_newpost_length=\"250\"\nintegrations_easysocial_privacy=\"0\"\nintegrations_jomsocial_album=\"1\"\nintegrations_jomsocial_blog_new_activity=\"1\"\nintegrations_jomsocial_blog_update_activity=\"1\"\nintegrations_jomsocial_comment_new_activity=\"1\"\nintegrations_jomsocial_submit_content=\"1\"\nintegrations_jomsocial_show_category=\"1\"\nintegrations_jomsocial_blogger_status=\"1\"\nintegrations_jomsocial_profile_link=\"1\"\nintegrations_jomsocial_toolbar=\"0\"\nintegrations_jomsocial_feature_blog_activity=\"1\"\nintegrations_jomsocial_activity_comments=\"1\"\nintegrations_jomsocial_activity_likes=\"1\"\nintegrations_jomsocial_rss_import_activity=\"0\"\nintegrations_jomsocial_blogs_length=\"250\"\nintegrations_jomsocial_comments_length=\"250\"\nintegrations_jomsocial_notification_blog=\"1\"\nintegrations_jomsocial_notification_comment=\"1\"\nintegrations_jomsocial_notification_rating=\"1\"\nintegrations_jomsocial_notification_comment_follower=\"1\"\njomsocial_blog_title_length=\"80\"\nmain_jomsocial_userpoint=\"1\"\nmain_jomsocial_activity=1\nmain_jomsocial_messaging=\"1\"\nmain_jomsocial_friends=\"1\"\nmain_jomsocial_privacy=\"0\"\nintegrations_twitter_centralized=0\nintegrations_twitter_centralized_userid=0\nintegrations_twitter_centralized_auto_post=0\nintegrations_twitter_centralized_send_updates=1\nintegrations_twitter_centralized_and_own=1\nintegrations_facebook_centralized=0\nintegrations_facebook_centralized_and_own=1\nintegrations_facebook_centralized_userid=0\nintegrations_facebook_centralized_auto_post=0\nintegrations_facebook_centralized_send_updates=0\nintegrations_linkedin_centralized=0\nintegrations_linkedin_centralized_userid=0\nintegrations_linkedin_centralized_auto_post=0\nintegrations_linkedin_centralized_send_updates=1\nintegrations_linkedin_centralized_and_own=1\nintegration_google_adsense_enable=\"1\"\nintegration_google_adsense_centralized=\"0\"\nintegrations_google_adsense_blogger=\"1\"\nintegration_google_adsense_code=\"\"\nintegration_google_adsense_display=\"both\"\nintegration_google_adsense_display_access=\"both\"\nintegrations_mighty_activity_new_blog=\"0\"\nintegrations_mighty_activity_update_blog=\"0\"\nintegrations_mighty_karma_new_blog=\"1\"\nintegrations_mighty_karma_new_blog_points=\"5\"\nintegrations_mighty_karma_remove_blog=1\nintegrations_mighty_karma_remove_blog_points=\"-5\"\nmain_linkedin_button=\"1\"\nmain_linkedin_button_style=\"vertical\"\nmain_stumbleupon_button=\"1\"\nmain_stumbleupon_button_style=\"vertical\"\nmain_pinit_button=\"1\"\nmain_pinit_button_style=\"vertical\"\nintegrations_order_twitter=\"1\"\nintegrations_order_facebook=\"2\"\nintegrations_order_googleone=\"3\"\nintegrations_order_digg=\"4\"\nintegrations_order_linkedin=\"5\"\nintegrations_order_stumbleupon=\"6\"\nintegrations_order_pinit=\"7\"\nintegrations_order_tweetmeme=8\nmain_remotepublishing_mailbox=\"0\"\nmain_remotepublishing_mailbox_remotesystemname=\"\"\nmain_remotepublishing_mailbox_service=\"imap\"\nmain_remotepublishing_mailbox_port=\"143\"\nmain_remotepublishing_mailbox_mailboxname=\"INBOX\"\nmain_remotepublishing_mailbox_username=\"Chelo\"\nmain_remotepublishing_mailbox_password=\"Selvat1974\"\nmain_remotepublishing_mailbox_run_interval=\"5\"\nmain_remotepublishing_mailbox_ssl=\"1\"\nmain_remotepublishing_mailbox_prefix=\"\"\nmain_remotepublishing_mailbox_userid=\"0\"\nmain_remotepublishing_mailbox_categoryid=\"1\"\nmain_remotepublishing_mailbox_publish=\"1\"\nmain_remotepublishing_mailbox_frontpage=\"1\"\nmain_remotepublishing_mailbox_fetch_limit=\"3\"\nmain_remotepublishing_mailbox_next_run=0\nmain_remotepublishing_mailbox_type=\"intro\"\nmain_remotepublishing_mailbox_format=\"html\"\nmain_remotepublishing_mailbox_from_whitelist=\"\"\nmain_remotepublishing_mailbox_image_attachment=\"1\"\nmain_remotepublishing_mailbox_validate_cert=\"1\"\nmain_remotepublishing_mailbox_syncuser=\"1\"\nmain_remotepublishing_mailbox_privacy=\"0\"\nmax_video_width=\"400\"\nmax_video_height=\"225\"\ndashboard_video_width=\"400\"\ndashboard_video_height=\"225\"\ndashboard_tags_listing=\"1\"\nmax_tags_allowed=\"5\"\nintegrations_mighty_blogs_length=\"250\"\nlayout_zero_as_plural=\"1\"\nmain_routing=\"currentactive\"\nmain_routing_itemid=\"\"\nmain_pagetitle_autoappend=\"1\"\nmain_routing_order_bloggerstandalone=\"1\"\nmain_routing_order_entry=\"2\"\nmain_routing_order_category=\"3\"\nmain_routing_order_blogger=\"4\"\nmain_routing_order_teamblog=\"5\"\nmain_routing_order_bloggerstandalone_ignore=\"1\"\nmain_routing_order_entry_ignore=\"1\"\nmain_routing_order_category_ignore=\"1\"\nmain_routing_order_blogger_ignore=\"1\"\nmain_routing_order_teamblog_ignore=\"1\"\nlayout_copyrights=\"0\"\nmain_microblog=\"1\"\nmain_microblog_photo=1\nmain_microblog_video=1\nmain_microblog_quote=1\nmain_microblog_link=1\nlayout_media_flickr=\"0\"\nintegrations_flickr_api_key=\"ed9c66c60eb8c975bcbe2ff4a60852bf\"\nintegrations_flickr_secret_key=\"df665d37e9a425bd\"\nmain_canonical_entry=\"1\"\nmain_scribeseo_key=\"\"\nlayout_streamtimeformat=\"%I:%M %p\"\neasyblog_environment=\"static\"\neasyblog_mode=\"compressed\"\ndebug_javascript=1\nmain_media_extensions=\"jpg,png,gif,3g2,3gp,aac,f4a,f4v,flv,m4a,m4v,mov,mp3,mp4,zip,rar,7z,pdf,doc,docx,ppt,pptx,xls,xlsx\"\nmain_upload_image_size=\"8\"\nmain_image_quality=\"70\"\nmain_original_image_width=\"1280\"\nmain_original_image_height=\"960\"\nmain_original_image_quality=\"80\"\nmain_resize_original_image=\"0\"\nmain_thumbnail_width=\"400\"\nmain_thumbnail_height=\"400\"\nmain_thumbnail_quality=\"70\"\nmedia_icon_width=128\nmedia_icon_height=128\nmedia_icon_quality=70\nmain_media_lightbox_preview=\"1\"\nmain_media_show_lightbox_caption=\"1\"\nmain_media_lightbox_caption_strip_extension=\"0\"\nmain_media_lightbox_enforce_size=\"0\"\nmain_media_lightbox_max_width=\"640\"\nmain_media_lightbox_max_height=\"480\"\nmain_media_manager=\"1\"\nmain_media_manager_place_shared_media=\"1\"\nmain_media_manager_items_per_page=\"100\"\nmain_media_manager_image_panel_enable_lightbox=\"0\"\nmain_media_manager_image_panel_enforce_image_dimension=\"0\"\nmain_media_manager_image_panel_enforce_image_width=\"400\"\nmain_media_manager_image_panel_enforce_image_height=\"400\"\nmain_media_manager_image_panel_max_variation_image_width=\"2000\"\nmain_media_manager_image_panel_max_variation_image_height=\"2000\"\nmain_twitter_button_via_screen_name=\"\"\nmain_script_versioning=\"1\"\nintegrations_jomsocial_unpublish_remove_activity=\"0\"\nsend_notification_emails=1\nlayout_responsive=\"1\"\nlayout_iconless=\"0\"\nmain_sendemailnotifications=\"1\"\nmain_ratings_aup_rate=\"0\"\ncomment_autosubscribe=\"0\"\ncomment_show_title=\"0\"\ncomment_akismet_key=\"\"\ncomment_easyblog=\"0\"\ncomment_easysocial=\"0\"\ncomment_intensedebate_code=\"\"\ncomment_disqus_code=\"\"\nintegrations_easysocial_points=\"0\"\nintegrations_mighty_activity_feature_blog=\"0\"\nintegrations_mighty_submit_content=\"0\"\nintegrations_mighty_show_category=\"0\"\nintegrations_mighty_karma_update_blog=\"0\"\nmain_phocapdf_enable=\"0\"\nmain_pingomatic=\"0\"\nmain_twitter_button_frontpage=\"0\"\nmain_facebook_like_admin=\"\"\nmain_facebook_like_appid=\"\"\nmain_googleone_frontpage=\"0\"\nmain_linkedin_button_frontpage=\"0\"\nmain_stumbleupon_button_frontpage=\"0\"\nmain_pinit_button_frontpage=\"0\"\n5d4b0db8eb569a005e924f16b2cd2450=\"1\"\nactive=\"\"\nactivechild=\"\"');
/*!40000 ALTER TABLE `nstest_easyblog_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_drafts`
--

DROP TABLE IF EXISTS `nstest_easyblog_drafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_drafts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` bigint(20) NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `title` text,
  `permalink` text NOT NULL,
  `content` longtext NOT NULL,
  `intro` longtext NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `private` int(11) unsigned NOT NULL DEFAULT '0',
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `subscription` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `frontpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isnew` tinyint(3) unsigned DEFAULT '0' COMMENT 'To indicate whether the post is new created or already been edited',
  `ispending` tinyint(1) DEFAULT '0',
  `issitewide` tinyint(1) DEFAULT '1',
  `blogpassword` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `trackbacks` text NOT NULL,
  `blog_contribute` tinyint(1) NOT NULL,
  `autopost` text NOT NULL,
  `autopost_centralized` text NOT NULL,
  `pending_approval` tinyint(3) DEFAULT '0',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `address` text,
  `external_source` text,
  `external_group_id` int(11) DEFAULT NULL,
  `robots` text,
  `copyrights` text,
  `language` char(7) NOT NULL,
  `source` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `send_notification_emails` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `easyblog_post_catid` (`category_id`),
  KEY `easyblog_post_published` (`published`),
  KEY `easyblog_post_created_by` (`created_by`),
  KEY `easyblog_post_pending_approval` (`pending_approval`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_drafts`
--

LOCK TABLES `nstest_easyblog_drafts` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_drafts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_drafts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_external`
--

DROP TABLE IF EXISTS `nstest_easyblog_external`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_external` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `source` text NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `external_groups_post_id` (`post_id`),
  KEY `external_groups_group_id` (`uid`),
  KEY `external_groups_posts` (`uid`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_external`
--

LOCK TABLES `nstest_easyblog_external` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_external` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_external` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_external_groups`
--

DROP TABLE IF EXISTS `nstest_easyblog_external_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_external_groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `source` text NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `external_groups_post_id` (`post_id`),
  KEY `external_groups_group_id` (`group_id`),
  KEY `external_groups_posts` (`group_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_external_groups`
--

LOCK TABLES `nstest_easyblog_external_groups` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_external_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_external_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_featured`
--

DROP TABLE IF EXISTS `nstest_easyblog_featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_featured` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `easyblog_featured_content_type` (`content_id`,`type`),
  KEY `easyblog_content` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_featured`
--

LOCK TABLES `nstest_easyblog_featured` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_featured` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_featured` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_feedburner`
--

DROP TABLE IF EXISTS `nstest_easyblog_feedburner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_feedburner` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_feedburner`
--

LOCK TABLES `nstest_easyblog_feedburner` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_feedburner` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_feedburner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_feeds`
--

DROP TABLE IF EXISTS `nstest_easyblog_feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_feeds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `url` text NOT NULL,
  `interval` int(11) NOT NULL,
  `cron` tinyint(3) NOT NULL,
  `item_creator` int(11) NOT NULL,
  `item_category` bigint(20) NOT NULL,
  `item_frontpage` tinyint(3) NOT NULL,
  `item_published` tinyint(3) NOT NULL,
  `item_content` text NOT NULL,
  `item_get_fulltext` tinyint(3) NOT NULL DEFAULT '0',
  `author` tinyint(3) NOT NULL,
  `params` text NOT NULL,
  `published` tinyint(3) NOT NULL,
  `created` datetime NOT NULL,
  `last_import` datetime NOT NULL,
  `flag` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cron` (`cron`),
  KEY `item_creator` (`item_creator`),
  KEY `author` (`author`),
  KEY `item_frontpage` (`item_frontpage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_feeds`
--

LOCK TABLES `nstest_easyblog_feeds` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_feeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_feeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_feeds_history`
--

DROP TABLE IF EXISTS `nstest_easyblog_feeds_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_feeds_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `feed_id` bigint(20) NOT NULL,
  `post_id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feed_post_id` (`feed_id`,`post_id`),
  KEY `feed_uids` (`feed_id`,`uid`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_feeds_history`
--

LOCK TABLES `nstest_easyblog_feeds_history` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_feeds_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_feeds_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_hashkeys`
--

DROP TABLE IF EXISTS `nstest_easyblog_hashkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_hashkeys` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_hashkeys`
--

LOCK TABLES `nstest_easyblog_hashkeys` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_hashkeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_hashkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_likes`
--

DROP TABLE IF EXISTS `nstest_easyblog_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `content_id` int(11) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_content_type` (`type`,`content_id`),
  KEY `easyblog_contentid` (`content_id`),
  KEY `easyblog_createdby` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_likes`
--

LOCK TABLES `nstest_easyblog_likes` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_mailq`
--

DROP TABLE IF EXISTS `nstest_easyblog_mailq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_mailq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailfrom` varchar(255) DEFAULT NULL,
  `fromname` varchar(255) DEFAULT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_mailq_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_mailq`
--

LOCK TABLES `nstest_easyblog_mailq` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_mailq` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_mailq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_mediamanager`
--

DROP TABLE IF EXISTS `nstest_easyblog_mediamanager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_mediamanager` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  FULLTEXT KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_mediamanager`
--

LOCK TABLES `nstest_easyblog_mediamanager` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_mediamanager` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_mediamanager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_meta`
--

DROP TABLE IF EXISTS `nstest_easyblog_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `content_id` int(11) NOT NULL,
  `keywords` text,
  `description` text,
  `indexing` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_meta`
--

LOCK TABLES `nstest_easyblog_meta` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_meta` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_meta` VALUES (1,'view',1,'','',1),(2,'view',2,'','',1),(3,'view',3,'','',1),(4,'view',4,'','',1),(5,'view',5,'','',1),(6,'view',6,'','',1),(7,'view',7,'','',1),(8,'view',8,'','',1);
/*!40000 ALTER TABLE `nstest_easyblog_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_migrate_content`
--

DROP TABLE IF EXISTS `nstest_easyblog_migrate_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_migrate_content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `component` varchar(255) NOT NULL DEFAULT 'com_content',
  `filename` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  KEY `post_id` (`post_id`),
  KEY `session_id` (`session_id`),
  KEY `component_content` (`content_id`,`component`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Store migrated joomla content id and map with eblog post id.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_migrate_content`
--

LOCK TABLES `nstest_easyblog_migrate_content` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_migrate_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_migrate_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_oauth`
--

DROP TABLE IF EXISTS `nstest_easyblog_oauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_oauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `auto` tinyint(1) NOT NULL,
  `request_token` text NOT NULL,
  `access_token` text NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  `private` tinyint(4) NOT NULL,
  `params` text NOT NULL,
  `system` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_oauth_user_type` (`user_id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_oauth`
--

LOCK TABLES `nstest_easyblog_oauth` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_oauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_oauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_oauth_posts`
--

DROP TABLE IF EXISTS `nstest_easyblog_oauth_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_oauth_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sent` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `easyblog_oauth_posts_ids` (`oauth_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_oauth_posts`
--

LOCK TABLES `nstest_easyblog_oauth_posts` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_oauth_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_oauth_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_post`
--

DROP TABLE IF EXISTS `nstest_easyblog_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `title` text,
  `permalink` text NOT NULL,
  `content` longtext NOT NULL,
  `intro` longtext NOT NULL,
  `excerpt` text,
  `category_id` bigint(20) unsigned NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `private` int(11) unsigned NOT NULL DEFAULT '0',
  `allowcomment` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `subscription` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `frontpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isnew` tinyint(3) unsigned DEFAULT '0' COMMENT 'To indicate whether the post is new created or already been edited',
  `ispending` tinyint(1) DEFAULT '0',
  `issitewide` tinyint(1) DEFAULT '1',
  `blogpassword` varchar(100) NOT NULL DEFAULT '',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `address` text,
  `system` tinyint(3) unsigned DEFAULT '0',
  `source` varchar(255) NOT NULL,
  `robots` text,
  `copyrights` text,
  `image` text,
  `language` char(7) NOT NULL,
  `send_notification_emails` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `easyblog_post_catid` (`category_id`),
  KEY `easyblog_post_published` (`published`),
  KEY `easyblog_post_created_by` (`created_by`),
  KEY `easyblog_post_blogger_list` (`published`,`id`,`created_by`),
  KEY `easyblog_post_search` (`private`,`published`,`issitewide`,`created`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_post`
--

LOCK TABLES `nstest_easyblog_post` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_post_rejected`
--

DROP TABLE IF EXISTS `nstest_easyblog_post_rejected`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_post_rejected` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `draft_id` bigint(20) unsigned NOT NULL,
  `created_by` int(11) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `draft_id` (`draft_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_post_rejected`
--

LOCK TABLES `nstest_easyblog_post_rejected` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_post_rejected` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_post_rejected` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_post_subscription`
--

DROP TABLE IF EXISTS `nstest_easyblog_post_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_post_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_post_subscription_post_id` (`post_id`),
  KEY `easyblog_post_subscription_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_post_subscription`
--

LOCK TABLES `nstest_easyblog_post_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_post_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_post_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_post_tag`
--

DROP TABLE IF EXISTS `nstest_easyblog_post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_post_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_post_tag_tag_id` (`tag_id`),
  KEY `easyblog_post_tag_post_id` (`post_id`),
  KEY `easyblog_post_tagpost_id` (`tag_id`,`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_post_tag`
--

LOCK TABLES `nstest_easyblog_post_tag` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_post_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_ratings`
--

DROP TABLE IF EXISTS `nstest_easyblog_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `sessionid` varchar(200) NOT NULL,
  `value` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`uid`),
  KEY `created_by` (`created_by`),
  KEY `rating` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_ratings`
--

LOCK TABLES `nstest_easyblog_ratings` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_reports`
--

DROP TABLE IF EXISTS `nstest_easyblog_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_reports` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `obj_id` bigint(20) NOT NULL,
  `obj_type` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `obj_id` (`obj_id`,`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_reports`
--

LOCK TABLES `nstest_easyblog_reports` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_site_subscription`
--

DROP TABLE IF EXISTS `nstest_easyblog_site_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_site_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_site_subscription_user_id` (`user_id`),
  KEY `easyblog_site_subscription_email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_site_subscription`
--

LOCK TABLES `nstest_easyblog_site_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_site_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_site_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_stream`
--

DROP TABLE IF EXISTS `nstest_easyblog_stream`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_stream` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actor_id` bigint(20) unsigned NOT NULL,
  `target_id` bigint(20) unsigned DEFAULT '0',
  `context_type` varchar(255) DEFAULT '',
  `context_id` bigint(20) unsigned DEFAULT '0',
  `verb` text,
  `source_id` bigint(20) unsigned DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uuid` text,
  PRIMARY KEY (`id`),
  KEY `easyblog_stream_actor` (`actor_id`),
  KEY `easyblog_stream_actor_timeline` (`actor_id`,`created`),
  KEY `easyblog_stream_target_timeline` (`target_id`,`created`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_stream`
--

LOCK TABLES `nstest_easyblog_stream` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_stream` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_stream` VALUES (1,868,0,'post',1,'delete',0,'2014-05-20 17:59:21','Congratulations! You have successfully installed EasyBlog!');
/*!40000 ALTER TABLE `nstest_easyblog_stream` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_tag`
--

DROP TABLE IF EXISTS `nstest_easyblog_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `easyblog_tag_title` (`title`),
  KEY `easyblog_tag_published` (`published`),
  KEY `easyblog_tag_alias` (`alias`),
  KEY `easyblog_tag_query1` (`published`,`id`,`title`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_tag`
--

LOCK TABLES `nstest_easyblog_tag` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_tag` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_tag` VALUES (1,868,'Thank You','thank-you','2014-05-14 14:03:56',0,1,0,0),(2,868,'Congratulations','congratulations','2014-05-14 14:03:56',0,1,0,0);
/*!40000 ALTER TABLE `nstest_easyblog_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team`
--

DROP TABLE IF EXISTS `nstest_easyblog_team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `access` tinyint(1) DEFAULT '1',
  `published` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team`
--

LOCK TABLES `nstest_easyblog_team` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team_groups`
--

DROP TABLE IF EXISTS `nstest_easyblog_team_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team_groups` (
  `team_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  KEY `team_id` (`team_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team_groups`
--

LOCK TABLES `nstest_easyblog_team_groups` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team_post`
--

DROP TABLE IF EXISTS `nstest_easyblog_team_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team_post` (
  `team_id` int(11) NOT NULL,
  `post_id` bigint(11) NOT NULL,
  KEY `easyblog_teampost_tid` (`team_id`),
  KEY `easyblog_teampost_pid` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team_post`
--

LOCK TABLES `nstest_easyblog_team_post` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team_request`
--

DROP TABLE IF EXISTS `nstest_easyblog_team_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ispending` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `easyblog_team_request_teamid` (`team_id`),
  KEY `easyblog_team_request_userid` (`user_id`),
  KEY `easyblog_team_request_pending` (`ispending`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team_request`
--

LOCK TABLES `nstest_easyblog_team_request` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team_subscription`
--

DROP TABLE IF EXISTS `nstest_easyblog_team_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `easyblog_team_subscription_team_id` (`team_id`),
  KEY `easyblog_team_subscription_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team_subscription`
--

LOCK TABLES `nstest_easyblog_team_subscription` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_team_users`
--

DROP TABLE IF EXISTS `nstest_easyblog_team_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_team_users` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isadmin` tinyint(1) DEFAULT '0',
  KEY `easyblog_team_id` (`team_id`),
  KEY `easyblog_team_userid` (`user_id`),
  KEY `easyblog_team_isadmin` (`team_id`,`user_id`,`isadmin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_team_users`
--

LOCK TABLES `nstest_easyblog_team_users` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_team_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_team_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_trackback`
--

DROP TABLE IF EXISTS `nstest_easyblog_trackback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_trackback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(25) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `excerpt` text NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `blog_name` text NOT NULL,
  `charset` varchar(45) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `option` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `easyblog_tb_post_id` (`post_id`),
  KEY `easyblog_tb_url` (`url`),
  KEY `easyblog_tb_ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_trackback`
--

LOCK TABLES `nstest_easyblog_trackback` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_trackback` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_trackback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_trackback_sent`
--

DROP TABLE IF EXISTS `nstest_easyblog_trackback_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_trackback_sent` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `sent` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `easyblog_tb_sent_post_id` (`post_id`),
  KEY `easyblog_tb_sent_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_trackback_sent`
--

LOCK TABLES `nstest_easyblog_trackback_sent` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_trackback_sent` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_trackback_sent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_twitter_microblog`
--

DROP TABLE IF EXISTS `nstest_easyblog_twitter_microblog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_twitter_microblog` (
  `id_str` text NOT NULL,
  `oauth_id` int(11) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `tweet_author` text NOT NULL,
  KEY `post_id` (`post_id`),
  FULLTEXT KEY `id_str` (`id_str`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_twitter_microblog`
--

LOCK TABLES `nstest_easyblog_twitter_microblog` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_twitter_microblog` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_twitter_microblog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_users`
--

DROP TABLE IF EXISTS `nstest_easyblog_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_users` (
  `id` bigint(20) unsigned NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `params` text,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `biography` text,
  `permalink` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `easyblog_users_permalink` (`permalink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_users`
--

LOCK TABLES `nstest_easyblog_users` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_users` DISABLE KEYS */;
INSERT INTO `nstest_easyblog_users` VALUES (868,'Super User','default_blogger.png','','','',1,'',NULL,'chelo');
/*!40000 ALTER TABLE `nstest_easyblog_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_easyblog_xml_wpdata`
--

DROP TABLE IF EXISTS `nstest_easyblog_xml_wpdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_easyblog_xml_wpdata` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `source` varchar(15) NOT NULL,
  `data` longtext NOT NULL,
  `comments` longtext,
  PRIMARY KEY (`id`),
  KEY `xml_wpdate_session` (`session_id`),
  KEY `xml_wpdate_post_source` (`post_id`,`source`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_easyblog_xml_wpdata`
--

LOCK TABLES `nstest_easyblog_xml_wpdata` WRITE;
/*!40000 ALTER TABLE `nstest_easyblog_xml_wpdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_easyblog_xml_wpdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_extensions`
--

DROP TABLE IF EXISTS `nstest_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `access` int(10) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(3) NOT NULL DEFAULT '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0',
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=864 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_extensions`
--

LOCK TABLES `nstest_extensions` WRITE;
/*!40000 ALTER TABLE `nstest_extensions` DISABLE KEYS */;
INSERT INTO `nstest_extensions` VALUES (1,'com_mailto','component','com_mailto','',0,1,1,1,'{\"name\":\"com_mailto\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MAILTO_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(2,'com_wrapper','component','com_wrapper','',0,1,1,1,'{\"name\":\"com_wrapper\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_WRAPPER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(3,'com_admin','component','com_admin','',1,1,1,1,'{\"name\":\"com_admin\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_ADMIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(4,'com_banners','component','com_banners','',1,1,1,0,'{\"name\":\"com_banners\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_BANNERS_XML_DESCRIPTION\",\"group\":\"\"}','{\"purchase_type\":\"3\",\"track_impressions\":\"0\",\"track_clicks\":\"0\",\"metakey_prefix\":\"\",\"save_history\":\"1\",\"history_limit\":10}','','',0,'0000-00-00 00:00:00',0,0),(5,'com_cache','component','com_cache','',1,1,1,1,'{\"name\":\"com_cache\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CACHE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(6,'com_categories','component','com_categories','',1,1,1,1,'{\"name\":\"com_categories\",\"type\":\"component\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(7,'com_checkin','component','com_checkin','',1,1,1,1,'{\"name\":\"com_checkin\",\"type\":\"component\",\"creationDate\":\"Unknown\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2008 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CHECKIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(8,'com_contact','component','com_contact','',1,1,1,0,'{\"name\":\"com_contact\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONTACT_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_contact_category\":\"hide\",\"save_history\":\"1\",\"history_limit\":10,\"show_contact_list\":\"0\",\"presentation_style\":\"sliders\",\"show_name\":\"1\",\"show_position\":\"1\",\"show_email\":\"0\",\"show_street_address\":\"1\",\"show_suburb\":\"1\",\"show_state\":\"1\",\"show_postcode\":\"1\",\"show_country\":\"1\",\"show_telephone\":\"1\",\"show_mobile\":\"1\",\"show_fax\":\"1\",\"show_webpage\":\"1\",\"show_misc\":\"1\",\"show_image\":\"1\",\"image\":\"\",\"allow_vcard\":\"0\",\"show_articles\":\"0\",\"show_profile\":\"0\",\"show_links\":\"0\",\"linka_name\":\"\",\"linkb_name\":\"\",\"linkc_name\":\"\",\"linkd_name\":\"\",\"linke_name\":\"\",\"contact_icons\":\"0\",\"icon_address\":\"\",\"icon_email\":\"\",\"icon_telephone\":\"\",\"icon_mobile\":\"\",\"icon_fax\":\"\",\"icon_misc\":\"\",\"show_headings\":\"1\",\"show_position_headings\":\"1\",\"show_email_headings\":\"0\",\"show_telephone_headings\":\"1\",\"show_mobile_headings\":\"0\",\"show_fax_headings\":\"0\",\"allow_vcard_headings\":\"0\",\"show_suburb_headings\":\"1\",\"show_state_headings\":\"1\",\"show_country_headings\":\"1\",\"show_email_form\":\"1\",\"show_email_copy\":\"1\",\"banned_email\":\"\",\"banned_subject\":\"\",\"banned_text\":\"\",\"validate_session\":\"1\",\"custom_reply\":\"0\",\"redirect\":\"\",\"show_category_crumb\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(9,'com_cpanel','component','com_cpanel','',1,1,1,1,'{\"name\":\"com_cpanel\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CPANEL_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10,'com_installer','component','com_installer','',1,1,1,1,'{\"name\":\"com_installer\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_INSTALLER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(11,'com_languages','component','com_languages','',1,1,1,1,'{\"name\":\"com_languages\",\"type\":\"component\",\"creationDate\":\"2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\"}','{\"administrator\":\"es-ES\",\"site\":\"es-ES\"}','','',0,'0000-00-00 00:00:00',0,0),(12,'com_login','component','com_login','',1,1,1,1,'{\"name\":\"com_login\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(13,'com_media','component','com_media','',1,1,0,1,'{\"name\":\"com_media\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MEDIA_XML_DESCRIPTION\",\"group\":\"\"}','{\"upload_extensions\":\"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\",\"upload_maxsize\":\"10\",\"file_path\":\"images\",\"image_path\":\"images\",\"restrict_uploads\":\"1\",\"allowed_media_usergroup\":\"3\",\"check_mime\":\"1\",\"image_extensions\":\"bmp,gif,jpg,png\",\"ignore_extensions\":\"\",\"upload_mime\":\"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip\",\"upload_mime_illegal\":\"text\\/html\"}','','',0,'0000-00-00 00:00:00',0,0),(14,'com_menus','component','com_menus','',1,1,1,1,'{\"name\":\"com_menus\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MENUS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(15,'com_messages','component','com_messages','',1,1,1,1,'{\"name\":\"com_messages\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MESSAGES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(16,'com_modules','component','com_modules','',1,1,1,1,'{\"name\":\"com_modules\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MODULES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(17,'com_newsfeeds','component','com_newsfeeds','',1,1,1,0,'{\"name\":\"com_newsfeeds\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{\"newsfeed_layout\":\"_:default\",\"save_history\":\"1\",\"history_limit\":5,\"show_feed_image\":\"1\",\"show_feed_description\":\"1\",\"show_item_description\":\"1\",\"feed_character_count\":\"0\",\"feed_display_order\":\"des\",\"float_first\":\"right\",\"float_second\":\"right\",\"show_tags\":\"1\",\"category_layout\":\"_:default\",\"show_category_title\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"maxLevel\":\"-1\",\"show_empty_categories\":\"0\",\"show_subcat_desc\":\"1\",\"show_cat_items\":\"1\",\"show_cat_tags\":\"1\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_items_cat\":\"1\",\"filter_field\":\"1\",\"show_pagination_limit\":\"1\",\"show_headings\":\"1\",\"show_articles\":\"0\",\"show_link\":\"1\",\"show_pagination\":\"1\",\"show_pagination_results\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(18,'com_plugins','component','com_plugins','',1,1,1,1,'{\"name\":\"com_plugins\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_PLUGINS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(19,'com_search','component','com_search','',1,1,1,0,'{\"name\":\"com_search\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_SEARCH_XML_DESCRIPTION\",\"group\":\"\"}','{\"enabled\":\"0\",\"show_date\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(20,'com_templates','component','com_templates','',1,1,1,1,'{\"name\":\"com_templates\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_TEMPLATES_XML_DESCRIPTION\",\"group\":\"\"}','{\"template_positions_display\":\"0\",\"upload_limit\":\"2\",\"image_formats\":\"gif,bmp,jpg,jpeg,png\",\"source_formats\":\"txt,less,ini,xml,js,php,css\",\"font_formats\":\"woff,ttf,otf\",\"compressed_formats\":\"zip\"}','','',0,'0000-00-00 00:00:00',0,0),(21,'com_weblinks','component','com_weblinks','',1,1,1,0,'{\"name\":\"com_weblinks\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','{\"target\":\"0\",\"save_history\":\"1\",\"history_limit\":5,\"count_clicks\":\"1\",\"icons\":1,\"link_icons\":\"\",\"float_first\":\"right\",\"float_second\":\"right\",\"show_tags\":\"1\",\"category_layout\":\"_:default\",\"show_category_title\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"maxLevel\":\"-1\",\"show_empty_categories\":\"0\",\"show_subcat_desc\":\"1\",\"show_cat_num_links\":\"1\",\"show_cat_tags\":\"1\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_num_links_cat\":\"1\",\"filter_field\":\"1\",\"show_pagination_limit\":\"1\",\"show_headings\":\"0\",\"show_link_description\":\"1\",\"show_link_hits\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_feed_link\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(22,'com_content','component','com_content','',1,1,0,1,'{\"name\":\"com_content\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','{\"article_layout\":\"_:default\",\"show_title\":\"1\",\"link_titles\":\"1\",\"show_intro\":\"1\",\"info_block_position\":\"0\",\"show_category\":\"0\",\"link_category\":\"0\",\"show_parent_category\":\"0\",\"link_parent_category\":\"0\",\"show_author\":\"1\",\"link_author\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_publish_date\":\"0\",\"show_item_navigation\":\"1\",\"show_vote\":\"0\",\"show_readmore\":\"1\",\"show_readmore_title\":\"1\",\"readmore_limit\":\"100\",\"show_tags\":\"1\",\"show_icons\":\"1\",\"show_print_icon\":\"1\",\"show_email_icon\":\"1\",\"show_hits\":\"1\",\"show_noauth\":\"0\",\"urls_position\":\"0\",\"show_publishing_options\":\"1\",\"show_article_options\":\"1\",\"save_history\":\"1\",\"history_limit\":10,\"show_urls_images_frontend\":\"0\",\"show_urls_images_backend\":\"1\",\"targeta\":0,\"targetb\":0,\"targetc\":0,\"float_intro\":\"left\",\"float_fulltext\":\"left\",\"category_layout\":\"_:blog\",\"show_category_heading_title_text\":\"1\",\"show_category_title\":\"0\",\"show_description\":\"0\",\"show_description_image\":\"0\",\"maxLevel\":\"1\",\"show_empty_categories\":\"0\",\"show_no_articles\":\"1\",\"show_subcat_desc\":\"1\",\"show_cat_num_articles\":\"0\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_num_articles_cat\":\"1\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"4\",\"num_columns\":\"2\",\"num_links\":\"4\",\"multi_column_order\":\"0\",\"show_subcategory_content\":\"0\",\"show_pagination_limit\":\"1\",\"filter_field\":\"hide\",\"show_headings\":\"1\",\"list_show_date\":\"0\",\"date_format\":\"\",\"list_show_hits\":\"1\",\"list_show_author\":\"1\",\"orderby_pri\":\"order\",\"orderby_sec\":\"rdate\",\"order_date\":\"published\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_feed_link\":\"1\",\"feed_summary\":\"0\",\"feed_show_readmore\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(23,'com_config','component','com_config','',1,1,0,1,'{\"name\":\"com_config\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONFIG_XML_DESCRIPTION\",\"group\":\"\"}','{\"filters\":{\"1\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"9\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"6\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"7\":{\"filter_type\":\"NONE\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"2\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"3\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"4\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"5\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"8\":{\"filter_type\":\"NONE\",\"filter_tags\":\"\",\"filter_attributes\":\"\"}}}','','',0,'0000-00-00 00:00:00',0,0),(24,'com_redirect','component','com_redirect','',1,1,0,1,'{\"name\":\"com_redirect\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_REDIRECT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(25,'com_users','component','com_users','',1,1,0,1,'{\"name\":\"com_users\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_USERS_XML_DESCRIPTION\",\"group\":\"\"}','{\"allowUserRegistration\":\"1\",\"new_usertype\":\"2\",\"guest_usergroup\":\"9\",\"sendpassword\":\"1\",\"useractivation\":\"1\",\"mail_to_admin\":\"0\",\"captcha\":\"\",\"frontend_userparams\":\"1\",\"site_language\":\"0\",\"change_login_name\":\"0\",\"reset_count\":\"10\",\"reset_time\":\"1\",\"minimum_length\":\"4\",\"minimum_integers\":\"0\",\"minimum_symbols\":\"0\",\"minimum_uppercase\":\"0\",\"save_history\":\"1\",\"history_limit\":5,\"mailSubjectPrefix\":\"\",\"mailBodySuffix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(27,'com_finder','component','com_finder','',1,1,0,0,'{\"name\":\"com_finder\",\"type\":\"component\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_description\":\"1\",\"description_length\":255,\"allow_empty_query\":\"0\",\"show_url\":\"1\",\"show_advanced\":\"1\",\"expand_advanced\":\"0\",\"show_date_filters\":\"0\",\"highlight_terms\":\"1\",\"opensearch_name\":\"\",\"opensearch_description\":\"\",\"batch_size\":\"50\",\"memory_table_limit\":30000,\"title_multiplier\":\"1.7\",\"text_multiplier\":\"0.7\",\"meta_multiplier\":\"1.2\",\"path_multiplier\":\"2.0\",\"misc_multiplier\":\"0.3\",\"stemmer\":\"snowball\"}','','',0,'0000-00-00 00:00:00',0,0),(28,'com_joomlaupdate','component','com_joomlaupdate','',1,1,0,1,'{\"name\":\"com_joomlaupdate\",\"type\":\"component\",\"creationDate\":\"February 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(29,'com_tags','component','com_tags','',1,1,1,1,'{\"name\":\"com_tags\",\"type\":\"component\",\"creationDate\":\"December 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"COM_TAGS_XML_DESCRIPTION\",\"group\":\"\"}','{\"tag_layout\":\"_:default\",\"save_history\":\"1\",\"history_limit\":5,\"show_tag_title\":\"0\",\"tag_list_show_tag_image\":\"0\",\"tag_list_show_tag_description\":\"0\",\"tag_list_image\":\"\",\"show_tag_num_items\":\"0\",\"tag_list_orderby\":\"title\",\"tag_list_orderby_direction\":\"ASC\",\"show_headings\":\"0\",\"tag_list_show_date\":\"0\",\"tag_list_show_item_image\":\"0\",\"tag_list_show_item_description\":\"0\",\"tag_list_item_maximum_characters\":0,\"return_any_or_all\":\"1\",\"include_children\":\"0\",\"maximum\":200,\"tag_list_language_filter\":\"all\",\"tags_layout\":\"_:default\",\"all_tags_orderby\":\"title\",\"all_tags_orderby_direction\":\"ASC\",\"all_tags_show_tag_image\":\"0\",\"all_tags_show_tag_descripion\":\"0\",\"all_tags_tag_maximum_characters\":20,\"all_tags_show_tag_hits\":\"0\",\"filter_field\":\"1\",\"show_pagination_limit\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"tag_field_ajax_mode\":\"1\",\"show_feed_link\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(30,'com_contenthistory','component','com_contenthistory','',1,1,1,0,'{\"name\":\"com_contenthistory\",\"type\":\"component\",\"creationDate\":\"May 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_CONTENTHISTORY_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(31,'com_ajax','component','com_ajax','',1,1,1,0,'{\"name\":\"com_ajax\",\"type\":\"component\",\"creationDate\":\"August 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_AJAX_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(32,'com_postinstall','component','com_postinstall','',1,1,1,1,'{\"name\":\"com_postinstall\",\"type\":\"component\",\"creationDate\":\"September 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_POSTINSTALL_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(100,'PHPMailer','library','phpmailer','',0,1,1,1,'{\"name\":\"PHPMailer\",\"type\":\"library\",\"creationDate\":\"2001\",\"author\":\"PHPMailer\",\"copyright\":\"(c) 2001-2003, Brent R. Matzelle, (c) 2004-2009, Andy Prevost. All Rights Reserved., (c) 2010-2013, Jim Jagielski. All Rights Reserved.\",\"authorEmail\":\"jimjag@gmail.com\",\"authorUrl\":\"https:\\/\\/github.com\\/PHPMailer\\/PHPMailer\",\"version\":\"5.2.6\",\"description\":\"LIB_PHPMAILER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(101,'SimplePie','library','simplepie','',0,1,1,1,'{\"name\":\"SimplePie\",\"type\":\"library\",\"creationDate\":\"2004\",\"author\":\"SimplePie\",\"copyright\":\"Copyright (c) 2004-2009, Ryan Parman and Geoffrey Sneddon\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/simplepie.org\\/\",\"version\":\"1.2\",\"description\":\"LIB_SIMPLEPIE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(102,'phputf8','library','phputf8','',0,1,1,1,'{\"name\":\"phputf8\",\"type\":\"library\",\"creationDate\":\"2006\",\"author\":\"Harry Fuecks\",\"copyright\":\"Copyright various authors\",\"authorEmail\":\"hfuecks@gmail.com\",\"authorUrl\":\"http:\\/\\/sourceforge.net\\/projects\\/phputf8\",\"version\":\"0.5\",\"description\":\"LIB_PHPUTF8_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(103,'Joomla! Platform','library','joomla','',0,1,1,1,'{\"name\":\"Joomla! Platform\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"http:\\/\\/www.joomla.org\",\"version\":\"13.1\",\"description\":\"LIB_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{\"mediaversion\":\"e4f39b07de5d0f74f4e51003d671690a\"}','','',0,'0000-00-00 00:00:00',0,0),(104,'IDNA Convert','library','idna_convert','',0,1,1,1,'{\"name\":\"IDNA Convert\",\"type\":\"library\",\"creationDate\":\"2004\",\"author\":\"phlyLabs\",\"copyright\":\"2004-2011 phlyLabs Berlin, http:\\/\\/phlylabs.de\",\"authorEmail\":\"phlymail@phlylabs.de\",\"authorUrl\":\"http:\\/\\/phlylabs.de\",\"version\":\"0.8.0\",\"description\":\"LIB_IDNA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(105,'FOF','library','fof','',0,1,1,1,'{\"name\":\"FOF\",\"type\":\"library\",\"creationDate\":\"2014-03-09 12:54:48\",\"author\":\"Nicholas K. Dionysopoulos \\/ Akeeba Ltd\",\"copyright\":\"(C)2011-2014 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"https:\\/\\/www.akeebabackup.com\",\"version\":\"2.2.1\",\"description\":\"LIB_FOF_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(106,'PHPass','library','phpass','',0,1,1,1,'{\"name\":\"PHPass\",\"type\":\"library\",\"creationDate\":\"2004-2006\",\"author\":\"Solar Designer\",\"copyright\":\"\",\"authorEmail\":\"solar@openwall.com\",\"authorUrl\":\"http:\\/\\/www.openwall.com\\/phpass\\/\",\"version\":\"0.3\",\"description\":\"LIB_PHPASS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(200,'mod_articles_archive','module','mod_articles_archive','',0,1,1,0,'{\"name\":\"mod_articles_archive\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters.\\n\\t\\tAll rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(201,'mod_articles_latest','module','mod_articles_latest','',0,1,1,0,'{\"name\":\"mod_articles_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LATEST_NEWS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(202,'mod_articles_popular','module','mod_articles_popular','',0,1,1,0,'{\"name\":\"mod_articles_popular\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(203,'mod_banners','module','mod_banners','',0,1,1,0,'{\"name\":\"mod_banners\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_BANNERS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(204,'mod_breadcrumbs','module','mod_breadcrumbs','',0,1,1,1,'{\"name\":\"mod_breadcrumbs\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_BREADCRUMBS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(205,'mod_custom','module','mod_custom','',0,1,1,1,'{\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(206,'mod_feed','module','mod_feed','',0,1,1,0,'{\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(207,'mod_footer','module','mod_footer','',0,1,1,0,'{\"name\":\"mod_footer\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FOOTER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(208,'mod_login','module','mod_login','',0,1,1,1,'{\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(209,'mod_menu','module','mod_menu','',0,1,1,1,'{\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(210,'mod_articles_news','module','mod_articles_news','',0,1,1,0,'{\"name\":\"mod_articles_news\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_NEWS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(211,'mod_random_image','module','mod_random_image','',0,1,1,0,'{\"name\":\"mod_random_image\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_RANDOM_IMAGE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(212,'mod_related_items','module','mod_related_items','',0,1,1,0,'{\"name\":\"mod_related_items\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_RELATED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(213,'mod_search','module','mod_search','',0,1,1,0,'{\"name\":\"mod_search\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SEARCH_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(214,'mod_stats','module','mod_stats','',0,1,1,0,'{\"name\":\"mod_stats\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(215,'mod_syndicate','module','mod_syndicate','',0,1,1,1,'{\"name\":\"mod_syndicate\",\"type\":\"module\",\"creationDate\":\"May 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SYNDICATE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(216,'mod_users_latest','module','mod_users_latest','',0,1,1,0,'{\"name\":\"mod_users_latest\",\"type\":\"module\",\"creationDate\":\"December 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_USERS_LATEST_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(217,'mod_weblinks','module','mod_weblinks','',0,1,1,0,'{\"name\":\"mod_weblinks\",\"type\":\"module\",\"creationDate\":\"July 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(218,'mod_whosonline','module','mod_whosonline','',0,1,1,0,'{\"name\":\"mod_whosonline\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_WHOSONLINE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(219,'mod_wrapper','module','mod_wrapper','',0,1,1,0,'{\"name\":\"mod_wrapper\",\"type\":\"module\",\"creationDate\":\"October 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_WRAPPER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(220,'mod_articles_category','module','mod_articles_category','',0,1,1,0,'{\"name\":\"mod_articles_category\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(221,'mod_articles_categories','module','mod_articles_categories','',0,1,1,0,'{\"name\":\"mod_articles_categories\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(222,'mod_languages','module','mod_languages','',0,1,1,1,'{\"name\":\"mod_languages\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(223,'mod_finder','module','mod_finder','',0,1,0,0,'{\"name\":\"mod_finder\",\"type\":\"module\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(300,'mod_custom','module','mod_custom','',1,1,1,1,'{\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(301,'mod_feed','module','mod_feed','',1,1,1,0,'{\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(302,'mod_latest','module','mod_latest','',1,1,1,0,'{\"name\":\"mod_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LATEST_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(303,'mod_logged','module','mod_logged','',1,1,1,0,'{\"name\":\"mod_logged\",\"type\":\"module\",\"creationDate\":\"January 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGGED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(304,'mod_login','module','mod_login','',1,1,1,1,'{\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"March 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(305,'mod_menu','module','mod_menu','',1,1,1,0,'{\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(307,'mod_popular','module','mod_popular','',1,1,1,0,'{\"name\":\"mod_popular\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(308,'mod_quickicon','module','mod_quickicon','',1,1,1,1,'{\"name\":\"mod_quickicon\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_QUICKICON_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(309,'mod_status','module','mod_status','',1,1,1,0,'{\"name\":\"mod_status\",\"type\":\"module\",\"creationDate\":\"Feb 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATUS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(310,'mod_submenu','module','mod_submenu','',1,1,1,0,'{\"name\":\"mod_submenu\",\"type\":\"module\",\"creationDate\":\"Feb 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SUBMENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(311,'mod_title','module','mod_title','',1,1,1,0,'{\"name\":\"mod_title\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_TITLE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(312,'mod_toolbar','module','mod_toolbar','',1,1,1,1,'{\"name\":\"mod_toolbar\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_TOOLBAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(313,'mod_multilangstatus','module','mod_multilangstatus','',1,1,1,0,'{\"name\":\"mod_multilangstatus\",\"type\":\"module\",\"creationDate\":\"September 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MULTILANGSTATUS_XML_DESCRIPTION\",\"group\":\"\"}','{\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(314,'mod_version','module','mod_version','',1,1,1,0,'{\"name\":\"mod_version\",\"type\":\"module\",\"creationDate\":\"January 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_VERSION_XML_DESCRIPTION\",\"group\":\"\"}','{\"format\":\"short\",\"product\":\"1\",\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(315,'mod_stats_admin','module','mod_stats_admin','',1,1,1,0,'{\"name\":\"mod_stats_admin\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATS_XML_DESCRIPTION\",\"group\":\"\"}','{\"serverinfo\":\"0\",\"siteinfo\":\"0\",\"counter\":\"0\",\"increase\":\"0\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(316,'mod_tags_popular','module','mod_tags_popular','',0,1,1,0,'{\"name\":\"mod_tags_popular\",\"type\":\"module\",\"creationDate\":\"January 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"MOD_TAGS_POPULAR_XML_DESCRIPTION\",\"group\":\"\"}','{\"maximum\":\"5\",\"timeframe\":\"alltime\",\"owncache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(317,'mod_tags_similar','module','mod_tags_similar','',0,1,1,0,'{\"name\":\"mod_tags_similar\",\"type\":\"module\",\"creationDate\":\"January 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"MOD_TAGS_SIMILAR_XML_DESCRIPTION\",\"group\":\"\"}','{\"maximum\":\"5\",\"matchtype\":\"any\",\"owncache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(400,'plg_authentication_gmail','plugin','gmail','authentication',0,0,1,0,'{\"name\":\"plg_authentication_gmail\",\"type\":\"plugin\",\"creationDate\":\"February 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_GMAIL_XML_DESCRIPTION\",\"group\":\"\"}','{\"applysuffix\":\"0\",\"suffix\":\"\",\"verifypeer\":\"1\",\"user_blacklist\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(401,'plg_authentication_joomla','plugin','joomla','authentication',0,1,1,1,'{\"name\":\"plg_authentication_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_AUTH_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(402,'plg_authentication_ldap','plugin','ldap','authentication',0,0,1,0,'{\"name\":\"plg_authentication_ldap\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LDAP_XML_DESCRIPTION\",\"group\":\"\"}','{\"host\":\"\",\"port\":\"389\",\"use_ldapV3\":\"0\",\"negotiate_tls\":\"0\",\"no_referrals\":\"0\",\"auth_method\":\"bind\",\"base_dn\":\"\",\"search_string\":\"\",\"users_dn\":\"\",\"username\":\"admin\",\"password\":\"bobby7\",\"ldap_fullname\":\"fullName\",\"ldap_email\":\"mail\",\"ldap_uid\":\"uid\"}','','',0,'0000-00-00 00:00:00',3,0),(403,'plg_content_contact','plugin','contact','content',0,1,1,0,'{\"name\":\"plg_content_contact\",\"type\":\"plugin\",\"creationDate\":\"January 2014\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.2\",\"description\":\"PLG_CONTENT_CONTACT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',1,0),(404,'plg_content_emailcloak','plugin','emailcloak','content',0,1,1,0,'{\"name\":\"plg_content_emailcloak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION\",\"group\":\"\"}','{\"mode\":\"1\"}','','',0,'0000-00-00 00:00:00',1,0),(406,'plg_content_loadmodule','plugin','loadmodule','content',0,1,1,0,'{\"name\":\"plg_content_loadmodule\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LOADMODULE_XML_DESCRIPTION\",\"group\":\"\"}','{\"style\":\"xhtml\"}','','',0,'2011-09-18 15:22:50',0,0),(407,'plg_content_pagebreak','plugin','pagebreak','content',0,1,1,0,'{\"name\":\"plg_content_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\"}','{\"title\":\"1\",\"multipage_toc\":\"1\",\"showall\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(408,'plg_content_pagenavigation','plugin','pagenavigation','content',0,1,1,0,'{\"name\":\"plg_content_pagenavigation\",\"type\":\"plugin\",\"creationDate\":\"January 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_PAGENAVIGATION_XML_DESCRIPTION\",\"group\":\"\"}','{\"position\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(409,'plg_content_vote','plugin','vote','content',0,1,1,0,'{\"name\":\"plg_content_vote\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_VOTE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',6,0),(410,'plg_editors_codemirror','plugin','codemirror','editors',0,1,1,1,'{\"name\":\"plg_editors_codemirror\",\"type\":\"plugin\",\"creationDate\":\"28 March 2011\",\"author\":\"Marijn Haverbeke\",\"copyright\":\"\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"\",\"version\":\"3.15\",\"description\":\"PLG_CODEMIRROR_XML_DESCRIPTION\",\"group\":\"\"}','{\"lineNumbers\":\"1\",\"lineWrapping\":\"1\",\"matchTags\":\"1\",\"matchBrackets\":\"1\",\"marker-gutter\":\"1\",\"autoCloseTags\":\"1\",\"autoCloseBrackets\":\"1\",\"autoFocus\":\"1\",\"theme\":\"default\",\"tabmode\":\"indent\"}','','',0,'0000-00-00 00:00:00',1,0),(411,'plg_editors_none','plugin','none','editors',0,1,1,1,'{\"name\":\"plg_editors_none\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Unknown\",\"copyright\":\"\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"\",\"version\":\"3.0.0\",\"description\":\"PLG_NONE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',2,0),(412,'plg_editors_tinymce','plugin','tinymce','editors',0,1,1,0,'{\"name\":\"plg_editors_tinymce\",\"type\":\"plugin\",\"creationDate\":\"2005-2013\",\"author\":\"Moxiecode Systems AB\",\"copyright\":\"Moxiecode Systems AB\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"tinymce.moxiecode.com\",\"version\":\"4.0.22\",\"description\":\"PLG_TINY_XML_DESCRIPTION\",\"group\":\"\"}','{\"mode\":\"1\",\"skin\":\"0\",\"mobile\":\"0\",\"entity_encoding\":\"raw\",\"lang_mode\":\"1\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"extended_elements\":\"\",\"html_height\":\"550\",\"html_width\":\"750\",\"resizing\":\"1\",\"element_path\":\"1\",\"fonts\":\"1\",\"paste\":\"1\",\"searchreplace\":\"1\",\"insertdate\":\"1\",\"colors\":\"1\",\"table\":\"1\",\"smilies\":\"1\",\"hr\":\"1\",\"link\":\"1\",\"media\":\"1\",\"print\":\"1\",\"directionality\":\"1\",\"fullscreen\":\"1\",\"alignment\":\"1\",\"visualchars\":\"1\",\"visualblocks\":\"1\",\"nonbreaking\":\"1\",\"template\":\"1\",\"blockquote\":\"1\",\"wordcount\":\"1\",\"advlist\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"inlinepopups\":\"1\",\"custom_plugin\":\"\",\"custom_button\":\"\"}','','',0,'0000-00-00 00:00:00',3,0),(413,'plg_editors-xtd_article','plugin','article','editors-xtd',0,1,1,1,'{\"name\":\"plg_editors-xtd_article\",\"type\":\"plugin\",\"creationDate\":\"October 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_ARTICLE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',1,0),(414,'plg_editors-xtd_image','plugin','image','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_image\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_IMAGE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',2,0),(415,'plg_editors-xtd_pagebreak','plugin','pagebreak','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',3,0),(416,'plg_editors-xtd_readmore','plugin','readmore','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_readmore\",\"type\":\"plugin\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_READMORE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',4,0),(417,'plg_search_categories','plugin','categories','search',0,1,1,0,'{\"name\":\"plg_search_categories\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(418,'plg_search_contacts','plugin','contacts','search',0,1,1,0,'{\"name\":\"plg_search_contacts\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CONTACTS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(419,'plg_search_content','plugin','content','search',0,1,1,0,'{\"name\":\"plg_search_content\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(420,'plg_search_newsfeeds','plugin','newsfeeds','search',0,1,1,0,'{\"name\":\"plg_search_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(421,'plg_search_weblinks','plugin','weblinks','search',0,1,1,0,'{\"name\":\"plg_search_weblinks\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(422,'plg_system_languagefilter','plugin','languagefilter','system',0,0,1,1,'{\"name\":\"plg_system_languagefilter\",\"type\":\"plugin\",\"creationDate\":\"July 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',1,0),(423,'plg_system_p3p','plugin','p3p','system',0,1,1,0,'{\"name\":\"plg_system_p3p\",\"type\":\"plugin\",\"creationDate\":\"September 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_P3P_XML_DESCRIPTION\",\"group\":\"\"}','{\"headers\":\"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM\"}','','',0,'0000-00-00 00:00:00',2,0),(424,'plg_system_cache','plugin','cache','system',0,0,1,1,'{\"name\":\"plg_system_cache\",\"type\":\"plugin\",\"creationDate\":\"February 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CACHE_XML_DESCRIPTION\",\"group\":\"\"}','{\"browsercache\":\"0\",\"cachetime\":\"15\"}','','',0,'0000-00-00 00:00:00',9,0),(425,'plg_system_debug','plugin','debug','system',0,1,1,0,'{\"name\":\"plg_system_debug\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_DEBUG_XML_DESCRIPTION\",\"group\":\"\"}','{\"profile\":\"1\",\"queries\":\"1\",\"memory\":\"1\",\"language_files\":\"1\",\"language_strings\":\"1\",\"strip-first\":\"1\",\"strip-prefix\":\"\",\"strip-suffix\":\"\"}','','',0,'0000-00-00 00:00:00',4,0),(426,'plg_system_log','plugin','log','system',0,1,1,1,'{\"name\":\"plg_system_log\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LOG_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',5,0),(427,'plg_system_redirect','plugin','redirect','system',0,0,1,1,'{\"name\":\"plg_system_redirect\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_REDIRECT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',6,0),(428,'plg_system_remember','plugin','remember','system',0,1,1,1,'{\"name\":\"plg_system_remember\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_REMEMBER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',7,0),(429,'plg_system_sef','plugin','sef','system',0,1,1,0,'{\"name\":\"plg_system_sef\",\"type\":\"plugin\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEF_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',8,0),(430,'plg_system_logout','plugin','logout','system',0,1,1,1,'{\"name\":\"plg_system_logout\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',3,0),(431,'plg_user_contactcreator','plugin','contactcreator','user',0,0,1,0,'{\"name\":\"plg_user_contactcreator\",\"type\":\"plugin\",\"creationDate\":\"August 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTACTCREATOR_XML_DESCRIPTION\",\"group\":\"\"}','{\"autowebpage\":\"\",\"category\":\"34\",\"autopublish\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(432,'plg_user_joomla','plugin','joomla','user',0,1,1,0,'{\"name\":\"plg_user_joomla\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2009 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_USER_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{\"strong_passwords\":\"1\",\"autoregister\":\"1\"}','','',0,'0000-00-00 00:00:00',2,0),(433,'plg_user_profile','plugin','profile','user',0,0,1,0,'{\"name\":\"plg_user_profile\",\"type\":\"plugin\",\"creationDate\":\"January 2008\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_USER_PROFILE_XML_DESCRIPTION\",\"group\":\"\"}','{\"register-require_address1\":\"1\",\"register-require_address2\":\"1\",\"register-require_city\":\"1\",\"register-require_region\":\"1\",\"register-require_country\":\"1\",\"register-require_postal_code\":\"1\",\"register-require_phone\":\"1\",\"register-require_website\":\"1\",\"register-require_favoritebook\":\"1\",\"register-require_aboutme\":\"1\",\"register-require_tos\":\"1\",\"register-require_dob\":\"1\",\"profile-require_address1\":\"1\",\"profile-require_address2\":\"1\",\"profile-require_city\":\"1\",\"profile-require_region\":\"1\",\"profile-require_country\":\"1\",\"profile-require_postal_code\":\"1\",\"profile-require_phone\":\"1\",\"profile-require_website\":\"1\",\"profile-require_favoritebook\":\"1\",\"profile-require_aboutme\":\"1\",\"profile-require_tos\":\"1\",\"profile-require_dob\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(434,'plg_extension_joomla','plugin','joomla','extension',0,1,1,1,'{\"name\":\"plg_extension_joomla\",\"type\":\"plugin\",\"creationDate\":\"May 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',1,0),(435,'plg_content_joomla','plugin','joomla','content',0,1,1,0,'{\"name\":\"plg_content_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(436,'plg_system_languagecode','plugin','languagecode','system',0,0,1,0,'{\"name\":\"plg_system_languagecode\",\"type\":\"plugin\",\"creationDate\":\"November 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',10,0),(437,'plg_quickicon_joomlaupdate','plugin','joomlaupdate','quickicon',0,1,1,1,'{\"name\":\"plg_quickicon_joomlaupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(438,'plg_quickicon_extensionupdate','plugin','extensionupdate','quickicon',0,1,1,1,'{\"name\":\"plg_quickicon_extensionupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(439,'plg_captcha_recaptcha','plugin','recaptcha','captcha',0,0,1,0,'{\"name\":\"plg_captcha_recaptcha\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION\",\"group\":\"\"}','{\"public_key\":\"\",\"private_key\":\"\",\"theme\":\"clean\"}','','',0,'0000-00-00 00:00:00',0,0),(440,'plg_system_highlight','plugin','highlight','system',0,1,1,0,'{\"name\":\"plg_system_highlight\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_HIGHLIGHT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',7,0),(441,'plg_content_finder','plugin','finder','content',0,0,1,0,'{\"name\":\"plg_content_finder\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(442,'plg_finder_categories','plugin','categories','finder',0,1,1,0,'{\"name\":\"plg_finder_categories\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',1,0),(443,'plg_finder_contacts','plugin','contacts','finder',0,1,1,0,'{\"name\":\"plg_finder_contacts\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CONTACTS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',2,0),(444,'plg_finder_content','plugin','content','finder',0,1,1,0,'{\"name\":\"plg_finder_content\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',3,0),(445,'plg_finder_newsfeeds','plugin','newsfeeds','finder',0,1,1,0,'{\"name\":\"plg_finder_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',4,0),(446,'plg_finder_weblinks','plugin','weblinks','finder',0,1,1,0,'{\"name\":\"plg_finder_weblinks\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',5,0),(447,'plg_finder_tags','plugin','tags','finder',0,1,1,0,'{\"name\":\"plg_finder_tags\",\"type\":\"plugin\",\"creationDate\":\"February 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_TAGS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(448,'plg_twofactorauth_totp','plugin','totp','twofactorauth',0,0,1,0,'{\"name\":\"plg_twofactorauth_totp\",\"type\":\"plugin\",\"creationDate\":\"August 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"PLG_TWOFACTORAUTH_TOTP_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(449,'plg_authentication_cookie','plugin','cookie','authentication',0,1,1,0,'{\"name\":\"plg_authentication_cookie\",\"type\":\"plugin\",\"creationDate\":\"July 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_AUTH_COOKIE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(450,'plg_twofactorauth_yubikey','plugin','yubikey','twofactorauth',0,0,1,0,'{\"name\":\"plg_twofactorauth_yubikey\",\"type\":\"plugin\",\"creationDate\":\"September 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"PLG_TWOFACTORAUTH_YUBIKEY_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(451,'plg_search_tags','plugin','tags','search',0,0,1,0,'{\"name\":\"plg_search_tags\",\"type\":\"plugin\",\"creationDate\":\"March 2014\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_TAGS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"show_tagged_items\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(503,'beez3','template','beez3','',0,1,1,0,'{\"name\":\"beez3\",\"type\":\"template\",\"creationDate\":\"25 November 2009\",\"author\":\"Angie Radtke\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"3.1.0\",\"description\":\"TPL_BEEZ3_XML_DESCRIPTION\",\"group\":\"\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"templatecolor\":\"nature\"}','','',0,'0000-00-00 00:00:00',0,0),(504,'hathor','template','hathor','',1,1,1,0,'{\"name\":\"hathor\",\"type\":\"template\",\"creationDate\":\"May 2010\",\"author\":\"Andrea Tarr\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"hathor@tarrconsulting.com\",\"authorUrl\":\"http:\\/\\/www.tarrconsulting.com\",\"version\":\"3.0.0\",\"description\":\"TPL_HATHOR_XML_DESCRIPTION\",\"group\":\"\"}','{\"showSiteName\":\"0\",\"colourChoice\":\"0\",\"boldText\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(506,'protostar','template','protostar','',0,1,1,0,'{\"name\":\"protostar\",\"type\":\"template\",\"creationDate\":\"4\\/30\\/2012\",\"author\":\"Kyle Ledbetter\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"\",\"version\":\"1.0\",\"description\":\"TPL_PROTOSTAR_XML_DESCRIPTION\",\"group\":\"\"}','{\"templateColor\":\"\",\"logoFile\":\"\",\"googleFont\":\"1\",\"googleFontName\":\"Open+Sans\",\"fluidContainer\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(507,'isis','template','isis','',1,1,1,0,'{\"name\":\"isis\",\"type\":\"template\",\"creationDate\":\"3\\/30\\/2012\",\"author\":\"Kyle Ledbetter\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"\",\"version\":\"1.0\",\"description\":\"TPL_ISIS_XML_DESCRIPTION\",\"group\":\"\"}','{\"templateColor\":\"\",\"logoFile\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(600,'English (United Kingdom)','language','en-GB','',0,1,1,1,'{\"name\":\"English (United Kingdom)\",\"type\":\"language\",\"creationDate\":\"2013-03-07\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.3.0\",\"description\":\"en-GB site language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(601,'English (United Kingdom)','language','en-GB','',1,1,1,1,'{\"name\":\"English (United Kingdom)\",\"type\":\"language\",\"creationDate\":\"2013-03-07\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.3.0\",\"description\":\"en-GB administrator language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(700,'files_joomla','file','joomla','',0,1,1,1,'{\"name\":\"files_joomla\",\"type\":\"file\",\"creationDate\":\"April 2014\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2014 Open Source Matters. All rights reserved\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.3.0\",\"description\":\"FILES_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(703,'gantry','component','com_gantry','',0,1,0,0,'{\"name\":\"Gantry\",\"type\":\"component\",\"creationDate\":\"April 12, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"4.1.24\",\"description\":\"Gantry Starting Template for Joomla! v4.1.24\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(704,'System - Gantry','plugin','gantry','system',0,1,1,0,'{\"name\":\"System - Gantry\",\"type\":\"plugin\",\"creationDate\":\"April 12, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"4.1.24\",\"description\":\"Gantry System Plugin for Joomla\",\"group\":\"\"}','{\"debugloglevel\":\"63\"}','','',0,'0000-00-00 00:00:00',1,0),(705,'rt_epsilon','template','rt_epsilon','',0,1,1,0,'{\"name\":\"rt_epsilon\",\"type\":\"template\",\"creationDate\":\"March 2, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"1.0\",\"description\":\"Parent for all PHP based projects\",\"group\":\"\"}','{\"master\":\"true\"}','','',0,'0000-00-00 00:00:00',0,0),(706,'System - RokExtender','plugin','rokextender','system',0,1,1,0,'{\"name\":\"System - RokExtender\",\"type\":\"plugin\",\"creationDate\":\"October 31, 2012\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2012 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.0\",\"description\":\"System - Gantry\",\"group\":\"\"}','{\"registered\":\"\\/modules\\/mod_roknavmenu\\/lib\\/RokNavMenuEvents.php,\\/modules\\/mod_rokweather\\/lib\\/RokWeatherPlugin.php,\\/modules\\/mod_rokminievents3\\/lib\\/RokMiniEvents3Plugin.php,\\/modules\\/mod_rokminievents\\/lib\\/RokMiniEventsPlugin.php\"}','','',0,'0000-00-00 00:00:00',1,0),(707,'RokNavMenu','module','mod_roknavmenu','',0,1,1,0,'{\"name\":\"RokNavMenu\",\"type\":\"module\",\"creationDate\":\"November 5, 2013\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2013 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.7\",\"description\":\"RocketTheme Customizable Navigation Menu\",\"group\":\"\"}','{\"limit_levels\":\"0\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"filteringspacer2\":\"\",\"theme\":\"default\",\"custom_layout\":\"default.php\",\"custom_formatter\":\"default.php\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}','','',0,'0000-00-00 00:00:00',0,0),(709,'RokWeather','module','mod_rokweather','',0,1,1,0,'{\"name\":\"RokWeather\",\"type\":\"module\",\"creationDate\":\"November 5, 2013\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2013 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.3\",\"description\":\"RokWeather is a weather module showing current weather from online Weather Services\",\"group\":\"\"}','{\"source\":\"yahoo\",\"default_degree\":\"0\",\"user_interaction\":\"1\",\"units_switch\":\"1\",\"enable_location_cookie\":\"0\",\"enable_icon\":\"1\",\"enable_humidity\":\"1\",\"enable_wind\":\"0\",\"wind_speed\":\"0\",\"enable_forecast\":\"1\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(711,'RokStock','module','mod_rokstock','',0,1,1,0,'{\"name\":\"RokStock\",\"type\":\"module\",\"creationDate\":\"November 5, 2013\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2013 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.1\",\"description\":\"RokStock is market stock module based on Google data\",\"group\":\"\"}','{\"default_stocks\":\".DJI, .INX, .IXIC\",\"user_interaction\":\"1\",\"store_cookie\":\"1\",\"store_time\":\"30\",\"externals\":\"1\",\"show_main_chart\":\"1\",\"show_tooltips\":\"0\",\"time_display\":\"12\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(713,'Content - RokSocialButtons','plugin','roksocialbuttons','content',0,1,1,0,'{\"name\":\"Content - RokSocialButtons\",\"type\":\"plugin\",\"creationDate\":\"November 5, 2013\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2013 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"1.5.2\",\"description\":\"RokSocialButtons Content Plugin.  Use format {socialbuttons} in your article to display the social buttons in your article\",\"group\":\"\"}','{\"addthis_id\":\"\",\"enable_twitter\":\"1\",\"enable_facebook\":\"1\",\"enable_google\":\"1\",\"prepend_text\":\"\",\"extra_class\":\"\",\"display_position\":\"0\",\"add_method\":\"2\",\"catid\":\"\"}','','',0,'0000-00-00 00:00:00',5,0),(715,'Editor - RokPad','plugin','rokpad','editors',0,1,1,0,'{\"name\":\"Editor - RokPad\",\"type\":\"plugin\",\"creationDate\":\"February 11, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.1.8\",\"description\":\"\\n        <div class=\\\"rokpad-description\\\">\\n        <img src=\\\"..\\/plugins\\/editors\\/rokpad\\/assets\\/admin\\/images\\/rokpad.jpg\\\" class=\\\"img-padding\\\" \\/><h1>RokPad<\\/h1>\\n        <h2>The Power of Desktop Text Editor in a Joomla!<\\/h2>\\n        <p>Ever wished you could use a powerful desktop text editor such as Textmate, SublimeText, or UltraEdit directly on a Joomla! web site?  Now with RokPad we provide many features and capabilities that traditionally would only be found in a powerful desktop editor.  RokPad provides advanced functions such as an Ajax saving action, syntax highlighting, configurable themes, multiple cursors and selections, shortcut keys, multiple language support, and many other incredible features.<\\/p>\\n\\n        <h2>Key Features:<\\/h2>\\n        <ul class=\\\"features\\\">\\n\\t\\t\\t<li>Code Highlighter built on the great ACE Editor<\\/li>\\n\\t        <li>Support for CSS, HTML, JavaScript, JSON, LESS, Markdown, PHP, SQL, Plain Text, Textile, XML and more...<\\/li>\\n\\t        <li>Ajax save and Automatic Save options. You\'ll never loose your content again, nor wait until the page has finished reloading after a save!<\\/li>\\n\\t        <li>Save, Undo, Redo, Goto line, Advanced Search and Search &amp; Replace, Full Screen. Settings like Themes, Font Size, Code Folding, Wrap Mode, Invisible Characters, Print Margin, Highlight of selected word<\\/li>\\n\\t        <li>26 Themes to choose from<\\/li>\\n\\t        <li>Resizable Editor by dragging the Statusbar<\\/li>\\n\\t        <li>Keyboard shortcuts<\\/li>\\n\\t        <li>Brackets match<\\/li>\\n\\t        <li>Multiple cursors and selections<\\/li>\\n\\t        <li>Vertical Selection<\\/li>\\n\\t        <li>Ability to insert at multiple locations xtd-buttons shortcodes, all at once.<\\/li>\\n\\t        <li>Shortcodes and Universal Tag Insertion<\\/li>\\n\\t        <li>Drag &amp; Drop of text from external applications such as other Browser Tabs\\/windows or Native Applications (Supported on Firefox, Chrome, IE10 and Safari)<\\/li>\\n\\t        <li>Import local files by Drag &amp; Drop directly from your desktop! (Supported on Firefox, Chrome, IE10 and Safari 6+)<\\/li>\\n\\t        <li>And much more!<\\/li>\\n        <\\/ul>\\n        <\\/div>\\n        \",\"group\":\"\"}','{\"autosave-enabled\":\"0\",\"autosave-time\":\"5\",\"theme\":\"fluidvision\",\"font-size\":\"12px\",\"fold-style\":\"markbeginend\",\"use-wrap-mode\":\"free\",\"selection-style\":\"1\",\"highlight-active-line\":\"1\",\"highlight-selected-word\":\"1\",\"show-invisibles\":\"0\",\"show-gutter\":\"1\",\"show-print-margin\":\"1\",\"fade-fold-widgets\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(717,'RokMiniEvents3','module','mod_rokminievents3','',0,1,1,0,'{\"name\":\"RokMiniEvents3\",\"type\":\"module\",\"creationDate\":\"April 9, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"3.0.0\",\"description\":\"RokMiniEvents3 allows to share your Joomla! website Calendar Events from Google, EventList, JEvents, JomSocial, RedEvent and RSEvents\",\"group\":\"\"}','{\"builtin_css\":\"1\",\"sortorder\":\"ascending\",\"time_range\":\"predefined_ranges\",\"startmin\":\"\",\"startmax\":\"\",\"rangespan\":\"current_month\",\"show_description\":\"1\",\"strip_tags\":\"a,i,br\",\"trim_description\":\"1\",\"trim_count\":\"200\",\"localtime\":\"local\",\"timezone\":\"0\",\"dayformat\":\"%d\",\"monthformat\":\"%b\",\"yearformat\":\"%Y\",\"timeformat\":\"%I:%M %p\",\"datedisplay\":\"badge\",\"showyear\":\"0\",\"limit_count\":\"0\",\"events_pane\":\"3\",\"timeline\":\"both\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(720,'System - RokCommon','plugin','rokcommon','system',0,1,1,0,'{\"name\":\"System - RokCommon\",\"type\":\"plugin\",\"creationDate\":\"March 11, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"3.1.11\",\"description\":\"RokCommon System Plugin\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(721,'rokgallery','component','com_rokgallery','',1,1,0,0,'{\"name\":\"RokGallery\",\"type\":\"component\",\"creationDate\":\"March 15, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.29\",\"description\":\"Parent for all PHP based projects\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(722,'RokGallery Module','module','mod_rokgallery','',0,1,1,0,'{\"name\":\"RokGallery Module\",\"type\":\"module\",\"creationDate\":\"March 15, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.29\",\"description\":\"Module for displaying RokGallery\",\"group\":\"\"}','{\"link\":\"0\",\"default_menuitem\":\"0\",\"title\":\"false\",\"caption\":\"false\",\"sort_by\":\"gallery_ordering\",\"sort_direction\":\"ASC\",\"limit_count\":\"10\",\"css_style\":\"light\",\"layout\":\"grid\",\"columns\":\"1\",\"arrows\":\"onhover\",\"navigation\":\"thumbnails\",\"animation_type\":\"random\",\"animation_duration\":\"500\",\"autoplay_enabled\":\"0\",\"autoplay_delay\":\"7\",\"showcase_arrows\":\"onhover\",\"showcase_image_position\":\"left\",\"showcase_imgpadding\":\"0\",\"showcase_animation_type\":\"random\",\"showcase_captionsanimation\":\"crossfade\",\"showcase_animation_duration\":\"500\",\"showcase_autoplay_enabled\":\"0\",\"showcase_autoplay_delay\":\"7\",\"showcase_responsive_arrows\":\"onhover\",\"showcase_responsive_image_position\":\"left\",\"showcase_responsive_imgpadding\":\"0\",\"showcase_responsive_animation_type\":\"random\",\"showcase_responsive_captionsanimation\":\"crossfade\",\"showcase_responsive_animation_duration\":\"500\",\"showcase_responsive_autoplay_enabled\":\"0\",\"showcase_responsive_autoplay_delay\":\"7\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(723,'Button - RokGallery','plugin','rokgallery','editors-xtd',0,1,1,0,'{\"name\":\"Button - RokGallery\",\"type\":\"plugin\",\"creationDate\":\"March 15, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.29\",\"description\":\"This is an Editor Button to allow selection of RokGallery Slices\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',50,0),(724,'System - RokGallery','plugin','rokgallery','system',0,1,1,0,'{\"name\":\"System - RokGallery\",\"type\":\"plugin\",\"creationDate\":\"March 15, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.29\",\"description\":\"A system level support plugin for RokGallery.\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',50,0),(726,'Content - RokComments','plugin','rokcomments','content',0,1,1,0,'{\"name\":\"Content - RokComments\",\"type\":\"plugin\",\"creationDate\":\"March 4, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.2\",\"description\":\"\\n      \\n      <div class=\\\"rc-wrapper\\\">\\n\\n      <h1>RokComments<\\/h1>\\n      <p> RokComments is a powerful content plugin that allows for easy integration of third-party JavaScript-based comment systems such as <b><a href=\\\"#intnse\\\">IntenseDebate<\\/a><\\/b>, <b><a href=\\\"#facebook\\\">Facebook<\\/a><\\/b>, <b><a href=\\\"disqus\\\">Disqus<\\/a><\\/b>, <b><a href=\\\"#livefyre\\\">Livefyre<\\/a><\\/b>, and <b>JS-Kit<\\/b> <em>(Deprecated)<\\/em><\\/p>\\n\\n      <a name=\\\"intense\\\"><\\/a>\\n      <h2>IntenseDebate<\\/h2>\\n      <p><img src=\\\"..\\/plugins\\/content\\/rokcomments\\/images\\/id-comments-acct.jpg\\\" \\\"\\/>To setup RokComments to use IntenseDebate, you first have to sign up at <a href=\\\"http:\\/\\/intensedebate.com\\\" target=\\\"_new\\\">http:\\/\\/intensedebate.com<\\/a>. Once you have created an account, you need to select <strong>\\\"Sites\\\"<\\/strong> from the top menu, then click <strong>\\\"+ Add blog\\/site\\\"<\\/strong> from the dropdown. Enter the URL to your website and click Next Step. for Step 2, choose <strong>Generic Install<\\/strong> from the options, then click Next Step.  This last page has the JavaScript that you normally would need to install the comments.<\\/p>\\n      <p>Just save the long string variable that is displayed in the <strong>idcomments_acct<\\/strong> var. This is the only thing you will need to configure RokComments to use IntenseDebate.\\n      <\\/p>\\n      <h3>Configure<\\/h3>\\n      <p>Open up the <strong>RokComments Content Plugin<\\/strong> via the <strong>Plugin Manager<\\/strong> in the Joomla Administrator.  Set the following attributes:<\\/p>\\n      <ol>\\n          <li>Set <strong>Comment System<\\/strong> to <strong class=\\\"under\\\">IntenseDebate<\\/strong><\\/li>\\n          <li>Enable\\/Disable the <strong>Show Comment Count<\\/strong> and the <strong>Show Comment Icon<\\/strong> options as you desire.<\\/li>\\n          <li>If you are using <strong class=\\\"under\\\">Menus + Categories<\\/strong> for the Activation Method, ensure you select the correct <strong>Menus<\\/strong> and\\/or <strong>Categories<\\/strong> where you would like the comments to show.<\\/li>\\n          <li>In the <strong>IntenseDebate Account<\\/strong> input field, put the <strong class=\\\"under\\\">idcomments_act<\\/strong> value you saved earlier. eg: <strong class=\\\"under\\\">2a8f5c96e2fb1deb5a485678a9c523f0<\\/strong> <\\/li>\\n      <\\/ol>\\n\\n      <a name=\\\"facebook\\\"><\\/a>\\n      <h2>Facebook<\\/h2>\\n      <p><img src=\\\"..\\/plugins\\/content\\/rokcomments\\/images\\/fb-appid.jpg\\\" \\\"\\/>The first step to integrating Facebook comments is to sign up as a Facebook developer.  To do this you must enable and authorize the <strong>Facebook Developer<\\/strong> application to access your Facebook account. Visit the <a href=\\\"https:\\/\\/developers.facebook.com\\/apps\\\" target=\\\"_new\\\">FaceBook App Here<\\/a> and click <strong>\\\"Allow\\\"<\\/strong>.  The next step is to click the <strong>\\\"+ Create New App\\\"<\\/strong> button on the \\\"Apps\\\" page.  Enter something like <strong>\\\"MySite Comments\\\"<\\/strong> in the App Display Name field, and some unique name for the App Namespace, such as <strong>\\\"mysite-comments\\\"<\\/strong>, review and agree to the Facebook Platform Policies and click \\\"Continue\\\". Enter the Security Check validation and click \\\"Submit\\\".  The next page is the <strong>\\\"Basic Settings\\\"<\\/strong> and here you need to enter your domain for the <strong>App Domain<\\/strong>, eg: <strong class=\\\"under\\\">mysite.com<\\/strong>.  You also need to click the <strong>Website<\\/strong> block in the \\\"Select how your app integrates with Facebook\\\" section and put the URL of your website, eg: <strong class=\\\"under\\\">http:\\/\\/www.mysite.com<\\/strong>.<\\/p>\\n      <p>Lastly copy the <strong>App ID<\\/strong> value as you will need this to configure RokComments to use Facebook.<\\/p>\\n      <h3>Configure<\\/h3>\\n      <p>Open up the <strong>RokComments Content Plugin<\\/strong> via the <strong>Plugin Manager<\\/strong> in the Joomla Administrator.  Set the following attributes:<\\/p>\\n      <ol>\\n          <li>Set <strong>Comment System<\\/strong> to <strong class=\\\"under\\\">Facebook<\\/strong><\\/li>\\n          <li>Enable\\/Disable the <strong>Show Comment Count<\\/strong> option as you desire. <strong>Show Comment Icon<\\/strong> has no effect for Facebook.<\\/li>\\n          <li>If you are using <strong class=\\\"under\\\">Menus + Categories<\\/strong> for the Activation Method, ensure you select the correct <strong>Menus<\\/strong> and\\/or <strong>Categories<\\/strong> where you would like the comments to show.<\\/li>\\n          <li>In the <strong>Facebook AppId<\\/strong> input field, put the <strong class=\\\"under\\\">App ID<\\/strong> value you saved earlier. eg: <strong class=\\\"under\\\">236773289710058<\\/strong> <\\/li>\\n          <li>Enter the width in pixels of the comment area, just adjust this field till it fits nicely under your content<\\/li>\\n          <li>Enter a comma separated list of Facebook User IDs of people you want to be able to moderate these comments.  Alternatively you can moderate them via the <a href=\\\"http:\\/\\/developers.facebook.com\\/tools\\/comments\\\" target=\\\"_new\\\">Developer Tools<\\/a><\\/li>\\n      <\\/ol>\\n\\n      <a name=\\\"disqus\\\"><\\/a>\\n      <h2>Disqus<\\/h2>\\n      <p><img src=\\\"..\\/plugins\\/content\\/rokcomments\\/images\\/dis-shortname.jpg\\\" \\\"\\/>In order to use Disqus comments you need to first Sign Up at <a href=\\\"http:\\/\\/disqus.com\\/\\\" target=\\\"_new\\\">http:\\/\\/disqus.com<\\/a>.  After signing up you need to click the <strong>\\\"+ Add\\\"<\\/strong> button in the <strong>Your Sites<\\/strong> sidebar section.  Fill in the form with your information for the your site.<\\/p>\\n      <p>The <strong>\\\"shortname\\\"<\\/strong> is important as this is the unique identifier you will use when configuring RokComments.  On the Settings panel configure the options as you like, or just leave the defaults before hitting continue.  You will be able to moderate these comments directly by going to the shortname url, eg: <strong>http:\\/\\/mysite.disqus.com<\\/strong>.<\\/p>\\n      <h3>Configure<\\/h3>\\n      <p>Open up the <strong>RokComments Content Plugin<\\/strong> via the <strong>Plugin Manager<\\/strong> in the Joomla Administrator.  Set the following attributes:<\\/p>\\n      <ol>\\n          <li>Set <strong>Comment System<\\/strong> to <strong class=\\\"under\\\">Disqus<\\/strong><\\/li>\\n          <li>Enable\\/Disable the <strong>Show Comment Count<\\/strong> and the <strong>Show Comment Icon<\\/strong> options as you desire.<\\/li>\\n          <li>If you are using <strong class=\\\"under\\\">Menus + Categories<\\/strong> for the Activation Method, ensure you select the correct <strong>Menus<\\/strong> and\\/or <strong>Categories<\\/strong> where you would like the comments to show.<\\/li>\\n          <li>In the <strong>Disqus Shorname<\\/strong> input field, put the <strong class=\\\"under\\\">shortname<\\/strong> value you saved earlier. eg: <strong class=\\\"under\\\">mysite<\\/strong> <\\/li>\\n          <li>If you need to test the comments on an inaccessible website during development you can enable the <strong>Developer Mode<\\/strong> option here.<\\/li>\\n      <\\/ol>\\n\\n      <a name=\\\"livefyre\\\"><\\/a>\\n      <h2>Livefyre<\\/h2>\\n      <p><img src=\\\"..\\/plugins\\/content\\/rokcomments\\/images\\/lf-siteid.jpg\\\" \\\"\\/>The first step to installing Livefyre comments on your site is to Sign Up via the <a href=\\\"http:\\/\\/www.livefyre.com\\\" target=\\\"_new\\\">http:\\/\\/www.livefyre.com<\\/a> website.  When you have signed up, you should click <strong>\\\"Install\\\"<\\/strong> or go directly to the <a href=\\\"http:\\/\\/www.livefyre.com\\/install\\/\\\" target=\\\"_new\\\">install URL<\\/a>. Enter the URL of your site and then click the <strong>\\\"Custom\\\"<\\/strong> option for the <strong>Platform<\\/strong>, and then click the \\\"Keep Going!\\\" button.<\\/p>\\n      <p>That\'s all there is to it.  You will be provided with a chunk of JavaScript, but all you need to do is copy the numeric <strong>site_id<\\/strong> variable as this will be used to configure RokComments to use Livefyre.<\\/p>\\n\\n      <h3>Configure<\\/h3>\\n      <p>Open up the <strong>RokComments Content Plugin<\\/strong> via the <strong>Plugin Manager<\\/strong> in the Joomla Administrator.  Set the following attributes:<\\/p>\\n      <ol>\\n          <li>Set <strong>Comment System<\\/strong> to <strong class=\\\"under\\\">Livefyre<\\/strong><\\/li>\\n          <li>NOTE: Comment Counts are not supported in Livefyre currently, so those options will be ignored.<\\/li>\\n          <li>If you are using <strong class=\\\"under\\\">Menus + Categories<\\/strong> for the Activation Method, ensure you select the correct <strong>Menus<\\/strong> and\\/or <strong>Categories<\\/strong> where you would like the comments to show.<\\/li>\\n          <li>In the <strong>Livefyre Site ID<\\/strong> input field, put the <strong class=\\\"under\\\">site_id<\\/strong> value you saved earlier. eg: <strong class=\\\"under\\\">291224<\\/strong> <\\/li>\\n      <\\/ol>\\n      \\n      <\\/div>\\n      <style>\\n          .rc-wrapper h1 {margin-left:0;}\\n          .rc-wrapper h2 {margin-top:40px;color:#333;}\\n          span.readonly .rc-wrapper {font-weight:normal;}\\n          .rc-wrapper img {float:right;margin:0 0 20px 20px;}\\n          .rc-wrapper .under {text-decoration:underline;}\\n          .rc-wrapper li {list-style-type:decimal !important;margin-left:30px;}\\n          .plg-desc {margin-left:0 !Important;}\\n      <\\/style>\\n      \\n    \",\"group\":\"\"}','{\"system\":\"1\",\"spacer_global\":\"\",\"showcount\":\"1\",\"showicon\":\"rk-icon\",\"tagmode\":\"0\",\"method\":\"id\",\"spacer_menus_cats\":\"\",\"menus\":\"\",\"categories\":\"\",\"spacer_intense\":\"\",\"id-account\":\"\",\"spacer_facebook\":\"\",\"fb-appid\":\"\",\"fb-width\":\"500\",\"fb-postcount\":\"10\",\"fb-modid\":\"\",\"spacer_disq\":\"\",\"d-subdomain\":\"\",\"d-devmode\":\"0\",\"spacer_livefyre\":\"\",\"lf-siteid\":\"\",\"spacer_jskit\":\"\",\"js-domain\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(727,'Button - RokComments','plugin','rokcomments','editors-xtd',0,1,1,0,'{\"name\":\"Button - RokComments\",\"type\":\"plugin\",\"creationDate\":\"March 4, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.2\",\"description\":\"Inserts the plugin code for RokComments\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(729,'RokMiniEvents','module','mod_rokminievents','',0,1,1,0,'{\"name\":\"RokMiniEvents\",\"type\":\"module\",\"creationDate\":\"November 5, 2013\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2013 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.3\",\"description\":\"RokMiniEvents allows to share your Joomla! website Google Calendar Events\",\"group\":\"\"}','{\"builtin_css\":\"1\",\"set_widths\":\"1\",\"wrapper_width\":\"750\",\"item_number\":\"3\",\"sortorder\":\"ascending\",\"time_range\":\"predefined_ranges\",\"startmin\":\"\",\"startmax\":\"\",\"rangespan\":\"current_month\",\"show_description\":\"1\",\"strip_tags\":\"a,i,br\",\"trim_description\":\"1\",\"trim_count\":\"200\",\"localtime\":\"local\",\"timezone\":\"0\",\"dayformat\":\"%d\",\"monthformat\":\"%b\",\"yearformat\":\"%Y\",\"timeformat\":\"%I:%M %p\",\"datedisplay\":\"badge\",\"showyear\":\"0\",\"limit_count\":\"0\",\"events_pane\":\"3\",\"timeline\":\"arrows\",\"timeline_dates\":\"inline\",\"transition\":\"Expo.easeInOut\",\"duration\":\"500\",\"offset_x\":\"0\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(731,'System - RokBox','plugin','rokbox','system',0,1,1,0,'{\"name\":\"System - RokBox\",\"type\":\"plugin\",\"creationDate\":\"March 4, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.7\",\"description\":\"\\n        <div class=\\\"rokbox-description\\\">\\n        <img src=\\\"..\\/plugins\\/system\\/rokbox\\/assets\\/admin\\/images\\/rokbox.jpg\\\" class=\\\"img-padding\\\" \\/><h1>RokBox2<\\/h1>\\n        <p>RokBox2 is a fully responsive modal pop-up plug-in for Joomla.  It displays <strong>images<\\/strong>, <strong>videos<\\/strong>, <strong>embedded widgets<\\/strong>, <strong>Ajax content<\\/strong> and <strong>Joomla modules<\\/strong>.<\\/p>\\n\\n        <p>RokBox2 contains a <strong>Content plug-in<\\/strong> and <strong>Button Editor plug-in<\\/strong>. The <strong>Content plug-in<\\/strong> can auto-generate thumbnails of <strong>local images<\\/strong> that can be used as content for your RokBox2 links. All thumbnails generated are <strong>responsive<\\/strong> so that they can easily adapt to any device. The <strong>Button Editor plug-in<\\/strong> allows for easy creation of RokBox2 style snippets with just a few clicks.<\\/p>\\n        <p>RokBox2 also provides backward compatibility for RokBox1 style <code>{rokbox}<\\/code> syntax.<\\/p>\\n\\n        <h2>Key Features:<\\/h2>\\n        <ul class=\\\"features\\\">\\n            <li>HTML5 and CSS3<\\/li>\\n            <li>Fully Responsive<\\/li>\\n            <li>Auto thumbnails generator<\\/li>\\n            <li>Captions supporting HTML syntax<\\/li>\\n            <li>Ajax Content listener<\\/li>\\n            <li>Multiple media types supported:\\n                <ul class=\\\"features\\\">\\n                    <li>Images: base64 encoded, jpg, gif, png, bmp, webp<\\/li>\\n                    <li>HTML5 Video and Audio<\\/li>\\n                    <li>TwitPic<\\/li>\\n                    <li>Instagram<\\/li>\\n                    <li>YouTube<\\/li>\\n                    <li>Vimeo<\\/li>\\n                    <li>Telly (ex TwitVid)<\\/li>\\n                    <li>Metacafe<\\/li>\\n                    <li>Dailymotion<\\/li>\\n                    <li>Spotify<\\/li>\\n                    <li>Google Maps<\\/li>\\n                <\\/ul>\\n            <\\/li>\\n            <li>Fit\\/Unfit Screen: If an image is too big it gets shrunk to fit the view-port but you can always click the Fit Screen icon to expand it and scroll.<\\/li>\\n            <li>Albums to group related images<\\/li>\\n            <li>Key Bindings for easy navigation: <code>&larr;<\\/code> (Previous), <code>&rarr;<\\/code> (Next), <code>f<\\/code> Fitscreen\\/Unfitscreen, <code>esc<\\/code> Close<\\/li>\\n        <\\/ul>\\n\\n        <p class=\\\"note\\\"><strong>NOTE:<\\/strong> RokBox2 consists of 3 plug-ins: <strong>Content<\\/strong>, <strong>System<\\/strong> and <strong>Editor Button<\\/strong>. Make sure to have a look at all three plug-in manager pages to get an idea of what they do.<\\/p>\\n        <\\/div>\\n        \",\"group\":\"\"}','{\"backwards_compat\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(732,'Content - RokBox','plugin','rokbox','content',0,1,1,0,'{\"name\":\"Content - RokBox\",\"type\":\"plugin\",\"creationDate\":\"March 4, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.7\",\"description\":\"\\n        <div class=\\\"rokbox-description\\\">\\n        <img src=\\\"..\\/plugins\\/system\\/rokbox\\/assets\\/admin\\/images\\/rokbox.jpg\\\" class=\\\"img-padding\\\" \\/><h1>RokBox2<\\/h1>\\n        <p>Auto generates thumbnails of <strong>local images<\\/strong> that can be used as content for your RokBox2 links. All thumbnails generated are <strong>responsive<\\/strong> so that they can be easily adapted to any device. RokBox2 Content plugins also provides backward compatibility for the old discontinued RokBox1 that allowed writing snippets through the <code>{rokbox}<\\/code> syntax.<\\/p>\\n\\n        <p class=\\\"note\\\"><strong>NOTE:<\\/strong> RokBox2 comes with 3 plugins: <strong>Content<\\/strong>, <strong>System<\\/strong> and <strong>Editor Button<\\/strong>. Make sure to have a look at all three plugin manager pages to get an idea of what they do.<\\/p>\\n        <\\/div>\\n        \",\"group\":\"\"}','{\"backwards_compat\":\"0\",\"thumb_width\":\"150\",\"thumb_height\":\"100\",\"thumb_quality\":\"90\"}','','',0,'0000-00-00 00:00:00',1,0),(733,'Button - RokBox','plugin','rokbox','editors-xtd',0,1,1,0,'{\"name\":\"Button - RokBox\",\"type\":\"plugin\",\"creationDate\":\"March 4, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"2.0.7\",\"description\":\"This is an Editor Button to allow injection of RokBox snippets into your Content\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(737,'com_easydiscuss','component','com_easydiscuss','',1,1,0,0,'{\"name\":\"com_easydiscuss\",\"type\":\"component\",\"creationDate\":\"April 2014\",\"author\":\"StackIdeas\",\"copyright\":\"Copyright 2009 - 2012 Stack Ideas. All rights reserved\",\"authorEmail\":\"support@stackideas.com\",\"authorUrl\":\"http:\\/\\/www.stackideas.com\",\"version\":\"3.2.9422\",\"description\":\"\\n\\t\\tDiscussion extension for your Joomla! site.\\n\\t\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(738,'User - EasyBlog Users','plugin','easyblogusers','user',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(739,'com_easyblog','component','com_easyblog','',1,1,0,0,'{\"name\":\"com_easyblog\",\"type\":\"component\",\"creationDate\":\"12\\/02\\/2010\",\"author\":\"Stack Ideas\",\"copyright\":\"Copyright 2009-2012 Stack Ideas. All rights reserved\",\"authorEmail\":\"support@stackideas.com\",\"authorUrl\":\"http:\\/\\/www.stackideas.com\",\"version\":\"3.9.15633\",\"description\":\"\\n\\t\\tEasyBlog is a Joomla! blogging component that transforms your Joomla! site into a powerful multi-blogging website.\\n\\t\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(740,'plg_system_dpcalendar','plugin','dpcalendar','system',0,1,1,0,'{\"name\":\"plg_system_dpcalendar\",\"type\":\"plugin\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"PLG_SYSTEM_DPCALENDAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(741,'mod_dpcalendar_upcoming','module','mod_dpcalendar_upcoming','',0,1,0,0,'{\"name\":\"mod_dpcalendar_upcoming\",\"type\":\"module\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"MOD_DPCALENDAR_UPCOMING_XML_DESCRIPTION\",\"group\":\"\"}','{\"max_events\":\"5\",\"order\":\"asc\",\"filter\":\"\",\"ongoing\":\"0\",\"output_grouping\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(742,'mod_dpcalendar_counter','module','mod_dpcalendar_counter','',0,1,0,0,'{\"name\":\"mod_dpcalendar_counter\",\"type\":\"module\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"MOD_DPCALENDAR_COUNTER_XML_DESCRIPTION\",\"group\":\"\"}','{\"filter\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(743,'mod_dpcalendar_mini','module','mod_dpcalendar_mini','',0,1,0,0,'{\"name\":\"mod_dpcalendar_mini\",\"type\":\"module\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"MOD_DPCALENDAR_MINI_XML_DESCRIPTION\",\"group\":\"\"}','{\"compact_events\":\"2\",\"weekstart\":\"1\",\"titleformat_month\":\"M Y\",\"timeformat_month\":\"g:i a\",\"show_event_as_popup\":\"2\",\"popup_width\":\"\",\"popup_height\":\"500\",\"event_edit_popup\":\"1\",\"calendar_height\":\"\",\"event_color\":\"135CAE\"}','','',0,'0000-00-00 00:00:00',0,0),(744,'plg_search_dpcalendar','plugin','dpcalendar','search',0,1,1,0,'{\"name\":\"plg_search_dpcalendar\",\"type\":\"plugin\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"PLG_SEARCH_DPCALENDAR_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"0\",\"pastevents\":\"1\",\"date_format\":\"m.d.Y\",\"time_format\":\"g:i a\"}','','',0,'0000-00-00 00:00:00',0,0),(745,'com_dpcalendar','component','com_dpcalendar','',1,1,0,0,'{\"name\":\"com_dpcalendar\",\"type\":\"component\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\\n\\t\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"COM_DPCALENDAR_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(746,'dpcalendar','package','pkg_dpcalendar','',0,1,1,0,'{\"name\":\"DPCalendar\",\"type\":\"package\",\"creationDate\":\"May 2014\",\"author\":\"Digital Peak\",\"copyright\":\"(C) 2007 - 2014 Digital Peak. All rights reserved.\",\"authorEmail\":\"info@digital-peak.com\",\"authorUrl\":\"joomla.digital-peak.com\",\"version\":\"4.0.6\",\"description\":\"\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(747,'plg_system_kunena','plugin','kunena','system',0,1,1,0,'{\"name\":\"plg_system_kunena\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_SYSTEM_KUNENA_DESC\",\"group\":\"\"}','{\"jcontentevents\":\"0\",\"jcontentevent_target\":\"body\"}','','',0,'0000-00-00 00:00:00',0,0),(748,'plg_quickicon_kunena','plugin','kunena','quickicon',0,1,1,0,'{\"name\":\"plg_quickicon_kunena\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_QUICKICON_KUNENA_DESC\",\"group\":\"\"}','{\"context\":\"mod_quickicon\"}','','',0,'0000-00-00 00:00:00',0,0),(749,'Kunena Framework','library','kunena','',0,1,1,0,'{\"name\":\"Kunena Framework\",\"type\":\"library\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2013 Kunena Team. All rights reserved.\",\"authorEmail\":\"kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"Kunena Framework.\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(750,'Kunena Media Files','file','kunena_media','',0,1,0,0,'{\"name\":\"Kunena Media Files\",\"type\":\"file\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2013 Kunena Team. All rights reserved.\",\"authorEmail\":\"kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"Kunena media files.\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(751,'com_kunena','component','com_kunena','',1,1,0,0,'{\"name\":\"com_kunena\",\"type\":\"component\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2013 Kunena Team. All rights reserved.\",\"authorEmail\":\"kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"COM_KUNENA_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(752,'kunena','package','pkg_kunena','',0,1,1,0,'{\"name\":\"Kunena Forum Package\",\"type\":\"package\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2013 Kunena Team. All rights reserved.\",\"authorEmail\":\"kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"Kunena Forum Package.\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(753,'plg_kunena_alphauserpoints','plugin','alphauserpoints','kunena',0,0,1,0,'{\"name\":\"plg_kunena_alphauserpoints\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_ALPHAUSERPOINTS_DESCRIPTION\",\"group\":\"\"}','{\"activity\":\"1\",\"avatar\":\"1\",\"profile\":\"1\",\"activity_points_limit\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(754,'plg_kunena_community','plugin','community','kunena',0,0,1,0,'{\"name\":\"plg_kunena_community\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_COMMUNITY_DESCRIPTION\",\"group\":\"\"}','{\"access\":\"1\",\"login\":\"1\",\"activity\":\"1\",\"avatar\":\"1\",\"profile\":\"1\",\"private\":\"1\",\"activity_points_limit\":\"0\",\"activity_stream_limit\":\"0\"}','','',0,'0000-00-00 00:00:00',2,0),(755,'plg_kunena_comprofiler','plugin','comprofiler','kunena',0,0,1,0,'{\"name\":\"plg_kunena_comprofiler\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_COMPROFILER_DESCRIPTION\",\"group\":\"\"}','{\"access\":\"1\",\"login\":\"1\",\"activity\":\"1\",\"avatar\":\"1\",\"profile\":\"1\",\"private\":\"1\"}','','',0,'0000-00-00 00:00:00',3,0),(756,'plg_kunena_gravatar','plugin','gravatar','kunena',0,0,1,0,'{\"name\":\"plg_kunena_gravatar\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_GRAVATAR_DESCRIPTION\",\"group\":\"\"}','{\"avatar\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(757,'plg_kunena_uddeim','plugin','uddeim','kunena',0,0,1,0,'{\"name\":\"plg_kunena_uddeim\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_UDDEIM_DESCRIPTION\",\"group\":\"\"}','{\"private\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(758,'plg_kunena_kunena','plugin','kunena','kunena',0,1,1,0,'{\"name\":\"plg_kunena_kunena\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_KUNENA_DESCRIPTION\",\"group\":\"\"}','{\"avatar\":\"1\",\"profile\":\"1\"}','','',0,'0000-00-00 00:00:00',6,0),(759,'plg_kunena_joomla','plugin','joomla','kunena',0,1,1,0,'{\"name\":\"plg_kunena_joomla\",\"type\":\"plugin\",\"creationDate\":\"2014-03-09\",\"author\":\"Kunena Team\",\"copyright\":\"www.kunena.org\",\"authorEmail\":\"Kunena@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"3.0.5\",\"description\":\"PLG_KUNENA_JOOMLA_25_30_DESCRIPTION\",\"group\":\"\"}','{\"access\":\"1\",\"login\":\"1\"}','','',0,'0000-00-00 00:00:00',7,0),(760,'community','component','com_community','',1,1,0,0,'{\"name\":\"Community\",\"type\":\"component\",\"creationDate\":\"July 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"JomSocial is a social networking component for Joomla!\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(761,'Azrul System Mambot For Joomla','plugin','azrul.system','system',0,1,1,0,'{\"name\":\"Azrul System Mambot For Joomla\",\"type\":\"plugin\",\"creationDate\":\"July 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@azrul.com\",\"authorUrl\":\"www.azrul.com\",\"version\":\"3.0.5.3\",\"description\":\"\\n\\t\\tAjax System for Joomla, Azrul.com\\/JomSocial.com\\n\\t\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(762,'User - Jomsocial User','plugin','jomsocialuser','user',0,1,1,0,'{\"name\":\"User - Jomsocial User\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_JOMSOCIALUSER_XML_DESCRIPTION\",\"group\":\"\"}','{\"delete_jommla_contact\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(763,'Community - Walls','plugin','walls','community',0,1,1,0,'{\"name\":\"Community - Walls\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_WALLS_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"cache\":\"1\",\"position\":\"content\",\"charlimit\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(764,'System - Jomsocial Facebook Connect','plugin','jomsocialconnect','system',0,1,1,0,'{\"name\":\"System - Jomsocial Facebook Connect\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial\",\"copyright\":\"Copyright (C) 2008 - 2009. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_JOMSOCIALCONNECT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(765,'Jomsocial Update','plugin','jomsocialupdate','system',0,1,1,0,'{\"name\":\"Jomsocial Update\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"AzrulStudio\",\"copyright\":\"Copyright (C) 2010. All rights reserved.\",\"authorEmail\":\"support@azrul.com\",\"authorUrl\":\"www.azrul.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_JOMSOCIALUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(766,'Community - Events','plugin','events','community',0,1,1,0,'{\"name\":\"Community - Events\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_EVENTS_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"cache\":\"1\",\"sorting\":\"1\",\"position\":\"content|sidebar-top|sidebar-bottom\"}','','',0,'0000-00-00 00:00:00',0,0),(767,'Community - Feeds','plugin','feeds','community',0,1,1,0,'{\"name\":\"Community - Feeds\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_FEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{\"cache\":\"0\",\"coreapp\":\"0\",\"position\":\"content\",\"defaultprivacy\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(768,'Community - Friend\'s Location','plugin','friendslocation','community',0,1,1,0,'{\"name\":\"Community - Friend\'s Location\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_FRIENDSLOCATION_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"cache\":\"1\",\"position\":\"content\",\"town_field_code\":\"FIELD_CITY\",\"state_field_code\":\"FIELD_STATE\",\"country_field_code\":\"FIELD_COUNTRY\",\"count\":\"0\",\"show_karma\":\"1\",\"width\":\"480\",\"height\":\"340\"}','','',0,'0000-00-00 00:00:00',0,0),(769,'Community - Input Processor','plugin','input','community',0,1,1,0,'{\"name\":\"Community - Input Processor\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_INPUT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(770,'Community - Invite','plugin','invite','community',0,1,1,0,'{\"name\":\"Community - Invite\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_INVITE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(771,'Kunena Groups','plugin','kunenagroups','community',0,1,1,0,'{\"name\":\"Kunena Groups\",\"type\":\"plugin\",\"creationDate\":\"2012-11-24\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2012 Kunena Team. All rights reserved.\",\"authorEmail\":\"admin@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"2.0.3\",\"description\":\"PLG_COMMUNITY_KUNENAGROUPS_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"1\",\"category_mapping\":\"\",\"default_category\":\"0\",\"allow_categories\":\"\",\"deny_categories\":\"\",\"position\":\"content|sidebar-top|sidebar-bottom\"}','','',0,'0000-00-00 00:00:00',0,0),(772,'My Forum Menu','plugin','kunenamenu','community',0,1,1,0,'{\"name\":\"My Forum Menu\",\"type\":\"plugin\",\"creationDate\":\"2012-11-24\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2012 Kunena Team. All rights reserved.\",\"authorEmail\":\"admin@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"2.0.3\",\"description\":\"PLG_COMMUNITY_KUNENAMENU_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"sh_editprofile\":\"1\",\"sh_myprofile\":\"1\",\"sh_myposts\":\"1\",\"sh_mysubscriptions\":\"1\",\"sh_myfavorites\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(773,'My Forum Posts','plugin','mykunena','community',0,1,1,0,'{\"name\":\"My Forum Posts\",\"type\":\"plugin\",\"creationDate\":\"2012-11-24\",\"author\":\"Kunena Team\",\"copyright\":\"(C) 2008 - 2012 Kunena Team. All rights reserved.\",\"authorEmail\":\"admin@kunena.org\",\"authorUrl\":\"http:\\/\\/www.kunena.org\",\"version\":\"2.0.3\",\"description\":\"PLG_COMMUNITY_MYKUNENA_DESCRIPTION\",\"group\":\"\"}','{\"count\":\"5\",\"coreapp\":\"0\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(774,'System - Jomsocial Redirect','plugin','jomsocialredirect','system',0,0,1,0,'{\"name\":\"System - Jomsocial Redirect\",\"type\":\"plugin\",\"creationDate\":\"Aug 11 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"\",\"group\":\"\"}','{\"override_com_user_registration\":\"1\",\"redirect_previous\":\"0\",\"redirect_login\":\"1\",\"redirect_login_msg\":\"LOGIN_SUCCESSFUL\",\"redirect_login_failed\":\"1\",\"redirect_login_failed_msg\":\"LOGIN_FAILED\",\"redirect_logout\":\"1\",\"redirect_logout_msg\":\"YOU_HAVE_LOGGED_OUT\",\"redirect_registration_msg\":\"REDIRECTED_TO_COMMUNITY_REGISTRATION\"}','','',0,'0000-00-00 00:00:00',0,0),(775,'Community - My kunena updates','plugin','kunena','community',0,1,1,0,'{\"name\":\"Community - My kunena updates\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_KUNENA_XML_DESCRIPTION\",\"group\":\"\"}','{\"count\":\"5\",\"coreapp\":\"0\",\"position\":\"content\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(776,'Community - Latest Photos','plugin','latestphoto','community',0,1,1,0,'{\"name\":\"Community - Latest Photos\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_LATESTPHOTO_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"position\":\"content\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(777,'Community - My Articles','plugin','myarticles','community',0,1,1,0,'{\"name\":\"Community - My Articles\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_MYARTICLES_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"position\":\"content\",\"section\":\"\",\"limit\":\"50\",\"count\":\"10\",\"introtext\":\"0\",\"cache\":\"1\",\"display_expired\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(778,'Community - My Contacts','plugin','mycontacts','community',0,1,1,0,'{\"name\":\"Community - My Contacts\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_MYCONTACTS_XML_DESCRIPTION\",\"group\":\"\"}','{\"cache\":\"0\",\"coreapp\":\"0\",\"position\":\"content\",\"hide_empty\":\"0\",\"home_address\":\"1\",\"city\":\"1\",\"postal_code\":\"1\",\"country\":\"1\",\"phone_number\":\"1\",\"mobile_number\":\"1\",\"fax_number\":\"1\",\"website\":\"1\",\"my_company\":\"1\",\"work_address\":\"1\",\"comp_website\":\"1\",\"department\":\"1\",\"job_title\":\"1\",\"main_im_id\":\"1\",\"im_list\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(779,'Community - My Google Ads','plugin','mygoogleads','community',0,0,1,0,'{\"name\":\"Community - My Google Ads\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Google Ads application. Users will be able to insert their own Google ads on their profile page.\",\"group\":\"\"}','{\"coreapp\":\"0\",\"position\":\"content\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(780,'Community - My Tagged Videos','plugin','mytaggedvideos','community',0,1,1,0,'{\"name\":\"Community - My Tagged Videos\",\"type\":\"plugin\",\"creationDate\":\"Febuary 2012\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2012 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_MYTAGGEDVIDEOS_XML_DESCRIPTION\",\"group\":\"\"}','{\"coreapp\":\"0\",\"position\":\"content\",\"count\":\"10\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(781,'Community - My Latest Videos','plugin','myvideos','community',0,1,1,0,'{\"name\":\"Community - My Latest Videos\",\"type\":\"plugin\",\"creationDate\":\"Febuary 2012\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2012 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Display user\'s latest videos\",\"group\":\"\"}','{\"coreapp\":\"0\",\"position\":\"content\",\"count\":\"10\",\"cache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(782,'My twitter updates','plugin','twitter','community',0,0,1,0,'{\"name\":\"My twitter updates\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_TWITTER_XML_DESCRIPTION\",\"group\":\"\"}','{\"cache\":\"0\",\"position\":\"content\",\"coreapp\":\"0\",\"consumerKey\":\"\",\"consumerSecret\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(783,'Community - Wordfilter','plugin','wordfilter','community',0,1,1,0,'{\"name\":\"Community - Wordfilter\",\"type\":\"plugin\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright 2008 - 2010 by Slashes & Dots Sdn Bhd. All rights reserved\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"PLG_WORDFILTER_XML_DESCRIPTION\",\"group\":\"\"}','{\"replacement\":\"*\",\"badwords\":\"fuck,shit\"}','','',0,'0000-00-00 00:00:00',0,0),(784,'Community - Active Groups','module','mod_activegroups','',0,1,0,0,'{\"name\":\"Community - Active Groups\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Display most active groups from groups that is created within JomSocial\",\"group\":\"\"}','{\"cache\":\"1\",\"count\":\"5\",\"show_avatar\":\"1\",\"show_total\":\"1\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(785,'Community - Activity Stream','module','mod_activitystream','',0,1,0,0,'{\"name\":\"Community - Activity Stream\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Activity Stream\",\"group\":\"\"}','{\"max_entry\":\"10\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(786,'Community - Events Module','module','mod_community_events','',0,1,0,0,'{\"name\":\"Community - Events Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Latest Event\",\"group\":\"\"}','{\"moduleclass_sfx\":\"cModule cFrontPage-LatestEvents app-box\",\"default\":\"5\"}','','',0,'0000-00-00 00:00:00',0,0),(787,'Community - Groups Module','module','mod_community_groups','',0,1,0,0,'{\"name\":\"Community - Groups Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Latest Groups\",\"group\":\"\"}','{\"moduleclass_sfx\":\" cModule cFrontPage-LatestGroups app-box\",\"default\":\"5\"}','','',0,'0000-00-00 00:00:00',0,0),(788,'Community - Members Module','module','mod_community_members','',0,1,0,0,'{\"name\":\"Community - Members Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Latest Members\",\"group\":\"\"}','{\"moduleclass_sfx\":\" cModule cFrontPage-LatestMembers app-box\",\"default\":\"5\"}','','',0,'0000-00-00 00:00:00',0,0),(789,'Community - Photos Module','module','mod_community_photos','',0,1,0,0,'{\"name\":\"Community - Photos Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Photos\",\"group\":\"\"}','{\"moduleclass_sfx\":\"cModule cFrontPage-LatestPhotos app-box\",\"default\":\"20\"}','','',0,'0000-00-00 00:00:00',0,0),(790,'Community - Quick Search Module','module','mod_community_quicksearch','',0,1,0,0,'{\"name\":\"Community - Quick Search Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Community Quick Search\",\"group\":\"\"}','{\"moduleclass_sfx\":\"cModule cFrontPage-Search app-box\"}','','',0,'0000-00-00 00:00:00',0,0),(791,'Community - Videos Module','module','mod_community_videos','',0,1,0,0,'{\"name\":\"Community - Videos Module\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Lates Video\",\"group\":\"\"}','{\"moduleclass_sfx\":\"cModule cFrontPage-LatestVideos app-box\",\"default\":\"5\"}','','',0,'0000-00-00 00:00:00',0,0),(792,'Community - Whos Online','module','mod_community_whosonline','',0,1,0,0,'{\"name\":\"Community - Whos Online\",\"type\":\"module\",\"creationDate\":\"April 2013\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2013 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Whos online\",\"group\":\"\"}','{\"moduleclass_sfx\":\"cModule cFrontPage-ShowOnline app-box\",\"default\":\"20\"}','','',0,'0000-00-00 00:00:00',0,0),(793,'Community - Dating Search','module','mod_datingsearch','',0,1,0,0,'{\"name\":\"Community - Dating Search\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Dating Search\",\"group\":\"\"}','{\"field_gender\":\"FIELD_GENDER\",\"field_birthdate\":\"FIELD_BIRTHDATE\",\"field_country\":\"FIELD_COUNTRY\",\"field_state\":\"FIELD_STATE\",\"field_city\":\"FIELD_CITY\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(794,'Community - Hello Me','module','mod_hellome','',0,1,0,0,'{\"name\":\"Community - Hello Me\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Hello Me\",\"group\":\"\"}','{\"cache\":\"0\",\"customCache\":\"1\",\"show_avatar\":\"1\",\"show_karma\":\"1\",\"enable_login\":\"1\",\"enable_facebookconnect\":\"1\",\"enable_alert\":\"1\",\"enable_last_status\":\"1\",\"enable_edit_status\":\"1\",\"enable_menu\":\"1\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(795,'Community - JomSocial Connect','module','mod_jomsocialconnect','',0,1,0,0,'{\"name\":\"Community - JomSocial Connect\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Displays facebook connect logo\",\"group\":\"\"}','{\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(796,'Community - Latest Discussion','module','mod_latestdiscussion','',0,1,0,0,'{\"name\":\"Community - Latest Discussion\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Show the active discussion\",\"group\":\"\"}','{\"cache\":\"1\",\"count\":\"5\",\"show_avatar\":\"1\",\"repeat_avatar\":\"1\",\"show_private_discussion\":\"1\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(797,'Community - Latest group posts','module','mod_latestgrouppost','',0,1,0,0,'{\"name\":\"Community - Latest group posts\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Show recent wall posts from groups\",\"group\":\"\"}','{\"cache\":\"0\",\"count\":\"5\",\"charcount\":\"100\",\"afterlogin_setting\":\"\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(798,'Community - Jomsocial Notification','module','mod_notify','',0,1,0,0,'{\"name\":\"Community - Jomsocial Notification\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"This module is meant to display the three JomSocial notifications; global notification, friend requests and private messages. Please make sure this module is made visible for Registered users only.\",\"group\":\"\"}','{\"cache\":\"0\",\"customCache\":\"1\",\"show_global_notification\":\"1\",\"show_friend_request\":\"1\",\"enable_private_message\":\"1\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(799,'Community - Photo Comments','module','mod_photocomments','',0,1,0,0,'{\"name\":\"Community - Photo Comments\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Displays recent photo walls\",\"group\":\"\"}','{\"moduleclass_sfx\":\"\",\"count\":\"5\",\"show_avatar\":\"1\",\"character_limit\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(800,'Community - JomSocial Statistics','module','mod_statistics','',0,1,0,0,'{\"name\":\"Community - JomSocial Statistics\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"JomSocial Statistics\",\"group\":\"\"}','{\"cache\":\"0\",\"customCache\":\"1\",\"members\":\"1\",\"groups\":\"1\",\"discussions\":\"1\",\"albums\":\"1\",\"photos\":\"1\",\"videos\":\"1\",\"bulletins\":\"1\",\"activities\":\"1\",\"walls\":\"1\",\"events\":\"1\",\"genders\":\"1\",\"genders_male\":\"1\",\"genders_female\":\"1\",\"genders_unspecified\":\"1\",\"genders_fieldcode\":\"FIELD_GENDER\",\"genders_male_display\":\"Male\",\"genders_female_display\":\"Female\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(801,'Community - Top Members','module','mod_topmembers','',0,1,0,0,'{\"name\":\"Community - Top Members\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Show the top members\",\"group\":\"\"}','{\"cache\":\"1\",\"count\":\"10\",\"show_avatar\":\"1\",\"show_karma\":\"1\",\"moduleclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(802,'Community - Video Comments','module','mod_videocomments','',0,1,0,0,'{\"name\":\"Community - Video Comments\",\"type\":\"module\",\"creationDate\":\"March 2011\",\"author\":\"JomSocial Team\",\"copyright\":\"Copyright (C) 2008 - 2010 JomSocial. All rights reserved.\",\"authorEmail\":\"support@jomsocial.com\",\"authorUrl\":\"http:\\/\\/www.jomsocial.com\",\"version\":\"3.0.5.3\",\"description\":\"Displays recent video walls\",\"group\":\"\"}','{\"moduleclass_sfx\":\"\",\"count\":\"5\",\"show_avatar\":\"1\",\"character_limit\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(803,'com_ijoomlainstaller','component','com_ijoomlainstaller','',1,1,0,0,'{\"name\":\"COM_IJOOMLAINSTALLER\",\"type\":\"component\",\"creationDate\":\"September 11, 2013\",\"author\":\"iJoomla\",\"copyright\":\"C) 2011 iJoomla.com\",\"authorEmail\":\"webmaster2@ijoomla.com\",\"authorUrl\":\"www.iJoomla.com\",\"version\":\"1.0.0\",\"description\":\"\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(804,'plg_content_ozio','plugin','ozio','content',0,1,1,0,'{\"name\":\"plg_content_ozio\",\"type\":\"plugin\",\"creationDate\":\"2013\",\"author\":\"Vamba\",\"copyright\":\"Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.\",\"authorEmail\":\"oziogallery3@joomla.it\",\"authorUrl\":\"www.joomla.it\",\"version\":\"4.2.0\",\"description\":\"COM_OZIOGALLERY3_PLG_OZIO_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(805,'plg_editors-xtd_oziogallery','plugin','oziogallery','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_oziogallery\",\"type\":\"plugin\",\"creationDate\":\"2013\",\"author\":\"Open Source Solutions\",\"copyright\":\"Open Source Solutions\",\"authorEmail\":\"demis@opensourcesolutions.es\",\"authorUrl\":\"http:\\/\\/www.opensourcesolutions.es\\/\",\"version\":\"4.0.3\",\"description\":\"PLG_EDITORS-XTD_OZIOGALLERY_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(806,'oziofullscreen','template','oziofullscreen','',0,1,1,0,'{\"name\":\"oziofullscreen\",\"type\":\"template\",\"creationDate\":\"2013\",\"author\":\"Garda Informatica\",\"copyright\":\"(C) 2013 - Garda Informatica\",\"authorEmail\":\"info@gardainformatica.it\",\"authorUrl\":\"http:\\/\\/www.gardainformatica.it\",\"version\":\"1.0.1\",\"description\":\"Ozio Fullscreen Template for Joomla! 3\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(807,'com_oziogallery3','component','com_oziogallery3','',1,1,0,0,'{\"name\":\"com_oziogallery3\",\"type\":\"component\",\"creationDate\":\"2013\",\"author\":\"Alexred\",\"copyright\":\"(C) 2008 - 2014 - TOT The Ozio Team\",\"authorEmail\":\"info@joomla.it\",\"authorUrl\":\"http:\\/\\/www.joomla.it\",\"version\":\"4.2.1\",\"description\":\"Ozio Gallery for Joomla! 3\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(809,'Gantry','library','lib_gantry','',0,1,1,0,'{\"name\":\"Gantry\",\"type\":\"library\",\"creationDate\":\"April 12, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"4.1.24\",\"description\":\"Gantry Starting Template for Joomla! v4.1.24\",\"group\":\"\"}','{}','{\"last_update\":1401884193}','',0,'0000-00-00 00:00:00',0,0),(811,'SpanishES','language','es-ES','',0,1,0,0,'{\"name\":\"Spanish (ES)\",\"type\":\"language\",\"creationDate\":\"2014-5-4\",\"author\":\"Spanish Translation Team: Comunidad Joomla\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters and comunidadjoomla.org. All rights reserved.\",\"authorEmail\":\"info@comunidadjoomla.org\",\"authorUrl\":\"www.comunidadjoomla.org\",\"version\":\"3.3.0.1\",\"description\":\"Spanish language pack for Joomla! 3.3.0 - Site\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(812,'SpanishES','language','es-ES','',1,1,0,0,'{\"name\":\"Spanish (ES)\",\"type\":\"language\",\"creationDate\":\"2014-3-7\",\"author\":\"Spanish Translation Team: Comunidad Joomla\",\"copyright\":\"Copyright (C) 2005 - 2014 Open Source Matters and comunidadjoomla.org. All rights reserved.\",\"authorEmail\":\"info@comunidadjoomla.org\",\"authorUrl\":\"www.comunidadjoomla.org\",\"version\":\"3.3.0.1\",\"description\":\"Spanish language pack for Joomla! 3.3.0 - Administrator\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(813,'es-ES','package','pkg_es-ES','',0,1,1,0,'{\"name\":\"Spanish Language Pack\",\"type\":\"package\",\"creationDate\":\"5 de mayo del 2014\",\"author\":\"Spanish Translation Team: comunidadjoomla.org\",\"copyright\":\"Copyright (C) 2005 - 2014 comunidadjoomla.org and Open Source Matters. All rights reserved.\",\"authorEmail\":\"info@comunidadjoomla.org\",\"authorUrl\":\"www.comunidadjoomla.org\",\"version\":\"3.3.0.1\",\"description\":\"\\n\\t\\t<div style=\\\"text-align:left;\\\">\\n\\t\\t<h2>Successfully installed the spanish language pack for Joomla! 3.3.0.<\\/h2>\\n\\t\\t<p><\\/p>\\n\\t\\t<p>Please report any bugs or issues at the Comunidad Joomla! <a href=\\\"http:\\/\\/foro.comunidadjoomla.org\\/traduccion-ext\\/\\\" target=\\\"_blank\\\">Translation forum<\\/a><\\/p>\\n\\t\\t<p><\\/p>\\n\\t\\t<p>Translated by: <a href=\\\"http:\\/\\/www.comunidadjoomla.org\\\" target=\\\"_blank\\\" title=\\\"\\\">The spanish translation team of Comunidad Joomla!<\\/a><\\/p>\\n\\t\\t<h2>El paquete en espa\\u00f1ol para Joomla! 3.3.0 se ha instalado correctamente.<\\/h2>\\n\\t\\t<p><\\/p>\\n\\t\\t<p>Por favor, reporte cualquier bug o asunto relacionado a nuestro <a href=\\\"http:\\/\\/foro.comunidadjoomla.org\\/traduccion-ext\\/\\\" target=\\\"_blank\\\">Foro de traducciones<\\/a><\\/p>\\n\\t\\t<p><\\/p>\\n\\t\\t<p>Traducci\\u00f3n: <a href=\\\"http:\\/\\/www.comunidadjoomla.org\\\" target=\\\"_blank\\\" title=\\\"\\\">El equipo de traducci\\u00f3n de Comunidad Joomla!<\\/a><\\/p>\\n\\t\\t<\\/div>\\n\\t\\t\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(814,'com_phocadownload','component','com_phocadownload','',1,1,0,0,'{\"name\":\"com_phocadownload\",\"type\":\"component\",\"creationDate\":\"20\\/02\\/2014\",\"author\":\"Jan Pavelka (www.phoca.cz)\",\"copyright\":\"Jan Pavelka\",\"authorEmail\":\"\",\"authorUrl\":\"www.phoca.cz\",\"version\":\"3.0.4\",\"description\":\"Phoca Download\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(815,'admintools','component','com_admintools','',1,1,0,0,'{\"name\":\"Admintools\",\"type\":\"component\",\"creationDate\":\"2014-05-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2010 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"3.0.0\",\"description\":\"Security and utilitarian tools for Joomla! site administrators\",\"group\":\"\"}','{\"scandiffs\":\"0\",\"scanemail\":\"\",\"showstats\":\"1\",\"longconfigpage\":\"0\",\"downloadid\":\"1bb3b07cfa7012236ad81101a810dcb1\"}','','',0,'0000-00-00 00:00:00',0,0),(816,'System - Admin Tools','plugin','admintools','system',0,1,1,0,'{\"name\":\"System - Admin Tools\",\"type\":\"plugin\",\"creationDate\":\"2014-05-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2010 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"3.0.0\",\"description\":\"\\n\\t\\tHandles URL redirections defined in Admin Tools, fends off common attacks\\n\\t\\tand automates session table and cache clean-up\\n\\t\",\"group\":\"\"}','{\"language_override\":\"\",\"@spacer\":\"\",\"sesoptimizer\":\"0\",\"sesopt_freq\":\"60\",\"sescleaner\":\"0\",\"ses_freq\":\"60\",\"cachecleaner\":\"0\",\"cache_freq\":\"1440\",\"cacheexpire\":\"0\",\"cacheexp_freq\":\"60\",\"cleantemp\":\"0\",\"cleantemp_freq\":\"60\",\"deleteinactive\":\"0\",\"deleteinactive_days\":\"7\",\"maxlogentries\":\"0\"}','','',0,'0000-00-00 00:00:00',-1,0),(817,'System - One Click Action','plugin','oneclickaction','system',0,1,1,0,'{\"name\":\"System - One Click Action\",\"type\":\"plugin\",\"creationDate\":\"2011-05-26\",\"author\":\"Nicholas K. Dionysopoulos \\/ AkeebaBackup.com\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"2.1\",\"description\":\"PLG_ONCECLICK_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(818,'System - Admin Tools Update Email','plugin','atoolsupdatecheck','system',0,0,1,0,'{\"name\":\"System - Admin Tools Update Email\",\"type\":\"plugin\",\"creationDate\":\"2011-05-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATOOLSUPDATECHECK_DESCRIPTION2\",\"group\":\"\"}','{\"language_override\":\"\",\"email\":\"\",\"singleclick\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(819,'System - Admin Tools Joomla! Update Email','plugin','atoolsjupdatecheck','system',0,1,1,0,'{\"name\":\"System - Admin Tools Joomla! Update Email\",\"type\":\"plugin\",\"creationDate\":\"2011-05-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATOOLSJUPDATECHECK_DESCRIPTION2\",\"group\":\"\"}','{\"language_override\":\"\",\"email\":\"\",\"singleclick\":\"0\",\"lastrun\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(820,'plg_installer_admintools','plugin','admintools','installer',0,1,1,0,'{\"name\":\"plg_installer_admintools\",\"type\":\"plugin\",\"creationDate\":\"2014-03-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_INSTALLER_ADMINTOOLS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(821,'FOF','library','lib_f0f','',0,1,1,0,'{\"name\":\"FOF\",\"type\":\"library\",\"creationDate\":\"2014-05-02 19:14:41\",\"author\":\"Nicholas K. Dionysopoulos \\/ Akeeba Ltd\",\"copyright\":\"(C)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"https:\\/\\/www.akeebabackup.com\",\"version\":\"2.3.0\",\"description\":\"Framework-on-Framework (FOF) - The rapid component development framework for Joomla!. This package is the newer version of FOF, not the one shipped with Joomla! as the official Joomla! RAD Layer. The Joomla! RAD Layer has ceased development in March 2014.\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(822,'AkeebaStrapper','file','files_strapper','',0,1,0,0,'{\"name\":\"AkeebaStrapper\",\"type\":\"file\",\"creationDate\":\"2014-05-02 19:14:41\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"(C) 2012-2013 Akeeba Ltd.\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"https:\\/\\/www.akeebabackup.com\",\"version\":\"2.3.0\",\"description\":\"Namespaced jQuery, jQuery UI and Bootstrap for Akeeba products.\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(823,'akeeba','component','com_akeeba','',1,1,0,0,'{\"name\":\"Akeeba\",\"type\":\"component\",\"creationDate\":\"2014-05-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2006-2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"3.11.0\",\"description\":\"Akeeba Backup Pro - Full Joomla! site backup solution, Professional Edition\",\"group\":\"\"}','{\"frontend_enable\":\"0\",\"failure_frontend_enable\":\"0\",\"frontend_secret_word\":\"\",\"frontend_email_on_finish\":\"0\",\"frontend_email_address\":\"\",\"frontend_email_subject\":\"\",\"frontend_email_body\":\"\",\"failure_timeout\":180,\"failure_email_address\":\"\",\"failure_email_subject\":\"\",\"failure_email_body\":\"\",\"siteurl\":\"http:\\/\\/localhost\\/joomla32\\/\",\"jversion\":\"1.6\",\"jlibrariesdir\":\"C:\\/xampp\\/htdocs\\/joomla32\\/libraries\",\"lastversion\":\"3.11.0\",\"angieupgrade\":\"1\",\"update_dlid\":\"1bb3b07cfa7012236ad81101a810dcb1\",\"displayphpwarning\":\"1\",\"autoupdateCli\":\"1\",\"notificationFreq\":\"1\",\"notificationTime\":\"day\",\"notificationEmail\":\"\",\"useencryption\":\"1\",\"dateformat\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(824,'plg_installer_akeebabackup','plugin','akeebabackup','installer',0,1,1,0,'{\"name\":\"plg_installer_akeebabackup\",\"type\":\"plugin\",\"creationDate\":\"2014-03-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_INSTALLER_AKEEBABACKUP_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(825,'plg_quickicon_akeebabackup','plugin','akeebabackup','quickicon',0,1,1,0,'{\"name\":\"plg_quickicon_akeebabackup\",\"type\":\"plugin\",\"creationDate\":\"2012-09-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_QUICKICON_AKEEBABACKUP_XML_DESCRIPTION\",\"group\":\"\"}','{\"context\":\"mod_quickicon\",\"enablewarning\":\"1\",\"warnfailed\":\"1\",\"maxbackupperiod\":\"24\"}','','',0,'0000-00-00 00:00:00',0,0),(826,'PLG_SYSTEM_AKEEBAUPDATECHECK_TITLE','plugin','akeebaupdatecheck','system',0,0,1,0,'{\"name\":\"PLG_SYSTEM_AKEEBAUPDATECHECK_TITLE\",\"type\":\"plugin\",\"creationDate\":\"2011-05-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2009-2014 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.1\",\"description\":\"PLG_AKEEBAUPDATECHECK_DESCRIPTION2\",\"group\":\"\"}','{\"language_override\":\"\",\"email\":\"\",\"singleclick\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(827,'PLG_SYSTEM_BACKUPONUPDATE_TITLE','plugin','backuponupdate','system',0,1,1,0,'{\"name\":\"PLG_SYSTEM_BACKUPONUPDATE_TITLE\",\"type\":\"plugin\",\"creationDate\":\"2013-08-13\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2009-2014 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"3.7\",\"description\":\"PLG_SYSTEM_BACKUPONUPDATE_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(828,'PLG_SRP_TITLE','plugin','srp','system',0,0,1,0,'{\"name\":\"PLG_SRP_TITLE\",\"type\":\"plugin\",\"creationDate\":\"2014-05-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"3.11.0\",\"description\":\"PLG_SRP_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(829,'akeebabackup - es-ES','file','es-ES','',0,1,0,0,'{\"name\":\"akeebabackup - es-ES\",\"type\":\"file\",\"creationDate\":\"06 May 2014\",\"author\":\"AkeebaBackup.com\",\"copyright\":\"Copyright (C)2014 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"\",\"version\":\"\\/Users\\/nicholas\\/Projects\\/akeeba\\/abcore\\/build\\/..\",\"description\":\"Spanish (Spain) translation file for Akeeba Backup\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(830,'com_ats','component','com_ats','',1,1,0,0,'{\"name\":\"com_ats\",\"type\":\"component\",\"creationDate\":\"2014-05-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.5.0\",\"description\":\"A very simple ticket support system\",\"group\":\"\"}','{\"downloadid\":\"1bb3b07cfa7012236ad81101a810dcb1\",\"editor\":\"bbcode\",\"bbcodeuas\":\"; Android,iPad;,iPhone;,; Windows Phone OS,Windows Phone,; Windows CE,BlackBerry;,; Blazer,; BOLT\\/,\\/SymbianOS,(Symbian),Fennec\\/,GoBrowser\\/,Iris\\/,Maemo Browser,MIB\\/,Minimo\\/,NetFront\\/,Opera Mobi\\/,Opera Mini\\/,SEMC-Browser\\/,Skyfire\\/,TeaShark\\/,Teleca Q,uZardWeb\\/\",\"filtermethod\":\"htmlpurifier\",\"htmlpurifier_include\":\"1\",\"htmlpurifier_configstring\":\"p,b,a[href],i,u,strong,em,small,big,span[style],font[size],font[color],ul,ol,li,br,img[src],img[width],img[height],code,pre,blockquote\",\"transliteration\":\"\\u03b1|a,\\u03b2|v,\\u03b3|g,\\u03b4|d,\\u03b5|e,\\u03b6|z,\\u03b7|i,\\u03b8|th,\\u03b9|i,\\u03ba|k,\\u03bb|l,\\u03bc|m,\\u03bd|n,\\u03be|x,\\u03bf|o,\\u03c0|p,\\u03c1|r,\\u03c3|s,\\u03c2|s,\\u03c4|t,\\u03c5|y,\\u03c6|f,\\u03c7|ch,\\u03c8|ps,\\u03c9|o,\\u03ac|a,\\u03ad|e,\\u03ae|i,\\u03af|i,\\u03cc|o,\\u03cd|y,\\u03ce|o,\\u03ca|i,\\u03cb|y,\\u0390|i,\\u03b0|y,\\u00e0|a,\\u00e1|a,\\u00e2|a,\\u00e4|a,\\u00e6|ae,\\u00e3|a,\\u00e5|a,\\u0101|a,\\u00e7|c,\\u0107|c,\\u010d|c,\\u00e8|e,\\u00e9|e,\\u00ea|e,\\u00eb|e,\\u0113|e,\\u0117|e,\\u0119|e,\\u00ee|i,\\u00ef|i,\\u00ed|i,\\u012b|i,\\u012f|i,\\u00ec|i,\\u0142|i,\\u00f1|n,\\u0144|n,\\u00f4|o,\\u00f6|o,\\u00f2|o,\\u00f3|o,\\u0153|oe,\\u00f8|o,\\u014d|o,\\u00f5|o,\\u00df|s,\\u015b|s,\\u0161|s,\\u00fb|u,\\u00fc|u,\\u00f9|u,\\u00fa|u,\\u016b|u,\\u00ff|y,\\u017e|z,\\u017a|z,\\u017c|z,\\u0430|a,\\u0431|b,\\u0432|v,\\u0433|g,\\u0434|d,\\u0435|e,\\u0451|e,\\u0436|zh,\\u0437|z,\\u0438|i,\\u0439|i,\\u043a|k,\\u043b|l,\\u043c|m,\\u043d|n,\\u043e|o,\\u043f|p,\\u0440|r,\\u0441|s,\\u0442|t,\\u0443|y,\\u0444|f,\\u0445|kh,\\u0446|ts,\\u0447|ch,\\u0448|sh,\\u0449|sh,\\u044b|y,\\u044d|e,\\u044e|yu,\\u044f|ya\",\"ticketPriorities\":\"0\",\"assigned_noemail\":\"0\",\"customStatuses\":\"\",\"editeableforxminutes\":\"15\",\"attachments_private\":\"0\",\"nonewtickets\":\"0\",\"noreplies\":\"0\",\"showcredits\":\"0\",\"userfeedback\":\"0\",\"ajaxreplies\":\"1\",\"instantreplies_daylimit\":30,\"refundonunpublishticket\":\"1\",\"refundondeleteticket\":\"1\",\"refundonunpublishpost\":\"1\",\"refundondeletepost\":\"1\",\"maxattachmentage\":\"30\",\"maxinactiveticket\":\"30\",\"silentticketcloseage\":\"60\",\"botusers\":\"\",\"siteurl\":\"http:\\/\\/localhost\\/joomla32\\/\",\"replybyemail\":\"0\",\"emailadminonly\":\"0\",\"newbyemail\":\"0\",\"email_default_category\":[\"0\"],\"gmail\":\"0\",\"mailboxtype\":\"imap\",\"email_server\":\"imap.gmail.com\",\"email_port\":\"\",\"email_ssl\":\"0\",\"email_tls\":\"1\",\"email_validate_certificate\":\"1\",\"email_username\":\"\",\"email_password\":\"\",\"email_folder\":\"INBOX\",\"email_delete\":\"1\",\"email_checkevery\":\"5\",\"email_lastcheck\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(831,'Akeeba Ticket System - Credits info','module','mod_atscredits','',0,1,0,0,'{\"name\":\"Akeeba Ticket System - Credits info\",\"type\":\"module\",\"creationDate\":\"June 2013\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (C) 2011-2013 Nicholas K. Dionysopoulos \\/ AkeebaBackup.com\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"MOD_ATSCREDITS_DESCRIPTION\",\"group\":\"\"}','{\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\"}','','',0,'0000-00-00 00:00:00',0,0),(832,'PLG_ATS_ALPHAUSERPOINTS','plugin','alphauserpoints','ats',0,0,1,0,'{\"name\":\"PLG_ATS_ALPHAUSERPOINTS\",\"type\":\"plugin\",\"creationDate\":\"April 2013\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATS_ALPHAUSERPOINTS_XML_DESCRIPTION\",\"group\":\"\"}','[]','','',0,'0000-00-00 00:00:00',0,0),(833,'PLG_ATS_CUSTOMFIELDS','plugin','customfields','ats',0,1,1,0,'{\"name\":\"PLG_ATS_CUSTOMFIELDS\",\"type\":\"plugin\",\"creationDate\":\"August 2012\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATS_CUSTOMFIELDS_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(834,'PLG_ATS_GRAVATAR','plugin','gravatar','ats',0,1,1,0,'{\"name\":\"PLG_ATS_GRAVATAR\",\"type\":\"plugin\",\"creationDate\":\"November 2012\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATS_GRAVATAR_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(835,'PLG_ATS_POSTEMAIL_NAME','plugin','postemail','ats',0,1,1,0,'{\"name\":\"PLG_ATS_POSTEMAIL_NAME\",\"type\":\"plugin\",\"creationDate\":\"2011-12-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATS_POSTEMAIL_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(836,'PLG_ATS_SOCIALLIKE_NAME','plugin','sociallike','ats',0,0,1,0,'{\"name\":\"PLG_ATS_SOCIALLIKE_NAME\",\"type\":\"plugin\",\"creationDate\":\"2013-11-26\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2011-2013 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_ATS_SOCIALLIKE_DESCRIPTION\",\"group\":\"\"}','{\"button_facebook\":\"1\",\"button_twitter\":\"1\",\"button_gplus\":\"1\",\"button_linkedin\":\"1\",\"button_stumbleupon\":\"1\",\"button_pinterest\":\"1\",\"button_addthis\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(837,'Content - Akeeba Ticket System Credits Left','plugin','atscredits','content',0,1,1,0,'{\"name\":\"Content - Akeeba Ticket System Credits Left\",\"type\":\"plugin\",\"creationDate\":\"June 2013\",\"author\":\"Nicholas K. Dionysopoulos \\/ AkeebaBackup.com\",\"copyright\":\"(C) 2011-2013 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_CONTENT_ATSCREDITS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(838,'plg_finder_ats','plugin','ats','finder',0,1,1,0,'{\"name\":\"plg_finder_ats\",\"type\":\"plugin\",\"creationDate\":\"June 2012\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (C) 2011 - 2012 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nikosdion@gmail.com\",\"authorUrl\":\"www.AkeebaBackup.com\",\"version\":\"1.0\",\"description\":\"PLG_FINDER_ATS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(839,'plg_installer_akeebaticketsystem','plugin','akeebaticketsystem','installer',0,1,1,0,'{\"name\":\"plg_installer_akeebaticketsystem\",\"type\":\"plugin\",\"creationDate\":\"2014-03-06\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (c)2012 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"http:\\/\\/www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_INSTALLER_AKEEBATICKETSYSTEM_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(840,'plg_search_ats','plugin','ats','search',0,1,1,0,'{\"name\":\"plg_search_ats\",\"type\":\"plugin\",\"creationDate\":\"January 2012\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (C) 2011 - 2012 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nikosdion@gmail.com\",\"authorUrl\":\"www.AkeebaBackup.com\",\"version\":\"1.0\",\"description\":\"PLG_SEARCH_ATS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\"}','','',0,'0000-00-00 00:00:00',0,0),(841,'sh404sef - Akeeba Ticket System','plugin','com_ats','sh404sefextplugins',0,1,1,0,'{\"name\":\"sh404sef - Akeeba Ticket System\",\"type\":\"plugin\",\"creationDate\":\"February 2014\",\"author\":\"Nicholas K. Dionysopoulos \\/ AkeebaBackup.com\",\"copyright\":\"Copyright (C) 2011-2014 Nicholas K. Dionysopoulos \\/ AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nicholas@dionysopoulos.me\",\"authorUrl\":\"www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"Provide support for sef urls and meta data in sh404SEF\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(842,'plg_system_atsreplybyemail','plugin','atsreplybyemail','system',0,0,1,0,'{\"name\":\"plg_system_atsreplybyemail\",\"type\":\"plugin\",\"creationDate\":\"November 2012\",\"author\":\"Nicholas K. Dionysopoulos\",\"copyright\":\"Copyright (C) 2011 - 2012 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nikosdion@gmail.com\",\"authorUrl\":\"www.AkeebaBackup.com\",\"version\":\"1.0\",\"description\":\"PLG_SYSTEM_ATSREPLYBYEMAIL_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(843,'plg_user_ats','plugin','ats','user',0,1,1,0,'{\"name\":\"plg_user_ats\",\"type\":\"plugin\",\"creationDate\":\"November 2011\",\"author\":\"Nicholas K. Dionysopoulos \\/ AkeebaBackup.com\",\"copyright\":\"(C) 2011-2013 AkeebaBackup.com. All rights reserved.\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"www.akeebabackup.com\",\"version\":\"1.0\",\"description\":\"PLG_USER_ATS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(844,'plg_editors_jce','plugin','jce','editors',0,1,1,0,'{\"name\":\"plg_editors_jce\",\"type\":\"plugin\",\"creationDate\":\"12 December 2013\",\"author\":\"Ryan Demmer\",\"copyright\":\"2006-2010 Ryan Demmer\",\"authorEmail\":\"info@joomlacontenteditor.net\",\"authorUrl\":\"http:\\/\\/www.joomlacontenteditor.net\",\"version\":\"2.3.4.4\",\"description\":\"WF_EDITOR_PLUGIN_DESC\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(845,'plg_quickicon_jcefilebrowser','plugin','jcefilebrowser','quickicon',0,1,1,0,'{\"name\":\"plg_quickicon_jcefilebrowser\",\"type\":\"plugin\",\"creationDate\":\"12 December 2013\",\"author\":\"Ryan Demmer\",\"copyright\":\"Copyright (C) 2006 - 2013 Ryan Demmer. All rights reserved\",\"authorEmail\":\"@@email@@\",\"authorUrl\":\"www.joomalcontenteditor.net\",\"version\":\"2.3.4.4\",\"description\":\"PLG_QUICKICON_JCEFILEBROWSER_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(846,'jce','component','com_jce','',1,1,0,0,'{\"name\":\"JCE\",\"type\":\"component\",\"creationDate\":\"12 December 2013\",\"author\":\"Ryan Demmer\",\"copyright\":\"Copyright (C) 2006 - 2013 Ryan Demmer. All rights reserved\",\"authorEmail\":\"info@joomlacontenteditor.net\",\"authorUrl\":\"www.joomlacontenteditor.net\",\"version\":\"2.3.4.4\",\"description\":\"WF_ADMIN_DESC\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(847,'com_articlegenerator','component','com_articlegenerator','',1,1,0,0,'{\"name\":\"COM_ARTICLEGENERATOR\",\"type\":\"component\",\"creationDate\":\"November 2013\",\"author\":\"MCTrading\",\"copyright\":\"Copyright (C) 2013 by MCTrading All rights reserved\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.suchmaschinen-optimierung-seo.org\\/\",\"version\":\"2.2\",\"description\":\"ARTICLEGENERATOR\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(848,'System - JCE MediaBox','plugin','jcemediabox','system',0,1,1,0,'{\"name\":\"System - JCE MediaBox\",\"type\":\"plugin\",\"creationDate\":\"08 May 2014\",\"author\":\"Ryan Demmer\",\"copyright\":\"Copyright (C) 2006 - 2013 Ryan Demmer. All rights reserved\",\"authorEmail\":\"@@email@@\",\"authorUrl\":\"www.joomlacontenteditor.net\",\"version\":\"1.1.16\",\"description\":\"JCEMEDIABOX_DESC\",\"group\":\"\"}','{\"theme\":\"standard\",\"imgpath\":\"plugins\\/system\\/jcemediabox\\/img\",\"fadespeed\":\"500\",\"scalespeed\":\"500\",\"overlay\":\"1\",\"overlayopacity\":\"0.8\",\"overlaycolor\":\"#000000\",\"width\":\"\",\"height\":\"\",\"resize\":\"1\",\"close\":\"2\",\"icons\":\"1\",\"hideobjects\":\"0\",\"scrolling\":\"fixed\",\"components\":\"\",\"menu\":\"\",\"dynamic_themes\":\"0\",\"legacy\":\"0\",\"lightbox\":\"0\",\"shadowbox\":\"0\",\"cookie_expiry\":\"\",\"tipclass\":\"tooltip\",\"tipopacity\":\"0.8\",\"tipspeed\":\"150\",\"tipposition\":\"br\",\"tipoffsets_x\":\"16\",\"tipoffsets_y\":\"16\"}','','',0,'0000-00-00 00:00:00',0,0),(849,'articlegenerator','package','pkg_articlegenerator','',0,1,1,0,'{\"name\":\"PKG_ARTICLEGENERATOR\",\"type\":\"package\",\"creationDate\":\"November 2013\",\"author\":\"MCTrading\",\"copyright\":\"Copyright (C) 2013 by MCTrading All rights reserved\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.suchmaschinen-optimierung-seo.org\\/\",\"version\":\"2.2\",\"description\":\"PKG_ARTICLEGENERATOR_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(855,'Content - RokInjectModule','plugin','rokinjectmodule','content',0,1,1,0,'{\"name\":\"Content - RokInjectModule\",\"type\":\"plugin\",\"creationDate\":\"February 28, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"1.6\",\"description\":\"RokInjectModule Content Plugin.  Use format [module-{moduleid}] in your article to inject a module. You can also specify a style, eg: [module-28 style=xhtml]\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',5,0),(857,'RokCommon','library','lib_rokcommon','',0,1,1,0,'{\"name\":\"RokCommon\",\"type\":\"library\",\"creationDate\":\"March 11, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"3.1.11\",\"description\":\"RokCommon Shared Library\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(862,'rt_hadron','template','rt_hadron','',0,1,1,0,'{\"name\":\"rt_hadron\",\"type\":\"template\",\"creationDate\":\"March 21, 2014\",\"author\":\"RocketTheme, LLC\",\"copyright\":\"(C) 2005 - 2014 RocketTheme, LLC. All rights reserved.\",\"authorEmail\":\"support@rockettheme.com\",\"authorUrl\":\"http:\\/\\/www.rockettheme.com\",\"version\":\"1.1\",\"description\":\"Parent for all PHP based projects\",\"group\":\"\"}','{\"master\":\"true\"}','','',0,'0000-00-00 00:00:00',0,0),(863,'Vinaora Nivo Slider','module','mod_vt_nivo_slider','',0,1,0,0,'{\"name\":\"Vinaora Nivo Slider\",\"type\":\"module\",\"creationDate\":\"Jun 2013\",\"author\":\"VINAORA\",\"copyright\":\"Copyright (C) 2011-2013 VINAORA. All rights reserved.\",\"authorEmail\":\"info@vinaora.com\",\"authorUrl\":\"http:\\/\\/vinaora.com\",\"version\":\"3.1.0\",\"description\":\"MOD_VT_NIVO_SLIDER_XML_DESCRIPTION\",\"group\":\"\"}','{\"demo\":\"-1\",\"theme\":\"default\",\"slide_width\":\"auto\",\"slide_height\":\"auto\",\"item_path\":\"\",\"item_title\":\"\",\"item_description\":\"\",\"item_url\":\"\",\"item_target\":\"_blank\",\"effect\":\"fold\",\"slices\":\"15\",\"boxCols\":\"8\",\"boxRows\":\"4\",\"animSpeed\":\"500\",\"pauseTime\":\"3000\",\"startSlide\":\"0\",\"directionNav\":\"1\",\"controlNav\":\"1\",\"pauseOnHover\":\"1\",\"manualAdvance\":\"1\",\"prevText\":\"Prev\",\"nextText\":\"Next\",\"ribbon\":\"1\",\"controlPosition\":\"bottomright\",\"controlStyle\":\"05\",\"arrowStyle\":\"10\",\"titleColor\":\"#333333\",\"titleFontSize\":\"18\",\"titleFontStyle\":\"\",\"descColor\":\"#333333\",\"descFontSize\":\"12\",\"descFontStyle\":\"\",\"captionWidth\":\"auto\",\"captionHeight\":\"auto\",\"captionBackground\":\"#ffffcc\",\"captionPosition\":\"all\",\"captionMarginVertical\":\"\",\"captionMarginHorizontal\":\"\",\"captionRounded\":\"all\",\"slide_bgcolor\":\"\",\"slide_bdcolor\":\"\",\"slide_bdwidth\":\"0\",\"slide_bdrounded\":\"0\",\"slide_bdshadow\":\"0\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\",\"controlNavThumbs\":\"false\"}','','',0,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `nstest_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_filters`
--

DROP TABLE IF EXISTS `nstest_finder_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_filters` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_filters`
--

LOCK TABLES `nstest_finder_filters` WRITE;
/*!40000 ALTER TABLE `nstest_finder_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links`
--

DROP TABLE IF EXISTS `nstest_finder_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `state` int(5) DEFAULT '1',
  `access` int(5) DEFAULT '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL DEFAULT '0',
  `sale_price` double unsigned NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links`
--

LOCK TABLES `nstest_finder_links` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms0`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms0`
--

LOCK TABLES `nstest_finder_links_terms0` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms0` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms1`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms1`
--

LOCK TABLES `nstest_finder_links_terms1` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms1` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms2`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms2`
--

LOCK TABLES `nstest_finder_links_terms2` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms2` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms3`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms3`
--

LOCK TABLES `nstest_finder_links_terms3` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms3` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms4`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms4`
--

LOCK TABLES `nstest_finder_links_terms4` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms4` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms5`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms5`
--

LOCK TABLES `nstest_finder_links_terms5` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms5` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms6`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms6`
--

LOCK TABLES `nstest_finder_links_terms6` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms6` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms7`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms7`
--

LOCK TABLES `nstest_finder_links_terms7` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms7` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms8`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms8`
--

LOCK TABLES `nstest_finder_links_terms8` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms8` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_terms9`
--

DROP TABLE IF EXISTS `nstest_finder_links_terms9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_terms9`
--

LOCK TABLES `nstest_finder_links_terms9` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_terms9` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_terms9` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termsa`
--

DROP TABLE IF EXISTS `nstest_finder_links_termsa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termsa`
--

LOCK TABLES `nstest_finder_links_termsa` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termsa` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termsa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termsb`
--

DROP TABLE IF EXISTS `nstest_finder_links_termsb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termsb`
--

LOCK TABLES `nstest_finder_links_termsb` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termsb` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termsb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termsc`
--

DROP TABLE IF EXISTS `nstest_finder_links_termsc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termsc`
--

LOCK TABLES `nstest_finder_links_termsc` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termsc` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termsc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termsd`
--

DROP TABLE IF EXISTS `nstest_finder_links_termsd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termsd`
--

LOCK TABLES `nstest_finder_links_termsd` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termsd` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termsd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termse`
--

DROP TABLE IF EXISTS `nstest_finder_links_termse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termse`
--

LOCK TABLES `nstest_finder_links_termse` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termse` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_links_termsf`
--

DROP TABLE IF EXISTS `nstest_finder_links_termsf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_links_termsf`
--

LOCK TABLES `nstest_finder_links_termsf` WRITE;
/*!40000 ALTER TABLE `nstest_finder_links_termsf` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_links_termsf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_taxonomy`
--

DROP TABLE IF EXISTS `nstest_finder_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_taxonomy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_taxonomy`
--

LOCK TABLES `nstest_finder_taxonomy` WRITE;
/*!40000 ALTER TABLE `nstest_finder_taxonomy` DISABLE KEYS */;
INSERT INTO `nstest_finder_taxonomy` VALUES (1,0,'ROOT',0,0,0);
/*!40000 ALTER TABLE `nstest_finder_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_taxonomy_map`
--

DROP TABLE IF EXISTS `nstest_finder_taxonomy_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_taxonomy_map`
--

LOCK TABLES `nstest_finder_taxonomy_map` WRITE;
/*!40000 ALTER TABLE `nstest_finder_taxonomy_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_taxonomy_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_terms`
--

DROP TABLE IF EXISTS `nstest_finder_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_terms` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL DEFAULT '0',
  `language` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_terms`
--

LOCK TABLES `nstest_finder_terms` WRITE;
/*!40000 ALTER TABLE `nstest_finder_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_terms_common`
--

DROP TABLE IF EXISTS `nstest_finder_terms_common`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_terms_common`
--

LOCK TABLES `nstest_finder_terms_common` WRITE;
/*!40000 ALTER TABLE `nstest_finder_terms_common` DISABLE KEYS */;
INSERT INTO `nstest_finder_terms_common` VALUES ('a','en'),('about','en'),('after','en'),('ago','en'),('all','en'),('am','en'),('an','en'),('and','en'),('ani','en'),('any','en'),('are','en'),('aren\'t','en'),('as','en'),('at','en'),('be','en'),('but','en'),('by','en'),('for','en'),('from','en'),('get','en'),('go','en'),('how','en'),('if','en'),('in','en'),('into','en'),('is','en'),('isn\'t','en'),('it','en'),('its','en'),('me','en'),('more','en'),('most','en'),('must','en'),('my','en'),('new','en'),('no','en'),('none','en'),('not','en'),('noth','en'),('nothing','en'),('of','en'),('off','en'),('often','en'),('old','en'),('on','en'),('onc','en'),('once','en'),('onli','en'),('only','en'),('or','en'),('other','en'),('our','en'),('ours','en'),('out','en'),('over','en'),('page','en'),('she','en'),('should','en'),('small','en'),('so','en'),('some','en'),('than','en'),('thank','en'),('that','en'),('the','en'),('their','en'),('theirs','en'),('them','en'),('then','en'),('there','en'),('these','en'),('they','en'),('this','en'),('those','en'),('thus','en'),('time','en'),('times','en'),('to','en'),('too','en'),('true','en'),('under','en'),('until','en'),('up','en'),('upon','en'),('use','en'),('user','en'),('users','en'),('veri','en'),('version','en'),('very','en'),('via','en'),('want','en'),('was','en'),('way','en'),('were','en'),('what','en'),('when','en'),('where','en'),('whi','en'),('which','en'),('who','en'),('whom','en'),('whose','en'),('why','en'),('wide','en'),('will','en'),('with','en'),('within','en'),('without','en'),('would','en'),('yes','en'),('yet','en'),('you','en'),('your','en'),('yours','en');
/*!40000 ALTER TABLE `nstest_finder_terms_common` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_tokens`
--

DROP TABLE IF EXISTS `nstest_finder_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '1',
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `language` char(3) NOT NULL DEFAULT '',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_tokens`
--

LOCK TABLES `nstest_finder_tokens` WRITE;
/*!40000 ALTER TABLE `nstest_finder_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_tokens_aggregate`
--

DROP TABLE IF EXISTS `nstest_finder_tokens_aggregate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  `language` char(3) NOT NULL DEFAULT '',
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_tokens_aggregate`
--

LOCK TABLES `nstest_finder_tokens_aggregate` WRITE;
/*!40000 ALTER TABLE `nstest_finder_tokens_aggregate` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_tokens_aggregate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_finder_types`
--

DROP TABLE IF EXISTS `nstest_finder_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_finder_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_finder_types`
--

LOCK TABLES `nstest_finder_types` WRITE;
/*!40000 ALTER TABLE `nstest_finder_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_finder_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_aliases`
--

DROP TABLE IF EXISTS `nstest_kunena_aliases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_aliases` (
  `alias` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `item` varchar(32) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `alias` (`alias`),
  KEY `state` (`state`),
  KEY `item` (`item`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_aliases`
--

LOCK TABLES `nstest_kunena_aliases` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_aliases` DISABLE KEYS */;
INSERT INTO `nstest_kunena_aliases` VALUES ('announcement','view','announcement',1),('category','view','category',1),('category/create','layout','category.create',1),('category/default','layout','category.default',1),('category/edit','layout','category.edit',1),('category/manage','layout','category.manage',1),('category/moderate','layout','category.moderate',1),('category/user','layout','category.user',1),('common','view','common',1),('create','layout','category.create',0),('credits','view','credits',1),('default','layout','category.default',0),('edit','layout','category.edit',0),('home','view','home',1),('main-forum','catid','1',1),('manage','layout','category.manage',0),('misc','view','misc',1),('moderate','layout','category.moderate',0),('search','view','search',1),('statistics','view','statistics',1),('suggestion-box','catid','3',1),('topic','view','topic',1),('topics','view','topics',1),('user','view','user',1),('welcome-mat','catid','2',1);
/*!40000 ALTER TABLE `nstest_kunena_aliases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_announcement`
--

DROP TABLE IF EXISTS `nstest_kunena_announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_announcement` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `sdescription` text NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` tinyint(4) NOT NULL DEFAULT '0',
  `showdate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_announcement`
--

LOCK TABLES `nstest_kunena_announcement` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_announcement` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_attachments`
--

DROP TABLE IF EXISTS `nstest_kunena_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mesid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `hash` char(32) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `folder` varchar(255) NOT NULL,
  `filetype` varchar(20) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mesid` (`mesid`),
  KEY `userid` (`userid`),
  KEY `hash` (`hash`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_attachments`
--

LOCK TABLES `nstest_kunena_attachments` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_categories`
--

DROP TABLE IF EXISTS `nstest_kunena_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `name` tinytext,
  `alias` varchar(255) NOT NULL,
  `icon_id` tinyint(4) NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `accesstype` varchar(20) NOT NULL DEFAULT 'joomla.level',
  `access` int(11) NOT NULL DEFAULT '0',
  `pub_access` int(11) NOT NULL DEFAULT '1',
  `pub_recurse` tinyint(4) DEFAULT '1',
  `admin_access` int(11) NOT NULL DEFAULT '0',
  `admin_recurse` tinyint(4) DEFAULT '1',
  `ordering` smallint(6) NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `channels` text,
  `checked_out` tinyint(4) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review` tinyint(4) NOT NULL DEFAULT '0',
  `allow_anonymous` tinyint(4) NOT NULL DEFAULT '0',
  `post_anonymous` tinyint(4) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `headerdesc` text NOT NULL,
  `class_sfx` varchar(20) NOT NULL,
  `allow_polls` tinyint(4) NOT NULL DEFAULT '0',
  `topic_ordering` varchar(16) NOT NULL DEFAULT 'lastpost',
  `numTopics` mediumint(8) NOT NULL DEFAULT '0',
  `numPosts` mediumint(8) NOT NULL DEFAULT '0',
  `last_topic_id` int(11) NOT NULL DEFAULT '0',
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `last_post_time` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `category_access` (`accesstype`,`access`),
  KEY `published_pubaccess_id` (`published`,`pub_access`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_categories`
--

LOCK TABLES `nstest_kunena_categories` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_categories` DISABLE KEYS */;
INSERT INTO `nstest_kunena_categories` VALUES (1,0,'Main Forum','main-forum',0,0,'joomla.group',0,1,1,0,1,1,1,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'This is the main forum section. It serves as a container for categories for your topics.','The section header is used to display additional information about the categories of topics that it contains.','',0,'lastpost',0,0,0,0,0,''),(2,1,'Welcome Mat','welcome-mat',0,0,'joomla.group',0,1,1,0,1,1,1,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'We encourage new members to introduce themselves here. Get to know one another and share your interests.','[b]Welcome to the Kunena forum![/b] \n\n Tell us and our members who you are, what you like and why you became a member of this site. \n We welcome all new members and hope to see you around a lot!','',0,'lastpost',1,1,1,1,1400088380,''),(3,1,'Suggestion Box','suggestion-box',0,0,'joomla.group',0,1,1,0,1,2,1,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'Have some feedback and input to share? \n Don\'t be shy and drop us a note. We want to hear from you and strive to make our site better and more user friendly for our guests and members a like.','This is the optional category header for the Suggestion Box.','',1,'lastpost',0,0,0,0,0,'');
/*!40000 ALTER TABLE `nstest_kunena_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_configuration`
--

DROP TABLE IF EXISTS `nstest_kunena_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_configuration` (
  `id` int(11) NOT NULL DEFAULT '0',
  `params` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_configuration`
--

LOCK TABLES `nstest_kunena_configuration` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_configuration` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_keywords`
--

DROP TABLE IF EXISTS `nstest_kunena_keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `public_count` int(11) NOT NULL,
  `total_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `public_count` (`public_count`),
  KEY `total_count` (`total_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_keywords`
--

LOCK TABLES `nstest_kunena_keywords` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_keywords` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_keywords_map`
--

DROP TABLE IF EXISTS `nstest_kunena_keywords_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_keywords_map` (
  `keyword_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  UNIQUE KEY `keyword_user_topic` (`keyword_id`,`user_id`,`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `topic_user` (`topic_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_keywords_map`
--

LOCK TABLES `nstest_kunena_keywords_map` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_keywords_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_keywords_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_messages`
--

DROP TABLE IF EXISTS `nstest_kunena_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT '0',
  `thread` int(11) DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `name` tinytext,
  `userid` int(11) NOT NULL DEFAULT '0',
  `email` tinytext,
  `subject` tinytext,
  `time` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(128) DEFAULT NULL,
  `topic_emoticon` int(11) NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `hold` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `moved` tinyint(4) DEFAULT '0',
  `modified_by` int(7) DEFAULT NULL,
  `modified_time` int(11) DEFAULT NULL,
  `modified_reason` tinytext,
  PRIMARY KEY (`id`),
  KEY `thread` (`thread`),
  KEY `ip` (`ip`),
  KEY `userid` (`userid`),
  KEY `time` (`time`),
  KEY `locked` (`locked`),
  KEY `hold_time` (`hold`,`time`),
  KEY `parent_hits` (`parent`,`hits`),
  KEY `catid_parent` (`catid`,`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_messages`
--

LOCK TABLES `nstest_kunena_messages` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_messages` DISABLE KEYS */;
INSERT INTO `nstest_kunena_messages` VALUES (1,0,1,2,'Kunena',868,NULL,'Welcome to Kunena!',1400088380,'127.0.0.1',0,0,0,0,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `nstest_kunena_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_messages_text`
--

DROP TABLE IF EXISTS `nstest_kunena_messages_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_messages_text` (
  `mesid` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  PRIMARY KEY (`mesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_messages_text`
--

LOCK TABLES `nstest_kunena_messages_text` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_messages_text` DISABLE KEYS */;
INSERT INTO `nstest_kunena_messages_text` VALUES (1,'[size=4][b]Welcome to Kunena![/b][/size] \n\n Thank you for choosing Kunena for your community forum needs in Joomla. \n\n Kunena, translated from Swahili meaning “to speak”, is built by a team of open source professionals with the goal of providing a top quality, tightly unified forum solution for Joomla. \n\n\n [size=4][b]Additional Kunena Resources[/b][/size] \n\n [b]Kunena Documentation:[/b] [url]http://www.kunena.org/docs[/url] \n\n [b]Kunena Support Forum[/b]: [url]http://www.kunena.org/forum[/url] \n\n [b]Kunena Downloads:[/b] [url]http://www.kunena.org/download[/url] \n\n [b]Kunena Blog:[/b] [url]http://www.kunena.org/blog[/url] \n\n [b]Follow Kunena on Twitter:[/b] [url]http://www.kunena.org/twitter[/url]');
/*!40000 ALTER TABLE `nstest_kunena_messages_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_polls`
--

DROP TABLE IF EXISTS `nstest_kunena_polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `threadid` int(11) NOT NULL,
  `polltimetolive` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `threadid` (`threadid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_polls`
--

LOCK TABLES `nstest_kunena_polls` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_polls_options`
--

DROP TABLE IF EXISTS `nstest_kunena_polls_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_polls_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) DEFAULT NULL,
  `text` varchar(100) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_polls_options`
--

LOCK TABLES `nstest_kunena_polls_options` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_polls_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_polls_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_polls_users`
--

DROP TABLE IF EXISTS `nstest_kunena_polls_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_polls_users` (
  `pollid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `lasttime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvote` int(11) DEFAULT NULL,
  UNIQUE KEY `pollid` (`pollid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_polls_users`
--

LOCK TABLES `nstest_kunena_polls_users` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_polls_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_polls_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_ranks`
--

DROP TABLE IF EXISTS `nstest_kunena_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_ranks` (
  `rank_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(255) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_ranks`
--

LOCK TABLES `nstest_kunena_ranks` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_ranks` DISABLE KEYS */;
INSERT INTO `nstest_kunena_ranks` VALUES (1,'New Member',0,0,'rank1.gif'),(2,'Junior Member',20,0,'rank2.gif'),(3,'Senior Member',40,0,'rank3.gif'),(4,'Premium Member',80,0,'rank4.gif'),(5,'Elite Member',160,0,'rank5.gif'),(6,'Platinum Member',320,0,'rank6.gif'),(7,'Administrator',0,1,'rankadmin.gif'),(8,'Moderator',0,1,'rankmod.gif'),(9,'Spammer',0,1,'rankspammer.gif'),(10,'Banned',0,1,'rankbanned.gif');
/*!40000 ALTER TABLE `nstest_kunena_ranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_sessions`
--

DROP TABLE IF EXISTS `nstest_kunena_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_sessions` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `allowed` text,
  `lasttime` int(11) NOT NULL DEFAULT '0',
  `readtopics` text,
  `currvisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `currvisit` (`currvisit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_sessions`
--

LOCK TABLES `nstest_kunena_sessions` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_sessions` DISABLE KEYS */;
INSERT INTO `nstest_kunena_sessions` VALUES (868,'na',1401467577,'0',1401798484);
/*!40000 ALTER TABLE `nstest_kunena_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_smileys`
--

DROP TABLE IF EXISTS `nstest_kunena_smileys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_smileys` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL DEFAULT '',
  `location` varchar(50) NOT NULL DEFAULT '',
  `greylocation` varchar(60) NOT NULL DEFAULT '',
  `emoticonbar` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_smileys`
--

LOCK TABLES `nstest_kunena_smileys` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_smileys` DISABLE KEYS */;
INSERT INTO `nstest_kunena_smileys` VALUES (1,'B)','cool.png','cool-grey.png',1),(2,'8)','cool.png','cool-grey.png',0),(3,'8-)','cool.png','cool-grey.png',0),(4,':-(','sad.png','sad-grey.png',0),(5,':(','sad.png','sad-grey.png',1),(6,':sad:','sad.png','sad-grey.png',0),(7,':cry:','sad.png','sad-grey.png',0),(8,':)','smile.png','smile-grey.png',1),(9,':-)','smile.png','smile-grey.png',0),(10,':cheer:','cheerful.png','cheerful-grey.png',1),(11,';)','wink.png','wink-grey.png',1),(12,';-)','wink.png','wink-grey.png',0),(13,':wink:','wink.png','wink-grey.png',0),(14,';-)','wink.png','wink-grey.png',0),(15,':P','tongue.png','tongue-grey.png',1),(16,':p','tongue.png','tongue-grey.png',0),(17,':-p','tongue.png','tongue-grey.png',0),(18,':-P','tongue.png','tongue-grey.png',0),(19,':razz:','tongue.png','tongue-grey.png',0),(20,':angry:','angry.png','angry-grey.png',1),(21,':mad:','angry.png','angry-grey.png',0),(22,':unsure:','unsure.png','unsure-grey.png',1),(23,':o','shocked.png','shocked-grey.png',0),(24,':-o','shocked.png','shocked-grey.png',0),(25,':O','shocked.png','shocked-grey.png',0),(26,':-O','shocked.png','shocked-grey.png',0),(27,':eek:','shocked.png','shocked-grey.png',0),(28,':ohmy:','shocked.png','shocked-grey.png',1),(29,':huh:','wassat.png','wassat-grey.png',1),(30,':?','confused.png','confused-grey.png',0),(31,':-?','confused.png','confused-grey.png',0),(32,':???','confused.png','confused-grey.png',0),(33,':dry:','ermm.png','ermm-grey.png',1),(34,':ermm:','ermm.png','ermm-grey.png',0),(35,':lol:','grin.png','grin-grey.png',1),(36,':X','sick.png','sick-grey.png',0),(37,':x','sick.png','sick-grey.png',0),(38,':sick:','sick.png','sick-grey.png',1),(39,':silly:','silly.png','silly-grey.png',1),(40,':y32b4:','silly.png','silly-grey.png',0),(41,':blink:','blink.png','blink-grey.png',1),(42,':blush:','blush.png','blush-grey.png',1),(43,':oops:','blush.png','blush-grey.png',1),(44,':kiss:','kissing.png','kissing-grey.png',1),(45,':rolleyes:','blink.png','blink-grey.png',0),(46,':roll:','blink.png','blink-grey.png',0),(47,':woohoo:','w00t.png','w00t-grey.png',1),(48,':side:','sideways.png','sideways-grey.png',1),(49,':S','dizzy.png','dizzy-grey.png',1),(50,':s','dizzy.png','dizzy-grey.png',0),(51,':evil:','devil.png','devil-grey.png',1),(52,':twisted:','devil.png','devil-grey.png',0),(53,':whistle:','whistling.png','whistling-grey.png',1),(54,':pinch:','pinch.png','pinch-grey.png',1),(55,':D','laughing.png','laughing-grey.png',0),(56,':-D','laughing.png','laughing-grey.png',0),(57,':grin:','laughing.png','laughing-grey.png',0),(58,':laugh:','laughing.png','laughing-grey.png',0),(59,':|','neutral.png','neutral-grey.png',0),(60,':-|','neutral.png','neutral-grey.png',0),(61,':neutral:','neutral.png','neutral-grey.png',0),(62,':mrgreen:','mrgreen.png','mrgreen-grey.png',0),(63,':?:','question.png','question-grey.png',0),(64,':!:','exclamation.png','exclamation-grey.png',0),(65,':arrow:','arrow.png','arrow-grey.png',0),(66,':idea:','idea.png','idea-grey.png',0);
/*!40000 ALTER TABLE `nstest_kunena_smileys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_thankyou`
--

DROP TABLE IF EXISTS `nstest_kunena_thankyou`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_thankyou` (
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `targetuserid` int(11) NOT NULL,
  `time` datetime NOT NULL,
  UNIQUE KEY `postid` (`postid`,`userid`),
  KEY `userid` (`userid`),
  KEY `targetuserid` (`targetuserid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_thankyou`
--

LOCK TABLES `nstest_kunena_thankyou` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_thankyou` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_thankyou` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_topics`
--

DROP TABLE IF EXISTS `nstest_kunena_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `subject` tinytext,
  `icon_id` int(11) NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `hold` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `posts` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `attachments` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `moved_id` int(11) NOT NULL DEFAULT '0',
  `first_post_id` int(11) NOT NULL DEFAULT '0',
  `first_post_time` int(11) NOT NULL DEFAULT '0',
  `first_post_userid` int(11) NOT NULL DEFAULT '0',
  `first_post_message` text,
  `first_post_guest_name` tinytext,
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `last_post_time` int(11) NOT NULL DEFAULT '0',
  `last_post_userid` int(11) NOT NULL DEFAULT '0',
  `last_post_message` text,
  `last_post_guest_name` tinytext,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `locked` (`locked`),
  KEY `hold` (`hold`),
  KEY `posts` (`posts`),
  KEY `hits` (`hits`),
  KEY `first_post_userid` (`first_post_userid`),
  KEY `last_post_userid` (`last_post_userid`),
  KEY `first_post_time` (`first_post_time`),
  KEY `last_post_time` (`last_post_time`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_topics`
--

LOCK TABLES `nstest_kunena_topics` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_topics` DISABLE KEYS */;
INSERT INTO `nstest_kunena_topics` VALUES (1,2,'Welcome to Kunena!',0,0,0,0,1,1,0,0,0,1,1400088380,868,'[size=4][b]Welcome to Kunena![/b][/size] \n\n Thank you for choosing Kunena for your community forum needs in Joomla. \n\n Kunena, translated from Swahili meaning “to speak”, is built by a team of open source professionals with the goal of providing a top quality, tightly unified forum solution for Joomla. \n\n\n [size=4][b]Additional Kunena Resources[/b][/size] \n\n [b]Kunena Documentation:[/b] [url]http://www.kunena.org/docs[/url] \n\n [b]Kunena Support Forum[/b]: [url]http://www.kunena.org/forum[/url] \n\n [b]Kunena Downloads:[/b] [url]http://www.kunena.org/download[/url] \n\n [b]Kunena Blog:[/b] [url]http://www.kunena.org/blog[/url] \n\n [b]Follow Kunena on Twitter:[/b] [url]http://www.kunena.org/twitter[/url]','Kunena',1,1400088380,868,'[size=4][b]Welcome to Kunena![/b][/size] \n\n Thank you for choosing Kunena for your community forum needs in Joomla. \n\n Kunena, translated from Swahili meaning “to speak”, is built by a team of open source professionals with the goal of providing a top quality, tightly unified forum solution for Joomla. \n\n\n [size=4][b]Additional Kunena Resources[/b][/size] \n\n [b]Kunena Documentation:[/b] [url]http://www.kunena.org/docs[/url] \n\n [b]Kunena Support Forum[/b]: [url]http://www.kunena.org/forum[/url] \n\n [b]Kunena Downloads:[/b] [url]http://www.kunena.org/download[/url] \n\n [b]Kunena Blog:[/b] [url]http://www.kunena.org/blog[/url] \n\n [b]Follow Kunena on Twitter:[/b] [url]http://www.kunena.org/twitter[/url]','Kunena','');
/*!40000 ALTER TABLE `nstest_kunena_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_user_categories`
--

DROP TABLE IF EXISTS `nstest_kunena_user_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_user_categories` (
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `allreadtime` datetime DEFAULT NULL,
  `subscribed` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`user_id`,`category_id`),
  KEY `category_subscribed` (`category_id`,`subscribed`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_user_categories`
--

LOCK TABLES `nstest_kunena_user_categories` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_user_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_user_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_user_read`
--

DROP TABLE IF EXISTS `nstest_kunena_user_read`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_user_read` (
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  UNIQUE KEY `user_topic_id` (`user_id`,`topic_id`),
  KEY `category_user_id` (`category_id`,`user_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_user_read`
--

LOCK TABLES `nstest_kunena_user_read` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_user_read` DISABLE KEYS */;
INSERT INTO `nstest_kunena_user_read` VALUES (868,1,2,1,1400678114);
/*!40000 ALTER TABLE `nstest_kunena_user_read` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_user_topics`
--

DROP TABLE IF EXISTS `nstest_kunena_user_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_user_topics` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `posts` mediumint(8) NOT NULL DEFAULT '0',
  `last_post_id` int(11) NOT NULL DEFAULT '0',
  `owner` tinyint(4) NOT NULL DEFAULT '0',
  `favorite` tinyint(4) NOT NULL DEFAULT '0',
  `subscribed` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  UNIQUE KEY `user_topic_id` (`user_id`,`topic_id`),
  KEY `topic_id` (`topic_id`),
  KEY `posts` (`posts`),
  KEY `owner` (`owner`),
  KEY `favorite` (`favorite`),
  KEY `subscribed` (`subscribed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_user_topics`
--

LOCK TABLES `nstest_kunena_user_topics` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_user_topics` DISABLE KEYS */;
INSERT INTO `nstest_kunena_user_topics` VALUES (868,1,2,1,1,1,0,0,'');
/*!40000 ALTER TABLE `nstest_kunena_user_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_users`
--

DROP TABLE IF EXISTS `nstest_kunena_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_users` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `view` varchar(8) NOT NULL DEFAULT '',
  `signature` text,
  `moderator` int(11) DEFAULT '0',
  `banned` datetime DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `posts` int(11) DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `karma` int(11) DEFAULT '0',
  `karma_time` int(11) DEFAULT '0',
  `group_id` int(4) DEFAULT '1',
  `uhits` int(11) DEFAULT '0',
  `personalText` tinytext,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `birthdate` date NOT NULL DEFAULT '0001-01-01',
  `location` varchar(50) DEFAULT NULL,
  `icq` varchar(50) DEFAULT NULL,
  `aim` varchar(50) DEFAULT NULL,
  `yim` varchar(50) DEFAULT NULL,
  `msn` varchar(50) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `gtalk` varchar(50) DEFAULT NULL,
  `myspace` varchar(50) DEFAULT NULL,
  `linkedin` varchar(50) DEFAULT NULL,
  `delicious` varchar(50) DEFAULT NULL,
  `friendfeed` varchar(50) DEFAULT NULL,
  `digg` varchar(50) DEFAULT NULL,
  `blogspot` varchar(50) DEFAULT NULL,
  `flickr` varchar(50) DEFAULT NULL,
  `bebo` varchar(50) DEFAULT NULL,
  `websitename` varchar(50) DEFAULT NULL,
  `websiteurl` varchar(50) DEFAULT NULL,
  `rank` tinyint(4) NOT NULL DEFAULT '0',
  `hideEmail` tinyint(1) NOT NULL DEFAULT '1',
  `showOnline` tinyint(1) NOT NULL DEFAULT '1',
  `thankyou` int(11) DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `group_id` (`group_id`),
  KEY `posts` (`posts`),
  KEY `uhits` (`uhits`),
  KEY `banned` (`banned`),
  KEY `moderator` (`moderator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_users`
--

LOCK TABLES `nstest_kunena_users` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_users` DISABLE KEYS */;
INSERT INTO `nstest_kunena_users` VALUES (868,'',NULL,0,NULL,0,1,NULL,0,0,1,0,NULL,0,'0001-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,0),(869,'',NULL,0,NULL,0,0,NULL,0,0,1,0,NULL,0,'0001-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,0),(870,'',NULL,0,NULL,0,0,NULL,0,0,1,0,NULL,0,'0001-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,0);
/*!40000 ALTER TABLE `nstest_kunena_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_users_banned`
--

DROP TABLE IF EXISTS `nstest_kunena_users_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_users_banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `ip` varchar(128) DEFAULT NULL,
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  `expiration` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `reason_private` text,
  `reason_public` text,
  `modified_by` int(11) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `comments` text,
  `params` text,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `ip` (`ip`),
  KEY `expiration` (`expiration`),
  KEY `created_time` (`created_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_users_banned`
--

LOCK TABLES `nstest_kunena_users_banned` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_users_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_kunena_users_banned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_kunena_version`
--

DROP TABLE IF EXISTS `nstest_kunena_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_kunena_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(20) NOT NULL,
  `versiondate` date NOT NULL,
  `installdate` date NOT NULL,
  `build` varchar(20) NOT NULL,
  `versionname` varchar(40) DEFAULT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_kunena_version`
--

LOCK TABLES `nstest_kunena_version` WRITE;
/*!40000 ALTER TABLE `nstest_kunena_version` DISABLE KEYS */;
INSERT INTO `nstest_kunena_version` VALUES (1,'3.0.5','2014-03-09','2014-05-14','','Invecchiato','');
/*!40000 ALTER TABLE `nstest_kunena_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_languages`
--

DROP TABLE IF EXISTS `nstest_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_languages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_languages`
--

LOCK TABLES `nstest_languages` WRITE;
/*!40000 ALTER TABLE `nstest_languages` DISABLE KEYS */;
INSERT INTO `nstest_languages` VALUES (1,'en-GB','English (UK)','English (UK)','en','en','','','','',1,1,1);
/*!40000 ALTER TABLE `nstest_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_menu`
--

DROP TABLE IF EXISTS `nstest_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`,`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(255)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_menu`
--

LOCK TABLES `nstest_menu` WRITE;
/*!40000 ALTER TABLE `nstest_menu` DISABLE KEYS */;
INSERT INTO `nstest_menu` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,307,0,'*',0),(2,'menu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,4,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',1,10,0,'*',1),(3,'menu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',2,3,0,'*',1),(4,'menu','com_banners_categories','Categories','','Banners/Categories','index.php?option=com_categories&extension=com_banners','component',0,2,2,6,0,'0000-00-00 00:00:00',0,0,'class:banners-cat',0,'',4,5,0,'*',1),(5,'menu','com_banners_clients','Clients','','Banners/Clients','index.php?option=com_banners&view=clients','component',0,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners-clients',0,'',6,7,0,'*',1),(6,'menu','com_banners_tracks','Tracks','','Banners/Tracks','index.php?option=com_banners&view=tracks','component',0,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners-tracks',0,'',8,9,0,'*',1),(7,'menu','com_contact','Contacts','','Contacts','index.php?option=com_contact','component',0,1,1,8,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',11,16,0,'*',1),(8,'menu','com_contact','Contacts','','Contacts/Contacts','index.php?option=com_contact','component',0,7,2,8,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',12,13,0,'*',1),(9,'menu','com_contact_categories','Categories','','Contacts/Categories','index.php?option=com_categories&extension=com_contact','component',0,7,2,6,0,'0000-00-00 00:00:00',0,0,'class:contact-cat',0,'',14,15,0,'*',1),(10,'menu','com_messages','Messaging','','Messaging','index.php?option=com_messages','component',0,1,1,15,0,'0000-00-00 00:00:00',0,0,'class:messages',0,'',17,22,0,'*',1),(11,'menu','com_messages_add','New Private Message','','Messaging/New Private Message','index.php?option=com_messages&task=message.add','component',0,10,2,15,0,'0000-00-00 00:00:00',0,0,'class:messages-add',0,'',18,19,0,'*',1),(12,'menu','com_messages_read','Read Private Message','','Messaging/Read Private Message','index.php?option=com_messages','component',0,10,2,15,0,'0000-00-00 00:00:00',0,0,'class:messages-read',0,'',20,21,0,'*',1),(13,'menu','com_newsfeeds','News Feeds','','News Feeds','index.php?option=com_newsfeeds','component',0,1,1,17,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',23,28,0,'*',1),(14,'menu','com_newsfeeds_feeds','Feeds','','News Feeds/Feeds','index.php?option=com_newsfeeds','component',0,13,2,17,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',24,25,0,'*',1),(15,'menu','com_newsfeeds_categories','Categories','','News Feeds/Categories','index.php?option=com_categories&extension=com_newsfeeds','component',0,13,2,6,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds-cat',0,'',26,27,0,'*',1),(16,'menu','com_redirect','Redirect','','Redirect','index.php?option=com_redirect','component',0,1,1,24,0,'0000-00-00 00:00:00',0,0,'class:redirect',0,'',29,30,0,'*',1),(17,'menu','com_search','Basic Search','','Basic Search','index.php?option=com_search','component',0,1,1,19,0,'0000-00-00 00:00:00',0,0,'class:search',0,'',31,32,0,'*',1),(18,'menu','com_weblinks','Weblinks','','Weblinks','index.php?option=com_weblinks','component',0,1,1,21,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',33,38,0,'*',1),(19,'menu','com_weblinks_links','Links','','Weblinks/Links','index.php?option=com_weblinks','component',0,18,2,21,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',34,35,0,'*',1),(20,'menu','com_weblinks_categories','Categories','','Weblinks/Categories','index.php?option=com_categories&extension=com_weblinks','component',0,18,2,6,0,'0000-00-00 00:00:00',0,0,'class:weblinks-cat',0,'',36,37,0,'*',1),(21,'menu','com_finder','Smart Search','','Smart Search','index.php?option=com_finder','component',0,1,1,27,0,'0000-00-00 00:00:00',0,0,'class:finder',0,'',39,40,0,'*',1),(22,'menu','com_joomlaupdate','Joomla! Update','','Joomla! Update','index.php?option=com_joomlaupdate','component',1,1,1,28,0,'0000-00-00 00:00:00',0,0,'class:joomlaupdate',0,'',41,42,0,'*',1),(23,'main','com_tags','Tags','','Tags','index.php?option=com_tags','component',0,1,1,29,0,'0000-00-00 00:00:00',0,1,'class:tags',0,'',43,44,0,'',1),(24,'main','com_postinstall','Post-installation messages','','Post-installation messages','index.php?option=com_postinstall','component',0,1,1,32,0,'0000-00-00 00:00:00',0,1,'class:postinstall',0,'',45,46,0,'*',1),(101,'mainmenu','Inicio','home','','home','index.php?option=com_content&view=featured','component',1,1,1,22,0,'0000-00-00 00:00:00',0,1,'',10,'{\"featured_categories\":[\"\"],\"layout_type\":\"blog\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"3\",\"num_columns\":\"3\",\"num_links\":\"0\",\"multi_column_order\":\"1\",\"orderby_pri\":\"\",\"orderby_sec\":\"front\",\"order_date\":\"\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_title\":\"\",\"link_titles\":\"\",\"show_intro\":\"\",\"info_block_position\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"link_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_vote\":\"\",\"show_readmore\":\"\",\"show_readmore_title\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_hits\":\"\",\"show_noauth\":\"\",\"show_feed_link\":\"1\",\"feed_summary\":\"\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":1,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"111\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',47,48,1,'*',0),(103,'main','RokGallery','rokgallery','','rokgallery','index.php?option=com_rokgallery','component',0,1,1,721,0,'0000-00-00 00:00:00',0,1,'components/com_rokgallery/assets/images/rokgallery_16x16.png',0,'',49,50,0,'',1),(104,'main','COM_EASYDISCUSS','com-easydiscuss','','com-easydiscuss','index.php?option=com_easydiscuss','component',0,1,1,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss.png',0,'',51,82,0,'',1),(105,'main','COM_EASYDISCUSS_ADMIN_MENU_SETTINGS','com-easydiscuss-admin-menu-settings','','com-easydiscuss/com-easydiscuss-admin-menu-settings','index.php?option=com_easydiscuss&view=settings','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-settings.png',0,'',52,53,0,'',1),(106,'main','COM_EASYDISCUSS_MENU_DISCUSSIONS','com-easydiscuss-menu-discussions','','com-easydiscuss/com-easydiscuss-menu-discussions','index.php?option=com_easydiscuss&view=posts','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-posts.png',0,'',54,55,0,'',1),(107,'main','COM_EASYDISCUSS_ADMIN_MENU_AUTOPOSTING','com-easydiscuss-admin-menu-autoposting','','com-easydiscuss/com-easydiscuss-admin-menu-autoposting','index.php?option=com_easydiscuss&view=autoposting','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-autoposting.png',0,'',56,57,0,'',1),(108,'main','COM_EASYDISCUSS_ADMIN_MENU_CATEGORIES','com-easydiscuss-admin-menu-categories','','com-easydiscuss/com-easydiscuss-admin-menu-categories','index.php?option=com_easydiscuss&view=categories','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-categories.png',0,'',58,59,0,'',1),(109,'main','COM_EASYDISCUSS_ADMIN_MENU_TAGS','com-easydiscuss-admin-menu-tags','','com-easydiscuss/com-easydiscuss-admin-menu-tags','index.php?option=com_easydiscuss&view=tags','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-tags.png',0,'',60,61,0,'',1),(110,'main','COM_EASYDISCUSS_ADMIN_MENU_USERS','com-easydiscuss-admin-menu-users','','com-easydiscuss/com-easydiscuss-admin-menu-users','index.php?option=com_easydiscuss&view=users','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-users.png',0,'',62,63,0,'',1),(111,'main','COM_EASYDISCUSS_ADMIN_MENU_ROLES','com-easydiscuss-admin-menu-roles','','com-easydiscuss/com-easydiscuss-admin-menu-roles','index.php?option=com_easydiscuss&view=roles','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-roles.png',0,'',64,65,0,'',1),(112,'main','COM_EASYDISCUSS_ADMIN_MENU_ACL','com-easydiscuss-admin-menu-acl','','com-easydiscuss/com-easydiscuss-admin-menu-acl','index.php?option=com_easydiscuss&view=acls','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-acls.png',0,'',66,67,0,'',1),(113,'main','COM_EASYDISCUSS_ADMIN_MENU_REPORTS','com-easydiscuss-admin-menu-reports','','com-easydiscuss/com-easydiscuss-admin-menu-reports','index.php?option=com_easydiscuss&view=reports','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-reports.png',0,'',68,69,0,'',1),(114,'main','COM_EASYDISCUSS_ADMIN_MENU_SUBSCRIPTION','com-easydiscuss-admin-menu-subscription','','com-easydiscuss/com-easydiscuss-admin-menu-subscription','index.php?option=com_easydiscuss&view=subscription','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-subscription.png',0,'',70,71,0,'',1),(115,'main','COM_EASYDISCUSS_ADMIN_MENU_BADGES','com-easydiscuss-admin-menu-badges','','com-easydiscuss/com-easydiscuss-admin-menu-badges','index.php?option=com_easydiscuss&view=badges','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-badges.png',0,'',72,73,0,'',1),(116,'main','COM_EASYDISCUSS_ADMIN_MENU_POINTS','com-easydiscuss-admin-menu-points','','com-easydiscuss/com-easydiscuss-admin-menu-points','index.php?option=com_easydiscuss&view=points','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-points.png',0,'',74,75,0,'',1),(117,'main','COM_EASYDISCUSS_ADMIN_MENU_RANKING','com-easydiscuss-admin-menu-ranking','','com-easydiscuss/com-easydiscuss-admin-menu-ranking','index.php?option=com_easydiscuss&view=ranks','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-ranks.png',0,'',76,77,0,'',1),(118,'main','COM_EASYDISCUSS_ADMIN_MENU_CUSTOMFIELDS','com-easydiscuss-admin-menu-customfields','','com-easydiscuss/com-easydiscuss-admin-menu-customfields','index.php?option=com_easydiscuss&view=customfields','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-customfields.png',0,'',78,79,0,'',1),(119,'main','COM_EASYDISCUSS_ADMIN_MENU_SPOOLS','com-easydiscuss-admin-menu-spools','','com-easydiscuss/com-easydiscuss-admin-menu-spools','index.php?option=com_easydiscuss&view=spools','component',0,104,2,737,0,'0000-00-00 00:00:00',0,1,'components/com_easydiscuss/themes/default/images/favicons/easydiscuss-spools.png',0,'',80,81,0,'',1),(120,'mainmenu','Discussions','discussions','','discussions','index.php?option=com_easydiscuss&view=index','component',1,1,1,737,0,'0000-00-00 00:00:00',0,1,'',10,'',83,84,0,'*',0),(121,'main','COM_EASYBLOG','com-easyblog','','com-easyblog','index.php?option=com_easyblog','component',0,1,1,739,0,'0000-00-00 00:00:00',0,1,'../media/com_easyblog/images/easyblog-16x16.png',0,'',85,114,0,'',1),(122,'main','COM_EASYBLOG_ADMIN_MENU_ACL','com-easyblog-admin-menu-acl','','com-easyblog/com-easyblog-admin-menu-acl','index.php?option=com_easyblog&view=acls','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/acls-favicon.png',0,'',86,87,0,'',1),(123,'main','COM_EASYBLOG_ADMIN_MENU_BLOGS','com-easyblog-admin-menu-blogs','','com-easyblog/com-easyblog-admin-menu-blogs','index.php?option=com_easyblog&view=blogs','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/blogs-favicon.png',0,'',88,89,0,'',1),(124,'main','COM_EASYBLOG_ADMIN_MENU_CATEGORIES','com-easyblog-admin-menu-categories','','com-easyblog/com-easyblog-admin-menu-categories','index.php?option=com_easyblog&view=categories','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/categories-favicon.png',0,'',90,91,0,'',1),(125,'main','COM_EASYBLOG_ADMIN_MENU_COMMENTS','com-easyblog-admin-menu-comments','','com-easyblog/com-easyblog-admin-menu-comments','index.php?option=com_easyblog&view=comments','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/comments-favicon.png',0,'',92,93,0,'',1),(126,'main','COM_EASYBLOG_ADMIN_MENU_METATAGS','com-easyblog-admin-menu-metatags','','com-easyblog/com-easyblog-admin-menu-metatags','index.php?option=com_easyblog&view=metas','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/meta-favicon.png',0,'',94,95,0,'',1),(127,'main','COM_EASYBLOG_ADMIN_MENU_MIGRATORS','com-easyblog-admin-menu-migrators','','com-easyblog/com-easyblog-admin-menu-migrators','index.php?option=com_easyblog&view=migrators','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/migrators-favicon.png',0,'',96,97,0,'',1),(128,'main','COM_EASYBLOG_ADMIN_MENU_PENDING','com-easyblog-admin-menu-pending','','com-easyblog/com-easyblog-admin-menu-pending','index.php?option=com_easyblog&view=pending','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/pending-favicon.png',0,'',98,99,0,'',1),(129,'main','COM_EASYBLOG_ADMIN_MENU_SETTINGS','com-easyblog-admin-menu-settings','','com-easyblog/com-easyblog-admin-menu-settings','index.php?option=com_easyblog&view=settings','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/settings-favicon.png',0,'',100,101,0,'',1),(130,'main','COM_EASYBLOG_ADMIN_MENU_SUBSCRIPTIONS','com-easyblog-admin-menu-subscriptions','','com-easyblog/com-easyblog-admin-menu-subscriptions','index.php?option=com_easyblog&view=subscriptions','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/subscriptions-favicon.png',0,'',102,103,0,'',1),(131,'main','COM_EASYBLOG_ADMIN_MENU_TAGS','com-easyblog-admin-menu-tags','','com-easyblog/com-easyblog-admin-menu-tags','index.php?option=com_easyblog&view=tags','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/tags-favicon.png',0,'',104,105,0,'',1),(132,'main','COM_EASYBLOG_ADMIN_MENU_TEAMBLOGS','com-easyblog-admin-menu-teamblogs','','com-easyblog/com-easyblog-admin-menu-teamblogs','index.php?option=com_easyblog&view=teamblogs','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/teamblogs-favicon.png',0,'',106,107,0,'',1),(133,'main','COM_EASYBLOG_ADMIN_MENU_THEMES','com-easyblog-admin-menu-themes','','com-easyblog/com-easyblog-admin-menu-themes','index.php?option=com_easyblog&view=themes','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/themes-favicon.png',0,'',108,109,0,'',1),(134,'main','COM_EASYBLOG_ADMIN_MENU_TRACKBACKS','com-easyblog-admin-menu-trackbacks','','com-easyblog/com-easyblog-admin-menu-trackbacks','index.php?option=com_easyblog&view=trackbacks','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/trackback-favicon.png',0,'',110,111,0,'',1),(135,'main','COM_EASYBLOG_ADMIN_MENU_USERS','com-easyblog-admin-menu-users','','com-easyblog/com-easyblog-admin-menu-users','index.php?option=com_easyblog&view=users','component',0,121,2,739,0,'0000-00-00 00:00:00',0,1,'components/com_easyblog/assets/images/users-favicon.png',0,'',112,113,0,'',1),(136,'mainmenu','Blogs','easyblog','','easyblog','index.php?option=com_easyblog&view=latest','component',1,1,1,739,0,'0000-00-00 00:00:00',0,1,'',10,'{\"limit\":\"-2\",\"includesubcategories\":\"0\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"111\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',115,116,0,'*',0),(144,'main','COM_KUNENA','com-kunena','','com-kunena','index.php?option=com_kunena','component',0,1,1,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-logo-white.png',0,'',117,140,0,'',1),(145,'main','COM_KUNENA_DASHBOARD','com-kunena-dashboard','','com-kunena/com-kunena-dashboard','index.php?option=com_kunena&view=cpanel','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-logo-white.png',0,'',118,119,0,'',1),(146,'main','COM_KUNENA_CATEGORY_MANAGER','com-kunena-category-manager','','com-kunena/com-kunena-category-manager','index.php?option=com_kunena&view=categories','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-categories.png',0,'',120,121,0,'',1),(147,'main','COM_KUNENA_USER_MANAGER','com-kunena-user-manager','','com-kunena/com-kunena-user-manager','index.php?option=com_kunena&view=users','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-users.png',0,'',122,123,0,'',1),(148,'main','COM_KUNENA_FILE_MANAGER','com-kunena-file-manager','','com-kunena/com-kunena-file-manager','index.php?option=com_kunena&view=attachments','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-files.png',0,'',124,125,0,'',1),(149,'main','COM_KUNENA_EMOTICON_MANAGER','com-kunena-emoticon-manager','','com-kunena/com-kunena-emoticon-manager','index.php?option=com_kunena&view=smilies','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-smileys.png',0,'',126,127,0,'',1),(150,'main','COM_KUNENA_RANK_MANAGER','com-kunena-rank-manager','','com-kunena/com-kunena-rank-manager','index.php?option=com_kunena&view=ranks','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-ranks.png',0,'',128,129,0,'',1),(151,'main','COM_KUNENA_TEMPLATE_MANAGER','com-kunena-template-manager','','com-kunena/com-kunena-template-manager','index.php?option=com_kunena&view=templates','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-templates.png',0,'',130,131,0,'',1),(152,'main','COM_KUNENA_CONFIGURATION','com-kunena-configuration','','com-kunena/com-kunena-configuration','index.php?option=com_kunena&view=config','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-prune.png',0,'',132,133,0,'',1),(153,'main','COM_KUNENA_PLUGIN_MANAGER','com-kunena-plugin-manager','','com-kunena/com-kunena-plugin-manager','index.php?option=com_kunena&view=plugins','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-plugins.png',0,'',134,135,0,'',1),(154,'main','COM_KUNENA_FORUM_TOOLS','com-kunena-forum-tools','','com-kunena/com-kunena-forum-tools','index.php?option=com_kunena&view=tools','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-config.png',0,'',136,137,0,'',1),(155,'main','COM_KUNENA_TRASH_MANAGER','com-kunena-trash-manager','','com-kunena/com-kunena-trash-manager','index.php?option=com_kunena&view=trash','component',0,144,2,751,0,'0000-00-00 00:00:00',0,1,'components/com_kunena/media/icons/favicons/kunena-trash.png',0,'',138,139,0,'',1),(156,'kunenamenu','Forum','forum','','forum','index.php?option=com_kunena&view=home&defaultmenu=158','component',1,1,1,751,0,'0000-00-00 00:00:00',0,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"catids\":0}',141,158,0,'*',0),(157,'kunenamenu','Index','index','','forum/index','index.php?option=com_kunena&view=category&layout=list','component',1,156,2,751,0,'0000-00-00 00:00:00',0,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',142,143,0,'*',0),(158,'kunenamenu','Recent Topics','recent','','forum/recent','index.php?option=com_kunena&view=topics&mode=replies','component',1,156,2,751,0,'0000-00-00 00:00:00',0,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"topics_catselection\":\"\",\"topics_categories\":\"\",\"topics_time\":720}',144,145,0,'*',0),(159,'kunenamenu','New Topic','newtopic','','forum/newtopic','index.php?option=com_kunena&view=topic&layout=create','component',1,156,2,751,0,'0000-00-00 00:00:00',0,2,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',146,147,0,'*',0),(160,'kunenamenu','No Replies','noreplies','','forum/noreplies','index.php?option=com_kunena&view=topics&mode=noreplies','component',1,156,2,751,0,'0000-00-00 00:00:00',0,2,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"topics_catselection\":\"\",\"topics_categories\":\"\",\"topics_time\":-1}',148,149,0,'*',0),(161,'kunenamenu','My Topics','mylatest','','forum/mylatest','index.php?option=com_kunena&view=topics&layout=user&mode=default','component',1,156,2,751,0,'0000-00-00 00:00:00',0,2,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"topics_catselection\":\"2\",\"topics_categories\":\"0\",\"topics_time\":-1}',150,151,0,'*',0),(162,'kunenamenu','Profile','profile','','forum/profile','index.php?option=com_kunena&view=user','component',1,156,2,751,0,'0000-00-00 00:00:00',0,2,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"integration\":1}',152,153,0,'*',0),(163,'kunenamenu','Help','help','','forum/help','index.php?option=com_kunena&view=misc','component',1,156,2,751,0,'0000-00-00 00:00:00',0,3,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"body\":\"This help page is a menu item inside [b]Kunena Menu[\\/b], which allows easy navigation in your forum. \\n\\n You can use Joomla Menu Manager to edit items in this menu. Please go to [b]Administration[\\/b] >> [b]Menus[\\/b] >> [b]Kunena Menu[\\/b] >> [b]Help[\\/b] to edit or remove this menu item. \\n\\n In this menu item you can use Plain Text, BBCode or HTML. If you want to bind article into this page, you may use article BBCode (with article id): [code][article=full]123[\\/article][\\/code] \\n\\n If you want to create your own menu for Kunena, please start by creating [b]Home Page[\\/b] first. In that page you can select default menu item, which is shown when you enter to Kunena.\",\"body_format\":\"bbcode\"}',154,155,0,'*',0),(164,'kunenamenu','Search','search','','forum/search','index.php?option=com_kunena&view=search','component',1,156,2,751,0,'0000-00-00 00:00:00',0,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',156,157,0,'*',0),(165,'mainmenu','Foros','kunena-2014-05-14','','kunena-2014-05-14','index.php?Itemid=156','alias',1,1,1,0,0,'0000-00-00 00:00:00',0,1,'',10,'{\"aliasoptions\":\"156\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"111\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',159,160,0,'*',0),(166,'main','COM_COMMUNITY','com-community','','com-community','index.php?option=com_community','component',0,1,1,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/community-favicon.png',0,'',161,198,0,'',1),(167,'main','COM_COMMUNITY_MENU_CONFIGURATION','com-community-menu-configuration','','com-community/com-community-menu-configuration','index.php?option=com_community&view=configuration','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/configuration-favicon.png',0,'',162,163,0,'',1),(168,'main','COM_COMMUNITY_MENU_CATEGORY_USERS','com-community-menu-category-users','','com-community/com-community-menu-category-users','index.php?option=com_community&view=users','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/edit-user-favicon.png',0,'',164,165,0,'',1),(169,'main','COM_COMMUNITY_MENU_MULTIPROFILE','com-community-menu-multiprofile','','com-community/com-community-menu-multiprofile','index.php?option=com_community&view=multiprofile','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/multiprofile-favicon.png',0,'',166,167,0,'',1),(170,'main','COM_COMMUNITY_MENU_CUSTOM_PROFILES','com-community-menu-custom-profiles','','com-community/com-community-menu-custom-profiles','index.php?option=com_community&view=profiles','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/profiles-favicon.png',0,'',168,169,0,'',1),(171,'main','COM_COMMUNITY_MENU_GROUPS','com-community-menu-groups','','com-community/com-community-menu-groups','index.php?option=com_community&view=groups','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/groups-favicon.png',0,'',170,171,0,'',1),(172,'main','COM_COMMUNITY_MENU_GROUPS_CATEGORY','com-community-menu-groups-category','','com-community/com-community-menu-groups-category','index.php?option=com_community&view=groupcategories','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/groupcategories-favicon.png',0,'',172,173,0,'',1),(173,'main','COM_COMMUNITY_MENU_VIDEOS_CATEGORY','com-community-menu-videos-category','','com-community/com-community-menu-videos-category','index.php?option=com_community&view=videoscategories','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/videos-favicon.png',0,'',174,175,0,'',1),(174,'main','COM_COMMUNITY_MENU_EVENTS','com-community-menu-events','','com-community/com-community-menu-events','index.php?option=com_community&view=events','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/event-favicon.png',0,'',176,177,0,'',1),(175,'main','COM_COMMUNITY_MENU_EVENTS_CATEGORY','com-community-menu-events-category','','com-community/com-community-menu-events-category','index.php?option=com_community&view=eventcategories','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/eventcategories-favicon.png',0,'',178,179,0,'',1),(176,'main','COM_COMMUNITY_MENU_TEMPLATES','com-community-menu-templates','','com-community/com-community-menu-templates','index.php?option=com_community&view=templates','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/templates-favicon.png',0,'',180,181,0,'',1),(177,'main','COM_COMMUNITY_MENU_MAIL_QUEUE','com-community-menu-mail-queue','','com-community/com-community-menu-mail-queue','index.php?option=com_community&view=mailqueue','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/mailq-favicon.png',0,'',182,183,0,'',1),(178,'main','COM_COMMUNITY_MENU_APPLICATIONS','com-community-menu-applications','','com-community/com-community-menu-applications','index.php?option=com_plugins&filter_type=community&filter_folder=community','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/applications-favicon.png',0,'',184,185,0,'',1),(179,'main','COM_COMMUNITY_MENU_USER_POINTS','com-community-menu-user-points','','com-community/com-community-menu-user-points','index.php?option=com_community&view=userpoints','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/userpoints-favicon.png',0,'',186,187,0,'',1),(180,'main','COM_COMMUNITY_MENU_MASS_MESSAGING','com-community-menu-mass-messaging','','com-community/com-community-menu-mass-messaging','index.php?option=com_community&view=messaging','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/message-favicon.png',0,'',188,189,0,'',1),(181,'main','COM_COMMUNITY_MENU_ACTIVITIES','com-community-menu-activities','','com-community/com-community-menu-activities','index.php?option=com_community&view=activities','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/activities-favicon.png',0,'',190,191,0,'',1),(182,'main','COM_COMMUNITY_MENU_MEMBERLIST','com-community-menu-memberlist','','com-community/com-community-menu-memberlist','index.php?option=com_community&view=memberlist','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/memberlist-favicon.png',0,'',192,193,0,'',1),(183,'main','COM_COMMUNITY_MENU_REPORTINGS','com-community-menu-reportings','','com-community/com-community-menu-reportings','index.php?option=com_community&view=reports','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/reports-favicon.png',0,'',194,195,0,'',1),(184,'main','COM_COMMUNITY_MENU_ABOUT','com-community-menu-about','','com-community/com-community-menu-about','index.php?option=com_community&view=about','component',0,166,2,760,0,'0000-00-00 00:00:00',0,1,'components/com_community/assets/icons/about-favicon.png',0,'',196,197,0,'',1),(185,'mainmenu','Social','jomsocial','','jomsocial','index.php?option=com_community&view=frontpage','component',1,1,1,760,0,'0000-00-00 00:00:00',0,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"111\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',203,204,0,'*',0),(186,'jomsocial','Profile','profile','','profile','index.php?option=com_community&view=profile','component',1,1,1,760,0,'0000-00-00 00:00:00',0,1,'',10,'',205,220,0,'*',0),(187,'jomsocial','Change Profile Picture','change-profile-picture','','profile/change-profile-picture','index.php?option=com_community&view=profile&task=uploadAvatar','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',206,207,0,'*',0),(188,'jomsocial','Change Profile Video','change-profile-video','','profile/change-profile-video','index.php?option=com_community&view=profile&task=linkVideo','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',208,209,0,'*',0),(189,'jomsocial','Edit Profile','edit-profile','','profile/edit-profile','index.php?option=com_community&view=profile&task=edit','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',210,211,0,'*',0),(190,'jomsocial','Edit Details','edit-details','','profile/edit-details','index.php?option=com_community&view=profile&task=editDetails','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',212,213,0,'*',0),(191,'jomsocial','Privacy','privacy','','profile/privacy','index.php?option=com_community&view=profile&task=privacy','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',214,215,0,'*',0),(192,'jomsocial','Preferences','preferences','','profile/preferences','index.php?option=com_community&view=profile&task=preferences','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',216,217,0,'*',0),(193,'jomsocial','Customize My Page','customize-my-page','','profile/customize-my-page','index.php?option=com_community&view=profile&task=editPage','component',1,186,2,760,0,'0000-00-00 00:00:00',0,1,'',10,'',218,219,0,'*',0),(194,'jomsocial','Friends','friends','','friends','index.php?option=com_community&view=friends','component',1,1,1,760,0,'0000-00-00 00:00:00',0,2,'',10,'',221,234,0,'*',0),(195,'jomsocial','Show All','show-all','','friends/show-all','index.php?option=com_community&view=friends','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',222,223,0,'*',0),(196,'jomsocial','Search','search','','friends/search','index.php?option=com_community&view=search','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',224,225,0,'*',0),(197,'jomsocial','Advanced Search','advanced-search','','friends/advanced-search','index.php?option=com_community&view=search&task=advancesearch','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',226,227,0,'*',0),(198,'jomsocial','Invite Friends','invite-friends','','friends/invite-friends','index.php?option=com_community&view=friends&task=invite','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',228,229,0,'*',0),(199,'jomsocial','Request Sent','request-sent','','friends/request-sent','index.php?option=com_community&view=friends&task=sent','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',230,231,0,'*',0),(200,'jomsocial','Pending my approval','pending-my-approval','','friends/pending-my-approval','index.php?option=com_community&view=friends&task=pending','component',1,194,2,760,0,'0000-00-00 00:00:00',0,2,'',10,'',232,233,0,'*',0),(201,'jomsocial','Groups','groups','','groups','index.php?option=com_community&view=groups&task=mygroups','component',1,1,1,760,0,'0000-00-00 00:00:00',0,2,'',10,'',235,236,0,'*',0),(202,'jomsocial','Photos','photos','','photos','index.php?option=com_community&view=photos&task=myphotos','component',1,1,1,760,0,'0000-00-00 00:00:00',0,2,'',10,'',237,238,0,'*',0),(203,'jomsocial','Videos','videos','','videos','index.php?option=com_community&view=videos&task=myvideos','component',1,1,1,760,0,'0000-00-00 00:00:00',0,2,'',10,'',239,240,0,'*',0),(204,'jomsocial','Events','events','','events','index.php?option=com_community&view=events&task=myevents','component',1,1,1,760,0,'0000-00-00 00:00:00',0,2,'',10,'',241,242,0,'*',0),(205,'main','COM_IJOOMLAINSTALLER','com-ijoomlainstaller','','com-ijoomlainstaller','index.php?option=com_ijoomlainstaller','component',0,1,1,803,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',199,200,0,'',1),(206,'main','com_oziogallery3','com-oziogallery3','','com-oziogallery3','index.php?option=com_oziogallery3','component',0,1,1,807,0,'0000-00-00 00:00:00',0,1,'components/com_oziogallery3/assets/images/oziogallery3.png',0,'',201,202,0,'',1),(214,'main','COM_PHOCADOWNLOAD','com-phocadownload','','com-phocadownload','index.php?option=com_phocadownload','component',0,1,1,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu.png',0,'',243,270,0,'',1),(215,'main','COM_PHOCADOWNLOAD_CONTROLPANEL','com-phocadownload-controlpanel','','com-phocadownload/com-phocadownload-controlpanel','index.php?option=com_phocadownload','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-control-panel.png',0,'',244,245,0,'',1),(216,'main','COM_PHOCADOWNLOAD_FILES','com-phocadownload-files','','com-phocadownload/com-phocadownload-files','index.php?option=com_phocadownload&view=phocadownloadfiles','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-files.png',0,'',246,247,0,'',1),(217,'main','COM_PHOCADOWNLOAD_CATEGORIES','com-phocadownload-categories','','com-phocadownload/com-phocadownload-categories','index.php?option=com_phocadownload&view=phocadownloadcats','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-category.png',0,'',248,249,0,'',1),(218,'main','COM_PHOCADOWNLOAD_LICENSES','com-phocadownload-licenses','','com-phocadownload/com-phocadownload-licenses','index.php?option=com_phocadownload&view=phocadownloadlics','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-lic.png',0,'',250,251,0,'',1),(219,'main','COM_PHOCADOWNLOAD_STATISTICS','com-phocadownload-statistics','','com-phocadownload/com-phocadownload-statistics','index.php?option=com_phocadownload&view=phocadownloadstat','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-stat.png',0,'',252,253,0,'',1),(220,'main','COM_PHOCADOWNLOAD_DOWNLOADS','com-phocadownload-downloads','','com-phocadownload/com-phocadownload-downloads','index.php?option=com_phocadownload&view=phocadownloaddownloads','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-downloads.png',0,'',254,255,0,'',1),(221,'main','COM_PHOCADOWNLOAD_UPLOADS','com-phocadownload-uploads','','com-phocadownload/com-phocadownload-uploads','index.php?option=com_phocadownload&view=phocadownloaduploads','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-uploads.png',0,'',256,257,0,'',1),(222,'main','COM_PHOCADOWNLOAD_FILE_RATING','com-phocadownload-file-rating','','com-phocadownload/com-phocadownload-file-rating','index.php?option=com_phocadownload&view=phocadownloadrafile','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-vote-file.png',0,'',258,259,0,'',1),(223,'main','COM_PHOCADOWNLOAD_TAGS','com-phocadownload-tags','','com-phocadownload/com-phocadownload-tags','index.php?option=com_phocadownload&view=phocadownloadtags','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-tags.png',0,'',260,261,0,'',1),(224,'main','COM_PHOCADOWNLOAD_LAYOUT','com-phocadownload-layout','','com-phocadownload/com-phocadownload-layout','index.php?option=com_phocadownload&view=phocadownloadlayouts','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-layout.png',0,'',262,263,0,'',1),(225,'main','COM_PHOCADOWNLOAD_STYLES','com-phocadownload-styles','','com-phocadownload/com-phocadownload-styles','index.php?option=com_phocadownload&view=phocadownloadstyles','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-style.png',0,'',264,265,0,'',1),(226,'main','COM_PHOCADOWNLOAD_LOGGING','com-phocadownload-logging','','com-phocadownload/com-phocadownload-logging','index.php?option=com_phocadownload&view=phocadownloadlogs','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-logs.png',0,'',266,267,0,'',1),(227,'main','COM_PHOCADOWNLOAD_INFO','com-phocadownload-info','','com-phocadownload/com-phocadownload-info','index.php?option=com_phocadownload&view=phocadownloadinfo','component',0,214,2,814,0,'0000-00-00 00:00:00',0,1,'media/com_phocadownload/images/administrator/icon-16-pdl-menu-info.png',0,'',268,269,0,'',1),(228,'main','COM_ADMINTOOLS','com-admintools','','com-admintools','index.php?option=com_admintools','component',0,1,1,815,0,'0000-00-00 00:00:00',0,1,'../media/com_admintools/images/admintools-16.png',0,'',271,272,0,'',1),(230,'main','COM_AKEEBA','com-akeeba','','com-akeeba','index.php?option=com_akeeba','component',0,1,1,823,0,'0000-00-00 00:00:00',0,1,'../media/com_akeeba/icons/akeeba-16.png',0,'',273,274,0,'',1),(231,'main','COM_ATS','com-ats','','com-ats','index.php?option=com_ats','component',0,1,1,830,0,'0000-00-00 00:00:00',0,1,'../media/com_ats/images/ats-16.png',0,'',275,276,0,'',1),(232,'main','JCE','jce','','jce','index.php?option=com_jce','component',0,1,1,846,0,'0000-00-00 00:00:00',0,1,'components/com_jce/media/img/menu/logo.png',0,'',277,286,0,'',1),(233,'main','WF_MENU_CPANEL','wf-menu-cpanel','','jce/wf-menu-cpanel','index.php?option=com_jce','component',0,232,2,846,0,'0000-00-00 00:00:00',0,1,'components/com_jce/media/img/menu/jce-cpanel.png',0,'',278,279,0,'',1),(234,'main','WF_MENU_CONFIG','wf-menu-config','','jce/wf-menu-config','index.php?option=com_jce&view=config','component',0,232,2,846,0,'0000-00-00 00:00:00',0,1,'components/com_jce/media/img/menu/jce-config.png',0,'',280,281,0,'',1),(235,'main','WF_MENU_PROFILES','wf-menu-profiles','','jce/wf-menu-profiles','index.php?option=com_jce&view=profiles','component',0,232,2,846,0,'0000-00-00 00:00:00',0,1,'components/com_jce/media/img/menu/jce-profiles.png',0,'',282,283,0,'',1),(236,'main','WF_MENU_INSTALL','wf-menu-install','','jce/wf-menu-install','index.php?option=com_jce&view=installer','component',0,232,2,846,0,'0000-00-00 00:00:00',0,1,'components/com_jce/media/img/menu/jce-install.png',0,'',284,285,0,'',1),(237,'main','COM_ARTICLEGENERATOR','com-articlegenerator','','com-articlegenerator','index.php?option=com_articlegenerator','component',0,1,1,847,0,'0000-00-00 00:00:00',0,1,'components/com_articlegenerator/assets/images/logo_articlegenerator_16.png',0,'',287,288,0,'',1),(239,'main','COM_DPCALENDAR','com-dpcalendar','','com-dpcalendar','index.php?option=com_dpcalendar','component',0,1,1,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',289,302,0,'',1),(240,'main','COM_DPCALENDAR_SUBMENU_CPANEL','com-dpcalendar-submenu-cpanel','','com-dpcalendar/com-dpcalendar-submenu-cpanel','index.php?option=com_dpcalendar&view=cpanel','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',290,291,0,'',1),(241,'main','COM_DPCALENDAR_SUBMENU_EVENTS','com-dpcalendar-submenu-events','','com-dpcalendar/com-dpcalendar-submenu-events','index.php?option=com_dpcalendar&view=events','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',292,293,0,'',1),(242,'main','COM_DPCALENDAR_SUBMENU_CALENDARS','com-dpcalendar-submenu-calendars','','com-dpcalendar/com-dpcalendar-submenu-calendars','index.php?option=com_categories&extension=com_dpcalendar','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',294,295,0,'',1),(243,'main','COM_DPCALENDAR_SUBMENU_LOCATIONS','com-dpcalendar-submenu-locations','','com-dpcalendar/com-dpcalendar-submenu-locations','index.php?option=com_dpcalendar&view=locations','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',296,297,0,'',1),(244,'main','COM_DPCALENDAR_SUBMENU_TOOLS','com-dpcalendar-submenu-tools','','com-dpcalendar/com-dpcalendar-submenu-tools','index.php?option=com_dpcalendar&view=tools','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',298,299,0,'',1),(245,'main','COM_DPCALENDAR_SUBMENU_SUPPORT','com-dpcalendar-submenu-support','','com-dpcalendar/com-dpcalendar-submenu-support','index.php?option=com_dpcalendar&view=support','component',0,239,2,745,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',300,301,0,'',1),(246,'tickets','Categoría de Tickets','categoria-de-tickets','','categoria-de-tickets','index.php?option=com_ats&view=categories','component',1,1,1,830,0,'0000-00-00 00:00:00',1,1,'',10,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"110\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',303,304,0,'*',0),(247,'tickets','Últimos Tickets','ultimos-tickets','','ultimos-tickets','index.php?option=com_ats&view=latests','component',1,1,1,830,0,'0000-00-00 00:00:00',0,1,'',10,'{\"show_pagination\":\"1\",\"show_pagination_results\":\"1\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0,\"dropdown_item_subtext\":\"\",\"dropdown_customimage\":\"\",\"dropdown_customicon\":\"\",\"dropdown_customclass\":\"\",\"dropdown_columns\":\"1\",\"dropdown_distribution\":\"even\",\"dropdown_manual_distribution\":\"\",\"dropdown_dropdown_width\":\"\",\"dropdown_column_widths\":\"\",\"dropdown_children_group\":\"0\",\"dropdown_children_type\":\"menuitems\",\"dropdown_modules\":\"110\",\"dropdown_module_positions\":\"\",\"splitmenu_item_subtext\":\"\",\"splitmenu_customimage\":\"\",\"splitmenu_customicon\":\"\",\"splitmenu_customclass\":\"\"}',305,306,0,'*',0);
/*!40000 ALTER TABLE `nstest_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_menu_types`
--

DROP TABLE IF EXISTS `nstest_menu_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_menu_types`
--

LOCK TABLES `nstest_menu_types` WRITE;
/*!40000 ALTER TABLE `nstest_menu_types` DISABLE KEYS */;
INSERT INTO `nstest_menu_types` VALUES (1,'mainmenu','Main Menu','The main menu for the site'),(2,'kunenamenu','Kunena Menu','This is the default Kunena menu. It is used as the top navigation for Kunena. It can be publish in any module position. Simply unpublish items that are not required.'),(3,'jomsocial','JomSocial toolbar','Toolbar items for JomSocial toolbar'),(4,'tickets','Tickets','Sistema de Tickets');
/*!40000 ALTER TABLE `nstest_menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_messages`
--

DROP TABLE IF EXISTS `nstest_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_messages`
--

LOCK TABLES `nstest_messages` WRITE;
/*!40000 ALTER TABLE `nstest_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_messages_cfg`
--

DROP TABLE IF EXISTS `nstest_messages_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_messages_cfg`
--

LOCK TABLES `nstest_messages_cfg` WRITE;
/*!40000 ALTER TABLE `nstest_messages_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_messages_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_modules`
--

DROP TABLE IF EXISTS `nstest_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) NOT NULL DEFAULT '',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_modules`
--

LOCK TABLES `nstest_modules` WRITE;
/*!40000 ALTER TABLE `nstest_modules` DISABLE KEYS */;
INSERT INTO `nstest_modules` VALUES (1,55,'Main Menu','','',1,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',1,1,'{\"menutype\":\"mainmenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(2,56,'Login','','',1,'login',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'',1,'*'),(3,57,'Popular Articles','','',3,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_popular',3,1,'{\"count\":\"5\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(4,58,'Recently Added Articles','','',4,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latest',3,1,'{\"count\":\"5\",\"ordering\":\"c_dsc\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(8,59,'Toolbar','','',1,'toolbar',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_toolbar',3,1,'',1,'*'),(9,60,'Quick Icons','','',1,'icon',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_quickicon',3,1,'',1,'*'),(10,61,'Logged-in Users','','',2,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_logged',3,1,'{\"count\":\"5\",\"name\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(12,62,'Admin Menu','','',1,'menu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',3,1,'{\"layout\":\"\",\"moduleclass_sfx\":\"\",\"shownew\":\"1\",\"showhelp\":\"1\",\"cache\":\"0\"}',1,'*'),(13,63,'Admin Submenu','','',1,'submenu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_submenu',3,1,'',1,'*'),(14,64,'User Status','','',2,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_status',3,1,'',1,'*'),(15,65,'Title','','',1,'title',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_title',3,1,'',1,'*'),(16,50,'Identificación','','',1,'sidebar-a',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,0,'{\"pretext\":\"\",\"posttext\":\"\",\"login\":\"\",\"logout\":\"\",\"greeting\":\"1\",\"name\":\"0\",\"usesecure\":\"0\",\"usetext\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"module_tag\":\"div\",\"bootstrap_size\":\"0\",\"header_tag\":\"h3\",\"header_class\":\"\",\"style\":\"0\"}',0,'*'),(17,51,'Breadcrumbs','','',1,'breadcrumb',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_breadcrumbs',1,0,'{\"showHere\":\"1\",\"showHome\":\"1\",\"homeText\":\"Inicio\",\"showLast\":\"1\",\"separator\":\" | \",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\",\"module_tag\":\"div\",\"bootstrap_size\":\"0\",\"header_tag\":\"h3\",\"header_class\":\"\",\"style\":\"0\"}',0,'*'),(79,68,'Multilanguage status','','',1,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_multilangstatus',3,1,'{\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(86,69,'Joomla Version','','',1,'footer',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_version',3,1,'{\"format\":\"short\",\"product\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(87,55,'RokWeather','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_rokweather',1,1,'',0,'*'),(88,62,'RokStock','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_rokstock',1,1,'',0,'*'),(89,63,'Eventos','','',1,'sidebar-a',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_rokminievents',1,1,'{\"builtin_css\":\"1\",\"set_widths\":\"1\",\"wrapper_width\":\"750\",\"item_number\":\"3\",\"sortorder\":\"ascending\",\"time_range\":\"predefined_ranges\",\"startmin\":\"\",\"startmax\":\"\",\"rangespan\":\"current_month\",\"show_description\":\"1\",\"strip_tags\":\"a,i,br\",\"trim_description\":\"1\",\"trim_count\":\"200\",\"localtime\":\"local\",\"timezone\":\"America\\/Argentina\\/Mendoza\",\"dayformat\":\"%d\",\"monthformat\":\"%b\",\"yearformat\":\"%Y\",\"timeformat\":\"%I:%M %p\",\"datedisplay\":\"badge\",\"showyear\":\"0\",\"limit_count\":\"0\",\"events_pane\":\"3\",\"timeline\":\"arrows\",\"timeline_dates\":\"inline\",\"transition\":\"Expo.easeInOut\",\"duration\":\"500\",\"offset_x\":\"0\",\"google\":\"0\",\"google_gid\":\"marcebarcelona@gmail.com\",\"google_past\":\"1\",\"google_maxresults\":\"25\",\"google_gcache\":\"3600\",\"google_links\":\"link_no\",\"jomsocial\":\"1\",\"jomsocial_category\":[\"0\"],\"jomsocial_total\":\"10\",\"jomsocial_type\":\"all\",\"jomsocial_past\":\"1\",\"jomsocial_links\":\"link_no\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"module_cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\",\"module_tag\":\"div\",\"bootstrap_size\":\"0\",\"header_tag\":\"h3\",\"header_class\":\"\",\"style\":\"0\"}',0,'*'),(90,65,'DPCalendar Upcoming','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_dpcalendar_upcoming',1,1,'',0,'*'),(91,68,'DPCalendar Counter','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_dpcalendar_counter',1,1,'',0,'*'),(92,69,'DPCalendar Mini','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_dpcalendar_mini',1,1,'',0,'*'),(93,74,'Community - Active Groups','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_activegroups',1,1,'',0,'*'),(94,75,'Community - Activity Stream','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_activitystream',1,1,'',0,'*'),(95,76,'Community - Events Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_events',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":5}',0,'*'),(96,77,'Community - Groups Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_groups',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":5}',0,'*'),(97,78,'Community - Members Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_members',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":20}',0,'*'),(98,79,'Community - Photos Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_photos',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":20}',0,'*'),(99,80,'Community - Quick Search Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_quicksearch',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":\"\"}',0,'*'),(100,81,'Community - Videos Module','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_videos',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":3}',0,'*'),(101,82,'Community - Whos Online','','',1,'js_side_frontpage',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_community_whosonline',1,1,'{\"moduleclass_sfx\":\" app-box\",\"default\":20}',0,'*'),(102,83,'Community - Dating Search','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_datingsearch',1,1,'',0,'*'),(103,84,'Community - Hello Me','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_hellome',1,1,'',0,'*'),(104,85,'Community - JomSocial Connect','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_jomsocialconnect',1,1,'',0,'*'),(105,86,'Community - Latest Discussion','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_latestdiscussion',1,1,'',0,'*'),(106,87,'Community - Latest group posts','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_latestgrouppost',1,1,'',0,'*'),(107,88,'Community - Jomsocial Notification','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_notify',1,1,'',0,'*'),(108,89,'Community - Photo Comments','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_photocomments',1,1,'',0,'*'),(109,90,'Community - JomSocial Statistics','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_statistics',1,1,'',0,'*'),(110,91,'Community - Top Members','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_topmembers',1,1,'',0,'*'),(111,92,'Community - Video Comments','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_videocomments',1,1,'',0,'*'),(112,106,'Akeeba Ticket System - Credits info','','',0,'left',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_atscredits',1,1,'',0,'*'),(113,0,'Advertfield for ArticleGenerator','','',1,'user99',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_custom',1,0,'{\"prepare_content\":\"1\",\"backgroundimage\":\"\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}',0,'*'),(114,109,'Evangelio del Día','','',1,'mainbottom-a',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_feed',1,1,'{\"rssurl\":\"http:\\/\\/evangeliodeldia.org\\/rss\\/v2\\/evangelizo_rss-sp.xml\",\"rssrtl\":\"0\",\"rsstitle\":\"0\",\"rssdesc\":\"0\",\"rssimage\":\"1\",\"rssitems\":\"5\",\"rssitemdesc\":\"1\",\"word_count\":\"200\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"module_tag\":\"div\",\"bootstrap_size\":\"0\",\"header_tag\":\"h3\",\"header_class\":\"\",\"style\":\"0\"}',0,'*'),(119,119,'Vinaora Nivo Slider','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_vt_nivo_slider',1,1,'',0,'*'),(120,120,'Banner principal','','',1,'slideshow',868,'2014-06-04 15:56:01','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_vt_nivo_slider',1,0,'{\"demo\":\"-1\",\"theme\":\"amazing\",\"slide_width\":\"1200\",\"slide_height\":\"400\",\"item_dir\":\"\\/images\\/notthingamsquared\",\"item_path\":\"\",\"item_title\":\"Aymara Intranet\\r\\nTecnolog\\u00eda de punta\\r\\nEsta es la prueba 3\\r\\nEsta es la prueba 4\\r\\nEsta es la prueba 5\",\"item_description\":\"Todo lo que necesit\\u00e1s en un solo sitio\\r\\nDisfruta de lo mejor de la web 2.0\\r\\nEsta es mi descripci\\u00f3n 3\\r\\nEsta es mi descripci\\u00f3n 4\\r\\nEsta es mi descripci\\u00f3n 5\",\"item_url\":\"\",\"item_target\":\"_blank\",\"effect\":\"fade\",\"slices\":\"5\",\"boxCols\":\"5\",\"boxRows\":\"4\",\"animSpeed\":\"500\",\"pauseTime\":\"3000\",\"startSlide\":\"0\",\"directionNav\":\"1\",\"controlNav\":\"0\",\"pauseOnHover\":\"1\",\"manualAdvance\":\"1\",\"prevText\":\"Prev.\",\"nextText\":\"Pr\\u00f3x.\",\"ribbon\":\"1\",\"controlPosition\":\"bottomright\",\"controlStyle\":\"01.png\",\"arrowStyle\":\"01.png\",\"titleColor\":\"#333333\",\"titleFontSize\":\"22\",\"titleFontStyle\":\"\",\"descColor\":\"#333333\",\"descFontSize\":\"14\",\"descFontStyle\":\"\",\"captionWidth\":\"auto\",\"captionHeight\":\"auto\",\"captionBackground\":\"#7AB867\",\"captionPosition\":\"bottomright\",\"captionMarginVertical\":\"\",\"captionMarginHorizontal\":\"\",\"captionRounded\":\"all\",\"slide_bgcolor\":\"\",\"slide_bdcolor\":\"\",\"slide_bdwidth\":\"0\",\"slide_bdrounded\":\"1\",\"slide_bdshadow\":\"0\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\",\"controlNavThumbs\":\"false\",\"module_tag\":\"div\",\"bootstrap_size\":\"0\",\"header_tag\":\"h3\",\"header_class\":\"\",\"style\":\"0\"}',0,'*');
/*!40000 ALTER TABLE `nstest_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_modules_menu`
--

DROP TABLE IF EXISTS `nstest_modules_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_modules_menu`
--

LOCK TABLES `nstest_modules_menu` WRITE;
/*!40000 ALTER TABLE `nstest_modules_menu` DISABLE KEYS */;
INSERT INTO `nstest_modules_menu` VALUES (1,0),(2,0),(3,0),(4,0),(6,0),(7,0),(8,0),(9,0),(10,0),(12,0),(13,0),(14,0),(15,0),(16,101),(17,0),(79,0),(86,0),(89,101),(90,0),(91,0),(92,0),(95,0),(96,0),(97,0),(98,0),(99,0),(100,0),(101,0),(112,0),(114,101),(120,101);
/*!40000 ALTER TABLE `nstest_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_newsfeeds`
--

DROP TABLE IF EXISTS `nstest_newsfeeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `link` varchar(200) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(10) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(10) unsigned NOT NULL DEFAULT '3600',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `images` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_newsfeeds`
--

LOCK TABLES `nstest_newsfeeds` WRITE;
/*!40000 ALTER TABLE `nstest_newsfeeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_newsfeeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_oneclickaction_actions`
--

DROP TABLE IF EXISTS `nstest_oneclickaction_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_oneclickaction_actions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL,
  `actionurl` varchar(4000) NOT NULL,
  `otp` char(64) NOT NULL,
  `expiry` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_oneclickaction_actions`
--

LOCK TABLES `nstest_oneclickaction_actions` WRITE;
/*!40000 ALTER TABLE `nstest_oneclickaction_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_oneclickaction_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_overrider`
--

DROP TABLE IF EXISTS `nstest_overrider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_overrider` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `constant` varchar(255) NOT NULL,
  `string` text NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_overrider`
--

LOCK TABLES `nstest_overrider` WRITE;
/*!40000 ALTER TABLE `nstest_overrider` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_overrider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload`
--

DROP TABLE IF EXISTS `nstest_phocadownload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sectionid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(250) NOT NULL DEFAULT '',
  `filename_play` varchar(250) NOT NULL DEFAULT '',
  `filename_preview` varchar(250) NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT '',
  `author_email` varchar(255) NOT NULL DEFAULT '',
  `author_url` varchar(255) NOT NULL DEFAULT '',
  `license` varchar(255) NOT NULL DEFAULT '',
  `license_url` varchar(255) NOT NULL DEFAULT '',
  `image_filename` varchar(255) NOT NULL DEFAULT '',
  `image_filename_spec1` varchar(255) NOT NULL DEFAULT '',
  `image_filename_spec2` varchar(255) NOT NULL DEFAULT '',
  `image_download` varchar(255) NOT NULL DEFAULT '',
  `video_filename` varchar(255) NOT NULL DEFAULT '',
  `link_external` varchar(255) NOT NULL DEFAULT '',
  `mirror1link` varchar(255) NOT NULL DEFAULT '',
  `mirror1title` varchar(255) NOT NULL DEFAULT '',
  `mirror1target` varchar(10) NOT NULL DEFAULT '',
  `mirror2link` varchar(255) NOT NULL DEFAULT '',
  `mirror2title` varchar(255) NOT NULL DEFAULT '',
  `mirror2target` varchar(10) NOT NULL DEFAULT '',
  `description` text,
  `features` text,
  `changelog` text,
  `notes` text,
  `userid` int(11) NOT NULL DEFAULT '0',
  `version` varchar(255) NOT NULL DEFAULT '',
  `directlink` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `textonly` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `confirm_license` int(11) NOT NULL DEFAULT '0',
  `unaccessible_file` int(11) NOT NULL DEFAULT '0',
  `token` char(64) DEFAULT NULL,
  `tokenhits` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `metakey` text,
  `metadesc` text,
  `metadata` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`,`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload`
--

LOCK TABLES `nstest_phocadownload` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_categories`
--

DROP TABLE IF EXISTS `nstest_phocadownload_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `section` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `uploaduserid` text,
  `accessuserid` text,
  `deleteuserid` text,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `count` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `metakey` text,
  `metadesc` text,
  `metadata` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_categories`
--

LOCK TABLES `nstest_phocadownload_categories` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_file_votes`
--

DROP TABLE IF EXISTS `nstest_phocadownload_file_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_file_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_file_votes`
--

LOCK TABLES `nstest_phocadownload_file_votes` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_file_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_file_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_file_votes_statistics`
--

DROP TABLE IF EXISTS `nstest_phocadownload_file_votes_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_file_votes_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `average` float(8,6) NOT NULL DEFAULT '0.000000',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_file_votes_statistics`
--

LOCK TABLES `nstest_phocadownload_file_votes_statistics` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_file_votes_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_file_votes_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_layout`
--

DROP TABLE IF EXISTS `nstest_phocadownload_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categories` text,
  `category` text,
  `file` text,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_layout`
--

LOCK TABLES `nstest_phocadownload_layout` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_layout` DISABLE KEYS */;
INSERT INTO `nstest_phocadownload_layout` VALUES (1,'<div class=\"pd-categoriesbox\">\r\n<div class=\"pd-title\">{pdtitle}</div>\r\n{pdsubcategories}\r\n{pdclear}\r\n</div>','<div class=\"pd-filebox\">\r\n{pdfiledesctop}\r\n{pdfile}\r\n<div class=\"pd-buttons\">{pdbuttondownload}</div>\r\n<div class=\"pd-buttons\">{pdbuttondetails}</div>\r\n<div class=\"pd-buttons\">{pdbuttonpreview}</div>\r\n<div class=\"pd-buttons\">{pdbuttonplay}</div>\r\n<div class=\"pd-mirrors\">{pdmirrorlink2} {pdmirrorlink1}</div>\r\n<div class=\"pd-rating\">{pdrating}</div>\r\n<div class=\"pd-tags\">{pdtags}</div>\r\n{pdfiledescbottom}\r\n<div class=\"pd-cb\"></div>\r\n</div>','<div class=\"pd-filebox\">\r\n{pdimage}\r\n{pdfile}\r\n{pdfilesize}\r\n{pdversion}\r\n{pdlicense}\r\n{pdauthor}\r\n{pdauthoremail}\r\n{pdfiledate}\r\n{pddownloads}\r\n{pddescription}\r\n{pdfeatures}\r\n{pdchangelog}\r\n{pdnotes}\r\n<div class=\"pd-mirrors\">{pdmirrorlink2} {pdmirrorlink1}</div>\r\n<div class=\"pd-report\">{pdreportlink}</div>\r\n<div class=\"pd-rating\">{pdrating}</div>\r\n<div class=\"pd-tags\">{pdtags}</div>\r\n<div class=\"pd-cb\"></div>\r\n</div>',0,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `nstest_phocadownload_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_licenses`
--

DROP TABLE IF EXISTS `nstest_phocadownload_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_licenses`
--

LOCK TABLES `nstest_phocadownload_licenses` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_licenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_logging`
--

DROP TABLE IF EXISTS `nstest_phocadownload_logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_logging` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `page` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_logging`
--

LOCK TABLES `nstest_phocadownload_logging` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_logging` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_logging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_styles`
--

DROP TABLE IF EXISTS `nstest_phocadownload_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_styles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `menulink` text,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_styles`
--

LOCK TABLES `nstest_phocadownload_styles` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_styles` DISABLE KEYS */;
INSERT INTO `nstest_phocadownload_styles` VALUES (1,'Phocadownload','phocadownload','phocadownload.css',NULL,1,1,0,'0000-00-00 00:00:00',1,NULL,'*'),(2,'Rating','rating','rating.css',NULL,1,1,0,'0000-00-00 00:00:00',2,NULL,'*'),(3,'Button','button','button.css',NULL,1,0,0,'0000-00-00 00:00:00',3,NULL,'*'),(4,'Button (Rounded Corners)','','buttonrc.css',NULL,1,0,0,'0000-00-00 00:00:00',4,NULL,'*'),(5,'Default','default','default.css',NULL,2,1,0,'0000-00-00 00:00:00',1,NULL,'*'),(6,'Bootstrap','','bootstrap.min.css',NULL,1,0,0,'0000-00-00 00:00:00',5,NULL,'*');
/*!40000 ALTER TABLE `nstest_phocadownload_styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_tags`
--

DROP TABLE IF EXISTS `nstest_phocadownload_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link_ext` varchar(255) NOT NULL DEFAULT '',
  `link_cat` int(11) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text,
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_tags`
--

LOCK TABLES `nstest_phocadownload_tags` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_tags_ref`
--

DROP TABLE IF EXISTS `nstest_phocadownload_tags_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_tags_ref` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `tagid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `i_fileid` (`fileid`,`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_tags_ref`
--

LOCK TABLES `nstest_phocadownload_tags_ref` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_tags_ref` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_tags_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_phocadownload_user_stat`
--

DROP TABLE IF EXISTS `nstest_phocadownload_user_stat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_phocadownload_user_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_phocadownload_user_stat`
--

LOCK TABLES `nstest_phocadownload_user_stat` WRITE;
/*!40000 ALTER TABLE `nstest_phocadownload_user_stat` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_phocadownload_user_stat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_postinstall_messages`
--

DROP TABLE IF EXISTS `nstest_postinstall_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_postinstall_messages` (
  `postinstall_message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `extension_id` bigint(20) NOT NULL DEFAULT '700' COMMENT 'FK to #__extensions',
  `title_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'Lang key for the title',
  `description_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'Lang key for description',
  `action_key` varchar(255) NOT NULL DEFAULT '',
  `language_extension` varchar(255) NOT NULL DEFAULT 'com_postinstall' COMMENT 'Extension holding lang keys',
  `language_client_id` tinyint(3) NOT NULL DEFAULT '1',
  `type` varchar(10) NOT NULL DEFAULT 'link' COMMENT 'Message type - message, link, action',
  `action_file` varchar(255) DEFAULT '' COMMENT 'RAD URI to the PHP file containing action method',
  `action` varchar(255) DEFAULT '' COMMENT 'Action method name or URL',
  `condition_file` varchar(255) DEFAULT NULL COMMENT 'RAD URI to file holding display condition method',
  `condition_method` varchar(255) DEFAULT NULL COMMENT 'Display condition method, must return boolean',
  `version_introduced` varchar(50) NOT NULL DEFAULT '3.2.0' COMMENT 'Version when this message was introduced',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`postinstall_message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_postinstall_messages`
--

LOCK TABLES `nstest_postinstall_messages` WRITE;
/*!40000 ALTER TABLE `nstest_postinstall_messages` DISABLE KEYS */;
INSERT INTO `nstest_postinstall_messages` VALUES (1,700,'PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_TITLE','PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_BODY','PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_ACTION','plg_twofactorauth_totp',1,'action','site://plugins/twofactorauth/totp/postinstall/actions.php','twofactorauth_postinstall_action','site://plugins/twofactorauth/totp/postinstall/actions.php','twofactorauth_postinstall_condition','3.2.0',0),(2,700,'COM_CPANEL_MSG_EACCELERATOR_TITLE','COM_CPANEL_MSG_EACCELERATOR_BODY','COM_CPANEL_MSG_EACCELERATOR_BUTTON','com_cpanel',1,'action','admin://components/com_admin/postinstall/eaccelerator.php','admin_postinstall_eaccelerator_action','admin://components/com_admin/postinstall/eaccelerator.php','admin_postinstall_eaccelerator_condition','3.2.0',1),(3,700,'COM_CPANEL_WELCOME_BEGINNERS_TITLE','COM_CPANEL_WELCOME_BEGINNERS_MESSAGE','','com_cpanel',1,'message','','','','','3.2.0',1),(4,700,'COM_CPANEL_MSG_PHPVERSION_TITLE','COM_CPANEL_MSG_PHPVERSION_BODY','','com_cpanel',1,'message','','','admin://components/com_admin/postinstall/phpversion.php','admin_postinstall_phpversion_condition','3.2.2',1);
/*!40000 ALTER TABLE `nstest_postinstall_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_redirect_links`
--

DROP TABLE IF EXISTS `nstest_redirect_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_redirect_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_redirect_links`
--

LOCK TABLES `nstest_redirect_links` WRITE;
/*!40000 ALTER TABLE `nstest_redirect_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_redirect_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokcommon_configs`
--

DROP TABLE IF EXISTS `nstest_rokcommon_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokcommon_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(45) NOT NULL DEFAULT '',
  `type` varchar(45) NOT NULL,
  `file` varchar(256) NOT NULL,
  `priority` int(10) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokcommon_configs`
--

LOCK TABLES `nstest_rokcommon_configs` WRITE;
/*!40000 ALTER TABLE `nstest_rokcommon_configs` DISABLE KEYS */;
INSERT INTO `nstest_rokcommon_configs` VALUES (3,'rokgallery','container','/components/com_rokgallery/container.xml',10),(4,'rokgallery','library','/components/com_rokgallery/lib',10),(7,'roksprocket','container','/components/com_roksprocket/container.xml',10),(8,'roksprocket','library','/components/com_roksprocket/lib',10);
/*!40000 ALTER TABLE `nstest_rokcommon_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_file_loves`
--

DROP TABLE IF EXISTS `nstest_rokgallery_file_loves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_file_loves` (
  `file_id` int(10) unsigned NOT NULL DEFAULT '0',
  `kount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `file_id` (`file_id`),
  CONSTRAINT `nstest_file_loves_file_id_files_id` FOREIGN KEY (`file_id`) REFERENCES `nstest_rokgallery_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_file_loves`
--

LOCK TABLES `nstest_rokgallery_file_loves` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_file_loves` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_file_loves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_file_tags`
--

DROP TABLE IF EXISTS `nstest_rokgallery_file_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_file_tags` (
  `file_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`file_id`,`tag`),
  KEY `nstest_rokgallery_file_tags_file_id_idx` (`file_id`),
  CONSTRAINT `nstest_file_tags_file_id_files_id` FOREIGN KEY (`file_id`) REFERENCES `nstest_rokgallery_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_file_tags`
--

LOCK TABLES `nstest_rokgallery_file_tags` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_file_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_file_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_file_views`
--

DROP TABLE IF EXISTS `nstest_rokgallery_file_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_file_views` (
  `file_id` int(10) unsigned NOT NULL DEFAULT '0',
  `kount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `file_id` (`file_id`),
  CONSTRAINT `nstest_file_views_file_id__files_id` FOREIGN KEY (`file_id`) REFERENCES `nstest_rokgallery_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_file_views`
--

LOCK TABLES `nstest_rokgallery_file_views` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_file_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_file_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_files`
--

DROP TABLE IF EXISTS `nstest_rokgallery_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `guid` char(36) NOT NULL,
  `md5` char(32) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `license` varchar(255) DEFAULT NULL,
  `xsize` int(10) unsigned NOT NULL,
  `ysize` int(10) unsigned NOT NULL,
  `filesize` int(10) unsigned NOT NULL,
  `type` char(20) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `nstest_files_sluggable_idx` (`slug`),
  KEY `nstest_rokgallery_files_published_idx` (`published`),
  KEY `nstest_rokgallery_files_md5_idx` (`md5`),
  KEY `nstest_rokgallery_files_guid_idx` (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_files`
--

LOCK TABLES `nstest_rokgallery_files` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_files_index`
--

DROP TABLE IF EXISTS `nstest_rokgallery_files_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_files_index` (
  `keyword` varchar(200) NOT NULL DEFAULT '',
  `field` varchar(50) NOT NULL DEFAULT '',
  `position` bigint(20) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword`,`field`,`position`,`id`),
  KEY `nstest_rokgallery_files_index_id_idx` (`id`),
  CONSTRAINT `nstest_rokgallery_files_index_id_idx` FOREIGN KEY (`id`) REFERENCES `nstest_rokgallery_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_files_index`
--

LOCK TABLES `nstest_rokgallery_files_index` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_files_index` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_files_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_filters`
--

DROP TABLE IF EXISTS `nstest_rokgallery_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_filters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `query` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `rokgallery_profiles_name_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_filters`
--

LOCK TABLES `nstest_rokgallery_filters` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_filters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_galleries`
--

DROP TABLE IF EXISTS `nstest_rokgallery_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `filetags` longtext,
  `width` int(10) unsigned NOT NULL DEFAULT '910',
  `height` int(10) unsigned NOT NULL DEFAULT '500',
  `keep_aspect` tinyint(1) DEFAULT '0',
  `force_image_size` tinyint(1) DEFAULT '0',
  `thumb_xsize` int(10) unsigned NOT NULL DEFAULT '190',
  `thumb_ysize` int(10) unsigned NOT NULL DEFAULT '150',
  `thumb_background` varchar(12) DEFAULT NULL,
  `thumb_keep_aspect` tinyint(1) DEFAULT '0',
  `auto_publish` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `nstest_rokgallery_galleries_auto_publish_idx` (`auto_publish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_galleries`
--

LOCK TABLES `nstest_rokgallery_galleries` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_jobs`
--

DROP TABLE IF EXISTS `nstest_rokgallery_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_jobs` (
  `id` char(36) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL,
  `properties` text,
  `state` varchar(255) NOT NULL,
  `status` text,
  `percent` bigint(20) unsigned DEFAULT NULL,
  `sm` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_jobs`
--

LOCK TABLES `nstest_rokgallery_jobs` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_profiles`
--

DROP TABLE IF EXISTS `nstest_rokgallery_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `profile` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `nstest_rokgallery_profiles_name_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_profiles`
--

LOCK TABLES `nstest_rokgallery_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_schema_version`
--

DROP TABLE IF EXISTS `nstest_rokgallery_schema_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_schema_version` (
  `version` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_schema_version`
--

LOCK TABLES `nstest_rokgallery_schema_version` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_schema_version` DISABLE KEYS */;
INSERT INTO `nstest_rokgallery_schema_version` VALUES (2);
/*!40000 ALTER TABLE `nstest_rokgallery_schema_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_slice_tags`
--

DROP TABLE IF EXISTS `nstest_rokgallery_slice_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_slice_tags` (
  `slice_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`slice_id`,`tag`),
  KEY `rokgallery_slice_tags_slice_id_idx` (`slice_id`),
  CONSTRAINT `nstest_slice_tags_slice_id_slices_id` FOREIGN KEY (`slice_id`) REFERENCES `nstest_rokgallery_slices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_slice_tags`
--

LOCK TABLES `nstest_rokgallery_slice_tags` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_slice_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_slice_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_slices`
--

DROP TABLE IF EXISTS `nstest_rokgallery_slices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_slices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(10) unsigned NOT NULL,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `guid` char(36) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `caption` text,
  `link` text,
  `filesize` int(10) unsigned NOT NULL,
  `xsize` int(10) unsigned NOT NULL,
  `ysize` int(10) unsigned NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `admin_thumb` tinyint(1) NOT NULL DEFAULT '0',
  `manipulations` longtext,
  `palette` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `thumb_xsize` int(10) unsigned NOT NULL,
  `thumb_ysize` int(10) unsigned NOT NULL,
  `thumb_keep_aspect` tinyint(1) NOT NULL DEFAULT '1',
  `thumb_background` varchar(12) DEFAULT NULL,
  `ordering` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `guid` (`guid`),
  UNIQUE KEY `nstest_rokgallery_slices_sluggable_idx` (`slug`,`gallery_id`),
  KEY `rokgallery_slices_published_idx` (`published`),
  KEY `rokgallery_slices_guid_idx` (`guid`),
  KEY `file_id_idx` (`file_id`),
  KEY `gallery_id_idx` (`gallery_id`),
  CONSTRAINT `nstest_slices_file_id_files_id` FOREIGN KEY (`file_id`) REFERENCES `nstest_rokgallery_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nstest_slices_gallery_id_galleries_id` FOREIGN KEY (`gallery_id`) REFERENCES `nstest_rokgallery_galleries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_slices`
--

LOCK TABLES `nstest_rokgallery_slices` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_slices` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_slices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_rokgallery_slices_index`
--

DROP TABLE IF EXISTS `nstest_rokgallery_slices_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_rokgallery_slices_index` (
  `keyword` varchar(200) NOT NULL DEFAULT '',
  `field` varchar(50) NOT NULL DEFAULT '',
  `position` bigint(20) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword`,`field`,`position`,`id`),
  KEY `rokgallery_slices_index_id_idx` (`id`),
  CONSTRAINT `nstest_rokgallery_slices_index_id_idx` FOREIGN KEY (`id`) REFERENCES `nstest_rokgallery_slices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_rokgallery_slices_index`
--

LOCK TABLES `nstest_rokgallery_slices_index` WRITE;
/*!40000 ALTER TABLE `nstest_rokgallery_slices_index` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_rokgallery_slices_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_schemas`
--

DROP TABLE IF EXISTS `nstest_schemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_schemas`
--

LOCK TABLES `nstest_schemas` WRITE;
/*!40000 ALTER TABLE `nstest_schemas` DISABLE KEYS */;
INSERT INTO `nstest_schemas` VALUES (700,'3.3.0-2014-04-02'),(737,'3.2.9422'),(739,'3.9.15633'),(805,'3.3.5'),(814,'3.0.2'),(847,'2.2');
/*!40000 ALTER TABLE `nstest_schemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_session`
--

DROP TABLE IF EXISTS `nstest_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_session` (
  `session_id` varchar(200) NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) DEFAULT '',
  `data` mediumtext,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_session`
--

LOCK TABLES `nstest_session` WRITE;
/*!40000 ALTER TABLE `nstest_session` DISABLE KEYS */;
INSERT INTO `nstest_session` VALUES ('mph3curkjojqfcpc43kotq81q4',0,1,'1401897368','__default|a:10:{s:15:\"session.counter\";i:90;s:19:\"session.timer.start\";i:1401798072;s:18:\"session.timer.last\";i:1401897295;s:17:\"session.timer.now\";i:1401897366;s:22:\"session.client.browser\";s:109:\"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36\";s:8:\"registry\";O:24:\"Joomla\\Registry\\Registry\":1:{s:7:\"\\0\\0\\0data\";O:8:\"stdClass\":3:{s:5:\"users\";O:8:\"stdClass\":1:{s:5:\"login\";O:8:\"stdClass\":1:{s:4:\"form\";O:8:\"stdClass\":2:{s:6:\"return\";s:20:\"index.php?Itemid=101\";s:4:\"data\";a:0:{}}}}s:13:\"rememberLogin\";b:1;s:10:\"com_kunena\";O:8:\"stdClass\":1:{s:12:\"user868_read\";a:4:{i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:0;i:0;}}}}s:4:\"user\";O:5:\"JUser\":27:{s:9:\"\\0\\0\\0isRoot\";b:1;s:2:\"id\";s:3:\"868\";s:4:\"name\";s:27:\"Marcelo Herrera - TMS Group\";s:8:\"username\";s:5:\"Chelo\";s:5:\"email\";s:24:\"marcebarcelona@gmail.com\";s:8:\"password\";s:60:\"$2y$10$qOWhrCGmWd1M4yXDd2DcduWVhFEj34NHR09eVL3iFgjkMLkj6EMkG\";s:14:\"password_clear\";s:0:\"\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"1\";s:12:\"registerDate\";s:19:\"2014-04-07 16:47:00\";s:13:\"lastvisitDate\";s:19:\"2014-06-04 11:51:07\";s:10:\"activation\";s:1:\"0\";s:6:\"params\";s:114:\"{\"update_cache_list\":1,\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}\";s:6:\"groups\";a:2:{i:2;s:1:\"2\";i:8;s:1:\"8\";}s:5:\"guest\";i:0;s:13:\"lastResetTime\";s:19:\"0000-00-00 00:00:00\";s:10:\"resetCount\";s:1:\"0\";s:12:\"requireReset\";s:1:\"0\";s:10:\"\\0\\0\\0_params\";O:24:\"Joomla\\Registry\\Registry\":1:{s:7:\"\\0\\0\\0data\";O:8:\"stdClass\":7:{s:17:\"update_cache_list\";i:1;s:11:\"admin_style\";s:0:\"\";s:14:\"admin_language\";s:0:\"\";s:8:\"language\";s:0:\"\";s:6:\"editor\";s:0:\"\";s:8:\"helpsite\";s:0:\"\";s:8:\"timezone\";s:0:\"\";}}s:14:\"\\0\\0\\0_authGroups\";a:3:{i:0;i:1;i:1;i:2;i:3;i:8;}s:14:\"\\0\\0\\0_authLevels\";a:5:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:6;}s:15:\"\\0\\0\\0_authActions\";N;s:12:\"\\0\\0\\0_errorMsg\";N;s:10:\"\\0\\0\\0_errors\";a:0:{}s:3:\"aid\";i:0;s:6:\"otpKey\";s:0:\"\";s:4:\"otep\";s:0:\"\";}s:13:\"session.token\";s:32:\"6af342ead3510fc96caaf3cbf9996937\";s:23:\"gantry-current-template\";s:10:\"rt_epsilon\";s:16:\"com_mailto.links\";a:1:{s:40:\"952ebd264b130beba9f2517bb62ad52bae2d899e\";O:8:\"stdClass\":2:{s:4:\"link\";s:76:\"http://localhost/joomla32/index.php/17-banner-principal/5-intranet-publicada\";s:6:\"expiry\";i:1401897366;}}}',0,''),('pm5qsl07emnql7ah706u9ecsu1',1,0,'1401897363','__default|a:8:{s:15:\"session.counter\";i:224;s:19:\"session.timer.start\";i:1401882651;s:18:\"session.timer.last\";i:1401897360;s:17:\"session.timer.now\";i:1401897361;s:22:\"session.client.browser\";s:109:\"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36\";s:8:\"registry\";O:24:\"Joomla\\Registry\\Registry\":1:{s:7:\"\\0\\0\\0data\";O:8:\"stdClass\":9:{s:11:\"application\";O:8:\"stdClass\":1:{s:4:\"lang\";s:0:\"\";}s:13:\"com_installer\";O:8:\"stdClass\":4:{s:7:\"message\";s:0:\"\";s:17:\"extension_message\";s:0:\"\";s:6:\"manage\";O:8:\"stdClass\":4:{s:6:\"filter\";O:8:\"stdClass\":5:{s:6:\"search\";s:3:\"rok\";s:9:\"client_id\";s:0:\"\";s:6:\"status\";s:0:\"\";s:4:\"type\";s:0:\"\";s:5:\"group\";s:0:\"\";}s:8:\"ordercol\";s:4:\"name\";s:9:\"orderdirn\";s:3:\"asc\";s:10:\"limitstart\";i:0;}s:12:\"redirect_url\";N;}s:11:\"com_modules\";O:8:\"stdClass\":3:{s:7:\"modules\";O:8:\"stdClass\":4:{s:6:\"filter\";O:8:\"stdClass\":8:{s:18:\"client_id_previous\";i:0;s:6:\"search\";s:6:\"banner\";s:6:\"access\";i:0;s:5:\"state\";s:0:\"\";s:8:\"position\";s:0:\"\";s:6:\"module\";s:0:\"\";s:9:\"client_id\";i:0;s:8:\"language\";s:0:\"\";}s:8:\"ordercol\";s:8:\"position\";s:9:\"orderdirn\";s:3:\"asc\";s:10:\"limitstart\";i:0;}s:3:\"add\";O:8:\"stdClass\":1:{s:6:\"module\";O:8:\"stdClass\":2:{s:12:\"extension_id\";N;s:6:\"params\";N;}}s:4:\"edit\";O:8:\"stdClass\":1:{s:6:\"module\";O:8:\"stdClass\":2:{s:4:\"data\";N;s:2:\"id\";a:1:{i:0;i:120;}}}}s:6:\"global\";O:8:\"stdClass\":1:{s:4:\"list\";O:8:\"stdClass\":1:{s:5:\"limit\";i:100;}}s:15:\"com_roksprocket\";O:8:\"stdClass\":2:{s:4:\"edit\";O:8:\"stdClass\":1:{s:6:\"module\";O:8:\"stdClass\":2:{s:2:\"id\";a:0:{}s:4:\"data\";N;}}s:9:\"module_id\";i:118;}s:11:\"com_plugins\";O:8:\"stdClass\":2:{s:7:\"plugins\";O:8:\"stdClass\":4:{s:6:\"filter\";O:8:\"stdClass\":4:{s:6:\"search\";s:0:\"\";s:6:\"access\";i:0;s:7:\"enabled\";s:0:\"\";s:6:\"folder\";s:0:\"\";}s:8:\"ordercol\";s:6:\"folder\";s:9:\"orderdirn\";s:3:\"asc\";s:10:\"limitstart\";s:3:\"100\";}s:4:\"edit\";O:8:\"stdClass\":1:{s:6:\"plugin\";O:8:\"stdClass\":2:{s:2:\"id\";a:0:{}s:4:\"data\";N;}}}s:10:\"com_gantry\";O:8:\"stdClass\":1:{s:4:\"edit\";O:8:\"stdClass\":1:{s:8:\"template\";O:8:\"stdClass\":2:{s:2:\"id\";a:0:{}s:4:\"data\";N;}}}s:11:\"com_content\";O:8:\"stdClass\":1:{s:4:\"edit\";O:8:\"stdClass\":1:{s:7:\"article\";O:8:\"stdClass\":2:{s:2:\"id\";a:0:{}s:4:\"data\";N;}}}s:5:\"media\";O:8:\"stdClass\":1:{s:4:\"list\";O:8:\"stdClass\":1:{s:6:\"layout\";s:6:\"thumbs\";}}}}s:4:\"user\";O:5:\"JUser\":27:{s:9:\"\\0\\0\\0isRoot\";b:1;s:2:\"id\";s:3:\"868\";s:4:\"name\";s:27:\"Marcelo Herrera - TMS Group\";s:8:\"username\";s:5:\"Chelo\";s:5:\"email\";s:24:\"marcebarcelona@gmail.com\";s:8:\"password\";s:60:\"$2y$10$qOWhrCGmWd1M4yXDd2DcduWVhFEj34NHR09eVL3iFgjkMLkj6EMkG\";s:14:\"password_clear\";s:0:\"\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"1\";s:12:\"registerDate\";s:19:\"2014-04-07 16:47:00\";s:13:\"lastvisitDate\";s:19:\"2014-06-03 12:22:04\";s:10:\"activation\";s:1:\"0\";s:6:\"params\";s:114:\"{\"update_cache_list\":1,\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}\";s:6:\"groups\";a:2:{i:2;s:1:\"2\";i:8;s:1:\"8\";}s:5:\"guest\";i:0;s:13:\"lastResetTime\";s:19:\"0000-00-00 00:00:00\";s:10:\"resetCount\";s:1:\"0\";s:12:\"requireReset\";s:1:\"0\";s:10:\"\\0\\0\\0_params\";O:24:\"Joomla\\Registry\\Registry\":1:{s:7:\"\\0\\0\\0data\";O:8:\"stdClass\":7:{s:17:\"update_cache_list\";i:1;s:11:\"admin_style\";s:0:\"\";s:14:\"admin_language\";s:0:\"\";s:8:\"language\";s:0:\"\";s:6:\"editor\";s:0:\"\";s:8:\"helpsite\";s:0:\"\";s:8:\"timezone\";s:0:\"\";}}s:14:\"\\0\\0\\0_authGroups\";a:3:{i:0;i:1;i:1;i:2;i:3;i:8;}s:14:\"\\0\\0\\0_authLevels\";a:5:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:6;}s:15:\"\\0\\0\\0_authActions\";N;s:12:\"\\0\\0\\0_errorMsg\";N;s:10:\"\\0\\0\\0_errors\";a:0:{}s:3:\"aid\";i:0;s:6:\"otpKey\";s:0:\"\";s:4:\"otep\";s:0:\"\";}s:13:\"session.token\";s:32:\"4fbd8a4d632635626731adb370abd443\";}__wf|a:1:{s:13:\"session.token\";s:32:\"bec3d2660bd2a7546b803c21aa702cd4\";}roksprocket|a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}',868,'Chelo');
/*!40000 ALTER TABLE `nstest_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_tags`
--

DROP TABLE IF EXISTS `nstest_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tag_idx` (`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_tags`
--

LOCK TABLES `nstest_tags` WRITE;
/*!40000 ALTER TABLE `nstest_tags` DISABLE KEYS */;
INSERT INTO `nstest_tags` VALUES (1,0,0,1,0,'','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'','','','',0,'2011-01-01 00:00:01','',0,'0000-00-00 00:00:00','','',0,'*',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `nstest_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_template_styles`
--

DROP TABLE IF EXISTS `nstest_template_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_template_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) NOT NULL DEFAULT '',
  `client_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `home` char(7) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_template_styles`
--

LOCK TABLES `nstest_template_styles` WRITE;
/*!40000 ALTER TABLE `nstest_template_styles` DISABLE KEYS */;
INSERT INTO `nstest_template_styles` VALUES (4,'beez3',0,'0','Beez3 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/joomla_black.gif\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management\",\"navposition\":\"left\",\"templatecolor\":\"personal\",\"html5\":\"0\"}'),(5,'hathor',1,'0','Hathor - Default','{\"showSiteName\":\"0\",\"colourChoice\":\"\",\"boldText\":\"0\"}'),(7,'protostar',0,'0','protostar - Default','{\"templateColor\":\"\",\"logoFile\":\"\",\"googleFont\":\"1\",\"googleFontName\":\"Open+Sans\",\"fluidContainer\":\"0\"}'),(8,'isis',1,'1','isis - Default','{\"templateColor\":\"\",\"logoFile\":\"\"}'),(10,'rt_epsilon',0,'1','Aymará Intranet','{\"master\":\"true\",\"current_id\":\"10\",\"template_full_name\":\"Epsilon\",\"grid_system\":\"12\",\"template_prefix\":\"epsilon-\",\"cookie_time\":\"31536000\",\"override_set\":\"2.5\",\"name\":\"Preset1\",\"copy_lang_files_if_diff\":\"1\",\"logo\":{\"enabled\":\"1\",\"position\":\"header-a\",\"type\":\"epsilon\",\"custom\":{\"image\":\"\"}},\"accent\":{\"color1\":\"#70B620\",\"color2\":\"#FAC843\"},\"header\":{\"text-color\":\"#898788\",\"background\":\"#EAE6E5\",\"type\":\"headroom\",\"top-offset\":\"80\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"demoroksprocket\":{\"type\":\"preset4\"},\"showcase\":{\"text-color\":\"#898788\",\"background\":\"#EAE6E5\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"top\":{\"text-color\":\"#EFEFEF\",\"background\":\"#70B620\",\"type\":\"epsilon\",\"customtop\":{\"image\":\"\"},\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"utility\":{\"text-color\":\"#898788\",\"background\":\"#EAE6E5\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"feature\":{\"text-color\":\"#AAA8A9\",\"background\":\"#FFFFFF\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"maintop\":{\"text-color\":\"#EFEFEF\",\"background\":\"#70B620\",\"type\":\"epsilon\",\"custommaintop\":{\"image\":\"\"},\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"expandedtop\":{\"text-color\":\"#818181\",\"background\":\"#EDECED\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"mainbody\":{\"overlay\":\"light\"},\"expandedbottom\":{\"text-color\":\"#818181\",\"background\":\"#EDECED\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"extension\":{\"text-color\":\"#AAA8A9\",\"background\":\"#FFFFFF\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"bottom\":{\"text-color\":\"#898788\",\"background\":\"#EAE6E5\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"footer\":{\"text-color\":\"#9F9FA1\",\"background\":\"#323337\",\"type\":\"epsilon\",\"customfooter\":{\"image\":\"\"},\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"copyright\":{\"text-color\":\"#9F9FA1\",\"background\":\"#323337\",\"enabled\":\"1\",\"position\":\"copyright-b\",\"text\":\"Hecho por TMS Group SA\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"font\":{\"family\":\"s:epsilon\",\"size\":\"default\",\"size-is\":\"default\"},\"viewswitcher-priority\":\"1\",\"logo-priority\":\"2\",\"copyright-priority\":\"3\",\"styledeclaration-priority\":\"4\",\"fontsizer-priority\":\"5\",\"date-priority\":\"7\",\"totop-priority\":\"8\",\"systemmessages-priority\":\"9\",\"smartload-priority\":\"13\",\"pagesuffix-priority\":\"14\",\"resetsettings-priority\":\"15\",\"analytics-priority\":\"16\",\"dropdownmenu-priority\":\"18\",\"jstools-priority\":\"21\",\"moduleoverlays-priority\":\"22\",\"rtl-priority\":\"23\",\"splitmenu-priority\":\"24\",\"webfonts-priority\":\"27\",\"styledeclaration-enabled\":\"1\",\"social\":{\"enabled\":\"0\",\"target\":\"_blank\",\"button-1-icon\":\"\",\"button-1-text\":\"\",\"button-1-link\":\"\",\"button-3-icon\":\"\",\"button-3-text\":\"\",\"button-3-link\":\"\",\"button-5-icon\":\"\",\"button-5-text\":\"\",\"button-5-link\":\"\",\"position\":\"copyright-a\",\"hidden-spacer\":\"\",\"button-2-icon\":\"\",\"button-2-text\":\"\",\"button-2-link\":\"\",\"button-4-icon\":\"\",\"button-4-text\":\"\",\"button-4-link\":\"\",\"button-6-icon\":\"\",\"button-6-text\":\"\",\"button-6-link\":\"\"},\"chart-enabled\":\"1\",\"comingsoon\":{\"enabled\":\"0\",\"date\":\"1\",\"month\":\"0\",\"year\":\"2020\"},\"email-subscription\":{\"enabled\":\"1\"},\"feedburner-uri\":\"\",\"systemmessages\":{\"enabled\":\"1\",\"position\":\"drawer\"},\"date\":{\"enabled\":\"0\",\"position\":\"utility-a\",\"clientside\":\"0\",\"formats\":\"%A, %B %d, %Y\"},\"fontsizer\":{\"enabled\":\"0\",\"position\":\"utility-b\"},\"login\":{\"enabled\":\"0\",\"position\":\"sidebar-c\",\"text\":\"Ingreso\",\"logouttext\":\"Salir\"},\"popup\":{\"enabled\":\"0\",\"position\":\"utility-d\",\"text\":\"Popup Module\"},\"branding\":{\"enabled\":\"0\",\"position\":\"copyright-a\"},\"totop\":{\"enabled\":\"1\",\"position\":\"copyright-c\",\"text\":\"Back to Top\"},\"resetsettings\":{\"enabled\":\"0\",\"position\":\"copyright-d\",\"text\":\"Reset Settings\"},\"analytics\":{\"enabled\":\"0\",\"code\":\"\",\"position\":\"analytics\"},\"menu\":{\"enabled\":\"1\",\"type\":\"dropdownmenu\",\"dropdownmenu\":{\"theme\":\"gantry-dropdown\",\"limit_levels\":\"0\",\"startLevel\":\"0\",\"showAllChildren\":\"1\",\"class_sfx\":\"top\",\"cache\":\"0\",\"menutype\":\"mainmenu\",\"position\":\"header-b\",\"responsive-menu\":\"panel\",\"enable-current-id\":\"1\",\"module_cache\":\"1\"},\"splitmenu\":{\"mainmenu-limit_levels\":\"1\",\"mainmenu-startLevel\":\"0\",\"mainmenu-endLevel\":\"0\",\"mainmenu-class_sfx\":\"top\",\"submenu-limit_levels\":\"1\",\"submenu-startLevel\":\"1\",\"submenu-endLevel\":\"9\",\"cache\":\"0\",\"menutype\":\"mainmenu\",\"theme\":\"gantry-splitmenu\",\"mainmenu-position\":\"header-b\",\"submenu-position\":\"sidebar-a\",\"submenu-title\":\"1\",\"submenu-class_sfx\":\"\",\"submenu-module_sfx\":\"\",\"responsive-menu\":\"panel\",\"roknavmenu_dropdown_enable-current-id\":\"0\",\"module_cache\":\"1\"}},\"mainbodyPosition\":\"6,3,3\",\"mainbottom\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"layout-mode\":\"responsive\",\"loadtransition\":\"1\",\"component-enabled\":\"1\",\"mainbody-enabled\":\"1\",\"rtl-enabled\":\"0\",\"pagesuffix-enabled\":\"1\",\"selectivizr-enabled\":\"1\",\"less\":{\"compression\":\"1\",\"compilewait\":\"2\",\"debugheader\":\"0\"},\"ie7splash-enabled\":\"1\",\"demo\":\"1\",\"k2\":\"0\"}'),(11,'oziofullscreen',0,'0','oziofullscreen - Default','{}'),(13,'rt_hadron',0,'0','Hadron - Default','{\"master\":\"true\",\"current_id\":\"13\",\"template_full_name\":\"Hadron\",\"grid_system\":\"12\",\"template_prefix\":\"hadron-\",\"cookie_time\":\"31536000\",\"override_set\":\"2.5\",\"name\":\"Preset1\",\"copy_lang_files_if_diff\":\"1\",\"logo\":{\"enabled\":\"1\",\"position\":\"header-a\",\"type\":\"preset1\",\"custom\":{\"image\":\"\"}},\"accent\":{\"color1\":\"#86DBC8\",\"color2\":\"#34AE93\"},\"button\":{\"text-color\":\"#314F49\",\"background\":\"#86DBC8\"},\"border\":{\"style\":\"semirounded\"},\"header\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"navigation\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"showcase\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"1\",\"showmax\":\"3\"},\"utility\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#1F2022\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"feature\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"maintop\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#131315\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"mainbody\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#27292B\"},\"bottom\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"footer\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"copyright\":{\"overlay\":\"dark\",\"text-color\":\"#BBBBBB\",\"background\":\"#191A1C\",\"enabled\":\"1\",\"position\":\"copyright-b\",\"text\":\"Designed by RocketTheme\",\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"font\":{\"family\":\"s:hadron\",\"size\":\"default\",\"size-is\":\"default\"},\"viewswitcher-priority\":\"1\",\"logo-priority\":\"2\",\"styledeclaration-priority\":\"4\",\"fontsizer-priority\":\"5\",\"date-priority\":\"7\",\"totop-priority\":\"8\",\"systemmessages-priority\":\"9\",\"smartload-priority\":\"13\",\"pagesuffix-priority\":\"14\",\"resetsettings-priority\":\"15\",\"analytics-priority\":\"16\",\"dropdownmenu-priority\":\"18\",\"jstools-priority\":\"21\",\"moduleoverlays-priority\":\"22\",\"rtl-priority\":\"23\",\"splitmenu-priority\":\"24\",\"webfonts-priority\":\"27\",\"branding-priority\":\"28\",\"copyright-priority\":\"29\",\"styledeclaration-enabled\":\"1\",\"social\":{\"enabled\":\"0\",\"target\":\"_blank\",\"button-1-icon\":\"\",\"button-1-text\":\"\",\"button-1-link\":\"\",\"button-3-icon\":\"\",\"button-3-text\":\"\",\"button-3-link\":\"\",\"button-5-icon\":\"\",\"button-5-text\":\"\",\"button-5-link\":\"\",\"position\":\"navigation-b\",\"hidden-spacer\":\"\",\"button-2-icon\":\"\",\"button-2-text\":\"\",\"button-2-link\":\"\",\"button-4-icon\":\"\",\"button-4-text\":\"\",\"button-4-link\":\"\",\"button-6-icon\":\"\",\"button-6-text\":\"\",\"button-6-link\":\"\"},\"chart-enabled\":\"1\",\"comingsoon\":{\"enabled\":\"0\",\"date\":\"1\",\"month\":\"0\",\"year\":\"2020\"},\"email-subscription\":{\"enabled\":\"1\"},\"feedburner-uri\":\"\",\"systemmessages\":{\"enabled\":\"1\",\"position\":\"drawer\"},\"date\":{\"enabled\":\"0\",\"position\":\"utility-a\",\"clientside\":\"0\",\"formats\":\"%A, %B %d, %Y\"},\"fontsizer\":{\"enabled\":\"0\",\"position\":\"utility-b\"},\"login\":{\"enabled\":\"0\",\"position\":\"utility-c\",\"text\":\"Member Login\",\"logouttext\":\"Logout\"},\"popup\":{\"enabled\":\"0\",\"position\":\"utility-d\",\"text\":\"Popup Module\"},\"branding\":{\"enabled\":\"1\",\"position\":\"copyright-a\"},\"totop\":{\"enabled\":\"1\",\"position\":\"copyright-c\",\"text\":\"Back to Top\"},\"resetsettings\":{\"enabled\":\"0\",\"position\":\"copyright-d\",\"text\":\"Reset Settings\"},\"analytics\":{\"enabled\":\"0\",\"code\":\"\",\"position\":\"analytics\"},\"menu\":{\"enabled\":\"1\",\"type\":\"dropdownmenu\",\"dropdownmenu\":{\"theme\":\"gantry-dropdown\",\"limit_levels\":\"0\",\"startLevel\":\"0\",\"showAllChildren\":\"1\",\"class_sfx\":\"top\",\"cache\":\"0\",\"menutype\":\"mainmenu\",\"position\":\"navigation-a\",\"responsive-menu\":\"panel\",\"enable-current-id\":\"0\",\"module_cache\":\"1\"},\"splitmenu\":{\"mainmenu-limit_levels\":\"1\",\"mainmenu-startLevel\":\"0\",\"mainmenu-endLevel\":\"0\",\"mainmenu-class_sfx\":\"top\",\"submenu-limit_levels\":\"1\",\"submenu-startLevel\":\"1\",\"submenu-endLevel\":\"9\",\"cache\":\"0\",\"menutype\":\"mainmenu\",\"theme\":\"gantry-splitmenu\",\"mainmenu-position\":\"navigation-a\",\"submenu-position\":\"sidebar-a\",\"submenu-title\":\"1\",\"submenu-class_sfx\":\"\",\"submenu-module_sfx\":\"\",\"responsive-menu\":\"panel\",\"roknavmenu_dropdown_enable-current-id\":\"0\",\"module_cache\":\"1\"}},\"top\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"expandedtop\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"mainbodyPosition\":\"6,3,3\",\"mainbottom\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"expandedbottom\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"extension\":{\"layout\":\"3,3,3,3\",\"showall\":\"0\",\"showmax\":\"6\"},\"layout-mode\":\"responsive\",\"loadtransition\":\"0\",\"component-enabled\":\"1\",\"mainbody-enabled\":\"1\",\"rtl-enabled\":\"0\",\"pagesuffix-enabled\":\"1\",\"selectivizr-enabled\":\"1\",\"less\":{\"compression\":\"1\",\"compilewait\":\"2\",\"debugheader\":\"0\"},\"ie7splash-enabled\":\"1\",\"demo\":\"1\",\"k2\":\"0\"}');
/*!40000 ALTER TABLE `nstest_template_styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ucm_base`
--

DROP TABLE IF EXISTS `nstest_ucm_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ucm_base` (
  `ucm_id` int(10) unsigned NOT NULL,
  `ucm_item_id` int(10) NOT NULL,
  `ucm_type_id` int(11) NOT NULL,
  `ucm_language_id` int(11) NOT NULL,
  PRIMARY KEY (`ucm_id`),
  KEY `idx_ucm_item_id` (`ucm_item_id`),
  KEY `idx_ucm_type_id` (`ucm_type_id`),
  KEY `idx_ucm_language_id` (`ucm_language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ucm_base`
--

LOCK TABLES `nstest_ucm_base` WRITE;
/*!40000 ALTER TABLE `nstest_ucm_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ucm_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ucm_content`
--

DROP TABLE IF EXISTS `nstest_ucm_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ucm_content` (
  `core_content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `core_type_alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'FK to the content types table',
  `core_title` varchar(255) NOT NULL,
  `core_alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `core_body` mediumtext NOT NULL,
  `core_state` tinyint(1) NOT NULL DEFAULT '0',
  `core_checked_out_time` varchar(255) NOT NULL DEFAULT '',
  `core_checked_out_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `core_access` int(10) unsigned NOT NULL DEFAULT '0',
  `core_params` text NOT NULL,
  `core_featured` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `core_metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `core_created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `core_created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `core_created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_modified_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Most recent user that modified',
  `core_modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_language` char(7) NOT NULL,
  `core_publish_up` datetime NOT NULL,
  `core_publish_down` datetime NOT NULL,
  `core_content_item_id` int(10) unsigned DEFAULT NULL COMMENT 'ID from the individual type table',
  `asset_id` int(10) unsigned DEFAULT NULL COMMENT 'FK to the #__assets table.',
  `core_images` text NOT NULL,
  `core_urls` text NOT NULL,
  `core_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `core_version` int(10) unsigned NOT NULL DEFAULT '1',
  `core_ordering` int(11) NOT NULL DEFAULT '0',
  `core_metakey` text NOT NULL,
  `core_metadesc` text NOT NULL,
  `core_catid` int(10) unsigned NOT NULL DEFAULT '0',
  `core_xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `core_type_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`core_content_id`),
  KEY `tag_idx` (`core_state`,`core_access`),
  KEY `idx_access` (`core_access`),
  KEY `idx_alias` (`core_alias`),
  KEY `idx_language` (`core_language`),
  KEY `idx_title` (`core_title`),
  KEY `idx_modified_time` (`core_modified_time`),
  KEY `idx_created_time` (`core_created_time`),
  KEY `idx_content_type` (`core_type_alias`),
  KEY `idx_core_modified_user_id` (`core_modified_user_id`),
  KEY `idx_core_checked_out_user_id` (`core_checked_out_user_id`),
  KEY `idx_core_created_user_id` (`core_created_user_id`),
  KEY `idx_core_type_id` (`core_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains core content data in name spaced fields';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ucm_content`
--

LOCK TABLES `nstest_ucm_content` WRITE;
/*!40000 ALTER TABLE `nstest_ucm_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_ucm_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_ucm_history`
--

DROP TABLE IF EXISTS `nstest_ucm_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_ucm_history` (
  `version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ucm_item_id` int(10) unsigned NOT NULL,
  `ucm_type_id` int(10) unsigned NOT NULL,
  `version_note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Optional version name',
  `save_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `character_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of characters in this version.',
  `sha1_hash` varchar(50) NOT NULL DEFAULT '' COMMENT 'SHA1 hash of the version_data column.',
  `version_data` mediumtext NOT NULL COMMENT 'json-encoded string of version data',
  `keep_forever` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=auto delete; 1=keep',
  PRIMARY KEY (`version_id`),
  KEY `idx_ucm_item_id` (`ucm_type_id`,`ucm_item_id`),
  KEY `idx_save_date` (`save_date`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_ucm_history`
--

LOCK TABLES `nstest_ucm_history` WRITE;
/*!40000 ALTER TABLE `nstest_ucm_history` DISABLE KEYS */;
INSERT INTO `nstest_ucm_history` VALUES (1,8,6,'','2014-04-11 14:38:22',868,543,'5ca5478a204dd709d81f624c23e1bba4eff8a837','{\"id\":8,\"asset_id\":56,\"parent_id\":\"1\",\"lft\":\"13\",\"rgt\":14,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Institutional Content\",\"alias\":\"institutional-content\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-04-11 14:38:22\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(2,9,7,'','2014-04-11 15:21:43',868,545,'b340a8b6831c647be60ec282be150b5232bc3742','{\"id\":9,\"asset_id\":57,\"parent_id\":\"1\",\"lft\":\"15\",\"rgt\":16,\"level\":1,\"path\":null,\"extension\":\"com_contact\",\"title\":\"Institutional Contacts\",\"alias\":\"institutional-contacts\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-04-11 15:21:43\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(3,1,1,'','2014-04-11 15:22:46',868,2792,'7f3434cf5f836cb0f149c36db2dd13b30c7caa41','{\"id\":1,\"asset_id\":58,\"title\":\"Contact Information\",\"alias\":\"contact-information\",\"introtext\":\"<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">For general inquiries, please contact our corporate headquarters at (555) 555-5555 or\\u00a0<a href=\\\"mailto:info@bitstew.com\\\" target=\\\"_blank\\\">info@nottinghamsquared.com<\\/a>.<\\/p>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">For sales or product information, please contact us at\\u00a0<a href=\\\"mailto:sales@bitstew.com\\\" target=\\\"_blank\\\">sales@nottinghamsquared.com<\\/a><\\/p>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">If you are an existing customer and require technical support, please contact\\u00a0<a href=\\\"mailto:support@bitstew.com\\\" target=\\\"_blank\\\">support@nottinghamsquared.com<\\/a><\\/p>\\r\\n<h3 style=\\\"font-size: 1.17em; color: #333333; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Send us a message<\\/h3>\",\"fulltext\":\"\",\"state\":1,\"catid\":\"8\",\"created\":\"2014-04-11 15:22:46\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"\",\"modified_by\":null,\"checked_out\":null,\"checked_out_time\":null,\"publish_up\":\"2014-04-11 15:22:46\",\"publish_down\":\"0000-00-00 00:00:00\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":1,\"ordering\":null,\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":null,\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(4,2,1,'','2014-04-11 15:23:55',868,3525,'d55ce27828fa255ff8705de22e2a27b85283ca9d','{\"id\":2,\"asset_id\":59,\"title\":\"Product & Services\",\"alias\":\"product-services\",\"introtext\":\"<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">Widespread adoption of social and mobile technology is having a profound impact on how companies interact with customers, employees and stakeholders across the supply chain. A more connected marketplace has made managing business more complicated. Massive amounts of data now available to the business are both a problem to address and an opportunity to pursue.<\\/p>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">These changes are forcing enterprise-wide digital transformation with information technology moving from solely a back office support function to a critical interaction point. The standard approaches to application development and management no longer suffice as the message to be more agile and deliver solutions faster with higher quality outcomes at a lower price\\u2014is now stronger than ever.<\\/p>\\r\\n<ul style=\\\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">\\r\\n<li>Human Capital\\r\\n<ul>\\r\\n<li>SAP<\\/li>\\r\\n<li>Oracle<\\/li>\\r\\n<li>Itron<\\/li>\\r\\n<li>L&amp;G<\\/li>\\r\\n<li>Elster<\\/li>\\r\\n<li>Smart Grid<\\/li>\\r\\n<\\/ul>\\r\\n<\\/li>\\r\\n<li>Consulting Services (on-shore and off-shore)\\r\\n<ul>\\r\\n<li>SAP<\\/li>\\r\\n<li>Oracle<\\/li>\\r\\n<li>Itron<\\/li>\\r\\n<li>L&amp;G<\\/li>\\r\\n<li>Elster<\\/li>\\r\\n<li>Smart Grid<\\/li>\\r\\n<li>Cyber Security<\\/li>\\r\\n<li>Analystics<\\/li>\\r\\n<\\/ul>\\r\\n<\\/li>\\r\\n<li>Outsourcing \\/ Managed Services (on-shore and off-shore)\\r\\n<ul>\\r\\n<li>Help Desk<\\/li>\\r\\n<li>Entire IT Department<\\/li>\\r\\n<li>application management<\\/li>\\r\\n<li>application development<\\/li>\\r\\n<li>SaaS<\\/li>\\r\\n<\\/ul>\\r\\n<\\/li>\\r\\n<\\/ul>\",\"fulltext\":\"\",\"state\":1,\"catid\":\"8\",\"created\":\"2014-04-11 15:23:55\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"\",\"modified_by\":null,\"checked_out\":null,\"checked_out_time\":null,\"publish_up\":\"2014-04-11 15:23:55\",\"publish_down\":\"0000-00-00 00:00:00\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":1,\"ordering\":null,\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":null,\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(5,3,1,'','2014-04-11 16:39:23',868,4492,'21e729a12c737fb7a56f85ca6eac25403e97669b','{\"id\":3,\"asset_id\":60,\"title\":\"Industry Expertise\",\"alias\":\"industry-expertise\",\"introtext\":\"<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">Excelling in technology is more important than ever in the new global economy.\\u00a0\\u00a0 Partnering with a proven resource that gives your organization a competitive advantage has never been more important.\\u00a0 Nottingham Squared provides a broad, deep spectrum of knowledge around information technology.\\u00a0 We have the best and brightest minds in North and South America working on the most complex issues in multiple industries.\\u00a0 See how we can help you meet your strategic goals and objectives.<\\/p>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">\\u00a0<\\/p>\\r\\n<table>\\r\\n<tbody>\\r\\n<tr>\\r\\n<td>\\u00a0<\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Utilities<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Oil &amp; Energy<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Healthcare<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Financial Services<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Manufacturing<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<\\/tbody>\\r\\n<\\/table>\",\"fulltext\":\"\",\"state\":0,\"catid\":\"8\",\"created\":\"2014-04-11 16:39:23\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"\",\"modified_by\":null,\"checked_out\":null,\"checked_out_time\":null,\"publish_up\":\"\",\"publish_down\":\"\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":1,\"ordering\":null,\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":null,\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(6,3,1,'','2014-04-11 16:55:23',868,5008,'3343dfc43a8eae76d8b23dd2b5f0cc1558be2973','{\"id\":3,\"asset_id\":\"60\",\"title\":\"Industry Expertise\",\"alias\":\"industry-expertise\",\"introtext\":\"<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">Excelling in technology is more important than ever in the new global economy.\\u00a0\\u00a0 Partnering with a proven resource that gives your organization a competitive advantage has never been more important.\\u00a0 Nottingham Squared provides a broad, deep spectrum of knowledge around information technology.\\u00a0 We have the best and brightest minds in North and South America working on the most complex issues in multiple industries.\\u00a0 See how we can help you meet your strategic goals and objectives.<\\/p>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">\\u00a0<\\/p>\\r\\n<table>\\r\\n<tbody>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/8554301672_f76436a9ca_b.jpg\\\" alt=\\\"\\\" width=\\\"288\\\" height=\\\"133\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Utilities<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/Work.1.png\\\" alt=\\\"\\\" width=\\\"297\\\" height=\\\"91\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Oil &amp; Energy<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/catedral.png\\\" alt=\\\"\\\" width=\\\"291\\\" height=\\\"89\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Healthcare<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/TechTiles.png\\\" alt=\\\"\\\" width=\\\"291\\\" height=\\\"89\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Financial Services<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/Solder.png\\\" alt=\\\"\\\" width=\\\"288\\\" height=\\\"88\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Manufacturing<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<\\/tbody>\\r\\n<\\/table>\",\"fulltext\":\"\",\"state\":0,\"catid\":\"8\",\"created\":\"2014-04-11 16:39:23\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"2014-04-11 16:55:23\",\"modified_by\":\"868\",\"checked_out\":\"868\",\"checked_out_time\":\"2014-04-11 16:52:15\",\"publish_up\":\"\",\"publish_down\":\"\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":2,\"ordering\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":\"0\",\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(7,3,1,'','2014-04-11 16:55:49',868,4852,'91759ed665dd875024aac6cc27e9af34fbaf7449','{\"id\":3,\"asset_id\":\"60\",\"title\":\"Industry Expertise\",\"alias\":\"industry-expertise\",\"introtext\":\"<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">Excelling in technology is more important than ever in the new global economy.\\u00a0\\u00a0 Partnering with a proven resource that gives your organization a competitive advantage has never been more important.\\u00a0 Nottingham Squared provides a broad, deep spectrum of knowledge around information technology.\\u00a0 We have the best and brightest minds in North and South America working on the most complex issues in multiple industries.\\u00a0 See how we can help you meet your strategic goals and objectives.\\u00a0<\\/p>\\r\\n<table>\\r\\n<tbody>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/8554301672_f76436a9ca_b.jpg\\\" alt=\\\"\\\" width=\\\"288\\\" height=\\\"133\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Utilities<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/Work.1.png\\\" alt=\\\"\\\" width=\\\"297\\\" height=\\\"91\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Oil &amp; Energy<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/catedral.png\\\" alt=\\\"\\\" width=\\\"291\\\" height=\\\"89\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Healthcare<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/TechTiles.png\\\" alt=\\\"\\\" width=\\\"291\\\" height=\\\"89\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Financial Services<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<tr>\\r\\n<td>\\u00a0<img src=\\\"images\\/notthingamsquared\\/Solder.png\\\" alt=\\\"\\\" width=\\\"288\\\" height=\\\"88\\\" \\/><\\/td>\\r\\n<td>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Manufacturing<\\/h4>\\r\\n<p style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">We provide strong reliable servicies...<\\/p>\\r\\n<\\/td>\\r\\n<\\/tr>\\r\\n<\\/tbody>\\r\\n<\\/table>\",\"fulltext\":\"\",\"state\":0,\"catid\":\"8\",\"created\":\"2014-04-11 16:39:23\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"2014-04-11 16:55:49\",\"modified_by\":\"868\",\"checked_out\":\"868\",\"checked_out_time\":\"2014-04-11 16:55:23\",\"publish_up\":\"\",\"publish_down\":\"\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":3,\"ordering\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":\"0\",\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(8,4,1,'','2014-04-11 16:56:26',868,2979,'a7650b415a8dff4b2dd770d1f4e97e5c90ab212d','{\"id\":4,\"asset_id\":61,\"title\":\"About Us\",\"alias\":\"about-us\",\"introtext\":\"<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Mission Statement<\\/h4>\\r\\n<p class=\\\"MsoNoSpacing\\\" style=\\\"margin-bottom: 1.3em; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\"><span style=\\\"font-size: 10.0pt; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;\\\">Partnering with our clients to give their overall business a strategic competitive advantage through Information Technology.<span>\\u00a0\\u00a0<\\/span>Bringing our partners the best and brightest minds from multiple industries giving their Information Technology organization a fresh perspective.<\\/span><\\/p>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Our Team<\\/h4>\\r\\n<ul style=\\\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">\\r\\n<li>Members<\\/li>\\r\\n<\\/ul>\\r\\n<h4 style=\\\"font-size: 14px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; line-height: 21px;\\\">Partners<\\/h4>\\r\\n<ul style=\\\"font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-size: 14px; line-height: 21px;\\\">\\r\\n<li>Partners<\\/li>\\r\\n<\\/ul>\",\"fulltext\":\"\",\"state\":1,\"catid\":\"8\",\"created\":\"2014-04-11 16:56:26\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"\",\"modified_by\":null,\"checked_out\":null,\"checked_out_time\":null,\"publish_up\":\"2014-04-11 16:56:26\",\"publish_down\":\"0000-00-00 00:00:00\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":1,\"ordering\":null,\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":null,\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(9,8,6,'','2014-05-20 14:22:53',868,605,'26e7053ac529b182872bebb6c8879496b6b10537','{\"id\":8,\"asset_id\":\"56\",\"parent_id\":\"1\",\"lft\":\"13\",\"rgt\":\"14\",\"level\":\"1\",\"path\":\"institutional-content\",\"extension\":\"com_content\",\"title\":\"Contenido Institucional\",\"alias\":\"institutional-content\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":\"868\",\"checked_out_time\":\"2014-05-20 14:22:36\",\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-04-11 14:38:22\",\"modified_user_id\":\"868\",\"modified_time\":\"2014-05-20 14:22:53\",\"hits\":\"0\",\"language\":\"*\",\"version\":\"1\"}',0),(10,11,6,'','2014-05-20 14:23:11',868,558,'0446fed9f5b290a9a44ed6d5a825d004a5a1f327','{\"id\":11,\"asset_id\":95,\"parent_id\":\"1\",\"lft\":\"19\",\"rgt\":20,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Noticias de Eventos Internos\",\"alias\":\"noticias-de-eventos-internos\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:23:11\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(11,12,6,'','2014-05-20 14:23:29',868,538,'44e8f136c3226edf998374429a0a7596fa9004ed','{\"id\":12,\"asset_id\":96,\"parent_id\":\"1\",\"lft\":\"21\",\"rgt\":22,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Noticias de Viajes\",\"alias\":\"noticias-de-viajes\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:23:29\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(12,13,6,'','2014-05-20 14:23:49',868,541,'5fd2ecbd3fc06463db6ba05c54a8e47060eb4636','{\"id\":13,\"asset_id\":97,\"parent_id\":\"1\",\"lft\":\"23\",\"rgt\":24,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Evangelio del D\\u00eda\",\"alias\":\"evangelio-del-dia\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:23:49\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(13,14,6,'','2014-05-20 14:24:15',868,549,'7d92931601c03f9b1f2241ae2047807dee743930','{\"id\":14,\"asset_id\":98,\"parent_id\":\"1\",\"lft\":\"25\",\"rgt\":26,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Documentaci\\u00f3n Interna\",\"alias\":\"documentacion-interna\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:24:15\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(14,15,6,'','2014-05-20 14:25:12',868,553,'efe6298bad503532549d6c682a213dd388825aff','{\"id\":15,\"asset_id\":99,\"parent_id\":\"14\",\"lft\":\"26\",\"rgt\":27,\"level\":2,\"path\":null,\"extension\":\"com_content\",\"title\":\"Reglamento Interno Aymara\",\"alias\":\"reglamento-interno-aymara\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:25:12\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(15,16,6,'','2014-05-20 14:28:17',868,532,'30f8e726680dc3f3629de235b21afc276e5f1531','{\"id\":16,\"asset_id\":100,\"parent_id\":\"14\",\"lft\":\"28\",\"rgt\":29,\"level\":2,\"path\":null,\"extension\":\"com_content\",\"title\":\"Notificaciones\",\"alias\":\"notificaciones\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:28:17\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(16,17,6,'','2014-05-20 14:28:51',868,535,'302209b7fe5f93c9dbdb496c5ddff25f2d5d2832','{\"id\":17,\"asset_id\":101,\"parent_id\":\"1\",\"lft\":\"31\",\"rgt\":32,\"level\":1,\"path\":null,\"extension\":\"com_content\",\"title\":\"Banner Principal\",\"alias\":\"banner-principal\",\"note\":\"\",\"description\":\"\",\"published\":\"1\",\"checked_out\":null,\"checked_out_time\":null,\"access\":\"1\",\"params\":\"{\\\"category_layout\\\":\\\"\\\",\\\"image\\\":\\\"\\\"}\",\"metadesc\":\"\",\"metakey\":\"\",\"metadata\":\"{\\\"author\\\":\\\"\\\",\\\"robots\\\":\\\"\\\"}\",\"created_user_id\":\"868\",\"created_time\":\"2014-05-20 14:28:51\",\"modified_user_id\":null,\"modified_time\":null,\"hits\":\"0\",\"language\":\"*\",\"version\":null}',0),(17,5,1,'','2014-05-30 14:00:19',868,1780,'3ace009c9c3b517edb0eba9ecbd7c72a92b4f8b0','{\"id\":5,\"asset_id\":110,\"title\":\"Intranet Publicada\",\"alias\":\"intranet-publicada\",\"introtext\":\"<p><img src=\\\"images\\/banners\\/shadow_image_106722.png\\\" alt=\\\"\\\" width=\\\"956\\\" height=\\\"410\\\" \\/><\\/p>\\r\\n<p>&nbsp;<\\/p>\",\"fulltext\":\"\",\"state\":1,\"catid\":\"17\",\"created\":\"2014-05-30 14:00:19\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"\",\"modified_by\":null,\"checked_out\":null,\"checked_out_time\":null,\"publish_up\":\"2014-05-30 14:00:19\",\"publish_down\":\"0000-00-00 00:00:00\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":1,\"ordering\":null,\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":null,\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"0\",\"language\":\"*\",\"xreference\":\"\"}',0),(18,5,1,'','2014-06-04 15:21:27',868,1818,'35be8389cd99fe9fb76e4de4812634fb622c71d3','{\"id\":5,\"asset_id\":\"110\",\"title\":\"Intranet Publicada\",\"alias\":\"intranet-publicada\",\"introtext\":\"<p><img src=\\\"images\\/banners\\/shadow_image_106722.png\\\" alt=\\\"\\\" width=\\\"956\\\" height=\\\"410\\\" \\/><\\/p>\\r\\n<p>&nbsp;<\\/p>\",\"fulltext\":\"\",\"state\":1,\"catid\":\"17\",\"created\":\"2014-05-30 14:00:19\",\"created_by\":\"868\",\"created_by_alias\":\"\",\"modified\":\"2014-06-04 15:21:27\",\"modified_by\":\"868\",\"checked_out\":\"868\",\"checked_out_time\":\"2014-06-04 15:20:47\",\"publish_up\":\"2014-05-30 14:00:19\",\"publish_down\":\"0000-00-00 00:00:00\",\"images\":\"{\\\"image_intro\\\":\\\"\\\",\\\"float_intro\\\":\\\"\\\",\\\"image_intro_alt\\\":\\\"\\\",\\\"image_intro_caption\\\":\\\"\\\",\\\"image_fulltext\\\":\\\"\\\",\\\"float_fulltext\\\":\\\"\\\",\\\"image_fulltext_alt\\\":\\\"\\\",\\\"image_fulltext_caption\\\":\\\"\\\"}\",\"urls\":\"{\\\"urla\\\":false,\\\"urlatext\\\":\\\"\\\",\\\"targeta\\\":\\\"\\\",\\\"urlb\\\":false,\\\"urlbtext\\\":\\\"\\\",\\\"targetb\\\":\\\"\\\",\\\"urlc\\\":false,\\\"urlctext\\\":\\\"\\\",\\\"targetc\\\":\\\"\\\"}\",\"attribs\":\"{\\\"show_title\\\":\\\"\\\",\\\"link_titles\\\":\\\"\\\",\\\"show_tags\\\":\\\"\\\",\\\"show_intro\\\":\\\"\\\",\\\"info_block_position\\\":\\\"\\\",\\\"show_category\\\":\\\"\\\",\\\"link_category\\\":\\\"\\\",\\\"show_parent_category\\\":\\\"\\\",\\\"link_parent_category\\\":\\\"\\\",\\\"show_author\\\":\\\"\\\",\\\"link_author\\\":\\\"\\\",\\\"show_create_date\\\":\\\"\\\",\\\"show_modify_date\\\":\\\"\\\",\\\"show_publish_date\\\":\\\"\\\",\\\"show_item_navigation\\\":\\\"\\\",\\\"show_icons\\\":\\\"\\\",\\\"show_print_icon\\\":\\\"\\\",\\\"show_email_icon\\\":\\\"\\\",\\\"show_vote\\\":\\\"\\\",\\\"show_hits\\\":\\\"\\\",\\\"show_noauth\\\":\\\"\\\",\\\"urls_position\\\":\\\"\\\",\\\"alternative_readmore\\\":\\\"\\\",\\\"article_layout\\\":\\\"\\\",\\\"show_publishing_options\\\":\\\"\\\",\\\"show_article_options\\\":\\\"\\\",\\\"show_urls_images_backend\\\":\\\"\\\",\\\"show_urls_images_frontend\\\":\\\"\\\"}\",\"version\":2,\"ordering\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"access\":\"1\",\"hits\":\"0\",\"metadata\":\"{\\\"robots\\\":\\\"\\\",\\\"author\\\":\\\"\\\",\\\"rights\\\":\\\"\\\",\\\"xreference\\\":\\\"\\\"}\",\"featured\":\"1\",\"language\":\"*\",\"xreference\":\"\"}',0);
/*!40000 ALTER TABLE `nstest_ucm_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_update_sites`
--

DROP TABLE IF EXISTS `nstest_update_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_update_sites` (
  `update_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `location` text NOT NULL,
  `enabled` int(11) DEFAULT '0',
  `last_check_timestamp` bigint(20) DEFAULT '0',
  `extra_query` varchar(1000) DEFAULT '',
  PRIMARY KEY (`update_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Update Sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_update_sites`
--

LOCK TABLES `nstest_update_sites` WRITE;
/*!40000 ALTER TABLE `nstest_update_sites` DISABLE KEYS */;
INSERT INTO `nstest_update_sites` VALUES (1,'Joomla Core','collection','http://update.joomla.org/core/list.xml',1,1401884173,''),(2,'Joomla Extension Directory','collection','http://update.joomla.org/jed/list.xml',1,1401884173,''),(3,'Accredited Joomla! Translations','collection','http://update.joomla.org/language/translationlist_3.xml',1,1401884173,''),(5,'RocketTheme Update Directory','collection','http://updates.rockettheme.com/joomla/updates.xml',1,1401884173,''),(6,'DPCalendar Free Update Site','extension','http://joomla.digital-peak.com/index.php?option=com_ars&view=update&task=stream&format=xml&id=4&ext=extension.xml',1,1401884173,''),(7,'Kunena 3.0 Update Site','collection','http://update.kunena.org/3.0/list.xml',1,1401884173,''),(8,'Ozio Gallery3 update site','extension','http://www.opensourcesolutions.es/download/oziogallery4.xml',0,0,''),(9,'Gantry Framework Update Site','extension','http://www.gantry-framework.org/updates/joomla16/gantry.xml',1,1401884173,''),(10,'Admin Tools Professional','extension','http://cdn.akeebabackup.com/updates/atpro.xml',1,1401884173,'dlid=1bb3b07cfa7012236ad81101a810dcb1'),(11,'Akeeba Backup Professional','extension','http://cdn.akeebabackup.com/updates/abpro.xml',1,1401884173,'dlid=1bb3b07cfa7012236ad81101a810dcb1'),(12,'Akeeba Ticket System Professional','extension','http://cdn.akeebabackup.com/updates/ats.xml',1,1401884173,'dlid=1bb3b07cfa7012236ad81101a810dcb1'),(13,'JCE Editor Updates','extension','https://www.joomlacontenteditor.net/index.php?option=com_updates&view=update&format=xml&id=1&file=extension.xml',1,1401884173,''),(14,'JCE MediaBox Updates','extension','https://www.joomlacontenteditor.net/index.php?option=com_updates&view=update&format=xml&id=3',1,1401884173,''),(15,'JCE MediaBox Updates','extension','https://www.joomlacontenteditor.net/index.php?option=com_updates&view=update&format=xml&id=3&file=extension.xml',1,1401884173,''),(16,'Vinaora Update Server','extension','http://update.vinaora.com/joomla3x/mod_vt_nivo_slider.xml',1,0,'');
/*!40000 ALTER TABLE `nstest_update_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_update_sites_extensions`
--

DROP TABLE IF EXISTS `nstest_update_sites_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT '0',
  `extension_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_update_sites_extensions`
--

LOCK TABLES `nstest_update_sites_extensions` WRITE;
/*!40000 ALTER TABLE `nstest_update_sites_extensions` DISABLE KEYS */;
INSERT INTO `nstest_update_sites_extensions` VALUES (1,700),(2,700),(3,600),(3,813),(5,707),(5,709),(5,711),(5,713),(5,715),(5,717),(5,726),(5,729),(5,731),(5,855),(5,857),(6,746),(7,752),(8,807),(9,809),(10,815),(11,823),(12,830),(13,846),(14,848),(15,848),(16,863);
/*!40000 ALTER TABLE `nstest_update_sites_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_updates`
--

DROP TABLE IF EXISTS `nstest_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_site_id` int(11) DEFAULT '0',
  `extension_id` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT '',
  `description` text NOT NULL,
  `element` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `folder` varchar(20) DEFAULT '',
  `client_id` tinyint(3) DEFAULT '0',
  `version` varchar(32) DEFAULT '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  `infourl` text NOT NULL,
  `extra_query` varchar(1000) DEFAULT '',
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='Available Updates';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_updates`
--

LOCK TABLES `nstest_updates` WRITE;
/*!40000 ALTER TABLE `nstest_updates` DISABLE KEYS */;
INSERT INTO `nstest_updates` VALUES (1,3,0,'Malay','','pkg_ms-MY','package','',0,'3.2.2.1','','http://update.joomla.org/language/details3/ms-MY_details.xml','',''),(2,3,0,'Romanian','','pkg_ro-RO','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/ro-RO_details.xml','',''),(3,3,0,'Flemish','','pkg_nl-BE','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/nl-BE_details.xml','',''),(4,3,0,'Chinese Traditional','','pkg_zh-TW','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/zh-TW_details.xml','',''),(5,3,0,'French','','pkg_fr-FR','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/fr-FR_details.xml','',''),(6,3,0,'German','','pkg_de-DE','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/de-DE_details.xml','',''),(7,3,0,'Greek','','pkg_el-GR','package','',0,'3.2.0.1','','http://update.joomla.org/language/details3/el-GR_details.xml','',''),(8,3,0,'Japanese','','pkg_ja-JP','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/ja-JP_details.xml','',''),(9,3,0,'Hebrew','','pkg_he-IL','package','',0,'3.1.1.1','','http://update.joomla.org/language/details3/he-IL_details.xml','',''),(10,3,0,'EnglishAU','','pkg_en-AU','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/en-AU_details.xml','',''),(11,3,0,'EnglishUS','','pkg_en-US','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/en-US_details.xml','',''),(12,3,0,'Hungarian','','pkg_hu-HU','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/hu-HU_details.xml','',''),(13,3,0,'Afrikaans','','pkg_af-ZA','package','',0,'3.2.0.1','','http://update.joomla.org/language/details3/af-ZA_details.xml','',''),(14,3,0,'Arabic Unitag','','pkg_ar-AA','package','',0,'3.3.0.2','','http://update.joomla.org/language/details3/ar-AA_details.xml','',''),(15,3,0,'Belarusian','','pkg_be-BY','package','',0,'3.2.1.1','','http://update.joomla.org/language/details3/be-BY_details.xml','',''),(16,3,0,'Bulgarian','','pkg_bg-BG','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/bg-BG_details.xml','',''),(17,3,0,'Catalan','','pkg_ca-ES','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/ca-ES_details.xml','',''),(18,3,0,'Chinese Simplified','','pkg_zh-CN','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/zh-CN_details.xml','',''),(19,3,0,'Croatian','','pkg_hr-HR','package','',0,'3.1.5.1','','http://update.joomla.org/language/details3/hr-HR_details.xml','',''),(20,3,0,'Czech','','pkg_cs-CZ','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/cs-CZ_details.xml','',''),(21,3,0,'Danish','','pkg_da-DK','package','',0,'3.3.0.2','','http://update.joomla.org/language/details3/da-DK_details.xml','',''),(22,3,0,'Dutch','','pkg_nl-NL','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/nl-NL_details.xml','',''),(23,3,0,'Estonian','','pkg_et-EE','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/et-EE_details.xml','',''),(24,3,0,'Italian','','pkg_it-IT','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/it-IT_details.xml','',''),(25,3,0,'Korean','','pkg_ko-KR','package','',0,'3.2.3.1','','http://update.joomla.org/language/details3/ko-KR_details.xml','',''),(26,3,0,'Latvian','','pkg_lv-LV','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/lv-LV_details.xml','',''),(27,3,0,'Macedonian','','pkg_mk-MK','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/mk-MK_details.xml','',''),(28,3,0,'Norwegian Bokmal','','pkg_nb-NO','package','',0,'3.2.2.1','','http://update.joomla.org/language/details3/nb-NO_details.xml','',''),(29,3,0,'Persian','','pkg_fa-IR','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/fa-IR_details.xml','',''),(30,3,0,'Polish','','pkg_pl-PL','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/pl-PL_details.xml','',''),(31,3,0,'Russian','','pkg_ru-RU','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/ru-RU_details.xml','',''),(32,3,0,'Slovak','','pkg_sk-SK','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/sk-SK_details.xml','',''),(33,3,0,'Swedish','','pkg_sv-SE','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/sv-SE_details.xml','',''),(34,3,0,'Syriac','','pkg_sy-IQ','package','',0,'3.2.3.1','','http://update.joomla.org/language/details3/sy-IQ_details.xml','',''),(35,3,0,'Tamil','','pkg_ta-IN','package','',0,'3.3.0.2','','http://update.joomla.org/language/details3/ta-IN_details.xml','',''),(36,3,0,'Thai','','pkg_th-TH','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/th-TH_details.xml','',''),(37,3,0,'Turkish','','pkg_tr-TR','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/tr-TR_details.xml','',''),(38,3,0,'Ukrainian','','pkg_uk-UA','package','',0,'3.2.0.6','','http://update.joomla.org/language/details3/uk-UA_details.xml','',''),(39,3,0,'Uyghur','','pkg_ug-CN','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/ug-CN_details.xml','',''),(40,3,0,'Albanian','','pkg_sq-AL','package','',0,'3.1.1.1','','http://update.joomla.org/language/details3/sq-AL_details.xml','',''),(41,3,0,'Portuguese Brazil','','pkg_pt-BR','package','',0,'3.0.2.1','','http://update.joomla.org/language/details3/pt-BR_details.xml','',''),(42,3,0,'Serbian Latin','','pkg_sr-YU','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/sr-YU_details.xml','',''),(43,3,0,'Bosnian','','pkg_bs-BA','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/bs-BA_details.xml','',''),(44,3,0,'Serbian Cyrillic','','pkg_sr-RS','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/sr-RS_details.xml','',''),(45,3,0,'Vietnamese','','pkg_vi-VN','package','',0,'3.2.1.1','','http://update.joomla.org/language/details3/vi-VN_details.xml','',''),(46,3,0,'Bahasa Indonesia','','pkg_id-ID','package','',0,'3.3.0.2','','http://update.joomla.org/language/details3/id-ID_details.xml','',''),(47,3,0,'Finnish','','pkg_fi-FI','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/fi-FI_details.xml','',''),(48,3,0,'Swahili','','pkg_sw-KE','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/sw-KE_details.xml','',''),(49,3,0,'Montenegrin','','pkg_srp-ME','package','',0,'3.2.1.1','','http://update.joomla.org/language/details3/srp-ME_details.xml','',''),(50,3,0,'EnglishCA','','pkg_en-CA','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/en-CA_details.xml','',''),(51,3,0,'FrenchCA','','pkg_fr-CA','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/fr-CA_details.xml','',''),(52,3,0,'Welsh','','pkg_cy-GB','package','',0,'3.3.0.1','','http://update.joomla.org/language/details3/cy-GB_details.xml','',''),(53,5,0,'RokGallery Extension','','com_rokgallery','component','',0,'2.29','0802','http://updates.rockettheme.com/joomla/286/21ffe006','',''),(54,5,0,'RokBooster Plugin','','rokbooster','plugin','system',0,'1.1.13','0802','http://updates.rockettheme.com/joomla/287/cb577720','',''),(55,5,0,'RokAjaxSearch Module','','mod_rokajaxsearch','module','',0,'2.0.3','0802','http://updates.rockettheme.com/joomla/290/1d5a0af1','',''),(56,5,0,'RokFeatureTable Module','','mod_rokfeaturetable','module','',0,'1.5','0802','http://updates.rockettheme.com/joomla/296/fb9111b3','',''),(57,5,729,'RokMiniEvents3 Module','','mod_rokminievents','module','',0,'3.0.0','0802','http://updates.rockettheme.com/joomla/297/1686051690','',''),(58,5,0,'RokQuickCart Extension','','com_rokquickcart','component','',0,'2.1.2','0802','http://updates.rockettheme.com/joomla/298/ddfa10eb','',''),(59,5,0,'RokCandy Extension','','com_rokcandy','component','',0,'2.0.1','0802','http://updates.rockettheme.com/joomla/302/2df8a4e2','',''),(60,5,0,'RokBridge Extension','','com_rokbridge','component','',0,'3.2','0802','http://updates.rockettheme.com/joomla/304/535b5e07','',''),(61,5,0,'RokBridge Extension','','com_rokbridge','component','',0,'3.2','0802','http://updates.rockettheme.com/joomla/304/535b5e07','',''),(62,5,0,'RokUpdater Plugin','','rokupdater','plugin','system',0,'1.0.8','0802','http://updates.rockettheme.com/joomla/305/ea19bc50','',''),(63,7,0,'Kunena Language Pack','Language Pack for Kunena Forum','pkg_kunena_languages','package','',0,'3.0.5','','http://update.kunena.org/3.0/pkg_kunena_languages.xml','',''),(64,7,0,'Kunena Latest Module','','mod_kunenalatest','module','',0,'3.0.1','','http://update.kunena.org/3.0/mod_kunenalatest.xml','',''),(65,7,0,'Kunena Login Module','','mod_kunenalogin','module','',0,'3.0.1','','http://update.kunena.org/3.0/mod_kunenalogin.xml','',''),(66,7,0,'Kunena Search Module','','mod_kunenasearch','module','',0,'3.0.1','','http://update.kunena.org/3.0/mod_kunenasearch.xml','',''),(67,7,0,'Kunena Statistics Module','','mod_kunenastats','module','',0,'3.0.1','','http://update.kunena.org/3.0/mod_kunenastats.xml','',''),(68,7,0,'Content - Kunena Discuss','','kunenadiscuss','plugin','content',0,'3.0.1','','http://update.kunena.org/3.0/plg_content_kunenadiscuss.xml','',''),(69,7,0,'Search - Kunena','','kunena','plugin','search',0,'3.0.1','','http://update.kunena.org/3.0/plg_search_kunena.xml','','');
/*!40000 ALTER TABLE `nstest_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_user_keys`
--

DROP TABLE IF EXISTS `nstest_user_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_user_keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `series` varchar(255) NOT NULL,
  `invalid` tinyint(4) NOT NULL,
  `time` varchar(200) NOT NULL,
  `uastring` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `series` (`series`),
  UNIQUE KEY `series_2` (`series`),
  UNIQUE KEY `series_3` (`series`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_user_keys`
--

LOCK TABLES `nstest_user_keys` WRITE;
/*!40000 ALTER TABLE `nstest_user_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_user_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_user_notes`
--

DROP TABLE IF EXISTS `nstest_user_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_user_notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_user_notes`
--

LOCK TABLES `nstest_user_notes` WRITE;
/*!40000 ALTER TABLE `nstest_user_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_user_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_user_profiles`
--

DROP TABLE IF EXISTS `nstest_user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_user_profiles`
--

LOCK TABLES `nstest_user_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_user_profiles` DISABLE KEYS */;
INSERT INTO `nstest_user_profiles` VALUES (869,'ats.signature',' ',1),(870,'ats.signature',' ',1);
/*!40000 ALTER TABLE `nstest_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_user_usergroup_map`
--

DROP TABLE IF EXISTS `nstest_user_usergroup_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_user_usergroup_map`
--

LOCK TABLES `nstest_user_usergroup_map` WRITE;
/*!40000 ALTER TABLE `nstest_user_usergroup_map` DISABLE KEYS */;
INSERT INTO `nstest_user_usergroup_map` VALUES (868,2),(868,8),(869,2),(869,8),(870,2),(870,8);
/*!40000 ALTER TABLE `nstest_user_usergroup_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_usergroups`
--

DROP TABLE IF EXISTS `nstest_usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_usergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_usergroups`
--

LOCK TABLES `nstest_usergroups` WRITE;
/*!40000 ALTER TABLE `nstest_usergroups` DISABLE KEYS */;
INSERT INTO `nstest_usergroups` VALUES (1,0,1,18,'Public'),(2,1,8,15,'Registered'),(3,2,9,14,'Author'),(4,3,10,13,'Editor'),(5,4,11,12,'Publisher'),(6,1,4,7,'Manager'),(7,6,5,6,'Administrator'),(8,1,16,17,'Super Users'),(9,1,2,3,'Guest');
/*!40000 ALTER TABLE `nstest_usergroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_users`
--

DROP TABLE IF EXISTS `nstest_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Require user to reset password on next login',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=871 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_users`
--

LOCK TABLES `nstest_users` WRITE;
/*!40000 ALTER TABLE `nstest_users` DISABLE KEYS */;
INSERT INTO `nstest_users` VALUES (868,'Marcelo Herrera - TMS Group','Chelo','marcebarcelona@gmail.com','$2y$10$qOWhrCGmWd1M4yXDd2DcduWVhFEj34NHR09eVL3iFgjkMLkj6EMkG',0,1,'2014-04-07 16:47:00','2014-06-04 11:51:07','0','{\"update_cache_list\":1,\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}','0000-00-00 00:00:00',0,'','',0),(869,'Diego Nieto','dnieto','diego.nieto@tmsgroup.com.ar','$2y$10$ywQqlHa3cLPjOLcyElh2sOna8tYJ8MN2ZsNCP.8tx5RrlgNSO77L.',0,1,'2014-05-30 18:20:51','0000-00-00 00:00:00','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}','0000-00-00 00:00:00',0,'','',0),(870,'Alejandro Weber','aweber','alejandro.weber@tmsgroup.com.ar','$2y$10$WkT9X2LLxYbxKodtjLt1qORfBQ5xVdppZAMAsYmiSP08PZn8ZVlie',0,1,'2014-05-30 18:22:03','0000-00-00 00:00:00','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}','0000-00-00 00:00:00',0,'','',0);
/*!40000 ALTER TABLE `nstest_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_viewlevels`
--

DROP TABLE IF EXISTS `nstest_viewlevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_viewlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_viewlevels`
--

LOCK TABLES `nstest_viewlevels` WRITE;
/*!40000 ALTER TABLE `nstest_viewlevels` DISABLE KEYS */;
INSERT INTO `nstest_viewlevels` VALUES (1,'Public',0,'[1]'),(2,'Registered',1,'[6,2,8]'),(3,'Special',2,'[6,3,8]'),(5,'Guest',0,'[9]'),(6,'Super Users',0,'[8]');
/*!40000 ALTER TABLE `nstest_viewlevels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_weblinks`
--

DROP TABLE IF EXISTS `nstest_weblinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_weblinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `images` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_weblinks`
--

LOCK TABLES `nstest_weblinks` WRITE;
/*!40000 ALTER TABLE `nstest_weblinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `nstest_weblinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nstest_wf_profiles`
--

DROP TABLE IF EXISTS `nstest_wf_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nstest_wf_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `users` text NOT NULL,
  `types` text NOT NULL,
  `components` text NOT NULL,
  `area` tinyint(3) NOT NULL,
  `device` varchar(255) NOT NULL,
  `rows` text NOT NULL,
  `plugins` text NOT NULL,
  `published` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `checked_out` tinyint(3) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nstest_wf_profiles`
--

LOCK TABLES `nstest_wf_profiles` WRITE;
/*!40000 ALTER TABLE `nstest_wf_profiles` DISABLE KEYS */;
INSERT INTO `nstest_wf_profiles` VALUES (1,'Default','Default Profile for all users','','3,4,5,6,8,7','',0,'desktop,tablet,phone','help,newdocument,undo,redo,spacer,bold,italic,underline,strikethrough,justifyfull,justifycenter,justifyleft,justifyright,spacer,blockquote,formatselect,styleselect,removeformat,cleanup;fontselect,fontsizeselect,forecolor,backcolor,spacer,clipboard,indent,outdent,lists,sub,sup,textcase,charmap,hr;directionality,fullscreen,preview,source,print,searchreplace,spacer,table;visualaid,visualchars,visualblocks,nonbreaking,style,xhtmlxtras,anchor,unlink,link,imgmanager,spellchecker,article','charmap,contextmenu,browser,inlinepopups,media,help,clipboard,searchreplace,directionality,fullscreen,preview,source,table,textcase,print,style,nonbreaking,visualchars,visualblocks,xhtmlxtras,imgmanager,anchor,link,spellchecker,article,lists',1,1,0,'0000-00-00 00:00:00',''),(2,'Front End','Sample Front-end Profile','','3,4,5','',1,'desktop,tablet,phone','help,newdocument,undo,redo,spacer,bold,italic,underline,strikethrough,justifyfull,justifycenter,justifyleft,justifyright,spacer,formatselect,styleselect;clipboard,searchreplace,indent,outdent,lists,cleanup,charmap,removeformat,hr,sub,sup,textcase,nonbreaking,visualchars,visualblocks;fullscreen,preview,print,visualaid,style,xhtmlxtras,anchor,unlink,link,imgmanager,spellchecker,article','charmap,contextmenu,inlinepopups,help,clipboard,searchreplace,fullscreen,preview,print,style,textcase,nonbreaking,visualchars,visualblocks,xhtmlxtras,imgmanager,anchor,link,spellchecker,article,lists',0,2,0,'0000-00-00 00:00:00',''),(3,'Blogger','Simple Blogging Profile','','3,4,5,6,8,7','',0,'desktop,tablet,phone','bold,italic,strikethrough,lists,blockquote,spacer,justifyleft,justifycenter,justifyright,spacer,link,unlink,imgmanager,article,spellchecker,fullscreen,kitchensink;formatselect,underline,justifyfull,forecolor,clipboard,removeformat,charmap,indent,outdent,undo,redo,help','link,imgmanager,article,spellchecker,fullscreen,kitchensink,clipboard,contextmenu,inlinepopups,lists',0,3,0,'0000-00-00 00:00:00','{\"editor\":{\"toggle\":\"0\"}}'),(4,'Mobile','Sample Mobile Profile','','3,4,5,6,8,7','',0,'tablet,phone','undo,redo,spacer,bold,italic,underline,formatselect,spacer,justifyleft,justifycenter,justifyfull,justifyright,spacer,fullscreen,kitchensink;styleselect,lists,spellchecker,article,link,unlink','fullscreen,kitchensink,spellchecker,article,link,inlinepopups,lists',0,4,0,'0000-00-00 00:00:00','{\"editor\":{\"toolbar_theme\":\"mobile\",\"resizing\":\"0\",\"resize_horizontal\":\"0\",\"resizing_use_cookie\":\"0\",\"toggle\":\"0\",\"links\":{\"popups\":{\"default\":\"\",\"jcemediabox\":{\"enable\":\"0\"},\"window\":{\"enable\":\"0\"}}}}}');
/*!40000 ALTER TABLE `nstest_wf_profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-04 13:00:07
