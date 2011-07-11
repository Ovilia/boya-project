<?php

if($_SESSION['isAdmin'] == 'y')
	require_once('adminConnect.php');
else
	require_once('connect.php');

function getUsername($U_ID){	
	$query = sprintf("SELECT user_name FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['user_name'];
	}else{
		return '';
	}
}

function getEmail($U_ID){	
	$query = sprintf("SELECT email FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['email'];
	}else{
		return '';
	}
}

function getUserSpam($U_ID){
	$query = sprintf("SELECT U_spam FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['U_spam'] != 'y' && $row['U_spam'] != 'Y') {
		return false;
	}else{
		return true;
	}
}

function getQuesSpam($Q_ID){
	$query = sprintf("SELECT Q_spam FROM Question WHERE Q_ID = %s LIMIT 1", $Q_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['Q_spam'] != 'y' && $row['Q_spam'] != 'Y') {
		return false;
	}else{
		return true;
	}
}

function getWebsite($U_ID){
	$query = sprintf("SELECT website FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['website'];
	}else{
		return '';
	}
}

function getBirthday($U_ID){	
	$query = sprintf("SELECT birthday FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null && $row['birthday'] != '0000-00-00') {
		return $row['birthday'];
	}else{
		return '';
	}
}

function getGender($U_ID){	
	$query = sprintf("SELECT gender FROM User WHERE U_ID = %s LIMIT 1", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['gender'];
	}else{
		return '';
	}
}

function getFollowerAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Follow WHERE following_ID = %s", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return $query;
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return '';
	}
}

function getFollowingAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Follow WHERE follower_ID = %s", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return $query;
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['amt'];
	}else{
		return '';
	}
}

function getAnsweredAmt($U_ID){
	$query = sprintf("SELECT COUNT(*) as amt FROM Answer WHERE U_ID = %s AND Q_ID IN (SELECT Q_ID FROM Question WHERE Q_spam != 'Y' AND Q_spam != 'y')", $U_ID);
	$result = mysql_query($query);
	if (!$result){
		return $query;
	}
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
	if (!$result){
		return $query;
	}
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
	if (!$result){
		return $query;
	}
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
	if (getUnionQuesAmt($U_ID1, $U_ID2) == 0)
		return 0;
	return getIntersetQuesAmt($U_ID1, $U_ID2) / getUnionQuesAmt($U_ID1, $U_ID2);
}

function getMostSimilar($U_ID, $offset, $size){
	$link = mysqli_connect("localhost", "root", "tecton", "BoYa");
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s", mysqli_connect_error());
		exit();
	}
	$query = sprintf("CALL getMostSimilar(%s, %s, %s)",
				$U_ID, $offset, $size);
	$len = 0;
	$ans = Array();
	if(mysqli_multi_query($link, $query)){
		do{
			if($result = mysqli_store_result($link)){
				while($row = mysqli_fetch_row($result)){
					$ans[$len]['U_ID'] = $row[0];
					$ans[$len]['similar'] = $row[1];
					$len++;
				}
				mysqli_free_result($result);
			}
			if (!mysqli_more_results($link)){
				break;
			}
		}while (mysqli_next_result($link));
	}
	mysqli_close($link);
	return $ans;
}

function isAnswered($U_ID, $Q_ID){
	$query = sprintf("SELECT * FROM Answer WHERE U_ID = %s and Q_ID = %s LIMIT 1",
					 $U_ID, $Q_ID);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return true;
	}else{
		return false;
	}
}

