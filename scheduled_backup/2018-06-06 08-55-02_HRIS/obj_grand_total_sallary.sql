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

/* Procedure structure for procedure `grand_total_sallary` */

/*!50003 DROP PROCEDURE IF EXISTS  `grand_total_sallary` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`gandhi`@`localhost` PROCEDURE `grand_total_sallary`(in start_dt date, in end_dt date)
BEGIN
set @start_date = start_dt;
SET @end_date = end_dt;
SELECT 
  SUM(a.upah) AS total_upah,
  SUM(a.kehadiran_pagi) AS total_uang_kehadiran,
  SUM(a.deduction) AS total_deduction,
  SUM(a.allowance) AS total_allowance,
  SUM(a.jamsostek) AS total_jamsostek,
  SUM(a.jpk) AS total_jpk,
  ('hk'),
  SUM(a.kehadiran_bulanan) AS total_kh_bulanan,
  SUM(a.upah_perjam) AS total_upah_perjam,
  SUM(a.jam_lembur) AS total_jam_lembur,
  SUM(a.uang_lembur) AS total_uang_lembur,
  SUM(a.insentive_snack) AS total_uang_snack,
  SUM(a.total_pendapatan) AS total_pendapatan,
  SUM(a.total_potongan) AS toal_potongan,
  SUM(a.gaji_bersih) AS toal_gaji_bersih 
FROM
  (SELECT 
    b.empcode,
    b.empname,
    b.position,
    c.position_desc,
    b.departement,
    d.dept_desc,
    e.upah,
    e.kehadiran_pagi,
    COALESCE(f.deduction, 0) AS deduction,
    COALESCE(g.allowance, 0) AS allowance,
    CASE
      -- jika jamsostek tidak di bayarkan
      WHEN e.status_jamsostek = 0 
      THEN 0 
      WHEN e.status_jamsostek = 1 
      THEN ROUND(3 / 100 * e.upah) 
    END AS jamsostek,
    CASE
      -- jika bpjs tidak di bayarkan
      WHEN e.lifeinsurance = 0 
      THEN 0 -- jika bpjs dibayarkan
      WHEN e.lifeinsurance = 1 
      THEN ROUND(1 / 100 * h.rate) 
    END AS jpk,
    -- ROUND(3/100 * e.upah) as jamsostek,
    COUNT(a.attd_date) AS hk,
    COUNT(a.attd_date) * e.kehadiran_pagi AS kehadiran_bulanan,
    ROUND(1 / 173 * e.upah) AS upah_perjam,
    COALESCE(SUM(a.overtime), 0) AS jam_lembur,
    COALESCE(
      ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
      0
    ) AS uang_lembur,
    (COUNT(a.attd_date) * 5000) AS insentive_snack,
    COALESCE(
      e.upah + (
        (COUNT(a.attd_date) * 5000) + (
          COUNT(a.attd_date) * e.kehadiran_pagi
        ) + COALESCE(
          ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
          0
        )
      ) + COALESCE(g.allowance, 0),
      0
    ) AS total_pendapatan,
    COALESCE(e.jamsostek + e.jpk, 0) + COALESCE(f.deduction, 0) AS total_potongan,
    CASE
      WHEN e.overtime = 0 
      THEN 
      CASE
        -- 1 = ikut jamsostek, 0 = tidak ikut jamsostek
        WHEN e.status_jamsostek = 0 
        AND e.lifeinsurance = 0 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) 
        WHEN e.status_jamsostek = 1 
        AND e.lifeinsurance = 0 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) - e.jamsostek 
        WHEN e.status_jamsostek = 0 
        AND e.lifeinsurance = 1 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) - e.jpk 
        WHEN e.status_jamsostek = 1 
        AND e.lifeinsurance = 1 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) - (e.jamsostek + e.jpk) -- WHEN e.jamsostek = 0 AND e.lifeinsurance = 0 then "tidak jamsostek dan bpjs"
      END -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0))
      WHEN e.overtime = 1 
      THEN 
      CASE
        -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek di bayarkan 
        WHEN e.status_jamsostek = 1 
        AND e.lifeinsurance = 1 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) + COALESCE(g.allowance, 0) - (
          e.jamsostek + e.jpk + COALESCE(f.deduction, 0)
        ) -- jika dia mendapatkan overtime dan jika bpjs dan jamsostek tidak bayarkan 
        WHEN e.status_jamsostek = 0 
        AND e.lifeinsurance = 0 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) + COALESCE(g.allowance, 0) - COALESCE(f.deduction, 0) -- jika dia mendapatkan overtime dan jika bpjs dibayarkan tapi jamsostek tidak di bayarkan 
        WHEN e.status_jamsostek = 0 
        AND e.lifeinsurance = 1 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) + COALESCE(g.allowance, 0) - (e.jpk + COALESCE(f.deduction, 0)) -- jika dia mendapatkan overtime dan jika bpjs tidak dibayarkan tapi jamsostek di bayarkan 
        WHEN e.status_jamsostek = 1 
        AND e.lifeinsurance = 0 
        THEN e.upah + (
          (COUNT(a.attd_date) * 5000) + (
            COUNT(a.attd_date) * e.kehadiran_pagi
          ) + COALESCE(
            ROUND((1 / 173 * e.upah) * SUM(a.overtime)),
            0
          )
        ) + COALESCE(g.allowance, 0) - (
          e.jamsostek + COALESCE(f.deduction, 0)
        ) 
      END -- e.upah + ((COUNT(a.attd_date) * 5000) + (COUNT(a.attd_date) * e.kehadiran_pagi) + coalesce(ROUND((1/173*e.upah) * SUM(a.overtime)),0)) + COALESCE(g.allowance,0) - COALESCE(f.deduction,0)
    END AS gaji_bersih 
  FROM
    (SELECT 
      * 
    FROM
      gang_activity 
    WHERE attd_code IN ('attd001', 'attd010', 'attd011') 
      AND attd_date BETWEEN @start_date 
      AND @end_date) a 
    RIGHT JOIN emp_master b -- JADIKAN RIGHT JOIN JIKA INIGN MENAMPILKAN SELURUH KARYAWAN
      ON a.empcode = b.empcode 
    INNER JOIN master_position c 
      ON b.position = c.id_position 
    INNER JOIN master_dept d 
      ON b.departement = d.departement -- diremarks untuk menampilkan field yang digunakan saja dan untuk perhitungaan potongan
    INNER JOIN 
      (SELECT 
        a.empcode,
        a.upah,
        a.kehadiran_pagi,
        a.jamsostek AS status_jamsostek,
        a.lifeinsurance,
        a.overtime,
        CASE
          -- jika jamsostek tidak di bayarkan
          WHEN a.jamsostek = 0 
          THEN 0 
          WHEN a.jamsostek = 1 
          THEN ROUND(3 / 100 * a.upah) 
        END AS jamsostek,
        CASE
          -- jika bpjs tidak di bayarkan
          WHEN a.lifeinsurance = 0 
          THEN 0 -- jika bpjs dibayarkan
          WHEN a.lifeinsurance = 1 
          THEN ROUND(1 / 100 * b.rate) 
        END AS jpk 
      FROM
        hr_hist_status a,
        (SELECT 
          ID,
          MAX(EFFECTIVE_DATE) AS EFFE,
          REMARKS,
          RATE 
        FROM
          MASTER_UMP) b) e 
      ON b.empcode = e.empcode 
    LEFT JOIN 
      (SELECT 
        empcode,
        adhoc_date,
        SUM(amount) AS deduction 
      FROM
        empallded 
      WHERE adhoc_date BETWEEN @start_date
        AND @end_date 
        AND allowded_code LIKE '%D%' 
      GROUP BY empcode) f -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
      ON b.empcode = f.empcode 
    LEFT JOIN 
      (SELECT 
        empcode,
        adhoc_date,
        allowded_code,
        SUM(amount) AS allowance 
      FROM
        empallded 
      WHERE adhoc_date BETWEEN @start_date
        AND @end_date 
        AND allowded_code LIKE '%A%' 
      GROUP BY empcode) g -- LEFT JOIN JIKA INGIN MENAMPILKAN KARYAWAN MESKIPUN TIDAK MEMILIKI ALLODED
      ON b.empcode = g.empcode,
    (SELECT 
      ID,
      MAX(EFFECTIVE_DATE) AS EFFE,
      REMARKS,
      RATE 
    FROM
      MASTER_UMP) h 
  WHERE a.attd_date BETWEEN @start_date 
    AND @end_date 
  GROUP BY a.empcode) a;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
