<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

// danger alert
$setAlertCondition = false;
$setAlertText = "";
$setAlertText2 = "";

// form tambah data
if(isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $gender = $_POST['gender'];
  $alamat = $_POST['alamat'];
  $telp = $_POST['nomortelepon'];

  $explodeName = explode(" ",$nama);
  $maximumSize	= 2097152; // 2 MB

  if(!empty($_FILES['sertifikat']['name'])) {
    // checking size of file
    if($_FILES['sertifikat']['size'] <= $maximumSize) {
      $sertifikat = $explodeName[0]."_".$_FILES['sertifikat']['name'];
      $type = "application/pdf";
      $directory = "C:/xampp/htdocs/tpq-annuur/assets/berkas/sertifikat/";

      // checking type of file
      if($_FILES['sertifikat']['type'] == $type) {
        $upload = move_uploaded_file($_FILES['sertifikat']['tmp_name'], $directory.$sertifikat);
        
        // checking if upload is success
        if($upload) {
          // send data to db
          $query = "INSERT INTO `pengajar`(`nama`,`jenis_kelamin`,`alamat`,`no_telp`,`sertifikat`) VALUES ('$nama','$gender','$alamat','$telp','$sertifikat')";
          $result = mysqli_query($conn, $query);
          
          header("Location: ../pengasuh.php");
        } else {      
          $setAlertCondition = true;
          $setAlertText = "File gagal di upload!";
          $setAlertText2 = "Silahkan coba kembali";
        }
      } else {
        $setAlertCondition = true;
        $setAlertText = "Tipe file salah!";
        $setAlertText2 = "Tipe file yang diperbolehkan adalah pdf";
      }
    } else {
      $setAlertCondition = true;
      $setAlertText = "Ukuran file terlalu besar!";
      $setAlertText2 = "Ukuran maksimal adalah 2 MB";
    }
  } else {
    $query = "INSERT INTO `pengajar`(`nama`,`jenis_kelamin`,`alamat`,`no_telp`,`sertifikat`) VALUES ('$nama','$gender','$alamat','$telp','')";
    $result = mysqli_query($conn, $query);
    
    header("Location: ../pengasuh.php");
  }
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
        <h3>Tambah Data Pengasuh</h3>
        <a href="/tpq-annuur/admin/pengasuh/data-pengasuh/pengasuh.php" class="btn btn-success btn-sm btn-back">
          <span><i class="bi bi-chevron-left"></i></span>
          <span>Kembali</span>
        </a>

        <!-- danger alert -->
        <div class="alert alert-danger alert-dismissible fade show" id="alert">
          <strong><?= $setAlertText?></strong> <?= $setAlertText2?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">
            <form method="post" enctype="multipart/form-data">

              <!-- Nama -->
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" name="nama" class="form-control" id="nama" required>
                </div>
              </div><br>

              <!-- Jenis Kelamin -->
              <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                  <select class="form-select" name="gender" id="gender" required>
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option value="LAKI-LAKI">Laki-laki</option>
                    <option value="PEREMPUAN">Perempuan</option>
                  </select>
                </div>
              </div><br>

              <!-- Alamat -->
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea name="alamat" class="form-control" id="alamat" required></textarea>
                </div>
              </div><br>

              <!-- Nomor Telepon -->
              <div class="form-group row">
                <label for="nomortelepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input type="number" name="nomortelepon" class="form-control" id="nomortelepon" required>
                </div>
              </div><br>

              <!-- Sertifikat -->
              <div class="form-group row">
                <label for="sertifikat" class="col-sm-2 col-form-label">Sertifikat</label>
                <div class="col-sm-10">
                  <input class="form-control" name="sertifikat" id="formSertifikat" type="file" accept="application/pdf">
                  <small class="form-text text-muted">
                    * Tipe File: pdf Ukuran Maksimal: 2MB
                  </small>
                </div>
              </div><br>

              <!-- Button -->
              <div class="form-group row">
                <label for="button" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col col-md-6 d-grid gap-2">
                      <button type="reset" class="btn btn-danger btn-block">
                        <span><i class="bi "></i></span>
                        <span>Reset Data</span>
                      </button>
                    </div>
                    <div class="col col-md-6 d-grid gap-2">
                      <button type="submit" name="tambah" class="btn btn-success btn-block">
                        <span><i class="bi "></i></span>
                        <span>Tambah Data</span>
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

    <!-- Javascript -->
    <!-- Show Alert -->
    <?php
      if($setAlertCondition) {
        echo '<script type="text/javascript">
                $("#alert").show();
              </script>';
      } else {
        echo '<script type="text/javascript">
                $("#alert").hide();
              </script>';
      }
    ?>
  </body>
</html>