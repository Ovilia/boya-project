<?php
require_once('function.php');
session_start();

if ($_GET['follow'] == 'follow'){
	if (setFollow($_SESSION['U_ID'], $_GET['U_ID']))
		echo "<script language=\"JavaScript\">alert(\"Followed Successfully!\");window.history.back(); </script>";
	else
		echo "<script language=\"JavaScript\">alert(\"Failed to follow!\");window.history.back(); </script>";	
}elseif($_GET['follow'] == 'unfollow'){
	if (setUnfollow($_SESSION['U_ID'], $_GET['U_ID']))
		echo "<script language=\"JavaScript\">alert(\"Unfollowed Successfully!\");window.history.back(); </script>";
	else
		echo "<script language=\"JavaScript\">alert(\"Failed to unfollow!\");window.history.back(); </script>";
}
?>
