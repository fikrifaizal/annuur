<?php 
$name = explode(" ", $_SESSION["nama"]);
$role = explode(" ", $_SESSION["role"]);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- cdn bootstrap 5 & icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <!-- cdn font style -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" />
    <!-- cdn dataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
    <!-- cdn fontawesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- lib datepicker -->
    <link rel="stylesheet" href="\lib\css\bootstrap-datepicker3.min.css" />
    <!-- css sidebar -->
    <link rel="stylesheet" href="\admin\layout\sidebar.css" />
  </head>
  
  <body>
    <!-- start of top navigation bar -->
    <nav class="navbar navbar-light navbar-expand-lg fixed-top shadow">
      <div class="container-fluid">
        
        <!-- sidebar button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <!-- navbar title -->
        <a class="navbar-brand me-auto ms-lg-0 mx-2 text-uppercase fw-bold navbar-title text-black">SIMTPQ</a>
        <!-- account button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mx-5" id="topNavBar">
          <div class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <span class="topbar-text">Selamat Datang di Sistem Informasi Manajemen TPQ</span>
            </li>
          </div>

          <div class="topbar-divider"></div>

          <div class="d-flex">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle topbar-text" id="userDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline me-2"><?= ucfirst(strtolower($name['0']))?></span>
                  <img class="img-profile rounded-circle" src="\assets\image\user.png">
                </a>

                <!-- Dropdown User Information -->
                <div class="dropdown-menu dropdown-menu-end dropdown-margin-top" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="/tpq-annuur/admin/pengaturan/pengaturan.php">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Pengaturan
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- end of top navigation bar -->

    <!-- start of offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar">
      <div class="offcanvas-body p-0">
        <nav class="navbar-light">
          <ul class="navbar-nav">
            <li>
              <img class="logo" src="\assets\image\logo-annur-bulat.png" />
              <li class="mx-4">
                <div class="navbar-divider"></div>
                <span class="user-info text-light"><?= ucfirst(strtolower($role['0']))?></span>
              </li>
            </li>

            <!-- sidebar item -->
            <li class="mt-3 mx-4">
              <a href="/tpq-annuur/admin/dashboard.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            
            <li class="mx-4">
              <div class="navbar-divider my-3"></div>
              <div class="text-light small fw-bold text-uppercase"><label>Santri</label></div>
              <a href="/tpq-annuur/admin/santri/data-santri/santri.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Data Santri</span>
              </a>
              
              <a href="/tpq-annuur/admin/santri/presensi-santri/presensi.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Presensi Santri</span>
              </a>

              <a class="nav-link btn-sidebar sidebar-link text-light" data-bs-toggle="collapse" href="#penilaian">
                <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                <span>Penilaian Santri</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="penilaian">
                <ul class="navbar-nav mx-4">
                  <li>
                    <a href="/tpq-annuur/admin/santri/penilaian/penilaian.php" class="btn-sidebar nav-link text-light">
                      <span class="me-2"><i class="bi bi-file-earmark-check"></i></span>
                      <span>Penilaian</span>
                    </a>
                  </li>
                  <li>
                    <a href="/tpq-annuur/admin/santri/penilaian/riwayat-nilai.php" class="btn-sidebar nav-link text-light">
                      <span class="me-2"><i class="bi bi-file-earmark-minus"></i></span>
                      <span>Riwayat</span>
                    </a>
                  </li>
                </ul>
              </div>
              
              <a href="/tpq-annuur/admin/santri/spp/spp.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>SPP Santri</span>
              </a>
            </li>
            
            <li class="mx-4">
              <div class="navbar-divider my-3"></div>
              <div class="text-light small fw-bold text-uppercase"><label>Pengasuh</label></div>
              <a href="/tpq-annuur/admin/pengasuh/data-pengasuh/pengasuh.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Data Pengasuh</span>
              </a>

              <a href="/tpq-annuur/admin/pengasuh/presensi-pengasuh/presensi.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Presensi Pengasuh</span>
              </a>
            </li>
            
            <li class="mx-4">
              <div class="navbar-divider my-3"></div>
              <div class="text-light small fw-bold text-uppercase"><label>Petugas Piket</label></div>
              <a href="/tpq-annuur/admin/petugas/data-petugas/petugas.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Data Petugas</span>
              </a>

              <a href="/tpq-annuur/admin/petugas/presensi-petugas/presensi.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Presensi Petugas</span>
              </a>
            </li>
            
            <li class="mx-4 mb-3">
              <div class="navbar-divider my-3"></div>
              <div class="text-light small fw-bold text-uppercase"><label>Keuangan TPQ</label></div>
              <a href="/tpq-annuur/admin/keuangan/keuangan.php" class="btn-sidebar nav-link text-light">
                <span class="me-2"><i class="bi bi-house"></i></span>
                <span>Laporan Keuangan</span>
              </a>
            </li>
            <!-- sidebar item -->
          </ul>
        </nav>
      </div>
    </div>
    <!-- end of offcanvas -->

    <!-- Javascript Support -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- dataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
    
    <!-- datepicker -->
    <script type="text/javascript" src="/tpq-annuur/lib/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/tpq-annuur/lib/locales/bootstrap-datepicker.id.min.js"></script>

    <script>
      $(document).ready(function () {
        $('#dataTables-table').dataTable();
      });
    </script>
  </body>
</html>