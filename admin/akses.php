<?php
session_start();

if(!isset($_SESSION['id']) && $_SESSION['role'] != "ADMINISTRATOR"){
	header("location: ../login.php");
}
?>