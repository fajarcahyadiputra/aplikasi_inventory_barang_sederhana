<?php

class M_barangKeluar extends CI_Model
{
	protected $table = 'tb_barangkeluar';

	public function getKeluar($where = null)
	{
		if($where === null){
			return $this->db->get($this->table)->result();
		}else{
			return $this->db->get_where($this->table, $where)->row();
		}
	}
	public function tambahBarang($data)
	{
		 $tambah = $this->db->insert($this->table, $data);
		 if($tambah){
		 	$data = ['tambah' => true, 'id' => $this->db->insert_id()];
		 }else{
		 	$data = ['tambah' => false];
		 }
		 return $data;
	}
	public function removeStufOut($where)
	{
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
	public function editKeluar($data, $where)
	{
		$this->db->where($where);
		$edit = $this->db->update($this->table, $data);
		if($edit){
		 	$data = ['edit' => true, 'id' => $this->db->insert_id()];
		 }else{
		 	$data = ['edit' => false];
		 }
		 return $data;
	}
}