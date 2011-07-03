<?php
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$male = $_POST['male'];
$birthday = $_POST['birthday'];
$website = $_POST['website'];
if (substr($website, 0, 5) != "http")
	$website = "http://".$website;

require_once('function.php');

if (insertUser($username, $password, $email, $male, $birthday, $website)){
	echo "<script language=\"JavaScript\">alert(\"注册成功!\");window.setTimeout(\"window.location.href=\'index.php\'\", 1000); </script>";
} else {
	echo "<script language=\"JavaScript\">alert(\"注册失败!\");window.setTimeout(\"window.location.href=\'register.php\'\", 1000); </script>";
}
?>
