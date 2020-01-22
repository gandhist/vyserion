<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('qrcode_bysesssion')) {
 

 function qrcode_bysesssion()
	{
        $ci = get_instance();
		$obj_user = $ci->ion_auth->user()->row();
		$username = $obj_user->username;
		$this->load->library('ciqrcode');

		$params['data'] = 'Generate by : '.$username;
		$params['level'] = 'L';
		$params['size'] = 10;
		$params['savename'] =  FCPATH.'/upload/qrcode/'.$username.'.png';
		$this->ciqrcode->generate($params);
		//echo '<img src="'.base_url().''.$username.'.png" />';
		
    }
    
}

if (! function_exists('qrcode_by_params')) {
 

    function qrcode_by_params($param, $file_name)
       {
        $ci = get_instance();

           $ci->load->library('ciqrcode');
   
           $params['data'] = 'Approved by : '.$param;
           $params['level'] = 'L';
           $params['size'] = 10;
           $params['savename'] =  FCPATH.'/upload/qrcode/'.$file_name.'.png';
           $ci->ciqrcode->generate($params);
           //echo '<img src="'.base_url().''.$username.'.png" />';
           
       }
       
   }