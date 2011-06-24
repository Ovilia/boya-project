<?php
require_once('connect.php');

function getWebsite($U_ID){
	$query = sprintf("SELECT website FROM User WHERE U_ID = '%s' LIMIT 1", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['website'];
	}else{
		return '';
	}
}

function getFollowerAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Follow WHERE following_ID = '%s'", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return '';
	}
}

function getFollowingAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Follow WHERE follower_ID = '%s'", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return '';
	}
}

function getAnsweredAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Answer WHERE U_ID = '%s'", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return '';
	}
}
?>
