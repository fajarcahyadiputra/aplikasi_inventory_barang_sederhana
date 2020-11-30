<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataBarang extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_dataBarang','barang');
	}
	public function index()
	{
		$data = [
			'barang'=>  $this->barang->getBarang(),
			'title' => 'Data Barang',
		];
		$this->load->view('admin/templet/header', $data);
		$this->load->view('admin/templet/sidebar');
		$this->load->view('admin/DataBarang',$data);
		$this->load->view('admin/templet/footer');
	}
	public function tambahBarang()
	{
		$nama 		= $this->input->post('namaBarang');
		$stok 		= $this->input->post('stok');
		$keterangan = $this->input->post('keterangan');

		$data  		= [
			'nama_barang'	=> $nama,
			'id_user'		=> 1,
			'stok'			=> $stok,
			'keterangan'	=> $keterangan,
			'tanggal_buat'	=> date('Y-m-d h:i:s'),
			'terakhir_update'=> date('Y-m-d h:i:s'),
		];

		$tambah 	= $this->barang->tambahData($data);
		$pesan		= [];

		if($tambah){
			$pesan['tambah'] = true;
		}else{
			$pesan['tambah'] = false;
		}

		echo json_encode($pesan);
	}
	public function HapusData()
	{
		$where  = ['id' => $this->input->post('id')];
		$hapus  = $this->barang->hapusData($where);

		$pesan		= [];

		if($hapus){
			$pesan['hapus'] = true;
		}else{
			$pesan['hapus'] = false;
		}

		echo json_encode($pesan);
	}
	public function tampilDataBarang()
	{
		$where  = ['id' => $this->input->post('id')];
		$data  = $this->barang->getBarang($where);
		echo json_encode($data);
	}
	public function editBarang()
	{
		$nama 		= $this->input->post('namaBarang');
		$stok 		= $this->input->post('stok');
		$keterangan = $this->input->post('keterangan');

		$where 		= ['id' => $this->input->post('id')];

		$data  		= [
			'nama_barang'	=> $nama,
			'stok'			=> $stok,
			'keterangan'	=> $keterangan,
			'terakhir_update'=> date('Y-m-d h:i:s'),
		];

		$edit 	= $this->barang->editData($data, $where);
		$pesan		= [];

		if($edit){
			$pesan['edit'] = true;
		}else{
			$pesan['edit'] = false;
		}

		echo json_encode($pesan);
	}
	public function reportExcel()
	{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Barang');
			$sheet->setCellValue('C1', 'Stok');
			$sheet->setCellValue('D1', 'Keterangan');
			$sheet->setCellValue('E1', 'Tanggal Buat');
			
			$barang = $this->barang->getBarang();
			$no = 1;
			$x = 2;
			foreach($barang as $row)
			{
				$sheet->setCellValue('A'.$x, $no++);
				$sheet->setCellValue('B'.$x, $row->nama_barang);
				$sheet->setCellValue('C'.$x, $row->stok);
				$sheet->setCellValue('D'.$x, $row->keterangan);
				$sheet->setCellValue('E'.$x, $row->tanggal_buat);
				$x++;
			}
			$writer = new Xlsx($spreadsheet);
			$filename = 'laporan-barang';
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
	}
}