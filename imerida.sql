-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2014 at 10:02 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `imerida`
--

-- --------------------------------------------------------

--
-- Table structure for table `symmetexontes`
--

CREATE TABLE IF NOT EXISTS `symmetexontes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `onoma` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `epitheto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sxoleio` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tel_sxoleioy` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `foritos_yparxei` tinyint(1) NOT NULL,
  `ekpaideytikos` tinyint(1) NOT NULL DEFAULT '1',
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `epilogi` tinyint(1) DEFAULT '0',
  `enimerothike` tinyint(1) NOT NULL DEFAULT '0',
  `sentdate` datetime NOT NULL,
  `epibebaiosi` tinyint(1) NOT NULL DEFAULT '1',
  `parousia` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `symmetexontes`
--

INSERT INTO `symmetexontes` (`id`, `onoma`, `epitheto`, `sxoleio`, `tel_sxoleioy`, `mobile`, `email`, `foritos_yparxei`, `ekpaideytikos`, `regtime`, `epilogi`, `enimerothike`, `sentdate`, `epibebaiosi`, `parousia`) VALUES
(1, 'TEST', 'TEST', 'EPAL RODOPOLIS', '2327022020', '6977556655', 'test@test.gr', 1, 1, '2014-03-14 21:41:45', 1, 0, '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=greek AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `id`, `role`) VALUES
('user', 'user', 1, 'user'),
('admin', 'admin', 2, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
