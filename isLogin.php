<?php
function isLogin()
{
	if (isset($_SESSION['user_name']) and isset($_SESSION['U_ID'])
		and $_SESSION['user_name'] != null and $_SESSION['U_ID'] != null)
		return true;
	else
		return false;
}
?>
