<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = [
			'title' => 'Dashboard',
		];
		$this->load->view('admin/templet/header', $data);
		$this->load->view('admin/templet/sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/templet/footer');
	}
}