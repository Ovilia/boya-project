<?php
/*check session if is already login*/
require_once('isLogin.php');
if (isLogin())
{
	header("location:home.php");
}

$email = $_POST['email'];
$password = $_POST['password'];

require_once('connect.php');
$query = "SELECT U_ID, user_name FROM USER WHERE email = '{$email}' AND user_pw = '{$password}' LIMIT 1";
$result = $db->query($query);
$row = $result->fetch_assoc();
if ($row != null) {
    session_start();
    $_SESSION['U_ID'] = $row['U_ID'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['email'] = $email;
	header("location:home.php");
}
else {
    echo 'No user matched!<br>Click <a href="index.php">here</a> to return';
}
?>