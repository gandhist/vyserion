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

/* Function  structure for function  `get_empname` */

/*!50003 DROP FUNCTION IF EXISTS `get_empname` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `get_empname`(`p_empcode` int) RETURNS varchar(255) CHARSET latin1
BEGIN
	#Routine body goes here...
DECLARE nama VARCHAR(255);
SELECT empname into nama FROM emp_master where empcode = p_empcode;
	RETURN nama;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
