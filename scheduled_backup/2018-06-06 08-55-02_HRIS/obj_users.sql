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

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users` values (1,'127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,NULL,1268889823,1516516160,1,'Admin','istrator','ADMIN','0'),(2,'::1','gandhi','$2y$08$.JFr2e90.AsfgK1NoeNR2.5fUFSBSbATjm6D2xoWWrf1J.xUyjjNO',NULL,'gandhi@hris.com',NULL,'PQESEWgTxQTjD9MQo-PE0.678180197334fa7562',1516509174,NULL,1516493424,1528243319,1,'Gandhi','Saputra','PIM','081240353913'),(4,'::1','nugraha','$2y$08$.rAxJj7ic13yFaPe5IUpGewuIMNbmpxwL8UMK.SVCtixB7qHpwwCO',NULL,'nugraha@prime-pim.com',NULL,NULL,NULL,NULL,1520391569,1523850810,1,'Nugraha','Marsosa','PIM','0987'),(5,'::1','tester','$2y$08$qTyc2yLd/tHk56fGAAdHNeamGtlFBDx7GNvxmgl7LRQcjpe/DQQU.',NULL,'gandhi@hris.com',NULL,NULL,NULL,NULL,1520656937,1520656970,1,'Programmer','Codeigniter','Gandhi','090'),(6,'::1','supatno','$2y$08$BffEmoxJiH06F7BxWhM/0uH1ikTWiZ9onKsOXM7KAqG/heR3ykKdC',NULL,'supatno@prime-pim.com',NULL,NULL,NULL,NULL,1523610090,1527236647,1,'Supatno','12345678','PT PIM','08'),(7,'192.168.11.17','dini','$2y$08$gk4/XpPybOlMIgbWRqr0FuWdhWQGY2T5V3z2jTPM3ZPLLwjs8c2qC',NULL,'dini@prime-pim.com',NULL,NULL,NULL,NULL,1523841970,1527912996,1,'dini','12345678','pt pim','078'),(8,'192.168.11.108','eha','$2y$08$QBNm7kZAv137KzOeCD7gHuPKaK94rA2uLzS7L3GRsjV8X7JBHIb.6',NULL,'eha@gmail.com',NULL,NULL,NULL,NULL,1524816166,1528156582,1,'eha','eha','PT PIM','098'),(9,'192.168.11.147','widya','$2y$08$tvvvG3NGZwOAD7/qxTOHEOTxYwSaZL2CB7WKVNQaAHZwYbXfjyXtO',NULL,'widya@prime-pim.com',NULL,NULL,NULL,NULL,1527665282,1528246046,1,'widya','12345678','PT PIM','09');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
