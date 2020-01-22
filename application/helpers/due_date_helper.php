<?php
if (! defined('BASEPATH'))exit('No direct script access allowed');

/*helper untuk mendapatkan selisih dari tanggal awal dan tanggal akhir atau due date*/

if (! function_exists('due_date')) {
	function due_date($start_date, $end_date)
	{
		$start = date_create($start_date);
		$end = date_create($end_date);

		$interval = date_diff($start, $end);
		$date_interval = $interval->format("%a"); // %a untuk menampilkan selisihnya saja, %R%a untuk memberi tanda + didepannya
	}
}

/*public function selisih($start_date, $end_date)
	{
		$obj_user = $this->ion_auth->user()->row();
		$email = $obj_user->username;
		$data['username'] = $email;
		echo "tanggal awal adalah ".$start_date." sampai dengan tanggal ".$end_date." akan berakhir, selisinya adalah ".$this->duedate($start_date,$end_date)."";
		$a = date_create($start_date);
		$b = date_create($end_date);
		//$t = date_diff("2018-01-01","2018-01-15");
		$t = date_diff($a, $b);
		echo "<br>";
		echo $t->format("%a Days again "). $data['username']. " contract expired";
	}*/