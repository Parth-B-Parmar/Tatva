-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2021 at 02:43 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notesmarketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryid` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `countrycode` varchar(10) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryid`, `name`, `countrycode`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'india', '91', '2021-03-27 13:33:19', 11, '2021-04-10 21:20:49', 11, b'1'),
(2, 'Afghanistan', '93', '2021-04-02 13:33:19', 14, '2021-04-10 21:20:38', 11, b'1'),
(3, 'Bangladesh', '880', '2021-02-20 13:33:19', 16, '2021-04-10 21:22:06', 14, b'1'),
(4, 'China', '86', '2021-03-17 13:33:19', 11, '2021-04-10 21:22:31', 11, b'1'),
(5, 'Japan', '81', '2021-03-11 13:33:19', 14, '2021-04-10 21:21:33', 14, b'1'),
(6, 'United States', '1', '2021-02-27 13:33:19', 15, '2021-04-10 21:21:30', 14, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `downloadid` int(10) UNSIGNED NOT NULL,
  `noteid` int(10) UNSIGNED NOT NULL,
  `seller` int(10) UNSIGNED NOT NULL,
  `downloader` int(10) UNSIGNED NOT NULL,
  `sellerhasalloweddownload` bit(1) NOT NULL,
  `attactmentpath` varchar(255) DEFAULT NULL,
  `isattachmentdownloaded` bit(1) NOT NULL,
  `attactmentdownloadeddate` datetime DEFAULT NULL,
  `ispaid` int(11) UNSIGNED NOT NULL,
  `purchasedprice` decimal(10,2) DEFAULT NULL,
  `notetitle` varchar(100) NOT NULL,
  `notecategory` varchar(100) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`downloadid`, `noteid`, `seller`, `downloader`, `sellerhasalloweddownload`, `attactmentpath`, `isattachmentdownloaded`, `attactmentdownloadeddate`, `ispaid`, `purchasedprice`, `notetitle`, `notecategory`, `createddate`, `createdby`, `modifieddate`, `modifiedby`) VALUES
(99, 61, 19, 25, b'1', '../Members/19/61/Attachements/70_1618572146.pdf', b'1', '2021-04-16 17:04:00', 2, '0.00', 'Maths', 'CA', '2021-04-16 17:04:00', 25, '2021-04-16 17:04:00', 25),
(100, 62, 25, 2, b'0', '../Members/25/62/Attachements/71_1618572941.pdf', b'0', '2021-04-16 17:08:29', 1, '100.00', 'Physics', 'IT', '2021-04-16 17:08:29', 2, '2021-04-16 17:08:29', 2),
(101, 62, 25, 19, b'1', '../Members/25/62/Attachements/71_1618572941.pdf', b'0', '2021-04-16 17:41:09', 1, '100.00', 'Physics', 'IT', '2021-04-16 17:39:12', 19, '2021-04-16 17:39:12', 19);

-- --------------------------------------------------------

--
-- Table structure for table `notecategories`
--

