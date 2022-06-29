<?php
require_once('../../../../config.php');
require_once('../../../helper.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  // start of setting datepicker
  $id = $_GET['id'];
  $dateQuery = "SELECT * FROM `filter_presensi` WHERE `id` LIKE '$id'";
  $dateResult = mysqli_query($conn, $dateQuery);
  $dateData = mysqli_fetch_array($dateResult, MYSQLI_ASSOC);
  $tahun = $dateData['tahun'];
  $bulan = $dateData['bulan'];
  
  $bulanInt = monthConverter(strtoupper($bulan)); // convert bulan dari text ke angka
  $startDate = $tahun."-".$bulanInt."-01";
  $lastDate = lastOfMonth($bulanInt, $tahun);
  $today = ifToday($bulanInt, $tahun);
  // end of setting datepicker
  
  // search data with datepicker
  if(isset($_POST['cari'])) {
    $tanggal = $_POST['tanggal'];
    $setDate = defaultDateFormat($tanggal);
    $explodeDate = explode("-",$setDate);
    $filterDate = $explodeDate['2'];
  
    // data santri
    $result = query($conn, $id, $setDate);
  
    header("Location: detail-presensi.php?id=$id&tgl=$filterDate");
  }
  // ambil data setelah search
  elseif(!empty($_GET['tgl'])){
    $setDate = $tahun."-".$bulanInt."-".$_GET['tgl'];
    $tanggal = customDateFormat($setDate);
  
    // data santri
    $result = query($conn, $id, $setDate);
  }
  // jika bulan adalah bulan sekarang (today)
  elseif($today['isToday']) {
    $setDate = date("Y-m-d");
    $tanggal = $today['date'];
  
    $countQuery = "SELECT COUNT(santri_induk) as total FROM `presensi_santri`
                    WHERE filter_id LIKE '$id' && tanggal LIKE '$setDate'";
    $countResult = mysqli_query($conn, $countQuery);
    $countData = mysqli_fetch_array($countResult, MYSQLI_ASSOC);
  
    if($countData['total'] < 1) {
      // insert from santri to presensi
      $insertQuery = "INSERT INTO `presensi_santri`(`santri_induk`,`filter_id`,`keterangan`,`tanggal`)
                      SELECT `induk`,'$id','','$setDate' FROM `santri` ORDER BY induk ASC";
      $insertResult = mysqli_query($conn, $insertQuery);
    }
  
    // data santri
    $result = query($conn, $id, $setDate);
  }
  else {
    $setDate = $startDate;
    $tanggal = customDateFormat($startDate);
  
    $countQuery = "SELECT COUNT(santri_induk) as total FROM `presensi_santri`
                    WHERE filter_id LIKE '$id' && tanggal LIKE '$setDate'";
    $countResult = mysqli_query($conn, $countQuery);
    $countData = mysqli_fetch_array($countResult, MYSQLI_ASSOC);
  
    if($countData['total'] < 1) {
      // insert from santri to presensi
      $insertQuery = "INSERT INTO `presensi_santri`(`santri_induk`,`filter_id`,`keterangan`,`tanggal`)
                      SELECT `induk`,'$id','','$setDate' FROM `santri` ORDER BY induk ASC";
      $insertResult = mysqli_query($conn, $insertQuery);
    }
  
    // data santri
    $result = query($conn, $id, $startDate);
  }
} else {
  header("Location: ../presensi.php");
}

// data santri
function query($connection, $filter, $date) {
  $query = "SELECT santri.induk as induk, santri.nama_lengkap as nama_lengkap, presensi_santri.keterangan as keterangan FROM `presensi_santri`
            LEFT JOIN `santri` ON presensi_santri.santri_induk = santri.induk
            WHERE presensi_santri.filter_id LIKE '$filter' && presensi_santri.tanggal LIKE '$date'";
  return mysqli_query($connection, $query);
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
        <h3>Input Presensi Santri</h3>
        <a href="/tpq-annuur/admin/santri/presensi-santri/presensi.php" class="btn btn-success btn-sm btn-back">
          <span><i class="bi bi-chevron-left"></i></span>
          <span>Kembali</span>
        </a>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">
          
            <form method="post">
              <!-- Tanggal -->
              <div class="form-group row">
                <label for="btn-datepicker" class="col-sm-2 col-form-label">Tanggal Presensi</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" name="tanggal" class="form-control btn btn-input text-start" id="btn-datepicker" value="<?= $tanggal?>" required readonly>
                    <button type="submit" name="cari" class="btn btn-success">
                      <span><i class="bi "></i></span>
                      <span>Tetapkan</span>
                    </button>
                  </div>
                  <small class="form-text text-muted">
                    * Tekan form diatas untuk memilih tanggal
                  </small>
                </div>
              </div>
            </form><hr class="my-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTables-table">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col" width="10%">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $badgeColor = "";
                    $keterangan = "";

                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      echo "<tr class='text-center align-middle'><td>".$data['induk']."</td>";
                      echo "<td>".$data['nama_lengkap']."</td>";
                      $btnHadir = "";
                      $btnTidakHadir = "";

                      if($data['keterangan'] == "HADIR") {
                        $badgeColor = "bg-success text-wrap";
                        $keterangan = "Hadir";
                        $btnHadir = "disabled";
                      } elseif($data['keterangan'] == "TIDAK HADIR") {
                        $badgeColor = "bg-danger text-wrap";
                        $keterangan = "Tidak Hadir";
                        $btnTidakHadir = "disabled";
                      } else {
                        $badgeColor = "bg-warning text-wrap";
                        $keterangan = "Kosong";
                      } ?>

                      <td>
                        <span class="badge <?= $badgeColor?>"><?= $keterangan?></span>
                      </td>
                      <td>
                        <a role="button" href="update-presensi.php?id=<?= $id?>&nis=<?= $data['induk']?>&ket=1&tgl=<?= $setDate?>"
                           class="btn btn-outline-success btn-sm <?= $btnHadir?>" aria-disabled="true">Hadir
                        </a>
                        <a role="button" href="update-presensi.php?id=<?= $id?>&nis=<?= $data['induk']?>&ket=0&tgl=<?= $setDate?>"
                           class="btn btn-outline-danger btn-sm <?= $btnTidakHadir?>" aria-disabled="true">Tidak Hadir
                        </a>
                      </td></tr><?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript -->
    <script type="text/javascript">
      $(document).ready(function(){
        $("#btn-datepicker").datepicker({
          format    : 'DD, dd MM yyyy',
          todayBtn  : "linked",
          language  : "id",
          orientation: "bottom auto",
          todayHighlight: true,
          maxViewMode: 0,
          startDate: new Date('<?= $startDate?>'),
          endDate: new Date('<?= $lastDate?>')
        });
      });
    </script>
  </body>
</html>