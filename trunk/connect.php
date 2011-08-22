<?php
	$db = mysql_connect("127.0.0.1:3306:/var/lib/mysql/mysql.sock", "root", "tecton");
	if (!$db){
		    die('Connect Error: '. mysql_error());
	} else {
		mysql_select_db('BoYa');
	}
?>
