<?php
class M_login extends CI_Model
{

	public $table = 'user';
	public $order = 'DESC';
	public $id = 'id_user';

	function __construct()
	{
		parent::__construct();
	}

	private function saveSession($id, $level, $pass, $f_name, $l_name, $username, $foto, $ta, $id_level) 
	{
		$array=array(
			"id"=>$id,
			"level"=>$level,
			"pass"=>$pass,
			"f_name"=>$f_name,
			"l_name"=>$l_name,
			"username"=>$username,
			"foto"=>$foto,
			"ta"=>$ta,
			"id_level" => $id_level,
			);

		$this->session->set_userdata($array);
	}

	function checkOldPass($old_password)
	{
		$this->db->where('id_user', $this->session->userdata("id"));
		$query = $this->db->get($this->table);
		$row  = $query->row();
		
		if($row->username != null){
			$row = $query->row();
			if($old_password == $row->password){
				return true;
			}else{
				return false;
			}
		}
	}

	function getDataLevel($id) {
		$this->db->where("id_level",$id);
		$data=$this->db->get("level")->row();
		return $data->level;
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	function cekLogin()
	{	
		date_default_timezone_set("Asia/Jakarta");

		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$ta = $this->input->post('ta');

		$this->db->where("username",$username);
		$this->db->where("password",$password);
		$login=$this->db->get("user");

		if($login->num_rows() == 1) {
			$login=$login->row();
			$this->saveSession($login->id_user,$this->getDataLevel($login->level),$this->input->post('password'),$login->f_name,$login->l_name,$login->username,$login->foto,$ta,$login->level);

			$data = array(
				'status' => "1",
				'last_login' => date('Y-m-d H:i:s'),
				'last_loginIP' => $this->input->ip_address(),
				);

			$this->update(array('id_user' => $login->id_user), $data);

			return "1_".$this->getDataLevel($login->level);
		} else {
			return "0_user/pass";
		}
	}
}
?>