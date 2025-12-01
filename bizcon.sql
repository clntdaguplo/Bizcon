-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 04:51 PM
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
-- Database: `bizcon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--
-- Error reading structure for table bizcon.appointments: #1932 - Table &#039;bizcon.appointments&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.appointments: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`appointments`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--
-- Error reading structure for table bizcon.bookings: #1932 - Table &#039;bizcon.bookings&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.bookings: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`bookings`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--
-- Error reading structure for table bizcon.cache: #1932 - Table &#039;bizcon.cache&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.cache: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`cache`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--
-- Error reading structure for table bizcon.cache_locks: #1932 - Table &#039;bizcon.cache_locks&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.cache_locks: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`cache_locks`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `consultants`
--
-- Error reading structure for table bizcon.consultants: #1932 - Table &#039;bizcon.consultants&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.consultants: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`consultants`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `consultant_profiles`
--

CREATE TABLE `consultant_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `age` tinyint(3) UNSIGNED NOT NULL,
  `sex` enum('Male','Female','Other') NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `is_rejected` tinyint(1) NOT NULL DEFAULT 0,
  `admin_note` text DEFAULT NULL,
  `rules_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `full_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `expertise` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultant_profiles`
--

INSERT INTO `consultant_profiles` (`id`, `user_id`, `address`, `age`, `sex`, `resume_path`, `avatar_path`, `is_verified`, `is_rejected`, `admin_note`, `rules_accepted`, `full_name`, `phone_number`, `email`, `expertise`, `created_at`, `updated_at`) VALUES
(1, 1, 'asufbsjbcnsajndiasjndausndasndand', 43, 'Male', 'resumes/oD6hwgBc0OlomYF67ZG3YnEPq251oejr3UtM7qjF.pdf', 'avatars/QLyAMJQMLLjFNJ4rXwBHZBWxZQWcEzErjbtP3NeS.jpg', 1, 0, NULL, 1, 'clint consult', '09684344670', 'clintconsult@gmail.com', 'Business Strategy', '2025-11-12 23:42:12', '2025-11-13 04:47:54'),
(2, 3, 'iudhasiudhjioashdioashjdoialskhdask slk\'dfihjosajl;]kgaedjikol;sdgjil[dbf[ljkdfjopidfbh lo\'isjdjiodsjoidsjoig dsinfsiodkhngiosdnfg ioadnfakdjphfjklpsdnfiosdlk[jgfilsdhjfg 8aoishnfionasf', 45, 'Male', 'resumes/ZflWeJy6o0BjI3QSqs6mPDUoGLZhm27peEvYdNlc.pdf', 'avatars/jeAd5cNGaoWqL9moCIluND1FJ96cvygsmNmx8IQn.jpg', 1, 0, NULL, 1, 'Test Consultant1', '09123123123', 'consultant1@gmail.com', 'E-commerce Business, Financial Business', '2025-11-13 00:22:38', '2025-12-01 05:16:02'),
(3, 5, 'asdagdfhsfgdjhfsghafdhdafhfdhsdghadhgwer wsfasdfg', 32, 'Male', 'resumes/TvxsOxIiGG73wkbb32hJMwh6T5YuaRZPugUeiJm3.pdf', 'avatars/IA5btjFOHWypmNadnNFECGRy7pTZxzCjW1CHP0wP.jpg', 1, 0, NULL, 1, 'Consulant2', '09123456789', 'consultant2@gmail.com', 'Marketing', '2025-11-13 04:55:53', '2025-11-13 04:56:37'),
(4, 6, 'hqwahsdahsdshadsahdhshd', 23, 'Male', 'resumes/EOE4MZtcCyJyjuVCu2hR2LPlYfWTPsSZSO8FPwsp.pdf', 'avatars/oao41OKl2kF7Tz4ScK31VteOFRX6E3BEd39Bqemh.png', 1, 0, NULL, 1, 'consultant10', '09123123123', 'consultant10@gmail.com', 'IT specialist', '2025-11-16 22:36:18', '2025-11-17 01:06:59'),
(5, 8, 'uagsdsadnasbd nhuasdjsankdlmsd868790-ihn tyuiokjytghjiuyhb uyyuijhyyujyujhujhgbn', 23, 'Male', 'resumes/4NljcnNPlfTfjJNyTwKhdQhmVPIDKuiUHM27c3zh.pdf', 'avatars/PqHPQ1bllbBiNDrrKwp2XN2diMM3LsqV9iu8l8EV.jpg', 0, 1, NULL, 1, 'Teo Consult', '09876876876', 'teoconsult@gmail.com', 'IT specialist', '2025-11-20 22:27:41', '2025-11-20 22:31:11'),
(6, 10, 'uasdbjasndks mjaisdklnmaskld,o1 qkn klm', 21, 'Male', 'resumes/JFneBmbdE4q3NXMfclljmtksWQN9arYkvWMydMmo.pdf', 'avatars/lrLTYnwGijRJax4dSfyk8jun5NY8EKuCOBKbJZZA.png', 1, 0, NULL, 1, 'Anjo Consult', '09123123123', 'anjoconsult@gmail.com', 'Finance', '2025-11-20 22:44:45', '2025-11-20 22:45:13'),
(7, 11, 'dasdmksa,djomlsadjmkla,sdklm,askfl,eg[oklpogfh,bogmlfbigjfkdjdoiqsakojdlsojdkm', 20, 'Male', 'resumes/14AQudHlhv2ai5w6PbRmJFkkzCbOmDh8pubSVDL3.pdf', 'avatars/fWnF4o84t9HnajPkgDpunnhlLjwoUgPVacE8Iejx.png', 0, 0, NULL, 1, 'Hubert Consult', '09345345345', 'hubertconsult@gmail.com', 'Law', '2025-11-20 22:56:03', '2025-11-20 22:56:03'),
(8, 14, 'auisgfbuhjasbdjkawhndckasnd', 21, 'Male', 'resumes/jK40eBMBvmTSPsG3XkjIz859a1I5iP7YQ5KXEbWt.pdf', 'avatars/pewrKpRVATMo0qn5YZ4eAM5CuAK3yu9KfEVQx4Zc.jpg', 1, 0, NULL, 1, 'bahan bahan', '09123123123', 'bahan@gmail.com', 'Technology & IT Support, Financial Business', '2025-12-01 01:37:33', '2025-12-01 01:48:03'),
(9, 15, 'a7fgbuhasjbndiasjknbd', 23, 'Male', 'resumes/OjNlEeqqrj8UJzR7enN8RIat10JufTEfCEoIv5FA.pdf', 'avatars/6aEUkwijRLwNrYcd2oneSFjCHAKBs8D31CgEOhuZ.jpg', 1, 0, NULL, 1, 'Allen Rafael', '09321321321', 'allen@gmail.com', 'Technology & IT Support, Marketing Business', '2025-12-01 01:52:49', '2025-12-01 04:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `consultant_profile_id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `scheduled_time` time DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `meeting_link` varchar(255) DEFAULT NULL,
  `proposal_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `proposed_date` date DEFAULT NULL,
  `proposed_time` time DEFAULT NULL,
  `consultation_summary` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `client_readiness_rating` int(11) DEFAULT NULL,
  `report_file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `customer_id`, `consultant_profile_id`, `topic`, `details`, `preferred_date`, `scheduled_date`, `preferred_time`, `scheduled_time`, `status`, `meeting_link`, `proposal_status`, `created_at`, `updated_at`, `proposed_date`, `proposed_time`, `consultation_summary`, `recommendations`, `client_readiness_rating`, `report_file_path`) VALUES
