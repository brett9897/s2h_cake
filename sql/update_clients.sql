-- Host: localhost
-- Generation Time: Mar 01, 2013 at 11:10 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s2h_cake`
--

-- --------------------------------------------------------
ALTER TABLE `clients`
	ADD COLUMN `middle_name` varchar(50) NOT NULL
	AFTER `first_name`;

ALTER TABLE `clients`
	ADD COLUMN `nickname` varchar(50) NOT NULL
	AFTER `dob`;

ALTER TABLE `clients`
	ADD COLUMN `phone_number` varchar(15) NOT NULL
	AFTER `nickname`;
