<?php

class M_pengguna extends CI_Model
{
	protected $table = 'tb_users';

	public function getPengguna($where = 0)
	{
		if($where === 0){
			return $this->db->get($this->table)->result();
		}else{
			return $this->db->get_where($this->table,$where)->row();
		}
	}
	public function tambahData($data)
	{
		return $this->db->insert($this->table,$data);
	}
	public function hapusData($where)
	{
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
	public function editData($data, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $data);
	}
}