<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class absensi extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_absensi');
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
			'konten' => 'data_absensi'
		);
		$this->_template($data);
	}

	public function ajax_list()
	{
		$list = $this->m_absensi->get_datatables();
		$data = array();
		$no = $_POST["start"];
		foreach ($list as $key => $value) {
			$no++;
			$row = array();

			$aksi = '<a href="javascript:void(0);" class="btn btn-icons btn-warning btn-rounded" title="Edit" onclick="edit('."'".$value->id."'".')"><i class="mdi mdi-pencil"></i></a> <a href="javascript:void(0);" class="btn btn-danger btn-icons btn-rounded" title="Hapus" onclick="hapus('."'".$value->id."'".')"><i class="mdi mdi-delete"></i></a>';
			$row[] = $no;
			$row[] = $value->nip.' - '.$value->nama_lengkap;
			$row[] = $value->kode_diklat.' - '.$value->nama_diklat;
			$row[] = date('d F Y',strtotime($value->tgl));
			$row[] = '<span class="badge badge-success" style="font-size:14px">'.$value->jam_masuk.'</span>';
			$row[] = $value->keterangan;

			$row[] = $aksi;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_absensi->count_all(),
			"recordsFiltered" => $this->m_absensi->count_filtered(),
			"data" => $data,
		);
            //output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->m_absensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'tanggal' => date('Y-m-d',strtotime($this->input->post('tanggal'))),
			'jam_masuk' => $this->input->post('jam_masuk'),
			'keterangan' => 'HADIR'
		);


		$this->m_absensi->update(array('id' => $this->input->post('id_absensi')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->m_absensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
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

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function export_excel()
	{

		$diklat_id = $this->input->post('diklat_id');
		$list = $this->m_absensi->get_data($diklat_id);
		$diklat = $this->diklat->get_by_id($diklat_id);

		$data = array(
			'kode_diklat' => $diklat->kode_diklat,
			'nama_diklat' => $diklat->nama_diklat,
			'get_data' => $list,
		);

		$this->load->view('absensi/rekap', $data);

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
		$this->email->subject('Konfirmasi Kehadiran'); 
		$this->email->message($message);

		if (!$this->email->send()) {
			show_error($this->email->print_debugger()); 
		}
		else {
			return true;
		}
	}


	public function scan_kehadiran()
	{
		date_default_timezone_set('Asia/Jakarta');

		$nip = $this->input->post('qr_nip');
		$diklat_id = $this->diklat->get_diklat_id();
		$pegawai_id = $this->pegawai->get_by_nip($nip);

		$absensi = $this->m_absensi->get_by_absen($nip, date('Y-m-d'));

		if (count($absensi) == 0) {

			$data = array(
				'diklat_id'=> $diklat_id->id,
				'pegawai_id' => $pegawai_id->id,
				'tgl' => date('Y-m-d'),
				'jam_masuk' => date('H:i:s'),
				'keterangan' => 'HADIR'
			);
			$kirim = $this->kirim_email($pegawai_id->email, "Terima Kasih, ".$pegawai_id->nama_lengkap." Anda Sudah Hadir Pada Diklat ".$diklat_id->nama_diklat." Pada Pukul " .date('H:i:s')             );
			$insert = $this->m_absensi->save($data);
		} 

		echo json_encode($insert);
	}
}