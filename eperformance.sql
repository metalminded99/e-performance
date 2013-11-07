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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`eperformance` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `eperformance`;

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

/*Data for the table `tbl_abilities` */

insert  into `tbl_abilities`(`ability_id`,`ability_code`,`ability_name`,`ability_desc`,`date_added`) values (4,'PS01','Problem Sensitivity','The ability to tell when something is wrong or is likely to go wrong. It does not involve solving th','2013-11-05 14:18:50'),(5,'OE01','Oral Expression','The ability to communicate information and ideas in speaking so others will understand.','2013-11-05 14:19:29'),(6,'OC01','Oral Comprehension','The ability to listen to and understand information and ideas presented through spoken words and sen','2013-11-05 14:20:38'),(7,'IR01','Inductive Reasoning','The ability to combine pieces of information to form general rules or conclusions (includes finding ','2013-11-05 14:21:05'),(8,'SC01','Speech Clarity','The ability to speak clearly so others can understand you.','2013-11-05 14:21:51'),(9,'DR01',' Deductive Reasoning','The ability to apply general rules to specific problems to produce answers that make sense.','2013-11-05 14:22:29'),(10,'WE01','Written Expression','The ability to communicate information and ideas in writing so others will understand.','2013-11-05 14:23:15'),(11,'SR02','Speech Recognition','The ability to identify and understand the speech of another person.','2013-11-05 14:23:36'),(12,'WC03','Written Comprehension','The ability to read and understand information and ideas presented in writing.','2013-11-05 14:26:42'),(13,'NV01',' Near Vision','The ability to see details at close range (within a few feet of the observer).','2013-11-05 14:27:12'),(14,'SA03','Selective Attention ','The ability to concentrate on a task over a period of time without being distracted.','2013-11-05 14:28:02'),(15,'IO04',' Information Ordering','The ability to arrange things or actions in a certain order or pattern according to a specific rule ','2013-11-05 14:28:31'),(16,'TS02','Trunk Strength','The ability to use your abdominal and lower back muscles to support part of the body repeatedly or c','2013-11-05 14:28:56'),(17,'TS04','Time Sharing ','The ability to shift back and forth between two or more activities or sources of information (such a','2013-11-05 14:29:20'),(18,'FC05','Flexibility of Closure','The ability to identify or detect a known pattern (a figure, object, word, or sound) that is hidden ','2013-11-05 14:29:47'),(19,'MD02','Manual Dexterity','The ability to quickly move your hand, your hand together with your arm, or your two hands to grasp,','2013-11-05 14:30:12');

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

/*Data for the table `tbl_activities` */

insert  into `tbl_activities`(`activity_id`,`activity_code`,`activity_name`,`activity_desc`,`date_added`) values (4,'ACFO','Assisting and Caring for Others','Providing personal assistance, medical attention, emotional support, or other personal care to other','2013-11-05 14:33:30'),(5,'DCRI','Documenting/Recording Information ','Entering, transcribing, recording, storing, or maintaining information in written or electronic/magn','2013-11-05 14:34:17'),(6,'GI04','Getting Information','Observing, receiving, and otherwise obtaining information from all relevant sources.','2013-11-05 14:34:39'),(7,'UURK','Updating and Using Relevant Knowledge ','Keeping up-to-date technically and applying new knowledge to your job.','2013-11-05 14:35:00'),(8,'OPPW','Organizing, Planning, and Prioritizing Work ','Developing specific goals and plans to prioritize, organize, and accomplish your work.','2013-11-05 14:35:20'),(9,'IOAE','Identifying Objects, Actions, and Events','Identifying information by categorizing, estimating, recognizing differences or similarities, and de','2013-11-05 14:35:44');

/*Table structure for table `tbl_appraisal` */

DROP TABLE IF EXISTS `tbl_appraisal`;

