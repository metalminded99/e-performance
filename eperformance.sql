-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2013 at 08:00 AM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eperformance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_abilities`
--

CREATE TABLE IF NOT EXISTS `tbl_abilities` (
  `ability_id` int(11) NOT NULL AUTO_INCREMENT,
  `ability_code` tinytext,
  `ability_name` varchar(100) DEFAULT NULL,
  `ability_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ability_id`),
  KEY `abilities_name` (`ability_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_abilities`
--

INSERT INTO `tbl_abilities` (`ability_id`, `ability_code`, `ability_name`, `ability_desc`, `date_added`) VALUES
(2, 'AB', 'test ability', 'test ability', '2013-06-19 10:31:52'),
(3, 'AB2', 'test ability 2', 'test ability 2', '2013-06-19 10:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activities`
--

CREATE TABLE IF NOT EXISTS `tbl_activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` tinytext,
  `activity_name` varchar(100) DEFAULT NULL,
  `activity_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`),
  KEY `ability_name` (`activity_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_activities`
--

INSERT INTO `tbl_activities` (`activity_id`, `activity_code`, `activity_name`, `activity_desc`, `date_added`) VALUES
(2, 'AC', 'test activity', 'test activity', '2013-06-19 10:32:29'),
(3, 'AC2', 'test activity 2', 'test activity 2', '2013-06-19 10:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal` (
  `appraisal_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `appraisal_title` varchar(100) DEFAULT NULL,
  `appraisal_desc` text,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`appraisal_id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_appraisal`
--

INSERT INTO `tbl_appraisal` (`appraisal_id`, `job_id`, `appraisal_title`, `appraisal_desc`, `date_created`) VALUES
(2, 2, 'The quick brown fox jumps over the lazy dog', 'The quick brown fox jumps over the lazy dog', '2013-08-01 05:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_assignment`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal_assignment` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  `date_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assign_id`),
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_appraisal_assignment`
--

INSERT INTO `tbl_appraisal_assignment` (`assign_id`, `app_id`, `user_id`, `status`, `date_assigned`) VALUES
(2, 2, 6, 'Completed', '2013-08-10 07:37:43'),
(3, 2, 7, 'Completed', '2013-08-17 03:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_mngr_assignment`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal_mngr_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `assign_id` (`assign_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_appraisal_mngr_assignment`
--

INSERT INTO `tbl_appraisal_mngr_assignment` (`assign_id`, `manager_id`, `status`) VALUES
(2, 2, 'Completed'),
(3, 2, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_peer_assignment`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal_peer_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `peer_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `peer_id` (`peer_id`),
  KEY `assign_id` (`assign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_appraisal_peer_assignment`
--

INSERT INTO `tbl_appraisal_peer_assignment` (`assign_id`, `peer_id`, `status`) VALUES
(2, 7, 'Completed'),
(3, 6, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_questionaire`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal_questionaire` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_id` int(11) DEFAULT NULL,
  `question` text,
  `category` enum('skills','abl','core','perf') DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `appraisal_id` (`appraisal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_appraisal_questionaire`
--

INSERT INTO `tbl_appraisal_questionaire` (`question_id`, `appraisal_id`, `question`, `category`) VALUES
(15, 2, 'Competncy 1', 'core'),
(16, 2, 'Competncy 2', 'core'),
(17, 2, 'Competncy 3', 'core'),
(18, 2, 'Competncy 4', 'core'),
(19, 2, 'Competncy 5', 'core'),
(20, 2, 'test', 'perf'),
(21, 2, 'test1', 'perf'),
(22, 2, 'test2', 'skills'),
(23, 2, 'test3', 'skills'),
(24, 2, 'test5', 'abl'),
(25, 2, 'test7', 'abl');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appraisal_result`
--

CREATE TABLE IF NOT EXISTS `tbl_appraisal_result` (
  `user_id` int(11) DEFAULT NULL,
  `appraisal_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `self_score` float DEFAULT NULL,
  `peer_id` int(11) DEFAULT NULL,
  `peer_score` float DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `manager_score` float DEFAULT NULL,
  `date_submit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `appraisal_id` (`appraisal_id`),
  KEY `question_id` (`question_id`),
  KEY `peer_id` (`peer_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_appraisal_result`
--

INSERT INTO `tbl_appraisal_result` (`user_id`, `appraisal_id`, `question_id`, `self_score`, `peer_id`, `peer_score`, `manager_id`, `manager_score`, `date_submit`) VALUES
(6, 2, 15, 5, 7, 5, 2, 4, '2013-08-10 03:33:35'),
(6, 2, 16, 1, 7, 4, 2, 4, '2013-08-10 03:33:35'),
(6, 2, 17, 2, 7, 3, 2, 4, '2013-08-10 03:33:35'),
(6, 2, 18, 3, 7, 2, 2, 5, '2013-08-10 03:33:35'),
(6, 2, 19, 4, 7, 1, 2, 4, '2013-08-10 03:33:35'),
(6, 2, 20, 5, 7, 5, 2, 5, '2013-08-10 03:34:54'),
(6, 2, 21, 5, 7, 4, 2, 3, '2013-08-10 03:34:54'),
(6, 2, 22, 2, 7, 4, 2, 3, '2013-08-10 03:35:06'),
(6, 2, 23, 3, 7, 5, 2, 2, '2013-08-10 03:35:06'),
(6, 2, 24, 4, 7, 5, 2, 2, '2013-08-10 03:42:02'),
(6, 2, 25, 5, 7, 4, 2, 4, '2013-08-10 03:42:02'),
(7, 2, 15, 3, 6, 5, 2, 4, '2013-08-17 04:11:24'),
(7, 2, 16, 3, 6, 4, 2, 4, '2013-08-17 04:11:24'),
(7, 2, 17, 4, 6, 4, 2, 3, '2013-08-17 04:11:24'),
(7, 2, 18, 4, 6, 4, 2, 3, '2013-08-17 04:11:24'),
(7, 2, 19, 5, 6, 3, 2, 2, '2013-08-17 04:11:24'),
(7, 2, 20, 3, 6, 3, 2, 3, '2013-08-17 04:11:28'),
(7, 2, 21, 4, 6, 2, 2, 4, '2013-08-17 04:11:28'),
(7, 2, 22, 3, 6, 4, 2, 5, '2013-08-17 04:11:35'),
(7, 2, 23, 4, 6, 3, 2, 4, '2013-08-17 04:11:36'),
(7, 2, 24, 5, 6, 4, 2, 4, '2013-08-17 04:11:39'),
(7, 2, 25, 4, 6, 5, 2, 2, '2013-08-17 04:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE IF NOT EXISTS `tbl_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_desc` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dept_id`),
  KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`dept_id`, `dept_name`, `dept_desc`, `date_added`) VALUES
(1, 'Human Resource', 'All about Human Resourcing', '2013-06-04 16:00:00'),
(4, 'Accounting', 'Accounting', '2013-06-09 15:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dept_goals`
--

CREATE TABLE IF NOT EXISTS `tbl_dept_goals` (
  `goal_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `goal_title` varchar(100) DEFAULT NULL,
  `goal_desc` text,
  `due_date` date DEFAULT NULL,
  `days_to_remind` int(3) DEFAULT NULL,
  `deliverables` text,
  `success_measure` varchar(100) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`goal_id`),
  KEY `goal_title` (`goal_title`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Department goals' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_dept_goals`
--

INSERT INTO `tbl_dept_goals` (`goal_id`, `department_id`, `goal_title`, `goal_desc`, `due_date`, `days_to_remind`, `deliverables`, `success_measure`, `date_created`) VALUES
(1, 1, 'test1', 'test1', '2013-09-30', 5, 'test1', 'test1', '2013-08-07 06:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_duties`
--

CREATE TABLE IF NOT EXISTS `tbl_duties` (
  `duty_id` int(11) NOT NULL AUTO_INCREMENT,
  `duty_code` tinytext,
  `duty_name` varchar(100) DEFAULT NULL,
  `duty_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`duty_id`),
  KEY `duty_name` (`duty_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_duties`
--

INSERT INTO `tbl_duties` (`duty_id`, `duty_code`, `duty_name`, `duty_desc`, `date_added`) VALUES
(2, 'DT', 'test duty', 'test duty', '2013-06-19 10:33:04'),
(3, 'DT2', 'test duty 2', 'test duty 2', '2013-06-19 10:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_development`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_development` (
  `user_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('Pending','In Progress','Completed','Cancelled') NOT NULL,
  `date_assigned` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `training_id` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_emp_development`
--

INSERT INTO `tbl_emp_development` (`user_id`, `training_id`, `date_start`, `date_end`, `comment`, `status`, `date_assigned`) VALUES
(6, 4, '2013-07-08', '2013-07-12', '', 'In Progress', '2013-07-03 20:30:54'),
(6, 3, '2013-07-22', '2013-07-24', '', 'In Progress', '2013-07-04 10:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_goals`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_goals` (
  `goal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_title` varchar(100) DEFAULT NULL,
  `goal_desc` text,
  `due_date` date DEFAULT NULL,
  `days_to_remind` int(3) DEFAULT '0',
  `status` enum('In Progress','Completed','Not Started','Late','Unapproved','Warning','At Risk','Rejected') NOT NULL DEFAULT 'Unapproved',
  `percentage` float NOT NULL DEFAULT '0',
  `deliverables` varchar(100) NOT NULL,
  `success_measure` varchar(100) NOT NULL,
  `self_score` int(3) DEFAULT NULL,
  `peer_score` int(3) DEFAULT NULL,
  `sup_score` int(3) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved` int(1) DEFAULT '0',
  `sup_comment` longtext,
  `date_approved` datetime DEFAULT NULL,
  PRIMARY KEY (`goal_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Goals set by employees' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbl_emp_goals`
--

INSERT INTO `tbl_emp_goals` (`goal_id`, `user_id`, `goal_title`, `goal_desc`, `due_date`, `days_to_remind`, `status`, `percentage`, `deliverables`, `success_measure`, `self_score`, `peer_score`, `sup_score`, `date_created`, `approved`, `sup_comment`, `date_approved`) VALUES
(12, 7, 'test', 'test', '2013-06-30', 3, 'Not Started', 0, 'test', 'test', NULL, NULL, NULL, '2013-06-26 02:46:16', 1, NULL, '2013-06-26 10:46:16'),
(14, 6, 'my goal', 'my goal', '2013-09-01', 3, 'Not Started', 90, 'my goal', 'my goal', NULL, NULL, NULL, '2013-08-28 15:53:59', 1, NULL, '2013-08-28 11:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_journals`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_journals` (
  `journal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `journal_title` varchar(50) DEFAULT NULL,
  `journal_desc` varchar(500) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`journal_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_emp_journals`
--

INSERT INTO `tbl_emp_journals` (`journal_id`, `user_id`, `journal_title`, `journal_desc`, `date_created`, `modified_date`) VALUES
(1, 6, 'The quick brown fox', 'The quick brown fox jumps over the lazy fucking dog.', '2013-07-04 10:21:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_perf_output`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_perf_output` (
  `user_id` int(11) NOT NULL,
  `perf_id` int(11) NOT NULL,
  `self_score` int(11) NOT NULL DEFAULT '0',
  `peer_score` int(11) NOT NULL DEFAULT '0',
  `sup_score` int(11) NOT NULL DEFAULT '0',
  KEY `perf_id` (`perf_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Employee Scores for Performance Output';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp_process`
--

CREATE TABLE IF NOT EXISTS `tbl_emp_process` (
  `user_id` int(11) DEFAULT NULL,
  `process_id` int(11) DEFAULT NULL,
  `date_accomplished` datetime DEFAULT NULL,
  `date_assigned` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `process_id` (`process_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_emp_process`
--

INSERT INTO `tbl_emp_process` (`user_id`, `process_id`, `date_accomplished`, `date_assigned`) VALUES
(6, 4, NULL, '2013-07-18 03:49:33'),
(7, 4, NULL, '2013-07-18 03:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

CREATE TABLE IF NOT EXISTS `tbl_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `history` varchar(255) DEFAULT NULL,
  `date_done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `tbl_history`
--

INSERT INTO `tbl_history` (`history_id`, `user_id`, `history`, `date_done`) VALUES
(1, 2, 'Created new department goal', '2013-08-07 06:22:09'),
(2, 2, 'Updated department goal', '2013-08-07 06:23:57'),
(3, 2, 'Deassigned peer to employee feedback', '2013-08-08 10:55:26'),
(4, 2, 'Assigned peer to employee feedback', '2013-08-08 10:55:46'),
(5, 2, 'Assigned peer to employee feedback', '2013-08-08 10:57:05'),
(6, 2, 'Assigned peer to employee feedback', '2013-08-08 10:57:12'),
(7, 2, 'Deassigned peer to employee feedback', '2013-08-08 11:02:53'),
(8, 2, 'Assigned peer to employee feedback', '2013-08-08 11:04:47'),
(9, 2, 'Deassigned peer to employee feedback', '2013-08-08 11:05:03'),
(10, 2, 'Assigned peer to employee feedback', '2013-08-08 11:07:30'),
(11, 2, 'Deassigned peer to employee feedback', '2013-08-08 11:07:35'),
(12, 2, 'Assigned peer to employee feedback', '2013-08-08 11:07:41'),
(13, 2, 'Assigned peer to employee feedback', '2013-08-10 07:25:51'),
(14, 2, 'Assigned peer to employee feedback', '2013-08-10 07:26:23'),
(15, 2, 'Assigned peer to employee feedback', '2013-08-10 07:33:27'),
(16, 2, 'Assigned peer to employee feedback', '2013-08-10 07:33:33'),
(17, 2, 'Assigned peer to employee feedback', '2013-08-10 07:37:43'),
(18, 2, 'Assigned peer to employee feedback', '2013-08-10 07:37:49'),
(19, 6, 'Evaluate self appraisal', '2013-08-11 02:19:13'),
(21, 7, 'Evaluate peer appraisal', '2013-08-11 06:17:45'),
(22, 2, 'Assigned peer to employee feedback', '2013-08-17 03:18:10'),
(23, 2, 'Evaluate employee appraisal', '2013-08-17 03:51:21'),
(24, 7, 'Evaluate self appraisal', '2013-08-17 03:53:56'),
(25, 7, 'Evaluate self appraisal', '2013-08-17 04:11:39'),
(26, 2, 'Evaluate employee appraisal', '2013-08-17 04:12:54'),
(27, 2, 'Evaluate employee appraisal', '2013-08-17 07:29:05'),
(28, 6, 'Evaluate peer appraisal', '2013-08-17 07:58:50'),
(29, 2, 'Change employee goal status to REJECTED', '2013-08-28 15:53:49'),
(30, 2, 'Change employee goal status to NOT STARTED', '2013-08-28 15:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobs`
--

CREATE TABLE IF NOT EXISTS `tbl_jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_desc` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `job_desc` (`job_desc`),
  KEY `dept_id` (`dept_id`),
  KEY `job_title` (`job_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_jobs`
--

INSERT INTO `tbl_jobs` (`job_id`, `dept_id`, `job_title`, `job_desc`, `date_added`) VALUES
(2, 1, 'Employee Relations', 'Employee Relations', '2013-06-05 00:00:00'),
(4, 4, 'Accountant', 'Accountant', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_abilities`
--

CREATE TABLE IF NOT EXISTS `tbl_job_abilities` (
  `ability_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `ability_id` (`ability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_abilities`
--

INSERT INTO `tbl_job_abilities` (`ability_id`, `job_id`, `active`, `date_added`) VALUES
(3, NULL, 'Yes', '2013-07-23 01:31:50'),
(2, 4, 'Yes', '2013-07-24 23:15:56'),
(3, 4, 'Yes', '2013-07-24 23:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_activities`
--

CREATE TABLE IF NOT EXISTS `tbl_job_activities` (
  `activity_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_activities`
--

INSERT INTO `tbl_job_activities` (`activity_id`, `job_id`, `active`, `date_added`) VALUES
(3, NULL, 'Yes', '2013-07-23 06:40:34'),
(3, 4, 'Yes', '2013-07-24 23:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_duties`
--

CREATE TABLE IF NOT EXISTS `tbl_job_duties` (
  `duty_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `duty_id` (`duty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_duties`
--

INSERT INTO `tbl_job_duties` (`duty_id`, `job_id`, `active`, `date_added`) VALUES
(2, NULL, 'Yes', '2013-07-23 06:40:28'),
(2, 4, 'Yes', '2013-07-24 23:15:35'),
(3, 4, 'Yes', '2013-07-24 23:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_skills`
--

CREATE TABLE IF NOT EXISTS `tbl_job_skills` (
  `skill_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_skills`
--

INSERT INTO `tbl_job_skills` (`skill_id`, `job_id`, `active`, `date_added`) VALUES
(3, NULL, 'Yes', '2013-07-23 01:31:43'),
(5, NULL, 'Yes', '2013-07-23 01:31:43'),
(6, NULL, 'Yes', '2013-07-23 01:31:43'),
(8, NULL, 'Yes', '2013-07-23 01:31:43'),
(2, 4, 'Yes', '2013-07-24 23:15:52'),
(7, 4, 'Yes', '2013-07-24 23:15:52'),
(8, 4, 'Yes', '2013-07-24 23:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_journal_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_journal_comments` (
  `journal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `journal_id` (`journal_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_content` text NOT NULL,
  `active` enum('1','2') NOT NULL DEFAULT '1',
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`),
  KEY `news_title` (`news_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perf_output`
--

CREATE TABLE IF NOT EXISTS `tbl_perf_output` (
  `perf_id` int(11) NOT NULL AUTO_INCREMENT,
  `perf_title` varchar(100) NOT NULL,
  `perf_desc` text NOT NULL,
  PRIMARY KEY (`perf_id`),
  KEY `perf_title` (`perf_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='List of performance output (appraisal form); static data ' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_perf_output`
--

INSERT INTO `tbl_perf_output` (`perf_id`, `perf_title`, `perf_desc`) VALUES
(1, 'Job Knowledge / Skills ', 'The extent to which an employee demonstrates functional knowledge and the skill level required to complete the assignments efficiently and effectively. Includes learning & adapting to changing skill requirements.'),
(2, 'Quantity of Work', 'The extent to which an employee uses available working time, plans and prioritizes work to achieve a reasonable volume of work.'),
(3, 'Quality of Work ', 'The extent to which an employee exerted effort to consistently achieve desired outcomes which are accurate, thorough and with a minimum avoidable errors.'),
(4, 'Timeliness', 'The extent to which an employee is able to work quickly and deliver required output on a timely basis. Adjusts to unexpected changes in work demands to meet timetables.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_process`
--

CREATE TABLE IF NOT EXISTS `tbl_process` (
  `proc_id` int(11) NOT NULL AUTO_INCREMENT,
  `proc_title` varchar(100) DEFAULT NULL,
  `proc_desc` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`proc_id`),
  KEY `proc_title` (`proc_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_process`
--

INSERT INTO `tbl_process` (`proc_id`, `proc_title`, `proc_desc`, `start_date`, `end_date`, `date_added`) VALUES
(4, 'Update Job Specifications', 'Update Job Specifications', '2013-07-18', '2013-07-22', '2013-07-17 02:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_skills`
--

CREATE TABLE IF NOT EXISTS `tbl_skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_code` tinytext,
  `skill_name` varchar(100) DEFAULT NULL,
  `skill_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_skills`
--

INSERT INTO `tbl_skills` (`skill_id`, `skill_code`, `skill_name`, `skill_desc`, `date_added`) VALUES
(2, 'test1', 'test skill', 'test skill', '2013-06-19 10:30:41'),
(3, 't2', 'test skill 2', 'test skill 2', '2013-06-19 10:30:51'),
(4, 't3', 'test skill 3', 'test skill 3', '2013-06-19 11:03:48'),
(5, 't4', 'test skill 4', 'test skill', '2013-06-19 11:04:01'),
(6, 't5', 'test skill 5', 'test skill', '2013-06-19 11:04:17'),
(7, 't6', 'test skill 6', 'test skill', '2013-06-19 11:04:28'),
(8, 't7', 'test skill 7', 'test skill 7', '2013-06-20 02:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trainings`
--

CREATE TABLE IF NOT EXISTS `tbl_trainings` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_title` varchar(100) DEFAULT NULL,
  `training_desc` text NOT NULL,
  `duration` int(3) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`training_id`),
  KEY `training_title` (`training_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_trainings`
--

INSERT INTO `tbl_trainings` (`training_id`, `training_title`, `training_desc`, `duration`, `date_created`) VALUES
(3, 'Test 1', 'Test 1', 10, '2013-06-27 18:29:27'),
(4, 'test 2', 'test 2', 5, '2013-06-29 18:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_training_abilities`
--

CREATE TABLE IF NOT EXISTS `tbl_training_abilities` (
  `training_id` int(11) DEFAULT NULL,
  `ability_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `training_id` (`training_id`),
  KEY `ability_id` (`ability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_training_abilities`
--

INSERT INTO `tbl_training_abilities` (`training_id`, `ability_id`, `date_added`) VALUES
(3, 2, '2013-06-27 18:29:27'),
(4, 2, '2013-06-29 18:18:10'),
(4, 3, '2013-06-29 18:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_training_skills`
--

CREATE TABLE IF NOT EXISTS `tbl_training_skills` (
  `training_id` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `training_id` (`training_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_training_skills`
--

INSERT INTO `tbl_training_skills` (`training_id`, `skill_id`, `date_added`) VALUES
(3, 2, '2013-06-27 18:29:27'),
(3, 4, '2013-06-27 18:29:27'),
(3, 7, '2013-06-27 18:29:27'),
(4, 2, '2013-06-29 18:18:09'),
(4, 4, '2013-06-29 18:18:10'),
(4, 6, '2013-06-29 18:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) DEFAULT NULL,
  `pword` text NOT NULL,
  `lvl` enum('1','2','3') NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `home_address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `home_phone` varchar(20) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `tin_id` varchar(50) NOT NULL,
  `sss_id` varchar(20) NOT NULL,
  `pagibig_id` varchar(20) NOT NULL,
  `philhealth_id` varchar(20) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `emergency_contact` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `avatar` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fname` (`fname`),
  KEY `mname` (`mname`),
  KEY `lname` (`lname`),
  KEY `department_id` (`department_id`),
  KEY `job_id` (`job_id`),
  KEY `uname` (`uname`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `uname`, `pword`, `lvl`, `fname`, `mname`, `lname`, `home_address`, `email`, `home_phone`, `mobile_phone`, `birthday`, `gender`, `tin_id`, `sss_id`, `pagibig_id`, `philhealth_id`, `emergency_phone`, `emergency_contact`, `department_id`, `job_id`, `last_login`, `avatar`) VALUES
(1, 'admin', 'e6e061838856bf47e1de730719fb2609', '1', 'Administrator', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', 0, 0, '2013-09-03 06:08:24', ''),
(2, 'test', '827ccb0eea8a706c4c34a16891f84e7b', '2', 'test', 'test', 'test', ' test ', 'test@test.com', '123456', '12345', '1993-06-01', 'Male', '', '', '', '', '1321', 'test', 1, 2, '2013-09-04 23:54:08', ''),
(6, 'malbitos', '827ccb0eea8a706c4c34a16891f84e7b', '3', 'Mark', 'test', 'Albitos', 'asdasdasd        ', 'asdasdas@123.com', '+123123', '+123123', '1990-06-13', 'Male', '', '', '', '', '123123', 'Asdasd', 1, 2, '2013-09-03 22:33:17', ''),
(7, 'jdelacruz', '827ccb0eea8a706c4c34a16891f84e7b', '3', 'Juan Miguel', 'Santo Domingo', 'Dela Cruz', '  asd', 'asd@asd.com', '1231231', '12312312', '1958-06-10', 'Male', '', '', '', '', '123123', 'klnfldsnflsdnf', 1, 2, '2013-08-17 15:49:38', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_appraisal`
--
ALTER TABLE `tbl_appraisal`
  ADD CONSTRAINT `tbl_appraisal_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_appraisal_mngr_assignment`
--
ALTER TABLE `tbl_appraisal_mngr_assignment`
  ADD CONSTRAINT `tbl_appraisal_mngr_assignment_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `tbl_appraisal_assignment` (`assign_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_appraisal_peer_assignment`
--
ALTER TABLE `tbl_appraisal_peer_assignment`
  ADD CONSTRAINT `tbl_appraisal_peer_assignment_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `tbl_appraisal_assignment` (`assign_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_appraisal_questionaire`
--
ALTER TABLE `tbl_appraisal_questionaire`
  ADD CONSTRAINT `tbl_appraisal_questionaire_ibfk_1` FOREIGN KEY (`appraisal_id`) REFERENCES `tbl_appraisal` (`appraisal_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_dept_goals`
--
ALTER TABLE `tbl_dept_goals`
  ADD CONSTRAINT `tbl_dept_goals_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`dept_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_emp_journals`
--
ALTER TABLE `tbl_emp_journals`
  ADD CONSTRAINT `tbl_emp_journals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_emp_perf_output`
--
ALTER TABLE `tbl_emp_perf_output`
  ADD CONSTRAINT `tbl_emp_perf_output_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_emp_perf_output_ibfk_2` FOREIGN KEY (`perf_id`) REFERENCES `tbl_perf_output` (`perf_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_emp_process`
--
ALTER TABLE `tbl_emp_process`
  ADD CONSTRAINT `tbl_emp_process_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_emp_process_ibfk_2` FOREIGN KEY (`process_id`) REFERENCES `tbl_process` (`proc_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_history`
--
ALTER TABLE `tbl_history`
  ADD CONSTRAINT `tbl_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `tbl_jobs`
--
ALTER TABLE `tbl_jobs`
  ADD CONSTRAINT `tbl_jobs_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `tbl_department` (`dept_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_job_abilities`
--
ALTER TABLE `tbl_job_abilities`
  ADD CONSTRAINT `tbl_job_abilities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_job_abilities_ibfk_2` FOREIGN KEY (`ability_id`) REFERENCES `tbl_abilities` (`ability_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_job_activities`
--
ALTER TABLE `tbl_job_activities`
  ADD CONSTRAINT `tbl_job_activities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_job_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `tbl_activities` (`activity_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_job_duties`
--
ALTER TABLE `tbl_job_duties`
  ADD CONSTRAINT `tbl_job_duties_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_job_duties_ibfk_2` FOREIGN KEY (`duty_id`) REFERENCES `tbl_duties` (`duty_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_job_skills`
--
ALTER TABLE `tbl_job_skills`
  ADD CONSTRAINT `tbl_job_skills_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_job_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `tbl_skills` (`skill_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_journal_comments`
--
ALTER TABLE `tbl_journal_comments`
  ADD CONSTRAINT `tbl_journal_comments_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `tbl_emp_journals` (`journal_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_journal_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_training_abilities`
--
ALTER TABLE `tbl_training_abilities`
  ADD CONSTRAINT `tbl_training_abilities_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `tbl_trainings` (`training_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_training_abilities_ibfk_2` FOREIGN KEY (`ability_id`) REFERENCES `tbl_abilities` (`ability_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_training_skills`
--
ALTER TABLE `tbl_training_skills`
  ADD CONSTRAINT `tbl_training_skills_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `tbl_trainings` (`training_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_training_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `tbl_skills` (`skill_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
