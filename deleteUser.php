<?php
	require_once('adminFunction.php');
	
	if (deleteUser($_GET['U_ID']))
		return 't';
	else
		return 'f';
?>