CREATE TABLE `tbl_appraisal` (
  `appraisal_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `appraisal_title` varchar(100) DEFAULT NULL,
  `appraisal_desc` text,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`appraisal_id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `tbl_appraisal_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_jobs` (`job_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal` */

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_assignment` */

/*Table structure for table `tbl_appraisal_main_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_main_categories`;

CREATE TABLE `tbl_appraisal_main_categories` (
  `main_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_category_name` varchar(45) DEFAULT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`main_category_id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_main_categories` */

insert  into `tbl_appraisal_main_categories`(`main_category_id`,`main_category_name`,`job_id`) values (1,'Core Competency',0),(6,'Performance Output',0),(7,'Skills',0),(8,'Abilities',0);

/*Table structure for table `tbl_appraisal_mngr_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_mngr_assignment`;

CREATE TABLE `tbl_appraisal_mngr_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `assign_id` (`assign_id`),
  KEY `manager_id` (`manager_id`),
  CONSTRAINT `tbl_appraisal_mngr_assignment_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `tbl_appraisal_assignment` (`assign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_mngr_assignment` */

/*Table structure for table `tbl_appraisal_peer_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_peer_assignment`;

CREATE TABLE `tbl_appraisal_peer_assignment` (
  `assign_id` int(11) DEFAULT NULL,
  `peer_id` int(11) DEFAULT NULL,
  `status` enum('Pending','On-going','Completed') DEFAULT NULL,
  KEY `peer_id` (`peer_id`),
  KEY `assign_id` (`assign_id`),
  CONSTRAINT `tbl_appraisal_peer_assignment_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `tbl_appraisal_assignment` (`assign_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_peer_assignment` */

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
  KEY `fk_tbl_appraisal_questionaire_2_idx` (`category`),
  CONSTRAINT `fk_tbl_appraisal_questionaire_1` FOREIGN KEY (`sub_category`) REFERENCES `tbl_appraisal_sub_categories` (`sub_category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_appraisal_questionaire_2` FOREIGN KEY (`category`) REFERENCES `tbl_appraisal_main_categories` (`main_category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_appraisal_questionaire_ibfk_1` FOREIGN KEY (`appraisal_id`) REFERENCES `tbl_appraisal` (`appraisal_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_questionaire` */

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

/*Data for the table `tbl_appraisal_result` */

insert  into `tbl_appraisal_result`(`user_id`,`appraisal_id`,`question_id`,`self_score`,`peer_id`,`peer_score`,`manager_id`,`manager_score`,`date_submit`) values (6,4,26,2,NULL,NULL,2,2,'2013-11-02 19:27:26'),(6,4,27,4,NULL,NULL,2,3,'2013-11-02 19:27:26'),(6,4,28,4,NULL,NULL,2,4,'2013-11-02 19:27:26'),(6,4,29,3,NULL,NULL,2,5,'2013-11-02 19:27:26'),(6,4,30,3,NULL,NULL,2,2,'2013-11-02 19:27:26'),(6,4,31,3,NULL,NULL,2,4,'2013-11-02 19:27:26'),(6,4,32,5,NULL,NULL,2,1,'2013-11-02 19:27:26'),(6,4,33,3,NULL,NULL,2,3,'2013-11-02 19:27:26'),(6,4,34,2,NULL,NULL,2,5,'2013-11-02 19:27:26'),(6,4,35,4,NULL,NULL,2,4,'2013-11-02 19:27:27'),(7,4,26,NULL,NULL,NULL,2,1,'2013-11-04 12:19:02'),(7,4,27,NULL,NULL,NULL,2,2,'2013-11-04 12:19:02'),(7,4,28,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,29,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,30,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,31,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,32,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,33,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,34,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(7,4,35,NULL,NULL,NULL,2,5,'2013-11-04 12:19:02'),(6,5,36,NULL,NULL,NULL,2,2,'2013-11-05 08:59:53'),(6,5,37,NULL,NULL,NULL,2,3,'2013-11-05 08:59:53'),(6,5,38,NULL,NULL,NULL,2,5,'2013-11-05 08:59:54'),(6,5,39,NULL,NULL,NULL,2,2,'2013-11-05 08:59:54'),(6,5,40,NULL,NULL,NULL,2,3,'2013-11-05 08:59:54');

/*Table structure for table `tbl_appraisal_sub_categories` */

DROP TABLE IF EXISTS `tbl_appraisal_sub_categories`;

CREATE TABLE `tbl_appraisal_sub_categories` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_cat_id` int(11) DEFAULT NULL,
  `sub_category_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sub_category_id`),
  KEY `index2` (`main_cat_id`),
  KEY `fk_tbl_appraisal_sub_categories_1_idx` (`main_cat_id`),
  CONSTRAINT `fk_tbl_appraisal_sub_categories_1` FOREIGN KEY (`main_cat_id`) REFERENCES `tbl_appraisal_main_categories` (`main_category_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_sub_categories` */

insert  into `tbl_appraisal_sub_categories`(`sub_category_id`,`main_cat_id`,`sub_category_name`) values (6,6,'Job Knowledge'),(7,6,'Quantity of Work'),(8,6,'Quality of Work'),(9,6,'Timeliness'),(10,7,'Judgement and Decision Making'),(11,7,'Active Listening'),(12,7,'Critical Thinking'),(13,8,'Written Comprehension'),(14,8,'Speech CLarity'),(15,8,'Problem Sensitivity'),(16,1,'Safe and Quality Nursing Care'),(17,1,'Management of Resources and Environment');

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

/*Data for the table `tbl_department` */

insert  into `tbl_department`(`dept_id`,`dept_name`,`dept_desc`,`date_added`) values (1,'Human Resource','All about Human Resourcing','2013-06-04 16:00:00');

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

/*Data for the table `tbl_dept_goals` */

insert  into `tbl_dept_goals`(`goal_id`,`department_id`,`goal_title`,`goal_desc`,`due_date`,`days_to_remind`,`deliverables`,`success_measure`,`date_created`) values (3,1,'Improve Patient Care','To provide excellence inpatient care that is comprehensive and sensitive to their social, emotional, cultural and physical needs','2014-01-01',20,'Patient Feedback','Better Patient Feedback','2013-11-05 19:49:35'),(4,1,'Maintain Good Work Environment','To recruit, retain and develop nursing staff in a progressive environment that provides challenges and fosters creativity, personal/professional growth and displays performance of service standards.','2014-02-12',5,'Performance Status Report','Improved Nursing staff','2013-11-05 19:58:06'),(5,1,'Ensure Optimal Quality of Care','To ensure optimal quality of patient care through objective, systematic monitoring using established standards and criteria-based evaluations.','2014-09-10',20,'Report for Quality Care','Improved Quality Care within a year','2013-11-05 20:03:51'),(6,1,'Improve Nursing Research','To measure the effectiveness of nursing research through ongoing investigation and implementation of concepts and theories designed to improve patient care.','2014-01-22',15,'Effectiveness Report for the year','Nursing research will rise','2013-11-05 20:05:27');

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

/*Data for the table `tbl_duties` */

insert  into `tbl_duties`(`duty_id`,`duty_code`,`duty_name`,`duty_desc`,`date_added`) values (4,'FM01','File Maintenance','Maintain accurate, detailed reports and records.','2013-11-05 14:43:30'),(5,'NDG01','Nurse Data Gathering','Monitor, record and report symptoms and changes in patients\' conditions','2013-11-05 14:44:19'),(6,'MI09','Medical Information','Record patients\' medical information and vital signs.','2013-11-05 14:45:11'),(7,'NTP01','Nurse Treatment Plans','Modify patient treatment plans as indicated by patients\' responses and conditions.','2013-11-05 14:47:07'),(8,'PC02','Proper Coordination',' Consult and coordinate with health care team members to assess, plan, implement and evaluate patien','2013-11-05 14:47:32'),(9,'DE02','Data Evaluation','Order, interpret, and evaluate diagnostic tests to identify and assess patient\'s condition.','2013-11-05 14:49:10');

/*Table structure for table `tbl_emp_development` */

DROP TABLE IF EXISTS `tbl_emp_development`;

CREATE TABLE `tbl_emp_development` (
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

/*Data for the table `tbl_emp_development` */

insert  into `tbl_emp_development`(`user_id`,`training_id`,`date_start`,`date_end`,`comment`,`status`,`date_assigned`) values (6,5,'2013-11-04','2013-11-12','','In Progress','2013-11-05 16:40:41');

/*Table structure for table `tbl_emp_goal_comments` */

DROP TABLE IF EXISTS `tbl_emp_goal_comments`;

CREATE TABLE `tbl_emp_goal_comments` (
  `goal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_emp_goal_comments` */

insert  into `tbl_emp_goal_comments`(`goal_id`,`user_id`,`comment`,`date_commented`) values (15,2,'Test','2013-11-03 10:42:42');

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

/*Data for the table `tbl_emp_goals` */

insert  into `tbl_emp_goals`(`goal_id`,`user_id`,`goal_title`,`goal_desc`,`due_date`,`days_to_remind`,`status`,`percentage`,`deliverables`,`success_measure`,`self_score`,`peer_score`,`sup_score`,`date_created`,`approved`,`sup_comment`,`date_approved`,`dept_goal_id`) values (12,7,'test','test','2013-06-30',3,'Pending',0,'test','test',NULL,NULL,NULL,'2013-11-03 07:06:32',1,NULL,'2013-06-26 10:46:16',NULL),(14,6,'my goal','my goal','2013-09-01',3,'Completed',100,'my goal','my goal',NULL,NULL,NULL,'2013-11-03 07:15:35',1,NULL,'2013-08-28 11:53:59',NULL),(15,6,'asdasd','asd','2013-11-30',2,'Rejected',0,'asdas','dasd',NULL,NULL,NULL,'2013-11-03 10:42:42',0,NULL,'2013-11-03 05:42:01',1),(16,6,'improve self performance','njusbujdb','2014-11-01',50,'Pending',0,'self performance appraisal report','performance',NULL,NULL,NULL,'2013-11-05 08:36:52',0,NULL,NULL,2),(17,8,'Cleanliness','clean as you go','2013-11-07',1,'Pending',0,'report','attainable',NULL,NULL,NULL,'2013-11-05 19:02:49',0,NULL,NULL,2);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_emp_journals` */

insert  into `tbl_emp_journals`(`journal_id`,`user_id`,`journal_title`,`journal_desc`,`date_created`,`modified_date`) values (1,6,'The quick brown fox','The quick brown fox jumps over the lazy fucking dog.','2013-07-04 10:21:37',NULL),(2,6,'received commendation manager','received kudos because of overtime.','2013-11-05 08:44:18',NULL),(3,8,'Happy day','Im so happy','2013-11-05 19:01:58',NULL);

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

/*Data for the table `tbl_emp_perf_output` */

/*Table structure for table `tbl_emp_proc_comment` */

DROP TABLE IF EXISTS `tbl_emp_proc_comment`;

CREATE TABLE `tbl_emp_proc_comment` (
  `proc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_emp_proc_comment` */

insert  into `tbl_emp_proc_comment`(`proc_id`,`user_id`,`comment`,`status`,`date_comment`) values (4,6,'test','Rejected','2013-10-15 04:22:03');

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

/*Data for the table `tbl_emp_process` */

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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_history` */

insert  into `tbl_history`(`history_id`,`user_id`,`history`,`date_done`) values (1,2,'Created new department goal','2013-08-07 06:22:09'),(2,2,'Updated department goal','2013-08-07 06:23:57'),(3,2,'Deassigned peer to employee feedback','2013-08-08 10:55:26'),(4,2,'Assigned peer to employee feedback','2013-08-08 10:55:46'),(5,2,'Assigned peer to employee feedback','2013-08-08 10:57:05'),(6,2,'Assigned peer to employee feedback','2013-08-08 10:57:12'),(7,2,'Deassigned peer to employee feedback','2013-08-08 11:02:53'),(8,2,'Assigned peer to employee feedback','2013-08-08 11:04:47'),(9,2,'Deassigned peer to employee feedback','2013-08-08 11:05:03'),(10,2,'Assigned peer to employee feedback','2013-08-08 11:07:30'),(11,2,'Deassigned peer to employee feedback','2013-08-08 11:07:35'),(12,2,'Assigned peer to employee feedback','2013-08-08 11:07:41'),(13,2,'Assigned peer to employee feedback','2013-08-10 07:25:51'),(14,2,'Assigned peer to employee feedback','2013-08-10 07:26:23'),(15,2,'Assigned peer to employee feedback','2013-08-10 07:33:27'),(16,2,'Assigned peer to employee feedback','2013-08-10 07:33:33'),(17,2,'Assigned peer to employee feedback','2013-08-10 07:37:43'),(18,2,'Assigned peer to employee feedback','2013-08-10 07:37:49'),(19,6,'Evaluate self appraisal','2013-08-11 02:19:13'),(21,7,'Evaluate peer appraisal','2013-08-11 06:17:45'),(22,2,'Assigned peer to employee feedback','2013-08-17 03:18:10'),(23,2,'Evaluate employee appraisal','2013-08-17 03:51:21'),(24,7,'Evaluate self appraisal','2013-08-17 03:53:56'),(25,7,'Evaluate self appraisal','2013-08-17 04:11:39'),(26,2,'Evaluate employee appraisal','2013-08-17 04:12:54'),(27,2,'Evaluate employee appraisal','2013-08-17 07:29:05'),(28,6,'Evaluate peer appraisal','2013-08-17 07:58:50'),(29,2,'Change employee goal status to REJECTED','2013-08-28 15:53:49'),(30,2,'Change employee goal status to NOT STARTED','2013-08-28 15:53:59'),(31,2,'Assigned peer to employee feedback','2013-11-02 17:48:28'),(32,6,'Evaluate self appraisal','2013-11-02 19:23:35'),(33,6,'Evaluate self appraisal','2013-11-02 19:27:27'),(34,2,'Evaluate employee appraisal','2013-11-03 14:05:20'),(35,2,'Assigned peer to employee feedback','2013-11-04 12:18:15'),(36,2,'Evaluate employee appraisal','2013-11-04 12:19:02'),(37,2,'Created new department goal','2013-11-05 08:33:47'),(38,2,'Assigned peer to employee feedback','2013-11-05 08:46:44'),(39,2,'Assigned peer to employee feedback','2013-11-05 08:58:15'),(40,2,'Evaluate employee appraisal','2013-11-05 08:59:54'),(41,2,'Added new training to employee','2013-11-05 09:16:43'),(42,2,'Deleted employee training','2013-11-05 16:37:33'),(43,2,'Deleted employee training','2013-11-05 16:37:38'),(44,2,'Added new training to employee','2013-11-05 16:40:41'),(45,8,'Deleted department goal','2013-11-05 19:46:34'),(46,8,'Deleted department goal','2013-11-05 19:46:38'),(47,8,'Created new department goal','2013-11-05 19:49:35'),(48,8,'Created new department goal','2013-11-05 19:58:06'),(49,8,'Created new department goal','2013-11-05 20:03:51'),(50,8,'Created new department goal','2013-11-05 20:05:28'),(51,8,'Assigned peer to employee feedback','2013-11-06 10:14:30'),(52,8,'Assigned peer to employee feedback','2013-11-06 10:14:39');

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

/*Data for the table `tbl_job_abilities` */

insert  into `tbl_job_abilities`(`ability_id`,`job_id`,`active`,`date_added`) values (NULL,NULL,'Yes','2013-07-23 01:31:50'),(NULL,NULL,'Yes','2013-07-24 23:15:56'),(NULL,NULL,'Yes','2013-07-24 23:15:56'),(NULL,NULL,'Yes','2013-11-04 12:13:13'),(NULL,NULL,'Yes','2013-11-04 12:13:13');

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

/*Data for the table `tbl_job_activities` */

insert  into `tbl_job_activities`(`activity_id`,`job_id`,`active`,`date_added`) values (NULL,NULL,'Yes','2013-07-23 06:40:34'),(NULL,NULL,'Yes','2013-07-24 23:15:44'),(NULL,NULL,'Yes','2013-11-04 12:12:59'),(NULL,NULL,'Yes','2013-11-04 12:12:59');

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

/*Data for the table `tbl_job_duties` */

insert  into `tbl_job_duties`(`duty_id`,`job_id`,`active`,`date_added`) values (NULL,NULL,'Yes','2013-07-23 06:40:28'),(NULL,NULL,'Yes','2013-07-24 23:15:35'),(NULL,NULL,'Yes','2013-07-24 23:15:35'),(NULL,NULL,'Yes','2013-11-04 12:12:50'),(NULL,NULL,'Yes','2013-11-04 12:12:50');

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

/*Data for the table `tbl_job_skills` */

insert  into `tbl_job_skills`(`skill_id`,`job_id`,`active`,`date_added`) values (NULL,NULL,'Yes','2013-07-23 01:31:43'),(NULL,NULL,'Yes','2013-07-23 01:31:43'),(NULL,NULL,'Yes','2013-07-23 01:31:43'),(NULL,NULL,'Yes','2013-07-23 01:31:43'),(NULL,NULL,'Yes','2013-07-24 23:15:52'),(NULL,NULL,'Yes','2013-07-24 23:15:52'),(NULL,NULL,'Yes','2013-07-24 23:15:52'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06'),(NULL,NULL,'Yes','2013-11-04 12:13:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_jobs` */

insert  into `tbl_jobs`(`job_id`,`dept_id`,`job_title`,`job_desc`,`date_added`) values (6,1,'Nurse','A person trained to care for the sick or infirm especially in a hospital','0000-00-00 00:00:00');

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

/*Data for the table `tbl_journal_comments` */

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

/*Data for the table `tbl_news` */

/*Table structure for table `tbl_perf_output` */

DROP TABLE IF EXISTS `tbl_perf_output`;

CREATE TABLE `tbl_perf_output` (
  `perf_id` int(11) NOT NULL AUTO_INCREMENT,
  `perf_title` varchar(100) NOT NULL,
  `perf_desc` text NOT NULL,
  PRIMARY KEY (`perf_id`),
  KEY `perf_title` (`perf_title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='List of performance output (appraisal form); static data ';

/*Data for the table `tbl_perf_output` */

insert  into `tbl_perf_output`(`perf_id`,`perf_title`,`perf_desc`) values (1,'Job Knowledge / Skills ','The extent to which an employee demonstrates functional knowledge and the skill level required to complete the assignments efficiently and effectively. Includes learning & adapting to changing skill requirements.'),(2,'Quantity of Work','The extent to which an employee uses available working time, plans and prioritizes work to achieve a reasonable volume of work.'),(3,'Quality of Work ','The extent to which an employee exerted effort to consistently achieve desired outcomes which are accurate, thorough and with a minimum avoidable errors.'),(4,'Timeliness','The extent to which an employee is able to work quickly and deliver required output on a timely basis. Adjusts to unexpected changes in work demands to meet timetables.');

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

/*Data for the table `tbl_process` */

insert  into `tbl_process`(`proc_id`,`proc_title`,`proc_desc`,`start_date`,`end_date`,`date_added`) values (1,'Set Departmental Goals','Create goals per department to support organizations mission and vision','2014-01-06','2014-01-17','2013-11-06 09:37:55'),(2,'Create and Link Individual Goals','Create personal goals to contribute to the completion of departmental goals','2014-01-20','2014-01-31','2013-11-06 09:39:22'),(3,'Check Individual Goals','Approve or reject individual goals of employees','2014-01-20','2014-01-31','2013-11-06 09:44:06'),(4,'Take Notes of Performance','Write down significant events on your progress using the performance journal','2014-01-06','2014-12-22','2013-11-06 09:51:37'),(5,'Assign 360 Feedback 1st quarter','Select peer evaluator and schedule of performance appraisal for the first quarter','2014-03-03','2014-03-10','2013-11-06 09:54:13'),(6,'Assign 360 Feedback 2nd quarter','Select peer evaluator and schedule of performance appraisal for the second quarter','2014-06-02','2014-06-09','2013-11-06 09:56:46'),(7,'Assign 360 Feedback 3rd quarter','Select peer evaluator and schedule of performance appraisal for the third quarter','2014-09-01','2014-09-08','2013-11-06 09:57:57'),(8,'Assign 360 Feedback 4th quarter','Select peer evaluator and schedule of performance appraisal for the fourth quarter','2014-12-01','2014-12-08','2013-11-06 09:59:04');

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

/*Data for the table `tbl_process_logs` */

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

/*Data for the table `tbl_skills` */

insert  into `tbl_skills`(`skill_id`,`skill_code`,`skill_name`,`skill_desc`,`date_added`) values (9,'ACLI','Active Listening ','Giving full attention to what other people are saying, taking time to understand the points being ma','2013-11-05 15:42:19'),(10,'RECO','Reading Comprehension ','Understanding written sentences and paragraphs in work related documents.','2013-11-05 15:42:52'),(11,'CRTH','Critical Thinking','Using logic and reasoning to identify the strengths and weaknesses of alternative solutions, conclus','2013-11-05 15:43:17'),(12,'IS01','Instructing','Teaching others how to do something.','2013-11-05 15:44:03'),(13,'SP02','Speaking','Talking to others to convey information effectively.','2013-11-05 15:44:29'),(14,'TM02','Time Management ','Managing one\'s own time and the time of others','2013-11-05 15:44:56'),(15,'SO69','Service Orientation ','Actively looking for ways to help people.','2013-11-05 15:45:19'),(16,'MO29','Monitoring','Monitoring/Assessing performance of yourself, other individuals, or organizations to make improvemen','2013-11-05 15:47:27'),(17,'SOPE','Social Perceptiveness',' Being aware of others\' reactions and understanding why they react as they do.','2013-11-05 15:47:53'),(18,'WR02','Writing ','Communicating effectively in writing as appropriate for the needs of the audience.','2013-11-05 15:48:29'),(19,'AL02','Active Learning ',' Understanding the implications of new information for both current and future problem-solving and d','2013-11-05 15:48:54'),(20,'CO40','Coordination',' Adjusting actions in relation to others\' actions.','2013-11-05 15:49:19'),(21,'JADM','Judgment and Decision Making',' Considering the relative costs and benefits of potential actions to choose the most appropriate one','2013-11-05 15:49:46'),(22,'SC89','Science ','Using scientific rules and methods to solve problems.','2013-11-05 15:50:17'),(23,'LEST','Learning Strategies ',' Selecting and using training/instructional methods and procedures appropriate for the situation whe','2013-11-05 15:50:49'),(24,'CPS0','Complex Problem Solving ',' Identifying complex problems and reviewing related information to develop and evaluate options and ','2013-11-05 15:51:45'),(25,'MATH','Mathematics ','Using mathematics to solve problems.','2013-11-05 15:52:10'),(26,'PER1','Persuasion ','Persuading others to change their minds or behavior.','2013-11-05 15:52:38'),(27,'NE02','Negotiation ','Bringing others together and trying to reconcile differences.','2013-11-05 15:53:02'),(28,'OPMO','Operation Monitoring ','Watching gauges, dials, or other indicators to make sure a machine is working properly.','2013-11-05 15:53:22'),(29,'EQSE','Equipment Selection',' Determining the kind of tools and equipment needed to do a job.','2013-11-05 15:53:48');

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

/*Data for the table `tbl_training_abilities` */

insert  into `tbl_training_abilities`(`training_id`,`ability_id`,`date_added`) values (5,4,'2013-11-05 16:31:40'),(5,6,'2013-11-05 16:31:40'),(5,10,'2013-11-05 16:31:40'),(5,13,'2013-11-05 16:31:40'),(5,15,'2013-11-05 16:31:40'),(6,4,'2013-11-05 16:34:51'),(6,7,'2013-11-05 16:34:51'),(6,9,'2013-11-05 16:34:51'),(6,10,'2013-11-05 16:34:51'),(6,15,'2013-11-05 16:34:51'),(6,19,'2013-11-05 16:34:51'),(7,4,'2013-11-05 16:59:17'),(7,5,'2013-11-05 16:59:17'),(7,6,'2013-11-05 16:59:17'),(7,10,'2013-11-05 16:59:17'),(7,14,'2013-11-05 16:59:17'),(7,15,'2013-11-05 16:59:17'),(8,4,'2013-11-05 17:00:30'),(8,7,'2013-11-05 17:00:30'),(8,8,'2013-11-05 17:00:30'),(8,9,'2013-11-05 17:00:30'),(8,12,'2013-11-05 17:00:30'),(8,13,'2013-11-05 17:00:30'),(8,14,'2013-11-05 17:00:30'),(8,15,'2013-11-05 17:00:30'),(8,19,'2013-11-05 17:00:30'),(9,4,'2013-11-05 17:01:20'),(9,7,'2013-11-05 17:01:20'),(9,9,'2013-11-05 17:01:20'),(9,13,'2013-11-05 17:01:20'),(9,15,'2013-11-05 17:01:20'),(10,4,'2013-11-05 17:02:43'),(10,7,'2013-11-05 17:02:43'),(10,11,'2013-11-05 17:02:44'),(10,13,'2013-11-05 17:02:44'),(10,14,'2013-11-05 17:02:44'),(10,15,'2013-11-05 17:02:44'),(11,4,'2013-11-05 17:04:06'),(11,5,'2013-11-05 17:04:06'),(11,6,'2013-11-05 17:04:06'),(11,11,'2013-11-05 17:04:06'),(11,12,'2013-11-05 17:04:07'),(11,15,'2013-11-05 17:04:07'),(11,19,'2013-11-05 17:04:07'),(12,4,'2013-11-05 17:06:40'),(12,9,'2013-11-05 17:06:40'),(12,13,'2013-11-05 17:06:40'),(12,14,'2013-11-05 17:06:40'),(12,15,'2013-11-05 17:06:40'),(13,4,'2013-11-05 17:08:45'),(13,5,'2013-11-05 17:08:45'),(13,6,'2013-11-05 17:08:45'),(13,7,'2013-11-05 17:08:45'),(13,8,'2013-11-05 17:08:45'),(13,9,'2013-11-05 17:08:45'),(13,10,'2013-11-05 17:08:45'),(13,11,'2013-11-05 17:08:45'),(13,12,'2013-11-05 17:08:45'),(13,13,'2013-11-05 17:08:45'),(13,14,'2013-11-05 17:08:45'),(13,15,'2013-11-05 17:08:45'),(13,16,'2013-11-05 17:08:45'),(13,17,'2013-11-05 17:08:45'),(13,18,'2013-11-05 17:08:45'),(13,19,'2013-11-05 17:08:45');

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

/*Data for the table `tbl_training_skills` */

insert  into `tbl_training_skills`(`training_id`,`skill_id`,`date_added`) values (5,9,'2013-11-05 16:31:40'),(5,11,'2013-11-05 16:31:40'),(5,13,'2013-11-05 16:31:40'),(5,19,'2013-11-05 16:31:40'),(5,20,'2013-11-05 16:31:40'),(5,29,'2013-11-05 16:31:40'),(6,9,'2013-11-05 16:34:51'),(6,10,'2013-11-05 16:34:51'),(6,11,'2013-11-05 16:34:51'),(6,19,'2013-11-05 16:34:51'),(6,20,'2013-11-05 16:34:51'),(6,24,'2013-11-05 16:34:51'),(6,25,'2013-11-05 16:34:51'),(7,9,'2013-11-05 16:59:16'),(7,11,'2013-11-05 16:59:16'),(7,12,'2013-11-05 16:59:16'),(7,15,'2013-11-05 16:59:16'),(7,16,'2013-11-05 16:59:16'),(7,17,'2013-11-05 16:59:17'),(7,19,'2013-11-05 16:59:17'),(7,20,'2013-11-05 16:59:17'),(7,25,'2013-11-05 16:59:17'),(8,9,'2013-11-05 17:00:30'),(8,11,'2013-11-05 17:00:30'),(8,16,'2013-11-05 17:00:30'),(8,20,'2013-11-05 17:00:30'),(8,23,'2013-11-05 17:00:30'),(8,24,'2013-11-05 17:00:30'),(9,9,'2013-11-05 17:01:20'),(9,11,'2013-11-05 17:01:20'),(9,14,'2013-11-05 17:01:20'),(9,16,'2013-11-05 17:01:20'),(9,17,'2013-11-05 17:01:20'),(9,18,'2013-11-05 17:01:20'),(9,21,'2013-11-05 17:01:20'),(9,23,'2013-11-05 17:01:20'),(9,29,'2013-11-05 17:01:20'),(10,9,'2013-11-05 17:02:43'),(10,13,'2013-11-05 17:02:43'),(10,15,'2013-11-05 17:02:43'),(10,19,'2013-11-05 17:02:43'),(10,21,'2013-11-05 17:02:43'),(10,24,'2013-11-05 17:02:43'),(10,29,'2013-11-05 17:02:43'),(11,9,'2013-11-05 17:04:06'),(11,10,'2013-11-05 17:04:06'),(11,11,'2013-11-05 17:04:06'),(11,12,'2013-11-05 17:04:06'),(11,15,'2013-11-05 17:04:06'),(11,16,'2013-11-05 17:04:06'),(11,19,'2013-11-05 17:04:06'),(11,20,'2013-11-05 17:04:06'),(11,23,'2013-11-05 17:04:06'),(11,28,'2013-11-05 17:04:06'),(12,9,'2013-11-05 17:06:40'),(12,10,'2013-11-05 17:06:40'),(12,12,'2013-11-05 17:06:40'),(12,13,'2013-11-05 17:06:40'),(12,14,'2013-11-05 17:06:40'),(12,15,'2013-11-05 17:06:40'),(12,16,'2013-11-05 17:06:40'),(12,17,'2013-11-05 17:06:40'),(12,18,'2013-11-05 17:06:40'),(12,19,'2013-11-05 17:06:40'),(13,9,'2013-11-05 17:08:44'),(13,10,'2013-11-05 17:08:44'),(13,11,'2013-11-05 17:08:44'),(13,12,'2013-11-05 17:08:44'),(13,13,'2013-11-05 17:08:44'),(13,14,'2013-11-05 17:08:44'),(13,15,'2013-11-05 17:08:44'),(13,16,'2013-11-05 17:08:44'),(13,17,'2013-11-05 17:08:44'),(13,18,'2013-11-05 17:08:44'),(13,19,'2013-11-05 17:08:44'),(13,20,'2013-11-05 17:08:44'),(13,21,'2013-11-05 17:08:44'),(13,22,'2013-11-05 17:08:44'),(13,23,'2013-11-05 17:08:44'),(13,24,'2013-11-05 17:08:44'),(13,25,'2013-11-05 17:08:44'),(13,26,'2013-11-05 17:08:44'),(13,27,'2013-11-05 17:08:45'),(13,28,'2013-11-05 17:08:45'),(13,29,'2013-11-05 17:08:45');

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

/*Data for the table `tbl_trainings` */

insert  into `tbl_trainings`(`training_id`,`training_title`,`training_desc`,`duration`,`date_created`) values (5,'BASIC SKILLS ENHANCEMENT TRAINING PROGRAM','This course aims to develop nurses\' knowledge, skills and attitude in the performance of techniques and procedures with an understanding of the principles involved.',60,'2013-11-05 16:31:40'),(6,'BASIC I.V. THERAPY TRAINING','This program aims to enhance the nurse\'s knowledge and skill in the delivery of their expanded role as intravenous nurse therapists.',30,'2013-11-05 16:34:51'),(7,'POST-GRADUATE COURSE IN PULMONOLOGY NURSING','This program is conceptualized in line with the hospital-based nurses of the future, a stepping stone toward a clinical nurse specialist as far as respiratory care is concerned.  The health care system of the future will inevitably be fragmented because of the competitive health market hence, there is a need to intensify our knowledge and skill through an understanding of the underlying principles and concepts in order to develop a high degree of expertise in the care of patients with respiratory diseases.',80,'2013-11-05 16:59:16'),(8,'ONCOLOGY NURSING ','This course deals with basic concepts in cancer and the principles in cancer therapy, focusing on the roles and responsibilities of the nurse in cancer management.',40,'2013-11-05 17:00:30'),(9,'POST-GRADUATE COURSE IN CRITICAL CARE NURSING','The Intensive Care Unit (ICU) is a specialized unit requiring a new type of nurse, one who possesses the essential knowledge, skills and qualities that will assist him/her to perform effectively in a more sophisticated and technologically advanced environment.  With the greater responsibilities that an ICU nurse carries, it is necessary that adequate training be provided to help him/her cope with the demands and challenges of the critical care setting.',320,'2013-11-05 17:01:19'),(10,'RESPIRATORY EMERGENCY NURSING','Respiratory Emergency Nursing connotes a compelling urgency and is seen as a real challenge to nurses.  Nursing practice in the emergency room demands the best of our energies and capabilities in accurate assessment, utilization of sound clinical judgment where life support and effective intervention is the main concern.',320,'2013-11-05 17:02:43'),(11,'OPERATING ROOM NURSING PROGRAM','This program aims to prepare nurses to be effective and efficient members of the surgical team and make her aware of her vital role as caregiver to patients peri-operatively.',12,'2013-11-05 17:04:06'),(12,'SKILLS ENHANCEMENT TRAINING FOR NURSING ATTENDANTS','This course provides the participants with the essential knowledge and skills in the performance of basic, yet vital nursing procedures as well as equipping them with up-to-date techniques in assisting patients.',12,'2013-11-05 17:06:40'),(13,'WARD CLERK TRAINING PROGRAM ','This program is designed to orient, train and develop qualified nursing aides to the tasks and other related activities performed by the ward clerk.',12,'2013-11-05 17:08:44');

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

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`uname`,`pword`,`lvl`,`fname`,`mname`,`lname`,`home_address`,`email`,`home_phone`,`mobile_phone`,`birthday`,`gender`,`tin_id`,`sss_id`,`pagibig_id`,`philhealth_id`,`emergency_phone`,`emergency_contact`,`department_id`,`job_id`,`last_login`,`avatar`) values (1,'admin','e6e061838856bf47e1de730719fb2609','1','Administrator','','','','','','','0000-00-00','','','','','','','',0,0,'2013-11-07 11:25:51',''),(2,'test','827ccb0eea8a706c4c34a16891f84e7b','2','test','test','test',' test ','test@test.com','123456','12345','1993-06-01','Male','','','','','1321','test',1,2,'2013-11-07 11:25:26',''),(6,'malbitos','827ccb0eea8a706c4c34a16891f84e7b','3','Mark','test','Albitos','asdasdasd        ','asdasdas@123.com','+123123','+123123','1990-06-13','Male','','','','','123123','Asdasd',1,2,'2013-11-05 17:41:15',''),(7,'jdelacruz','827ccb0eea8a706c4c34a16891f84e7b','3','Juan Miguel','Santo Domingo','Dela Cruz','  asd','asd@asd.com','1231231','12312312','1958-06-10','Male','','','','','123123','klnfldsnflsdnf',1,2,'2013-11-03 04:14:22',''),(8,'marcgwapo00','39911e864d61032151e9db601c1d76d0','2','Marc Esperanza','Fullon','Esperanza','        130 Melanie Marquez BFRV Las Pinas City      ','marcgwapo00@yahoo.com','8460052','09167125456','1989-10-27','Male','','','','','09175779072','Muriel F Esperanza',1,6,'2013-11-06 12:02:37','user/1383672413_810017.jpg'),(9,'botong09','827ccb0eea8a706c4c34a16891f84e7b','3','Carlos','S','Garcia','   99 san fernando st Laguna  ','botong09@yahoo.com','8729695','09158764908','1989-10-02','Male','','','','','8887546','Ema Garcia',1,6,'2013-11-05 20:04:11',''),(10,'patmalolos','827ccb0eea8a706c4c34a16891f84e7b','3','Patrick','G','Malolos','  87 st. Maria Clara Quezon City','patmalopatmalo@yahoo.com','8672918','09176784657','1989-01-10','Male','','','','','8477568','Mariel Malolos',1,6,NULL,''),(11,'Fral1992','827ccb0eea8a706c4c34a16891f84e7b','3','David','P','Turner','   3026 Comfort Court\r\nMadison, WI 53715 ','DavidPTurner@teleworm.us','8172357','0987123487','1987-05-08','Male','','','','','8923849','not available',1,6,NULL,''),(12,'Satte1989','827ccb0eea8a706c4c34a16891f84e7b','3','Warren','R','Bourque','  884 Spring Haven Trail\r\nRochelle Park, NJ 07662','WarrenRBourque@rhyta.com','8679345','09156789659','1979-04-11','Male','','','','','8976568','Rawa Borque',1,6,NULL,''),(13,'Thoulieve1981','827ccb0eea8a706c4c34a16891f84e7b','3','Jason ','C','Wilson','3079 Cunningham Court\r\nRoyal Oak, MI 48067','JasonCWilson@dayrep.com','84643928','0917568433','1981-08-25','Male','','','','','8568432','Rachel Wilson',1,6,NULL,''),(14,'Oplity','827ccb0eea8a706c4c34a16891f84e7b','3','Thomas','F','Reel','  2806 Formula Lane\r\nMc Kinney, TX 75069','ThomasPReel@armyspy.com','8093328','09287654738','1981-12-26','Male','','','','','9439485','Tammy Reel',1,6,NULL,''),(15,'Ristraid1986','827ccb0eea8a706c4c34a16891f84e7b','3','William ','T','Gay','  2704 Nicholas Street\r\nBrookville, KS 67425','WilliamTGay@jourrapide.com','8932948','09185464738','1986-11-23','Male','','','','','8948573','Mary Gay',1,6,NULL,''),(16,'Quitorger','827ccb0eea8a706c4c34a16891f84e7b','3','Whitney ','H','Ranson','  625 Horner Street\r\nYoungstown, OH 44503','WhitneyHRanson@dayrep.com','8657348','09175467384','1992-03-18','Female','','','','','89348573','Ramil Ranson',1,6,NULL,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
