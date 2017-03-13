-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 11:48 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `categories_sp` ()  NO SQL
SELECT cat_id, cat_name, cat_description
FROM categories$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cat_by_id_sp` (IN `@cat_id` INT)  NO SQL
SELECT categories.cat_id, categories.cat_name, categories.cat_description
FROM categories
WHERE categories.cat_id = `@cat_id`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_comment_sp` (IN `@post_codtent` TEXT, IN `@topic_id` INT, IN `@user_id` INT)  NO SQL
INSERT INTO posts
(post_content, post_date, post_topic, post_by) 
VALUES (`@post_codtent`, NOW(), `@topic_id`, `@user_id`)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_topic_sp` (IN `@topic_subject` VARCHAR(50), IN `@topic_cat` INT, IN `@user_id` INT)  NO SQL
INSERT INTO topics
(topic_subject, topic_cat, topic_date, topic_by)
VALUES(`@topic_subject`, `@topic_cat`, CURDATE(), `@user_id`)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_posts_sp` (IN `@topic_id` INT)  NO SQL
SELECT
    posts.post_topic,
    posts.post_content,
    posts.post_date,
    posts.post_by,
    users.user_id,
    users.user_name
FROM
    posts
LEFT JOIN
    users
ON
    posts.post_by = users.user_id
WHERE
    posts.post_topic = `@topic_id`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_topic_sp` (IN `@topic_id` INT)  NO SQL
SELECT topics.topic_id, topics.topic_subject, topics.topic_date, topics.topic_cat, topics.topic_by, users.user_name
FROM topics INNER JOIN users ON topics.topic_by = users.user_id
WHERE topics.topic_id = `@topic_id`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `last_topic_sp` (IN `@topic_subject` VARCHAR(50), IN `@topic_cat` INT, IN `@user_id` INT)  NO SQL
SELECT topics.topic_id, topics.topic_subject, topics.topic_date, topics.topic_cat, topics.topic_by
FROM topics
WHERE
topics.topic_subject = `@topic_subject` AND topics.topic_cat = `@topic_cat` AND topics.topic_by = `@user_id`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_user_sp` (IN `@username` VARCHAR(30), IN `@password` VARCHAR(50))  NO SQL
SELECT user_id, user_name, user_email, user_level
FROM users
WHERE
user_name = `@username` AND user_pass = `@password`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_cat_sp` (IN `@cat_name` VARCHAR(50), IN `@cat_description` VARCHAR(255))  NO SQL
INSERT INTO categories
(cat_name, cat_description)
VALUES
(`@cat_name`, `@cat_description`)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_user_sp` (IN `@username` VARCHAR(30), IN `@password` VARCHAR(100), IN `@useremail` VARCHAR(100), IN `@userdate` DATE, IN `@userlevel` INT)  NO SQL
INSERT INTO users
(user_name, user_pass, user_email ,user_date, user_level)
VALUES
(`@username`, `@password`, `@useremail`, `@userdate`, `@userlevel`)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `topics_for_cat_sp` (IN `@cat_id` INT)  NO SQL
SELECT topics.topic_id, topics.topic_subject, topics.topic_date, topics.topic_cat, topics.topic_by, users.user_name
FROM topics INNER JOIN users ON topics.topic_by = users.user_id
WHERE topics.topic_cat = `@cat_id`$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(8) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(1, 'JA Test Category', 'Test category just for fun!'),
(2, 'Category 2', 'Another Category');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_date`, `post_topic`, `post_by`) VALUES
(1, 'test', '2017-03-13 10:43:05', 11, 1),
(2, 'test comment', '2017-03-13 10:44:17', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL,
  `topic_subject` varchar(255) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_subject`, `topic_date`, `topic_cat`, `topic_by`) VALUES
(1, 'test topic', '0000-00-00 00:00:00', 1, 1),
(2, 'another topic', '0000-00-00 00:00:00', 1, 1),
(3, 'another topic', '0000-00-00 00:00:00', 1, 1),
(4, 'another topic', '0000-00-00 00:00:00', 1, 1),
(5, 'another topic', '0000-00-00 00:00:00', 1, 1),
(6, 'test', '0000-00-00 00:00:00', 1, 1),
(7, 'test1', '2017-03-10 00:00:00', 1, 1),
(8, 'Blah Blah', '2017-03-10 00:00:00', 1, 1),
(9, 'test topic 1', '2017-03-10 00:00:00', 1, 1),
(10, 'test topic 1', '2017-03-10 00:00:00', 1, 1),
(11, 'Topic for category 2', '2017-03-10 00:00:00', 2, 1),
(12, 'Next Topic', '2017-03-10 00:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_date` datetime NOT NULL,
  `user_level` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_date`, `user_level`) VALUES
(1, 'johntest', '9bc34549d565d9505b287de0cd20ac77be1d3f2c', 'test@test.com', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name_unique` (`cat_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_topic` (`post_topic`),
  ADD KEY `post_by` (`post_by`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_cat` (`topic_cat`),
  ADD KEY `topic_by` (`topic_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name_unique` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
