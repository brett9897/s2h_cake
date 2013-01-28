-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 06:06 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s2hcake`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `survey_instance_id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fK_answers_question` (`question_id`),
  KEY `fk_answers_client` (`client_id`),
  KEY `survey_instance_id` (`survey_instance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=203 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

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
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `feedback` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groupings`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groupings`
--

INSERT INTO `groupings` (`id`, `survey_id`, `label`, `ordering`, `is_used`, `created`, `modified`) VALUES
(1, 1, 'Personal Information', 1, 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(2, 1, 'Test New Grouping', 2, 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_options_questions` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `label`, `created`, `modified`) VALUES
(1, 3, 'option 1', '2013-01-01 05:00:00', '2013-01-01 05:00:00'),
(2, 3, 'option 2', '2013-01-21 23:11:08', '2013-01-01 05:00:00'),
(3, 4, 'radio 1', '2013-01-26 19:20:00', '0000-00-00 00:00:00'),
(4, 4, 'radio 2', '2013-01-26 19:20:08', '0000-00-00 00:00:00'),
(5, 5, 'checkbox 1', '2013-01-26 21:28:02', '0000-00-00 00:00:00'),
(6, 5, 'checkbox 2', '2013-01-26 21:28:12', '0000-00-00 00:00:00'),
(7, 7, 'option 1', '2013-01-01 05:00:00', '2013-01-01 05:00:00'),
(8, 7, 'option 2', '2013-01-01 05:00:00', '2013-01-01 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `isDeleted`, `created`, `modified`) VALUES
(1, 'samwiseCorp', 0, '2013-01-04 00:00:00', '2013-01-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

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
  KEY `grouping_id` (`grouping_id`),
  KEY `survey_id` (`survey_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `survey_id`, `grouping_id`, `internal_name`, `label`, `type_id`, `ordering`, `is_used`, `is_required`, `created`, `modified`, `validation_1`, `validation_2`, `validation_3`, `validation_4`) VALUES
(1, 1, 1, 'test', 'test', 1, 1, 1, 0, '2013-01-01 00:00:00', '2013-01-21 21:00:03', NULL, NULL, NULL, NULL),
(2, 1, 1, 'test2', 'test2', 1, 2, 1, 0, '2013-01-01 00:00:00', '2013-01-01 05:00:00', NULL, NULL, NULL, NULL),
(3, 1, 2, 'testDropdown', 'Test Drop Down', 2, 3, 1, 0, '2013-01-01 00:00:00', '2013-01-01 05:00:00', NULL, NULL, NULL, NULL),
(4, 1, 2, 'testRadio', 'Test Radio', 3, 4, 1, 0, '2013-01-01 00:00:00', '2013-01-26 19:19:47', NULL, NULL, NULL, NULL),
(5, 1, 2, 'testCheckbox', 'Test Checkbox', 4, 5, 1, 0, '2013-01-01 00:00:00', '2013-01-26 21:27:29', NULL, NULL, NULL, NULL),
(6, 1, 2, 'textWithRefused', 'Text With Refused', 5, 6, 1, 0, '2013-01-01 00:00:00', '2013-01-01 05:00:00', NULL, NULL, NULL, NULL),
(7, 1, 2, 'selectWithOther', 'Select With Other', 6, 7, 1, 0, '2013-01-01 00:00:00', '2013-01-01 05:00:00', NULL, NULL, NULL, NULL),
(8, 1, 2, 'textWithRefused2', 'Text With Refused', 5, 8, 1, 0, '2013-01-01 00:00:00', '2013-01-27 20:26:39', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `organization_id`, `label`, `isActive`, `isDeleted`, `created`, `modified`) VALUES
(1, 1, 'newSurvey', 1, 0, '2013-01-01 00:00:00', '2013-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `survey_instances`
--

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
  UNIQUE KEY `client_id` (`client_id`),
  KEY `survey_id` (`survey_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `label`, `created`, `modified`) VALUES
(1, 'text', '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(2, 'select', '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(3, 'radio', '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(4, 'checkbox', '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(5, 'textWithRefused', '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(6, 'selectWithOther', '2013-01-01 00:00:00', '2013-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `organization_id`, `type`, `isDeleted`, `created`, `modified`) VALUES
(1, 'samwise', '9202ec3a18879d7cebb45e66ffd923cf854df31c', 'samwise', 'gamgee', 1, 'volunteer', 0, '2013-01-02 00:00:00', '2013-01-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `validations`
--

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
  ADD CONSTRAINT `answers_ibfk_8` FOREIGN KEY (`survey_instance_id`) REFERENCES `survey_instances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_6` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_7` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `groupings`
--
ALTER TABLE `groupings`
  ADD CONSTRAINT `groupings_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_6` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_ibfk_4` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_ibfk_5` FOREIGN KEY (`grouping_id`) REFERENCES `groupings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_instances`
--
ALTER TABLE `survey_instances`
  ADD CONSTRAINT `survey_instances_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_instances_ibfk_4` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_instances_ibfk_5` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
