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
	if (!$result){
		return $query;
	}
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

function getSimilarity($U_ID1, $U_ID2){
	$query = sprintf("SELECT similarity from Similar WHERE (U_ID1 = %s AND U_ID2 = %s) OR (U_ID1 = %s AND U_ID2 = %s) ORDER BY update_time DESC LIMIT 1",
			$U_ID1, $U_ID2, $U_ID2, $U_ID1);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['similarity'];
	}else{
		return 0;
	}
}

function getIntersetQuesAmt($U_ID1, $U_ID2){
	$query = sprintf("SELECT getIntersetQuesAmt(%s, %s) as amt", $U_ID1, $U_ID2);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return 0;
	}
}

function getUnionQuesAmt($U_ID1, $U_ID2){
	$query = sprintf("SELECT getUnionQuesAmt(%s, %s) as amt", $U_ID1, $U_ID2);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return 0;
	}
}

function getReliability($U_ID1, $U_ID2){
	
}

function getMostSimilar($U_ID, $offset, $size){
	$query = sprintf("CALL getMostSimilar(%s, %s, %s)",
				$U_ID, $offset, $size);
	$result = mysql_query($query);
	$ans = array();
	$len = 0;
	while($row = mysql_fetch_assoc($result)){
		$ans[$len] = $row;
		$len++;
	}
	return $ans;
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
		return true;
	} else {
		return false;
	}
}

function setUnfollow($followerID, $followingID){
	$query = sprintf("DELETE FROM Follow WHERE follower_ID = '%s' AND following_ID = '%s' LIMIT 1",
					 $followerID, $followingID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function insertUser($username, $password, $email, $male, $birthday, $website){
	$query = sprintf("INSERT INTO User VALUES(default, '%s', '%s', '%s', default, '%b', '%s', '%s')",  
				 mysql_real_escape_string($username), 
				 mysql_real_escape_string($password),
				 mysql_real_escape_string($email),
				 mysql_real_escape_string($male),
				 mysql_real_escape_string($birthday),
				 mysql_real_escape_string($website));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function insertQuestion($Q_ID, $father_Q_ID, $content){
	$query = sprintf("INSERT INTO Question VALUES(%s, %s, '%s', null)",
				mysql_real_escape_string($Q_ID), 
				mysql_real_escape_string($father_Q_ID),
				mysql_real_escape_string($content));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}		
}

function insertAnswer($U_ID, $Q_ID, $answer){
	$query = sprintf("INSERT INTO Answer VALUES(%s, %s, default, %s)",
				mysql_real_escape_string($U_ID), 
				mysql_real_escape_string($Q_ID),
				mysql_real_escape_string($answer));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}	
}
$s = getMostSimilar(1,0,10);
echo getEmail($s[0]['U_ID']);
?>
