<?php
session_start();
$U_ID = $_SESSION['U_ID'];
$email = $_POST['email'];
$username = $_POST['username'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$website = $_POST['website'];
if (substr($website, 0, 4) != "http"){
	$website = "http://".$website;
}

require_once('function.php');

if(updateUser($U_ID, $username, $email, $gender, $birthday, $website)){
	$_SESSION['user_name'] = $username;
	$_SESSION['email'] = $email;
	echo "<script language=\"JavaScript\">alert(\"修改成功!\");";
}else{
	echo "<script language=\"JavaScript\">alert(\"修改失败!\");";
}
echo "window.location.href=\"profile.php\"; </script>";

?>
