<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('log/m_log');
		$this->load->model('diklat/m_diklat','diklat');
		$this->load->model('keikutsertaan/m_keikutsertaan','keikutsertaan');
		$this->load->model('pegawai/m_pegawai','pegawai');
	}

	function _template($data) {
		$this->load->view('template/main', $data);	
	}

	public function index()
	{
		$get_diklat = $this->diklat->get_all();

		$data = array(
			'get_diklat' => $get_diklat,
			'konten' => 'dashboard'
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

	public function pegawai_chart()
	{
		$data = $this->pegawai->chart_pegawai();
		print json_encode($data);
	}

	public function hadir_chart($id)
	{
		$data = $this->keikutsertaan->chart_hadir($id);

		$hadir = 0;
		$tidak = 0;

		foreach ($data as $key => $value) {
			if($value->keterangan == 'HADIR') {
				$hadir = $hadir + 1;
			} else {
				$tidak = $tidak + 1;
			}
		}

		$ket = array();

		for ($i=0; $i < 2; $i++) { 
			if($i == 0) {
				 $ket[$i]['status'] = "HADIR";
				 $ket[$i]['jml'] = $hadir;

			} 
			else if($i == 1) {
				 $ket[$i]['status']= "TIDAK-HADIR";
				 $ket[$i]['jml'] = $tidak;
			}

		}
		echo json_encode($ket);
	}
}