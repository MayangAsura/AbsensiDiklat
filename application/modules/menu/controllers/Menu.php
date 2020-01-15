<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_menu');
		$this->load->model('level/m_level');
		$this->load->model('icon/m_icon');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'level' => $this->m_level->get_all(),
			'icon' => $this->m_icon->get_all(),
			'konten' => 'data_menu'
			);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_menu->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			if ($value->id_parents == 0) {
				$sub = "<span class='badge badge-success'>Menu Utama</span>";
			} else {
				$sub = "<span class='badge badge-primary'>".$value->sub_menu."</span>";
			}
			
			$row[] = $no;
			$row[] = $value->menu;
			$row[] = $value->nama_level;
			$row[] = $value->link;
			$row[] = $sub;

			$row[] = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_menu."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_menu."'".')"><i class="mdi mdi-delete"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_menu->count_all(),
			"recordsFiltered" => $this->m_menu->count_filtered(),
			"data" => $data,
			);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$this->_validate();

		if ($this->input->post('l_menu') === '1') {
			$sub_menu = "0";
		} else {
			$sub_menu = $this->input->post('id_parents');
		}
		
		$data = array(
			'menu' => $this->input->post('menu'),
			'level' => $this->input->post('level'),
			'icon' => $this->input->post('icon'),
			'link' => $this->input->post('link'),
			'id_parents' => $sub_menu,
			);

		$insert = $this->m_menu->save($data);
		helper_log("tambah", "Menambahkan data menu");
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_sub_menu($id)
	{
		$data = $this->m_menu->get_menu($id);
		echo json_encode($data);
	}
	
	public function ajax_edit($id)
	{
		$data = $this->m_menu->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		if ($this->input->post('l_menu') === '1') {
			$sub_menu = "0";
		} else {
			$sub_menu = $this->input->post('id_parents');
		}
		
		$data = array(
			'menu' => $this->input->post('menu'),
			'level' => $this->input->post('level'),
			'icon' => $this->input->post('icon'),
			'link' => $this->input->post('link'),
			'id_parents' => $sub_menu,
			);

		$this->m_menu->update(array('id_menu' => $this->input->post('id_menu')), $data);
		helper_log("edit", "Mengubah data menu");
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_menu->delete_by_id($id);
		helper_log("hapus", "Menghapus data menu");
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('menu') == '')
		{
			$data['inputerror'][] = 'menu';
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