<?php
require_once('../../../config.php');
require_once('../../akses.php');

// tahun sekarang
$tahun = date('Y');

$query = "SELECT * FROM `filter_presensi` WHERE `tahun` LIKE '$tahun'";
$result = mysqli_query($conn, $query);

$filterQuery = "SELECT DISTINCT `tahun` FROM `filter_presensi` ORDER BY `tahun` ASC";
$filterResult = mysqli_query($conn, $filterQuery);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TPQ</title>
    <link rel="shortcut icon" href="\tpq-annuur\assets\image\logo-annur-bulat.png">
    <!-- style css -->
    <link rel="stylesheet" href="\tpq-annuur\admin\layout\style.css" />
  </head>

  <body>
    <!-- sidebar & navbar -->
    <?php
      include('../../layout/sidebar.php');
    ?>

    <!-- konten -->
    <main>
      <div class="container-fluid content transition">
        <h3>Presensi Petugas</h3>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">
            
            <div class="row">
              <div class="col-sm">
                <a href="action/tambah.php" class="btn btn-success">
                  <span><i class="bi bi-plus"></i></span>
                  <span>Tambah Absensi Bulanan</span>
                </a>
              </div>
              <div class="col-sm">
                <button class="btn btn-filter dropdown-toggle" type="button" id="dropdownFilterJilid" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" style="float: right;">
                  Filter Tahun
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownFilterJilid">
                  <li><h6 class="dropdown-header">Pilih Jilid</h6></li>
                  <?php
                    while($data = mysqli_fetch_array($filterResult, MYSQLI_ASSOC)){
                      echo "<li><a class='dropdown-item' href='presensi.php?tahun=".$data['tahun']."'>".$data['tahun']."</a></li>";
                    }
                  ?>
                </ul>
              </div>
            </div><hr class="my-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col" width="5%">#</th>
                    <th scope="col">Bulan</th>
                    <th scope="col">Tahun</th>
                    <th scope="col" width="15%">Kelola</th>
                    <th scope="col" width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    // fetch data menjadi array asosisasi
                    $number = 1;
                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      echo "<tr class='text-center align-middle'><td>".($number++)."</td>";
                      echo "<td>".ucfirst(strtolower($data['bulan']))."</td>";
                      echo "<td>".$data['tahun']."</td>";?>
                      <td>
                        <a role="button" href="detail/detail-presensi.php?id=<?= $data['id']?>" class="btn btn-primary btn-sm">
                          <span><i class="bi bi-pencil"></i><span>
                          <span>Input</span>
                        </a>
                        <button type="button" class="btn btn-success btn-sm">Rekap</button>
                      </td>
                      <td>
                        <a role="button" href="action/edit.php?id=<?= $data['id']?>" class="btn btn-warning btn-sm">
                          <span><i class="bi bi-pencil"></i><span>
                          <span>Ubah</span>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModalDanger<?= $data['id']?>">
                          <span><i class="bi "></i></span>
                          <span>Hapus Data</span>
                        </button>
                      </td></tr>

                      <!-- Delete Modal Danger -->
                      <div class="modal fade" tabindex="-1" id="deleteModalDanger<?= $data['id']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Peringatan!</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <span>Apakah anda yakin untuk menghapus data ini?</span>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                              <a role="button" href="action/delete.php?id=<?= $data['id']?>" class="btn btn-danger">
                                <span><i class="bi bi-pencil"></i><span>
                                <span>Hapus</span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div><?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>