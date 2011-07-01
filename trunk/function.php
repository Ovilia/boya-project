<?php
require_once('connect.php');

function getUsername($U_ID){	
	$query = sprintf("SELECT user_name FROM User WHERE U_ID = '%s' LIMIT 1", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['user_name'];
	}else{
		return '';
	}
}

function getEmail($U_ID){	
	$query = sprintf("SELECT email FROM User WHERE U_ID = '%s' LIMIT 1", $U_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['email'];
	}else{
		return '';
	}
}

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

function isFollowed($followerID, $followingID){
	$query = sprintf("SELECT * FROM Follow WHERE follower_ID = '%s' and following_ID = '%s' LIMIT 1",
					 $followerID, $followingID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return true;
	}else{
		return false;
	}
}

function setFollow($followerID, $followingID){
	$query = sprintf("INSERT INTO Follow VALUES ('%s', '%s', default, false)",
					 $followerID, $followingID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		echo "<script language=\"JavaScript\">alert(\"Followed Successfully!\");window.history.back(); </script>";
	} else {
		echo "<script language=\"JavaScript\">alert(\"Failed to follow!\");window.history.back(); </script>";
	}
}

function setUnfollow($followerID, $followingID){
	$query = sprintf("DELETE FROM Follow WHERE follower_ID = '%s' AND following_ID = '%s' LIMIT 1",
					 $followerID, $followingID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		echo "<script language=\"JavaScript\">alert(\"Unfollowed Successfully!\");window.history.back(); </script>";
	} else {
		echo "<script language=\"JavaScript\">alert(\"Failed to unfollow!\");window.history.back(); </script>";
	}
}

?>
