<?php
	require_once('adminFunction.php');
	
	if (unspamUser($_GET['U_ID']))
		return 't';
	else
		return 'f';
?>
