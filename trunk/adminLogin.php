<?php
$username = $_POST['adminName'];
$password = $_POST['adminPassword'];

session_start();
if ($_SESSION['isAdmin'] == 'y'){
	header("admin.php");
}

require_once('adminConnect.php');
$query = sprintf("SELECT * FROM Admin WHERE login_name = '%s' AND admin_pw = '%s' LIMIT 1",
				 mysql_real_escape_string($username), mysql_real_escape_string($password));
	
//echo $query;
$result = mysql_query($query);

$row = mysql_fetch_assoc($result);
if ($row != null) {
    session_start();
    $_SESSION['isAdmin'] = 'y';
	header("location:admin.php");
}
else {
    echo '<script type="text/javascript">alert("No admin matched!"); window.location.href="index.php"</script>';
}
?>

