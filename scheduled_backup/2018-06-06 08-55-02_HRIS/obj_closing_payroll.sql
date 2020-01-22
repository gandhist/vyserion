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

/*Table structure for table `closing_payroll` */

DROP TABLE IF EXISTS `closing_payroll`;

CREATE TABLE `closing_payroll` (
  `payroll_seq` int(255) NOT NULL AUTO_INCREMENT,
  `period` int(12) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `empcode` int(15) DEFAULT NULL,
  `empname` varchar(50) DEFAULT NULL,
  `position` varchar(40) DEFAULT NULL,
  `position_desc` varchar(200) DEFAULT NULL,
  `departement` int(30) DEFAULT NULL,
  `dept_desc` varchar(20) DEFAULT NULL,
  `upah` decimal(10,2) DEFAULT NULL,
  `kehadiran_pagi` int(255) DEFAULT NULL,
  `deduction` double(100,0) DEFAULT NULL,
  `allowance` double(100,0) DEFAULT NULL,
  `jamsostek` decimal(10,2) DEFAULT NULL,
  `jpk` decimal(10,2) DEFAULT NULL,
  `hk` int(255) DEFAULT NULL,
  `kehadiran_bulanan` decimal(10,2) DEFAULT NULL,
  `upah_perjam` decimal(10,2) DEFAULT NULL,
  `jam_lembur` double(255,1) DEFAULT NULL,
  `uang_lembur` decimal(10,2) DEFAULT NULL,
  `insentive_snack` decimal(10,2) DEFAULT NULL,
  `total_pendapatan` decimal(10,2) DEFAULT NULL,
  `total_potongan` decimal(10,2) DEFAULT NULL,
  `gaji_bersih` decimal(10,2) DEFAULT NULL,
  `inputby` varchar(30) DEFAULT NULL,
  `updateby` varchar(30) DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`payroll_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `closing_payroll` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
