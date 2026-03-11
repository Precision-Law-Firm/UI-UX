-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2026 at 06:38 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u662658788_plf_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `content`, `image_url`) VALUES
(1, 'From Attorney General\'s Office to Strategic Private Practice', 'Precision Law Firm was founded by Mr. Jelend Chowrimootoo, Attorney-at-Law and former Senior State Attorney at the Attorney General\'s Office of Mauritius. His career spans both distinguished public service and private legal practice.', ''),
(2, 'Analytical Precision & Strategic Thinking', 'Known for his analytical precision, strategic thinking, and mastery of complex legal frameworks, he has built a reputation as a versatile practitioner capable of navigating demanding litigation, regulatory, and advisory matters with clarity and authority.', ''),
(3, 'Public Law Expertise', 'His tenure in public service strengthened his command of public law, statutory interpretation, and the procedural intricacies of the Mauritian legal system, positioning him as a trusted legal advisor on matters involving governance, administrative fairness, and the rule of law.', '');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` varchar(50) NOT NULL,
  `consultation_type` varchar(100) NOT NULL,
  `attorney_preference` varchar(100) DEFAULT NULL,
  `case_description` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `first_name`, `last_name`, `email`, `phone`, `appointment_date`, `appointment_time`, `consultation_type`, `attorney_preference`, `case_description`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Karen', 'Andriantasy', 'kar3nmitia@gmail.com', '57656260', '2026-02-27', '14:00', 'in-person', 'family', 'test', 'confirmed', '2026-02-27 11:49:34', '2026-02-27 11:50:07'),
(8, 'Karen', 'Andriantasy', 'kar3nmitia@gmail.com', '57656260', '2026-03-01', '12:00', 'phone', 'general', 'test', 'pending', '2026-03-01 12:29:46', '2026-03-01 12:29:46'),
(9, 'Karen', 'Andriantasy', 'kar3nmitia@gmail.com', '57656260', '2026-03-01', '14:00', 'video', 'property', 'test', 'pending', '2026-03-01 12:37:41', '2026-03-01 12:37:41'),
(10, 'Karen', 'Andriantasy', 'kar3nmitia@gmail.com', '57656260', '2026-03-02', '14:00', 'video', 'family', 'test', 'confirmed', '2026-03-02 07:29:19', '2026-03-02 07:30:00'),
(11, 'Nasser', 'Maudarbocus', 'maudar786@gmail.com', '57688110', '2026-03-12', '10:00', 'in-person', 'corporate', 'test', 'pending', '2026-03-02 07:49:46', '2026-03-02 07:49:46'),
(12, 'Jelend', 'Chowrimootoo', 'jelend90@live.com', '57508221', '2026-03-05', '10:00', 'in-person', 'Attornet-at-law (Avoué)', '', 'pending', '2026-03-03 13:10:38', '2026-03-03 13:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_features`
--

CREATE TABLE `appointment_features` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_features`
--

INSERT INTO `appointment_features` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'fa-calendar-check', 'Why Book With Us?', 'Flexible consultation options (in-person, video, phone)', 1, 1, '2026-02-18 09:57:26'),
(2, 'fa-check-circle', 'Experienced Attorneys', 'Experienced attorneys in specialized legal fields', 2, 1, '2026-02-18 09:57:26'),
(3, 'fa-check-circle', 'Confidential Communication', 'Confidential and secure client-attorney communication', 3, 1, '2026-02-18 09:57:26'),
(4, 'fa-check-circle', 'Transparent Pricing', 'Transparent pricing with no hidden fees', 4, 1, '2026-02-18 09:57:26'),
(5, 'fa-check-circle', 'Quick Confirmation', '24-hour appointment confirmation guarantee', 5, 1, '2026-02-18 09:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_hero`
--

