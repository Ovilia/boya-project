<?php
/*check session if is already login*/
require_once('isLogin.php');
if (isLogin())
{
	header("location:home.php");
}

$email = $_POST['email'];
$password = $_POST['password'];
if(!isset($email) || !isset($password) || $email == '' || $password == ''){
	header("location:index.php");
}

require_once('connect.php');
$query = sprintf("SELECT U_ID, user_name FROM User WHERE email = '%s' AND user_pw = '%s' AND U_span != 'y' LIMIT 1",
				 mysql_real_escape_string($email), mysql_real_escape_string($password));
	
echo $query;			 
$result = mysql_query($query);

$row = mysql_fetch_assoc($result);
if ($row != null) {
    session_start();
    $_SESSION['U_ID'] = $row['U_ID'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['email'] = $email;
	header("location:home.php");
}
else {
    echo 'No user matched!<br>Click <a href="index.php">here</a> to return.';
}
?>
