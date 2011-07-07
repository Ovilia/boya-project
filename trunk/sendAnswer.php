<?php
session_start();
require_once("function.php");
require_once("isLogin.php");
if (!isLogin())
	return false;

$Q_ID = mysql_real_escape_string($_POST['Q_ID']);
$answer = mysql_real_escape_string($_POST['answer']);

echo insertAnswer($_SESSION['U_ID'], $Q_ID, $answer);
?>
