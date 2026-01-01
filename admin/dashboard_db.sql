-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 05:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dashboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('user','admin','system','newsletter') DEFAULT 'system',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity`, `description`, `type`, `created_at`) VALUES
(1, 'Admin Login', 'Administrator logged into the dashboard', 'admin', '2025-12-29 06:27:14'),
(2, 'New Subscriber', 'New newsletter subscription received', 'newsletter', '2025-12-29 06:27:14'),
(3, 'Content Updated', 'Who We Are section was updated', 'admin', '2025-12-29 06:27:14'),
(4, 'System Check', 'Daily system health check completed', 'system', '2025-12-29 06:27:14'),
(5, 'Dashboard initialized', NULL, 'system', '2025-12-29 17:56:18'),
(6, 'Banner slider activated', NULL, 'system', '2025-12-29 17:56:18'),
(7, 'Newsletter system ready', NULL, 'system', '2025-12-29 17:56:18'),
(8, 'Database setup completed', NULL, 'system', '2025-12-29 17:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `content`, `image_path`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Empowering Families', 'Discover comprehensive resources and support for every stage of your parenting journey.', 'assets/images/banner1.jpg', 1, 'active', '2025-12-29 17:56:18', '2025-12-29 17:56:18'),
(2, 'Building Strong Communities', 'Join a thriving community of parents and experts dedicated to family wellness.', 'assets/images/banner2.jpg', 2, 'active', '2025-12-29 17:56:18', '2025-12-29 17:56:18'),
(3, 'Innovative Solutions', 'Access cutting-edge tools and technologies designed to make family life easier.', 'assets/images/banner3.jpg', 3, 'active', '2025-12-29 17:56:18', '2025-12-29 17:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `ecosystem`
--

CREATE TABLE `ecosystem` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'platform',
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ecosystem`
--

INSERT INTO `ecosystem` (`id`, `name`, `description`, `icon`, `category`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Parenting360', 'Comprehensive parenting resources and support', 'fa-baby', 'platform', 'active', 1, '2025-12-29 06:07:26', '2025-12-29 06:07:26'),
(2, 'MomsHQ', 'Empowering mothers with knowledge and community', 'fa-heart', 'community', 'active', 2, '2025-12-29 06:07:26', '2025-12-29 06:07:26'),
(3, 'Diyaa', 'Innovative solutions for modern families', 'fa-lightbulb', 'service', 'active', 3, '2025-12-29 06:07:26', '2025-12-29 06:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive','unsubscribed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success', 0, '2025-12-29 06:24:53', '2025-12-29 06:24:53'),
(2, 'New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info', 0, '2025-12-29 06:24:53', '2025-12-29 06:24:53'),
(3, 'System Update', 'The system has been updated to the latest version.', 'warning', 0, '2025-12-29 06:24:53', '2025-12-29 06:24:53'),
(4, 'Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success', 0, '2025-12-29 06:25:18', '2025-12-29 06:25:18'),
(5, 'New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info', 0, '2025-12-29 06:25:18', '2025-12-29 06:25:18'),
(6, 'System Update', 'The system has been updated to the latest version.', 'warning', 0, '2025-12-29 06:25:18', '2025-12-29 06:25:18'),
(7, 'Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success', 0, '2025-12-29 06:25:40', '2025-12-29 06:25:40'),
(8, 'New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info', 0, '2025-12-29 06:25:40', '2025-12-29 06:25:40'),
(9, 'System Update', 'The system has been updated to the latest version.', 'warning', 0, '2025-12-29 06:25:40', '2025-12-29 06:25:40'),
(10, 'Welcome to Thrive Admin', 'You have successfully logged into the admin dashboard.', 'success', 0, '2025-12-29 06:25:51', '2025-12-29 06:25:51'),
(11, 'New Newsletter Subscriber', 'A new user has subscribed to your newsletter.', 'info', 0, '2025-12-29 06:25:51', '2025-12-29 06:25:51'),
(12, 'System Update', 'The system has been updated to the latest version.', 'warning', 0, '2025-12-29 06:25:51', '2025-12-29 06:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `page_visited` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `who_we_are`
--

CREATE TABLE `who_we_are` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `who_we_are`
--

INSERT INTO `who_we_are` (`id`, `title`, `content`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Building Tomorrow\'s Solutions Todaydd', 'We are a team of passionate professionals dedicated to creating innovative solutions that transform businesses and improve lives. With years of experience and a commitment to excellence, we strive to deliver exceptional results that exceed expectations. Our expertise spans across various domains, and we pride ourselves on our ability to adapt and innovate in an ever-changing technological landscape.', NULL, 'active', '2025-12-29 05:43:15', '2025-12-29 06:14:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecosystem`
--
ALTER TABLE `ecosystem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `who_we_are`
--
ALTER TABLE `who_we_are`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ecosystem`
--
ALTER TABLE `ecosystem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `who_we_are`
--
ALTER TABLE `who_we_are`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
