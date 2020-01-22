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
		$this->db->where("`empcode` NOT IN (SELECT `empcode` from `hr_termination`)");
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

    /*model untuk menampilkan dropdown employee status KHT KBT PERMANENT*/
    function dd_emp_status()
    {
        // ambil data dari db
        $this->db->order_by('id_position', 'asc');
        $this->db->like('position_desc','karyawan');
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
        $this->db->order_by('id_position', 'asc');
        $this->db->like('id_position','attd');
        $result = $this->db->get('master_position');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        //$dd[''] = 'Attendace Code'; //untuk placeholder
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $a = " -> ";
                $dd[$row->id_position] = $row->id_position .$a. $row->position_desc;
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
        $this->db->select('nomor_plat,code_unit');
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
                $dd[$row->code_unit] = $row->code_unit .$a. $row->nomor_plat;
            }
        }
    else
    {
                $dd['no_data'] = "No Data";

    }

        return $dd;
    }

}

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