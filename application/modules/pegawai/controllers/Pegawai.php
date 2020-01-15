<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_pegawai');
    $this->load->model('diklat/m_diklat','diklat');
    $this->load->model('format/m_format','format');
    $this->load->model('keikutsertaan/m_keikutsertaan','keikutsertaan');
    $this->load->library('encrypt');
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
  }

  function _template($data) {
    $this->load->view('template/main', $data);	
  }

  public function index()
  {
    $data = array(
     'konten' => 'data_pegawai'
   );
    $this->_template($data);
  }


  public function cek_nip()
  {
    $nip = $this->input->post('nip');

    $out = array('status' => TRUE);

    if($this->m_pegawai->cek_NIP($nip)){
      $out['status'] = TRUE;
    }
    else {
      $out['status'] = FALSE;
    }

    echo json_encode($out);
  }

  public function ajax_list()
  {
    $list = $this->m_pegawai->get_datatables();
    $data = array();
    $no = $_POST["start"];
    foreach ($list as $key => $value) {
     $no++;
     $row = array();
     
     //<a href="'.base_url('pegawai/id_card?r='.$this->encrypt->encode($value->id).'&key='.$value->nip).'" class="btn btn-icons btn-info btn-rounded" title="Kirim Email"><i class="mdi mdi-account"></i></a>

     $aksi = '
     <a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id."'".')"><i class="mdi mdi-pencil"></i></a>
     <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id."'".')"><i class="mdi mdi-delete"></i></a>';

     $row[] = $no;
     $row[] = $value->nip;
     $row[] = $value->nama_lengkap;
     $row[] = $value->email;
     $row[] = $value->unit;
     $row[] = "<a class='navbar-brand brand-logo'><img class='img-responsive' src='".base_url('assets/qrcode/'.$value->qrcode)."' style='width:90px;height:90px;'></a>";

     $row[] = $aksi;

     $data[] = $row;
   }

   $output = array(
     "draw" => $_POST['draw'],
     "recordsTotal" => $this->m_pegawai->count_all(),
     "recordsFiltered" => $this->m_pegawai->count_filtered(),
     "data" => $data,
   );
            //output to json format
   echo json_encode($output);
 }

 public function qr_code($nip)
 {
    $config['cacheable']    = true; //boolean, the default is true
    $config['cachedir']     = './assets/cache/'; //string, the default is application/cache/
    $config['errorlog']     = './assets/error/'; //string, the default is application/logs/
    $config['imagedir']     = './assets/qrcode/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '1024'; //interger, the default is 1024
    $config['black']        = array(224,255,255); // array, default is array(255,255,255)
    $config['white']        = array(70,130,180); // array, default is array(0,0,0)
    $this->ciqrcode->initialize($config);

    $image_name=$nip.'.png'; 

    $params['data'] = $nip; 
    $params['level'] = 'H'; 
    $params['size'] = 10;
    $params['savename'] = FCPATH.$config['imagedir'].$image_name;
    $this->ciqrcode->generate($params); 

    return $image_name;
  }

  public function ajax_add()
  {
    $this->_validate();

    $nip = $this->input->post('nip');

    $data = array(
     'nip' => $nip,
     'nama_lengkap' => $this->input->post('nama_lengkap'),
     'unit' => $this->input->post('unit'),
     'email' => $this->input->post('email'),
     'qrcode' => $this->qr_code($nip),
   );

    $insert = $this->m_pegawai->save($data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_edit($id)
  {
   $data = $this->m_pegawai->get_by_id($id);
   echo json_encode($data);
 }

 public function ajax_update()
 {
   $this->_validate();

   $nip = $this->input->post('nip');

   $data = array(
    'nip' => $nip,
    'nama_lengkap' => $this->input->post('nama_lengkap'),
    'unit' => $this->input->post('unit'),
    'email' => $this->input->post('email'),
    'qrcode' => $this->qr_code($nip),
  );


   $this->m_pegawai->update(array('id' => $this->input->post('id_pegawai')), $data);
   echo json_encode(array("status" => TRUE));
 }

 public function ajax_delete($id)
 {
   $row = $this->m_pegawai->get_by_id($id);

   $this->m_pegawai->delete_by_id($id);

   $get_file = './assets/qrcode/'.$row->qrcode;
   if(file_exists($get_file))
   { 
     @unlink($get_file); 
   }

   echo json_encode(array("status" => TRUE));
 }

 public function id_card()
 {
  $id = $this->input->get('key');
  $list = $this->m_pegawai->get_by_nip($id);

  $data = array(
    'peg' => $list,
  );

  $this->load->view('pegawai/id_card', $data);
}

private function _validate()
{
 $data = array();
 $data['error_string'] = array();
 $data['inputerror'] = array();
 $data['status'] = TRUE;
 $data['msg'] = "";

 if($this->input->post('nama_lengkap') == '')
 {
  $data['inputerror'][] = 'nama_lengkap';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($this->input->post('nip') == '')
{
  $data['inputerror'][] = 'nip';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($this->input->post('unit') == '')
{
  $data['inputerror'][] = 'unit';
  $data['error_string'][] = 'Tidak Boleh Kosong';
  $data['status'] = FALSE;
}

if($data['status'] === FALSE)
{
  echo json_encode($data);
  exit();
}
}

public function all_peserta($id)
{
  $row = $this->keikutsertaan->get_detail($id);
  $jml = 0;
  $format = $this->format->get_all();

  foreach ($row as $key => $val) {

    $email = $val->email;

    $data = array(
      'nama_lengkap' => $val->nama_lengkap,
      'nip' => $val->nip,
      'qrcode' => $val->qrcode,
      'pembuka' => $format->pembuka,
      'penutup' => $format->penutup,
    );

    $message = $this->load->view('pegawai/tes.php',$data,TRUE);

    $result = $this->kirim_email($email, $message);

    $jml = $jml + 1;
  }

  echo json_encode(array("status" => TRUE, "jml" => $jml));
}

public function sendQR(){

  $pegawai_ids = $this->input->post('pegawai_ids');

  //$this->m_jurnal->deleteJurnal($jurnal_ids);

  echo json_encode($pegawai_ids);
}

public function send_qr($id, $diklat_id)
{
  $row = $this->m_pegawai->get_by_id($id);
  $row_diklat = $this->diklat->get_by_id($diklat_id);
  $format = $this->format->get_all();
  $email = $row->email;

  $data = array(
    'nama_lengkap' => $row->nama_lengkap,
    'nip' => $row->nip,
    'qrcode' => $row->qrcode,
    'nama_diklat' => $row_diklat->nama_diklat,
    'tgl_mulai' => date('d F',strtotime($row_diklat->tgl_mulai)),
    'tgl_berakhir' => date('d F Y',strtotime($row_diklat->tgl_berakhir)),
    'jam_mulai' => $row_diklat->jam_mulai,
    'jam_selesai' => $row_diklat->jam_selesai,
    'tempat' => $row_diklat->tempat,
    'dc' => $row_diklat->dc,
    'pembuka' => $format->pembuka,
    'penutup' => $format->penutup,
  );

  $message = $this->load->view('pegawai/tes.php',$data,TRUE);

  $result = $this->kirim_email($email, $message);

  echo json_encode($result);
}

function kirim_email($email, $message)
{     
  $this->load->library('email');
  $this->load->library('parser');

        // Inisiasi library email
  $this->email->initialize(array(
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'protocol'  => 'smtp',
    'smtp_host' => 'smtp.sendgrid.net',
    'smtp_user' => 'fajri12345',  // Ganti dengan username akun SendGrid kamu
    'smtp_pass' => 'Usahadakwah123',  // Ganti dengan password akun SendGrid kamu
    'smtp_port' => 587,
    'crlf'      => "\r\n",
    'newline'   => "\r\n",
    'wordwrap' => TRUE
  ));

  $this->email->from('plnupdljkt@gmail.com', 'UDIKLAT JAKARTA');
  $this->email->to($email);
  $this->email->subject('QR Code Registrasi Diklat Udiklat Jakarta'); 
  $this->email->message($message);

  if (!$this->email->send()) {
    show_error($this->email->print_debugger()); 
  }
  else {
    return true;
  }
}

public function data_excel()
{
  $fileName = $this->input->post('excel_pegawai', TRUE);

  $config['upload_path'] = './assets/excel/'; 
  $config['file_name'] = $fileName;
  $config['allowed_types'] = 'xls|xlsx';
  $config['max_size'] = 10000;
  $config['overwrite'] = TRUE;

  $this->load->library('upload', $config);
  $this->upload->initialize($config); 

  if ($this->upload->do_upload('excel_pegawai')) {
   $media = $this->upload->data();
   $inputFileName = './assets/excel/'.$media['file_name'];

   try {
    $inputFileType = IOFactory::identify($inputFileName);
    $objReader = IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();
  $tot = 0;

  for ($row = 2; $row <= $highestRow; $row++){  
   $rowData = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row,
     NULL,
     TRUE,
     FALSE);

   $res =$this->m_pegawai->get_nip($rowData[0][0]);

   if($res) {

   } else {
     $data = array(
      'nip'  => $rowData[0][0],
      'nama_lengkap'   => $rowData[0][1],
      'email' => $rowData[0][2],
      'unit' => $rowData[0][3],
      'qrcode' => $this->qr_code($rowData[0][0]),
    );

     $this->m_pegawai->save($data);

     $tot = $tot + 1;
   }

 } 
 echo $tot.' Data Imported Successfully';
} 

}


}