function isFollowed($followerID, $followingID){
	$query = sprintf("SELECT * FROM Follow WHERE follower_ID = %s and following_ID = %s LIMIT 1",
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
	$query = sprintf("INSERT INTO Follow VALUES (%s, %s, default)",
					 $followerID, $followingID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function setUnfollow($followerID, $followingID){
	$query = sprintf("DELETE FROM Follow WHERE follower_ID = %s AND following_ID = %s LIMIT 1",
					 $followerID, $followingID);
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function insertUser($username, $password, $email, $male='', $birthday='', $website='', $VIP='n'){
	$query = sprintf("INSERT INTO User VALUES(default, '%s', '%s', '%s', default, '%b', '%s', '%s', '%s', 'n')",  
				 mysql_real_escape_string($username), 
				 mysql_real_escape_string($password),
				 mysql_real_escape_string($email),
				 mysql_real_escape_string($male),
				 mysql_real_escape_string($birthday),
				 mysql_real_escape_string($website),
				 mysql_real_escape_string($VIP));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function updateUser($U_ID, $username, $email, $male='', $birthday='', $website=''){
	$query = sprintf("UPDATE User SET user_name = '%s', email = '%s', gender = '%s', birthday = '%s', website = '%s'".
					" WHERE U_ID = %d",  
				 mysql_real_escape_string($username), 
				 mysql_real_escape_string($email),
				 mysql_real_escape_string($male),
				 mysql_real_escape_string($birthday),
				 mysql_real_escape_string($website),
				 mysql_real_escape_string($U_ID));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}
}

function insertQuestion($content){
	$query = sprintf("INSERT INTO Question VALUES(default, '%s', 'n')",
				mysql_real_escape_string($content));
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return $query;
	}		
}

function insertAnswer($U_ID, $Q_ID, $answer){
	$query = sprintf("INSERT INTO Answer VALUES(%s, %s, default, '%s')",
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

function getRecentAnswers($U_ID, $offset, $amt){
	$len = 0;
	$ans = Array();
	$query = sprintf("SELECT Q_ID, answer_time FROM Answer WHERE U_ID = %d AND Q_ID IN (SELECT Q_ID FROM Question WHERE Q_spam != 'y' AND Q_spam != 'Y') ".
		"ORDER BY answer_time DESC LIMIT %d, %d",
				mysql_real_escape_string($U_ID),
				mysql_real_escape_string($offset),
				mysql_real_escape_string($amt));
				
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['Q_ID'] != '' && $row['Q_ID'] != null){
			$contentQuery = sprintf("SELECT content FROM Question WHERE Q_ID = %d LIMIT 1",
								mysql_real_escape_string($row['Q_ID']));
			$contentResult = mysql_query($contentQuery);
			$content = mysql_fetch_assoc($contentResult);
			$ans[$len]['Q_ID'] = $row['Q_ID'];
			$ans[$len]['answer_time'] = $row['answer_time'];
			$ans[$len]['content'] = $content['content'];
			$len++;
		}
	}
	return $ans;
}

function getRndQuestion($U_ID, $amt){
	$ans = Array();	
	$len = 0;
	$query = sprintf("SELECT Q_ID, content FROM Question WHERE Q_spam != 'y' AND Q_spam != 'Y' AND Q_ID NOT IN ".
				"(SELECT Q_ID FROM Answer WHERE U_ID = %d) ORDER BY RAND() LIMIT %d", 
				$U_ID, $amt);
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row;
		$len++;
	}
	return $ans;
}

function getRndU_ID(){
	$query = "SELECT U_ID FROM User WHERE U_spam != 'y' ORDER BY RAND() LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row['U_ID'];
}

function getFollowerID($U_ID, $offset, $amt){
	$query = sprintf("SELECT follower_ID FROM Follow WHERE following_ID = %d ORDER BY follow_time DESC LIMIT %d, %d",
					$U_ID, $offset, $amt);
	$result = mysql_query($query);
	$ans = array();
	$len = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row['follower_ID'];
		$len++;
	}
	return $ans;
}

function getUserID($offset, $amt){
	$query = sprintf("SELECT U_ID FROM User LIMIT %d, %d",
					$offset, $amt);
	$result = mysql_query($query);
	$ans = array();
	$len = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row['U_ID'];
		$len++;
	}
	return $ans;
}

function getQ_ID($offset, $amt){
	$query = sprintf("SELECT Q_ID FROM Question LIMIT %d, %d",
					$offset, $amt);
	$result = mysql_query($query);
	$ans = array();
	$len = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row['Q_ID'];
		$len++;
	}
	return $ans;
}

function getQuesContent($Q_ID){
	$query = sprintf("SELECT content FROM Question WHERE Q_ID = %s LIMIT 1", $Q_ID);
	$result = mysql_query($query);
	if (!$result){
		return mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row != null) {
		return $row['content'];
	}else{
		return '';
	}
}

function getUserAmt(){
	$query = "SELECT COUNT(*) AS amt FROM User";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row['amt'];
}

function getQuesAmt(){
	$query = "SELECT COUNT(*) AS amt FROM Question";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row['amt'];
}

function getFollowingID($U_ID, $offset, $amt){
	$query = sprintf("SELECT following_ID FROM Follow WHERE follower_ID = %d ORDER BY follow_time DESC LIMIT %d, %d",
					$U_ID, $offset, $amt);
	$result = mysql_query($query);
	$ans = array();
	$len = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$ans[$len] = $row['following_ID'];
		$len++;
	}
	return $ans;
}

function changePassword($U_ID, $oldPW, $newPW){
	$query = sprintf("UPDATE User SET user_pw = '%s' WHERE U_ID = %d AND user_pw = '%s' LIMIT 1",
					$newPW, $U_ID, $oldPW);
	$result = mysql_query($query);	
	if (mysql_affected_rows() > 0) {
		return true;
	} else {
		return false;
	}	
}

function emailExist($email){
	$query = sprintf("SELECT * FROM User WHERE email = '%s' LIMIT 1", $email);
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row['email']){
		return true;
	}else{
		return false;
	}
}

function resetPassword($email){
	$password = substr(md5(rand(0, 100).$email), 0, 16);
	$query = sprintf("UPDATE User SET user_pw = '%s' WHERE email = '%s' LIMIT 1",
					$password, $email);
	$result = mysql_query($query);	
	if (mysql_affected_rows() > 0) {
		return $password;
	} else {
		return false;
	}	
}

?>