(1, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Rejected', NULL, NULL, '2025-11-13 00:40:57', '2025-11-26 00:14:29', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Rejected', NULL, NULL, '2025-11-13 00:42:13', '2025-11-26 00:14:33', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Completed', NULL, NULL, '2025-11-13 00:42:14', '2025-11-26 00:12:55', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Rejected', NULL, NULL, '2025-11-13 00:42:14', '2025-11-26 00:14:24', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Rejected', NULL, NULL, '2025-11-13 00:42:15', '2025-11-17 01:12:52', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 4, 2, 'IT', 'I want It specialist hehehe for my code', '2025-11-14', NULL, '14:40:00', NULL, 'Rejected', NULL, NULL, '2025-11-13 00:42:15', '2025-11-17 01:12:58', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, 1, 'Start Up Business', 'dasdasdsadasdsadasd', '2025-11-28', NULL, '13:30:00', NULL, 'Rejected', NULL, NULL, '2025-11-15 04:59:09', '2025-11-26 21:53:22', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 4, 1, 'Start Up Business', 'dasdasdsadasdsadasd', '2025-11-28', NULL, '13:30:00', NULL, 'Rejected', NULL, NULL, '2025-11-15 04:59:11', '2025-11-26 21:53:18', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 4, 1, 'Start Up Business', 'dasdasdsadasdsadasd', '2025-11-28', NULL, '13:30:00', NULL, 'Rejected', NULL, NULL, '2025-11-15 04:59:43', '2025-11-26 21:52:57', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 4, 2, 'IT', 'dvdsgasf', '2025-11-21', NULL, '13:30:00', NULL, 'Rejected', NULL, NULL, '2025-11-15 05:01:42', '2025-11-17 01:12:48', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 4, 3, 'Start Up Business', 'ADASCSGSDGSDGDSg', '2025-11-22', NULL, '10:30:00', NULL, 'Pending', NULL, NULL, '2025-11-15 05:27:27', '2025-11-15 05:27:27', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 7, 1, 'Start Up Business', 'mvchgcvjhvhjc', '2025-11-20', NULL, '07:11:00', NULL, 'Rejected', NULL, NULL, '2025-11-17 01:10:11', '2025-11-26 21:53:27', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 4, 6, 'Start Up Business', 'sjagdbuasjkndmlkasm knjaksmdojkabsndkllkoinuhj mkjjsjkln', '2025-11-24', NULL, '13:30:00', NULL, 'Pending', NULL, NULL, '2025-11-20 22:47:18', '2025-11-20 22:47:18', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 4, 4, 'IT', 'hbjnbhnj', '2025-11-24', NULL, '17:20:00', NULL, 'Pending', NULL, NULL, '2025-11-20 23:16:11', '2025-11-20 23:16:11', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 12, 4, 'Capstone', 'Need help for capstone project', '2025-11-30', NULL, '14:00:00', NULL, 'Pending', NULL, NULL, '2025-11-25 23:12:23', '2025-11-25 23:12:23', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 12, 2, 'Final Capstone Project', 'Need consult', '2025-11-29', NULL, '10:00:00', NULL, 'Completed', NULL, NULL, '2025-11-26 00:03:02', '2025-11-26 20:54:06', NULL, NULL, 'dsfsdgfsdfsd', 'sgfsdfsdfsdgdf', 4, NULL),
(17, 13, 1, 'Small Start Up Business', 'Tara laag lods\n\nConsultant message: Ok', '2025-11-29', NULL, '13:00:00', NULL, 'Rejected', NULL, NULL, '2025-11-26 21:18:43', '2025-11-26 21:27:19', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 13, 1, 'Small Start Up Business', 'wewww\n\nConsultant message: I\'m not available that time so i can Propose new schedule', '2025-11-29', NULL, '13:30:00', NULL, 'Proposed', NULL, 'pending', '2025-11-26 21:30:32', '2025-11-26 21:48:49', '2025-11-29', '14:30:00', NULL, NULL, NULL, NULL),
(19, 4, 1, 'Mid Start Up Business', 'wowww', '2025-11-29', NULL, '13:30:00', NULL, 'Rejected', NULL, NULL, '2025-11-26 21:31:36', '2025-11-26 21:53:12', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 13, 1, 'Start Up Business', 'asdsajalsdmnskadkjnaksdkjnkas\n\nConsultant message: heheheh', '2025-11-30', '2025-11-30', '13:50:00', '13:50:00', 'Completed', 'https://meet.google.com/a0c-c57-', NULL, '2025-11-26 21:51:03', '2025-11-26 21:54:09', NULL, NULL, 'asdjnaskldnoiaslkhdniokljamdlmasjdnjkmdoskandk n', 'iasnidokasniofknasiofljmsopalkdolasjmksanfkaj.mfkmbsanaksdjmaksmdnaskndsa', 5, NULL),
(21, 12, 9, 'IT Support', 'Wa ra gud', '2025-12-02', NULL, '10:30:00', NULL, 'Pending', NULL, NULL, '2025-12-01 05:22:34', '2025-12-01 05:22:34', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_notifications`
--

CREATE TABLE `consultation_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('reminder_24h','reminder_1h','proposal','status_change') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultation_notifications`
--

INSERT INTO `consultation_notifications` (`id`, `consultation_id`, `user_id`, `type`, `title`, `message`, `is_read`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 16, 12, 'status_change', 'Consultation Report Ready', 'Your consultation report for \'Final Capstone Project\' is now available for download.', 0, '2025-11-26 20:54:06', '2025-11-26 20:54:06', '2025-11-26 20:54:06'),
(2, 17, 13, 'status_change', 'Consultation Rejected', 'Your consultation request for \'Small Start Up Business\' has been rejected.\n\nReason: Ok', 0, '2025-11-26 21:27:19', '2025-11-26 21:27:19', '2025-11-26 21:27:19'),
(3, 18, 13, 'proposal', 'New Schedule Proposed', 'Consultant proposed a new schedule: Nov 29, 2025 at 2:30 PM\n\nMessage: I\'m not available that time so i can Propose new schedule', 0, '2025-11-26 21:48:49', '2025-11-26 21:48:49', '2025-11-26 21:48:49'),
(4, 20, 13, 'status_change', 'Consultation Accepted', 'Your consultation request for \'Start Up Business\' has been accepted. Scheduled for Nov 30, 2025 at 1:50 PM', 0, '2025-11-26 21:51:50', '2025-11-26 21:51:50', '2025-11-26 21:51:50'),
(5, 20, 13, 'status_change', 'Consultation Accepted', 'Your consultation request for \'Start Up Business\' has been accepted. Scheduled for Nov 30, 2025 at 1:50 PM', 0, '2025-11-26 21:52:16', '2025-11-26 21:52:16', '2025-11-26 21:52:16'),
(6, 9, 4, 'status_change', 'Consultation Rejected', 'Your consultation request for \'Start Up Business\' has been rejected.', 0, '2025-11-26 21:52:57', '2025-11-26 21:52:57', '2025-11-26 21:52:57'),
(7, 20, 13, 'status_change', 'Consultation Report Ready', 'Your consultation report for \'Start Up Business\' is now available for download.', 0, '2025-11-26 21:54:09', '2025-11-26 21:54:09', '2025-11-26 21:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_ratings`
--

CREATE TABLE `consultation_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `rater_id` bigint(20) UNSIGNED NOT NULL,
  `rater_type` enum('customer','consultant') NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 1,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultation_ratings`
--

INSERT INTO `consultation_ratings` (`id`, `consultation_id`, `rater_id`, `rater_type`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 16, 12, 'customer', 3, '3', '2025-11-26 20:56:59', '2025-11-26 20:56:59'),
(2, 20, 13, 'customer', 4, '4', '2025-11-26 21:55:59', '2025-11-26 21:55:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Error reading structure for table bizcon.failed_jobs: #1932 - Table &#039;bizcon.failed_jobs&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.failed_jobs: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`failed_jobs`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--
-- Error reading structure for table bizcon.feedback: #1932 - Table &#039;bizcon.feedback&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.feedback: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`feedback`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--
-- Error reading structure for table bizcon.jobs: #1932 - Table &#039;bizcon.jobs&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.jobs: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`jobs`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--
-- Error reading structure for table bizcon.job_batches: #1932 - Table &#039;bizcon.job_batches&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.job_batches: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`job_batches`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `was_successful` tinyint(1) NOT NULL DEFAULT 0,
  `reason` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `occurred_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `was_successful`, `reason`, `ip_address`, `user_agent`, `occurred_at`, `created_at`, `updated_at`) VALUES
(1, 'admin1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-13 00:12:04', '2025-11-13 00:12:04', '2025-11-13 00:12:04'),
(2, 'admin1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-13 00:13:49', '2025-11-13 00:13:49', '2025-11-13 00:13:49'),
(3, 'customer1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-13 00:24:28', '2025-11-13 00:24:28', '2025-11-13 00:24:28'),
(4, 'admin1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 22:44:23', '2025-11-16 22:44:23', '2025-11-16 22:44:23'),
(5, 'customer2@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 22:45:58', '2025-11-20 22:45:58', '2025-11-20 22:45:58'),
(6, 'consultant10@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 23:17:14', '2025-11-20 23:17:14', '2025-11-20 23:17:14'),
(7, 'consultant10@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 23:17:25', '2025-11-20 23:17:25', '2025-11-20 23:17:25'),
(8, 'consultant1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 23:01:42', '2025-11-25 23:01:42', '2025-11-25 23:01:42'),
(9, 'consultant1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 23:01:42', '2025-11-25 23:01:42', '2025-11-25 23:01:42'),
(10, 'consultant1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 23:01:43', '2025-11-25 23:01:43', '2025-11-25 23:01:43'),
(11, 'consultant10@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 20:42:34', '2025-11-26 20:42:34', '2025-11-26 20:42:34'),
(12, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:21:55', '2025-11-26 21:21:55', '2025-11-26 21:21:55'),
(13, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:22:06', '2025-11-26 21:22:06', '2025-11-26 21:22:06'),
(14, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:22:18', '2025-11-26 21:22:18', '2025-11-26 21:22:18'),
(15, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:22:38', '2025-11-26 21:22:38', '2025-11-26 21:22:38'),
(16, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:22:55', '2025-11-26 21:22:55', '2025-11-26 21:22:55'),
(17, 'clintconsult@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 21:23:11', '2025-11-26 21:23:11', '2025-11-26 21:23:11'),
(18, 'consultant1@gmail.com', 0, 'invalid_credentials', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 00:28:33', '2025-12-01 00:28:33', '2025-12-01 00:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--
-- Error reading structure for table bizcon.messages: #1932 - Table &#039;bizcon.messages&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.messages: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`messages`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_13_072403_create_login_attempts_table', 1),
(3, '2025_12_15_000000_add_advanced_features_to_consultations', 2),
(4, '2025_11_26_000000_add_schedule_fields_to_consultations_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `my_bookings`
--
-- Error reading structure for table bizcon.my_bookings: #1932 - Table &#039;bizcon.my_bookings&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.my_bookings: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`my_bookings`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--
-- Error reading structure for table bizcon.notifications: #1932 - Table &#039;bizcon.notifications&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.notifications: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`notifications`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--
-- Error reading structure for table bizcon.payments: #1932 - Table &#039;bizcon.payments&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.payments: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`payments`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9GSk4AjH6YcFoknWT3A1w7tqBHhhTBekfsi6crxG', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM2o3QjVuM29FRzZZOWJ0N1RrWUl0VVVRVmVHZUJNSnFOS2hMWUNCbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo4MDoiaHR0cDovL2xvY2FsaG9zdC9kYXNoYm9hcmQvQml6Y29uL3B1YmxpYy9jb25zdWx0YW50L2NvbnN1bHRhdGlvbnMvMTYvcmVwb3J0L3ZpZXciO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovL2xvY2FsaG9zdC9kYXNoYm9hcmQvQml6Y29uL3B1YmxpYy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764603959),
('O2aJHTv8BHIBL1zj6wRm6jgqtshxDpRybjzRhIuj', 15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR3RyN3lDekVrQng1Y3lXVVoxcXJ5Zzg2ODZ6bnR6Tmtoem1CNFVkMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzM6Imh0dHA6Ly9sb2NhbGhvc3QvZGFzaGJvYXJkL0JpemNvbi9wdWJsaWMvY29uc3VsdGFudC9jb25zdWx0YXRpb25zLzIxL29wZW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTt9', 1764595392);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'clintconsult', 'clintconsult@gmail.com', NULL, '$2y$12$vY03BFPOPrD2NG94ZINQDOYYxx7T6KbkdMTYRuG8A/q5/KmQ//xSK', 'Consultant', NULL, '2025-11-12 23:40:12', '2025-11-12 23:40:38'),
(2, 'Test Admin', 'admin1@gmail.com', '2025-11-13 00:15:41', '$2y$12$wvwfrrAqm0iL9M2M.9LAf.60bKyWeKFWhvuPXDRoBSyLEhMG1NKBa', 'Admin', 'WmEFSD0YapfGF4ScBZN92Zw0FR0hiqjvefXY6E1wdQgtOhv6Hva9FG0AY3dK', '2025-11-13 00:15:41', '2025-11-13 00:15:41'),
(3, 'consultant123', 'consultant1@gmail.com', NULL, '$2y$12$PjO6vWthjydobJU0dr4.1u0mLsIGVg80jF4n5tUdwRzvjEfjVx2qC', 'Consultant', NULL, '2025-11-13 00:19:03', '2025-11-13 00:19:29'),
(4, 'customer123', 'customer1@gmail.com', NULL, '$2y$12$TP.WIQvm60Y2dP9z5s3UOOtQvORpc8MEtdOJ3m0BqP0OhU0CuPtB6', 'Customer', NULL, '2025-11-13 00:23:46', '2025-11-13 00:31:52'),
(5, 'consultant2', 'consultant2@gmail.com', NULL, '$2y$12$VCykS2qKbfE//S7bGdTRJ.puacNxFMW8ijwow/S9VpUY7h6J45ew2', 'Consultant', NULL, '2025-11-13 04:52:39', '2025-11-13 04:52:55'),
(6, 'consultant10', 'consultant10@gmail.com', NULL, '$2y$12$SMDuSKpvWOsHOMjzFTopyeQe1IGUVvWf64VRf55bbFcgyp6YsDSYK', 'Consultant', NULL, '2025-11-16 22:34:45', '2025-11-16 22:34:58'),
(7, 'hubertcustomer', 'hubertcustomer@gmail.com', NULL, '$2y$12$JsR91J416S5SB/iqZlg7kuHwOe0omr8Vc72NpE5TGMvE.pDOJxdba', 'Customer', NULL, '2025-11-17 01:09:06', '2025-11-17 01:09:21'),
(8, 'Teo consult', 'teoconsult@gmail.com', NULL, '$2y$12$iE7.BEjugvd9FwuTzo89B.usUaJDYv0ZVoICO0yRavL62VuLZLqxi', 'Consultant', NULL, '2025-11-20 22:26:20', '2025-11-20 22:26:34'),
(9, 'anjo customer', 'anjocustomer@gmail.com', NULL, '$2y$12$uHfT8oWHd7of4h90bCeu0O2m1C1ebKP.aG8SfaUW1qWjpeWOV88F2', 'Customer', NULL, '2025-11-20 22:39:06', '2025-11-20 22:39:22'),
(10, 'anjo consult', 'anjoconsult@gmail.com', NULL, '$2y$12$O8gje.sDZ.OPuMc4K4eRKuu4bdZ066BPkRDaJItN55aCY3.7cbOEC', 'Consultant', NULL, '2025-11-20 22:42:02', '2025-11-20 22:43:34'),
(11, 'Hubert Consult', 'hubertconsult@gmail.com', NULL, '$2y$12$/w107r/GMU4ENvo8ZZUe5elm2FXpbQudF1LPxXwW.mVtDfLubmZkG', 'Consultant', NULL, '2025-11-20 22:54:27', '2025-11-20 22:54:41'),
(12, 'pael', 'pael@gmail.com', NULL, '$2y$12$piIpNBhKFxcyWjyRRC/CVeGcBTspf4v/v76hlQxUHXPqf7znlzOdu', 'Customer', NULL, '2025-11-25 23:10:40', '2025-11-25 23:14:22'),
(13, 'Jen01', 'jenjen@gmail.com', NULL, '$2y$12$.BKZXIo8vX.L/ABDDSMwo.enAt13QGeVQeHnWIc8pQVDDuqHrlozG', 'Customer', NULL, '2025-11-26 21:14:41', '2025-11-26 21:14:56'),
(14, 'bahan', 'bahan@gmail.com', NULL, '$2y$12$o/8tNQYvT6hEaRjC7np.gufh18RAHoUxr6gP/X2EOiXPPb0xckjfq', 'Consultant', NULL, '2025-12-01 00:52:16', '2025-12-01 00:52:34'),
(15, 'allen', 'allen@gmail.com', NULL, '$2y$12$jQvWzsaMMxcGEKWObD1brel0YsBAQ3cpRVeLxmYR/8lAYIDGxR/zi', 'Consultant', NULL, '2025-12-01 01:50:48', '2025-12-01 01:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--
-- Error reading structure for table bizcon.verifications: #1932 - Table &#039;bizcon.verifications&#039; doesn&#039;t exist in engine
-- Error reading data for table bizcon.verifications: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `bizcon`.`verifications`&#039; at line 1

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_customer_id_foreign` (`customer_id`),
  ADD KEY `consultations_consultant_profile_id_foreign` (`consultant_profile_id`);

--
-- Indexes for table `consultation_notifications`
--
ALTER TABLE `consultation_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultation_notifications_consultation_id_foreign` (`consultation_id`),
  ADD KEY `consultation_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `consultation_ratings`
--
ALTER TABLE `consultation_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consultation_ratings_consultation_id_rater_id_rater_type_unique` (`consultation_id`,`rater_id`,`rater_type`),
  ADD KEY `consultation_ratings_rater_id_foreign` (`rater_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_attempts_email_index` (`email`),
  ADD KEY `login_attempts_was_successful_index` (`was_successful`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `consultation_notifications`
--
ALTER TABLE `consultation_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consultation_ratings`
--
ALTER TABLE `consultation_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  ADD CONSTRAINT `consultant_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_consultant_profile_id_foreign` FOREIGN KEY (`consultant_profile_id`) REFERENCES `consultant_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultation_notifications`
--
ALTER TABLE `consultation_notifications`
  ADD CONSTRAINT `consultation_notifications_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultation_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultation_ratings`
--
ALTER TABLE `consultation_ratings`
  ADD CONSTRAINT `consultation_ratings_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultation_ratings_rater_id_foreign` FOREIGN KEY (`rater_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
