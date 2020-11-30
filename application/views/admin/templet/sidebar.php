
<div id="wrapper">
  <!-- Sidebar -->
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('Home') ?>">
      <div class="sidebar-brand-icon">
       <img class="around-circle" width="170" src="<?php echo base_url('assets/img/logo.jpg') ?>" alt="">
     </div>
     <!-- <div class="sidebar-brand-text mx-3">POS</div> -->
   </a>
   <li class="nav-item p-2" style="font-size: 15px">
    <center><b>Administrator</b></center>
  </li>
  <hr class="sidebar-divider">
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo base_url('Home') ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('Pengguna') ?>">
        <i class="fas fa-users"></i>
        <span>Pengguna</span></a>
      </li>
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('DataBarang') ?>">
         <i class="fas fa-tasks"></i>
         <span>Data Barang</span></a>
       </li>
       <hr class="sidebar-divider">

       <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('BarangKeluar') ?>">
         <i class="fas fa-tasks"></i>
         <span>Barang Keluar</span></a>
       </li>
       <hr class="sidebar-divider">


      <div class="version" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>



            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?php echo base_url('assets/ruangAdmin/') ?>img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $this->session->userdata('username') ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url('Auth/logout_admin') ?>">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->
