<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mttr_model extends CI_Model 
{

    function __construct()
    {
        parent::__construct();
    }

    public function mttr_vs_mtbf($start_date, $end_date)
    {
        $this->db->query("SET @tanggal_awal = '".$start_date."';");
        $this->db->query("SET @tanggal_akhir = '".$end_date."';");
        $query = $this->db->query("
        select
        a.nap,
        c.code_unit, c.TYPE, c.no_machine, c.serial_number, c.model, c.manufacturer,
        --  CASE 
        --  WHEN b.status_bd = '0' THEN (DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1) * c.pwh
        --  ELSE COALESCE(ROUND(b.tdhr,2),0)
        --  END AS tdhr, 
          COALESCE(ROUND(b.tdhr,2),0) as tdhr, 
        DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1 AS hari,
        c.pwh AS working_hour,
        (
          DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1
        ) * c.pwh AS pwh,
        ROUND(SUM(a.total_hm),2) AS operation_hour,
        ROUND((((DATEDIFF(@tanggal_akhir, @tanggal_awal)+1) * c.pwh) - COALESCE(b.tdhr,0)) / ((DATEDIFF(@tanggal_akhir, @tanggal_awal)+1) * c.pwh) * 100,2) AS average,
        COALESCE(b.jumlah_bd,0) AS jumlah_bd,
        COALESCE(ROUND((SUM(a.total_hm) / b.jumlah_bd),2),0) AS mtbf,
        COALESCE(ROUND((b.tdhr / b.jumlah_bd),2),0) AS mttr,
        get_status_bd(a.nap) AS status_bd
        
      FROM
        vehicle_daily_activity a LEFT JOIN (
        -- awal data bd
        SELECT a.nap, SUM(a.jumlah_bd) AS jumlah_bd, a.status_bd, a.date_start, a.date_finished, a.hari_by_date AS hari, ROUND(SUM(a.tdhr),2) AS tdhr FROM
(
SELECT 
  nap,
    CASE
    WHEN status_bd = '0' THEN (DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1)
    ELSE COUNT(nap) 
    END jumlah_bd,
  status_bd,
  date_start,
  date_finished,
  DATEDIFF(DATE(date_finished), DATE(date_start))  AS hari_by_date,
  CASE 
  -- 0 day
  WHEN DATEDIFF(DATE(date_finished), DATE(date_start)) = 0 THEN 
	CASE
		-- jam 01
		
		-- 1-6 s/d 6-7	
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_finished),' 06:00:00')) / 3600,2)
		-- 1-6 > 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), date_finished) / 3600,2)
		-- 1-6 s/d 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		-- 1-6 > 13 - 17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), date_finished) / 3600,2)
		-- 1-6 s/d 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 1-6 > 19 - 24
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), date_finished) / 3600,2)
		-- 1 - 6
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, date_finished) / 3600,2)
		
		-- 7-12 > 13 - 17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), date_finished) / 3600,2)
		-- 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, date_finished) / 3600,2)
		-- 7-12 s/d 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		
		-- 7-12 s/d 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 7-12 > 19 - 23
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), date_finished) / 3600,2)
		
		-- 13:00-17:00
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, date_finished) / 3600,2)
		-- 13-17 s/d 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 13-17 > 19 - 23
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), date_finished) / 3600,2)
		
		
		-- 19:00 – 23:59
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, date_finished) / 3600,2)
		
		-- when date_start = '2019-02-12 08:30:00' then CONCAT(date(date_start),' 07:00:00') 
	END
