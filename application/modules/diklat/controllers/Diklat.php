<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diklat extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
    $this->load->model('m_diklat');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$data = array(
			'konten' => 'data_diklat'
		);
		$this->_template($data);
  }

	public function jadwal()
	{
		$data = array(
      'konten' => 'jadwal_diklat',
      'get_diklat' => $this->m_diklat->get_diklat()
		);
		$this->_template($data);
  }
  
  public function cek_kode()
  {
    $kode = $this->input->post('kode');

    $out = array('status' => TRUE);

    if($this->m_diklat->cek_kode($kode)){
      $out['status'] = TRUE;
    }
    else {
      $out['status'] = FALSE;
    }

    echo json_encode($out);
  }

  public function ajax_list()
  {
    $list = $this->m_diklat->get_datatables();
    $data = array();
    $no = $_POST["start"];
    foreach ($list as $key => $value) {
     $no++;
     $row = array();

     $aksi = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id."'".')"><i class="mdi mdi-delete"></i></a>';

     $row[] = $no;
     $row[] = $value->kode_diklat;
     $row[] = $value->nama_diklat;
     $row[] = date('d F Y',strtotime($value->tgl_mulai)).' - '.date('d F Y',strtotime($value->tgl_berakhir));
     $row[] = $value->tempat;
     $row[] = $value->jam_mulai.' - '.$value->jam_selesai;
     $row[] = $value->dc;

     $row[] = $aksi;

     $data[] = $row;
   }

   $output = array(
     "draw" => $_POST['draw'],
     "recordsTotal" => $this->m_diklat->count_all(),
     "recordsFiltered" => $this->m_diklat->count_filtered(),
     "data" => $data,
   );
            //output to json format
   echo json_encode($output);
 }

 public function ajax_add()
 {
  $this->_validate();

  $data = array(
   'kode_diklat' => $this->input->post('kode_diklat'),
   'nama_diklat' => $this->input->post('nama_diklat'),
   'tgl_mulai' => date('Y-m-d',strtotime($this->input->post('tgl_mulai'))),
   'tgl_berakhir' => date('Y-m-d',strtotime($this->input->post('tgl_selesai'))),
   'tempat' => $this->input->post('tempat'),
   'jam_mulai' => $this->input->post('jam_mulai'),
   'jam_selesai' => $this->input->post('jam_selesai'),
   'dc' => $this->input->post('dc'),
 );

  $insert = $this->m_diklat->save($data);
  echo json_encode(array("status" => TRUE));
}

public function ajax_edit($id)
{
 $data = $this->m_diklat->get_by_id($id);
 echo json_encode($data);
}

public function ajax_update()
{
 $this->_validate();

 $data = array(
  'kode_diklat' => $this->input->post('kode_diklat'),
  'nama_diklat' => $this->input->post('nama_diklat'),
  'tgl_mulai' => date('Y-m-d',strtotime($this->input->post('tgl_mulai'))),
  'tgl_berakhir' => date('Y-m-d',strtotime($this->input->post('tgl_selesai'))),
  'tempat' => $this->input->post('tempat'),
  'jam_mulai' => $this->input->post('jam_mulai'),
   'jam_selesai' => $this->input->post('jam_selesai'),
   'dc' => $this->input->post('dc'),
);

 $this->m_diklat->update(array('id' => $this->input->post('id_diklat')), $data);
 echo json_encode(array("status" => TRUE));
}

public function ajax_delete($id)
{
 $this->m_diklat->delete_by_id($id);
 echo json_encode(array("status" => TRUE));
}

private function _validate()
{
 $data = array();
 $data['error_string'] = array();
 $data['inputerror'] = array();
 $data['status'] = TRUE;
 $data['msg'] = "";

 if($this->input->post('kode_diklat') == '')
 {
  $data['inputerror'][] = 'kode_diklat';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($this->input->post('nama_diklat') == '')
{
  $data['inputerror'][] = 'nama_diklat';
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