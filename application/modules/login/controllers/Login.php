<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
		$this->load->model('m_konfigurasi');
		$this->load->model('user/m_user');
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation'));
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$konfig = $this->m_konfigurasi->get_konfig();
		$data = array(
			'konfig' => $konfig,
			);
		$this->load->view('login', $data);
	}

	public function profil($ket)
	{
		$id = $this->session->userdata("id");
		$profil = $this->m_user->get_by_id($id);

		if ($ket == 'ganti_password') {
			$title = "Ganti Password";
			$konten = 'ganti_password';
		} else {
			$title = "Ganti Foto Profil";
			$konten = 'ganti_foto';
		}
		
		$data = array(
			'title' => $title,
			'profil' => $profil,
			'konten' => $konten,
			);
		$this->_template($data);
	}

	public function logout($id) 
{
	$data = array(
		'status' => "0"
		);
	$this->m_user->update(array('id_user' => $id), $data);
	$this->session->sess_destroy();
	redirect("login");
}

function cekLogin() {
	$hasil=$this->m_login->cekLogin();
	echo json_encode($hasil);
}

function create_random($length)
{
	$data = '1234567890';
	$string = '';
	for($i = 0; $i < $length; $i++) {
		$pos = rand(0, strlen($data)-1);
		$string .= $data{$pos};
	}
	return $string;
}

public function cekPassOld()
{
	$old_password = md5($this->input->get('old_password'));
	$data = $this->m_login->checkOldPass($old_password);
	echo json_encode($data);
}

public function ajax_add()
{
	date_default_timezone_set("Asia/Jakarta");

	$data = array(
		'username' => $this->input->post('username'),
		'password' => md5($this->input->post('password')),
		'confirm_password' => md5($this->input->post('confirm')),
		'f_name' => $this->input->post('f_name'),
		'l_name' => $this->input->post('l_name'),
		'email' => $this->input->post('email'),
		'no_hp' => $this->input->post('no_hp'),
		'level' => "2",
		'token' => $this->create_random(6),
		'created_user' => date('Y-m-d H:i:s'),
		'created_IP' => $this->input->ip_address(),
		'status' => "0",
		'foto' => "no_img.jpg"
		);

	$insert = $this->m_user->save($data);

	helper_log("tambah", "Menambahkan data user");

	echo json_encode(array("status" => TRUE));
}

public function ajax_password()
{
		//$this->_validate();

	$data = array(
		'password' => md5($this->input->post('password')),
		'confirm_password' => md5($this->input->post('confirm')),
		);

	$this->m_user->update(array('id_user' => $this->input->post('id_user')), $data);
	echo json_encode(array("status" => TRUE));
}

public function ajax_profil()
{
	$config['upload_path']="./images/user";
	$config['allowed_types']='gif|jpg|png|jpeg|tiff';
	$config['file_name'] = $this->session->userdata("f_name");
	$config['overwrite'] = TRUE;

	$this->load->library('upload',$config);

	if($this->upload->do_upload("profil")){
		$data = array('upload_data' => $this->upload->data());
		$image= $data['upload_data']['file_name'];

		$data = array(
			'foto' => $image,
			);


		$this->m_user->update(array('id_user' => $this->input->post('id_user')), $data);
		echo json_encode(array("status" => TRUE));
	}
}
}