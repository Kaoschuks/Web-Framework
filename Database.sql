-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2016 at 09:30 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `name`, `uname`, `email`, `image`) VALUES
(3, 'íˆpWçAÏ ‚ÿ¬ÝLS‡Ñ´ŽÖr}*O;÷ˆ=D®4¡éÅèŽ†žæÃ£‡Åçcš³ÆÞÉôMùí‘¯', 'Kels', 'ˆuxœ;‰ç‘í+Zu„m¢ûùå°ÀÛöE·‘ïNŒjY$W…T7ºš{›$—‘iæ¯®ÞY‡ŽïuÖ@ÇÙm', '@"QÍŽyØJ#P\\Ê¼{}v\r$ØàÕ›üšù-Œ^ÊŸ)‘aQUkþ«cÂx\Z©™"½™®iW\Z…');

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `uname`, `passwd`, `access`) VALUES
(1, 'Kels', 'fb7efa7aa93911409a63ae36cab6beb586b0064da8a0d6385849f6860316caf4b3ca903f584a4e1a205fb58d1462f816c047f5b8e52c5c31ec920e5c5914a55a', '#r!(Â|ALVâ$`ßy«sôÔÄÅF1›õ`›³î?;FˆFˆO|íbÐM®µ%;ÕÁ''Ì');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `post` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `posted_by` varchar(255) NOT NULL,
  `posted_on` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `post`, `comment`, `posted_by`, `posted_on`) VALUES
(1, 'Kaos', '•6•Ü™ˆb\r=\\\\3™àbÙ°þ¬Æ>¡OÜÛwqøÝw!4Õ"ªéø•™vt&6Ñ‹Á©<pŒÓs†w½Ù„Ñ*­Gf´', 'Kels Chuks', '³çJ±‰_Æö¥Èƒ¢\0FE,÷90*ÎÞÙ=ßo»>Ãìøè0h3Þ²±s˜óŠÿAˆ5ÿ†a>±¬ücÐäï');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `author` varchar(255) CHARACTER SET utf8 NOT NULL,
  `posted_on` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `author`, `posted_on`, `image`, `category`) VALUES
(1, 'Kaos', '8á”Èüì³c,+ž˜y[üŽ™úQ²ÑÿïÇ,ÉÑëðvþ*÷’ª ×yùƒuf~¾Ôä«€2%¼	×^§Ý-†_Kê¯»z', 'Kelss_Chuks', 'þ<šZ‹U%SuBŽ‹Áü)÷lúÜö›Ð\nÍ^HaOâÑÀÀ2`§SÁ8~¤…0j‡}”ÚD9Öõ', '‡N°Øx¬L˜àj¼¨nÌù\n‚+Ú¿ªû¹jÖ®›JX@ûCK^%4óì½[µšŒ/Ë¸E/1Wv²¶$¹', '0Cšà±Ÿ\Züjfzº‚£ÐXÍ/i%Ýj¬Coì¬N|ÆŠMÆ^m»ÐÈ%MË)«:ýïÈ·');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
