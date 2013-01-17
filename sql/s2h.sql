-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2013 at 06:39 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s2h_third_version`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fK_answers_question` (`question_id`),
  KEY `fk_answers_client` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` int(10) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `ssn` varchar(9) NOT NULL,
  `dob` date NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_client_organization` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groupings`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `groupings`;
CREATE TABLE IF NOT EXISTS `groupings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL,
  `is_used` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_options_questions` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(10) unsigned NOT NULL,
  `grouping_id` int(10) unsigned NOT NULL,
  `internal_name` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type_id` smallint(5) unsigned NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL,
  `is_used` tinyint(1) NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validation_1` varchar(100) DEFAULT NULL,
  `validation_2` varchar(100) DEFAULT NULL,
  `validation_3` varchar(100) DEFAULT NULL,
  `validation_4` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_id` (`type_id`),
  KEY `grouping_id` (`grouping_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `survey_instances`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `survey_instances`;
CREATE TABLE IF NOT EXISTS `survey_instances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(10) unsigned NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `vi_score` int(10) unsigned NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `survey_id` (`survey_id`),
  UNIQUE KEY `client_id` (`client_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(127) NOT NULL,
  `password` varchar(127) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `organization_id` int(10) unsigned NOT NULL,
  `type` enum('volunteer','user','admin','superAdmin') NOT NULL DEFAULT 'volunteer',
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `org_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `validations`
--
-- Creation: Jan 17, 2013 at 11:28 PM
--

DROP TABLE IF EXISTS `validations`;
CREATE TABLE IF NOT EXISTS `validations` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `regex` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `groupings`
--
ALTER TABLE `groupings`
  ADD CONSTRAINT `groupings_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`);

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`grouping_id`) REFERENCES `groupings` (`id`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Constraints for table `survey_instances`
--
ALTER TABLE `survey_instances`
  ADD CONSTRAINT `survey_instances_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  ADD CONSTRAINT `survey_instances_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `survey_instances_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
