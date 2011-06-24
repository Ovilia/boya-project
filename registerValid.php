<?php
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$male = $_POST['male'];
$birthday = $_POST['birthday'];
$website = $_POST['website'];
if (substr($website, 0, 5) != "http")
	$website = "http://".$website;

require_once('connect.php');

$query = sprintf("INSERT INTO User VALUES(default, '%s', '%s', '%s', default, '%b', '%s', '%s')",  
				 mysql_real_escape_string($username), 
				 mysql_real_escape_string($password),
				 mysql_real_escape_string($email),
				 mysql_real_escape_string($male),
				 mysql_real_escape_string($birthday),
				 mysql_real_escape_string($website));

//echo $query;

$result = mysql_query($query);
if (mysql_affected_rows() > 0) {
	echo "<script language=\"JavaScript\">alert(\"注册成功!\");window.setTimeout(\"window.location.href=\'index.php\'\", 1000); </script>";
} else {
	echo "<script language=\"JavaScript\">alert(\"注册失败!\");window.setTimeout(\"window.location.href=\'register.php\'\", 1000); </script>";
}
?>
