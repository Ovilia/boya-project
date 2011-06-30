<?php
require_once('function.php');
session_start();

if ($_GET['follow'] == 'follow')
	setFollow($_SESSION['U_ID'], $_GET['U_ID']);
elseif($_GET['follow'] == 'unfollow')
	setUnfollow($_SESSION['U_ID'], $_GET['U_ID']);

?>
