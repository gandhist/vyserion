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

/*Table structure for table `hr_termination` */

DROP TABLE IF EXISTS `hr_termination`;

CREATE TABLE `hr_termination` (
  `empcode` int(15) NOT NULL,
  `datejoin` date DEFAULT NULL,
  `dateterminate` date DEFAULT NULL,
  `terminatetype` int(10) DEFAULT NULL,
  `reasonofresign` text,
  `terminationamount` int(100) DEFAULT NULL,
  `pensionamount` int(100) DEFAULT NULL,
  `approvedby` int(15) DEFAULT NULL,
  `approveddate` date DEFAULT NULL,
  `worktime` int(10) DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `inputby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  PRIMARY KEY (`empcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hr_termination` */

insert  into `hr_termination` values (1800130,NULL,'2018-04-18',3,'memalsukan tanda tangan, tidak transparan dalam melakukan job desk nya, SP2 bulan Maret 2018',0,0,NULL,'2018-04-18',NULL,NULL,'supatno','2018-05-22 08:34:45');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
