<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_log');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'konten' => 'data_log'
			);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_log->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			if ($value->tipe_log == 0) {
				$tipe = "<span class='badge badge-primary'>Login</span";
			} else if ($value->tipe_log == 1) {
				$tipe = "<span class='badge badge-info'>Logout</span";
			} else if ($value->tipe_log == 2) {
				$tipe = "<span class='badge badge-success'>Tambah</span";
			} else if ($value->tipe_log == 3) {
				$tipe = "<span class='badge badge-warning'>Edit</span";
			} else if ($value->tipe_log == 4) {
				$tipe = "<span class='badge badge-danger'>Hapus</span";
			}

			$row[] = $no;
			$row[] = date('d F Y H:i:s',strtotime($value->time_log));
			$row[] = $value->user_log;
			$row[] = $tipe;
			$row[] = $value->desc_log;

			$row[] = '<a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_log."'".')"><i class="mdi mdi-delete"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_log->count_all(),
			"recordsFiltered" => $this->m_log->count_filtered(),
			"data" => $data,
			);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'log' => $this->input->post('log'),
			);

		$insert = $this->m_log->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_log->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'log' => $this->input->post('log'),
			);



		$this->m_log->update(array('id_log' => $this->input->post('id_log')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_log->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$data['msg'] = "";

		if($this->input->post('log') == '')
		{
			$data['inputerror'][] = 'log';
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