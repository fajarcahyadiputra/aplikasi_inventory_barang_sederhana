<?php

class M_dataBarang extends CI_Model
{
	protected $table = 'tb_barang';
	public function getBarang($where = null)
	{
		if($where === null){
			return $this->db->get($this->table)->result();
		}else{
			return $this->db->get_where($this->table, $where)->row();
		}
	}
	public function tambahData($data)
	{
		return $this->db->insert($this->table, $data);
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