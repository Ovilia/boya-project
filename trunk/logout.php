<?php
session_start();
unset($_SESSION['U_ID']);
unset($_SESSION['user_name']);
header("location:index.php");
?>