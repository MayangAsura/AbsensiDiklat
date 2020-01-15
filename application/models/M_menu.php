<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class M_menu extends CI_Model
{
	public $table = 'menu';
	public $order = 'DESC';
	public $id = 'id_menu';

	function __construct()
	{
		parent::__construct();
	}

	public function get_menu($level)
	{
		$this->db->select("menu.*,icon.icon as icon_menu");
		$this->db->order_by("id_menu", "ASC");
		$this->db->where("id_parents", "0");
		$this->db->where("level", $level);
		$this->db->join("icon", "icon.id_icon = menu.icon","INNER");
		return $this->db->get($this->table)->result();
	}

	public function get_submenu($level)
	{
		$this->db->select("menu.*,icon.icon as icon_menu");
		$this->db->order_by("id_menu", "ASC");
		$this->db->where("level", $level);
		$this->db->join("icon", "icon.id_icon = menu.icon","INNER");
		return $this->db->get($this->table)->result();
	}

}