<?php
session_start();
include_once "../php/config.php";
if (!isset($_SESSION['username'])) {
  header("location: ../admin/login");
}
?>