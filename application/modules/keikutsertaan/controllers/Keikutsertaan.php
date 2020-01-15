<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keikutsertaan extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_keikutsertaan');
    $this->load->model('diklat/m_diklat','diklat');
    $this->load->model('pegawai/m_pegawai','pegawai');
  }

  function _template($data) {
    $this->load->view('template/main', $data);	
  }

  public function index()
  {

    $data = array(
      'get_diklat' => $this->diklat->get_diklat(),
      'get_pegawai' => $this->pegawai->get_all(),
      'konten' => 'data_keikutsertaan'
    );
    $this->_template($data);
  }

  public function ajax_list()
  {
    $list = $this->m_keikutsertaan->get_datatables();
    $data = array();
    $no = $_POST["start"];
    foreach ($list as $key => $value) {
     $no++;
     $row = array();

     $aksi = '<a href="'.site_url('keikutsertaan/detail_pegawai/'.$value->diklat_id).'" class="btn btn-icons btn-primary btn-rounded" title="Detail Peserta"><i class="mdi mdi-account"></i></a> ';

     $row[] = $no;
     $row[] = $value->kode_diklat;
     $row[] = $value->nama_diklat;

     $row[] = $aksi;

     $data[] = $row;
   }

   $output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $this->m_keikutsertaan->count_all(),
    "recordsFiltered" => $this->m_keikutsertaan->count_filtered(),
    "data" => $data,
  );
            //output to json format
   echo json_encode($output);
 }

 public function ajax_add()
 {
  $this->_validate();

  $pegawai_list = $this->input->post('pegawai_id');

  foreach($pegawai_list as $peg) {
    $data = array(
     'diklat_id' => $this->input->post('diklat_id'),
     'pegawai_id' => $peg,
   );

    $insert = $this->m_keikutsertaan->save($data);
  }
  echo json_encode(array("status" => TRUE));
}

public function detail_pegawai($id)
{

  $data = array(
    'get_pegawai' => $this->m_keikutsertaan->get_detail($id),
    'diklat_id' => $id,
    'konten' => 'detail_pegawai'
  );
  $this->_template($data);

}

public function ajax_update()
{
 $this->_validate();

 $data = array(
  'kode_keikutsertaan' => $this->input->post('kode_keikutsertaan'),
  'nama_keikutsertaan' => $this->input->post('nama_keikutsertaan'),
  'tgl_mulai' => date('Y-m-d',strtotime($this->input->post('tgl_mulai'))),
  'tgl_berakhir' => date('Y-m-d',strtotime($this->input->post('tgl_selesai'))),
  'tempat' => $this->input->post('tempat'),
);

 $this->m_keikutsertaan->update(array('id' => $this->input->post('id_keikutsertaan')), $data);
 echo json_encode(array("status" => TRUE));
}

public function ajax_delete($id)
{
 $this->m_keikutsertaan->delete_by_id($id);
 echo json_encode(array("status" => TRUE));
}

private function _validate()
{
 $data = array();
 $data['error_string'] = array();
 $data['inputerror'] = array();
 $data['status'] = TRUE;
 $data['msg'] = "";

 if($this->input->post('diklat_id') == '')
 {
  $data['inputerror'][] = 'diklat_id';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($this->input->post('pegawai_id') == '')
{
  $data['inputerror'][] = 'pegawai_id';
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