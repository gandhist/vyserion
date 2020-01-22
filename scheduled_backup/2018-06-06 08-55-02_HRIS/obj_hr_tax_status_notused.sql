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

/*Table structure for table `hr_tax_status_notused` */

DROP TABLE IF EXISTS `hr_tax_status_notused`;

CREATE TABLE `hr_tax_status_notused` (
  `empcode` int(15) NOT NULL,
  `start_date` date DEFAULT NULL,
  `familystatustax` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `familystatusrice` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `inputby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updateby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hr_tax_status_notused` */

insert  into `hr_tax_status_notused` values (1800002,'2018-01-01','TK/0','TK/0','gandhi','2018-02-07 00:00:00',NULL,NULL),(1800002,'2018-02-02','K/1','K/1','gandhi','2018-02-07 00:00:00',NULL,NULL),(1800004,'2018-02-03','K/3','K/3','gandhi','2018-02-07 00:00:00',NULL,NULL),(1800003,'2007-03-13','K/0','K/0','gandhi','2018-02-07 00:00:00',NULL,NULL),(1800003,'1999-01-01','K/3','K/2','gandhi','2018-02-08 00:00:00',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
