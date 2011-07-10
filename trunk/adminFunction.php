<?php
require_once("adminConnect.php");

function deleteUser($U_ID){
	$query = sprintf("DELETE FROM User WHERE U_ID = %d LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function spamUser($U_ID){	
	$query = sprintf("UPDATE User SET U_span = 'y' WHERE U_ID = %d LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function unspamUser($U_ID){	
	$query = sprintf("UPDATE User SET U_span = 'n' WHERE U_ID = %d LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function searchU_ID($U_ID){
	$query = sprintf("SELECT U_ID FROM User WHERE U_ID = %d LIMIT 1", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$ans = array();
	$ans[0] = $row['U_ID'];
	if ($row != null) {
		return $ans;
	}else{
		return null;
	}
}

function searchUsername($username, $offset){
	$query = "SELECT U_ID FROM User WHERE user_name LIKE '%".$username."%' LIMIT ".$offset.", 30";
	$ans = array();
	$len = 0;
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row['U_ID'];
		$len++;
	}
	return $ans;
}

function getSearchUserAmt($username){
	$query = "SELECT COUNT(*) FROM User WHERE user_name LIKE '%".$username."%'";
	$result = mysql_query($query);
	if ($row = mysql_fetch_assoc($result)) {
		return $row['COUNT(*)'];
	}
	return 0;
}

?>
