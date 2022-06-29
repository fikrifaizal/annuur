<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM `filter_presensi` WHERE `id` LIKE '$id'";
  $result = mysqli_query($conn, $query);

  header("Location: ../presensi.php");
} else {
  header("Location: ../presensi.php");
}
?>