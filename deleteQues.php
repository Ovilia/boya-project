<?php
	require_once('adminFunction.php');
	
	if (deleteQues($_GET['Q_ID']))
		return 't';
	else
		return 'f';
?>
