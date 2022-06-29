<?php
require_once('../../../config.php');
require_once('../../helper.php');
require_once('../../akses.php');

$id = $_SESSION['id'];
$date = date("Y-m-d");
$month = monthConverter2(date("m"));

if(isset($_GET['induk'])) {
  $induk = $_GET['induk'];
  $getQuery = "SELECT `nama_lengkap`,`infak_bulanan` FROM `santri` WHERE `induk` LIKE '$induk'";
  $getResult = mysqli_query($conn, $getQuery);
  $getData = mysqli_fetch_array($getResult, MYSQLI_ASSOC);

  $query = "INSERT INTO `keuangan_tpq`(`keterangan`,`keluar`,`masuk`,`tanggal`,`user_id`) VALUES
            (concat('SPP ','".$getData['nama_lengkap']."',' [$month]'),
            '0',
            ".$getData['infak_bulanan'].",
            '$date',
            '$id')";
  $result = mysqli_query($conn, $query);

  header("Location: spp.php");
} else {
  header("Location: spp.php");
}
?>