<?php
	require_once('adminFunction.php');
	
	if (spamQues($_GET['Q_ID']))
		return 't';
	else
		return 'f';
?>
