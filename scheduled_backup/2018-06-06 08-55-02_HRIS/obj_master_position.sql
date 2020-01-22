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

/*Table structure for table `master_position` */

DROP TABLE IF EXISTS `master_position`;

CREATE TABLE `master_position` (
  `id_position` varchar(200) NOT NULL,
  `position_desc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_position` */

insert  into `master_position` values ('attd001','Operational Production'),('attd002','Cuti'),('attd003','Off'),('attd004','Cuti Melahirkan'),('attd005','Mangkir'),('attd006','Sakit'),('attd007','Alfa'),('attd008','Izin'),('attd009','Mogok Kerja'),('attd010','Dinas Luar'),('attd011','Kerja Hari Libur'),('attd012','Kerja Hari Raya'),('kbt','karyawan bulanan tetap'),('khl','karyawan harian lepas'),('kt','karyawan tetap'),('PKWT1','PKWT1'),('PKWT2','PKWT2'),('pos01','Administrator'),('pos02','Mekanik Senior'),('pos03','Security'),('pos04','Accounting'),('pos05','Admin HR'),('pos06','Admin GA'),('pos07','Admin Logistic'),('pos08','Admin HSE'),('pos09','Admin Produksi'),('pos10','Checker'),('pos11','Driver Bus Karyawan'),('pos12','Driver DT'),('pos13','Driver Sarana Logistic'),('pos14','Driver Sarana Office'),('pos15','Driver Sarana PM'),('pos16','Driver Water Tank'),('pos17','Electrician'),('pos18','Foreman Pit Service'),('pos19','General Helper'),('pos20','Hand Picker'),('pos21','Helper Mekanik'),('pos22','Helper Pit Service'),('pos23','Helper WT'),('pos24','IT'),('pos25','Mekanik '),('pos26','Mekanik Alat Berat'),('pos27','Mekanik LV'),('pos28','Officer Survey'),('pos29','Operator A2B'),('pos30','Operator Dozer'),('pos31','Operator DT'),('pos32','Operator Excavator'),('pos33','Operator Grader'),('pos34','Operator OHT'),('pos35','Operator Pompa'),('pos36','Safety Control'),('pos37','Spare Driver Bus Karyawan'),('pos38','Store Keeper'),('pos39','Support HR'),('pos40','Tool Keeper'),('pos41','Traffic Man'),('pos42','Welder'),('pos43','Middle Foreman Produksi'),('pos44','Senior Foreman HSE'),('pos45','Safety Officer'),('pos46','Dept Head Logistic'),('pos47','Dept Head Produksi'),('pos48','Foreman Produksi'),('pos49','Senior Supervisor Produksi'),('pos50','Planner Service'),('pos51','Driver Fuel Truck');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
