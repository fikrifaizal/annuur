<?php 
require_once('../../../../config.php');
require_once('../../../akses.php');

// danger modal
$setAlertCondition = false;
$setAlertText = "";

// tahun sekarang
$tahun = date('Y');

// form tambah data
if(isset($_POST['tambah'])) {
  $bulan = strtoupper($_POST['bulan']);

  // mencari data yang sama dengan yang diinput
  $queryCount = "SELECT COUNT(`id`) as total FROM `filter_presensi` WHERE `bulan` LIKE '$bulan' AND `tahun` LIKE '$tahun'";
  $resultCount = mysqli_query($conn, $queryCount);
  $dataCount = mysqli_fetch_array($resultCount, MYSQLI_ASSOC);

  // membandingkan kesamaan data
  if($dataCount['total'] >= 1) {
    $setAlertCondition = true;
    $setAlertText = "Presensi bulan dan tahun ini sudah dibuat";
  } else {
    $query = "INSERT INTO `filter_presensi`(`bulan`,`tahun`) VALUES ('$bulan','$tahun')";
    $result = mysqli_query($conn, $query);
    header("Location: ../presensi.php");
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
        <h3>Buat Presensi Bulanan</h3>
        <a href="/tpq-annuur/admin/santri/presensi-santri/presensi.php" class="btn btn-success btn-sm btn-back">
          <span><i class="bi bi-chevron-left"></i></span>
          <span>Kembali</span>
        </a>

        <!-- danger alert -->
        <div class="alert alert-danger alert-dismissible fade show" id="alert">
          <strong><?= $setAlertText;?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- form input -->
            <form method="post">

              <!-- Bulan -->
              <div class="form-group row">
                <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
                <div class="col-sm-10">
                  <select class="form-select" name="bulan" id="bulan" required>
                    <option value="" selected disabled>Pilih Bulan</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                  </select>
                </div>
              </div><br>

              <!-- Tahun -->
              <div class="form-group row">
                <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                <div class="col-sm-10">
                  <input type="text" name="tahun" class="form-control" id="tahun" value="<?= $tahun;?>" disabled>
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
                      <button type="submit" name="tambah" class="btn btn-success btn-block">
                        <span><i class="bi "></i></span>
                        <span>Buat</span>
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