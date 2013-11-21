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
/*Table structure for table `tbl_succession_master` */

DROP TABLE IF EXISTS `tbl_succession_master`;

CREATE TABLE `tbl_succession_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text,
  `type` enum('potential','timing','risk','reason') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_succession_master` */

insert  into `tbl_succession_master`(`id`,`desc`,`type`) values (1,'high potential - potential to move 2-3 levels','potential'),(2,'promotable - potential to move 1 level','potential'),(3,'well placed in current role','potential'),(4,'needs development in current role','potential'),(5,'not acceptible in current role','potential'),(6,'too new to rate','potential'),(7,'immediate - ready for promotion','timing'),(8,'within 1 year','timing'),(9,'within 2 year','timing'),(10,'greater than 2 years','timing'),(11,'too new to rate','timing'),(12,'none - not likely to leave','risk'),(13,'low - likely to leave within 5 years','risk'),(14,'medium - likely to leave within 1 year','risk'),(15,'high - likely to leave within the year','risk'),(16,'too new to rate','risk'),(17,'approaching retirement','reason'),(18,'lack of growth opportunities','reason'),(19,'returning to school','reason'),(20,'dissatisfied with compensation','reason'),(21,'other reason','reason'),(22,'not applicable','reason');

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

/*Data for the table `tbl_succession_plan` */

insert  into `tbl_succession_plan`(`succession_id`,`user_id`,`potential`,`timing`,`risk_of_leaving`,`reason_for_leaving`) values (1,6,2,8,12,21);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
