<?php
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$website = $_POST['website'];
if (substr($website, 0, 4) != "http")
	$website = "http://".$website;

require_once('function.php');

if (insertUser($username, $password, $email, $gender, $birthday, $website)){
	echo "<script language=\"JavaScript\">alert(\"ע��ɹ�!\");window.location.href=\"index.php\"; </script>";
} else {
	echo "<script language=\"JavaScript\">alert(\"ע��ʧ��!\");window.location.href=\"register.php\"; </script>";
}
?>
