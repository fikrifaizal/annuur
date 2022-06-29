<?php
include_once('../../../config.php');
require_once('../../akses.php');

$query = "SELECT santri.induk as induk, santri.nama_lengkap as nama_lengkap, jenjang.jenjang as jenjang, penilaian.jenjang_id as jenjang_id FROM `penilaian`
          LEFT JOIN `santri` ON penilaian.santri_induk = santri.induk
          LEFT JOIN `jenjang` ON penilaian.jenjang_id = jenjang.id
          WHERE penilaian.id IN (SELECT MAX(id) FROM `penilaian` GROUP BY santri_induk) ORDER BY santri.nama_lengkap ASC";
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
        <h3>Penilaian Santri</h3>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTables-table">
                <thead class="table-secondary">
                  <tr class="text-center align-middle">
                    <th scope="col" width="5%">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jenjang Awal</th>
                    <th scope="col" width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $count = 1;
                    // fetch data menjadi array asosisasi
                    while($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      echo "<tr class='text-center align-middle'><th>".$count++."</th>";
                      echo "<td>".$data['nama_lengkap']."</td>";
                      echo "<td>".ucwords(strtolower($data['jenjang']))."</td>";?>
                      <td>
                        <a type="button" class="btn btn-success btn-sm" href="detail-penilaian.php?nis=<?= $data['induk']?>&jilid=<?= $data['jenjang_id']?>">Nilai</a>
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
  </body>
</html>