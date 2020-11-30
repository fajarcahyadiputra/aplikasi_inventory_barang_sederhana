<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_pengguna','user');
	}
	public function index()
	{
		$data = [
			'title' => 'Pengguna',
			'pengguna' => $this->user->getPengguna()
		];
		$this->load->view('admin/templet/header', $data);
		$this->load->view('admin/templet/sidebar');
		$this->load->view('admin/pengguna',$data);
		$this->load->view('admin/templet/footer');
	}
	public function tambah_pengguna()
	{
		$pesan      = [];
		$nama 		= $this->input->post('nama');
		$username	= $this->input->post('username');
		$password	= sha1($this->input->post('password'));
		$level 		= 'admin';

		$data  		= [
			'nama'			=> $nama,
			'username'		=> $username,
			'password'		=> $password,
			'level'			=> $level,
			'status_aktif'  => 'ya',
		];

		$tambah     = $this->user->tambahData($data);

		if($tambah){
			$pesan['tambah'] = true;
		}else{
			$pesan['tambah'] = false;
		}

		echo json_encode($pesan);
	}
	public function HapusData()
	{
		$where = ['id' => $this->input->post('id')];
		$hapus = $this->user->hapusData($where);
		$pesan=[];
		if($hapus){
			$pesan['hapus'] = true;
		}else{
			$pesan['hapus'] = false;
		}

		echo json_encode($pesan);
	}
	public function tampilEditPengguna()
	{
		$where = ['id' => $this->input->post('id')];
		$data = $this->user->getPengguna($where);
		echo json_encode($data);
	}
	public function editData()
	{
		$pesan      = [];
		$nama 		= $this->input->post('nama');
		$username	= strtolower($this->input->post('username'));
		$password	= sha1($this->input->post('password'));
		$level 		= $this->input->post('level');
		$status_aktif= $this->input->post('status_aktif');

		$where      = ['id' => $this->input->post('id')];

		$data  		= [
			'nama'			=> $nama,
			'username'		=> $username,
			'password'		=> $password,
			'level'			=> $level,
			'status_aktif'  => $status_aktif,
		];

		$edit     = $this->user->editData($data, $where);

		if($edit){
			$pesan['edit'] = true;
		}else{
			$pesan['edit'] = false;
		}

		echo json_encode($pesan);
	}
	public function gantiPassword()
	{
		$data   = [
			'password' => sha1($this->input->post('password')),
		];

		$where = ['id' => $this->input->post('id')];
		$edit = $this->user->editData($data, $where);
		$pesan = [];
		if($edit){
			$pesan['edit'] = true;
		}else{
			$pesan['edit'] = false;
		}

		echo json_encode($pesan);
	}
}