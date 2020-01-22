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

/*Table structure for table `absen_pengaturan` */

DROP TABLE IF EXISTS `absen_pengaturan`;

CREATE TABLE `absen_pengaturan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_mesin` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `absen_pengaturan` */

insert  into `absen_pengaturan` values (1,'192.168.11.236','0','mesin_produksi');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
