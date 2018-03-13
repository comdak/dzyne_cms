-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2013 at 04:08 PM
-- Server version: 5.0.96-community
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dzyne_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL auto_increment,
  `pagetitle` varchar(255) NOT NULL,
  `htmlcontent` text NOT NULL,
  `publishdate` varchar(255) default NULL,
  `publish` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Table structure for table `changelog`
--

CREATE TABLE IF NOT EXISTS `changelog` (
  `id` int(11) NOT NULL auto_increment,
  `uname` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `activitytime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;


--
-- Table structure for table `contactform`
--

CREATE TABLE IF NOT EXISTS `contactform` (
  `id` int(11) NOT NULL auto_increment,
  `companyname` varchar(255) default NULL,
  `contactname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) default NULL,
  `message` text NOT NULL,
  `viewed` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Table structure for table `nav`
--

CREATE TABLE IF NOT EXISTS `nav` (
  `id` int(11) NOT NULL auto_increment,
  `navtitle` varchar(255) NOT NULL,
  `imgfile` varchar(255) default NULL,
  `imgfilesel` varchar(255) default NULL,
  `pageid` int(11) NOT NULL,
  `parent` int(11) default '0',
  `publish` int(11) NOT NULL default '0',
  `sorting` int(11) NOT NULL,
  `cssid` varchar(255) default NULL,
  `extlink` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `nav`
--

INSERT INTO `nav` (`id`, `navtitle`, `imgfile`, `imgfilesel`, `pageid`, `parent`, `publish`, `sorting`, `cssid`, `extlink`) VALUES
(122, 'Home', 'images/navHome.jpg', 'images/navHomeSel.jpg', 1, 0, 1, 0, 'navHome', ''),
(114, 'Solutions', 'images/navSolutions.jpg', 'images/navSolutionsSel.jpg', 100, 0, 1, 1, 'navSolutions', ''),
(115, 'Clients', 'images/navClients.jpg', 'images/navClientsSel.jpg', 101, 0, 1, 3, 'navClients', ''),
(118, 'Contact', 'images/navContact.jpg', 'images/navContactSel.jpg', 102, 0, 1, 6, 'navContact', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL auto_increment,
  `pagetitle` varchar(255) NOT NULL,
  `inc` varchar(255) default NULL,
  `htmlcontent` text NOT NULL,
  `publish` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;


--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL auto_increment,
  `level` int(11) NOT NULL,
  `stop_page` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `level`, `stop_page`) VALUES
(20, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `perm_levels`
--

CREATE TABLE IF NOT EXISTS `perm_levels` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `level` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `perm_levels`
--

INSERT INTO `perm_levels` (`id`, `type`, `level`) VALUES
(1, 'Administrator', '1'),
(2, 'Site Owner', '2'),
(3, 'Staff', '3');

-- --------------------------------------------------------

--
-- Table structure for table `portalnav`
--

CREATE TABLE IF NOT EXISTS `portalnav` (
  `id` int(11) NOT NULL auto_increment,
  `navtitle` varchar(255) NOT NULL,
  `imgfile` varchar(255) default NULL,
  `imgfilesel` varchar(255) default NULL,
  `pageid` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `cssid` varchar(255) default NULL,
  `publish` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `portalnav`
--

INSERT INTO `portalnav` (`id`, `navtitle`, `imgfile`, `imgfilesel`, `pageid`, `parent`, `cssid`, `publish`, `sorting`) VALUES
(28, 'Dashboard', 'images/navDashboard.jpg', 'images/navDashboardSel.jpg', 1, 0, 'navDashboard', 1, 1),
(29, 'Pages', 'images/navPages.jpg', 'images/navPagesSel.jpg', 24, 0, 'navPages', 1, 2),
(30, 'Navigation', 'images/navNavigation.jpg', 'images/navNavigationSel.jpg', 23, 0, 'navNavigation', 1, 3),
(31, 'Media', 'images/navMedia.jpg', 'images/navMediaSel.jpg', 4, 0, 'navMedia', 1, 4),
(32, 'Security', 'images/navSecurity.jpg', 'images/navSecuritySel.jpg', 8, 0, 'navSecurity', 1, 5),
(33, 'Reports', 'images/navReports.jpg', 'images/navReportsSel.jpg', 10, 0, 'navReports', 1, 6),
(34, 'Plugins', 'images/navPlugins.jpg', 'images/navPluginsSel.jpg', 102, 0, 'navPlugins', 1, 7),
(35, 'Settings', 'images/navSettings.jpg', 'images/navSettingsSel.jpg', 13, 0, 'navSettings', 1, 8),
(36, 'Site Configuration', NULL, NULL, 13, 35, NULL, 1, 1),
(39, 'Image Browser', NULL, NULL, 4, 31, NULL, 1, 1),
(38, 'Web Analytics', NULL, NULL, 10, 33, NULL, 1, 1),
(40, 'File Browser', NULL, NULL, 5, 31, NULL, 1, 2),
(41, 'User Accounts', NULL, NULL, 8, 32, NULL, 1, 1),
(42, 'Page Permissions', NULL, NULL, 14, 32, NULL, 1, 2),
(43, 'Navigation Management', NULL, NULL, 23, 30, NULL, 1, 1),
(44, 'Page Management', NULL, NULL, 24, 29, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `portalpages`
--

CREATE TABLE IF NOT EXISTS `portalpages` (
  `id` int(11) NOT NULL auto_increment,
  `pagetitle` varchar(255) NOT NULL,
  `inc` varchar(255) NOT NULL,
  `publish` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `portalpages`
--

INSERT INTO `portalpages` (`id`, `pagetitle`, `inc`, `publish`) VALUES
(1, 'Dashboard', 'content/dashboard.php', 1),
(23, 'Navigation Management', 'content/nav_manage.php', 1),
(13, 'Site Configuration', 'content/set_siteconfig.php', 1),
(4, 'Image Browser', 'content/med_images.php', 1),
(5, 'File Browser', 'content/med_files.php', 1),
(24, 'Page Management', 'content/pag_manage.php', 1),
(8, 'User Accounts', 'content/sec_users.php', 1),
(10, 'Web Analytics', 'content/rep_analytics.php', 1),
(14, 'Security Permissions', 'content/sec_permissions.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scratchpad`
--

CREATE TABLE IF NOT EXISTS `scratchpad` (
  `id` int(11) NOT NULL auto_increment,
  `note` text NOT NULL,
  `uname` varchar(255) NOT NULL,
  `posttime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `siteconfig`
--

CREATE TABLE IF NOT EXISTS `siteconfig` (
  `id` int(11) NOT NULL auto_increment,
  `homedir` varchar(255) default NULL,
  `metakeywords` varchar(255) default NULL,
  `metadesc` varchar(255) default NULL,
  `sitename` varchar(255) default NULL,
  `imgpath` varchar(255) default NULL,
  `filepath` varchar(255) default NULL,
  `mainpage` int(11) NOT NULL,
  `mainnav` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `siteconfig`
--

INSERT INTO `siteconfig` (`id`, `homedir`, `metakeywords`, `metadesc`, `sitename`, `imgpath`, `filepath`, `mainpage`, `mainnav`) VALUES
(1, 'develop', 'dont,list,key,words,here', 'Development Playground', 'CMS Development', '/home/develop/www/images', '/home/develop/www/uploads', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emailaddr` varchar(255) default NULL,
  `lastaccess` int(11) NOT NULL,
  `ipaddr` char(32) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `emailaddr`, `lastaccess`, `ipaddr`, `level`) VALUES
(1, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'test@test.com', 1361653030, '8.8.8.8', 1),


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
