<?php
session_start();
$U_ID = $_SESSION['U_ID'];
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];

require_once('function.php');

if(changePassword($U_ID, $password, $newpassword)){
	echo "<script language=\"JavaScript\">alert(\"修改成功!\");";
}else{
	echo "<script language=\"JavaScript\">alert(\"修改失败!\");";
}
echo "window.location.href=\"profile.php\"; </script>";

?>