-- 1 day
  WHEN DATEDIFF(DATE(date_finished), DATE(date_start)) = 1 THEN 
	CASE
		-- 1-5 s/d ND 23:59-01
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 23:59:59') AND CONCAT(DATE(date_finished),' 01:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_finished),' 23:59:59')) / 3600,2)
		-- 1-5 > ND 05-07
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), CONCAT(DATE(date_finished),' 06:00:00')) / 3600,2)
		-- 1-5 > ND 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +7 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		-- 1-5 > ND 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +8 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 1-5 > ND 1-5
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 01:00:00') AND CONCAT(DATE(date_finished),' 06:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), date_finished) / 3600,2)
		-- 1-5 > ND 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +7 HOUR), date_finished) / 3600,2)
		-- 1-5 > ND 13-17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +8 HOUR), date_finished) / 3600,2)
		-- 1-5 > ND 19-23:59
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 01:00:00') AND CONCAT(DATE(date_start),' 06:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +10 HOUR), date_finished) / 3600,2)
		
		
		-- 7-12 > ND 23:59-01
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_start),' 23:59:59') AND CONCAT(DATE(date_finished),' 01:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_finished),' 23:59:59')) / 3600,2)
		-- 7-12 > ND 06-07
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_finished),' 06:00:00')) / 3600,2)
		-- 7-12 > ND 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		-- 7-12 > ND 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +6 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 7-12 > ND 1-6
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 01:00:00') AND CONCAT(DATE(date_finished),' 06:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), date_finished) / 3600,2)
		-- 7-12 > ND 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), date_finished) / 3600,2)
		-- 7-12 > ND 13-17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +6 HOUR), date_finished) / 3600,2)
		-- 7-12 > ND 19-23:59
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +8 HOUR), date_finished) / 3600,2)
		
		
		-- 13:00 – 17:00 > ND 23:59-01
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 23:59:59') AND CONCAT(DATE(date_finished),' 01:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_finished),' 23:59:59')) / 3600,2)
		-- 13:00 – 17:00 > ND 05-07
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_finished),' 06:00:00')) / 3600,2)
		-- 13:00 – 17:00 > ND 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		-- 13:00 – 17:00 > ND 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +6 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 13:00 – 17:00 > ND 1-5
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 01:00:00') AND CONCAT(DATE(date_finished),' 06:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), date_finished) / 3600,2)
		-- 13:00 – 17:00 > ND 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), date_finished) / 3600,2)
		-- 13:00 – 17:00 > ND 13-17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), date_finished) / 3600,2)
		-- 13:00 – 17:00 > ND 19-23:59
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +7 HOUR), date_finished) / 3600,2)
		
		-- 19:00 – 23:59 > ND 23:59-01
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 23:59:59') AND CONCAT(DATE(date_finished),' 01:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_finished),' 23:59:59')) / 3600,2)
		-- 19:00 – 23:59 > ND 06-07
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), CONCAT(DATE(date_finished),' 06:00:00')) / 3600,2)
		-- 19:00 – 23:59 > ND 12-13
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
		-- 19:00 – 23:59 > ND 17-19
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
		-- 19:00 – 23:59 > ND 1-5
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 01:00:00') AND CONCAT(DATE(date_finished),' 05:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +1 HOUR), date_finished) / 3600,2)
		-- 19:00 – 23:59 > ND 7-12
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), date_finished) / 3600,2)
		-- 19:00 – 23:59 > ND 13-17
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), date_finished) / 3600,2)
		-- 19:00 – 23:59 > ND 19-23:59
		WHEN date_start BETWEEN CONCAT(DATE(date_start),' 19:00:00') AND CONCAT(DATE(date_start),' 23:59:59') AND date_finished BETWEEN CONCAT(DATE(date_finished),' 19:00:00') AND CONCAT(DATE(date_finished),' 23:59:59') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +5 HOUR), date_finished) / 3600,2)
	END
