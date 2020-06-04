<?php
session_start();
unset($_SESSION['examiner_id']);
unset($_SESSION['examiner_username']);
ob_start();
header("location:login.php");
ob_flush();
?>
