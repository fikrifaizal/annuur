<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['nis'])) {
  // connect & query database
  $nis = $_GET['nis'];
  $query = "SELECT * FROM `santri` WHERE `induk` LIKE '$nis'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
  
  // get data from database
  $namaLengkap = $data['nama_lengkap'];
  $panggilan = $data['panggilan'];
  $tempatLahir = $data['tempat_lahir'];
  $tglLahir = $data['tgl_lahir'];
  $jenjangSekolah = $data['jenjang_sekolah'];
  $kelas = $data['kelas'];
  $telpSantri = $data['no_telp_santri'];
  $namaWali = $data['nama_ortu'];
  $pekerjaanWali = $data['pekerjaan_ortu'];
  $telpWali = $data['no_telp_ortu'];
  $alamat = $data['alamat_ortu'];
  $infakBulanan = $data['infak_bulanan'];
  
  // form ubah data
  if(isset($_POST['ubah'])) {
    $namaLengkap = $_POST['namaLengkap'];
    $panggilan = ucwords($_POST['panggilan']);
    $tempatLahir = ucwords($_POST['tempat']);
    $tglLahir = $_POST['tanggal'];
    $tglLahir = formatTanggal($tglLahir);
    $jenjangSekolah = $_POST['jenjangSekolah'];
    $kelas = $_POST['kelas'];
    $telpSantri = $_POST['telpSantri'];
    $namaWali = $_POST['namaWali'];
    $pekerjaanWali = $_POST['pekerjaanWali'];
    $telpWali = $_POST['telpWali'];
    $alamat = $_POST['alamat'];
    $infakBulanan = $_POST['infak'];
    
    $query = "UPDATE `santri` SET 
              `nama_lengkap`='$namaLengkap', `panggilan`='$panggilan', `tempat_lahir`='$tempatLahir',
              `tgl_lahir`='$tglLahir', `jenjang_sekolah`='$jenjangSekolah', `kelas`='$kelas',
              `no_telp_santri`='$telpSantri', `nama_ortu`='$namaWali', `pekerjaan_ortu`='$pekerjaanWali',
              `no_telp_ortu`='$telpWali', `alamat_ortu`='$alamat', `infak_bulanan`='$infakBulanan'
              WHERE `induk` LIKE '$nis'";
    $result = mysqli_query($conn, $query);
    
    header("Location: ../santri.php");
  }
} else {
  header("Location: ../santri.php");
}

