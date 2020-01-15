<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Format extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_format');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
    $jml = count($this->m_format->get_all());

		$data = array(
      'jml' => $jml,
			'konten' => 'data_format'
		);
		$this->_template($data);
	}
  public function cek_kode()
  {
    $kode = $this->input->post('kode');

    $out = array('status' => TRUE);

    if($this->m_format->cek_kode($kode)){
      $out['status'] = TRUE;
    }
    else {
      $out['status'] = FALSE;
    }

    echo json_encode($out);
  }

  public function ajax_list()
  {
    $list = $this->m_format->get_datatables();
    $data = array();
    $no = $_POST["start"];
    foreach ($list as $key => $value) {
     $no++;
     $row = array();

     $aksi = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id."'".')"><i class="mdi mdi-delete"></i></a>';

     $row[] = $no;
     $row[] = $value->pembuka;
     $row[] = $value->penutup;
     $row[] = $aksi;

     $data[] = $row;
   }

   $output = array(
     "draw" => $_POST['draw'],
     "recordsTotal" => $this->m_format->count_all(),
     "recordsFiltered" => $this->m_format->count_filtered(),
     "data" => $data,
   );
            //output to json format
   echo json_encode($output);
 }

 public function ajax_add()
 {
  $this->_validate();

  $data = array(
   'pembuka' => $this->input->post('pembuka'),
   'penutup' => $this->input->post('penutup'),
 );

  $insert = $this->m_format->save($data);
  echo json_encode(array("status" => TRUE));
}

public function ajax_edit($id)
{
 $data = $this->m_format->get_by_id($id);
 echo json_encode($data);
}

public function ajax_update()
{
 $this->_validate();

 $data = array(
  'pembuka' => $this->input->post('pembuka'),
  'penutup' => $this->input->post('penutup'),
);

 $this->m_format->update(array('id' => $this->input->post('id_format')), $data);
 echo json_encode(array("status" => TRUE));
}

public function ajax_delete($id)
{
 $this->m_format->delete_by_id($id);
 echo json_encode(array("status" => TRUE));
}

private function _validate()
{
 $data = array();
 $data['error_string'] = array();
 $data['inputerror'] = array();
 $data['status'] = TRUE;
 $data['msg'] = "";

 if($this->input->post('pembuka') == '')
 {
  $data['inputerror'][] = 'pembuka';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($this->input->post('penutup') == '')
{
  $data['inputerror'][] = 'penutup';
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