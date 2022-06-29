<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id']) && isset($_GET['induk'])) {
  $id = $_GET['id'];
  $induk = $_GET['induk'];
  $keterangan = $_GET['ket'];
  $tanggal = $_GET['tgl'];
  
  $dateExplode = explode("-",$tanggal);
  $filterDate = $dateExplode[2];
  
  if($keterangan == 1) {
    $queryRalat = "UPDATE `presensi_piket` SET `keterangan`='HADIR' WHERE `piket_id` LIKE '$induk'";
    $resultRalat = mysqli_query($conn, $queryRalat);
  
    header("Location: detail-presensi.php?id=$id&tgl=$filterDate");
  }
  elseif($keterangan == 0) {
    $queryRalat = "UPDATE `presensi_piket` SET `keterangan`='TIDAK HADIR' WHERE `piket_id` LIKE '$induk'";
    $resultRalat = mysqli_query($conn, $queryRalat);
    
    header("Location: detail-presensi.php?id=$id&tgl=$filterDate");
  }
  else {
    header("Location: ../presensi.php");
  }
} else {
  header("Location: ../presensi.php");
}

?>