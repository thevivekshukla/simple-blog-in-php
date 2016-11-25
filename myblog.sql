-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 19, 2016 at 09:00 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_admin`
--

CREATE TABLE `blog_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(15) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_password` varchar(60) NOT NULL,
  `date_of_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_admin`
--

INSERT INTO `blog_admin` (`admin_id`, `admin_username`, `admin_name`, `admin_password`, `date_of_reg`) VALUES
(1, 'admin', 'vivek shukla', '$2y$10$EI.8qdIL2zEJ60I.XcKOuuUUrZ5DOigWUU7yUB6Rxq56emr9TaD5u', '2016-09-10 12:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog_draft`
--

CREATE TABLE `blog_draft` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_title` tinytext NOT NULL,
  `post_content` longtext NOT NULL,
  `post_description` mediumtext NOT NULL,
  `post_tag` tinytext NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_draft`
--

INSERT INTO `blog_draft` (`post_id`, `post_title`, `post_content`, `post_description`, `post_tag`, `post_date`) VALUES
(1, 'sadu', 'hdhkjjnhjkjdut bnktugfsklmnhdhkjjnhhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmndut bnktugfsklmn', 'sadi', 'hdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmnhdhkjjnhjkjdut bnktugfsklmn', '2016-10-06 20:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_title` tinytext NOT NULL,
  `post_content` longtext NOT NULL,
  `post_description` mediumtext NOT NULL,
  `post_tag` tinytext NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`post_id`, `post_title`, `post_content`, `post_description`, `post_tag`, `post_date`) VALUES
(3, 'qweryuiolkjf   fxchgjkljv vhjnkljbdkjsndflk sdhfjsvioueif hveiuwhevowef seoios', 'dvjowejvowejvo', 'ewfhow', 'vwoejow', '2016-09-19 11:52:37'),
(4, 'post 145', 'testing', 'no desc', 'test', '2016-09-23 18:53:28'),
(5, 'new post', 'sdjlskdfj kljsd lsflks', 'svdskvsldnf sjdlks', 'sjdlksjfdlks', '2016-09-23 18:58:02'),
(9, 'post 145', 'testing 154', 'test', 'no desc', '2016-09-23 20:53:55'),
(10, 'post 2', 'sldkfjslkdf updated', 'sdkfjsl', 'djflks', '2016-09-24 17:59:48'),
(11, 'This is a new post', 'post slkfj fvnoewrj v osr dk wer  owieoikl owei lsfw oefj df fweu of fjwoej owef f woei wf kjf woie j jds fjweif jf sdjfoiwej sjf jweiofj ejf jfoiwej jdfj akfd jasdifwpefj klsdvknvweoij nd ifwje roijf we iorjiw', 'blog post', 'this is a blog post', '2016-09-24 18:16:55'),
(12, 'jlksjd f', 'xsvzf', 'dfsd f', 'sdf', '2016-09-28 11:20:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_admin`
--
ALTER TABLE `blog_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `blog_draft`
--
ALTER TABLE `blog_draft`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_admin`
--
ALTER TABLE `blog_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_draft`
--
ALTER TABLE `blog_draft`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
