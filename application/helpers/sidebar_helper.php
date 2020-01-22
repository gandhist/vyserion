<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');



if (! function_exists("menu_list")) {
	function menu_list() {
		$CI = get_instance();
		$CI->load->model('temp/template_model','sidebar');
		$menu = $CI->sidebar->get_menu();

		return $menu;
	}
}

if (! function_exists("sidebar_list")) {
    function sidebar_list($id_modul, $id_menu)
    {

		$CI = get_instance();
		$CI->load->model('temp/template_model','sidebar');		
        $d = $CI->sidebar->get_dropdown($id_modul, $id_menu);

        foreach ($d as $key) {
            //echo "<li  id='".$key->id."' ><a href='".base_url($key->controller)."'><i class='fa fa-circle-o'></i> ".$key->nama_menu."</a></li>";
            //echo "<li class='".active_submenu($key->controller)."'  id='".$id_modul."'><a href='".base_url($key->controller)."'><i class='menu-icon fa fa-caret-right'></i>".$key->nama_menu."</a><b class='arrow'></b></li>";
			//echo "<li class='".active_module_name($key->method)."'><a href='".base_url($key->method)."' id='".$id_module."'><i class='fa fa-circle-o'></i> ".$key->menu_name."</a></li>";
			echo '<li  class="'.active_module_name($key->method).'" ><a href=" '.base_url($key->method).' "><i class="fa fa-circle-o"></i> '.$key->menu_name.'</a></li>';
        }
    }
}

if (! function_exists("active_menu")) {
	function active_menu($controller)
	{
		$CI = get_instance();
		$class = $CI->router->fetch_class();
		$con = explode("/", $controller); 
		return $class = ($con[0] == $class) ? 'active treeview' : 'treeview' ;
		//return $sub = ($controller) ? 'active' : '' ;
	}
}

if (! function_exists("active_submenu")) {
	function active_submenu($controller)
	{
		$CI = get_instance();
		$CI->load->model('temp/template_model','sidebar');
		$class = $CI->router->fetch_class()."/".$CI->router->fetch_method();
		$menu = $CI->sidebar->cek_method($class);
		if ($menu) {
			return $a = ($controller==$menu->id_menu) ? 'active treeview' : 'treeview' ;
		}
		else{
			return $a = 'treeview' ;

		}
	}
}

if (! function_exists("active_module_name")) {
	function active_module_name($controller)
	{
		$CI = get_instance();
		$class = $CI->router->fetch_class()."/".$CI->router->fetch_method();
		//return $class = ($controller) ? 'active open' : '' ;
		return $class = ($controller==$class) ? 'active' : '' ;
	}
}

if (! function_exists("get_navbar")) {
	function get_navbar($controller, $id_modul, $id_menu)
	{
		$CI = get_instance();
		//$controller = explode("/", $controller);
		$url = $CI->router->fetch_class()."/".$CI->router->fetch_method();
		$class = $CI->menu->get_menu_by_controller($CI->router->fetch_method(), $id_modul, $id_menu);

		//var_dump($url);
		$id = $id_modul.$id_menu;
		if ($class) {
		$a = $class[0]['id_modul'].$class[0]['id_menu'];
		return $class = ($id==$a) ? 'active treeview' : '' ;
		}
		else
		{
		return $class = 'treeview';	
		}
	}
}

if (! function_exists("get_navbar_menu")) {
	function get_navbar_menu()
	{
		$CI = get_instance();
		//$class = $CI->menu->get_menu_by_class($controller);
		$CI->load->model('temp/template_model','sidebar');
		$class = $CI->router->fetch_class()."/".$CI->router->fetch_method();
		$menu = $CI->sidebar->cek_method($class);

		foreach ($menu as $key) {
			$id = $menu->id_menu;
			switch ($id) {
					case 1:
					$id = "Input";
					break;
					case 2:
					$id = "Process";
					break;
					case 3:
					$id = "Setup";
					break;
					case 4:
					$id = "Report";
					break;
			}
		
		$html = '<li><a href="#"><i class="fa fa-dashboard"></i><a href="'.base_url('dashboard').'">'.$menu->module_name.'</a></li><li >'.$id.'</li><li class="active">'.$menu->menu_name.'</li>';
		return $html;
		}
		
	}
}

if (! function_exists("get_modul_name")) {
	function get_modul_name()
	{
		$CI = get_instance();
		$CI->load->model('temp/template_model','sidebar');
		$class = $CI->router->fetch_class()."/".$CI->router->fetch_method();
		$menu = $CI->sidebar->cek_method($class);
		if ($menu) {
			return $menu->menu_name; 
		}
		else {
			return '';
		}


	}
}

if (! function_exists("ion_auth_entity")) {
	function ion_auth_entity()
	{
			$CI = get_instance();
			$usr = $CI->ion_auth->user()->row();
			$data['username'] = $usr->username;
			$data['id'] = $usr->id;
			$data['created_on'] = $usr->created_on;
			return $data;
	}
}

if (! function_exists("get_title")) {
	function get_title($controller)
	{
		$CI = get_instance();
		$data = $CI->menu->get_menu_by_class($controller);
		return $data;
	}
}