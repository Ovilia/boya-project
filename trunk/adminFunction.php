<?php
require_once("adminConnect.php");

function deleteUser($U_ID){
	$query = sprintf("DELETE FROM User WHERE U_ID = %d LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return 'y';
	} else {
		return $query;
	}
}

?>
