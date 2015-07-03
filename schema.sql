-- --------------------------------------------------------
-- Host:                         naijalol.com
-- Server version:               5.1.73 - Source distribution
-- Server OS:                    redhat-linux-gnu
-- HeidiSQL Version:             9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for hawkinthesky
CREATE DATABASE IF NOT EXISTS `hawkinthesky` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `hawkinthesky`;


-- Dumping structure for table hawkinthesky.websites
CREATE TABLE IF NOT EXISTS `websites` (
  `ga_property_id` int(11) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(250) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `ga_account_id` int(11) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`ga_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
