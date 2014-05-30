DROP TABLE IF EXISTS `#__articlegenerator`;
CREATE TABLE `#__articlegenerator` (
  `id` int(11) NOT NULL auto_increment,
  `title` VARCHAR (255) collate utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `feed_url` text collate utf8_unicode_ci NOT NULL,
  `extractfulltext` tinyint(1) NOT NULL default '0',
  `created` timestamp NOT NULL,
  `keywords` text collate utf8_unicode_ci NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `catid` int(11) NOT NULL,
  `validfor` int(11) unsigned NOT NULL default '0',
  `insertadvert` TINYINT NOT NULL DEFAULT '1',
  `advert` text collate utf8_unicode_ci NOT NULL,
  `autopublish` tinyint(1) unsigned NOT NULL default '1',
  `frontpage` tinyint(1) unsigned NOT NULL default '1',
  `delay` TINYINT NOT NULL DEFAULT '10',
  `fulltext` int(11) unsigned NOT NULL default '1',
  `feedlinksintro` int(11) unsigned NOT NULL default '0',
  `feedlinksfull` int(11) unsigned NOT NULL default '0',
  `feedimageintro` int(11) unsigned NOT NULL default '0',
  `feedimagefull` int(11) unsigned NOT NULL default '0',
  `posterid` INT NOT NULL,
  `origdate` TINYINT ( 1 ) NOT NULL DEFAULT '0',
  `jceboxlinks` TINYINT ( 1 ) NOT NULL DEFAULT '1',
  `jceparams` VARCHAR(400) collate utf8_unicode_ci NOT NULL,
  `negkey` text collate utf8_unicode_ci NOT NULL,
  `username` VARCHAR( 50 ) collate utf8_unicode_ci NOT NULL,
  `password` VARCHAR( 50 ) collate utf8_unicode_ci NOT NULL,
  `createddate` TINYINT(1) NOT NULL DEFAULT '0',
  `cutat` VARCHAR (50) collate utf8_unicode_ci NOT NULL,
  `showintro` tinyint(1) NOT NULL DEFAULT '1',
  `switchintrofull` tinyint(1) NOT NULL DEFAULT '0',
  `origauthor` tinyint(1) NOT NULL DEFAULT '0',
  `includelink` TINYINT NOT NULL DEFAULT '1',
  `readfullarticle` text collate utf8_unicode_ci NOT NULL,
  `dupavoid` VARCHAR (3) collate utf8_unicode_ci NOT NULL DEFAULT '3',
  `useiconv` TINYINT NOT NULL DEFAULT '1',
  `acgroup` INT NOT NULL DEFAULT '1',
  `ordering` tinyint(3) NOT NULL,  
  `cutatcharacter` int(11) NOT NULL,
  `ignoreitem` int(11) NOT NULL DEFAULT '0',
  `minimum_count` int(11) NOT NULL,  
  `allowabletags` VARCHAR(50) NOT NULL DEFAULT 'all',
  `articleintrostyle` VARCHAR(500) NOT NULL DEFAULT '[intro]',
  `articlefullstyle` VARCHAR(500) NOT NULL DEFAULT '[full]',  
  `language` VARCHAR(50) NOT NULL DEFAULT '*',
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM COMMENT='Feeds and data for ArticleGenerator' AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `#__articlegenerator` (title, feed_url, catid, ordering) VALUES 
('CNN', 'http://rss.cnn.com/rss/cnn_topstories.rss', 9, 1),
('Fulltext', 'http://feeds.feedburner.com/DroidApps', 9, 2),
('Russian', 'http://ria.ru/export/rss2/incidents/index.xml', 9, 3),
('CZECH', 'http://www.ireport.cz/rssfeed.php', 9, 4);





DROP TABLE IF EXISTS `#__articlegenerator_config`;
CREATE TABLE `#__articlegenerator_config` (
  `id` int(11) NOT NULL auto_increment,
  `getwith` TINYINT NOT NULL DEFAULT '1',
  `credit` TINYINT NOT NULL DEFAULT '1',
  `countkeys` TINYINT NOT NULL DEFAULT '20',
  `minLengthkeys` TINYINT NOT NULL DEFAULT '3',
  `usetitle` int(11) unsigned NOT NULL default '0',  
  `blackListkeys` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM COMMENT = 'ArticleGenerator options' AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `#__articlegenerator_config` (getwith, credit, countkeys, minLengthkeys, blackListkeys) VALUES 
(1 , 1, 20, 3,'ab, aber');
	







DELETE FROM `#__modules` WHERE title='Advertfield for ArticleGenerator' AND position='user99';
INSERT INTO `#__modules` (title, content, ordering, position, checked_out, checked_out_time, published, module, access, showtitle, params, client_id, language) VALUES
('Advertfield for ArticleGenerator', '', 1, 'user99', 0, '0000-00-00 00:00:00', 1, 'mod_custom', 1, 0, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*');

