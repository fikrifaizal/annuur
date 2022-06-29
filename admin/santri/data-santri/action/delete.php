<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM `santri` WHERE `induk` LIKE '$nis'";
  $result = mysqli_query($conn, $query);

  header("Location: ../santri.php");
} else {
  header("Location: ../santri.php");
}
?>