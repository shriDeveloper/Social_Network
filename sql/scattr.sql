-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2017 at 07:52 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scattr`
--

-- --------------------------------------------------------

--
-- Table structure for table `scattr_img_base`
--

CREATE TABLE `scattr_img_base` (
  `ImgId` int(255) NOT NULL,
  `ImgName` varchar(255) NOT NULL,
  `Hits` int(255) NOT NULL,
  `Cid` text NOT NULL,
  `Uploader` int(255) NOT NULL,
  `Time` time NOT NULL,
  `Date` date NOT NULL,
  `Caption` text NOT NULL,
  `Privacy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_img_base`
--

INSERT INTO `scattr_img_base` (`ImgId`, `ImgName`, `Hits`, `Cid`, `Uploader`, `Time`, `Date`, `Caption`, `Privacy`) VALUES
(109879, 'WW968uQmBfPO2giYnQ4i0zeEhgH4BdY33bai3GodgEo=', 1, '263087,285965,388808,470304,276658,490585,352766,255057,386871,110708,244384,120994,167921,269460,864674,320815,813275,477112,659090,349232,361094', 111110, '23:17:09', '2017-07-26', 'DEF', 'DEF'),
(233509, 'CchXnlMXdOJ97L6IQp2kgn++zEPc6Fyt2kgAJapVPQM=', 0, 'DEF', 276858, '23:20:58', '2017-07-26', 'DEF', 'DEF'),
(253144, 'lv4I9+8vD+GDHDsakQruW3shriHv8xYfllZh+hvRu2RHBA=', 2, '472929,286159,311252,205961,277116,137162,309692,759594,200181,198560,368988', 111110, '23:23:05', '2017-07-26', 'DEF', 'DEF'),
(260978, 'wM7NicM9VUA2fSZMSshriUyxBs7Cf9DwrLQc7AfdXug05E=', 1, '200050,399335,173550', 111110, '21:45:13', '2017-07-30', 'DEF', 'DEF'),
(377404, 'GMfYshriycu8KnBrO9ROp8vkDHIUKYg9gpBCURjvKEPRRk=', 0, '283376', 111110, '23:17:17', '2017-07-26', 'DEF', 'DEF'),
(388677, '3Xsv4TSUhUPwbK1C05cJQkOuXgK0Joc3t1shribUZ+sJeY=', 1, '443701,937631', 111110, '23:17:28', '2017-07-26', 'DEF', 'DEF'),
(396991, 'W8gtVovmSWC1cwLLscDrItT8kjneWDollr1fwDz01dA=', 2, '241554,476098,115271,288126,298057,234723,222098,629141,163600,774690,173495,544120', 111110, '21:23:34', '2017-07-26', 'DEF', 'DEF'),
(472723, 'MyAVnwbsinEsfi4TLo5j6af9qIeT2MZhitxbwptLjjw=', 1, '264101,294379,144712,102500,402569,447049', 111110, '23:17:22', '2017-07-26', 'DEF', 'DEF'),
(480584, 'I44brqe83r6ukPkF3M3Reh8fQU1MMvDKR09+ZHW8N+c=', 1, '196698,105307', 111110, '21:14:20', '2017-07-27', 'DEF', 'DEF'),
(641566, 'lnh9jyCvtshriO0j3wdj5706LEcLk9RRtWxLv2z2uSXv6s=', 0, '208842,488211,152384,307395,415600', 111110, '23:22:44', '2017-07-26', 'DEF', 'DEF');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_img_base_likes`
--

