<?php
require_once('../../../config.php');
require_once('../../helper.php');
require_once('../../akses.php');

$setMonth = date("m");
$setYear = date("Y");
$setDate = monthConverter2($setMonth)." ".$setYear;

// connect & query database
$query = "SELECT * FROM `santri`";
$result = mysqli_query($conn, $query);
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
        <h3>SPP Santri</h3>

        <!-- card tabel -->
        <div class="card border shadow">
          <div class="card-body m-3">

          <div>
            <label class="text-secondary">Periode</label>
            <h5><?= $setDate?></h5>
          </div><hr class="my-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTables-table">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col" width="5%">#</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Nama Wali</th>
                    <th scope="col" width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $count = 1;

                    // fetch data menjadi array asosisasi
                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      // cek pembayaran
                      $cekQuery = "SELECT COUNT(id) as id FROM `keuangan_tpq`
                                  WHERE `tanggal` LIKE '%$setMonth%' AND
                                  `keterangan` LIKE '%".$data['nama_lengkap']."%'";
                      $cekResult = mysqli_query($conn, $cekQuery);
                      $cekData = mysqli_fetch_array($cekResult, MYSQLI_ASSOC);

                      echo "<tr class='text-center align-middle'><td class='fw-bold'>".$count++."</td>";
                      echo "<td>".$data['induk']."</td>";
                      echo "<td>".$data['nama_lengkap']."</td>";
                      echo "<td>".$data['nama_ortu']."</td>";
                      
                      if($cekData['id'] > 0) {
                        echo "<td><span class='badge bg-success text-wrap'>Sudah Bayar</span></td>";
                      }
                      else { ?>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $data['induk']?>">
                            <span><i class="bi bi-pencil"></i><span>
                            <span>Pilih</span>
                          </button>
                        </td></tr>
                      
                      <!-- Modal Detail -->
                      <div class="modal fade" id="detailModal<?=$data['induk']?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <label class="col-sm-5">Nomor Induk Santri</label>
                                <p class="col-sm-7"><?=$data['induk']?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Nama Lengkap</label>
                                <p class="col-sm-7"><?=$data['nama_lengkap']?></p>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a role="button" class="btn btn-success" href="action-spp.php?induk=<?=$data['induk']?>">Konfirmasi</a>
                            </div>
                          </div>
                        </div>
                      </div><?php
                      }
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