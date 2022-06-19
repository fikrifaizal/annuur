<?php
require_once('../../../config.php');

// connect & query database
$query = "SELECT * FROM `pengajar`";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Pengajar</title>
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
        <h3>Data Pengajar</h3>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">
            <!-- button tambah data -->
            <div>
              <a href="action/tambah-pengasuh.php" class="btn btn-success">
                <span><i class="bi bi-plus"></i></span>
                <span>Tambah Data Pengasuh</span>
              </a>
            </div><hr class="my-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTables-table">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col">Nomor Induk</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col" width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    // fetch data menjadi array asosisasi
                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      echo "<tr class='text-center align-middle'><td>".$data['id']."</td>";
                      echo "<td>".$data['nama']."</td>";
                      echo "<td>".ucfirst(strtolower($data['jenis_kelamin']))."</td>";
                      echo "<td>".$data['no_telp']."</td>";
                      $sertifikat = $data['sertifikat'];?>
                      <!-- button trigger modal detail -->
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $data['id']?>">
                          <span><i class="bi bi-pencil"></i><span>
                          <span>Detail Lengkap</span>
                        </button>
                      </td></tr>
                      
                      <!-- Modal Detail -->
                      <div class="modal fade" id="detailModal<?=$data['id']?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Data Lengkap Pengajar</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <label class="col-sm-5">Nomor Induk</label>
                                <p class="col-sm-7"><?= $data['id']?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Nama Lengkap</label>
                                <p class="col-sm-7"><?= $data['nama']?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Jenis Kelamin</label>
                                <p class="col-sm-7"><?= ucfirst(strtolower($data['jenis_kelamin']))?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Alamat</label>
                                <p class="col-sm-7"><?= $data['alamat']?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Nomor Telepon</label>
                                <p class="col-sm-7"><?= $data['no_telp']?></p>
                              </div>
                              <div class="row">
                                <label class="col-sm-5">Sertifikat</label>
                                <div class="col-sm-7">
                                  <a href="/tpq-annuur/assets/berkas/sertifikat/<?= $sertifikat?>" class="btn btn-outline-secondary btn-sm" target="_blank">Lihat Sertifikat</a>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a role="button" class="btn btn-primary" href="action/ubah-pengasuh.php?id=<?= $data['id']?>">Edit</a>
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