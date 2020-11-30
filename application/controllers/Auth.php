<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_auth','auth');
	}
	public function index()
	{
		return $this->load->view('login');
	}
	public function proses_login()
	{
		if(!$_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->view('login');
		}else{
			$user = strtolower(trim(htmlspecialchars($this->input->post('username'))));
			$pass = sha1($this->input->post('password'));

			$check = $this->auth->check_login($user, $pass);
			$data  = $check->row();

			if($check->num_rows() > 0){
				if($data->status_aktif === 'ya'){
					$userdata = [
						'username' => $data->username,
						'id'	   => $data->id,
						'level'	   => $data->level,
						'Logged_in'=> true
					];

					$this->session->set_userdata($userdata);
					redirect('Home');
				}else{
					$this->session->set_flashdata('pesan','<div class="alert alert-danger">Maaf Account Anda Sudah Tidak Aktif</div>');
					redirect('Auth');
				}
			}else{
				$this->session->set_flashdata('pesan','<div class="alert alert-danger">Maaf Password / Username Anda Salah</div>');
				redirect('Auth');
			}

		}
	}
	public function logout_admin()
	{
		$this->session->unset_userdata(['username','level','Logged_in','id']);
		redirect('Auth');
	}
}