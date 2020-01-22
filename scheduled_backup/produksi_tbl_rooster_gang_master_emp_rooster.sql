/*
SQLyog Ultimate v10.42 
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

/*Table structure for table `emp_rooster` */

DROP TABLE IF EXISTS `emp_rooster`;

CREATE TABLE `emp_rooster` (
  `id_rooster_sk` int(255) NOT NULL AUTO_INCREMENT,
  `empcode` int(15) DEFAULT NULL,
  `period` int(12) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `code_begin` int(20) DEFAULT NULL,
  `a1` int(2) DEFAULT NULL COMMENT '26',
  `a2` int(2) DEFAULT NULL,
  `a3` int(2) DEFAULT NULL,
  `a4` int(2) DEFAULT NULL,
  `a5` int(2) DEFAULT NULL,
  `a6` int(2) DEFAULT NULL,
  `a7` int(2) DEFAULT NULL,
  `a8` int(2) DEFAULT NULL,
  `a9` int(2) DEFAULT NULL,
  `a10` int(2) DEFAULT NULL,
  `a11` int(2) DEFAULT NULL,
  `a12` int(2) DEFAULT NULL,
  `a13` int(2) DEFAULT NULL,
  `a14` int(2) DEFAULT NULL,
  `a15` int(2) DEFAULT NULL,
  `a16` int(2) DEFAULT NULL,
  `a17` int(2) DEFAULT NULL,
  `a18` int(2) DEFAULT NULL,
  `a19` int(2) DEFAULT NULL,
  `a20` int(2) DEFAULT NULL,
  `a21` int(2) DEFAULT NULL,
  `a22` int(2) DEFAULT NULL,
  `a23` int(2) DEFAULT NULL,
  `a24` int(2) DEFAULT NULL,
  `a25` int(2) DEFAULT NULL,
  `a26` int(2) DEFAULT NULL,
  `a27` int(2) DEFAULT NULL,
  `a28` int(2) DEFAULT NULL,
  `a29` int(2) DEFAULT NULL,
  `a30` int(2) DEFAULT NULL,
  `a31` int(2) DEFAULT NULL,
  `a32` int(2) DEFAULT NULL,
  `inputby` varchar(30) DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updateby` varchar(30) DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `is_deleted` int(2) DEFAULT '0',
  `deletedby` varchar(30) DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rooster_sk`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Data for the table `emp_rooster` */

insert  into `emp_rooster`(`id_rooster_sk`,`empcode`,`period`,`year`,`remarks`,`code_begin`,`a1`,`a2`,`a3`,`a4`,`a5`,`a6`,`a7`,`a8`,`a9`,`a10`,`a11`,`a12`,`a13`,`a14`,`a15`,`a16`,`a17`,`a18`,`a19`,`a20`,`a21`,`a22`,`a23`,`a24`,`a25`,`a26`,`a27`,`a28`,`a29`,`a30`,`a31`,`a32`,`inputby`,`inputdate`,`updateby`,`updatedate`,`is_deleted`,`deletedby`,`delete_date`) values (33,1800215,1,2018,NULL,NULL,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,1,'gandhi','2018-05-19 13:03:37'),(34,1800001,1,2018,'test_aja_off',11,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,NULL,NULL,NULL,NULL,NULL,NULL,1,'gandhi','2018-05-19 13:02:15'),(35,1800169,5,2018,'test edi aja',0,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00',0,NULL,NULL),(37,1800240,5,2018,'test nopiansyah',33,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(38,1800175,5,2018,'-',22,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(39,1800213,5,2018,'-',3,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(40,1800282,5,2018,'-',1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(41,1800274,5,2018,'-',11,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(42,1800193,5,2018,'-',0,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(43,1800207,5,2018,'-',33,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(44,1800222,5,2018,'-',11,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(45,1800110,5,2018,'-',1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(46,1800169,5,2018,'-',3,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(47,1800155,5,2018,'-',2,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(48,1800196,5,2018,'-',22,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(49,1800199,5,2018,'-',3,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL),(50,1800223,5,2018,'-',33,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,2,0,1,1,1,2,2,NULL,NULL,'','0000-00-00 00:00:00',NULL,NULL,0,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
