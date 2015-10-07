-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.26-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for site
CREATE DATABASE IF NOT EXISTS `site` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `site`;


-- Dumping structure for table site.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT '0',
  `rank` int(11) DEFAULT '0',
  `g_points` int(11) DEFAULT '0',
  `c_points` int(11) DEFAULT '0',
  `blizz_points` int(11) DEFAULT '0',
  `pic` varchar(1000) DEFAULT '../profile/profile.jpg',
  `identifier` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`identifier`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;


-- Dumping structure for table site.bugtracker
CREATE TABLE IF NOT EXISTS `bugtracker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL DEFAULT '0',
  `type` varchar(1000) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '0',
  `description` varchar(1000) NOT NULL DEFAULT '0',
  `date` varchar(50) NOT NULL DEFAULT '0',
  `rep_player_name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table site.bugtracker: ~0 rows (approximately)
DELETE FROM `bugtracker`;
/*!40000 ALTER TABLE `bugtracker` DISABLE KEYS */;
/*!40000 ALTER TABLE `bugtracker` ENABLE KEYS */;


-- Dumping structure for table site.bugtracker_type
CREATE TABLE IF NOT EXISTS `bugtracker_type` (
  `type` varchar(50) DEFAULT NULL,
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table site.bugtracker_type: ~5 rows (approximately)
DELETE FROM `bugtracker_type`;
/*!40000 ALTER TABLE `bugtracker_type` DISABLE KEYS */;
INSERT INTO `bugtracker_type` (`type`, `id`) VALUES
	('quest', 1),
	('npc', 2),
	('boss', 3),
	('item', 4),
	('spell', 5);
/*!40000 ALTER TABLE `bugtracker_type` ENABLE KEYS */;


-- Dumping structure for table site.forums
CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `autor` varchar(50) NOT NULL DEFAULT '0',
  `date` varchar(50) NOT NULL DEFAULT '0',
  `image` varchar(200) DEFAULT NULL,
  `pinned` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table site.forums: ~1 rows (approximately)
DELETE FROM `forums`;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
INSERT INTO `forums` (`id`, `title`, `autor`, `date`, `image`, `pinned`) VALUES
	(1, 'Community', 'brannik', '08.10.2015', 'forum_default', 1);
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;


-- Dumping structure for table site.forum_comments
CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT '0',
  `autor` varchar(50) NOT NULL DEFAULT '0',
  `date` varchar(50) NOT NULL DEFAULT '0',
  `comment` varchar(1000) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table site.forum_comments: ~1 rows (approximately)
DELETE FROM `forum_comments`;
/*!40000 ALTER TABLE `forum_comments` DISABLE KEYS */;
INSERT INTO `forum_comments` (`id`, `forum_id`, `autor`, `date`, `comment`) VALUES
	(1, 1, 'brannik', '08.10.2015', 'Welcome to frostmourne-wow');
/*!40000 ALTER TABLE `forum_comments` ENABLE KEYS */;


-- Dumping structure for table site.galery
CREATE TABLE IF NOT EXISTS `galery` (
  `id` int(11) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table site.galery: 9 rows
DELETE FROM `galery`;
/*!40000 ALTER TABLE `galery` DISABLE KEYS */;
INSERT INTO `galery` (`id`, `link`) VALUES
	(1, 'images/1.jpg'),
	(2, 'images/2.jpg'),
	(3, 'images/3.jpg'),
	(4, 'images/4.png'),
	(5, 'images/5.jpg'),
	(6, 'images/6.jpg'),
	(7, 'images/7.jpg'),
	(8, 'images/8.jpg'),
	(9, 'http://i60.tinypic.com/16as0ht.jpg');
/*!40000 ALTER TABLE `galery` ENABLE KEYS */;


-- Dumping structure for table site.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) DEFAULT NULL,
  `entry` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `cost_type` int(11) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table site.items: 4 rows
DELETE FROM `items`;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `entry`, `cost`, `cost_type`, `Name`) VALUES
	(1, 49623, 150, 1, 'Shadowmourne'),
	(2, 46017, 130, 1, 'Val\'anyr, Hammer of Ancient Kings'),
	(3, 46051, 55, 2, 'Meteorite crystal'),
	(4, 51296, 23, 1, 'Druid Head');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;


-- Dumping structure for table site.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) DEFAULT NULL,
  `text` varchar(50) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `acces` int(11) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table site.menu: 12 rows
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `text`, `link`, `acces`, `class`) VALUES
	(1, 'home', '../main.php', 0, 'home'),
	(2, 'galery', '../galery/index.php', 0, 'galery'),
	(3, 'menage news', '../post_news/index.php', 2, 'admin'),
	(5, 'menage galery', '../galery/menage.php', 3, 'admin'),
	(12, 'bugtracker', '../bugtracker/index.php', 0, 'vote'),
	(8, 'acp', '../admin/index.php', 3, 'admin'),
	(9, 'Shop', '../shop/index.php', 0, 'shop'),
	(10, 'support', '../support/index.php', 0, 'support'),
	(11, 'ingame staff', '../staff/index.php', 0, 'staff'),
	(13, 'donate', '../donate/index.php', 0, 'donate '),
	(4, 'tickets', '../admin/tickets.php', 2, 'admin'),
	(14, 'armory', '../armory/index.php', 0, 'armory');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Dumping structure for table site.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` int(11) DEFAULT '0',
  `reciever` int(11) DEFAULT '0',
  `title` varchar(50) DEFAULT 'empty',
  `text` varchar(1700) DEFAULT 'empty',
  `isreaden` int(11) DEFAULT '0',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Dumping data for table site.messages: 0 rows
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;


-- Dumping structure for table site.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `text` varchar(1500) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `autor` varchar(50) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping structure for table site.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) DEFAULT NULL,
  `autor` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `text` varchar(2500) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table site.tickets: 0 rows
DELETE FROM `tickets`;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
