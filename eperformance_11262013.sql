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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
  `main_category_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`main_category_id`)
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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
