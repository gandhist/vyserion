<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('create_auth')) {
	function create_auth()
	{
		$ci = get_instance();
		$obj_user = $ci->ion_auth->user()->row();
		$email = $obj_user->username;
		return $email;

		if ($ci->ion_auth->in_group('hr_add_biodata ')) {
			return show_error('You an administrator to view this page.');
		}
	else{
		return show_error('You must be an administrator to view this page.');
	}
	}
}


?>