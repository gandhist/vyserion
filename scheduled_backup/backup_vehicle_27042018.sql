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

/*Table structure for table `document_vehicle` */

DROP TABLE IF EXISTS `document_vehicle`;

CREATE TABLE `document_vehicle` (
  `id_document` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(50) DEFAULT NULL,
  `code_unit` varchar(40) DEFAULT NULL,
  `doc_type` varchar(20) DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `inputby` varchar(30) DEFAULT NULL,
  `updateby` varchar(30) DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `masa_berlaku` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `mail_pajak` int(2) DEFAULT '0' COMMENT '0 berarti belum kirim email',
  `mail_stnk` int(2) DEFAULT '0' COMMENT '0 berarti belum kirim email',
  `mail_keur` int(2) DEFAULT '0' COMMENT '0 berarti belum kirim email',
  `mail_iu` int(2) DEFAULT '0' COMMENT '0 berarti belum kirim email',
  PRIMARY KEY (`id_document`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `document_vehicle` */

insert  into `document_vehicle`(`id_document`,`doc_no`,`code_unit`,`doc_type`,`valid_until`,`remarks`,`inputby`,`updateby`,`inputdate`,`updatedate`,`masa_berlaku`,`status`,`mail_pajak`,`mail_stnk`,`mail_keur`,`mail_iu`) values (1,'tidak keruan','PIM.02','PAJAK','2018-07-27','PROJECT PT.BA',NULL,'gandhi',NULL,'2018-04-26 01:52:04','0 Tahun 3 Bulan 1 Hari','submit',NULL,NULL,NULL,NULL),(3,'UNKNOWN','PIM.02','STNK','2022-07-27','PROJECT PT.BA','gandhi','gandhi','2018-04-26 09:25:45','2018-04-26 01:52:04','4 Tahun 3 Bulan 1 Hari','submit',NULL,NULL,NULL,NULL),(4,'UNKNOWN','PIM.02','KEUR','2018-03-06','PROJECT PT.BA te','gandhi','gandhi','2018-04-26 09:25:45','2018-04-26 03:06:44','0 Tahun -1 Bulan -20 Hari','submit',NULL,NULL,NULL,NULL),(5,'UNKNOWN','PIM.02','IJIN USAHA','2018-09-07','PROJECT PT.BA','gandhi','gandhi','2018-04-26 09:25:45','2018-04-26 01:52:04','0 Tahun 4 Bulan 12 Hari','submit',NULL,NULL,NULL,NULL),(6,'unkown','PIM.02','PAJAK','2018-08-29','project ptba','gandhi','gandhi','2018-04-26 09:25:45','2018-04-26 01:52:04','0 Tahun 4 Bulan 3 Hari','closed',NULL,NULL,NULL,NULL);

/*Table structure for table `vehicle_master` */

DROP TABLE IF EXISTS `vehicle_master`;

CREATE TABLE `vehicle_master` (
  `id_vehicle` int(255) NOT NULL AUTO_INCREMENT,
  `vehicle_code` varchar(40) DEFAULT NULL,
  `nomor_plat` varchar(40) DEFAULT NULL,
  `code_unit` varchar(40) DEFAULT NULL,
  `pic_code` int(15) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `ownership` varchar(20) DEFAULT NULL,
  `status_unit` varchar(20) DEFAULT NULL,
  `date_receive` date DEFAULT NULL COMMENT 'tanggal diterima di site',
  `no_frame` varchar(50) DEFAULT NULL,
  `no_machine` varchar(50) DEFAULT NULL,
  `cylinder` varchar(20) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `inputby` varchar(30) DEFAULT NULL,
  `updateby` varchar(30) DEFAULT NULL,
  `inputdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `nap` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_vehicle`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `vehicle_master` */

insert  into `vehicle_master`(`id_vehicle`,`vehicle_code`,`nomor_plat`,`code_unit`,`pic_code`,`type`,`year`,`ownership`,`status_unit`,`date_receive`,`no_frame`,`no_machine`,`cylinder`,`remarks`,`inputby`,`updateby`,`inputdate`,`updatedate`,`nap`) values (1,NULL,'BG 9467 EC','PIM.02',1800260,'MITSUBISHI/TRITON 2,5L SC HDX (4X4) MT',2017,'ASSET PIM','rfu','2017-07-21','MMBENKL30HH030172','4D56UAL2481',NULL,'PROJECT PT. BA','gandhi',NULL,'2018-04-26 09:22:43',NULL,'97-68');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
