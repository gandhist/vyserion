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

/*Table structure for table `empallded` */

DROP TABLE IF EXISTS `empallded`;

CREATE TABLE `empallded` (
  `id_adhoc` int(100) NOT NULL AUTO_INCREMENT,
  `empcode` int(15) NOT NULL,
  `inputby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updateby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `adhoc_date` date DEFAULT NULL,
  `amount` double(100,0) DEFAULT NULL,
  `allowded_code` varchar(10) DEFAULT NULL,
  `deduction` varchar(10) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_adhoc`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `empallded` */

insert  into `empallded` values (1,1800002,'gandhi','2018-02-17 09:58:05','gandhi','2018-02-18 07:55:50','2018-02-19',80000,'D03',NULL,'ganti rugi minum kopi bos'),(3,1800001,'gandhi','2018-02-19 04:24:06',NULL,NULL,'2018-01-25',1830577,'D01',NULL,'potongan HK 19 Hari'),(4,1800001,'gandhi','2018-03-10 10:00:45','gandhi','2018-03-11 12:39:30','2018-01-20',101110,'A05',NULL,'awal masuk jamsostek tidak dibayarkan'),(5,1800001,'gandhi','2018-04-03 11:04:20',NULL,NULL,'2018-03-20',115000,'D05',NULL,'uang insentive kopi dan snack'),(6,1800001,'nugraha','2018-04-04 10:51:16',NULL,NULL,'2018-03-03',2000000,'A01',NULL,'dummy rapel');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
