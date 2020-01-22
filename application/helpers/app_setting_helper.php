<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('get_app_conf') ) {
    function get_app_conf($col)
    {
        $ci = get_instance();
        $ci->db->select($col);
        $ci->db->from('app_setting');
        $query = $ci->db->get();

        return $query->row();

    }
    
}