CREATE TABLE `scattr_img_base_likes` (
  `ImgId` int(255) NOT NULL,
  `likes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_img_base_likes`
--

INSERT INTO `scattr_img_base_likes` (`ImgId`, `likes`) VALUES
(109879, '248007'),
(233509, ''),
(253144, '111110,248007'),
(260978, '111110'),
(377404, ''),
(388677, '248007'),
(396991, '111110,248007'),
(472723, '248007'),
(480584, '111110'),
(641566, '');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_login_attempts`
--

CREATE TABLE `scattr_login_attempts` (
  `Email` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_login_attempts`
--

INSERT INTO `scattr_login_attempts` (`Email`, `Password`) VALUES
('shriniketdeshmukh111@gmail.com', 'ismhrienietk'),
('shriniketdeshmukh111@gmail.com', 'iamshriniket'),
('shriniketdeshmukh111@gmail.com', 'iamshriniket'),
('jjjj@gmII.COM', 'kkk'),
('ggt@gg.com', 'ggggg'),
('admin@gmail.com', 'admin@gmail.com'),
('admin@gmail.com', 'admin'),
('admin@gmail.com', 'admin12345'),
('deshmukhss3@rknec.edu', 'imadmin'),
('admin@gmail.com', 'iamadmin');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_users`
--

CREATE TABLE `scattr_users` (
  `AccId` int(50) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Picture` varchar(255) NOT NULL,
  `UPic` varchar(230) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_users`
--

INSERT INTO `scattr_users` (`AccId`, `FirstName`, `LastName`, `Email`, `Password`, `Picture`, `UPic`) VALUES
(111110, 'Admin', 'Page', 'admin@gmail.com', 'imadmin', 'http://sdcrush.com/themes/sexymetro/img/no_user.jpg', '19i5FAqkAq2mA'),
(203529, 'Pawan', 'Motwani', 'pawanmotwani@gmail.com', 'impawan', 'http://sdcrush.com/themes/sexymetro/img/no_user.jpg', '291E8xonbi9zM'),
(248007, 'david', 'beckham', 'david@gmail.com', 'imdavid', '../Public/248007/propic/32dwCcxm9X19w', '32dwCcxm9X19w'),
(266983, 'shriniket', 'swam', 'thefuture@gmail.com', 'imfuture', '../Public/266983/propic/16HiotcwtssdEqA', '16HiotcwtssdEqA'),
(276858, 'Shriniket', 'Deshmukh', 'shriniketdeshmukh111@gmail.com', 'imshriniket', '../Public/276858/propic/25qZCqtNocQqs', '25qZCqtNocQqs'),
(407600, 'christiano', 'ronaldo', 'ronaldo@gmail.com', 'imronaldo', '../Public/407600/propic/20uxghzOEqYY6', '20uxghzOEqYY6'),
(435432, 'nihal', 'reddy', 'nihalreddy@gmail.com', 'imnihal', '../Public/435432/propic/20Ii4TUQssdssdJjg', '20Ii4TUQssdssdJjg');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_users_favourites`
--

CREATE TABLE `scattr_users_favourites` (
  `AccId` int(200) NOT NULL,
  `Favourites` varchar(255) NOT NULL,
  `Request` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_users_favourites`
--

INSERT INTO `scattr_users_favourites` (`AccId`, `Favourites`, `Request`) VALUES
(111110, '248007', ''),
(203529, '276858,266983', ''),
(248007, '111110', 'DEF'),
(266983, '203529', '435432,111110'),
(276858, '203529,407600', ''),
(407600, '276858', 'DEF'),
(435432, 'DEF', '111110');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_users_imf`
--

CREATE TABLE `scattr_users_imf` (
  `AccId` int(50) NOT NULL,
  `College` text NOT NULL,
  `City` text NOT NULL,
  `About` text NOT NULL,
  `Tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_users_imf`
--

INSERT INTO `scattr_users_imf` (`AccId`, `College`, `City`, `About`, `Tags`) VALUES
(111110, 'rcoem', 'wardha', 'I m Admin', ''),
(203529, 'DEF', 'DEF', 'DEF', ''),
(248007, 'walton', 'manchester', 'I M A FootBaller!!!', 'football,manchester,chelsea'),
(266983, 'rcoem', 'wardha', 'fuckin shit is here', ''),
(276858, 'rcoem', 'nagpur', 'Founder of SNapperCo-founderInternet Entrepreneur', 'programming,java,eclipse,mysql'),
(407600, 'rocem', 'football', 'Its all about fun!!!', 'football,portugal,player,manchester united'),
(435432, 'rcoem', 'wardha', 'DEF', '');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_user_comments`
--

CREATE TABLE `scattr_user_comments` (
  `CID` int(255) NOT NULL,
  `Comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Commenter` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_user_comments`
--

INSERT INTO `scattr_user_comments` (`CID`, `Comment`, `Commenter`) VALUES
(102500, '0️⃣0️⃣0️⃣0️⃣8️⃣8️⃣8️⃣8️⃣8️⃣↙️↙️↙️♏️♏️♏️♏️♏️♏️♏️♉️♉️♉️♉️♉️♉️🅰🅰🅰🅰🅰🅱🅱🆎🆎🅾🅾🅾🕕🕕🕕🕕🕚🕚🕚⬛️⬛️⚫️??', '111110'),
(105307, 'just at the fuckin shit!!!😅😅😅😔😔😳😳😀😀😐❤️❤️', '111110'),
(110708, 'junk ip', '111110'),
(115271, 'we cant start over!!!', '111110'),
(120994, '😋😋😔😳😒', '111110'),
(137162, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '111110'),
(144712, 'the youtube!!!!', '111110'),
(152384, 'sjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', '111110'),
(163600, '😍😘😘😘', '111110'),
(167921, 'butyy', '111110'),
(173495, 'ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸŒ‡', '111110'),
(173550, 'ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ˜³ðŸ”³ðŸ”³ðŸ”³ðŸ”³ðŸ†ŽðŸ†ŽðŸ†ŽðŸ†ŽðŸ…±ðŸ…±â™‰ï¸â™‰ï¸ðŸ‡·ðŸ‡ºðŸ‡·ðŸ‡ºðŸ‡·ðŸ‡ºðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸŒ‡ðŸ©ðŸ©ðŸ©ðŸ©ðŸ©ðŸ©ðŸ©', '111110'),
(196698, 'the classes is the best!!!', '111110'),
(198560, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '111110'),
(200050, 'sathiyaÂ ', '111110'),
(200181, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '111110'),
(205961, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '111110'),
(208842, '😀😐😐😕😕😅😌😌😌😌😒😒😞😞🐑🐑🐑', '111110'),
(217657, 'Its when my Daemon time!!!!', '276858'),
(222098, 'yuinniikkk', '111110'),
(234723, 'hey i m the one yeah!!!', '111110'),
(241554, 'can we start over!!!', '111110'),
(244384, 'jhhjhhkkkj😊😊😊😊😊😊', '111110'),
(255057, 'can we start over!!!', '111110'),
(263087, 'We spend a day at facebook headquarter and it was great please to meet them.. mark zukerberg at the facebook headquartesrs was more suurprising to me and he delievered a speech at the harvard facebook in the san diago', '111110'),
(264101, 'junk ip .. in the best', '111110'),
(269460, 'say something!!!!', '111110'),
(276658, '😌😌😌🙈🙈😂😂', '111110'),
(277116, '🕕🕕🕕🕕🕕🕕', '111110'),
(283376, '❤️❤️❤️❤️❤️❤️❤️', '111110'),
(285965, 'less than i feel than i work in out!!!', '111110'),
(286159, 'hey.. i m the stay and the clock is ticking!!', '111110'),
(288126, 'i think the key is such a key and u talking the beat .. i see that you r on the web abd i really hard disk at the best of the page and i really i can sick is suck a key .. when you talking the keys ', '111110'),
(294379, '🗿🗿♨️♨️♨️♨️♨️♨️♨️♨️😂😂😂😂😂😂😂', '111110'),
(298057, '😊😊😊😊😊😊😗😗😘😘😍😍', '111110'),
(307395, 'sddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '111110'),
(309692, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss\\\\\\\\\\\\\\\\\\\\', '111110'),
(311252, 'youtube!!!!', '111110'),
(320815, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '111110'),
(349232, 'tera mera ridhta hai kaisa ek pal dur gawara nahi tere liye hai roz hai jite koi lamha nah ho terea bina .. tera Â  Â  Â  Â  kyuki tum hi hi ab tum hi ho pozindagi ab tum hi hi chain bhi merea dard bhi merei ashihiqui ab tum i hi', '111110'),
(352766, 'just a chill out!!!😌😌😌😌', '111110'),
(361094, 'We spend a day at facebook headquarter and it was great please to meet them.. mark zukerberg at the facebook headquartesrs was more suurprising to me and he delievered a speech at the harvard facebook in the san diago look what you have donw i m a nature ', '111110'),
(368988, 'ssssssssssssss', '111110'),
(386871, 'i m like all the way !!!😍😝😝', '111110'),
(388808, '😊😊😊', '111110'),
(399335, 'na tine muxhe gam diya!!! gujare the jo lamhe pyar ke .. phir tune badi kyu hawa yeh kyu kiya!!!!', '111110'),
(402569, 'kdfjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', '111110'),
(415600, 'sdddaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '111110'),
(443701, 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', '111110'),
(447049, 'jkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '111110'),
(470304, '😋😋😋😋👌👌👌👌👌', '111110'),
(472929, 'i m in love with your body!!', '111110'),
(476098, 'can wen hate closer!!!', '111110'),
(477112, 'yeah you just want attention ................ what r u doing i really want it from start!!!ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜˜ðŸ˜˜ðŸ˜˜', '111110'),
(488211, 'cxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '111110'),
(490585, '👌👌🎄🎄', '111110'),
(544120, 'we can start off fuckin shit!!!!ðŸ…±ðŸ…±ðŸ…±ðŸ…±ðŸ˜ðŸ˜ðŸ˜', '248007'),
(629141, 'i love great!!!', '111110'),
(659090, 'look what you have donw i m a nature fucker star boy .. i m good i m good i m good .. fighting for the desire we can never any one how i took the best of the technology!!!', '111110'),
(759594, 'i think the best is yet to come and i really want to build the website by my one self all i gotta do is the page rank!!!mmmmmmmmmmmmmmmmmmmmmmmmmmm', '111110'),
(774690, '🇷🇺🇷🇺🇷🇺🇷🇺🇷🇺🇷🇺🇷🇺😘😘😘😘😘😍😍😍', '111110'),
(813275, 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn', '111110'),
(864674, 'loppe the out stuck...', '111110'),
(937631, 'jbggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '111110');

-- --------------------------------------------------------

--
-- Table structure for table `scattr_user_img_base`
--

CREATE TABLE `scattr_user_img_base` (
  `AccId` int(255) NOT NULL,
  `ImgId` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scattr_user_img_base`
--

INSERT INTO `scattr_user_img_base` (`AccId`, `ImgId`) VALUES
(111110, '396991,109879,377404,472723,388677,641566,253144,480584,260978'),
(248007, 'DEF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scattr_img_base`
--
ALTER TABLE `scattr_img_base`
  ADD PRIMARY KEY (`ImgId`);

--
-- Indexes for table `scattr_img_base_likes`
--
ALTER TABLE `scattr_img_base_likes`
  ADD PRIMARY KEY (`ImgId`);

--
-- Indexes for table `scattr_users`
--
ALTER TABLE `scattr_users`
  ADD PRIMARY KEY (`AccId`);

--
-- Indexes for table `scattr_users_favourites`
--
ALTER TABLE `scattr_users_favourites`
  ADD PRIMARY KEY (`AccId`);

--
-- Indexes for table `scattr_users_imf`
--
ALTER TABLE `scattr_users_imf`
  ADD PRIMARY KEY (`AccId`);

--
-- Indexes for table `scattr_user_comments`
--
ALTER TABLE `scattr_user_comments`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `scattr_user_img_base`
--
ALTER TABLE `scattr_user_img_base`
  ADD PRIMARY KEY (`AccId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
