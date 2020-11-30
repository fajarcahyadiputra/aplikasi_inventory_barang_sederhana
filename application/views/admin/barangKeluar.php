<?php 
if (!$this->session->userdata('username')) {
	redirect('auth');
} else {
	?>

	<div class="container-fluid" id="container-wrapper">
		<div class="card mb-5" >
			<div class="card-header" style="background-color: aquamarine">
				<div class="row">
					<div class="col-sm-6">
						<h3>DATA BARANG KELUAR</h3>
					</div>
					<div class="col-sm-6 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahkeluar">
							Tambah Barang Keluar
						</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover" id="tableKeluar" style="width: 100%">
						<thead>	
							<tr>
								<th width="5%">No</th>
								<th width="3%">id</th>
								<th width="13%">Nama Barang</th>
								<th width="13%">Nama Pembuat</th>
								<th width="5%">Jumblah</th>
								<th width="10%">tanggal Keluar</th>
								<th width="14%">Keterangan</th>
								<th width="7%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1; foreach ($keluar as $dt): 
							$user = $this->db->get_where('tb_users', ['id' => $dt->id_user])->row();
							$br = $this->db->get_where('tb_barang',['id' => $dt->id_barang])->row();
							?>
							<tr class="text-center">
								<td><?php echo $no++ ?></td>
								<td><?php echo $dt->id ?></td>
								<td><?php echo $br->nama_barang ?></td>
								<td><?php echo $user->nama ?></td>
								<td><?php echo $dt->jumblah ?></td>
								<td><?php echo $dt->tanggal_keluar ?></td>
								<td width="30%" style="word-break: break-all;"><?php echo $dt->keterangan ?></td>
								<td>
									<div class="d-flex justify-content-center">
										<button class="btn btn-info btn-sm" id="tombol_editKeluar" data-id="<?php echo $dt->id ?>"><i class="fa fa-edit"></i></button>
										<a target="_blank" class="btn btn-primary  ml-2" href="<?php echo base_url('BarangKeluar/cetak_invoice/'). $dt->id?>"><i class="fas fa-print"></i></a>
										<button class="btn btn-danger btn-sm ml-2" id="tombol_hapusKeluar" data-id="<?php echo $dt->id ?>"><i class="fa fa-trash"></i></button>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Modal tambah-->
<div class="modal fade" id="modalTambahkeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_tambahKeluar">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Barang</label>
						<select required="" name="id_barang" class="form-control">
							<option value="" selected="" disabled="" hidden="">Pilih Barang</option>
							<?php foreach ($barang as $br): ?>
								<option value="<?php echo $br->id ?>"><?php echo $br->nama_barang ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<label>jumblah</label>
						<input required="" type="number" name="jumblah" class="form-control">
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<textarea name="keterangan"cols="30" rows="3" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end -->

<!-- modal edit data -->
<div class="modal fade" id="modalEditBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Edit Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_editKeluar">
				


			</form>
		</div>
	</div>
</div>
<!-- end -->




<script>
	$(document).ready(function(){

		let table = $('#tableKeluar').DataTable({
			"paging": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			async: true
		})

		//ajax untuk tambah data

		$('#form_tambahKeluar').on('submit',function(e){
			e.preventDefault();
			const data = $('#form_tambahKeluar').serialize();
			$.ajax({
				url: base_url+'BarangKeluar/tambahKeluar',
				type: 'post',
				dataType: 'json',
				data: data,
				success: function(hasil){
					$('#modalTambahkeluar').modal('hide');
					if(hasil.tambah == true){
						Swal.fire({
							icon: 'success',
							title: 'Berhasil...',
							text: 'Selamat Data Berhasil Di Tambahkan!',
							footer: `<a target="_blank" class="btn btn-info" href="${base_url + 'BarangKeluar/cetak_invoice/' + hasil.id}">Print?</a>`
						}).then(()=>{
							setTimeout(function(){
								location.reload();
							}, 800);
						})

					}else if(hasil.tambah === 'kosong'){
						Swal.fire({
							icon: 'error',
							title: 'Maaf Stok Tidak Cukup!',
							text: `Stok: ${hasil.stok}`,
						})
					}else{
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Data Gagal Di Tambahkan!',
						})
						setTimeout(function(){
							location.reload();
						}, 800);
					}
					
				}
			})
		})

		//end

		//ajax untuk hapus data
		$('#tableKeluar').on('click', '#tombol_hapusKeluar', function(){
			const id = $(this).data('id');
			Swal.fire({
				title: 'Apakah kamu yakin?',
				text: "Ingin Menghapus Data ini!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus!'
			}).then((result) => {
				if (result.value) {

					$.ajax({
						url: base_url+'BarangKeluar/HapusKeluar',
						data: {"id":id},
						type: 'post',
						dataType: 'json',
						success: function(hasil){
							setTimeout(function(){
								location.reload();
							},800);
							if(hasil.hapus == true){
								Swal.fire(
									'Terhapus',
									'Data Berhasil Di hapus',
									'success'
									)
							}else{
								Swal.fire(
									'Oops!',
									'Data gagal Di Hapus.',
									'error'
									)
							}
						}
					})

				}
			})
		})
		//end

		//ajax tampil data pengguna
		$('#tableKeluar').on('click','#tombol_editKeluar', function(){
			const id = $(this).data('id');
			$.ajax({
				url: base_url+'BarangKeluar/tampilDataBarangKeluar',
				data:{"id":id},
				dataType: 'json',
				type: 'post',
				success: function(hasil){
					$('#modalEditBarang').modal('show');
					// let date = new Date(hasil.tanggal_keluar);

					// let tanggal_keluar = date.getDate()+'/'+date.getMonth()+'/'+date.getFullYear();
					$('#form_editKeluar').html(`
						<div class="modal-body">
						<div class="form-group">
						<label>Nama Barang</label>
						<select required="" name="id_barang" class="form-control">
						<?php foreach ($barang as $br): ?>
							<option ${hasil.id_barang === <?php echo $br->id ?>?'selected':''} value="<?php echo $br->id ?>"><?php echo $br->nama_barang ?></option>
						<?php endforeach ?>
						</select>
						</div>
						<div class="form-group">
						<label>jumblah</label>
						<input required="" type="number" name="jumblah" class="form-control" value="${hasil.jumblah}">
						<input required="" type="number" name="id" class="form-control" hidden value="${hasil.id}">
						<input required="" type="number" name="id_barang_lama"  hidden value="${hasil.id_barang}">
						</div>
						<div class="form-group">
						<label>Keterangan</label>
						<textarea name="keterangan"cols="30" rows="3" class="form-control">${hasil.keterangan}</textarea>
						</div>
						<div class="form-group">
						<label>Tanggal Keluar</label>
						<input required="" type="date" name="tanggal_keluar" class="form-control" value="${hasil.tanggal_keluar}">
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Edit</button>
						</div>
						`)
				}
			})
		})
		//end

		//ajax untuk edit data pengguna
		$('#form_editKeluar').on('submit', function(e){
			e.preventDefault();
			const data = $('#form_editKeluar').serialize();
			$.ajax({
				url: base_url+'BarangKeluar/editBarangKeluar',
				data: data,
				dataType: 'json',
				type:'post',
				success: function(hasil){
					$('#modalEditBarang').modal('hide');
					if(hasil.edit == true){
						Swal.fire({
							icon: 'success',
							title: 'Berhasil...',
							text: 'Selamat Data Berhasil Di Tambahkan!',
							footer: `<a target="_blank" class="btn btn-info" href="${base_url + 'BarangKeluar/cetak_invoice/' + hasil.id}">Print?</a>`
						}).then(()=>{
							setTimeout(function(){
								location.reload();
							}, 800);
						})

					}else if(hasil.edit === 'kosong'){
						Swal.fire({
							icon: 'error',
							title: 'Maaf Stok Tidak Cukup!',
							text: `Stok: ${hasil.stok}`,
						})
					}else{
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Data Gagal Di Tambahkan!',
						})
						setTimeout(function(){
							location.reload();
						}, 800);
					}
					
				}
			})
		})
		//end
	})
</script>

<?php } ?>