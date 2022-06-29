<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  // connect & query database
  $id = $_GET['id'];
  $query = "SELECT * FROM `piket` WHERE `id` LIKE '$id'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
  
  // get data from database
  $nama = $data['nama'];
  $gender = $data['jenis_kelamin'];
  $alamat = $data['alamat'];
  $telp = $data['no_telp'];
  
  // form ubah data
  if(isset($_POST['ubah'])) {
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['nomortelepon'];
  
    // send data to db
    $query = "UPDATE `piket` SET `nama`='$nama',`jenis_kelamin`='$gender',
              `alamat`='$alamat',`no_telp`='$telp' WHERE `id` LIKE '$id'";
    $result = mysqli_query($conn, $query);
    
    header("Location: ../petugas.php");
  }
} else {
  header("Location: ../petugas.php");
}
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
      include('../../../layout/sidebar.php');
    ?>

    <!-- konten -->
    <main>
      <div class="container-fluid content transition">
        <h3>Update Data Petugas</h3>
        <a href="/tpq-annuur/admin/petugas/data-petugas/petugas.php" class="btn btn-success btn-sm btn-back">
          <span><i class="bi bi-chevron-left"></i></span>
          <span>Kembali</span>
        </a>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- form input -->
            <form method="post" enctype="multipart/form-data">

              <!-- Nomor Induk -->
              <div class="form-group row">
                <label for="induk" class="col-sm-2 col-form-label">Nomor Induk</label>
                <div class="col-sm-10">
                  <input type="text" name="induk" class="form-control" id="induk" value="<?= $id?>" disabled>
                </div>
              </div><br>

              <!-- Nama -->
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" name="nama" class="form-control" id="nama" value="<?= $nama?>" required>
                </div>
              </div><br>

              <!-- Jenis Kelamin -->
              <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                  <select class="form-select" name="gender" id="gender" required>
                    <option value="" disabled>Pilih Jenis Kelamin</option>
                    <option value="LAKI-LAKI">Laki-laki</option>
                    <option value="PEREMPUAN">Perempuan</option>
                  </select>
                </div>
              </div><br>

              <!-- Alamat -->
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea name="alamat" class="form-control" id="alamat" required><?= $alamat?></textarea>
                </div>
              </div><br>

              <!-- Nomor Telepon -->
              <div class="form-group row">
                <label for="nomortelepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input type="number" name="nomortelepon" class="form-control" id="nomortelepon" value="<?= $telp?>" required>
                </div>
              </div><br>

              <!-- Button -->
              <div class="form-group row">
                <label for="button" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col col-md-6 d-grid gap-2">
                    </div>
                    <div class="col col-md-6 d-grid gap-2">
                      <button type="submit" name="ubah" class="btn btn-success btn-block">
                        <span><i class="bi "></i></span>
                        <span>Ubah Data</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Delete Modal Danger -->
              <div class="modal fade" tabindex="-1" id="deleteModalDanger" aria-hidden="true">
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
                      <button type="submit" name="hapus" class="btn btn-danger">
                        <span><i class="bi "></i></span>
                        <span>Hapus</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>