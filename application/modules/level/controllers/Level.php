<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_level');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'konten' => 'data_level'
			);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_level->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			if ($value->id_level != 1 && $value->id_level != 2) {
				$aksi = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_level."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_level."'".')"><i class="mdi mdi-delete"></i></a>';
			} else {
				$aksi = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_level."'".')"><i class="mdi mdi-pencil"></i></a>';
			}
			
			$row[] = $no;
			$row[] = $value->level;
			$row[] = $value->keterangan;

			$row[] = $aksi;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_level->count_all(),
			"recordsFiltered" => $this->m_level->count_filtered(),
			"data" => $data,
			);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'level' => $this->input->post('level'),
			'direct_link' => 'dashboard',
			'keterangan' => $this->input->post('keterangan'),
			);

		$insert = $this->m_level->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_level->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'level' => $this->input->post('level'),
			'direct_link' => 'dashboard',
			'keterangan' => $this->input->post('keterangan'),
			);


		$this->m_level->update(array('id_level' => $this->input->post('id_level')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_level->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$data['msg'] = "";

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Tidak Boleh Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('keterangan') == '')
		{
			$data['inputerror'][] = 'keterangan';
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