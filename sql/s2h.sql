-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2013 at 03:54 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

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

DROP TABLE IF EXISTS `answers`;
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
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `groupings`
--

INSERT INTO `groupings` (`id`, `survey_id`, `label`, `ordering`, `is_used`, `created`, `modified`) VALUES
(1, 1, 'Personal Information', 1, 1, '2013-01-01 00:00:00', '2013-01-31 19:08:00'),
(2, 1, 'Test New Grouping', 2, 1, '2013-01-01 00:00:00', '2013-01-31 19:08:00'),
(3, 1, 'Housing Information', 3, 1, '2013-01-31 15:15:00', '2013-01-31 19:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `options`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `label`, `created`, `modified`) VALUES
(3, 4, 'radio 1', '2013-01-26 19:20:00', '0000-00-00 00:00:00'),
(4, 4, 'radio 2', '2013-01-26 19:20:08', '0000-00-00 00:00:00'),
(7, 7, 'option 1', '2013-01-01 05:00:00', '2013-01-01 05:00:00'),
(8, 7, 'option 2', '2013-01-01 05:00:00', '2013-01-01 05:00:00'),
(13, 3, 'option 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 3, 'option 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 5, 'checkbox 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 5, 'checkbox 2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 9, 'yes', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 9, 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 9, ' maybe', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 9, 'refused', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 10, 'yes', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 10, 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 10, 'maybe', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 10, 'refused', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 11, 'yes', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 11, 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 11, 'maybe', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 11, 'refused', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
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
  KEY `grouping_id` (`grouping_id`),
  KEY `survey_id` (`survey_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `survey_id`, `grouping_id`, `internal_name`, `label`, `type_id`, `ordering`, `is_used`, `is_required`, `created`, `modified`, `validation_1`, `validation_2`, `validation_3`, `validation_4`) VALUES
(1, 1, 1, 'test', 'test', 1, 1, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:02', NULL, NULL, NULL, NULL),
(2, 1, 1, 'test2', 'test2', 1, 2, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:02', NULL, NULL, NULL, NULL),
(3, 1, 2, 'testDropdown', 'Test Drop Down', 2, 1, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(4, 1, 2, 'testRadio', 'Test Radio', 3, 2, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(5, 1, 2, 'testCheckbox', 'Test Checkbox', 4, 3, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(6, 1, 2, 'textWithRefused', 'Text With Refused', 5, 4, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(7, 1, 2, 'selectWithOther', 'Select With Other', 6, 6, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(8, 1, 2, 'textWithRefused2', 'Text With Refused', 5, 5, 1, 0, '2013-01-01 00:00:00', '2013-02-01 08:08:14', NULL, NULL, NULL, NULL),
(9, 1, 3, 'A Question', 'Is this a question?', 2, 1, 1, 1, '2013-02-01 03:18:55', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(10, 1, 3, 'another question', 'Is this another question?', 3, 2, 1, 1, '2013-02-01 03:20:45', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(11, 1, 3, 'yet another question', 'Is this a third question?', 2, 3, 1, 1, '2013-02-01 03:21:26', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL),
(12, 1, 3, 'checking redirect', 'I am just checking the redirect', 5, 4, 1, 1, '2013-02-01 03:22:14', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
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
  UNIQUE KEY `client_id` (`client_id`),
  KEY `survey_id` (`survey_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
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
  KEY `org_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `organization_id`, `type`, `isDeleted`, `created`, `modified`) VALUES
(1, 'samwise', '9202ec3a18879d7cebb45e66ffd923cf854df31c', 'samwise', 'gamgee', 1, 'volunteer', 0, '2013-01-02 00:00:00', '2013-01-02 00:00:00'),
(4, 'superAdmin', '6e6dbd12bba6127f4d44f839e44a71fa779ee945', 'Super', 'Admin', 1, 'superAdmin', 0, '2013-01-30 00:00:00', '2013-01-30 00:00:00'),
(5, 'username', '6e6dbd12bba6127f4d44f839e44a71fa779ee945', 'User', 'Name', 1, 'user', 0, '2013-01-30 00:00:00', '2013-01-30 00:00:00'),
(6, 'admin', '6e6dbd12bba6127f4d44f839e44a71fa779ee945', 'Admin', 'User', 1, 'admin', 0, '2013-02-01 02:49:47', '2013-02-01 02:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `validations`
--

DROP TABLE IF EXISTS `validations`;
CREATE TABLE IF NOT EXISTS `validations` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `regex` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `validations`
--

INSERT INTO `validations` (`id`, `label`, `regex`, `created`, `modified`) VALUES
(1, 'alpha numeric', '^[a-zA-Z0-9]*$', '2013-01-30 00:00:00', '2013-01-30 00:00:00'),
(2, 'alpha numeric with spaces', '^[a-zA-Z0-9\\ ]*$', '2013-01-30 00:00:00', '2013-01-30 00:00:00');

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
