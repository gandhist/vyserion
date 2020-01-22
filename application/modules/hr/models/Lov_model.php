<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lov_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// model untuk dropdown employee code
	public function dd_empcode()
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
		$this->db->select('*');
		$this->db->from('emp_master');
		$this->db->where("`empcode` not in (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY)");
        $this->db->where('is_deleted','0');
		$result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
                //$dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }

    // model untuk dropdown employee code
    public function dd_operator()
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('*');
        $this->db->from('emp_master');
        $this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");
        $this->db->where('is_deleted','0');
        $this->db->where('departement','8');
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
                //$dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }


    /*model untuk menampilkan dropdown employee status KHT KBT PERMANENT*/
    function dd_emp_status()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->where_in('id_position', array('PKWT1','PKWT2','kt'));
        //$this->db->like('position_desc','karyawan');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'id_position'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }

    // model untuk dropdown employee id position
    function dd_emp_position()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('id_position','pos');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'id_position'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
            	$a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
            }
        }
        return $dd;
    }

    /*model untuk menampilkan dropdown Departement*/
    function dd_dept()
    {
        // ambil data dari db
        $this->db->order_by('departement', 'asc');
        $result = $this->db->get('master_dept');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd['*'] = 'ALL'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->departement] = $row->departement .$a. $row->dept_desc;
            }
        }
        return $dd;
    }

    /*model untuk menampilkan dropdown attendance code*/
    function dd_attd_code()
    {
        // ambil data dari db
        $this->db->order_by('attd_code', 'asc');
        //$this->db->like('id_position','attd');
        $result = $this->db->get('master_attd_code');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Attendace Code'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->attd_code] = $row->attd_code .$a. $row->attd_desc;
            }
        }
        return $dd;
    }

    // dropdown Allowance Deduction Code
    function dd_adhoc()
    {
        // ambil data dari db
        $this->db->order_by('allowded_Code', 'asc');
        $result = $this->db->get('master_adhoc');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Attendace Code'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->allowded_code] = $row->allowded_code .$a. $row->description;
            }
        }
        return $dd;
    }

    /*model untuk menampilkan dropdown kode vehicle*/
    public function dd_vehicle()
    {

        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('nomor_plat,nap');
        $this->db->from('vehicle_master');
        /*$this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");*/
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->nap] = $row->nap .$a. $row->nomor_plat;
            }
        }
        return $dd;
    }

    // model untuk dropdown gang
    public function dd_gang()
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('id_gang, gang_name');
        $this->db->from('gang');
        $this->db->where("active = 1");
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->id_gang] = $row->id_gang .$a. $row->gang_name;
            }
        }
        return $dd;
    }
    /*end of model dropdown gang*/

    // model untuk dropdown employee code di menu add rooster production
    public function dd_empcode_ros()
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('a.empcode, b.empname');
        $this->db->from('gang_master a');
        $this->db->join('emp_master b','a.empcode = b.empcode');
        $this->db->where('a.active=1');
        $this->db->where('b.empcode not in (SELECT empcode FROM hr_termination WHERE dateterminate < CURRENT_DATE() - INTERVAL 26 DAY)');
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }
    // model untuk dropdown employee code di menu add rooster production

    // model untuk dropdown mesin absen
    public function dd_mesin_finger()
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('ip, nama_mesin');
        $this->db->from('absen_pengaturan');
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->ip] = $row->ip .$a. $row->nama_mesin;
            }
        }
        return $dd;
    }
    /*end of model dropdown mesin absen*/

    public function email_notifikasi($parameter,$target)
    {
        $query = $this->db->query('select email FROM kirim_email WHERE parameter = '.$parameter.' and target = "'.$target.'"');
        return $query->result();
    }

    /*model untuk dropdown golongan karyawan*/
    public function dd_golongan()
    {
        $this->db->select('id_golongan, golongan');
        $this->db->from('master_golongan');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $a = " -> ";
                $dd[$row->id_golongan] = $row->id_golongan .$a. $row->golongan;
            }
        }
        return $dd;
    }
    /*model untuk dropdown golongan karyawan*/

    /*model untuk mendapatkan attd_code*/
    public function get_attd_code($attd_code)
    {
        $this->db->order_by('id_position');
        $this->db->like('id_position',$attd_code);
        return $this->db->get('master_position')->result_array();
    }

    public function dd_vendor()
    {
        $this->db->select('id_vendor, nama_vendor');
        $this->db->from('master_vendor');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $a = " -> ";
                $dd[$row->id_vendor] = $row->id_vendor .$a. $row->nama_vendor;
            }
        }
        return $dd;
    }

    /*model untuk menampilkan dropdown kode vehicle*/
    public function dd_vehicle_op()
    {

        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('code_unit,nap');
        $this->db->from('vehicle_master');
        $this->db->where('groups != 1');
        $this->db->where('active = 1');
        /*$this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");*/
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->nap] = $row->nap .$a. $row->code_unit;
            }
        }
        return $dd;
    }

    public function dd_vehicle_by_type()
    {
        $this->db->select('distinct(type) as type');
        $this->db->from('vehicle_master');
        $this->db->where('groups != 1');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $a = " -> ";
                $dd[$row->type] = $row->type .$a. $row->type; 
            }
        }
        return $dd;
    }

    public function dd_vehicle_group()
    {
        /*SELECT group_code, group_name FROM master_group*/
        $this->db->select('group_code, group_name');
        $this->db->from('master_group');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
         foreach ($result->result() as $row) {
                $a = " -> ";
                $dd[$row->group_code] = $row->group_code .$a. $row->group_name;
            }   
        }
        return $dd;
    }

    public function dd_materials_produksi()
    {
        /*SELECT MATERIAL_CODE, MATERIAL_DESC FROM MASTER_MATERIALS */
        $this->db->select('material_code, material_desc');
        $this->db->from('master_materials');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $a = " -> ";
                $dd[$row->material_code] = $row->material_code .$a. $row->material_desc;
            }
        }
        return $dd;
    }

    // model untuk dropdown berdasarkan departement
    public function dd_empcode_by_dept($dept_code)
    {
        // ambil data dari db
 /*       $this->db->order_by('empcode', 'asc');
        $result = $this->db->get('emp_master');*/
        $this->db->select('empcode, empname');
        $this->db->from('emp_master');
        $this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");
        $this->db->where('is_deleted','0');
        $this->db->where('departement',$dept_code);
        $result = $this->db->get();
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Empcode'; untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->empcode] = $row->empcode .$a. $row->empname;
                //$dd[$row->empcode] = $row->empcode .$a. $row->empname;
            }
        }
        return $dd;
    }

    public function get_dept_name($dept_id)
    {
        $query = $this->db->query("select dept_desc from master_dept where departement = '".$dept_id."' ");
        return $query->result_array();
    }




} /*end of lov model*/


/*

contoh penggunaan 
1. load model di controller
2. buat script
$data['dd_dept'] = $this->emp_attribute->dd_dept();
        $data['dd_dept_selected'] = $this->input->post('f_position') ? $this->input->post('f_position') : '';
        di function controller
3. panggil dropdown di view yang sudah terinstall plugin select2
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.min.js"></script>

<tr>
                                <td>Departement</td>
                                <!-- <td><input type="text" name="f_departement" class="form-control"> <span class="help-block"></span></td> -->
                                <td>
                                 <?php
                                  $dd_dept_attribute = 'class="form-control select2" id="f_departement" style="width: 100%;"';
                                 
                                  echo form_dropdown('f_departement', $dd_dept, $dd_dept_selected, $dd_dept_attribute);
                                  ?>
                                <span class="help-block"></span>
                                </td>
                              </tr>
*/