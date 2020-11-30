<?php 
if (!$this->session->userdata('username')) {

  redirect('auth');
} else {
  ?>
  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">

    <div class="card">
      <div class="card-header" style="background-color: #E3FDF5">
        <h3 class="text-dark">DASHBOARD</h3>
      </div>
      <div class="card-body">
       <div class="jumbotron" style="background-color: white">
        <h1 class="display-4">Hello, <?php echo $this->session->userdata('username') ?>!</h1>
        <p class="lead">Ini adalah aplikasi Manajemen stok barang.</p>
        <hr class="my-4">
        <p>Untuk Melihat Stok Barang Bisa Menekan Tombol Di Bawah</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="<?php echo base_url('DataBarang') ?>" role="button">Melihat Stok</a>
        </p>
      </div>
    </div>
  </div>

</div>
<!---Container Fluid-->
</div>

<?php } ?>