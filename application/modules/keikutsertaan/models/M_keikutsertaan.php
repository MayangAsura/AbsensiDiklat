<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class M_keikutsertaan extends CI_Model
{
	public $table = 'keikutsertaan';
	public $order = 'DESC';
	public $id = 'id';

	function __construct()
	{
		parent::__construct();
	}

	var $dt_column_order = array(null,'nama_diklat','nama_lengkap'); //set column field database for datatable orderable
	var $dt_column_search = array('nama_diklat','nama_lengkap');
     //set column field database for datatable searchable 
	var $dt_order = array('keikutsertaan.id' => 'DESC');

	private function _get_datatables_query()
	{
		$this->db->select("keikutsertaan.*, diklat.kode_diklat, diklat.nama_diklat, pegawai.nip, pegawai.nama_lengkap");
        $this->db->from($this->table);
        $this->db->join("diklat", "diklat.id = keikutsertaan.diklat_id","INNER");
        $this->db->join("pegawai", "pegawai.id = keikutsertaan.pegawai_id","INNER");
		$i = 0;

        foreach ($this->dt_column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->dt_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order'])) // here order processing
        {
        	$this->db->order_by($this->dt_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->dt_order))
        {
        	$order = $this->dt_order;
        	$this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->group_by("diklat.nama_diklat");
    } 
    
    function get_datatables()
    {
    	$this->_get_datatables_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function count_all()
    {
    	$this->db->select("*"); 
    	return $this->db->get($this->table)->num_rows();
    }

    function count_filtered() 
    {
    	$this->_get_datatables_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function get_all()
    {
        $this->db->order_by("id", "DESC");
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
    	$this->db->from($this->table);
    	$this->db->where($this->id,$id);
    	$query = $this->db->get();

    	return $query->row();
    }

    public function get_detail($id)
    {
        $this->db->select("keikutsertaan.*, pegawai.*");
        $this->db->from($this->table);
        $this->db->join("pegawai", "pegawai.id = keikutsertaan.pegawai_id","INNER");
        $this->db->where("diklat_id",$id);
        $query = $this->db->get();

        return $query->result();
    }

    public function chart_hadir($id)
    {
        $this->db->select("keikutsertaan.*, absensi.keterangan");
        $this->db->from($this->table);
        $this->db->join("absensi", "keikutsertaan.pegawai_id = absensi.pegawai_id","LEFT");
        $this->db->where("keikutsertaan.diklat_id",$id);
        $this->db->group_by("keikutsertaan.pegawai_id");
        $this->db->order_by("keikutsertaan.diklat_id", "DESC");
        $query = $this->db->get();

        return $query->result();
    }

    public function save($data)
    {
    	return $this->db->insert($this->table, $data);
    }

    public function update($where, $data)
    {
    	$this->db->update($this->table, $data, $where);
    	return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
    	$this->db->where($this->id, $id);
    	$this->db->delete($this->table);
    }

}