// function for date formatting
function formatTanggal($date){
  return date('Y-m-d', strtotime($date));
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
        <h3>Update Data Santri</h3>
        <a href="/tpq-annuur/admin/santri/data-santri/santri.php" class="btn btn-success btn-sm btn-back">
          <span><i class="bi bi-chevron-left"></i></span>
          <span>Kembali</span>
        </a>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- form input -->
            <form method="post">

              <!-- NIS -->
              <div class="form-group row">
                <label for="nis" class="col-sm-2 col-form-label">Nomor Induk Santri</label>
                <div class="col-sm-10">
                  <input type="text" name="nis" class="form-control" id="nis" value="<?= $nis?>" readonly>
                </div>
              </div><br>

              <!-- Nama -->
              <div class="form-group row">
                <label for="namaLengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" name="namaLengkap" class="form-control" id="namaLengkap" value="<?= $namaLengkap?>" required>
                </div>
              </div><br>

              <!-- Nama Panggilan -->
              <div class="form-group row">
                <label for="panggilan" class="col-sm-2 col-form-label">Nama Panggilan</label>
                <div class="col-sm-10">
                  <input type="text" name="panggilan" class="form-control" id="panggilan" value="<?= $panggilan?>" required>
                </div>
              </div><br>

              <!-- Tempat, Tanggal Lahir -->
              <div class="form-group row">
                <label for="lahir" class="col-sm-2 col-form-label">Tempat, Tanggal Lahir</label>
                <div class="col-sm-10">
                  <div class="input-group has-validation">
                    <input type="text" name="tempat" class="form-control" id="tempat" value="<?= $tempatLahir?>" required>
                    <span class="input-group-text" id="inputGroupPrepend3">,</span>
                    <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $tglLahir?>" required>
                  </div>
                </div>
              </div><br>

              <!-- Jenjang Sekolah -->
              <div class="form-group row">
                <label for="jenjangSekolah" class="col-sm-2 col-form-label">Jenjang Sekolah</label>
                <div class="col-sm-10">
                  <select class="form-select" name="jenjangSekolah" id="jenjangSekolah" required>
                    <option disabled>Pilih Jenjang Sekolah</option>
                    <option value="PAUD/PRA TK">PAUD/PRA TK</option>
                    <option value="TK/RA">TK/RA</option>
                    <option value="SD/MI">SD/MI</option>
                    <option value="SMP/MTS">SMP/MTS</option>
                    <option value="SMA/MA">SMA/MA</option>
                  </select>
                </div>
              </div><br>

              <!-- Kelas -->
              <div class="form-group row">
                <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                <div class="col-sm-10">
                  <input type="number" name="kelas" class="form-control" id="kelas" value="<?= $kelas?>" required>
                </div>
              </div><br>

              <!-- Telp Santri -->
              <div class="form-group row">
                <label for="telpSantri" class="col-sm-2 col-form-label">Telepon Santri</label>
                <div class="col-sm-10">
                  <input type="number" name="telpSantri" class="form-control" id="telpSantri" value="<?= $telpSantri?>" required>
                </div>
              </div><br>

              <!-- Nama Wali -->
              <div class="form-group row">
                <label for="namaWali" class="col-sm-2 col-form-label">Nama Wali</label>
                <div class="col-sm-10">
                  <input type="text" name="namaWali" class="form-control" id="namaWali" value="<?= $namaWali?>" required>
                </div>
              </div><br>

              <!-- Pekerjaan Wali -->
              <div class="form-group row">
                <label for="pekerjaanWali" class="col-sm-2 col-form-label">Pekerjaan Wali</label>
                <div class="col-sm-10">
                  <input type="text" name="pekerjaanWali" class="form-control" id="pekerjaanWali" value="<?= $pekerjaanWali?>" required>
                </div>
              </div><br>

              <!-- Telp Wali -->
              <div class="form-group row">
                <label for="telpWali" class="col-sm-2 col-form-label">Telepon Wali</label>
                <div class="col-sm-10">
                  <input type="number" name="telpWali" class="form-control" id="telpWali" value="<?= $telpWali?>" required>
                </div>
              </div><br>

              <!-- Alamat -->
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea name="alamat" class="form-control" id="alamat" maxlength="255" rows="2" required><?= $alamat?></textarea>
                </div>
              </div><br>

              <!-- Infak Bulanan -->
              <div class="form-group row">
                <label for="infak" class="col-sm-2 col-form-label">Infak Bulanan</label>
                <div class="col-sm-10">
                  <select class="form-select" name="infak" id="infak" required>
                    <option disabled>Pilih Infak Bulanan</option>
                    <option value="50000">Rp 50.000</option>
                    <option value="70000">Rp 70.000</option>
                  </select>
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
      // jenjang sekolah
      $jenjang = ["PAUD/PRA TK","TK/RA","SD/MI","SMP/MTS","SMA/MA"];
      for($i=0; $i < count($jenjang); $i++) {
        if(array_search($jenjangSekolah, $jenjang) == $i) {
          $i = $i+1;
          echo '<script type="text/javascript">
                document.getElementById("jenjangSekolah").getElementsByTagName("option")['.$i.'].selected = "selected"
              </script>';
          break;
        }
      }

      // infak
      if($infakBulanan == "Rp 50.000") {
        echo '<script type="text/javascript">
                document.getElementById("infak").getElementsByTagName("option")[1].selected = "selected"
              </script>';
      } else {
        echo '<script type="text/javascript">
                document.getElementById("infak").getElementsByTagName("option")[2].selected = "selected"
              </script>';
      }
    ?>
  </body>
</html>