CREATE TABLE `notecategories` (
  `categoryid` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notecategories`
--

INSERT INTO `notecategories` (`categoryid`, `name`, `description`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'MBA', 'MBA', '2021-03-27 13:43:57', 14, '2021-04-01 21:25:00', 11, b'1'),
(2, 'IT', 'IT', '2021-03-21 13:43:57', 15, '2021-04-10 21:24:36', 14, b'1'),
(3, 'CA', 'CA', '2021-03-17 13:43:57', 16, '2021-03-22 21:24:47', 16, b'1'),
(4, 'Maths', 'Maths', '2021-04-02 13:43:57', 11, '2021-04-10 21:24:41', 11, b'1'),
(5, 'Chemistry', 'chemistry', '2021-03-07 13:43:57', 14, '2021-04-10 21:24:47', 11, b'1'),
(6, 'Hitroy', 'History', '2021-02-11 13:43:57', 11, '2021-03-10 21:24:47', 15, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `notetypes`
--

CREATE TABLE `notetypes` (
  `typeid` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notetypes`
--

INSERT INTO `notetypes` (`typeid`, `name`, `description`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'Handwritten notes', 'hand written', '2021-02-27 13:51:17', 16, '2021-04-10 21:26:25', 15, b'1'),
(2, 'University notes', 'university notes', '2021-02-27 13:51:17', 14, '2021-04-03 21:26:28', 11, b'1'),
(3, 'Notebook', 'notebook', '2021-02-27 13:51:17', 15, '2021-03-10 21:26:35', 14, b'1'),
(4, 'Novel', 'novel', '2021-02-27 13:51:17', 11, '2021-04-10 21:26:32', 11, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `referencedata`
--

CREATE TABLE `referencedata` (
  `refdataid` int(10) UNSIGNED NOT NULL,
  `value` varchar(100) NOT NULL,
  `datavalue` varchar(100) NOT NULL,
  `refcategory` varchar(100) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referencedata`
--

INSERT INTO `referencedata` (`refdataid`, `value`, `datavalue`, `refcategory`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'Paid', 'P', 'Selling Mode', '2021-02-27 14:03:53', 3, NULL, NULL, b'1'),
(2, 'Free', 'F', 'Selling Mode', '2021-02-27 14:03:53', 3, NULL, NULL, b'1'),
(3, 'Draft', 'Draft', 'Notes Status', '2021-02-28 01:48:49', 3, NULL, NULL, b'1'),
(4, 'Submitted For Review', 'Submitted For Review', 'Notes Status', '2021-02-28 01:52:39', 3, NULL, NULL, b'1'),
(5, 'In Review ', 'In Review ', 'Notes Status', '2021-02-28 01:52:39', 3, NULL, NULL, b'1'),
(6, 'Published ', 'Approved', 'Notes Status', '2021-02-28 01:52:39', 3, NULL, NULL, b'1'),
(7, 'Rejected', 'Rejected', 'Notes Status', '2021-02-28 01:52:39', 3, NULL, NULL, b'1'),
(8, 'Removed', 'Removed', 'Notes Status', '2021-02-28 01:52:39', 3, NULL, NULL, b'1'),
(9, 'Male', 'M', 'Gender', '2021-02-28 01:54:36', 3, NULL, NULL, b'1'),
(10, 'Female', 'F', 'Gender', '2021-02-28 01:54:36', 3, NULL, NULL, b'1'),
(11, 'other', 'o', 'Gender', '2021-02-28 01:54:36', 3, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `sellernotes`
--

CREATE TABLE `sellernotes` (
  `noteid` int(10) UNSIGNED NOT NULL,
  `sellerid` int(10) UNSIGNED NOT NULL,
  `status` int(11) UNSIGNED NOT NULL,
  `actionedby` int(11) UNSIGNED DEFAULT NULL,
  `admin_remarks` varchar(255) DEFAULT NULL,
  `publisheddate` datetime DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `category` int(100) UNSIGNED NOT NULL,
  `displaypic` varchar(255) DEFAULT NULL,
  `notetype` int(11) UNSIGNED DEFAULT NULL,
  `page_no` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `university_name` varchar(200) DEFAULT NULL,
  `country` int(11) UNSIGNED DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `course_code` varchar(100) DEFAULT NULL,
  `proffesor` varchar(100) DEFAULT NULL,
  `ispaid` int(11) UNSIGNED NOT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `notespreview` varchar(255) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellernotes`
--

INSERT INTO `sellernotes` (`noteid`, `sellerid`, `status`, `actionedby`, `admin_remarks`, `publisheddate`, `title`, `category`, `displaypic`, `notetype`, `page_no`, `description`, `university_name`, `country`, `course`, `course_code`, `proffesor`, `ispaid`, `selling_price`, `notespreview`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(60, 19, 3, NULL, NULL, NULL, 'science', 2, '../Members/19/60/DP_1618472156.jpeg', 3, 100, 'This is good Note', 'VGEC', 1, 'CE', '017', 'VRV', 2, '0.00', '../Members/19/60/Preview_1618472156.pdf', '2021-04-15 13:05:55', 19, '2021-04-15 13:05:55', NULL, b'1'),
(61, 19, 6, 2, NULL, '2021-04-16 16:58:16', 'Maths', 3, '../Members/19/61/DP_1618572146.png', 2, 107, 'my class  Note', 'VGEC', 1, 'CE', '017', 'VRV', 2, '0.00', '../Members/19/61/Preview_1618572146.pdf', '2021-04-16 16:52:26', 19, '2021-04-16 16:58:16', 2, b'1'),
(62, 25, 6, 2, NULL, '2021-04-16 17:07:42', 'Physics', 2, '../Members/25/62/DP_1618572941.png', 4, 100, 'Paid Note', 'VGEC', 1, 'CE', '017', 'VRV', 1, '100.00', '../Members/25/62/Preview_1618572941.pdf', '2021-04-16 17:05:41', 25, '2021-04-16 17:07:42', 2, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `sellernotesattachements`
--

CREATE TABLE `sellernotesattachements` (
  `note_attach_id` int(10) UNSIGNED NOT NULL,
  `noteid` int(10) UNSIGNED NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellernotesattachements`
--

INSERT INTO `sellernotesattachements` (`note_attach_id`, `noteid`, `filename`, `filepath`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(69, 60, '69_1618472156pdf', '../Members/19/60/Attachements/69_1618472156.pdf', '2021-04-15 13:05:56', 19, NULL, NULL, b'1'),
(70, 61, '70_1618572146pdf', '../Members/19/61/Attachements/70_1618572146.pdf', '2021-04-16 16:52:26', 19, NULL, NULL, b'1'),
(71, 62, '71_1618572941pdf', '../Members/25/62/Attachements/71_1618572941.pdf', '2021-04-16 17:05:41', 25, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `sellernotesreportedissues`
--

CREATE TABLE `sellernotesreportedissues` (
  `note_reportid` int(10) UNSIGNED NOT NULL,
  `noteid` int(10) UNSIGNED NOT NULL,
  `reprotedbyid` int(10) UNSIGNED NOT NULL,
  `againstdownloaderid` int(10) UNSIGNED NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellernotesreview`
--

CREATE TABLE `sellernotesreview` (
  `note_review_id` int(10) UNSIGNED NOT NULL,
  `noteid` int(10) UNSIGNED NOT NULL,
  `reviewer_id` int(10) UNSIGNED NOT NULL,
  `againstdownloadsid` int(10) UNSIGNED NOT NULL,
  `ratings` decimal(10,1) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellernotesreview`
--

INSERT INTO `sellernotesreview` (`note_review_id`, `noteid`, `reviewer_id`, `againstdownloadsid`, `ratings`, `comments`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(23, 62, 19, 25, '3.8', 'Loved It', '2021-04-16 17:44:41', 19, '2021-04-16 17:44:41', 19, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `systemconfiguration`
--

CREATE TABLE `systemconfiguration` (
  `configid` int(10) UNSIGNED NOT NULL,
  `key_info` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `systemconfiguration`
--

INSERT INTO `systemconfiguration` (`configid`, `key_info`, `value`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'support_email', 'raj69gohil@gmail.com', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(2, 'support_phone_no', '919824328786', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(3, 'email_for_events', 'notesmarketplace@gmail.com', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(4, 'fb_url', 'https://www.facebook.com/TatvaSoft/', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(5, 'twitter_url', 'https://twitter.com/tatvasoft?s=20', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(6, 'linkedin_url', 'https://www.linkedin.com/company/tatvasoft', '2021-04-10 21:31:41', 11, '2021-04-10 21:32:48', 11, b'1'),
(7, 'default_note', '../Members/default/DP_default.jpg', '2021-04-10 21:32:48', 11, '2021-04-10 21:32:48', 11, b'1'),
(8, 'default_profile_pic', '../Members/default/PP_default.jpg', '2021-04-10 21:32:48', 11, '2021-04-10 21:32:48', 11, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `userprofileid` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(11) UNSIGNED DEFAULT NULL,
  `secondemail` varchar(100) DEFAULT NULL,
  `phone_country_code` int(10) UNSIGNED DEFAULT NULL,
  `phone_no` varchar(20) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `address_line1` varchar(100) NOT NULL,
  `address_line2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country` int(50) UNSIGNED DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `college` varchar(100) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`userprofileid`, `userid`, `dob`, `gender`, `secondemail`, `phone_country_code`, `phone_no`, `profile_pic`, `address_line1`, `address_line2`, `city`, `state`, `zipcode`, `country`, `university`, `college`, `createddate`, `createdby`, `modifieddate`, `modifiedby`) VALUES
(10, 19, '2021-04-15', 9, NULL, 1, '9106985141', '../Members/19/DP_1618471961.jpg', 'current', 'current', 'ahmedabad', 'ahmedabad', '382424', 1, 'VGEC', 'VGEC', '2021-04-15 13:02:41', 19, '2021-04-15 13:02:41', 19);

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `roleid` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`roleid`, `name`, `description`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(1, 'user', 'user can be buyer or seller or both combined', '2021-02-24 13:57:19', 3, '2021-02-24 13:59:59', 3, b'1'),
(2, 'admin', 'admin', '2021-02-24 13:57:43', 3, '2021-02-24 14:00:10', 3, b'1'),
(3, 'super admin', 'super admin', '2021-02-24 13:57:56', 3, '2021-02-24 14:01:41', 3, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(10) UNSIGNED NOT NULL,
  `roleid` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `password` varchar(24) NOT NULL,
  `isemailverified` bit(1) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `isactive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `roleid`, `firstname`, `lastname`, `emailid`, `password`, `isemailverified`, `createddate`, `createdby`, `modifieddate`, `modifiedby`, `isactive`) VALUES
(2, 2, 'Admin', 'admin', 'pp895131@gmail.com', 'Parth@123', b'1', NULL, NULL, '2021-04-15 13:17:52', NULL, b'1'),
(19, 1, 'Parth', 'Parmar', 'pp2895131@gmail.com', 'Parth@123', b'1', '2021-04-15 13:00:32', NULL, NULL, NULL, b'1'),
(25, 1, 'mortal', 'soul', 'pp3895131@gmail.com', 'Parth123', b'1', '2021-04-15 14:45:08', NULL, NULL, NULL, b'1'),
(26, 1, 'Rega', 'soul', 'pp7895131@gmail.com', 'Parth@123', b'1', '2021-04-16 17:53:49', NULL, NULL, NULL, b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryid`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`downloadid`),
  ADD KEY `noteid` (`noteid`),
  ADD KEY `seller` (`seller`),
  ADD KEY `downloader` (`downloader`),
  ADD KEY `ispaid` (`ispaid`);

--
-- Indexes for table `notecategories`
--
ALTER TABLE `notecategories`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `notetypes`
--
ALTER TABLE `notetypes`
  ADD PRIMARY KEY (`typeid`);

--
-- Indexes for table `referencedata`
--
ALTER TABLE `referencedata`
  ADD PRIMARY KEY (`refdataid`);

--
-- Indexes for table `sellernotes`
--
ALTER TABLE `sellernotes`
  ADD PRIMARY KEY (`noteid`),
  ADD KEY `sellerid` (`sellerid`),
  ADD KEY `status` (`status`),
  ADD KEY `actionedby` (`actionedby`),
  ADD KEY `category` (`category`),
  ADD KEY `notetype` (`notetype`),
  ADD KEY `country` (`country`),
  ADD KEY `ispaid` (`ispaid`);

--
-- Indexes for table `sellernotesattachements`
--
ALTER TABLE `sellernotesattachements`
  ADD PRIMARY KEY (`note_attach_id`),
  ADD KEY `noteid` (`noteid`);

--
-- Indexes for table `sellernotesreportedissues`
--
ALTER TABLE `sellernotesreportedissues`
  ADD PRIMARY KEY (`note_reportid`),
  ADD KEY `againstdownloaderid` (`againstdownloaderid`),
  ADD KEY `noteid` (`noteid`),
  ADD KEY `reprotedbyid` (`reprotedbyid`);

--
-- Indexes for table `sellernotesreview`
--
ALTER TABLE `sellernotesreview`
  ADD PRIMARY KEY (`note_review_id`),
  ADD KEY `noteid` (`noteid`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `againstdownloadsid` (`againstdownloadsid`);

--
-- Indexes for table `systemconfiguration`
--
ALTER TABLE `systemconfiguration`
  ADD PRIMARY KEY (`configid`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`userprofileid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `gender` (`gender`),
  ADD KEY `phone_country_code` (`phone_country_code`),
  ADD KEY `country` (`country`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `emailid` (`emailid`),
  ADD KEY `roleid` (`roleid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `countryid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `downloadid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `notecategories`
--
ALTER TABLE `notecategories`
  MODIFY `categoryid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notetypes`
--
ALTER TABLE `notetypes`
  MODIFY `typeid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referencedata`
--
ALTER TABLE `referencedata`
  MODIFY `refdataid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sellernotes`
--
ALTER TABLE `sellernotes`
  MODIFY `noteid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `sellernotesattachements`
--
ALTER TABLE `sellernotesattachements`
  MODIFY `note_attach_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `sellernotesreportedissues`
--
ALTER TABLE `sellernotesreportedissues`
  MODIFY `note_reportid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sellernotesreview`
--
ALTER TABLE `sellernotesreview`
  MODIFY `note_review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `systemconfiguration`
--
ALTER TABLE `systemconfiguration`
  MODIFY `configid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `userprofileid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `roleid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`noteid`) REFERENCES `sellernotes` (`noteid`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`seller`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `downloads_ibfk_3` FOREIGN KEY (`downloader`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `downloads_ibfk_4` FOREIGN KEY (`ispaid`) REFERENCES `referencedata` (`refdataid`);

--
-- Constraints for table `sellernotes`
--
ALTER TABLE `sellernotes`
  ADD CONSTRAINT `sellernotes_ibfk_1` FOREIGN KEY (`sellerid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `sellernotes_ibfk_2` FOREIGN KEY (`status`) REFERENCES `referencedata` (`refdataid`),
  ADD CONSTRAINT `sellernotes_ibfk_3` FOREIGN KEY (`actionedby`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `sellernotes_ibfk_4` FOREIGN KEY (`category`) REFERENCES `notecategories` (`categoryid`),
  ADD CONSTRAINT `sellernotes_ibfk_5` FOREIGN KEY (`notetype`) REFERENCES `notetypes` (`typeid`),
  ADD CONSTRAINT `sellernotes_ibfk_6` FOREIGN KEY (`country`) REFERENCES `countries` (`countryid`),
  ADD CONSTRAINT `sellernotes_ibfk_7` FOREIGN KEY (`ispaid`) REFERENCES `referencedata` (`refdataid`);

--
-- Constraints for table `sellernotesattachements`
--
ALTER TABLE `sellernotesattachements`
  ADD CONSTRAINT `sellernotesattachements_ibfk_1` FOREIGN KEY (`noteid`) REFERENCES `sellernotes` (`noteid`);

--
-- Constraints for table `sellernotesreportedissues`
--
ALTER TABLE `sellernotesreportedissues`
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_1` FOREIGN KEY (`againstdownloaderid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_2` FOREIGN KEY (`noteid`) REFERENCES `sellernotes` (`noteid`),
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_3` FOREIGN KEY (`reprotedbyid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `sellernotesreview`
--
ALTER TABLE `sellernotesreview`
  ADD CONSTRAINT `sellernotesreview_ibfk_1` FOREIGN KEY (`noteid`) REFERENCES `sellernotes` (`noteid`),
  ADD CONSTRAINT `sellernotesreview_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `sellernotesreview_ibfk_3` FOREIGN KEY (`againstdownloadsid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `userprofile_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `referencedata` (`refdataid`),
  ADD CONSTRAINT `userprofile_ibfk_3` FOREIGN KEY (`phone_country_code`) REFERENCES `countries` (`countryid`),
  ADD CONSTRAINT `userprofile_ibfk_4` FOREIGN KEY (`country`) REFERENCES `countries` (`countryid`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `userroles` (`roleid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
