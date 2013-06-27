-- 
-- Table structure for table `shortenedurls`
-- 

CREATE TABLE `shortenedurls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `long_url` varchar(255) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `creator` char(15) NOT NULL,
  `url` varchar(255) NOT NULL,
  `referrals` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `long` (`long_url`),
  UNIQUE KEY `url` (`url`),
  KEY `referrals` (`referrals`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Change starting URL length (optional)
--

-- If you want to start your URLs at a certain length
-- update the auto increment to x^(y-1) where x is the
-- number of allowed chars and y is the desired 
-- starting length of your URLs.

-- 3 character URLS (31^2 = 961)
ALTER TABLE `shortenedurls` AUTO_INCREMENT = 961;
