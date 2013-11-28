/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.34-0ubuntu0.12.04.1 : Database - eperformance
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tbl_abilities` */

DROP TABLE IF EXISTS `tbl_abilities`;

CREATE TABLE `tbl_abilities` (
  `ability_id` int(11) NOT NULL AUTO_INCREMENT,
  `ability_code` tinytext,
  `ability_name` varchar(100) DEFAULT NULL,
  `ability_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ability_id`),
  KEY `abilities_name` (`ability_name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_activities` */

DROP TABLE IF EXISTS `tbl_activities`;

CREATE TABLE `tbl_activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` tinytext,
  `activity_name` varchar(100) DEFAULT NULL,
  `activity_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`),
  KEY `ability_name` (`activity_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal` */

DROP TABLE IF EXISTS `tbl_appraisal`;

CREATE TABLE `tbl_appraisal` (
  `appraisal_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `appraisal_title` varchar(100) DEFAULT NULL,
  `appraisal_desc` text,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`appraisal_id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_assignment`;

CREATE TABLE `tbl_appraisal_assignment` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  `date_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assign_id`),
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_main_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_main_categories`;

CREATE TABLE `tbl_appraisal_main_categories` (
  `main_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_category_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`main_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_mngr_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_mngr_assignment`;

CREATE TABLE `tbl_appraisal_mngr_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `app_id` int(11) NOT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `assign_id` (`assign_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_peer_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_peer_assignment`;

CREATE TABLE `tbl_appraisal_peer_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `peer_id` int(11) DEFAULT NULL,
  `app_id` int(11) NOT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `peer_id` (`peer_id`),
  KEY `assign_id` (`assign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_percentage` */

DROP TABLE IF EXISTS `tbl_appraisal_percentage`;

CREATE TABLE `tbl_appraisal_percentage` (
  `appraisal_id` int(11) NOT NULL,
  `main_cat_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  KEY `appraisal_id` (`appraisal_id`),
  KEY `main_cat_id` (`main_cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_questionaire` */

DROP TABLE IF EXISTS `tbl_appraisal_questionaire`;

CREATE TABLE `tbl_appraisal_questionaire` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_id` int(11) DEFAULT NULL,
  `question` text,
  `category` int(1) DEFAULT NULL,
  `sub_category` int(1) DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `appraisal_id` (`appraisal_id`,`category`,`sub_category`),
  KEY `fk_tbl_appraisal_questionaire_1_idx` (`sub_category`),
  KEY `fk_tbl_appraisal_questionaire_2_idx` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_result` */

DROP TABLE IF EXISTS `tbl_appraisal_result`;

CREATE TABLE `tbl_appraisal_result` (
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

/*Table structure for table `tbl_appraisal_sub_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_sub_categories`;

CREATE TABLE `tbl_appraisal_sub_categories` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_cat_id` int(11) DEFAULT NULL,
  `appraisal_id` int(11) NOT NULL,
  `sub_category_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sub_category_id`),
  KEY `index2` (`main_cat_id`),
  KEY `fk_tbl_appraisal_sub_categories_1_idx` (`main_cat_id`),
  KEY `appraisal_id` (`appraisal_id`),
  KEY `appraisal_id_2` (`appraisal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_training` */

DROP TABLE IF EXISTS `tbl_appraisal_training`;

CREATE TABLE `tbl_appraisal_training` (
  `appraisal_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) DEFAULT NULL,
  `appraisal_title` varchar(100) DEFAULT NULL,
  `appraisal_desc` text,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`appraisal_id`),
  KEY `job_id` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_training_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_training_assignment`;

CREATE TABLE `tbl_appraisal_training_assignment` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  `date_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assign_id`),
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_training_main_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_training_main_categories`;

CREATE TABLE `tbl_appraisal_training_main_categories` (
  `main_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) NOT NULL,
  `appraisal_id` int(11) NOT NULL,
  `main_category_name` varchar(45) DEFAULT NULL,
  `percentage` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`main_category_id`),
  KEY `training_id` (`training_id`),
  KEY `appraisal_id` (`appraisal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_training_questionaire` */

DROP TABLE IF EXISTS `tbl_appraisal_training_questionaire`;

CREATE TABLE `tbl_appraisal_training_questionaire` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_id` int(11) DEFAULT NULL,
  `question` text,
  `category` int(1) DEFAULT NULL,
  `sub_category` int(1) DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `appraisal_id` (`appraisal_id`,`category`,`sub_category`),
  KEY `fk_tbl_appraisal_questionaire_1_idx` (`sub_category`),
  KEY `fk_tbl_appraisal_questionaire_2_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_appraisal_training_result` */

DROP TABLE IF EXISTS `tbl_appraisal_training_result`;

CREATE TABLE `tbl_appraisal_training_result` (
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

/*Table structure for table `tbl_appraisal_training_sub_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_training_sub_categories`;

CREATE TABLE `tbl_appraisal_training_sub_categories` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_cat_id` int(11) DEFAULT NULL,
  `appraisal_id` int(11) NOT NULL,
  `sub_category_name` varchar(45) DEFAULT NULL,
  `percentage` int(11) NOT NULL,
  PRIMARY KEY (`sub_category_id`),
  KEY `index2` (`main_cat_id`),
  KEY `fk_tbl_appraisal_sub_categories_1_idx` (`main_cat_id`),
  KEY `appraisal_id` (`appraisal_id`),
  KEY `appraisal_id_2` (`appraisal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_department` */

DROP TABLE IF EXISTS `tbl_department`;

CREATE TABLE `tbl_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_desc` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dept_id`),
  KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_dept_goals` */

DROP TABLE IF EXISTS `tbl_dept_goals`;

CREATE TABLE `tbl_dept_goals` (
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
  KEY `department_id` (`department_id`),
  CONSTRAINT `tbl_dept_goals_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`dept_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Department goals';

/*Table structure for table `tbl_duties` */

DROP TABLE IF EXISTS `tbl_duties`;

CREATE TABLE `tbl_duties` (
  `duty_id` int(11) NOT NULL AUTO_INCREMENT,
  `duty_code` tinytext,
  `duty_name` varchar(100) DEFAULT NULL,
  `duty_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`duty_id`),
  KEY `duty_name` (`duty_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_emp_development` */

DROP TABLE IF EXISTS `tbl_emp_development`;

CREATE TABLE `tbl_emp_development` (
  `user_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('Pending','On-going','Completed','Cancelled') NOT NULL,
  `date_assigned` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `training_id` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_emp_goal_comments` */

DROP TABLE IF EXISTS `tbl_emp_goal_comments`;

CREATE TABLE `tbl_emp_goal_comments` (
  `goal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_emp_goals` */

DROP TABLE IF EXISTS `tbl_emp_goals`;

CREATE TABLE `tbl_emp_goals` (
  `goal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_title` varchar(100) DEFAULT NULL,
  `goal_desc` text,
  `due_date` date DEFAULT NULL,
  `days_to_remind` int(3) DEFAULT '0',
  `status` enum('On-going','Completed','Pending','Late','Warning','At Risk','Rejected') NOT NULL DEFAULT 'Pending',
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
  `dept_goal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`goal_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT='Goals set by employees';

/*Table structure for table `tbl_emp_journals` */

DROP TABLE IF EXISTS `tbl_emp_journals`;

CREATE TABLE `tbl_emp_journals` (
  `journal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `journal_title` varchar(50) DEFAULT NULL,
  `journal_desc` varchar(500) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`journal_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_emp_journals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_emp_perf_output` */

DROP TABLE IF EXISTS `tbl_emp_perf_output`;

CREATE TABLE `tbl_emp_perf_output` (
  `user_id` int(11) NOT NULL,
  `perf_id` int(11) NOT NULL,
  `self_score` int(11) NOT NULL DEFAULT '0',
  `peer_score` int(11) NOT NULL DEFAULT '0',
  `sup_score` int(11) NOT NULL DEFAULT '0',
  KEY `perf_id` (`perf_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_emp_perf_output_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_emp_perf_output_ibfk_2` FOREIGN KEY (`perf_id`) REFERENCES `tbl_perf_output` (`perf_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Employee Scores for Performance Output';

/*Table structure for table `tbl_emp_proc_comment` */

DROP TABLE IF EXISTS `tbl_emp_proc_comment`;

CREATE TABLE `tbl_emp_proc_comment` (
  `proc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_emp_process` */

DROP TABLE IF EXISTS `tbl_emp_process`;

CREATE TABLE `tbl_emp_process` (
  `user_id` int(11) DEFAULT NULL,
  `process_id` int(11) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_accomplished` datetime DEFAULT NULL,
  `date_assigned` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','On-going','Completed') DEFAULT 'Pending',
  KEY `user_id` (`user_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `tbl_emp_process_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_emp_process_ibfk_2` FOREIGN KEY (`process_id`) REFERENCES `tbl_process` (`proc_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_history` */

DROP TABLE IF EXISTS `tbl_history`;

CREATE TABLE `tbl_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `history` varchar(255) DEFAULT NULL,
  `date_done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_job_abilities` */

DROP TABLE IF EXISTS `tbl_job_abilities`;

CREATE TABLE `tbl_job_abilities` (
  `ability_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `ability_id` (`ability_id`),
  CONSTRAINT `tbl_job_abilities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_job_abilities_ibfk_2` FOREIGN KEY (`ability_id`) REFERENCES `tbl_abilities` (`ability_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_job_activities` */

DROP TABLE IF EXISTS `tbl_job_activities`;

CREATE TABLE `tbl_job_activities` (
  `activity_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `activity_id` (`activity_id`),
  CONSTRAINT `tbl_job_activities_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_job_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `tbl_activities` (`activity_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_job_duties` */

DROP TABLE IF EXISTS `tbl_job_duties`;

CREATE TABLE `tbl_job_duties` (
  `duty_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `duty_id` (`duty_id`),
  CONSTRAINT `tbl_job_duties_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_job_duties_ibfk_2` FOREIGN KEY (`duty_id`) REFERENCES `tbl_duties` (`duty_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_job_skills` */

DROP TABLE IF EXISTS `tbl_job_skills`;

CREATE TABLE `tbl_job_skills` (
  `skill_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `job_id` (`job_id`),
  KEY `skill_id` (`skill_id`),
  CONSTRAINT `tbl_job_skills_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_job_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `tbl_skills` (`skill_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_jobs` */

DROP TABLE IF EXISTS `tbl_jobs`;

CREATE TABLE `tbl_jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_desc` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `job_desc` (`job_desc`),
  KEY `dept_id` (`dept_id`),
  KEY `job_title` (`job_title`),
  CONSTRAINT `tbl_jobs_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `tbl_department` (`dept_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_journal_comments` */

DROP TABLE IF EXISTS `tbl_journal_comments`;

CREATE TABLE `tbl_journal_comments` (
  `journal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `journal_id` (`journal_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_journal_comments_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `tbl_emp_journals` (`journal_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_journal_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_news` */

DROP TABLE IF EXISTS `tbl_news`;

CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_content` text NOT NULL,
  `active` enum('1','2') NOT NULL DEFAULT '1',
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`),
  KEY `news_title` (`news_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_perf_output` */

DROP TABLE IF EXISTS `tbl_perf_output`;

CREATE TABLE `tbl_perf_output` (
  `perf_id` int(11) NOT NULL AUTO_INCREMENT,
  `perf_title` varchar(100) NOT NULL,
  `perf_desc` text NOT NULL,
  PRIMARY KEY (`perf_id`),
  KEY `perf_title` (`perf_title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='List of performance output (appraisal form); static data ';

/*Table structure for table `tbl_process` */

DROP TABLE IF EXISTS `tbl_process`;

CREATE TABLE `tbl_process` (
  `proc_id` int(11) NOT NULL AUTO_INCREMENT,
  `proc_title` varchar(100) DEFAULT NULL,
  `proc_desc` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`proc_id`),
  KEY `proc_title` (`proc_title`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_process_logs` */

DROP TABLE IF EXISTS `tbl_process_logs`;

CREATE TABLE `tbl_process_logs` (
  `user_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0 - Pending, 1 - In progress, 2 - Completed',
  `date_started` datetime NOT NULL,
  `date_completed` datetime NOT NULL,
  KEY `user_id` (`user_id`,`process_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_skills` */

DROP TABLE IF EXISTS `tbl_skills`;

CREATE TABLE `tbl_skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_code` tinytext,
  `skill_name` varchar(100) DEFAULT NULL,
  `skill_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_succession_master` */

DROP TABLE IF EXISTS `tbl_succession_master`;

CREATE TABLE `tbl_succession_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text,
  `type` enum('potential','timing','risk','reason') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_succession_plan` */

DROP TABLE IF EXISTS `tbl_succession_plan`;

CREATE TABLE `tbl_succession_plan` (
  `succession_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `potential` int(11) DEFAULT NULL,
  `timing` int(11) DEFAULT NULL,
  `risk_of_leaving` int(11) DEFAULT NULL,
  `reason_for_leaving` int(11) DEFAULT NULL,
  PRIMARY KEY (`succession_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_training_abilities` */

DROP TABLE IF EXISTS `tbl_training_abilities`;

CREATE TABLE `tbl_training_abilities` (
  `training_id` int(11) DEFAULT NULL,
  `ability_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `training_id` (`training_id`),
  KEY `ability_id` (`ability_id`),
  CONSTRAINT `tbl_training_abilities_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `tbl_trainings` (`training_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_training_abilities_ibfk_2` FOREIGN KEY (`ability_id`) REFERENCES `tbl_abilities` (`ability_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_training_skills` */

DROP TABLE IF EXISTS `tbl_training_skills`;

CREATE TABLE `tbl_training_skills` (
  `training_id` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `training_id` (`training_id`),
  KEY `skill_id` (`skill_id`),
  CONSTRAINT `tbl_training_skills_ibfk_1` FOREIGN KEY (`training_id`) REFERENCES `tbl_trainings` (`training_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_training_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `tbl_skills` (`skill_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_trainings` */

DROP TABLE IF EXISTS `tbl_trainings`;

CREATE TABLE `tbl_trainings` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_title` varchar(100) DEFAULT NULL,
  `training_desc` text NOT NULL,
  `duration` int(3) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`training_id`),
  KEY `training_title` (`training_title`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
