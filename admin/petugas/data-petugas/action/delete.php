<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM `piket` WHERE `id` LIKE '$id'";
  $result = mysqli_query($conn, $query);

  header("Location: ../petugas.php");
} else {
  header("Location: ../petugas.php");
}
?>