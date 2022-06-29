<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

// danger alert
$setAlertCondition = false;
$setAlertText = "";
$setAlertText2 = "";

if(isset($_GET['id'])) {
  // connect & query database
  $id = $_GET['id'];
  $query = "SELECT * FROM `pengajar` WHERE `id` LIKE '$id'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

  // button sertifikat
  $sertifikat = "";
  $sertifText = "Tidak Ada Sertifikat";
  $disabled = "";
  if(!empty($data['sertifikat'])) {
    $sertifikat = $data['sertifikat'];
    $sertifText = "Lihat Sertifikat";
  } else {
    $disabled = "disabled";
  }
  
  // get data from database
  $nama = $data['nama'];
  $gender = $data['jenis_kelamin'];
  $alamat = $data['alamat'];
  $telp = $data['no_telp'];
  $sertifikat = $data['sertifikat'];

  // form ubah data
  if(isset($_POST['ubah'])) {
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['nomortelepon'];

    // send data to db
    $query = "UPDATE `pengajar` SET `nama`='$nama',`jenis_kelamin`='$gender',
              `alamat`='$alamat',`no_telp`='$telp' WHERE `id` LIKE '$id'";
    $result = mysqli_query($conn, $query);
    
    header("Location: ../pengasuh.php");
  }
  // perbarui sertifikat
  elseif(isset($_POST['perbarui'])) {
    $explodeName = explode(" ",$nama);
    $maximumSize	= 2000000; // 2 MB

    // checking size of file
    if($_FILES['sertifikat']['size'] <= $maximumSize) {
      $sertifikat = $explodeName[0]."_".$_FILES['sertifikat']['name'];
      $type = "application/pdf";
      $directory = "C:/xampp/htdocs/tpq-annuur/assets/berkas/sertifikat/";

      // checking type of file
      if($_FILES['sertifikat']['type'] == $type) {
        $upload = move_uploaded_file($_FILES['sertifikat']['tmp_name'],$directory.$sertifikat);
  
        // checking if upload is success
        if($upload) {
          // send data to db
          $query = "UPDATE `pengajar` SET `sertifikat`='$sertifikat' WHERE `id` LIKE '$id'";
          $result = mysqli_query($conn, $query);
          
          header("Location: ubah.php?id=".$data['id']."");
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
  }
} else {
  header("Location: ../pengasuh.php");
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
        <h3>Update Data Pengasuh</h3>
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

              <!-- Sertifikat -->
              <div class="form-group row">
                <label for="sertifikat" class="col-sm-2 col-form-label">Sertifikat</label>
                <div class="col-sm-10">
                  <div class="btn-group" role="group">
                    <a href="/tpq-annuur/assets/berkas/sertifikat/<?= $sertifikat?>" class="btn btn-outline-secondary <?= $disabled?>" target="_blank" aria-disabled="true">
                      <?= $sertifText?>
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#unggahModal">
                      Unggah Sertifikat Baru
                    </button>

                    <!-- Modal Unggah -->
                    <div class="modal fade" id="unggahModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Unggah Sertifikat Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group row">
                              <label for="sertifikat" class="col-sm-3 col-form-label">Sertifikat</label>
                              <div class="col-sm-9">
                                <input class="form-control" name="sertifikat" id="formSertifikat" type="file" accept="application/pdf">
                                <small class="form-text text-muted">
                                  * Tipe File: pdf Ukuran Maksimal: 2MB
                                </small>
                              </div>
                            </div><br>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="perbarui" class="btn btn-success">
                              <span><i class="bi "></i></span>
                              <span>Unggah</span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
            </form>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript -->
    <?php
      // selected data in select form
      if($gender == "LAKI-LAKI") {
        echo '<script type="text/javascript">
                document.getElementById("gender").getElementsByTagName("option")[1].selected = "selected"
              </script>';
      } else {
        echo '<script type="text/javascript">
                document.getElementById("gender").getElementsByTagName("option")[2].selected = "selected"
              </script>';
      }

      // Show Alert
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
    <script>

    </script>
  </body>
</html>