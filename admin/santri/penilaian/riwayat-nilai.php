<?php
require_once('../../../config.php');
require_once('../../helper.php');
require_once('../../akses.php');

$query = "SELECT santri.nama_lengkap as nama_lengkap, penilaian.jenjang_id as jenjang_id,
          penilaian.tanggal as tanggal, penilaian.keterangan FROM `penilaian`
          LEFT JOIN `santri` ON penilaian.santri_induk = santri.induk
          WHERE penilaian.keterangan LIKE '%Lulus%' ORDER BY penilaian.tanggal DESC";
$result = mysqli_query($conn, $query);

// filter
if(!empty($_GET['filter'])) {
  $filter = $_GET['filter'];
  $query = "SELECT santri.nama_lengkap as nama_lengkap, penilaian.jenjang_id as jenjang_id,
            penilaian.tanggal as tanggal, penilaian.keterangan FROM `penilaian`
            LEFT JOIN `santri` ON penilaian.santri_induk = santri.induk
            WHERE penilaian.keterangan LIKE '%Lulus%' AND penilaian.jenjang_id LIKE '$filter'
            ORDER BY penilaian.tanggal DESC";
  $result = mysqli_query($conn, $query);
}

function setJilid($connection, int $id = 0) {
  $queryJilid = "SELECT `jenjang` FROM `jenjang` WHERE `id` LIKE '$id'";
  $resultJilid = mysqli_query($connection, $queryJilid);
  $dataJilid = mysqli_fetch_array($resultJilid, MYSQLI_ASSOC);
  return ucwords(strtolower($dataJilid['jenjang']));
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
      include('../../layout/sidebar.php');
    ?>

    <!-- konten -->
    <main>
      <div class="container-fluid content transition">
        <h3>Riwayat Penilaian Santri</h3>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- filter jilid awal -->
            <div class="btn-group">
              <button class="btn btn-filter dropdown-toggle" type="button" id="dropdownFilterJilid" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                Filter Jilid Awal
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownFilterJilid">
                <li><h6 class="dropdown-header">Pilih Jilid</h6></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=0">Pra TK</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=1">Jilid 1</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=2">Jilid 2</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=3">Jilid 3</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=4">Jilid 4</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=5">Jilid 5</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=6">Jilid 6</a></li>
                <li><a class="dropdown-item" href="riwayat-nilai.php?filter=7">Al Qur'an</a></li>
              </ul>
            </div><hr class="my-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTables-table">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col" width="5%">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jilid Awal</th>
                    <th scope="col">Jilid Akhir</th>
                    <th scope="col">Tanggal Penilaian</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $count = 1;
                    // fetch data menjadi array asosisasi
                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      echo "<tr class='text-center align-middle'><th>".$count++."</th>";
                      echo "<td>".$data['nama_lengkap']."</td>";
                      echo "<td>".setJilid($conn,$data['jenjang_id'])."</td>";
                      echo "<td>".setJilid($conn,$data['jenjang_id']+1)."</td>";
                      echo "<td>".customDateFormat($data['tanggal'])."</td>";
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