-- when DATEDIFF(DATE(date_finished), DATE(date_start)) > 1 then 'more than 1 day' 
-- case > dari range waktu
	WHEN DATEDIFF(DATE(date_finished), DATE(date_start)) > DATEDIFF(@tanggal_akhir, @tanggal_awal) THEN 
		CASE
			WHEN date_start  < CONCAT(DATE(date_start),' 06:00:00') THEN ((DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) ) * get_pwh(nap) ) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start  < CONCAT(DATE(date_start),' 12:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap) ) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start  < CONCAT(DATE(date_start),' 17:00:00') THEN ((DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) ) * get_pwh(nap) ) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start  < CONCAT(DATE(date_start),' 23:59:59') THEN ((DATEDIFF(DATE(@tanggal_akhir), DATE(date_start))) * get_pwh(nap) ) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
		END 
-- case > 1 day
WHEN DATEDIFF(DATE(date_finished), DATE(date_start)) > 1 THEN 
	CASE
		-- < 5 pot 5 jam
		WHEN date_start  < CONCAT(DATE(date_start),' 06:00:00') THEN 
			CASE 
			-- finish < 6 hitung biasa
			WHEN date_finished < CONCAT(DATE(date_finished),' 06:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), date_finished) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 12 pot 1 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 12:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -1 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 2 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 17:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -2 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 2 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 23:59:59') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -4 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +4 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			
			END 
		-- < 12 pot 3 jam
		WHEN date_start  < CONCAT(DATE(date_start),' 12:00:00') THEN 
			CASE 
			-- finish < 5 hitung biasa
			WHEN date_finished < CONCAT(DATE(date_finished),' 05:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), date_finished) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 12 pot 2 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 12:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap))  + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -1 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 17:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -2 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 23:59:59') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -4 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +3 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			
			END 
		-- < 17 pot 2 jam
		WHEN date_start  < CONCAT(DATE(date_start),' 17:00:00') THEN 
			CASE 
			-- finish < 5 hitung biasa
			WHEN date_finished < CONCAT(DATE(date_finished),' 05:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), date_finished) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 12 pot 2 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 12:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap))  + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -1 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 17:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -2 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 23:59:59') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -4 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(date_start, INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			
			END 
		-- < 23 pot 5 jam
		WHEN date_start  < CONCAT(DATE(date_start),' 23:59:59') THEN 
			CASE 
			-- finish < 5 hitung biasa
			WHEN date_finished < CONCAT(DATE(date_finished),' 05:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), date_finished) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 12 pot 2 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 12:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap))  + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -1 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 17:00:00') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -2 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			-- finish < 17 pot 3 jam
			WHEN date_finished < CONCAT(DATE(date_finished),' 23:59:59') THEN ((DATEDIFF(DATE(date_finished), DATE(date_start)) - 1) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), DATE_ADD(date_finished, INTERVAL -4 HOUR)) / 3600,2) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			
			END 
	END
  ELSE SUM(total_down_time)
  END AS tdhr
FROM
  vehicle_breakdown 
WHERE DATE(date_start) BETWEEN @tanggal_awal 
  AND @tanggal_akhir AND status_bd = 1 GROUP BY date_start, nap
  UNION ALL
 -- ini untuk unit breakdown namun start date nya sebelum parameter tanggal awal
 SELECT 
  nap,
  CASE
    WHEN status_bd = '0' THEN (DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1)
    ELSE COUNT(nap) 
    END jumlah_bd,
  status_bd,
  date_start,
  date_finished,
  DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) AS hari,
  CASE 
  WHEN DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) = 0 THEN 
	
	CASE
			WHEN date_finished < CONCAT(DATE(date_finished),' 06:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(@tanggal_awal),' 01:00:00'), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(@tanggal_awal),' 01:00:00'), date_finished ) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(@tanggal_awal),' 01:00:00'), INTERVAL +1 HOUR), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(@tanggal_awal),' 01:00:00'), INTERVAL +1 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(@tanggal_awal),' 01:00:00'), INTERVAL +2 HOUR), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(@tanggal_awal),' 01:00:00'), INTERVAL +2 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
			WHEN date_finished < CONCAT(DATE(date_finished),' 19:00:00') THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(@tanggal_awal),' 01:00:00'), INTERVAL +5 HOUR), date_finished) / 3600,2)
	END 
	
  WHEN DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) >= 1 THEN
	CASE
			WHEN date_finished < CONCAT(DATE(date_finished),' 06:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap) ) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_finished),' 01:00:00'), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 06:00:00') AND CONCAT(DATE(date_finished),' 07:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(@tanggal_awal),' 01:00:00'), date_finished ) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 07:00:00') AND CONCAT(DATE(date_finished),' 12:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_finished),' 01:00:00'), INTERVAL +1 HOUR), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 12:00:00') AND CONCAT(DATE(date_finished),' 13:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_finished),' 01:00:00'), INTERVAL +1 HOUR), CONCAT(DATE(date_finished),' 12:00:00')) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 13:00:00') AND CONCAT(DATE(date_finished),' 17:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_finished),' 01:00:00'), INTERVAL +2 HOUR), date_finished) / 3600,2)
			WHEN date_finished BETWEEN CONCAT(DATE(date_finished),' 17:00:00') AND CONCAT(DATE(date_finished),' 19:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_finished),' 01:00:00'), INTERVAL +2 HOUR), CONCAT(DATE(date_finished),' 17:00:00')) / 3600,2)
			WHEN date_finished < CONCAT(DATE(date_finished),' 19:00:00') THEN (DATEDIFF(DATE(date_finished), DATE(@tanggal_awal)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_finished),' 01:00:00'), INTERVAL +4 HOUR), date_finished) / 3600,2)
	END
  END AS downtime
