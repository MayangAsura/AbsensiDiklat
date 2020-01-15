<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('level/m_level');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'level' => $this->m_level->get_all(),
			'konten' => 'data_user'
		);
		$this->_template($data);
	}

	public function cek_username()
	{
		$username = $this->input->post('username');

		if($this->m_user->getUsername($username)){
			echo '<label class="text-danger"><span>Username sudah terdaftar. Harap Ganti username yang lain.</span></label>';
		}
		else {
			echo '<label class="text-success"><span> Username Tersedia</span></label>';
		}
	}

	public function cek_email_lupa()
	{
		$email = $this->input->post('email');

		if($this->m_user->getEmail($email) > 0 ){
			echo "1";
		}
		else if ( $this->m_user->getEmail($email) == 0){
			echo "0";
		}
	}

	public function cek_email()
	{
		$email = $this->input->post('email');

		if($this->m_user->getEmail($email) > 0 ){
			echo '<label class="text-danger"><span>Email sudah terdaftar.</span></label>';
		}
		else if ( $this->m_user->getEmail($email) == 0){
			echo '<label class="text-success"><span> Email Tersedia</span></label>';
		}
	}

	public function ajax_list()
	{
		$list = $this->m_user->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			if ($value->status == 1) {
				$st = "<span class='btn btn-success btn-sm'></span>";
			} else {
				$st = "<span class='btn btn-danger btn-sm'></span>";
			}

			if ($value->level != 1) 
			{
				$btn = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_user."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_user."'".')"><i class="mdi mdi-delete"></i></a>';
			} else {
				$btn = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_user."'".')"><i class="mdi mdi-pencil"></i></a>';
			} 

			if ($value->last_login != null) {
				$last = date('d F Y H:i:s',strtotime($value->last_login));
			} else {
				$last = " ";
			}

			if ($value->created_user != null) {
				$creat = date('d F Y H:i:s',strtotime($value->created_user));
			} else {
				$creat = " ";
			}

			$row[] = $no;
			$row[] = $btn;

			$row[] = $st;
			$row[] = $value->username;
			$row[] = $value->f_name.' '.$value->l_name;
			$row[] = $value->email;
			$row[] = $value->no_hp;
			$row[] = $value->nama_level;
			$row[] = $last;
			$row[] = $creat;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_user->count_all(),
			"recordsFiltered" => $this->m_user->count_filtered(),
			"data" => $data,
		);
            //output to json format
		echo json_encode($output);
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

	public function ajax_add()
	{
	//$this->_validate();
		date_default_timezone_set("Asia/Jakarta");

		$data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'confirm_password' => md5($this->input->post('confirm')),
			'f_name' => $this->input->post('f_name'),
			'l_name' => $this->input->post('l_name'),
			'email' => $this->input->post('email'),
			'no_hp' => $this->input->post('no_hp'),
			'level' => $this->input->post('level'),
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

	public function ajax_edit($id)
	{
		$data = $this->m_user->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		//$this->_validate();
		
		if ($this->input->post('password') == '') {
			$data = array(
				'username' => $this->input->post('username'),
				'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'),
				'email' => $this->input->post('email'),
				'no_hp' => $this->input->post('no_hp'),
				'level' => $this->input->post('level'),
				'foto' => "no_img.jpg"
			);
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'confirm_password' => md5($this->input->post('confirm')),
				'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'),
				'email' => $this->input->post('email'),
				'no_hp' => $this->input->post('no_hp'),
				'level' => $this->input->post('level'),
				'foto' => "no_img.jpg"
			);
		}
		$this->m_user->update(array('id_user' => $this->input->post('id_user')), $data);
		helper_log("edit", "Mengubah data user");
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_user->delete_by_id($id);
		helper_log("hapus", "Menghapus data user");
		echo json_encode(array("status" => TRUE));
	}

	public function lupa_pass()
	{
		$data = array(
			'password' => md5($this->input->post('l_pass')),
			'confirm_password' => md5($this->input->post('l_con')),
		);

		$this->m_user->update(array('email' => "admin@gmail.com"), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Tidak Boleh Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('f_name') == '')
		{
			$data['inputerror'][] = 'f_name';
			$data['error_string'][] = 'Tidak Boleh Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('no_hp') == '')
		{
			$data['inputerror'][] = 'no_hp';
			$data['error_string'][] = 'Tidak Boleh Kosong';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


}