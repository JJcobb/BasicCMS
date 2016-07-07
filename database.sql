-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: sulley.cah.ucf.edu
-- Generation Time: Apr 23, 2016 at 05:53 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ja941580`
--

-- --------------------------------------------------------

--
-- Table structure for table `a6_comments`
--

CREATE TABLE `a6_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a6_comments`
--

INSERT INTO `a6_comments` (`comment_id`, `comment_creation_date`, `comment`, `user_id`, `review_id`) VALUES
(1, '2016-04-23 00:59:01', 'Yep. I liked it too.', 1, 2),
(2, '2016-04-23 12:43:53', 'Pretty good game. Highly recommended.', 1, 2),
(3, '2016-04-23 14:19:06', 'Woohoo! This is one of my favs!', 3, 6),
(4, '2016-04-23 14:20:23', 'Used to play this all the time. Def a 10/10.', 3, 2),
(5, '2016-04-23 14:36:04', 'There are a few things that make it different from Galaxian. But I like both games.', 4, 2),
(9, '2016-04-23 16:11:14', 'It was alright. I didn\'t think it was anything too special.', 1, 6),
(10, '2016-04-23 16:12:31', 'I can\'t even remember how many hours I used to spend playing this!', 1, 1),
(11, '2016-04-23 16:13:07', 'This game took so many of my quarters...', 4, 1),
(12, '2016-04-23 16:14:27', 'Robby is out of his mind. This game is where it\'s at.', 4, 6),
(13, '2016-04-23 16:15:31', 'Hey, I didn\'t say it was bad. It\'s still alright. I just wan\'t really into it.', 1, 6),
(14, '2016-04-23 16:17:19', 'Ms. Pac Man was alright too. But I prefer this one.', 3, 1),
(15, '2016-04-23 16:18:13', 'Anyone else make it to level 256?', 2, 1),
(16, '2016-04-23 16:23:08', 'Never really played it that much. But still a great game nonetheless.', 2, 3),
(17, '2016-04-23 16:24:03', 'Huh? I\'ve never even heard of this...', 3, 7),
(18, '2016-04-23 16:25:39', 'Man this game was challenging, but still loved it!', 3, 4),
(29, '2016-04-23 21:31:36', 'I\'d say it\'s almost deserving of a 10. Maybe a 9.5 would be most appropriate.', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `a6_reviews`
--

CREATE TABLE `a6_reviews` (
  `review_id` int(11) NOT NULL,
  `review_creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `game_name` varchar(255) NOT NULL,
  `game_review` varchar(255) NOT NULL,
  `game_rating` int(11) NOT NULL,
  `game_image_url` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a6_reviews`
--

INSERT INTO `a6_reviews` (`review_id`, `review_creation_date`, `game_name`, `game_review`, `game_rating`, `game_image_url`, `user_id`) VALUES
(1, '2016-04-05 22:21:58', 'Pac Man', 'This is a classic! Really good stuff.', 10, 'http://vignette1.wikia.nocookie.net/pacman/images/b/b4/Pacman_logo.gif/revision/latest?cb=20091017020035', 3),
(2, '2016-04-09 14:20:04', 'Galaga', 'This is the stuff right here! I don\'t know what makes it any different than Galaxian, but still a top notch piece of work.', 10, 'http://orig10.deviantart.net/5e43/f/2012/207/d/5/d51d6ff7d40d5bf567c23a58375a9f76-d58r751.png', 1),
(3, '2016-04-09 14:29:03', 'Dig Dug', 'This is sort of fun. Frustrating at times though.', 7, 'http://vignette1.wikia.nocookie.net/fictionalcrossover/images/e/ec/Dig_Dug_logo.jpg/revision/latest?cb=20120924113420', 3),
(4, '2016-04-09 14:41:17', 'Space Invaders', 'What a great game! I loved playing this as a kid. Highly recommended!', 9, 'http://www.arcadestickers.co.uk/image/cache/data/logos/space-invaders-logo-game-sticker-800x800.jpg', 1),
(5, '2016-04-13 00:28:36', 'Donkey Kong', 'The game was great. Before Mario was even really Mario. What a time to be alive.', 8, 'http://www.arcadestickers.co.uk/image/cache/data/logos/donkey-kong-logo-game-sticker-800x800.jpg', 4),
(6, '2016-04-13 00:35:04', 'Contra', 'Pretty fun. Such a great action shooter game.', 7, 'http://vignette3.wikia.nocookie.net/fictionalcrossover/images/c/c4/Contra.png/revision/latest?cb=20131013224959', 4),
(7, '2016-04-13 00:41:38', 'Q*bert', 'It\'s a decent game. The controls could be better.', 5, 'http://vignette2.wikia.nocookie.net/logopedia/images/d/d2/Qbert_game_logo.jpg/revision/latest?cb=20110819000224', 1);

-- --------------------------------------------------------

--
-- Table structure for table `a6_users`
--

CREATE TABLE `a6_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `access_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a6_users`
--

INSERT INTO `a6_users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `access_level`) VALUES
(1, 'review', '1c67665285fb6a7d761414e12578e574', 'Robby', 'Reviewer', 'reviewer'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Jacob', 'Vogelbacher', 'administrator'),
(3, 'review2', '1c67665285fb6a7d761414e12578e574', 'Bobby', 'Reviewman', 'reviewer'),
(4, 'review3', '1c67665285fb6a7d761414e12578e574', 'Toby', 'Reviewson', 'reviewer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a6_comments`
--
ALTER TABLE `a6_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `a6_reviews`
--
ALTER TABLE `a6_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `a6_users`
--
ALTER TABLE `a6_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a6_comments`
--
ALTER TABLE `a6_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `a6_reviews`
--
ALTER TABLE `a6_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `a6_users`
--
ALTER TABLE `a6_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