FROM
  vehicle_breakdown 
WHERE DATE(date_finished) BETWEEN @tanggal_awal 
  AND @tanggal_akhir AND DATE(date_start) < @tanggal_awal AND status_bd = 1 GROUP BY date_start, nap
  UNION ALL
-- untuk unit yang status breakdown nya open, downtime nya di hitung dari start_date sampai tanggal_akhir parameter
SELECT 
  nap,
  CASE
    WHEN status_bd = '0' THEN (DATEDIFF(@tanggal_akhir, @tanggal_awal) + 1)
    ELSE COUNT(nap) 
    END jumlah_bd,
  status_bd,
  date_start,
  COALESCE(date_finished, CONCAT(DATE(@tanggal_akhir), ' 23:59:59')) AS date_finished,
  DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) AS hari,
  CASE 
	WHEN DATE(date_start) < @tanggal_awal THEN -- 'dibawah DS'
			(DATEDIFF(DATE(@tanggal_akhir), DATE(@tanggal_awal)) + 1) * get_pwh(nap) 
	WHEN DATE(date_start) >= @tanggal_awal THEN -- 'lebih besar'
		CASE
			WHEN date_start < CONCAT(DATE(date_start),' 06:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, date_start, DATE_ADD(CONCAT(DATE(date_start),' 23:59:59'), INTERVAL -4 HOUR)) / 3600,2)
			WHEN date_start BETWEEN CONCAT(DATE(date_start),' 05:00:00') AND CONCAT(DATE(date_start),' 07:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_start),' 07:00:00'), INTERVAL +3 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start BETWEEN CONCAT(DATE(date_start),' 07:00:00') AND CONCAT(DATE(date_start),' 12:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, date_start, DATE_ADD(CONCAT(DATE(date_start),' 23:59:59'), INTERVAL -3 HOUR)) / 3600,2)
			WHEN date_start BETWEEN CONCAT(DATE(date_start),' 12:00:00') AND CONCAT(DATE(date_start),' 13:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(date_start),' 13:00:00'), INTERVAL +2 HOUR), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start BETWEEN CONCAT(DATE(date_start),' 13:00:00') AND CONCAT(DATE(date_start),' 17:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, date_start, DATE_ADD(CONCAT(DATE(date_start),' 23:59:59'), INTERVAL -2 HOUR)) / 3600,2)
			WHEN date_start BETWEEN CONCAT(DATE(date_start),' 17:00:00') AND CONCAT(DATE(date_start),' 19:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(date_start),' 19:00:00'), CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
			WHEN date_start > CONCAT(DATE(date_start),' 19:00:00') THEN (DATEDIFF(DATE(@tanggal_akhir), DATE(date_start)) * get_pwh(nap)) + ROUND(TIMESTAMPDIFF(SECOND, date_start, CONCAT(DATE(date_start),' 23:59:59')) / 3600,2)
		END
  END AS downtime
FROM
  vehicle_breakdown 
WHERE DATE(date_start) <= @tanggal_akhir AND status_bd = 0 GROUP BY date_start, nap) a GROUP BY a.nap
        -- akhir data bd
        ) b
          ON a.nap = b.nap
          LEFT JOIN (SELECT nap, code_unit, TYPE, no_machine, serial_number, model, manufacturer, pwh FROM vehicle_master ) c ON a.nap = c.nap
       WHERE a.date BETWEEN @tanggal_awal 
        AND @tanggal_akhir 
      GROUP BY a.nap  ");

        return $query->result_array();
    }
    
}



?>