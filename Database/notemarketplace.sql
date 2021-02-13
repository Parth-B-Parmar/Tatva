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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY ',
  `Name` varchar(100) NOT NULL,
  `CountryCode` varchar(100) NOT NULL,
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `NoteID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with SellerNotes table.',
  `Seller` int(20) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `Downloader` int(20) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `IsSellerHasAllowedDownload` bit(20) NOT NULL COMMENT 'for paid notes default false. For free notes it will be true anyway.',
  `AttachmentPath` varchar(5000) DEFAULT NULL COMMENT 'Attachement path can only be null if IsSellerHasAllowedDownload flag is false for paid notes.in that case we will hide download icon from UI.',
  `IsAttachmentDownloaded` bit(20) NOT NULL COMMENT 'for paid notes default false. For free notes it will be true anyway.',
  `AttachmentDownloadedDate` datetime(6) DEFAULT NULL COMMENT '"It can be null for paid notes if user has not downloaded as seller not allowed until he receives  a payment.\r\nif this field is null we can show created date as downloaded date and time for buyer requests grid."',
  `IsPaid` bit(64) NOT NULL COMMENT '"At a time when we insert the entry to this table we need to store Note selling type  to this table. Later if seller update his/her note configuration - Previous download records not gets affected. \r\nIf Paid we need to set true, if free we need to set to false."',
  `PurchasedPrice` decimal(20,0) DEFAULT NULL COMMENT '"At a time when we insert the entry to this table we need to store Note selling price  to this table. \r\nlater if seller update his/her note configuration - Previous download records not gets affected. "',
  `NoteTitle` varchar(100) NOT NULL COMMENT '"At a time when we insert the entry to this table we need to store Note Title  to this table. \r\nlater if seller update his/her note configuration - Previous download records not gets affected. "',
  `NoteCategory` varchar(100) NOT NULL COMMENT '"At a time when we insert the entry to this table we need to store Note Category  to this table. \r\nlater if seller update his/her note configuration - Previous download records not gets affected. "',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notecategories`
--

CREATE TABLE `notecategories` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY ',
  `Name` varchar(100) NOT NULL COMMENT 'Computer Science, IT,  Politics, Sports, Cricket,  etc..',
  `Description` varchar(5000) NOT NULL COMMENT 'Description to explain what this category means. ',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notetypes`
--

CREATE TABLE `notetypes` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY ',
  `Name` varchar(100) NOT NULL COMMENT 'Handwritten notes, university notes, novel, story books etc.. ',
  `Description` mediumtext NOT NULL COMMENT 'Description to explain what this type means. ',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `referencedata`
--

CREATE TABLE `referencedata` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY ',
  `Value` varchar(100) NOT NULL COMMENT 'Value to display over UI for each data item ',
  `Datavalue` varchar(100) NOT NULL COMMENT 'Unique identifier for dataitem per category which admin never can change.',
  `RefCategory` varchar(100) NOT NULL COMMENT 'category name. i.e. NotesStatus, SellingMode,Gender etc.',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `sellernotesattachments`
--

CREATE TABLE `sellernotesattachments` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `NoteID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with SellerNotes table.',
  `FileName` varchar(100) NOT NULL,
  `FilePath` varchar(5000) NOT NULL COMMENT '"We need to physically store the file at project root level under \r\n""Members/{UserID}/{NoteID}/Attachements"" folder  for each notes attachment user uploads with file name as {AttachmentID}_{timestamp} and over this column we need to store the file path information. on delete of attachments record, we can mark  a record as isactive =0. \r\nAlso maintain a validation that published/submitted  note atleast should have one note attachment.  restrict all the cases to prevent violation of this rule."',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record.',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellernotesreportedissues`
--

