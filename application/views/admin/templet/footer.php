
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>copyright &copy; <script>
        document.write(new Date().getFullYear());
      </script> - developed by
      <b><a href="" target="_blank">diri sendiri</a></b>
    </span>
  </div>
</div>
</footer>
<!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>
<script src="<?php echo base_url('assets/') ?>ruangAdmin/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- boostrap min -->
<script src="<?php echo base_url('assets/') ?>ruangAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ruangadmin -->
<script src="<?php echo base_url('assets/') ?>ruangAdmin/js/ruang-admin.min.js"></script>
<!-- datatable -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url('assets/') ?>sweetalert/sweetalert2.all.min.js"></script>
</body>

</html>


<script type="text/javascript">
 $(document).ready(function(){

  <?php if (empty($id_tabel)) { ?>
    let id_tabel = 'zero';
  <?php  } else { ?>
    let id_tabel = "<?php echo $id_tabel ?>";
  <?php } ?>

  if (id_tabel === '') {

  } else {
    const table = $(`#${id_tabel}`).DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    })
  }
      //ajax untuk tambah akun
      // ambil nama beban berdasrakn kode
      $('#form_tambah_transaksiBeban').on('change','#kode_beban', function(){
        const kode_beban = $('#kode_beban').val();
        $.ajax({
          url: base_url+'admin/ambil_nama_beban',
          data: {"kode":kode_beban},
          type: 'post',
          dataType: 'json',
          success: function(hasil){
           $('#form_tambah_transaksiBeban .np').html(`
             <div class="form-group">
             <label for="nama_beban">Nama beban</label>
             <input required="" type="text" name="nama_beban" class="form-control" value="${hasil.nama_beban}">
             </div>
             `)

           // alert(hasil)
         }
       })
      })


      $('#form_tambah_transaksiBeban').on('submit', function(e){
        e.preventDefault();
        const data = $('#form_tambah_transaksiBeban').serialize();

        $.ajax({
          url: base_url + 'admin/tambah_transaksiBeban',
          data: data,
          type: 'post',
          dataType: 'json',
          success: function(hasil){
          // table.ajax.reload();
          if(hasil.insert == true){
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
          },800);
        }
      })
      })
    //end

    //hapus data transaksi
    $(`#${id_tabel}`).on('click', '#tombol_hapus_transaksiBeban', function(){
      const kode_beban  = $(this).data('kode_beban');
      const no_transaksi = $(this).data('notransaksi');

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
          url: base_url + 'admin/hapus_transaksiBeban',
          data: {'kode_beban':kode_beban,'no_transaksi': no_transaksi},
          type: 'post',
          dataType: 'json',
          success: function(hasil){
            if(hasil.hapus == true){
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: 'Selamat Data Berhasil Di Hapus!',
              })
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Gagal Di Hapus!',
              })
            }
            setTimeout(function(){
              location.reload();
            },800);
          }
        })
      }
    })
   })
    //end

    <?php if(!empty($beban)){ ?>

    //ajax tampil data transaksi beban
    $(`#${id_tabel}`).on('click', '#tombol_edit_transaksiBeban', function(){

     const kode_beban  = $(this).data('kode_beban');
     const no_transaksi = $(this).data('notransaksi');

     $.ajax({
      url: base_url + 'admin/tampil_transaksiBeban',
      data:{'no_transaksi':no_transaksi},
      type:'post',
      dataType: 'json',
      success: function(hasil){
        $('#form_edit_transaksiBeban').html(`
          <div class="form-group">
          <label for="no_transaksi">No Transaksi</label>
          <input required="" type="text" name="no_transaksi" class="form-control" value="${hasil.no_transaksi}">
          <input hidden  type="text" name="no_transaksi_lama" class="form-control" value="${hasil.no_transaksi}">
          </div>
          <div class="form-group">
          <label for="tanggal">Tanggal</label>
          <input required="" type="date" name="tanggal" class="form-control" value="${hasil.tanggal}">
          </div>
          <div class="form-group">
          <label for="kode_beban">Kode Beban</label>
          <select required="" name="kode_beban" id="kode_beban" class="form-control">
          <option value="${hasil.kode_beban}" selected="">${hasil.kode_beban}</option>
          <?php foreach ($beban as $key => $bn){ ?>
            <option <value="<?php echo $bn->kode_beban ?>"><?php echo $bn->kode_beban ?></option>
          <?php } ?>
          </select>
          </div>
          <div class="pe">

          </div>
          <div class="form-group">
          <label for="harga">Harga</label>
          <input required="" type="text" name="harga" class="form-control" value="${hasil.harga}">
          </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          `)
        $('#modal_edit_transaksiBeban').modal('show');
      }
    })
   })

    $('#form_edit_transaksiBeban').on('change','#kode_beban', function(){
      const kode_beban = $('#form_edit_transaksiBeban #kode_beban').val();

      $.ajax({
        url: base_url+'admin/ambil_nama_beban',
        data: {"kode":kode_beban},
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         $('#form_edit_transaksiBeban .pe').html(`
           <div class="form-group">
           <label for="nama_beban">Nama beban</label>
           <input required="" type="text" name="nama_beban" class="form-control" value="${hasil.nama_beban}">
           </div>
           `)
       }
     })
    })
    //end

  <?php } ?>



    //edit data akun
    $('#form_edit_transaksiBeban').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_edit_transaksiBeban').serialize();

      $.ajax({
        url: base_url + 'admin/edit_transaksiBeban',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         $('#modal_edit_akun').modal('hide');
         if(hasil.edit == true){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil...',
            text: 'Selamat Data Berhasil Di edit!',
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Gagal Di edit!',
          })
        }
        setTimeout(function(){
          location.reload();
        },800);
      }
    })
    })
    //end

    //ajax untuk tambah data
    $('#form_tambah_pendapatan').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_tambah_pendapatan').serialize();

      $.ajax({
        url: base_url+'admin/tambah_pendapatan',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         if(hasil.insert == true){
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
        },800);
      }
    })
    })
    //end

    //ajax untuk hapus pendapatan
    $(`#${id_tabel}`).on('click', '#tombol_hapus_pendapatan', function(){
      const id  = $(this).data('id');

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
        url: base_url+'admin/hapus_pendapatan',
        data:{'id':id},
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         if(hasil.hapus == true){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil...',
            text: 'Selamat Data Berhasil Di Hapus!',
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Gagal Di Hapus!',
          })
        }
        setTimeout(function(){
          location.reload();
        },800);
      }
      
    })
     }
   })
   })
    //end

    //ajax tampil edit pendapatan
    $(`#${id_tabel}`).on('click', '#tombol_edit_pendapatan', function(){
      const id = $(this).data('id');

      $.ajax({
        url: base_url+'admin/tampil_data_pendapatan',
        data:{'id':id},
        type:'post',
        dataType: 'json',
        success: function(hasil){
         $('#form_edit_pendapatan').html(`
          <div class="modal-body">
          <div class="form-group">
          <label for="kode_pendapatan">Kode pendapatan</label>
          <input required="" type="text" name="kode_pendapatan" class="form-control" value="${hasil.kode_pendapatan}">
          <input required="" name="kode_pendapatan_lama" hidden value="${hasil.kode_pendapatan}">
          </div>
          <div class="form-group">
          <label for="satuan">Satuan</label>
          <input required="" type="text" name="satuan" class="form-control" value="${hasil.satuan}">
          </div>
          <div class="form-group">
          <label for="nama_pendapatan">Nama Pendapatan</label>
          <input required="" type="text" name="nama_pendapatan" class="form-control" value="${hasil.nama_pendapatan}">
          </div>
          <div class="form-group">
          <label for="harga">Harga</label>
          <input required="" type="number" step="0.1" name="harga" class="form-control" value="${hasil.harga}">
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </div>
          `);
         $('#modal_edit_pendapatan').modal('show');
       }
     })
    })
    //end

    //edit data pendapatan
    $('#form_edit_pendapatan').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_edit_pendapatan').serialize();
      $.ajax({
        url: base_url+'admin/edit_pendapatan',
        data:data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         $('#modal_edit_pendapatan').modal('hide');
         if(hasil.edit == true){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil...',
            text: 'Selamat Data Berhasil Di edit!',
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Gagal Di edit!',
          })
        }
        setTimeout(function(){
          location.reload();
        },800);
      }
    })
    })
    //end

    //ajax tambah beban
    $('#form_tambah_beban').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_tambah_beban').serialize();
      $.ajax({
        url: base_url+'admin/tambah_beban',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
          if(hasil.insert == true){
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
          },800);
        }
      })
    })
    //end

    //ajax hapus beban
    $(`#${id_tabel}`).on('click','#tombol_hapus_beban', function(hasil){
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
          url: base_url+'admin/hapus_beban',
          data:{'id':id},
          type: 'post',
          dataType: 'json',
          success: function(hasil){
           if(hasil.hapus == true){
            Swal.fire({
              icon: 'success',
              title: 'Berhasil...',
              text: 'Selamat Data Berhasil Di Hapus!',
            })
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Data Gagal Di Hapus!',
            })
          }
          setTimeout(function(){
            location.reload();
          },800);
        }
      })

      }
    })

   })
    //end

    //ajax untuk tampil edit
    $(`#${id_tabel}`).on('click','#tombol_edit_beban', function(){
      const id = $(this).data('id');

      $.ajax({
        url: base_url+'admin/tampil_data_beban',
        data: {'id':id},
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         $('#form_edit_beban').html(`
          <div class="modal-body">
          <div class="form-group">
          <label for="kode_beban">Kode beban</label>
          <input required="" type="text" name="kode_beban" class="form-control" value="${hasil.kode_beban}">
          <input required=""  name="kode_beban_lama" hidden value="${hasil.kode_beban}">
          </div>
          <div class="form-group">
          <label for="nama_beban">Nama beban</label>
          <input required="" type="text" name="nama_beban" class="form-control" value="${hasil.nama_beban}">
          </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          `);
         $('#modal_edit_beban').modal('show');
       }
     })
    })
    //end

    //edit data beban
    $('#form_edit_beban').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_edit_beban').serialize();
      $.ajax({
        url: base_url+'admin/edit_beban',
        data:data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
          $('#modal_edit_beban').modal('hide');
          if(hasil.edit == true){
            Swal.fire({
              icon: 'success',
              title: 'Berhasil...',
              text: 'Selamat Data Berhasil Di edit!',
            })
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Data Gagal Di edit!',
            })
          }
          setTimeout(function(){
            location.reload();
          },800);
        }
      })
    })
    //end

    //tambah data transaksi pendapatan

    //mengecheck untuk menampilkan data pendapatan
    $('#form_tambah_tPendapatan').on('change','#kode_pendapatan', function(){
      const kode_pendapatan  = $(this).val();

      $.ajax({
        url: base_url+'admin/tampil_pendapatan',
        data: {'kode': kode_pendapatan},
        type: 'post',
        dataType: 'json',
        success: function(hasil){
          $('#form_tambah_tPendapatan .pnp').html(`
           <div class="form-group">
           <label for="nama_pendapatan">Nama Pendapatan</label>
           <input required="" type="text"  name="nama_pendapatan" class="form-control" value="${hasil.nama_pendapatan}">
           </div>
           `);
        }
      })
    })
    //end

    //menghitung jumblah pendapatan
    $('#form_tambah_tPendapatan').bind('change keyup','#qty', function(){
      const harga = $('#harga').val();
      const qty   = $('#qty').val();
      const hasil = harga * qty;
      $('#jumblah').val(hasil);
    })
    //end

    //tambah data 
    $('#form_tambah_tPendapatan').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_tambah_tPendapatan').serialize();

      $.ajax({
        url: base_url+'admin/tambah_transaksi_pendapatan',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         if(hasil.insert == true){
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
        },800);
      }
    })
    })
    //end

    //hapus data transaksi Pendaptan
    $(`#${id_tabel}`).on('click','#tombol_hapus_tPendapatan', function(){
      const no_t = $(this).data('id');

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
        url: base_url+'admin/hapus_tPendapatan',
        data: {'no_t':no_t},
        type: 'post',
        dataType: 'json',
        success: function(hasil){
          if(hasil.hapus == true){
            Swal.fire({
              icon: 'success',
              title: 'Berhasil...',
              text: 'Selamat Data Berhasil Di Hapus!',
            })
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Data Gagal Di Hapus!',
            })
          }
          setTimeout(function(){
            location.reload();
          },800);
        }
      })

     }
   })

   })
    //end

    //tampil data tPendapatan
    <?php if(!empty($pendapatan)){ ?>

      $(`#${id_tabel}`).on('click','#tombol_edit_tPendapatan', function(){
        const no_transaksi= $(this).data('id');
        $.ajax({
          url: base_url+'admin/tampil_data_tPendapatan',
          data:{'no_transaksi':no_transaksi},
          type: 'post',
          dataType: 'json',
          success: function(hasil){
            console.log(hasil)
            $('#form_edit_tPendapatan').html(`
              <div class="modal-body">
              <div class="form-group">
              <label for="no_transaksi">No Transakasi</label>
              <input required="" type="text" name="no_transaksi" class="form-control" value="${hasil.no_transaksi}">
              <input required="" type="text" name="no_transaksi_lama" hidden value="${hasil.no_transaksi}">
              </div>
              <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input required="" type="date" name="tanggal" class="form-control" value="${hasil.tanggal}">
              </div>
              <div class="form-group">
              <label for="kode_pendapatan">kode Pendapatan</label>
              <select name="kode_pendapatan" id="kode_pendapatan" class="form-control">
              <option value="${hasil.kode_pendapatan}" selected="">${hasil.kode_pendapatan}</option>
              <?php foreach ($pendapatan as $key => $p): ?>
                <option value="<?php echo $p->kode_pendapatan ?>"><?php echo $p->kode_pendapatan ?></option>
              <?php endforeach ?>
              </select>
              </div>
              <div class="pnp">

              </div>
              <div class="form-group">
              <label for="harga">Harga</label>
              <input required="" type="text" id="harga" name="harga" class="form-control" value="${hasil.harga}">
              </div>
              <div class="form-group">
              <label for="qty">qty</label>
              <input required="" type="number" id="qty" id="qty"  name="qty" class="form-control" value="${hasil.qty}">
              </div>
              <div class="form-group">
              <label for="jumblah">Jumblah</label>
              <input required="" type="number" id="jumblah"  name="jumblah" class="form-control" value="${hasil.jumblah}">
              </div>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Edit</button>
              </div>
              `)
            $('#modal_edit_tPendapatan').modal('show');
          }
        })
      })

          //mengecheck untuk menampilkan data pendapatan
          $('#form_edit_tPendapatan').on('change','#kode_pendapatan', function(){
            const kode_pendapatan  = $(this).val();
            $.ajax({
              url: base_url+'admin/tampil_pendapatan',
              data: {'kode': kode_pendapatan},
              type: 'post',
              dataType: 'json',
              success: function(hasil){
                $('#form_edit_tPendapatan .pnp').html(`
                 <div class="form-group">
                 <label for="nama_pendapatan">Nama Pendapatan</label>
                 <input required="" type="text"  name="nama_pendapatan" class="form-control" value="${hasil.nama_pendapatan}">
                 </div>
                 `);
              }
            })
          })
    //end

        //menghitung jumblah pendapatan
        $('#form_edit_tPendapatan').bind('change keyup','#qty', function(){
          const harga = $('#form_edit_tPendapatan #harga').val();
          const qty   = $('#form_edit_tPendapatan #qty').val();
          const hasil = harga * qty;
          $('#form_edit_tPendapatan #jumblah').val(hasil);
        })
    //end

  <?php } ?>
    //end

    //edit data lainya
    $('#form_edit_tPendapatan').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_edit_tPendapatan').serialize();
      $.ajax({
        url: base_url+'admin/edit_tPendapatan',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         $('#modal_edit_lainya').modal('hide');
         if(hasil.edit == true){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil...',
            text: 'Selamat Data Berhasil Di edit!',
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Gagal Di edit!',
          })
        }
        setTimeout(function(){
          location.reload();
        },800);
      }
    })
    })
    //end

    //ajax untuk tambah user
    $('#form_tambah_user').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_tambah_user').serialize();
      $.ajax({
        url: base_url+'admin/tambah_user',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
          if(hasil.insert == true){
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
          },800);
        }
      })
    })
    //end

    //ajax untuk hapus user
    $(`#${id_tabel}`).on('click', '#tombol_hapus_user', function(){
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
          url: base_url+'admin/hapus_user',
          data: {'id':id},
          type: 'post',
          dataType: 'json',
          success: function(hasil){
            if(hasil.hapus == true){
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: 'Selamat Data Berhasil Di Hapus!',
              })
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Gagal Di Hapus!',
              })
            }
            setTimeout(function(){
              location.reload();
            },800);
          }
        })

      }
    })
   })
    //end

    //tampildata edit user
    $(`#${id_tabel}`).on('click','#tombol_edit_user', function(){
      const id = $(this).data('id');
      $.ajax({
        url: base_url+'admin/tampil_data_user',
        type: 'post',
        data:{'id':id},
        dataType: 'json',
        success: function(hasil){
          $('#form_edit_user').html(`
           <div class="modal-body">
           <div class="form-group">
           <label for="kode_user">Kode User</label>
           <input required="" type="text" name="kode_user" class="form-control" value="${hasil.kode_user}">
           <input  type="text" name="kode_user_lama" hidden value="${hasil.kode_user}">
           </div>
           <div class="form-group">
           <label for="nama_user">Nama User</label>
           <input required="" type="text" name="nama_user" class="form-control" value="${hasil.nama_user}">
           </div>
           <div class="form-group">
           <label for="nik">NIK</label>
           <input required="" type="number"  name="nik" class="form-control" value="${hasil.nik}">
           </div>
           <div class="form-group">
           <label for="username">Username</label>
           <input required="" type="text" name="username" class="form-control" value="${hasil.username}">
           </div>
           <div class="alert alert-info">Isi form input password di bawah jika ingin menganti password</div>
           <div class="form-group">
           <label for="password">Password</label>
           <input required="" type="text"  name="password_baru" class="form-control">
           <input required="" type="text"  name="password_lama" hidden value="${hasil.password}">
           </div>  
           <div class="form-group">
           <label for="jabatan">Jabatan</label>
           <input required="" type="text" name="jabatan" class="form-control" value="${hasil.jabatan}">
           </div>
           <div class="form-group">
           <label for="status_aktif">Status Aktif</label>
           <select name="status_aktif" id="status_aktif" class="form-control">
           <option ${hasil.status_aktif === 'aktif'?'selected':''} value="aktif">Aktif</option>
           <option  ${hasil.status_aktif === 'tidak'?'selected':''} value="tidak">Tidak</option>
           </select>
           </div>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-primary">Edit</button>
           </div>
           `)
          $('#modal_edit_user').modal('show');
        }
      })
    })
    //end

    //ajax edit data user
    $('#form_edit_user').on('submit', function(e){
      e.preventDefault();
      const data = $('#form_edit_user').serialize();
      $.ajax({
        url: base_url+'admin/edit_user',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(hasil){
         if(hasil.edit == true){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil...',
            text: 'Selamat Data Berhasil Di edit!',
          })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Gagal Di edit!',
          })
        }
        setTimeout(function(){
          location.reload();
        },800);
      }
    })
    })
    //end
  })
</script>



