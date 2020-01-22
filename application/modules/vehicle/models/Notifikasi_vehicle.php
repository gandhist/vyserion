<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_vehicle extends CI_Model {


  // count notifikasi unit yang habis surat menyurat
  public function notif_vehdoc()
        {
          //SELECT COUNT(*) AS total FROM document_status
          /* query akan menampilkan kontrak karyawan selain status closed, dan hanya akan menampilkan status show_notif 1 jika due datenya <= 30 hari dari end_date contract
       untuk yang due date nya minus (-) diharuskan di closed statusnya agar tidak tampil di notifikasi*/ 
          $query = $this->db->query('
      select  COUNT(a.show_notif) AS notif FROM
(SELECT id_document, doc_no, nap, doc_type, valid_until, DATEDIFF(valid_until, CURDATE()) AS due_date, status, CASE
  WHEN DATEDIFF(valid_until, CURDATE()) <= 60 THEN "1"
  ELSE "0"
  END AS show_notif FROM document_vehicle
  WHERE STATUS not in ("closed","approve")
  AND DATEDIFF(valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1');
          return $query->result();
        }

        // count notifikasi yang tidak p2h
        public function notif_p2h()
        {
          $this->db->query("SET @h_min_satu = CURDATE() - INTERVAL 1 DAY;");
          $this->db->query("SET @h_min_empat = CURDATE() - INTERVAL 4 DAY;");
          $query = $this->db->query('select COUNT(*) notif FROM
  (SELECT COUNT(a.nap) total_tidakp2h, a.nap, c.nomor_plat, get_empname(c.pic_code) pic, c.code_unit, b.last_km, b.tanggal AS last_date FROM 
  (SELECT nap,kondisi, tanggal FROM vehicle_daily_op WHERE tanggal BETWEEN @h_min_empat AND @h_min_satu) a
  RIGHT JOIN 
  (SELECT b.tanggal, b.nap,
    CASE
    WHEN b.stop_satu > b.stop_dua THEN b.stop_satu
    WHEN b.stop_dua > b.stop_satu THEN b.stop_dua 
    WHEN b.stop_dua = b.stop_dua THEN b.stop_dua
    WHEN b.stop_satu = b.stop_satu THEN b.stop_satu
  END AS last_km FROM
  (SELECT MAX(tanggal) tanggal, nap, MAX(stop_satu) stop_satu, MAX(stop_dua) stop_dua FROM vehicle_daily_op WHERE  kondisi = 0 GROUP BY nap) b
  ) b
  ON a.nap = b.nap
  LEFT JOIN vehicle_master c ON a.nap = c.nap
  WHERE a.kondisi = 5 GROUP BY a.nap) f WHERE total_tidakp2h >= 3 
  AND f.nap NOT IN ("97-68","97-43")');
          return $query->result();
        }


        // count notifikasi next service unit
        public function notif_next_service()
        {
          $this->db->query("SET @param_service = 900;");          
          $query = $this->db->query('select COUNT(*) notif FROM (SELECT 
  a.nap,
  a.max_km,
  b.code_unit,
  b.next_service,
  b.next_service - @param_service AS parameter,
  b.next_service - a.max_km AS sisa,
  CASE
  WHEN a.max_km >= b.next_service - @param_service THEN 1
  ELSE 0
  END AS notif_service
FROM
  (SELECT 
    MAX(tanggal),
    nap,
    MAX(
      CASE
        WHEN stop_dua > 0 
        THEN stop_dua 
        WHEN stop_dua = 0 
        THEN stop_satu 
        WHEN stop_satu > 0 
        THEN stop_satu 
      END
    ) max_km 
  FROM
    vehicle_daily_op 
  WHERE kondisi = 0 
  GROUP BY nap) a INNER JOIN
  (SELECT 
    id,
    nap,
    code_unit,
    MAX(bulan) bulan,
    MAX(tahun) tahun,
    MAX(next_service) next_service 
  FROM
    service_setup 
  GROUP BY nap) b ON a.nap = b.nap) s WHERE s.notif_service = 1');

          return $query->result();

        }

      public function notif()
      	{
      		//SELECT COUNT(*) AS total FROM document_status
      		/* query akan menampilkan kontrak karyawan selain status closed, dan hanya akan menampilkan status show_notif 1 jika due datenya <= 30 hari dari end_date contract
       untuk yang due date nya minus (-) diharuskan di closed statusnya agar tidak tampil di notifikasi*/ 
      		/*$query = $this->db->query('
      select  COUNT(a.show_notif) AS notif FROM
(SELECT id_document, doc_no, nap, doc_type, valid_until, DATEDIFF(valid_until, CURDATE()) AS due_date, status, CASE
  WHEN DATEDIFF(valid_until, CURDATE()) <= 60 THEN "1"
  ELSE "0"
  END AS show_notif FROM document_vehicle
  WHERE STATUS not in ("closed","approve")
  AND DATEDIFF(valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1'); di remakrs karena ada penambahan notifikasi untuk vehicle service*/
          // parameter untuk vehicle service di beri interval 3 hari kebelakang
          $this->db->query("SET @param = CURDATE() - INTERVAL 4 DAY;");
      		$query = $this->db->query("select SUM(notif) AS notif FROM
(SELECT  COUNT(a.show_notif) AS notif FROM
(SELECT id_document, doc_no, nap, doc_type, valid_until, DATEDIFF(valid_until, CURDATE()) AS due_date, STATUS, CASE
  WHEN DATEDIFF(valid_until, CURDATE()) <= 60 THEN '1'
  ELSE '0'
  END AS show_notif FROM document_vehicle
  WHERE STATUS NOT IN ('closed','approve')
  AND DATEDIFF(valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1
UNION ALL
SELECT COUNT(*) notif FROM (SELECT b.*,d.nomor_plat, get_empname(d.pic_code) pic, d.code_unit,
CASE
  WHEN c.stop_dua > 0 THEN stop_dua 
  WHEN c.stop_dua = 0 THEN stop_satu
  WHEN c.stop_satu > 0 THEN stop_satu
END AS last_km,
CASE 
  WHEN c.kondisi = 0 THEN 'READY'
  WHEN c.kondisi = 1 THEN 'KM ERROR'
  WHEN c.kondisi = 2 THEN 'STAND BY'
  WHEN c.kondisi = 3 THEN 'BREAKDOWN'
  WHEN c.kondisi = 4 THEN 'TROUBLE'
END kondisi FROM (
SELECT 
CASE
  WHEN MAX(tanggal) > @param THEN '1'
  WHEN MAX(tanggal) <= @param THEN '0'
END notif, nap, MAX(tanggal) last_date
FROM
  (SELECT id, MAX(tanggal) tanggal, nap, start_satu, stop_satu, total_satu, start_dua, stop_dua, total_dua, kondisi FROM vehicle_daily_op GROUP BY nap) a
  GROUP BY nap
 ) b INNER JOIN vehicle_daily_op c ON b.nap = c.nap AND b.last_date = c.tanggal AND b.notif = 0
 INNER JOIN vehicle_master d ON b.nap = d.nap) a
union all
SELECT COUNT(*) notif FROM (SELECT 
  a.nap,
  a.max_km,
  b.code_unit,
  b.next_service,
  b.next_service - 500 AS parameter,
  (b.next_service - 500) - a.max_km AS sisa,
  CASE
  WHEN a.max_km >= b.next_service - 500 THEN 1
  ELSE 0
  END AS notif_service
FROM
  (SELECT 
    MAX(tanggal),
    nap,
    MAX(
      CASE
        WHEN stop_dua > 0 
        THEN stop_dua 
        WHEN stop_dua = 0 
        THEN stop_satu 
        WHEN stop_satu > 0 
        THEN stop_satu 
      END
    ) max_km 
  FROM
    vehicle_daily_op 
  WHERE kondisi = 0 
  GROUP BY nap) a INNER JOIN
  (SELECT 
    id,
    nap,
    code_unit,
    MAX(bulan) bulan,
    MAX(tahun) tahun,
    MAX(next_service) next_service 
  FROM
    service_setup 
  GROUP BY nap) b ON a.nap = b.nap) s WHERE s.notif_service = 1
) c");
          return $query->result();

      	}

        public function list_notif_vehicle()
        {
          $query = $this->db->query('select nap, doc_type, valid_until, due_date, nomor_plat, code_unit, STATUS FROM
(SELECT a.id_document, a.doc_no, b.nomor_plat, b.code_unit, a.nap, a.doc_type, a.valid_until, DATEDIFF(a.valid_until, CURDATE()) AS due_date, a.status, CASE
  WHEN DATEDIFF(a.valid_until, CURDATE()) <= 60 THEN "1"
          
  ELSE "0"
  END AS show_notif FROM document_vehicle a, vehicle_master b
  WHERE a.nap = b.nap
  AND a.status NOT IN ("closed","approve")
  AND DATEDIFF(a.valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1 ORDER BY valid_until');
          return $query->result();
        }

        public function data_email()
        {
          /*SELECT nap, doc_type, valid_until, due_date, remarks, nomor_plat, code_unit, COALESCE(no_ref_sr,"-") no_ref_sr , COALESCE(no_ref_ppd, "-") no_ref_ppd FROM
(SELECT a.id_document, a.no_ref_sr, a.no_ref_ppd, a.doc_no, b.nomor_plat, b.code_unit, a.nap, a.doc_type, a.remarks, a.valid_until, DATEDIFF(a.valid_until, CURDATE()) AS due_date, a.status, CASE
  WHEN DATEDIFF(a.valid_until, CURDATE()) <= 60 THEN "1"
          
  ELSE "0"
  END AS show_notif FROM document_vehicle a, vehicle_master b
  WHERE a.nap = b.nap
   AND a.status NOT IN ("closed","approve")
  AND DATEDIFF(a.valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1 ORDER BY valid_until*/
          $query = $this->db->query('select nap, doc_type, valid_until, due_date, remarks, nomor_plat, code_unit, COALESCE(no_ref_sr,"-") no_ref_sr , COALESCE(no_ref_ppd, "-") no_ref_ppd FROM
(SELECT a.id_document, a.no_ref_sr, a.no_ref_ppd, a.doc_no, b.nomor_plat, b.code_unit, a.nap, a.doc_type, a.remarks, a.valid_until, DATEDIFF(a.valid_until, CURDATE()) AS due_date, a.status, CASE
  WHEN DATEDIFF(a.valid_until, CURDATE()) <= 60 THEN "1"
          
  ELSE "0"
  END AS show_notif FROM document_vehicle a, vehicle_master b
  WHERE a.nap = b.nap
   AND a.status NOT IN ("closed","approve")
  AND DATEDIFF(a.valid_until, CURDATE()) > 0) a
  WHERE a.show_notif = 1 ORDER BY valid_until');
          return $query->result();
        }

}