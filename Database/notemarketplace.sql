-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2021 at 07:34 PM
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
-- Database: `notemarketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `sellernotes`
--

CREATE TABLE `sellernotes` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `SellerID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `Status` int(11) NOT NULL COMMENT '"FOREIGN KEY relationship with ReferenceData table.\r\nbind distinct value from ReferenceData table with filter RefCategory =''NotesStatus'' and Isactive =1\r\n\r\nStatus can be ""Draft"", ""Submitted For Review"", ""In Review"", ""Published"", ""Rejected"" or ""Removed"""',
  `ActionedBy` int(11) DEFAULT NULL COMMENT '"FOREIGN KEY relationship with Users table.\r\nAdmin will reject the notes if he finds notes are not suitable for publish. \r\nAdmin will approve the notes if he finds notes are suitable for publish. \r\nAdmin will removed  the notes if he finds notes were not suitable for publish but currently published somehow. \r\nFor all cases, one can insert who did the action."',
  `AdminRemarks` varchar(255) DEFAULT NULL COMMENT '"Admin will enter the remarks when he will reject the notes or when he will mark status removed for notes via unpublish function. \r\n\r\nFor Rejected notes,  Seller cannot do anything except clone the notes and submit the new note again. . "',
  `PublishedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when admin approves  a record.',
  `Title` varchar(100) NOT NULL,
  `Category` int(20) NOT NULL COMMENT '"FOREIGN KEY relationship with NotesCategory  table.\r\nbind distinct Name from NotesCategory table with filter  Isactive =1"',
  `DisplayPicture` varchar(500) DEFAULT NULL COMMENT 'We need to physically store the file at project root level under "Members/{UserID}/{NoteID}/" folder  for display picture seller upload for his/her notes with file name as DP_{timestamp} and over this column we need to store the file path information. At a time only one picture should be there as DP for same noteid over physical directory(delete old and add new when user change display picture). If no display picture added, system need to use default admin configured one. ',
  `NoteType` int(20) DEFAULT NULL COMMENT '"FOREIGN KEY relationship with NoteTypes table.\r\nbind distinct Name from NoteTypes table with filter Isactive =1"',
  `NumberofPages` int(20) DEFAULT NULL,
  `Description` varchar(5000) NOT NULL,
  `UniversityName` varchar(200) DEFAULT NULL,
  `Country` int(20) DEFAULT NULL COMMENT '"FOREIGN KEY relationship with Country  table.\r\nbind distinct Country from Country table with filter  Isactive =1"',
  `Course` varchar(100) DEFAULT NULL,
  `CourseCode` varchar(100) DEFAULT NULL,
  `Professor` varchar(100) DEFAULT NULL,
  `IsPaid` bit(20) NOT NULL COMMENT '"Set false if selling mode is free and set true if selling mode is paid.\r\nbind distinct value from ReferenceData table with filter RefCategory =''SellingMode'' and Isactive =1"',
  `SellingPrice` decimal(50,0) DEFAULT NULL COMMENT 'if selling mode is paid - selling price cannot be a null (i.e. required) ; values can be 1,1.50, 100, 250.80',
  `NotesPreview` varchar(5000) DEFAULT NULL COMMENT '"if selling mode is paid - note preview cannot be a null (i.e. required)\r\nWe need to physically store the file at project root level under ""Members/{UserID}/{NoteID}/"" folder  for preview attachment user upload for preview with file name as Preview_{timestamp} and over this column we need to store the file path information. At a time only one note preview  should be there as preview for same noteid over physical directory(delete old and add new when user change profile picture). "',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. ',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. \r\n',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `UserID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `DOB` datetime(6) NOT NULL,
  `Gender` int(20) NOT NULL COMMENT '"FOREIGN KEY relationship with ReferenceData table.\r\nbind distinct value from ReferenceData table with filter RefCategory =''Gender'' and Isactive =1"\r\n',
  `SecondaryEmailAddress` varchar(100) NOT NULL COMMENT 'for Admin users only. \r\n',
  `Phonenumber–CountryCode` varchar(5) NOT NULL COMMENT 'bind distinct CountryCode  from Country table with filter  Isactive =1\r\n',
  `Phonenumber` varchar(20) NOT NULL,
  `ProfilePicture` varchar(500) NOT NULL COMMENT 'We need to physically store the file at project root level under "Members/{UserID}" folder i.e "Members/1"  for member uploaded profile pictures with file name as DP_{timestamp} and over here we need to store the file path information. At a time only one picture should be there as DP for same userid over physical directory(delete old and add new when user change profile picture). If no profile picture added, system need to use default admin configured one. \r\n',
  `AddressLine1` varchar(100) NOT NULL,
  `AddressLine2` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `ZipCode` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL COMMENT 'Bind distinct Country from Country table with filter  Isactive =1\r\n',
  `University` varchar(100) NOT NULL,
  `College` varchar(100) NOT NULL,
  `CreatedDate` datetime(6) NOT NULL COMMENT 'Date and time when system has created a record.\r\n',
  `CreatedBy` int(10) NOT NULL COMMENT 'UserID who has created this record. \r\n',
  `ModifiedDate` datetime(6) NOT NULL COMMENT 'Date and time when system has updated a record.\r\n',
  `ModifiedBy` int(10) NOT NULL COMMENT 'UserID who has updated this record. \r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY\r\n',
  `Name` varchar(50) NOT NULL COMMENT 'Entries can be Member, Admin or  Super Admin\r\n',
  `Description` varchar(255) DEFAULT NULL COMMENT 'What this role usage is one can write here.\r\n',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.\r\n',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.\r\n',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.\r\n',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.\r\n',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `RoleID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with UserRoles table.',
  `FirstName` varchar(50) NOT NULL COMMENT 'Required information',
  `LastName` varchar(50) NOT NULL COMMENT 'Required information',
  `EmailID` varchar(100) NOT NULL COMMENT 'Required information |  Unique EmailID across table.',
  `Password` varchar(24) NOT NULL COMMENT 'Required information',
  `IsEmailVerified` bit(50) NOT NULL COMMENT 'Required information , Default set to false',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(50) DEFAULT NULL COMMENT '"UserID who has created this record. \r\n\r\nUsually members will do signup by them for that case it can be null however Super admin will going to add other administrators so for that case we can store the Super admin  USERID who adds the record."\r\n',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(50) DEFAULT NULL COMMENT 'UserID who updates this record. \r\n',
  `IsActive` bit(50) NOT NULL COMMENT 'Required information , Default set to true\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sellernotes`
--
ALTER TABLE `sellernotes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
