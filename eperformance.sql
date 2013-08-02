/*
SQLyog Community v11.1 Beta2 (32 bit)
MySQL - 5.5.32-0ubuntu0.12.04.1 : Database - eperformance
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_abilities` */

insert  into `tbl_abilities`(`ability_id`,`ability_code`,`ability_name`,`ability_desc`,`date_added`) values (2,'AB','test ability','test ability','2013-06-19 18:31:52'),(3,'AB2','test ability 2','test ability 2','2013-06-19 18:32:13');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_activities` */

insert  into `tbl_activities`(`activity_id`,`activity_code`,`activity_name`,`activity_desc`,`date_added`) values (2,'AC','test activity','test activity','2013-06-19 18:32:29'),(3,'AC2','test activity 2','test activity 2','2013-06-19 18:32:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal` */

insert  into `tbl_appraisal`(`appraisal_id`,`job_id`,`appraisal_title`,`appraisal_desc`,`date_created`) values (2,2,'The quick brown fox jumps over the lazy dog','The quick brown fox jumps over the lazy dog','2013-08-01 13:48:53');

/*Table structure for table `tbl_appraisal_assignment` */

DROP TABLE IF EXISTS `tbl_appraisal_assignment`;

CREATE TABLE `tbl_appraisal_assignment` (
  `user_id` int(11) DEFAULT NULL,
  `peer_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT NULL,
  `date_assigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `peer_id` (`peer_id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_assignment` */

/*Table structure for table `tbl_appraisal_questionaire` */

DROP TABLE IF EXISTS `tbl_appraisal_questionaire`;

CREATE TABLE `tbl_appraisal_questionaire` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_id` int(11) DEFAULT NULL,
  `question` text,
  `category` enum('skills','abl','core','perf') DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `appraisal_id` (`appraisal_id`),
  CONSTRAINT `tbl_appraisal_questionaire_ibfk_1` FOREIGN KEY (`appraisal_id`) REFERENCES `tbl_appraisal` (`appraisal_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_appraisal_questionaire` */

insert  into `tbl_appraisal_questionaire`(`question_id`,`appraisal_id`,`question`,`category`) values (6,2,'The quick brown fox jumps over the lazy dog','core'),(7,2,'The quick brown fox jumps over the lazy dog','core'),(8,2,'The quick brown fox jumps over the lazy dog','core'),(9,2,'test','perf'),(10,2,'test1','perf'),(11,2,'test2','skills'),(12,2,'test3','skills'),(13,2,'test5','abl'),(14,2,'test7','abl');

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

/*Table structure for table `tbl_department` */

DROP TABLE IF EXISTS `tbl_department`;

CREATE TABLE `tbl_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_desc` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dept_id`),
  KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_department` */

insert  into `tbl_department`(`dept_id`,`dept_name`,`dept_desc`,`date_added`) values (1,'Human Resource','All about Human Resourcing','2013-06-05 00:00:00'),(4,'Accounting','Accounting','2013-06-09 23:21:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Department goals';

/*Data for the table `tbl_dept_goals` */

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_duties` */

insert  into `tbl_duties`(`duty_id`,`duty_code`,`duty_name`,`duty_desc`,`date_added`) values (2,'DT','test duty','test duty','2013-06-19 18:33:04'),(3,'DT2','test duty 2','test duty 2','2013-06-19 18:33:14');

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

insert  into `tbl_emp_development`(`user_id`,`training_id`,`date_start`,`date_end`,`comment`,`status`,`date_assigned`) values (6,4,'2013-07-08','2013-07-12','','In Progress','2013-07-04 04:30:54'),(6,3,'2013-07-22','2013-07-24','','In Progress','2013-07-04 18:57:22');

/*Table structure for table `tbl_emp_goals` */

DROP TABLE IF EXISTS `tbl_emp_goals`;

CREATE TABLE `tbl_emp_goals` (
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='Goals set by employees';

/*Data for the table `tbl_emp_goals` */

insert  into `tbl_emp_goals`(`goal_id`,`user_id`,`goal_title`,`goal_desc`,`due_date`,`days_to_remind`,`status`,`percentage`,`deliverables`,`success_measure`,`self_score`,`peer_score`,`sup_score`,`date_created`,`approved`,`sup_comment`,`date_approved`) values (12,7,'test','test','2013-06-30',3,'Not Started',0,'test','test',NULL,NULL,NULL,'2013-06-26 10:46:16',1,NULL,'2013-06-26 10:46:16'),(14,6,'my goal','my goal','2013-09-01',3,'In Progress',90,'my goal','my goal',NULL,NULL,NULL,'2013-06-26 10:52:33',1,NULL,'2013-06-26 10:45:59');

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

/*Data for the table `tbl_emp_journals` */

insert  into `tbl_emp_journals`(`journal_id`,`user_id`,`journal_title`,`journal_desc`,`date_created`,`modified_date`) values (1,6,'The quick brown fox','The quick brown fox jumps over the lazy fucking dog.','2013-07-04 18:21:37',NULL);

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

/*Table structure for table `tbl_emp_process` */

DROP TABLE IF EXISTS `tbl_emp_process`;

CREATE TABLE `tbl_emp_process` (
  `user_id` int(11) DEFAULT NULL,
  `process_id` int(11) DEFAULT NULL,
  `date_accomplished` datetime DEFAULT NULL,
  `date_assigned` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  KEY `process_id` (`process_id`),
  CONSTRAINT `tbl_emp_process_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_emp_process_ibfk_2` FOREIGN KEY (`process_id`) REFERENCES `tbl_process` (`proc_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_emp_process` */

insert  into `tbl_emp_process`(`user_id`,`process_id`,`date_accomplished`,`date_assigned`) values (2,NULL,NULL,'2013-07-18 11:49:33'),(8,NULL,NULL,'2013-07-18 11:49:33'),(2,4,NULL,'2013-07-18 11:50:19'),(6,4,NULL,'2013-07-18 11:50:19'),(8,4,NULL,'2013-07-18 11:50:19');

/*Table structure for table `tbl_history` */

DROP TABLE IF EXISTS `tbl_history`;

CREATE TABLE `tbl_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `history` varchar(255) DEFAULT NULL,
  `module` enum('goal','training','appraisal','account') DEFAULT NULL,
  `date_done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_history` */

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

insert  into `tbl_job_abilities`(`ability_id`,`job_id`,`active`,`date_added`) values (3,NULL,'Yes','2013-07-23 09:31:50'),(2,4,'Yes','2013-07-25 07:15:56'),(3,4,'Yes','2013-07-25 07:15:56');

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

insert  into `tbl_job_activities`(`activity_id`,`job_id`,`active`,`date_added`) values (3,NULL,'Yes','2013-07-23 14:40:34'),(3,4,'Yes','2013-07-25 07:15:44');

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

insert  into `tbl_job_duties`(`duty_id`,`job_id`,`active`,`date_added`) values (2,NULL,'Yes','2013-07-23 14:40:28'),(2,4,'Yes','2013-07-25 07:15:35'),(3,4,'Yes','2013-07-25 07:15:35');

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

insert  into `tbl_job_skills`(`skill_id`,`job_id`,`active`,`date_added`) values (3,NULL,'Yes','2013-07-23 09:31:43'),(5,NULL,'Yes','2013-07-23 09:31:43'),(6,NULL,'Yes','2013-07-23 09:31:43'),(8,NULL,'Yes','2013-07-23 09:31:43'),(2,4,'Yes','2013-07-25 07:15:52'),(7,4,'Yes','2013-07-25 07:15:52'),(8,4,'Yes','2013-07-25 07:15:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_jobs` */

insert  into `tbl_jobs`(`job_id`,`dept_id`,`job_title`,`job_desc`,`date_added`) values (2,1,'Employee Relations','Employee Relations','2013-06-05 00:00:00'),(4,4,'Accountant','Accountant','0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_process` */

insert  into `tbl_process`(`proc_id`,`proc_title`,`proc_desc`,`start_date`,`end_date`,`date_added`) values (4,'Update Job Specifications','Update Job Specifications','2013-07-18','2013-07-22','2013-07-17 10:51:15');

/*Table structure for table `tbl_skills` */

DROP TABLE IF EXISTS `tbl_skills`;

CREATE TABLE `tbl_skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_code` tinytext,
  `skill_name` varchar(100) DEFAULT NULL,
  `skill_desc` varchar(100) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_skills` */

insert  into `tbl_skills`(`skill_id`,`skill_code`,`skill_name`,`skill_desc`,`date_added`) values (2,'test1','test skill','test skill','2013-06-19 18:30:41'),(3,'t2','test skill 2','test skill 2','2013-06-19 18:30:51'),(4,'t3','test skill 3','test skill 3','2013-06-19 19:03:48'),(5,'t4','test skill 4','test skill','2013-06-19 19:04:01'),(6,'t5','test skill 5','test skill','2013-06-19 19:04:17'),(7,'t6','test skill 6','test skill','2013-06-19 19:04:28'),(8,'t7','test skill 7','test skill 7','2013-06-20 10:08:05');

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

insert  into `tbl_training_abilities`(`training_id`,`ability_id`,`date_added`) values (3,2,'2013-06-28 02:29:27'),(4,2,'2013-06-30 02:18:10'),(4,3,'2013-06-30 02:18:10');

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

insert  into `tbl_training_skills`(`training_id`,`skill_id`,`date_added`) values (3,2,'2013-06-28 02:29:27'),(3,4,'2013-06-28 02:29:27'),(3,7,'2013-06-28 02:29:27'),(4,2,'2013-06-30 02:18:09'),(4,4,'2013-06-30 02:18:10'),(4,6,'2013-06-30 02:18:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_trainings` */

insert  into `tbl_trainings`(`training_id`,`training_title`,`training_desc`,`duration`,`date_created`) values (3,'Test 1','Test 1',10,'2013-06-28 02:29:27'),(4,'test 2','test 2',5,'2013-06-30 02:18:09');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`uname`,`pword`,`lvl`,`fname`,`mname`,`lname`,`home_address`,`email`,`home_phone`,`mobile_phone`,`birthday`,`gender`,`tin_id`,`sss_id`,`pagibig_id`,`philhealth_id`,`emergency_phone`,`emergency_contact`,`department_id`,`job_id`,`last_login`,`avatar`) values (1,'admin','e6e061838856bf47e1de730719fb2609','1','Administrator','','','','','','','0000-00-00','','','','','','','',0,0,'2013-08-02 13:40:15',''),(2,'test','827ccb0eea8a706c4c34a16891f84e7b','2','test','test','test',' test ','test@test.com','123456','12345','1993-06-01','Male','','','','','1321','test',1,2,'2013-08-02 16:11:05',''),(5,'asd','3641265abc04ff623b3c82c131848950','2','asdasd','sdsad','asd','     asd       ','asd@asd.com','+123123','+123123','2013-06-09','Male','','','','','123123','asdasd',1,2,NULL,''),(6,'malbitos','827ccb0eea8a706c4c34a16891f84e7b','3','Mark','test','Albitos','asdasdasd        ','asdasdas@123.com','+123123','+123123','1990-06-13','Male','','','','','123123','Asdasd',1,2,'2013-07-08 11:11:56',''),(7,'jdelacruz','827ccb0eea8a706c4c34a16891f84e7b','3','Juan Miguel','Santo Domingo','Dela Cruz','  asd','asd@asd.com','1231231','12312312','1958-06-10','Male','','','','','123123','klnfldsnflsdnf',1,2,'2013-06-26 10:03:55',''),(8,'klasdl','4bfd200eba0c0fb877d110b50805fd88','3','asdasd','sdkasdl','askdakls','     asdasda   ','asdasd@asd.com','123123','12312312','2013-06-11','Male','','','','','123123','asdasd',1,2,NULL,'user/1370944.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
