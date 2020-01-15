<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfig extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_konfig');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'konten' => 'data_konfig'
			);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_konfig->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			$logo = base_url()."images/".$value->logo;

			if($value->logo == null) {
				$img = '<a href="javascript:void(0);" class="btn btn-info btn-sm" title="Edit" onclick="upload('."'".$value->id_konfig."'".')"><i class="mdi mdi-upload"></i> Upload</a>';
			} else {
				$img = '<img class="gambar" src="'.$logo.'" style="width:100px;">';
				$ganti = '<a href="javascript:void(0);" class="btn btn-icons btn-success btn-rounded" title="Ganti Foto" onclick="ganti('."'".$value->id_konfig."'".')"><i class="mdi mdi-upload"></i></a>';
			}

			$row[] = $no;
			$row[] = $value->nama_aplikasi;
			$row[] = date('d F Y',strtotime($value->tgl));
			$row[] = $value->klien;
			$row[] = $value->created_by;
			$row[] = $value->footer;
			$row[] = $img;
			$row[] = $ganti.' <a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id_konfig."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id_konfig."'".')"><i class="mdi mdi-delete"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_konfig->count_all(),
			"recordsFiltered" => $this->m_konfig->count_filtered(),
			"data" => $data,
			);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'nama_aplikasi' => $this->input->post('nama'),
			'tgl' => date('Y-m-d',strtotime($this->input->post('tgl'))),
			'klien' => $this->input->post('klien'),
			'created_by' => $this->input->post('pembuat'),
			'footer' => $this->input->post('footer'),
			);

		$insert = $this->m_konfig->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_konfig->get_by_id($id);
		$data->tgl = ($data->tgl == '0000-00-00') ? '' : $data->tgl; 
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'nama_aplikasi' => $this->input->post('nama'),
			'tgl' => date('Y-m-d',strtotime($this->input->post('tgl'))),
			'klien' => $this->input->post('klien'),
			'created_by' => $this->input->post('pembuat'),
			'footer' => $this->input->post('footer'),
			);

		$this->m_konfig->update(array('id_konfig' => $this->input->post('id_konfig')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_konfig->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function do_upload()
	{
		$config['upload_path']="./images";
		$config['allowed_types']='gif|jpg|png|jpeg|tiff';
		$config['encrypt_name'] = TRUE;
		$config['overwrite'] = TRUE;

		$this->load->library('upload',$config);

		if($this->upload->do_upload("logo")){
			$data = array('upload_data' => $this->upload->data());
			$image= $data['upload_data']['file_name'];

			$data = array(
				'logo' => $image,
				);


			$this->m_konfig->update(array('id_konfig' => $this->input->post('id_upload')), $data);
			echo json_encode(array("status" => TRUE));
		}

	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$data['msg'] = "";

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Tidak Boleh Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('klien') == '')
		{
			$data['inputerror'][] = 'klien';
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