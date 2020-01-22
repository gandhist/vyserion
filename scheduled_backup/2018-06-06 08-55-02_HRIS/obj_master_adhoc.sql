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

/*Table structure for table `master_adhoc` */

DROP TABLE IF EXISTS `master_adhoc`;

CREATE TABLE `master_adhoc` (
  `allowded_code` varchar(10) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `inputby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updateby` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`allowded_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_adhoc` */

insert  into `master_adhoc` values ('A01','Rapel Gaji',NULL,NULL,NULL,NULL),('A02','Kurang Bayar Gaji',NULL,NULL,NULL,NULL),('A03','Premi',NULL,NULL,NULL,NULL),('A04','Bonus HM',NULL,NULL,NULL,NULL),('A05','Adjustment Jamsostek - JPK',NULL,NULL,NULL,NULL),('D01','Potongan Sisa HK',NULL,NULL,NULL,NULL),('D02','Potongan Pinjaman Karyawan',NULL,NULL,NULL,NULL),('D03','Potongan Ganti Rugi',NULL,NULL,NULL,NULL),('D04','Potongan Lebih Bayar',NULL,NULL,NULL,NULL),('D05','Potongan Lain-Lain',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
