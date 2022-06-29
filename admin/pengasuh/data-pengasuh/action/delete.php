<?php
require_once('../../../../config.php');
require_once('../../../akses.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM `pengajar` WHERE `id` LIKE '$id'";
  $result = mysqli_query($conn, $query);
  
  header("Location: ../pengasuh.php");
} else {
  header("Location: ../pengasuh.php");
}
?>