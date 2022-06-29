<?php
require_once('../../config.php');
require_once('../helper.php');
require_once('../akses.php');

// variabel for filter
$startDate = "";
$endDate = "";
$file = $kategori = "semua";

// set filter
if(isset($_POST['filter'])) {
  if(!empty($_POST['start']) && !empty($_POST['end'])) {
    $startDate = defaultDateFormat($_POST['start']);
    $endDate = defaultDateFormat($_POST['end']);
    $kategori = $_POST['kategori'];
  
    header("Location: ?start=$startDate&end=$endDate&kategori=$kategori");
  } else {
    $kategori = $_POST['kategori'];
  
    header("Location: ?kategori=$kategori");
  }
}
// hapus filter
elseif(isset($_POST['hapus'])) {
  header("Location: keuangan.php");
}
// set data on filter form
elseif((!empty($_GET['start']) && !empty($_GET['end'])) || !empty($_GET['kategori'])){
  if(!empty($_GET['start']) && !empty($_GET['end'])) {
    $getStartDate = $_GET['start'];
    $getEndDate = $_GET['end'];

    $startDate = customDateFormat($getStartDate);
    $endDate = customDateFormat($getEndDate);
  }

  $file = $kategori = $_GET['kategori'];
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TPQ</title>
    <link rel="shortcut icon" href="\tpq-annuur\assets\image\logo-annur-bulat.png">
    <!-- style css -->
    <link rel="stylesheet" href="\tpq-annuur\admin\layout\style.css" />
    <style>
    </style>
  </head>

  <body>
    <!-- sidebar & navbar -->
    <?php
      include('../layout/sidebar.php');
    ?>

    <!-- konten -->
    <main>
      <div class="container-fluid content transition">
        <h3>Keuangan TPQ</h3>

        <!-- start of first card -->
        <div class="card border shadow mb-4">
          <div class="card-header text-secondary">
            <span><i class="bi bi-search me-2"></i></span>
            <span>Filter Keuangan</span>
          </div>

          <div class="card-body m-3">
            <form method="post">
              <div class="row">

                <!-- tanggal -->
                <div class="col-sm-6">
                  <p for="datepicker" class="form-label fw-bold">Tanggal</p>
                  <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control btn btn-input" name="start" placeholder="Awal" value="<?= $startDate?>" readonly>
                    <span class="input-group-text">ke</span>
                    <input type="text" class="form-control btn btn-input" name="end" placeholder="Akhir" value="<?= $endDate?>" readonly>
                  </div>
                </div>

                <!-- kategori -->
                <div class="col-sm-3">
                  <p for="kategori" class="form-label fw-bold">Kategori</p>
                  <select class="form-select" name="kategori" id="kategori">
                    <option selected value="semua">Semua Kategori</option>
                    <option value="masuk">Kas Masuk</option>
                    <option value="keluar">Kas Keluar</option>
                  </select>
                </div>

                <!-- button -->
                <div class="col-sm-3 d-grid">
                  <p for="btn-group" class="form-label fw-bold">&nbsp</p>
                  <div class="btn-group" role="group" aria-label="Button group">
                    <button type="submit" name="hapus" class="btn btn-danger btn-block">
                      <span><i class="bi bi-check"></i></span>
                      <span>Hapus</span>
                    </button>
                    <button type="submit" name="filter" class="btn btn-info btn-block">
                      <span><i class="bi bi-check"></i></span>
                      <span>Tampilkan</span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- end of first card -->

        <!-- start of second card -->
        <div class="card border shadow">
          <div class="card-body m-3">
            <div class="row">
              <div class="col-sm">
                <h5>Laporan Keuangan</h5>
              </div>
              <div class="col-sm">
                <!-- button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKeuangan" style="float: right;">
                  <span><i class="bi bi-plus"></i></span>
                  <span>Tambah</span>
                </button>

                <!-- Modal -->
                <form method="post" action="action/tambah.php">
                  <div class="modal fade" id="tambahKeuangan" tabindex="-1" aria-labelledby="tambahKeuangan" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <!-- Keterangan -->
                          <div class="form-group row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                              <textarea name="keterangan" class="form-control" id="keterangan" maxlength="255" rows="2" required></textarea>
                            </div>
                          </div><br>

                          <!-- Kategori -->
                          <div class="form-group row">
                            <label for="newkategori" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                              <select class="form-select" name="newkategori" id="newkategori">
                                <option selected disabled></option>
                                <option value="masuk">Kas Masuk</option>
                                <option value="keluar">Kas Keluar</option>
                              </select>
                            </div>
                          </div><br>

                          <!-- Jumlah -->
                          <div class="form-group row">
                            <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                            <div class="col-sm-9">
                              <input type="number" name="jumlah" class="form-control" id="jumlah" required>
                            </div>
                          </div><br>

                          <!-- Tanggal -->
                          <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-9">
                              <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                            </div>
                          </div><br>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" name="tambah" class="btn btn-success btn-block">
                            <span><i class="bi "></i></span>
                            <span>Simpan</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div><hr class="my-3">

            <!-- data on table -->
            <?php include('kas/'.$file.'.php');?>
          </div>
        </div>
        <!-- start of second card -->

      </div>
    </main>
    
    <!-- Javascript -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('.input-daterange').datepicker({
          format    : 'DD, dd MM yyyy',
          todayBtn  : "linked",
          language  : "id",
          orientation: "bottom auto",
          todayHighlight: true,
          maxViewMode: 2
        });
      });
    </script>
    <?php
      // selected data in select form
      $arrayform = ["semua","masuk","keluar"];
      for($i=0; $i < count($arrayform); $i++) {
        if(array_search($kategori, $arrayform) == $i) {
          echo '<script type="text/javascript">
                document.getElementById("kategori").getElementsByTagName("option")['.$i.'].selected = "selected"
              </script>';
          break;
        }
      }
    ?>
  </body>
</html>