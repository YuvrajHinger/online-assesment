<?php
session_start();
unset($_SESSION['candidate_id']);
unset($_SESSION['candidate_username']);
ob_start();
header("location:login.php");
ob_flush();
?>
