CREATE TABLE `artists` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default 0,
  `name` varchar(60) collate utf8_unicode_ci NOT NULL,
  `reference` varchar(15) character set ascii NOT NULL,
  `keywordList` varchar(255) character set ascii default NULL,
  `introduction` text character set armscii8 collate armscii8_bin,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Reference` (`reference`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `relatedartists` (
  `artist` int(11) unsigned NOT NULL,
  `relatedTo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`artist`,`relatedTo`)
) engine=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `albums` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `artist` int(11) unsigned NOT NULL,
  `available` tinyint(1) NOT NULL default 0,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `reference` varchar(15) character set armscii8 NOT NULL,
  `year` int(4) unsigned NOT NULL,
  `highPoints` varchar(255) collate utf8_unicode_ci default NULL,
  `rating` int(2) unsigned default NULL,
  `commentPhrase` varchar(255) collate utf8_unicode_ci default NULL,
  `review` text character set armscii8 collate armscii8_bin,
  PRIMARY KEY  (`id`),
  KEY `reference` (`reference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `discs` (
  `album` int(11) unsigned NOT NULL,
  `disc` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(64) collate utf8_unicode_ci default NULL,
  PRIMARY KEY (`album`, `disc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `tracks` (
  `album` int(11) unsigned NOT NULL,
  `disc` int(11) unsigned NOT NULL,
  `number` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(128) NOT NULL collate utf8_unicode_ci,
  `grade` tinyint(1) NOT NULL,
  PRIMARY KEY (`album`, `disc`, `number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `artist` int(11) unsigned NOT NULL,
  `album` int(11) unsigned NULL default NULL,
  `commentatorName` varchar(90) collate utf8_unicode_ci NOT NULL,
  `commentatorEMail` varchar(90) character set ascii default NULL,
  `commentatorIP` varchar(15) character set ascii default NULL,
  `commentDate` date NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `publiciseEMail` tinyint(1) NOT NULL,
  `reply` text collate armscii8_bin,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ratings` (
  `id` int(2) unsigned NOT NULL auto_increment,
  `title` varchar(40) collate utf8_unicode_ci NOT NULL,
  `description` varchar(512) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `siteupdates` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `title` varchar(80) collate utf8_unicode_ci NOT NULL,
  `text` text collate utf8_unicode_ci NOT NULL,
  `link` varchar(120) character set ascii NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `updateditems` (
  `siteUpdate` int(11) unsigned NOT NULL,
  `artist` int(11) unsigned NOT NULL,
  `album` int(11) unsigned NULL default NULL,
  PRIMARY KEY (`siteUpdate`, `artist`, `album`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;