<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class M_konfigurasi extends CI_Model
{
	public $table = 'konfig';
	public $order = 'DESC';
	public $id = 'id_konfig';

	function __construct()
	{
		parent::__construct();
	}

    public function get_konfig()
    {
        //$this->db->limit(1); 
        $this->db->order_by("id_konfig", "DESC");
        return $this->db->get($this->table)->row();
	}
	

}