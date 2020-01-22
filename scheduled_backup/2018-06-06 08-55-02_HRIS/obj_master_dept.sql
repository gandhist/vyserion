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

/*Table structure for table `master_dept` */

DROP TABLE IF EXISTS `master_dept`;

CREATE TABLE `master_dept` (
  `departement` int(30) NOT NULL,
  `dept_desc` varchar(20) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  PRIMARY KEY (`departement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_dept` */

insert  into `master_dept` values (1,'IT','2018-02-15'),(2,'Engginering','2018-02-15'),(3,'General Affairs','2018-02-15'),(4,'Human Resource','2018-02-15'),(5,'Security','2018-02-15'),(6,'HSE','2018-02-15'),(7,'Technical Support','2018-02-15'),(8,'Produksi','2018-02-15'),(9,'Finance','2018-02-15'),(10,'Manager','2018-02-15'),(11,'Accounting','2018-02-15'),(12,'Survey','2018-02-15'),(13,'Logistic','2018-04-12');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
