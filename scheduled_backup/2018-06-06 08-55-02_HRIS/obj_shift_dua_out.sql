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

/* Function  structure for function  `shift_dua_out` */

/*!50003 DROP FUNCTION IF EXISTS `shift_dua_out` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`gandhi`@`localhost` FUNCTION `shift_dua_out`(p_pin INT(20), p_datetime VARCHAR(50)) RETURNS varchar(50) CHARSET latin1
BEGIN
DECLARE v_keluar_shift_dua VARCHAR(50);
SELECT MAX(date_time) AS keluar INTO v_keluar_shift_dua FROM absen_finger WHERE HOUR(date_time) BETWEEN  "05:30:00" AND "06:30:00"
AND pin = p_pin AND DATE_ADD(DATE(p_datetime), INTERVAL 1 DAY) = DATE(date_time)
GROUP BY pin, DATE(date_time)
ORDER BY pin;
-- butuh parameter tanggal dan pin
RETURN v_keluar_shift_dua;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
