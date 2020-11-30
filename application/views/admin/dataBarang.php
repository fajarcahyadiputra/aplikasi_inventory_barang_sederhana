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
						<h3>DATA BARANG</h3>
					</div>
					<div class="col-sm-6 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahBarang">
							Tambah Barang
						</button>
						<a href="<?= base_url("DataBarang/reportExcel") ?>" class="btn btn-warning" >
							Report Excel
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover" id="tableBarang" style="width: 100%">
						<thead>	
							<tr>
								<th width="5%">No</th>
								<th width="3%">id</th>
								<th width="10%">Nama Pembuat</th>
								<th width="10%">Nama Barang</th>
								<th width="5%">Stok</th>
								<th width="13%">tanggal Buat</th>
								<th width="14%">tanggal Update</th>
								<th width="25%">Keterangan</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1; foreach ($barang as $key => $dt): 
							$user = $this->db->get_where('tb_users', ['id' => $dt->id_user])->row();
							?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $dt->id ?></td>
								<td><?php echo $user->nama ?></td>
								<td><?php echo $dt->nama_barang ?></td>
								<td><?php echo $dt->stok ?></td>
								<td><?php echo $dt->tanggal_buat ?></td>
								<td><?php echo $dt->terakhir_update ?></td>
								<td width="30%" style="word-break: break-all;"><?php echo $dt->keterangan ?></td>
								<td>
									<div class="d-flex justify-content-center">
										<button class="btn btn-info btn-sm" id="tombol_editBarang" data-id="<?php echo $dt->id ?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-danger btn-sm ml-2" id="tombol_hapusBarang" data-id="<?php echo $dt->id ?>"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_tambahBarang">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Barang</label>
						<input required="" type="text" name="namaBarang" class="form-control">
					</div>
					<div class="form-group">
						<label>Stok</label>
						<input required="" type="number" name="stok" class="form-control">
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
			<form id="form_editBarang">
				


			</form>
		</div>
	</div>
</div>
<!-- end -->




<script>
	$(document).ready(function(){

		let table = $('#tableBarang').DataTable({
			"paging": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			async: true
		})

		//ajax untuk tambah data

		$('#form_tambahBarang').on('submit',function(e){
			e.preventDefault();
			const data = $('#form_tambahBarang').serialize();
			$.ajax({
				url: base_url+'DataBarang/tambahBarang',
				type: 'post',
				dataType: 'json',
				data: data,
				success: function(hasil){
					$('#form_tambahBarang').modal('hide');
					if(hasil.tambah == true){
						Swal.fire({
							icon: 'success',
							title: 'Berhasil...',
							text: 'Selamat Data Berhasil Di Tambahkan!',
						})
					}else{
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Data Gagal Di Tambahkan!',
						})
					}
					setTimeout(function(){
						location.reload();
					}, 800);
				}
			})
		})

		//end

		//ajax untuk hapus data
		$('#tableBarang').on('click', '#tombol_hapusBarang', function(){
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
						url: base_url+'DataBarang/HapusData',
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
		$('#tableBarang').on('click','#tombol_editBarang', function(){
			const id = $(this).data('id');
			$.ajax({
				url: base_url+'DataBarang/tampilDataBarang',
				data:{"id":id},
				dataType: 'json',
				type: 'post',
				success: function(hasil){
					$('#modalEditBarang').modal('show');
					$('#form_editBarang').html(`
						<div class="modal-body">
						<div class="form-group">
						<label>Nama Barang</label>
						<input required="" type="text" name="namaBarang" value="${hasil.nama_barang}" class="form-control">
						<input required="" type="text" hidden="" name="id" value="${hasil.id}" class="form-control">
						</div>
						<div class="form-group">
						<label>Stok</label>
						<input required="" type="number" name="stok" class="form-control" value="${hasil.stok}">
						</div>
						<div class="form-group">
						<label>Keterangan</label>
						<textarea name="keterangan"cols="30" rows="3" class="form-control">${hasil.keterangan}</textarea>
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
		$('#form_editBarang').on('submit', function(e){
			e.preventDefault();
			const data = $('#form_editBarang').serialize();
			$.ajax({
				url: base_url+'DataBarang/editBarang',
				data: data,
				dataType: 'json',
				type:'post',
				success: function(hasil){
					$('#modalEditBarang').modal('hide');
					setTimeout(function(){
						location.reload();
					},800);
					if(hasil.edit == true){
						Swal.fire(
							'Sukses',
							'Data Berhasil Di Edit',
							'success'
							)
					}else{
						Swal.fire(
							'Oops!',
							'Data gagal Di Edit.',
							'error'
							)
					}
				}
			})
		})
		//end
	})
</script>

<?php } ?>