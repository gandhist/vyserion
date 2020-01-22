<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
    if ( ! function_exists('time_stamp'))
    {
        function time_stamp()
        {
        date_default_timezone_set('Asia/Jakarta');
            return date("Y-m-d H:i:s");
        }
    }

   