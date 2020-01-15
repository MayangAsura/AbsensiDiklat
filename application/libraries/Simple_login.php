<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple_login {
	
	// SET SUPER GLOBAL
	var $CI = NULL;
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	// Cek login proteksi halaman
	public function cek_login() {
		if($this->CI->session->userdata('id_user') == '' && $this->CI->session->userdata('level')=='') 
		{
			$this->CI->session->set_flashdata('sukses','Wahhh... Login dulu dong.');
			redirect(site_url(''));
		}	
	}
}