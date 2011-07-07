<?php
session_start();
require_once("function.php");
require_once("isLogin.php");
if (!isLogin())
	return false;
$question = getRndQuestion($_SESSION['U_ID'], 1);
echo $question[0]['content'].'^'.$question[0]['Q_ID'];
?>
