/*
SQLyog Job Agent v10.42 Copyright(c) Webyog Inc. All Rights Reserved.


MySQL - 5.5.5-10.1.13-MariaDB : Database - hris
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hris` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `hris`;

/*Table structure for table `hr_tax_status` */

DROP TABLE IF EXISTS `hr_tax_status`;

CREATE TABLE `hr_tax_status` (
  `id_tax_sk` int(10) NOT NULL AUTO_INCREMENT,
  `empcode` int(15) NOT NULL,
  `start_date` date DEFAULT NULL,
  `familystatustax` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `familystatusrice` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `inputby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updateby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tax_sk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `hr_tax_status` */

insert  into `hr_tax_status` values (1,1800002,'2017-08-22','TK/0','TK/0','gandhi','2018-02-08 00:00:00','gandhi','2018-02-15 23:45:23'),(2,1800002,'2018-02-20','K/1','K/2','gandhi','2018-02-08 00:00:00','gandhi','2018-02-08 10:38:04'),(3,1800002,'2018-02-21','K/2','K/2','gandhi','2018-02-08 00:00:00','gandhi','2018-02-08 12:06:59'),(4,1800001,'2017-02-24','TK/0','TK/0','gandhi','2018-02-08 11:47:53',NULL,NULL),(5,1800001,'2019-01-01','TK/0','TK/0','gandhi','2018-02-08 11:47:53','gandhi','2018-03-01 10:47:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
