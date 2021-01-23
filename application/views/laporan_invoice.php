<div style="display: flex">
	<img style="margin-top: 15px; margin-right: 10px" width="150" height="100" src="<?php echo base_url('assets/img/logo_report.jpg') ?>">
	<div style="display: inline-table; line-height: 5px; margin-top: 25px">
		<p>JL.Raya Narogong Km.16,</p>
		<p>Cileungsi Bogor 16820 - Indonesia</p>
		<p>Tel : +62-21 8230 525;8249 1720</p>
		<p>Fax : +62-21 8230 525;8249 1720</p>
	</div>
</div>

<div style="display:flex ; justify-content: flex-end; ">
	<table>
		<tr>
			<th>Tanggal</th>
			<td>:</td>
			<td><?php echo date('Y-m-d') ?></td>
		</tr>
		<tr>
			<th>Admin</th>
			<td>:</td>
			<td><?php echo $this->db->get_where('tb_users', ['id' => $keluar->id_user])->row()->nama; ?></td>
		</tr>
	</table>
</div>
<p>Nomer Surat Jalan : TR<?php echo time() ?></p>

<hr>
<table border="1" cellspacing="0" cellpadding="6" style="width: 100%; margin-top: 20px;">
	<thead>
		<tr>
			<th>id</th>
			<th>Nama Barang</th>
			<th>Jumblah</th>
			<th>tanggal Keluar</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="5%"><?php echo $keluar->id ?></td>
			<td width="10%"><?php echo $this->db->get_where('tb_barang', ['id' => $keluar->id_barang])->row()->nama_barang; ?></td>
			<td width="10%"><?php echo $keluar->jumblah ?></td>
			<td width="10%"><?php echo $keluar->tanggal_keluar ?></td>
			<td width="30%" style="word-break: break-all;"><?php echo $keluar->keterangan ?></td>
		</tr>
	</tbody>
</table>

<!-- <div style="float: left; margin-top: 50px;">
	<div style="margin-bottom: 90px">
		Bekasi,...
	</div> -->


</div>

<div style="text-align: right;  margin-top: 50px;">
	<div style="margin-bottom: 90px">
		Bekasi, <?php echo date('Y-m-d') ?>
	</div>

	<div style=""><?php echo $this->db->get_where('tb_users', ['id' => $keluar->id_user])->row()->nama; ?></div>
</div>


<script>
	window.print();
</script>