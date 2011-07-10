<?php
	require_once('adminFunction.php');
	
	if (spamUser($_GET['U_ID']))
		return 't';
	else
		return 'f';
?>
