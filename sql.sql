-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2017 at 09:37 AM
-- Server version: 5.6.25-0ubuntu1
-- PHP Version: 5.6.11-1ubuntu3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter_1776_reply_bot`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `web_path` varchar(500) NOT NULL,
  `system_path` varchar(500) NOT NULL,
  `filesize` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `search_id` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `reply` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(70) NOT NULL,
  `is_ready` int(11) NOT NULL DEFAULT '0',
  `twitter_media_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `added_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_completed` int(11) NOT NULL DEFAULT '0',
  `is_new` int(11) NOT NULL DEFAULT '1',
  `max_id` varchar(100) NOT NULL DEFAULT '0',
  `since_id` varchar(100) NOT NULL DEFAULT '0',
  `last_search` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `tweet_user_id` varchar(50) NOT NULL,
  `main_tweet_id` varchar(50) NOT NULL,
  `last_tweet_id` varchar(50) NOT NULL,
  `reply_tweet_id` varchar(50) NOT NULL,
  `value` varchar(10) NOT NULL,
  `status` text NOT NULL,
  `stage` int(11) NOT NULL DEFAULT '0',
  `is_new` int(11) NOT NULL DEFAULT '1',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `id` bigint(20) NOT NULL,
  `tweet_id` varchar(100) NOT NULL,
  `tweet` varchar(200) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `tweet_json` text NOT NULL,
  `datetime` datetime NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_new` int(11) NOT NULL DEFAULT '1',
  `reply_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `oauth_token` varchar(250) COLLATE utf8_bin NOT NULL,
  `oauth_secret` varchar(250) COLLATE utf8_bin NOT NULL,
  `user_json` text COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '2017-01-01 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dashboard_options` text COLLATE utf8_bin NOT NULL,
  `table_options` text COLLATE utf8_bin NOT NULL,
  `export_options` text COLLATE utf8_bin NOT NULL,
  `search_reset` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reply_reset` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_new` int(11) NOT NULL DEFAULT '1',
  `last_search` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `max_id` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `since_id` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `last_reply_time` datetime NOT NULL DEFAULT '2017-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet` (`tweet`),
  ADD KEY `tweet_2` (`tweet`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
