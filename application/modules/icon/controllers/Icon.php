<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Icon extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_icon');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'konten' => 'data_icon'
			);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_icon->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = '<i class="'.$value->icon.'"></i>';
			$row[] = $value->icon;

			$row[] = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_icon."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_icon."'".')"><i class="mdi mdi-delete"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_icon->count_all(),
			"recordsFiltered" => $this->m_icon->count_filtered(),
			"data" => $data,
			);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'icon' => $this->input->post('icon'),
			);

		$insert = $this->m_icon->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_icon->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'icon' => $this->input->post('icon'),
			);



		$this->m_icon->update(array('id_icon' => $this->input->post('id_icon')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_icon->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$data['msg'] = "";

		if($this->input->post('icon') == '')
		{
			$data['inputerror'][] = 'icon';
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