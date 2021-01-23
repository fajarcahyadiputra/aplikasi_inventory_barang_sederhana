<?php

class BarangKeluar extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_dataBarang', 'barang');
		$this->load->model('M_barangKeluar', 'keluar');
		$this->load->library('Pdf');
	}
	public function index()
	{
		$data = [
			'barang' => $this->barang->getBarang(),
			'keluar' =>  $this->keluar->getKeluar(),
			'title' => 'Data Barang Keluar',
		];
		$this->load->view('admin/templet/header', $data);
		$this->load->view('admin/templet/sidebar');
		$this->load->view('admin/barangKeluar', $data);
		$this->load->view('admin/templet/footer');
	}
	public function tambahKeluar()
	{
		$id_barang = $this->input->post('id_barang');
		$jumblah   = $this->input->post('jumblah');
		$keterangan = $this->input->post('keterangan');

		$stok      = $this->barang->getBarang(['id' => $id_barang]);
		$hasil_stok = $stok->stok - $jumblah;

		if ($hasil_stok >= 0) {

			$data 		= [
				'id_barang'	=> $id_barang,
				'id_user'	=> $this->session->userdata('id'),
				'jumblah'   => $jumblah,
				'tanggal_keluar' => date('Y-m-d h:i:s'),
				'keterangan' => $keterangan
			];

			$pesan = [];
			$tambah = $this->keluar->tambahBarang($data);

			if ($tambah['tambah'] === true) {
				$this->barang->editData(['stok' => $hasil_stok], ['id' => $id_barang]);
				$pesan['id']     = $tambah['id'];
				$pesan['tambah'] = true;
			} else {
				$pesan['tambah'] = false;
			}

			echo json_encode($pesan);
		} else {
			$pesan['tambah'] = 'kosong';
			$pesan['stok']   = $stok->stok;
			echo json_encode($pesan);
		}
	}
	public function cetak_invoice($id)
	{
		$data['keluar'] = $this->keluar->getKeluar(['id' => $id]);
		$this->load->view('laporan_invoice', $data);
		// $data    = [
		// 	'keluar'  => $this->keluar->getKeluar(['id' => $id]),
		// 	'title'   => 'Laporan Barang Keluar'
		// ];

		// $this->pdf->filename = "laporan barang keluar.pdf";
		// $this->pdf->load_view('laporan_invoice', $data);
	}
	public function HapusKeluar()
	{
		$where = ['id' => $this->input->post('id')];
		$hapus = $this->keluar->removeStufOut($where);
		$pesan = [];
		if ($hapus) {
			$pesan['hapus'] = true;
		} else {
			$pesan['hapus'] = false;
		}

		echo json_encode($pesan);
	}
	public function tampilDataBarangKeluar()
	{
		$where = ['id' => $this->input->post('id')];
		$data  = $this->keluar->getKeluar($where);
		echo json_encode($data);
	}
	public function editBarangKeluar()
	{
		$id_barang = $this->input->post('id_barang');
		$jumblah   = $this->input->post('jumblah');
		$keterangan = $this->input->post('keterangan');
		$tanggal_keluar = $this->input->post('tanggal_keluar');
		$id_barang_lama = $this->input->post('id_barang_lama');

		$stok      = $this->barang->getBarang(['id' => $id_barang]);
		$hasil_stok = $stok->stok - $jumblah;

		if ($hasil_stok >= 0) {

			$data 		= [
				'id_barang'	=> $id_barang,
				'id_user'	=> $this->session->userdata('id'),
				'jumblah'   => $jumblah,
				'tanggal_keluar' => date('Y-m-d h:i:s'),
				'keterangan' => $keterangan
			];

			$where = ['id' => $this->input->post('id')];

			$pesan = [];
			$edit = $this->keluar->editKeluar($data, $where);

			if ($edit['edit'] === true) {
				$check = $this->keluar->getKeluar(['id' => $this->input->post('id')]);
				if ($check->jumblah != $jumblah) {
					$tambah_stok = $stok->stok + $check->jumblah;
					$this->barang->editData(['stok' => $tambah_stok], ['id' => $id_barang_lama]);
					$this->barang->editData(['stok' => $hasil_stok], ['id' => $id_barang]);
				}
				$pesan['id']     = $edit['id'];
				$pesan['edit'] = true;
			} else {
				$pesan['edit'] = false;
			}

			echo json_encode($pesan);
		}
	}
}
