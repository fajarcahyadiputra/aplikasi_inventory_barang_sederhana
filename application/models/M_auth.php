<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model
{
	protected $table = 'tb_users';
	public function check_login($user, $pass)
	{
		return $this->db->get_where($this->table, ['username' => $user, 'password' => $pass]);
	}
}