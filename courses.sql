-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2016 at 07:02 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zend`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `course_desc` varchar(1000) NOT NULL,
  `duration` float NOT NULL,
  `student_no` int(11) NOT NULL,
  `language` varchar(30) NOT NULL,
  `skill_level` varchar(70) NOT NULL,
  `instructor` varchar(70) NOT NULL,
  `image` varchar(300) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `category_id`, `course_desc`, `duration`, `student_no`, `language`, `skill_level`, `instructor`, `image`, `type`) VALUES
(16, 'Marketing', 9, 'Principles of Marketing', 12, 0, 'English', 'Entry', 'AhmedMohamed', '/var/www/html/zendProject/zend_slms/upload/pic1.jpg', 'Free'),
(18, 'PHP', 16, 'php zend framework', 12, 0, 'English', 'Entry', 'Ahmed', '/var/www/html/zendProject/zend_slms/upload/pic1.jpg', 'Free');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