CREATE TABLE `appointment_hero` (
  `id` int(11) NOT NULL,
  `badge_text` varchar(255) NOT NULL,
  `title_line1` varchar(255) NOT NULL,
  `title_line2` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_hero`
--

INSERT INTO `appointment_hero` (`id`, `badge_text`, `title_line1`, `title_line2`, `description`, `background_image`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'Book Your Consultation', 'Expert Legal', 'Consultation', 'Schedule a personalised consultation with our experienced attorneys. Your first step towards legal resolution starts here.', 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', '214-4607', '2026-02-18 09:57:26', '2026-03-03 14:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_info_cards`
--

CREATE TABLE `appointment_info_cards` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_info_cards`
--

INSERT INTO `appointment_info_cards` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'fa-shield-alt', 'Confidentiality Guaranteed', 'All consultations are protected by attorney-client privilege and strict confidentiality protocols.', 1, 1, '2026-02-18 09:57:26'),
(2, 'fa-clock', 'Flexible Scheduling', 'We offer appointments during extended hours, including Saturdays, to accommodate your schedule.', 2, 1, '2026-02-18 09:57:26'),
(3, 'fa-file-contract', 'No Obligation Consultation', 'Initial consultations carry no obligation to retain our services. Get expert advice first.', 3, 1, '2026-02-18 09:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_steps`
--

CREATE TABLE `appointment_steps` (
  `id` int(11) NOT NULL,
  `step_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_steps`
--

INSERT INTO `appointment_steps` (`id`, `step_number`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 1, 'Personal Information', 'Provide your contact details so we can reach you for confirmation.', 1, 1, '2026-02-18 09:57:26'),
(2, 2, 'Select Date & Time', 'Choose your preferred consultation date and available time slot.', 2, 1, '2026-02-18 09:57:26'),
(3, 3, 'Consultation Details', 'Specify the type of consultation and attorney preference.', 3, 1, '2026-02-18 09:57:26'),
(4, 4, 'Confirmation', 'Review and submit your appointment. We\'ll confirm within 24 hours.', 4, 1, '2026-02-18 09:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `approach_content`
--

CREATE TABLE `approach_content` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approach_content`
--

INSERT INTO `approach_content` (`id`, `content`, `sort_order`, `created_at`) VALUES
(1, '<strong>Commercial thinking</strong> is at the heart of our approach. We take the time to understand the commercial rationale of every assignment, whether it\'s a transaction, dispute, or regulatory matter.', 1, '2026-02-18 08:13:32'),
(2, 'We analyze and discuss with our clients the possible means to achieve their objectives, leveraging our unique government experience to anticipate challenges and opportunities.', 2, '2026-02-18 08:13:32'),
(3, 'We agree with clients on clear timelines for delivery and adopt a transparent pricing policy so that legal costs are predictable from the outset.', 3, '2026-02-18 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `approach_features`
--

CREATE TABLE `approach_features` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approach_features`
--

INSERT INTO `approach_features` (`id`, `icon`, `title`, `description`, `sort_order`, `created_at`) VALUES
(1, 'fa-search', 'Analytical Precision', 'Meticulous attention to legal detail and strategic implications', 1, '2026-02-18 08:13:32'),
(2, 'fa-university', 'Government Insight', 'Unique perspective from former State Attorney experience', 2, '2026-02-18 08:13:32'),
(3, 'fa-handshake', 'Client Partnership', 'Collaborative approach focused on your business objectives', 3, '2026-02-18 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `attorneys`
--

CREATE TABLE `attorneys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `value` varchar(100) NOT NULL,
  `available` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attorneys`
--

INSERT INTO `attorneys` (`id`, `name`, `specialization`, `value`, `available`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Me Jelend Chowrimootoo', 'Attorney-at-law (Avoué)', 'general', 1, 1, 1, '2026-02-18 09:57:26'),
(2, 'Me Jelend Chowrimootoo', 'Corporate Law', 'corporate', 1, 2, 1, '2026-02-18 09:57:26'),
(3, 'Me Jelend Chowrimootoo', 'Family Law', 'family', 1, 3, 1, '2026-02-18 09:57:26'),
(4, 'Me Jelend Chowrimootoo', 'Property Law', 'property', 1, 4, 1, '2026-02-18 09:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `booked_slots`
--

CREATE TABLE `booked_slots` (
  `id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_slots`
--

INSERT INTO `booked_slots` (`id`, `appointment_date`, `time_slot`, `appointment_id`) VALUES
(1, '2026-02-27', '11:00', NULL),
(2, '2026-02-27', '16:00', NULL),
(3, '2026-02-28', '12:00', NULL),
(4, '2026-02-28', '14:00', NULL),
(5, '2026-02-27', '14:00', NULL),
(6, '2026-03-01', '12:00', NULL),
(7, '2026-03-01', '14:00', NULL),
(8, '2026-03-02', '14:00', NULL),
(9, '2026-03-12', '10:00', NULL),
(10, '2026-03-05', '10:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `career_applications`
--

CREATE TABLE `career_applications` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `cover_letter` text NOT NULL,
  `resume_path` varchar(500) DEFAULT NULL,
  `status` enum('pending','reviewed','interviewed','rejected','hired') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_applications`
--

INSERT INTO `career_applications` (`id`, `full_name`, `email`, `phone`, `position`, `cover_letter`, `resume_path`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'legal-intern', 'test', 'components/cv/69a1855405dd5_cv.pdf', '', '2026-02-27 11:51:48', '2026-02-27 11:52:18'),
(11, 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'legal-intern', 'test', 'components/cv/69a437906264e_cv.pdf', 'pending', '2026-03-01 12:56:48', '2026-03-01 12:56:48'),
(12, 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'legal-intern', 'test', 'components/cv/69a4485f5743c_cv.pdf', 'pending', '2026-03-01 14:08:31', '2026-03-01 14:08:31'),
(13, 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'legal-intern', 'test', 'components/cv/69a53e51eff57_cv.pdf', 'pending', '2026-03-02 07:37:54', '2026-03-02 07:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `career_positions`
--

CREATE TABLE `career_positions` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_positions`
--

INSERT INTO `career_positions` (`id`, `value`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'associate-attorney', 'Associate Attorney', 'Join our team as an Associate Attorney', 1, 1, '2026-02-18 10:04:50'),
(2, 'attorney-clerk', 'Attorney\'s Clerk', 'Legal support position for attorneys', 2, 1, '2026-02-18 10:04:50'),
(3, 'legal-intern', 'Legal Intern', 'Internship opportunity for law students', 3, 1, '2026-02-18 10:04:50'),
(4, 'other', 'Other Position', 'Other career opportunities', 4, 1, '2026-02-18 10:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `chat_responses`
--

CREATE TABLE `chat_responses` (
  `id` int(11) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `response` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_responses`
--

INSERT INTO `chat_responses` (`id`, `keyword`, `response`, `sort_order`, `is_active`) VALUES
(1, 'contact', 'You can contact us at: Phone: 214-4607 | Email: LawfirmPrecision@outlook.com', 1, 1),
(2, 'phone', 'Our phone number is: 214-4607', 2, 1),
(3, 'hour', 'Our office hours are: Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM.', 3, 1),
(4, 'time', 'Our office hours are: Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM.', 4, 1),
(5, 'career', 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.', 5, 1),
(6, 'job', 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.', 6, 1),
(7, 'apply', 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.', 7, 1),
(8, 'location', 'We\'re located at: 7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius.', 8, 1),
(9, 'address', 'We\'re located at: 7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius.', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_types`
--

CREATE TABLE `consultation_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_types`
--

INSERT INTO `consultation_types` (`id`, `name`, `value`, `description`, `sort_order`, `is_active`) VALUES
(1, 'In-person at Office', 'in-person', 'Meet face-to-face with our attorneys at our office', 1, 1),
(2, 'Video Conference', 'video', 'Remote consultation via video call (Zoom/Teams)', 2, 1),
(3, 'Phone Call', 'phone', 'Consultation by phone at your convenience', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_cards`
--

CREATE TABLE `contact_cards` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `additional_info` text DEFAULT NULL,
  `action_text` varchar(255) DEFAULT NULL,
  `action_link` varchar(500) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_cards`
--

INSERT INTO `contact_cards` (`id`, `icon`, `title`, `content`, `additional_info`, `action_text`, `action_link`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'fa-map-marker-alt', 'Our Office', '7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius', NULL, 'Get Directions', '#', 1, 1, '2026-02-18 10:04:50'),
(2, 'fa-phone-alt', 'Contact Details', '', 'Phone: 214-4607, Email: LawfirmPrecision@outlook.com', NULL, NULL, 2, 1, '2026-02-18 10:04:50'),
(3, 'fa-headset', 'Quick Support', 'Need immediate assistance? Our support team is available during business hours to help with your inquiries.', NULL, 'Live Chat Support', '#', 3, 1, '2026-02-18 10:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `contact_hero`
--

CREATE TABLE `contact_hero` (
  `id` int(11) NOT NULL,
  `title_line1` varchar(255) NOT NULL,
  `title_line2` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_hero`
--

INSERT INTO `contact_hero` (`id`, `title_line1`, `title_line2`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Contact Us &', 'Careers', 'Get in touch with our legal experts or explore career opportunities at Precision Law Firm.', '2026-02-18 10:04:50', '2026-02-18 10:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `duration_weeks` int(11) DEFAULT NULL,
  `duration_text` varchar(100) DEFAULT NULL,
  `price_rs` decimal(10,2) DEFAULT NULL,
  `instructor_name` varchar(255) DEFAULT NULL,
  `instructor_title` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `level_id`, `duration_weeks`, `duration_text`, `price_rs`, `instructor_name`, `instructor_title`, `start_date`, `icon`, `features`, `category`, `featured`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Introduction to Mauritian Law', '', 1, 8, '', 0.00, '', NULL, NULL, '', '', 'beginner', 1, 1, 1, '2026-02-18 09:29:30', '2026-03-02 08:14:58'),
(2, 'Corporate Law Essentials', '', 2, 12, '', 0.00, '', NULL, NULL, '', '', 'advanced', 1, 2, 1, '2026-02-18 09:29:30', '2026-03-02 08:08:40'),
(3, 'An Overview of Mauritian Constitutional Law', '', 3, 0, '', 8500.00, '', NULL, NULL, '', '', 'workshop', 1, 3, 1, '2026-02-18 09:29:30', '2026-03-02 08:15:50'),
(4, 'Civil Procedure : different modes of execution of judgement', '', 1, 6, '', 10500.00, '', NULL, NULL, '', '', 'beginner', 1, 4, 1, '2026-02-18 09:29:30', '2026-03-02 08:16:57'),
(5, 'Law of Evidence', '', 2, 10, '', 16000.00, '', NULL, NULL, '', '', 'advanced', 1, 5, 1, '2026-02-18 09:29:30', '2026-03-02 08:17:19'),
(6, 'Criminal Procedure : Principles of sentencing', '', 3, 0, '', 4500.00, '', NULL, NULL, '', '', 'workshop', 1, 6, 1, '2026-02-18 09:29:30', '2026-03-02 08:18:01'),
(7, 'Insolvency Law Winiding Up & Bankruptcy', '', 2, NULL, '', 10000.00, '', NULL, NULL, '', '', 'Advanced', 1, 7, 1, '2026-02-19 07:50:07', '2026-03-02 08:18:51');

-- --------------------------------------------------------

--
-- Table structure for table `courses_hero`
--

CREATE TABLE `courses_hero` (
  `id` int(11) NOT NULL,
  `title_line1` varchar(255) NOT NULL,
  `title_line2` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `primary_button_text` varchar(100) DEFAULT NULL,
  `primary_button_link` varchar(500) DEFAULT NULL,
  `secondary_button_text` varchar(100) DEFAULT NULL,
  `secondary_button_link` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses_hero`
--

INSERT INTO `courses_hero` (`id`, `title_line1`, `title_line2`, `subtitle`, `background_image`, `primary_button_text`, `primary_button_link`, `secondary_button_text`, `secondary_button_link`, `created_at`, `updated_at`) VALUES
(1, 'Continuous Learning Legal Education', 'for Professionals', 'Bridging theory with practice. Join our specialized legal courses designed for law students and aspiring legal professionals.', '../components/img/bg-try.png', 'Explore Courses', '#courses', 'Why Join Our Program?', '#why-join', '2026-02-18 09:29:30', '2026-02-19 09:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `course_benefits`
--

CREATE TABLE `course_benefits` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_benefits`
--

INSERT INTO `course_benefits` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'fa-user-tie', 'Expert Instructors', 'Learn from practicing attorneys who handle real cases daily. Get insights you won\'t find in textbooks.', 1, 1, '2026-02-18 09:29:30'),
(2, 'fa-hands-helping', 'Practical Skills', 'Master practical legal skills: drafting, negotiation, research, and courtroom procedures.', 2, 1, '2026-02-18 09:29:30'),
(3, 'fa-network-wired', 'Career Networking', 'Connect with legal professionals and build relationships that can launch your career.', 3, 1, '2026-02-18 09:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `course_features`
--

CREATE TABLE `course_features` (
  `id` int(11) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_features`
--

INSERT INTO `course_features` (`id`, `feature`, `sort_order`, `is_active`) VALUES
(1, 'Interactive online sessions', 1, 1),
(2, 'Real case studies', 2, 1),
(3, 'Personal feedback from instructors', 3, 1),
(4, 'Certificate of completion', 4, 1),
(5, 'Access to course materials for 1 year', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_levels`
--

CREATE TABLE `course_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `color` varchar(50) DEFAULT 'blue',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_levels`
--

INSERT INTO `course_levels` (`id`, `name`, `slug`, `color`, `sort_order`, `is_active`) VALUES
(1, 'Beginner', 'beginner', 'blue', 1, 1),
(2, 'Advanced', 'advanced', 'purple', 2, 1),
(3, 'Workshop', 'workshop', 'green', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_modules`
--

CREATE TABLE `course_modules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_modules`
--

INSERT INTO `course_modules` (`id`, `title`, `description`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'Legal Research Skills', 'Master online databases, case law research, and legal citation methods.', 'fa-search', 1, 1),
(2, 'Drafting & Documentation', 'Learn to draft legal documents, contracts, and court submissions professionally.', 'fa-file-alt', 2, 1),
(3, 'Courtroom Procedures', 'Understand courtroom etiquette, filing procedures, and advocacy techniques.', 'fa-gavel', 3, 1),
(4, 'Client Management', 'Develop skills for client interviews, communication, and case management.', 'fa-handshake', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_stats`
--

CREATE TABLE `course_stats` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` varchar(50) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_stats`
--

INSERT INTO `course_stats` (`id`, `label`, `value`, `icon`, `sort_order`) VALUES
(1, 'Hours of Content', '20+', 'fa-clock', 1),
(2, 'Practical Exercises', '100%', 'fa-check-circle', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cta_section`
--

CREATE TABLE `cta_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_link` varchar(500) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cta_section`
--

INSERT INTO `cta_section` (`id`, `title`, `description`, `button_text`, `button_link`, `is_active`, `updated_at`) VALUES
(1, 'Ready to discuss your legal needs?', 'Contact us for strategic legal advice from attorneys with government-level expertise and commercial insight.', 'Contact Our Team', 'contact.php', 1, '2026-02-18 10:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `application_code` varchar(20) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `student_email` varchar(150) NOT NULL,
  `student_phone` varchar(50) NOT NULL,
  `student_background` text NOT NULL,
  `additional_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `application_code`, `course_id`, `course_name`, `student_name`, `student_email`, `student_phone`, `student_background`, `additional_info`, `created_at`) VALUES
(3, 'STU-94EC', 1, 'Introduction to Legal Practice', 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'test', 'test', '2026-02-27 06:07:40'),
(4, 'STU-3A76', 1, 'Introduction to Legal Practice', 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'test', 'test', '2026-03-01 12:11:55'),
(5, 'STU-6271', 3, 'Courtroom Advocacy Workshop', 'Karen Andriantasy', 'kar3nmitia@gmail.com', '57656260', 'test', 'test', '2026-03-02 07:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_areas`
--

CREATE TABLE `expertise_areas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expertise_areas`
--

INSERT INTO `expertise_areas` (`id`, `name`, `description`) VALUES
(1, 'Civil Law', 'Civil, Commercial & Regulatory Law'),
(2, 'Commercial Law', 'Civil, Commercial & Regulatory Law'),
(3, 'Regulatory Law', 'Civil, Commercial & Regulatory Law'),
(4, 'Test', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_categories`
--

CREATE TABLE `expertise_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expertise_categories`
--

INSERT INTO `expertise_categories` (`id`, `title`, `description`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Litigation & Dispute Resolution', NULL, 'fa-gavel', 1, 1, '2026-02-18 08:40:51'),
(2, 'Corporate & Commercial Law', 'Comprehensive legal services for businesses, from formation to complex commercial transactions.', 'fa-building', 2, 1, '2026-02-18 08:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_cta`
--

CREATE TABLE `expertise_cta` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `primary_button_text` varchar(100) NOT NULL,
  `primary_button_link` varchar(500) NOT NULL,
  `secondary_button_text` varchar(100) DEFAULT NULL,
  `secondary_button_link` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expertise_cta`
--

INSERT INTO `expertise_cta` (`id`, `title`, `description`, `primary_button_text`, `primary_button_link`, `secondary_button_text`, `secondary_button_link`, `is_active`, `updated_at`) VALUES
(1, 'Need Specialized Legal Assistance?', 'Contact us to discuss how our expertise can help with your specific legal requirements.', 'Contact Our Team', 'contact.php', 'Meet Our Experts', 'team.php', 1, '2026-02-18 08:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_hero`
--

CREATE TABLE `expertise_hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expertise_hero`
--

INSERT INTO `expertise_hero` (`id`, `title`, `subtitle`, `background_image`, `created_at`, `updated_at`) VALUES
(1, 'OUR EXPERTISE', 'Comprehensive legal services across diverse practice areas, combining deep Mauritian legal knowledge with strategic commercial insight.', '../components/img/bg-try.png', '2026-02-18 08:40:51', '2026-03-04 04:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `founder`
--

CREATE TABLE `founder` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `former_position` varchar(500) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `cases_handled` int(11) DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `photo_url` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `founder`
--

INSERT INTO `founder` (`id`, `name`, `title`, `description`, `former_position`, `experience_years`, `cases_handled`, `initials`, `photo_url`, `bio`, `is_active`, `sort_order`, `created_at`) VALUES
(1, 'Me Jelend Chowrimootoo', 'Founder & Managing Director', 'Former Senior State Attorney with extensive experience in civil, commercial and constitutional litigation.', 'Former Senior State Attorney, Attorney General\'s Office', 8, 150, 'MJC', '../components/img/profile.jpg', 'Me Jelend Chowrimootoo founded Precision Law Firm after a distinguished career as Senior State Attorney at the Attorney General\'s Office of Mauritius. His government experience brings unique insight to private practice, particularly in matters involving public law, statutory interpretation, and complex litigation.', 1, 0, '2026-02-18 08:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `hero`
--

CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button_label` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`id`, `title`, `subtitle`, `description`, `button_label`, `button_link`, `image_url`) VALUES
(1, 'Professional  Legal  Attorneys', 'with commercial foresight', '\r\nWe help businesses resolve disputes, secure deals, and navigate risk through clear thinking, agile action, and strategic precision.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `icon_color` varchar(50) DEFAULT 'blue',
  `specialties` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `title`, `specialization`, `experience_years`, `bio`, `icon_color`, `specialties`, `sort_order`, `is_active`, `created_at`) VALUES
(4, 'Me. Jelend Chowrimootoo', 'Attorney-at-Law/Solicitor(Avoué)', NULL, NULL, NULL, 'blue', NULL, 0, 1, '2026-03-02 08:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_cases`
--

CREATE TABLE `jurisprudence_cases` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `case_number` varchar(100) DEFAULT NULL,
  `court` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `duration_months` int(11) DEFAULT NULL,
  `lead_attorney` varchar(255) DEFAULT NULL,
  `lead_attorney_initials` varchar(10) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `summary` text NOT NULL,
  `key_issues` text DEFAULT NULL,
  `outcome` text DEFAULT NULL,
  `impact` text DEFAULT NULL,
  `icon_color` varchar(50) DEFAULT 'blue',
  `featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_cases`
--

INSERT INTO `jurisprudence_cases` (`id`, `title`, `case_number`, `court`, `year`, `duration_months`, `lead_attorney`, `lead_attorney_initials`, `category_id`, `summary`, `key_issues`, `outcome`, `impact`, `icon_color`, `featured`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Republic v. Civil Liberties Union', NULL, NULL, 2022, NULL, NULL, 'MC', 2, '', NULL, NULL, NULL, 'blue', 0, 2, 0, '2026-02-18 08:52:16', '2026-03-03 12:53:49'),
(3, 'Smith v. Global Tech Solutions', NULL, NULL, 2023, NULL, NULL, 'PR', 4, '', NULL, NULL, NULL, 'blue', 0, 3, 0, '2026-02-18 08:52:16', '2026-03-03 12:55:25'),
(4, 'Mauritius Telecom v. Consumer Council', NULL, NULL, 2022, NULL, NULL, 'JD', 1, '', NULL, NULL, NULL, 'blue', 0, 4, 0, '2026-02-18 08:52:16', '2026-03-03 12:52:08'),
(5, 'Port Louis Development v. City Council', NULL, NULL, 2021, NULL, NULL, 'PL', 5, '', NULL, NULL, NULL, 'blue', 0, 5, 0, '2026-02-18 08:52:16', '2026-03-03 12:51:45'),
(6, 'Find below Landmark Cases', NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'blue', 0, 6, 1, '2026-03-03 12:59:24', '2026-03-03 13:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_categories`
--

CREATE TABLE `jurisprudence_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_categories`
--

INSERT INTO `jurisprudence_categories` (`id`, `name`, `slug`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Commercial Law', 'commercial', 'fa-briefcase', 1, 1, '2026-02-18 08:52:16'),
(2, 'Constitutional Law', 'constitutional', 'fa-landmark', 2, 1, '2026-02-18 08:52:16'),
(3, 'Civil Litigation', 'civil', 'fa-balance-scale', 3, 1, '2026-02-18 08:52:16'),
(4, 'Employment Law', 'employment', 'fa-users', 4, 1, '2026-02-18 08:52:16'),
(5, 'Property Law', 'property', 'fa-home', 5, 1, '2026-02-18 08:52:16'),
(6, 'Corporate Law', 'corporate', 'fa-building', 6, 1, '2026-02-18 08:52:16'),
(7, 'Banking Law', 'banking', 'fa-university', 7, 1, '2026-02-18 08:52:16'),
(8, 'Human Rights', 'human-rights', 'fa-heart', 8, 1, '2026-02-18 08:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_cta`
--

CREATE TABLE `jurisprudence_cta` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `primary_button_text` varchar(100) NOT NULL,
  `primary_button_link` varchar(500) NOT NULL,
  `secondary_button_text` varchar(100) DEFAULT NULL,
  `secondary_button_link` varchar(500) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_cta`
--

INSERT INTO `jurisprudence_cta` (`id`, `title`, `description`, `primary_button_text`, `primary_button_link`, `secondary_button_text`, `secondary_button_link`, `phone_number`, `is_active`, `updated_at`) VALUES
(1, 'Ready to Build Your Case Strategy?', 'Our proven track record in landmark cases demonstrates our ability to develop winning strategies for complex legal challenges.', 'Schedule Consultation', 'contact.php', 'Call Us', 'tel:+2302144607', '+230 214 4607', 1, '2026-02-18 08:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_hero`
--

CREATE TABLE `jurisprudence_hero` (
  `id` int(11) NOT NULL,
  `badge_text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_hero`
--

INSERT INTO `jurisprudence_hero` (`id`, `badge_text`, `title`, `subtitle`, `background_image`, `created_at`, `updated_at`) VALUES
(1, 'Landmark Cases', 'Our Jurisprudence', 'Discover landmark cases and significant legal precedents handled by our firm. Each case represents our commitment to excellence in legal strategy and advocacy.', '../components/img/bg-try.png', '2026-02-18 08:52:16', '2026-02-18 10:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_stats`
--

CREATE TABLE `jurisprudence_stats` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT '',
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_stats`
--

INSERT INTO `jurisprudence_stats` (`id`, `label`, `value`, `suffix`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Cases Handled', '150', '+', 'fa-gavel', 1, 1, '2026-02-18 08:52:16'),
(2, 'Success Rate', '95', '%', 'fa-chart-line', 2, 1, '2026-02-18 08:52:16'),
(3, 'Years Experience', '8', '+', 'fa-calendar-alt', 3, 1, '2026-02-18 08:52:16'),
(4, 'Landmark Precedents', '12', '+', 'fa-star', 4, 1, '2026-02-18 08:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `jurisprudence_timeline`
--

CREATE TABLE `jurisprudence_timeline` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT 'blue',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurisprudence_timeline`
--

INSERT INTO `jurisprudence_timeline` (`id`, `year`, `title`, `description`, `icon`, `color`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 2023, 'Digital Banking Precedent', 'Established new standards for consumer protection in digital transactions', 'fa-mobile-alt', 'blue', 1, 1, '2026-02-18 08:52:16'),
(2, 2022, 'Free Speech Expansion', 'Redefined constitutional protections for digital expression', 'fa-comments', 'purple', 2, 1, '2026-02-18 08:52:16'),
(3, 2021, 'Workplace Rights Milestone', 'Set new standards for employment discrimination cases', 'fa-briefcase', 'orange', 3, 1, '2026-02-18 08:52:16'),
(4, 2020, 'Property Rights Victory', 'Enhanced compensation standards for land acquisition', 'fa-home', 'red', 4, 1, '2026-02-18 08:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `office_hours`
--

CREATE TABLE `office_hours` (
  `id` int(11) NOT NULL,
  `day_range` varchar(100) NOT NULL,
  `hours` varchar(100) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_hours`
--

INSERT INTO `office_hours` (`id`, `day_range`, `hours`, `sort_order`, `is_active`) VALUES
(1, 'Mon-Fri', '9AM-5PM', 1, 1),
(2, 'Sat', '9AM-1PM', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `overview_description`
--

CREATE TABLE `overview_description` (
  `id` int(11) NOT NULL,
  `paragraph` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overview_description`
--

INSERT INTO `overview_description` (`id`, `paragraph`, `sort_order`, `created_at`) VALUES
(1, 'Precision Law Firm is a well established Law Firm which delivers legal advice with precision. We act for local and international clients across various sectors, combining deep legal knowledge with strategic commercial insight.', 1, '2026-02-18 08:13:32'),
(2, 'Founded by a former Senior State Attorney, our firm brings unique government experience to private practice, ensuring comprehensive legal solutions tailored to our clients\' specific needs.', 2, '2026-02-18 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `overview_hero`
--

CREATE TABLE `overview_hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overview_hero`
--

INSERT INTO `overview_hero` (`id`, `title`, `background_image`, `created_at`, `updated_at`) VALUES
(1, 'OVERVIEW', '../components/img/bg-try.png', '2026-02-18 08:13:32', '2026-02-18 10:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `practice_areas`
--

CREATE TABLE `practice_areas` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practice_areas`
--

INSERT INTO `practice_areas` (`id`, `icon`, `title`, `description`, `sort_order`, `created_at`) VALUES
(1, 'fa-gavel', 'Commercial Litigation', 'Strategic dispute resolution across Mauritian courts', 1, '2026-02-18 08:13:32'),
(2, 'fa-lightbulb', 'Intellectual Property', 'Industrial Property Act 2019 expertise', 2, '2026-02-18 08:13:32'),
(3, 'fa-briefcase', 'Employment Law', 'Workers\' Rights Act compliance & disputes', 3, '2026-02-18 08:13:32'),
(4, 'fa-chart-line', 'Financial Services', 'Regulatory compliance & advisory', 4, '2026-02-18 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `practice_areas_expertise`
--

CREATE TABLE `practice_areas_expertise` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practice_areas_expertise`
--

INSERT INTO `practice_areas_expertise` (`id`, `category_id`, `title`, `icon`, `description`, `features`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 1, 'Civil & Commercial Litigation', 'fa-gavel', 'Contract disputes and breach of contract matters, Tort claims and negligence cases, Debt recovery and enforcement proceedings', 'Contract disputes and breach of contract matters,Tort claims and negligence cases,Debt recovery and enforcement proceedings', 1, 1, '2026-02-18 08:40:51'),
(2, 1, 'Administrative & Constitutional Law', 'fa-balance-scale', 'Judicial review of administrative decisions, Constitutional rights protection, Public law disputes and remedies', 'Judicial review of administrative decisions,Constitutional rights protection,Public law disputes and remedies', 2, 1, '2026-02-18 08:40:51'),
(3, 1, 'Alternative Dispute Resolution', 'fa-handshake', 'Mediation and negotiation services, Arbitration under International Arbitration Act 2008, Domestic arbitration procedures', 'Mediation and negotiation services,Arbitration under International Arbitration Act 2008,Domestic arbitration procedures', 3, 1, '2026-02-18 08:40:51'),
(4, 2, 'Business Formation & Compliance', 'fa-building', 'Company incorporation and registration, Corporate governance and compliance, Shareholder agreements and disputes', 'Company incorporation and registration,Corporate governance and compliance,Shareholder agreements and disputes', 1, 1, '2026-02-18 08:40:51'),
(5, 2, 'Commercial Contracts', 'fa-file-contract', 'Drafting and review of commercial agreements, Distribution, agency, and franchise agreements, Joint ventures and partnerships', 'Drafting and review of commercial agreements,Distribution, agency, and franchise agreements,Joint ventures and partnerships', 2, 1, '2026-02-18 08:40:51'),
(6, 2, 'Financial Services Regulation', 'fa-chart-line', 'Compliance with Financial Services Act 2007, Banking Act and Bank of Mauritius regulations, Anti-money laundering (FIAMLA) compliance', 'Compliance with Financial Services Act 2007,Banking Act and Bank of Mauritius regulations,Anti-money laundering (FIAMLA) compliance', 3, 1, '2026-02-18 08:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `public_service`
--

CREATE TABLE `public_service` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `public_service`
--

INSERT INTO `public_service` (`id`, `title`, `description`, `icon`) VALUES
(1, 'Government Representation ', 'Civil, commercial, constitutional & administrative litigation before Supreme Court, Intermediate Court, and tribunals', 'fa-file-alt'),
(2, 'Legal Advisory', 'Drafting pleadings and legal opinions for ministries, statutory bodies, and government departments', 'fa-landmark'),
(3, 'Legislative Expertise', 'Advising on legislative interpretation, regulatory compliance, and public-sector risk management', 'fa-balance-scale');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `url` varchar(500) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `platform`, `icon`, `url`, `sort_order`, `is_active`) VALUES
(1, 'LinkedIn', 'fa-linkedin-in', '#', 1, 1),
(2, 'Twitter', 'fa-twitter', '#', 2, 1),
(3, 'Facebook', 'fa-facebook-f', '#', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `specialized_areas`
--

CREATE TABLE `specialized_areas` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialized_areas`
--

INSERT INTO `specialized_areas` (`id`, `title`, `description`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Intellectual Property', 'Industrial Property Act 2019 - Patents, Trademarks, Copyrights', 'fa-lightbulb', 1, 1, '2026-02-18 08:40:51'),
(2, 'Employment Law', 'Workers\' Rights Act 2019 compliance and disputes', 'fa-briefcase', 2, 1, '2026-02-18 08:40:51'),
(3, 'Real Estate Law', 'Property transactions, disputes, and ownership matters', 'fa-home', 3, 1, '2026-02-18 08:40:51'),
(4, 'Family Law', 'Divorce, custody, succession, and matrimonial property', 'fa-users', 4, 1, '2026-02-18 08:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `student_testimonials`
--

CREATE TABLE `student_testimonials` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_year` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `icon_color` varchar(50) DEFAULT 'blue',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_cta`
--

CREATE TABLE `team_cta` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_link` varchar(500) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_cta`
--

INSERT INTO `team_cta` (`id`, `title`, `description`, `button_text`, `button_link`, `is_active`, `updated_at`) VALUES
(1, 'Work with our Team', 'Benefit from legal counsel backed by government-level experience and strategic commercial insight.', 'Contact our Team', 'contact.php', 1, '2026-03-04 04:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `team_hero`
--

CREATE TABLE `team_hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `background_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_hero`
--

INSERT INTO `team_hero` (`id`, `title`, `subtitle`, `background_image`, `created_at`, `updated_at`) VALUES
(1, 'Our Team', 'Strategic legal professionals combining government expertise with commercial insight', '../components/img/bg-try.png', '2026-02-18 08:19:42', '2026-02-18 08:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'Legal Team',
  `initials` varchar(10) DEFAULT NULL,
  `photo_url` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `position`, `category`, `initials`, `photo_url`, `bio`, `email`, `phone`, `linkedin_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Me Jelend Chowrimootoo', 'Managing Director', 'Senior Associate', '', NULL, NULL, NULL, NULL, NULL, 1, 1, '2026-02-18 08:19:42', '2026-03-03 14:11:49'),
(2, 'Me Jelend Chowrimootoo', 'Founder Partner', 'Legal Counsel', '', NULL, NULL, NULL, NULL, NULL, 2, 1, '2026-02-18 08:19:42', '2026-03-03 14:10:27'),
(3, 'Me Jelend Chowrimootoo', 'Attorney-at-law (Avoué)', 'Associate Attorney', '', NULL, NULL, NULL, NULL, NULL, 3, 1, '2026-02-18 08:19:42', '2026-03-03 14:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `team_stats`
--

CREATE TABLE `team_stats` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `stat_text` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_stats`
--

INSERT INTO `team_stats` (`id`, `title`, `stat_text`, `description`, `icon`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Government', 'Former Senior State Attorney Experience', 'Direct experience representing the State of Mauritius', 'fa-gavel', 1, 1, '2026-02-18 08:19:42'),
(2, 'Strategic', 'Commercial Legal Insight', 'Practical solutions aligned with business objectives', 'fa-chart-line', 2, 1, '2026-02-18 08:19:42'),
(3, 'Versatile', 'Multi-Practice Expertise', 'Comprehensive legal services across diverse areas', 'fa-balance-scale', 3, 1, '2026-02-18 08:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `text` text DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `time_value` varchar(50) NOT NULL,
  `display_time` varchar(50) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `time_value`, `display_time`, `sort_order`, `is_active`) VALUES
(1, '09:00', '9:00 AM', 1, 1),
(2, '10:00', '10:00 AM', 2, 1),
(3, '11:00', '11:00 AM', 3, 1),
(4, '12:00', '12:00 PM', 4, 1),
(5, '13:00', '1:00 PM', 5, 1),
(6, '14:00', '2:00 PM', 6, 1),
(7, '15:00', '3:00 PM', 7, 1),
(8, '16:00', '4:00 PM', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(5, 'admin', 'lawfirmprecision@outlook.com', '$2y$10$OCYx/266HRxbvB.zKHtsJ.SNj/5S4pcUzIbqT8MqsviRN9cCgnmkG', '2026-03-01 14:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `what_we_do`
--

CREATE TABLE `what_we_do` (
  `id` int(11) NOT NULL,
  `column_number` int(11) DEFAULT 1,
  `content` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `what_we_do`
--

INSERT INTO `what_we_do` (`id`, `column_number`, `content`, `sort_order`, `created_at`) VALUES
(1, 1, 'We advise on all legal issues that arise in commercial transactions and business operations in Mauritius. Our expertise spans from routine corporate matters to complex regulatory compliance.', 1, '2026-02-18 08:13:32'),
(2, 1, 'Our litigation team represents clients before Mauritian courts including the Supreme Court, Intermediate Court, and various specialized tribunals.', 2, '2026-02-18 08:13:32'),
(3, 2, 'We provide strategic legal opinions for corporate and individual clients, ensuring compliance with Mauritian legislation while protecting their business interests.', 1, '2026-02-18 08:13:32'),
(4, 2, 'Our practice includes both contentious and non-contentious matters, with particular strength in regulatory frameworks specific to Mauritius\'s financial and business landscape.', 2, '2026-02-18 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `why_choose_features`
--

CREATE TABLE `why_choose_features` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `why_choose_features`
--

INSERT INTO `why_choose_features` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'fa-university', 'Government-Level Insight', 'Former Senior State Attorney experience provides unique understanding of Mauritian legal system', 1, 1, '2026-02-18 08:40:51'),
(2, 'fa-chess-knight', 'Strategic Approach', 'Commercial thinking combined with legal precision for optimal outcomes', 2, 1, '2026-02-18 08:40:51'),
(3, 'fa-balance-scale', 'Comprehensive Coverage', 'Diverse practice areas handled by experienced legal professionals', 3, 1, '2026-02-18 08:40:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_features`
--
ALTER TABLE `appointment_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_hero`
--
ALTER TABLE `appointment_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_info_cards`
--
ALTER TABLE `appointment_info_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_steps`
--
ALTER TABLE `appointment_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approach_content`
--
ALTER TABLE `approach_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approach_features`
--
ALTER TABLE `approach_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attorneys`
--
ALTER TABLE `attorneys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Indexes for table `booked_slots`
--
ALTER TABLE `booked_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slot` (`appointment_date`,`time_slot`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `career_applications`
--
ALTER TABLE `career_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career_positions`
--
ALTER TABLE `career_positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Indexes for table `chat_responses`
--
ALTER TABLE `chat_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultation_types`
--
ALTER TABLE `consultation_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Indexes for table `contact_cards`
--
ALTER TABLE `contact_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_hero`
--
ALTER TABLE `contact_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `courses_hero`
--
ALTER TABLE `courses_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_benefits`
--
ALTER TABLE `course_benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_features`
--
ALTER TABLE `course_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_levels`
--
ALTER TABLE `course_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_stats`
--
ALTER TABLE `course_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cta_section`
--
ALTER TABLE `cta_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertise_areas`
--
ALTER TABLE `expertise_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertise_categories`
--
ALTER TABLE `expertise_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertise_cta`
--
ALTER TABLE `expertise_cta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertise_hero`
--
ALTER TABLE `expertise_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `founder`
--
ALTER TABLE `founder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurisprudence_cases`
--
ALTER TABLE `jurisprudence_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `jurisprudence_categories`
--
ALTER TABLE `jurisprudence_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `jurisprudence_cta`
--
ALTER TABLE `jurisprudence_cta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurisprudence_hero`
--
ALTER TABLE `jurisprudence_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurisprudence_stats`
--
ALTER TABLE `jurisprudence_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurisprudence_timeline`
--
ALTER TABLE `jurisprudence_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_hours`
--
ALTER TABLE `office_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overview_description`
--
ALTER TABLE `overview_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overview_hero`
--
ALTER TABLE `overview_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_areas`
--
ALTER TABLE `practice_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_areas_expertise`
--
ALTER TABLE `practice_areas_expertise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `public_service`
--
ALTER TABLE `public_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialized_areas`
--
ALTER TABLE `specialized_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_testimonials`
--
ALTER TABLE `student_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_cta`
--
ALTER TABLE `team_cta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_hero`
--
ALTER TABLE `team_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_stats`
--
ALTER TABLE `team_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `what_we_do`
--
ALTER TABLE `what_we_do`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `why_choose_features`
--
ALTER TABLE `why_choose_features`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `appointment_features`
--
ALTER TABLE `appointment_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointment_hero`
--
ALTER TABLE `appointment_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment_info_cards`
--
ALTER TABLE `appointment_info_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment_steps`
--
ALTER TABLE `appointment_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `approach_content`
--
ALTER TABLE `approach_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `approach_features`
--
ALTER TABLE `approach_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attorneys`
--
ALTER TABLE `attorneys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booked_slots`
--
ALTER TABLE `booked_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `career_applications`
--
ALTER TABLE `career_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `career_positions`
--
ALTER TABLE `career_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat_responses`
--
ALTER TABLE `chat_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultation_types`
--
ALTER TABLE `consultation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_cards`
--
ALTER TABLE `contact_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_hero`
--
ALTER TABLE `contact_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses_hero`
--
ALTER TABLE `courses_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_benefits`
--
ALTER TABLE `course_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_features`
--
ALTER TABLE `course_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_levels`
--
ALTER TABLE `course_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_modules`
--
ALTER TABLE `course_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_stats`
--
ALTER TABLE `course_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cta_section`
--
ALTER TABLE `cta_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expertise_areas`
--
ALTER TABLE `expertise_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expertise_categories`
--
ALTER TABLE `expertise_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expertise_cta`
--
ALTER TABLE `expertise_cta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expertise_hero`
--
ALTER TABLE `expertise_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `founder`
--
ALTER TABLE `founder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jurisprudence_cases`
--
ALTER TABLE `jurisprudence_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jurisprudence_categories`
--
ALTER TABLE `jurisprudence_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jurisprudence_cta`
--
ALTER TABLE `jurisprudence_cta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jurisprudence_hero`
--
ALTER TABLE `jurisprudence_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jurisprudence_stats`
--
ALTER TABLE `jurisprudence_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jurisprudence_timeline`
--
ALTER TABLE `jurisprudence_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `office_hours`
--
ALTER TABLE `office_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `overview_description`
--
ALTER TABLE `overview_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `overview_hero`
--
ALTER TABLE `overview_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `practice_areas`
--
ALTER TABLE `practice_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `practice_areas_expertise`
--
ALTER TABLE `practice_areas_expertise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `public_service`
--
ALTER TABLE `public_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `specialized_areas`
--
ALTER TABLE `specialized_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_testimonials`
--
ALTER TABLE `student_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_cta`
--
ALTER TABLE `team_cta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_hero`
--
ALTER TABLE `team_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_stats`
--
ALTER TABLE `team_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `what_we_do`
--
ALTER TABLE `what_we_do`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `why_choose_features`
--
ALTER TABLE `why_choose_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_slots`
--
ALTER TABLE `booked_slots`
  ADD CONSTRAINT `booked_slots_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `course_levels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jurisprudence_cases`
--
ALTER TABLE `jurisprudence_cases`
  ADD CONSTRAINT `jurisprudence_cases_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `jurisprudence_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `practice_areas_expertise`
--
ALTER TABLE `practice_areas_expertise`
  ADD CONSTRAINT `practice_areas_expertise_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `expertise_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
