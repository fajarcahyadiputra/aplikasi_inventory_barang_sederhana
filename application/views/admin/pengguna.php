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
						<h3>DATA PENGGUNA SISTEM</h3>
					</div>
					<div class="col-sm-6 text-right">
						<?php if($this->session->userdata('level') === 'admin'){ ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPengguna">
								Tambah Pengguna
							</button>
						<?php }?>
					</div>
				</div>
			</div>
			<div class="card-body">
				<?php if($this->session->userdata('level') === 'admin'){ ?>

					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="tablePengguna">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Username</th>
									<th>Password</th>
									<th>Status Aktif</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; foreach ($pengguna as $key => $dt): ?>
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo $dt->nama ?></td>
									<td><?php echo $dt->username ?></td>
									<td class="text-center">
										<button type="button" id="tombolEditPassword" class="btn btn-success" data-id="<?php echo $dt->id ?>">
											Edit Password
										</button>
									</td>
									<td><?php echo $dt->status_aktif ?></td>
									<td>
										<div class="text-center">
											<button class="btn btn-info" id="tombol_editPengguna" data-id="<?php echo $dt->id ?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-danger" id="tombol_hapusPengguna" data-id="<?php echo $dt->id ?>"><i class="fa fa-trash"></i></button>
										</div>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>

			<?php }else{ ?>

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Username</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1; foreach ($pengguna as $key => $dt): ?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $dt->nama ?></td>
								<td><?php echo $dt->username ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>


		<?php } ?>
	</div>
</div>
</div>


<!-- Modal tambah-->
<div class="modal fade" id="modalTambahPengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_tambahPengguna">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama</label>
						<input required="" type="text" name="nama" class="form-control">
					</div>
					<div class="form-group">
						<label>Username</label>
						<input required="" type="text" name="username" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input required="" type="text" name="password" class="form-control">
					</div>
					<!-- <div class="form-group">
						<label>Level</label>
						<select required="" name="level" class="form-control">
							<option value="" disabled="" selected="" hidden="">Pilih Status Level</option>
							<option value="admin">Admin</option>
							<option value="sub_admin">Sub Admin</option>
						</select>
					</div> -->
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
<div class="modal fade" id="modalEditPengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Edit Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_editPengguna">
				
			</form>
		</div>
	</div>
</div>
<!-- end -->


<!-- modal edit data -->
<div class="modal fade" id="modalEditPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Edit Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_editPassword">
				
			</form>
		</div>
	</div>
</div>
<!-- end -->

<script>
	$(document).ready(function(){

		let table = $('#tablePengguna').DataTable({
			"paging": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			async: true
		})

		//ajax untuk tambah data

		$('#form_tambahPengguna').on('submit',function(e){
			e.preventDefault();

			const data = $('#form_tambahPengguna').serialize();

			$.ajax({
				url: base_url+'Pengguna/tambah_pengguna',
				type: 'post',
				dataType: 'json',
				data: data,
				success: function(hasil){

					$('#modalTambahPengguna').modal('hide');
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
		$('#tablePengguna').on('click', '#tombol_hapusPengguna', (e)=>{
			const id = e.target.getAttribute('data-id');

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
						url: base_url+'Pengguna/HapusData',
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
		$('#tablePengguna').on('click','#tombol_editPengguna', function(){
			const id = $(this).data('id');
			$.ajax({
				url: base_url+'Pengguna/tampilEditPengguna',
				data:{"id":id},
				dataType: 'json',
				type: 'post',
				success: function(hasil){
					$('#form_editPengguna').html(`
						<div class="modal-body">
						<div class="form-group">
						<label>Nama</label>
						<input required="" type="text" name="nama" class="form-control" value="${hasil.nama}">
						<input required="" hidden type="text" name="id" class="form-control" value="${hasil.id}">
						</div>
						<div class="form-group">
						<label>Username</label>
						<input required="" type="text" name="username" class="form-control" value="${hasil.username}">
						</div>
						<div class="form-group">
						<label>Level</label>
						<select required="" name="level" class="form-control">
						<option value="" disabled="" selected="" hidden="">Pilih Status Level</option>
						<option ${hasil.level === 'admin'?'selected':''} value="admin">Admin</option>
						<option ${hasil.level === 'sub_admin'?'selected':''} value="sub_admin">Sub Admin</option>
						</select>
						</div>
						<div class="form-group">
						<label>Status Aktif</label>
						<select required="" name="status_aktif" class="form-control">
						<option value="" disabled="" selected="" hidden="">Pilih Status Level</option>
						<option ${hasil.status_aktif === 'ya'?'selected':''} value="ya">Ya</option>
						<option ${hasil.status_aktif === 'tidak'?'selected':''} value="tidak">Tidak</option>
						</select>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Edit</button>
						</div>
						`);
					$('#modalEditPengguna').modal('show');
				}
			})
		})
		//end

		//ajax untuk edit data pengguna
		$('#form_editPengguna').on('submit', function(e){
			e.preventDefault();
			const data = $('#form_editPengguna').serialize();
			$.ajax({
				url: base_url+'Pengguna/editData',
				data: data,
				dataType: 'json',
				type:'post',
				success: function(hasil){
					$('#modalEditPengguna').modal('hide');
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

		//ajax untuk edit password

		$('#tablePengguna').on('click','#tombolEditPassword', function(){
			const id =$(this).data('id');

			$('#modalEditPassword').modal('show');
			$('#form_editPassword').html(`<div class="modal-body">
				<div class="form-group">
				<label>Password Baru</label>
				<input required="" type="text" name="password" class="form-control">
				<input hidden required="" type="text" name="id" class="form-control" value="${id}">
				</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Edit</button>
				</div>`);
		})

		$('#form_editPassword').on('submit', function(e){
			e.preventDefault();
			const data = $('#form_editPassword').serialize();
			$.ajax({
				url: base_url+'Pengguna/gantiPassword',
				data: data,
				dataType: 'json',
				type: 'post',
				success: function(hasil){
					$('#modalEditPassword').modal('hide');
					setTimeout(function(){
						location.reload();
					},800);
					if(hasil.edit == true){
						Swal.fire(
							'Sukses',
							'Password Berhasil Di Edit',
							'success'
							)
					}else{
						Swal.fire(
							'Oops!',
							'Password gagal Di Edit.',
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