CREATE TABLE `sellernotesreportedissues` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `NoteID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with SellerNotes table.',
  `ReportedBYID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `AgainstDownloadID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Downloads  table.',
  `Remarks` varchar(5000) NOT NULL,
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. ',
  `ModifiedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellernotesreviews`
--

CREATE TABLE `sellernotesreviews` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY',
  `NoteID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with SellerNotes table.',
  `ReviewedByID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Users table.',
  `AgainstDownloadsID` int(10) NOT NULL COMMENT 'FOREIGN KEY relationship with Downloads  table.',
  `Ratings` decimal(20,0) NOT NULL COMMENT 'Ratings can be 1 to 5. It also can be 1.5,2.5 etc. this is required.',
  `Comments` varchar(5000) NOT NULL,
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. ',
  `ModifiedDate` int(6) DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
  `IsActive` bit(20) NOT NULL COMMENT 'Required information , Default set to true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `systemconfigurations`
--

CREATE TABLE `systemconfigurations` (
  `ID` int(10) NOT NULL COMMENT 'PRIMARY KEY ',
  `Key` varchar(100) NOT NULL COMMENT '"SupportEmailAddress, SupportContact Number, EmailAddresssesForNotify, \r\nDefaultNoteDisplayPicture, DefaultMemberDisplayPicture, FBICON, TWITTERICON, LNICON etc."',
  `Value` varchar(5000) NOT NULL COMMENT 'value for each key which will super admin will configure.',
  `CreatedDate` datetime(6) DEFAULT NULL COMMENT 'Date and time when system has created a record.',
  `CreatedBy` int(10) DEFAULT NULL COMMENT 'UserID who has created this record. Super Admin ID you can insert static.',
  `ModifiedDate` timestamp(6) NULL DEFAULT NULL COMMENT 'Date and time when system has updated a record.',
  `ModifiedBy` int(10) DEFAULT NULL COMMENT 'UserID who has updated this record. Super Admin ID you can insert static.',
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
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NoteID` (`NoteID`),
  ADD KEY `Seller` (`Seller`),
  ADD KEY `Downloader` (`Downloader`);

--
-- Indexes for table `notecategories`
--
ALTER TABLE `notecategories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notetypes`
--
ALTER TABLE `notetypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `referencedata`
--
ALTER TABLE `referencedata`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sellernotes`
--
ALTER TABLE `sellernotes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SellerID` (`SellerID`),
  ADD KEY `Status` (`Status`),
  ADD KEY `ActionedBy` (`ActionedBy`),
  ADD KEY `Category` (`Category`),
  ADD KEY `NoteType` (`NoteType`),
  ADD KEY `Country` (`Country`);

--
-- Indexes for table `sellernotesattachments`
--
ALTER TABLE `sellernotesattachments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NoteID` (`NoteID`);

--
-- Indexes for table `sellernotesreportedissues`
--
ALTER TABLE `sellernotesreportedissues`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NoteID` (`NoteID`),
  ADD KEY `ReportedBYID` (`ReportedBYID`),
  ADD KEY `AgainstDownloadID` (`AgainstDownloadID`);

--
-- Indexes for table `sellernotesreviews`
--
ALTER TABLE `sellernotesreviews`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NoteID` (`NoteID`),
  ADD KEY `ReviewedByID` (`ReviewedByID`),
  ADD KEY `AgainstDownloadsID` (`AgainstDownloadsID`);

--
-- Indexes for table `systemconfigurations`
--
ALTER TABLE `systemconfigurations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Gender` (`Gender`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EmailID` (`EmailID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `sellernotes` (`ID`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`Seller`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `downloads_ibfk_3` FOREIGN KEY (`Downloader`) REFERENCES `users` (`ID`);

--
-- Constraints for table `sellernotes`
--
ALTER TABLE `sellernotes`
  ADD CONSTRAINT `sellernotes_ibfk_1` FOREIGN KEY (`SellerID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `sellernotes_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `referencedata` (`ID`),
  ADD CONSTRAINT `sellernotes_ibfk_3` FOREIGN KEY (`ActionedBy`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `sellernotes_ibfk_4` FOREIGN KEY (`Category`) REFERENCES `notecategories` (`ID`),
  ADD CONSTRAINT `sellernotes_ibfk_5` FOREIGN KEY (`NoteType`) REFERENCES `notetypes` (`ID`),
  ADD CONSTRAINT `sellernotes_ibfk_6` FOREIGN KEY (`Country`) REFERENCES `countries` (`ID`);

--
-- Constraints for table `sellernotesattachments`
--
ALTER TABLE `sellernotesattachments`
  ADD CONSTRAINT `sellernotesattachments_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `sellernotes` (`ID`);

--
-- Constraints for table `sellernotesreportedissues`
--
ALTER TABLE `sellernotesreportedissues`
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `sellernotes` (`ID`),
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_2` FOREIGN KEY (`ReportedBYID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `sellernotesreportedissues_ibfk_3` FOREIGN KEY (`AgainstDownloadID`) REFERENCES `downloads` (`ID`);

--
-- Constraints for table `sellernotesreviews`
--
ALTER TABLE `sellernotesreviews`
  ADD CONSTRAINT `sellernotesreviews_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `sellernotes` (`ID`),
  ADD CONSTRAINT `sellernotesreviews_ibfk_2` FOREIGN KEY (`ReviewedByID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `sellernotesreviews_ibfk_3` FOREIGN KEY (`AgainstDownloadsID`) REFERENCES `downloads` (`ID`);

--
-- Constraints for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `userprofile_ibfk_2` FOREIGN KEY (`Gender`) REFERENCES `referencedata` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `userroles` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
