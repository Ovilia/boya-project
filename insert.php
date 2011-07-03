<?php
require_once('function.php');

function testUser(){
	for ($i = 0; $i < 5; ++$i){
		if (!insertUser('user'.$i, hash('sha512', $i), 
			'user'.$i.'@boya.com', null, null, null))
			$i--;
	}
}

function testQues(){
	for ($i = 0; $i < 5; ++$i){
		insertQuestion($i, 'null', hash('sha512', $i));
	}
}

function testAns(){
	for ($i = 0; $i < 10; ++$i){
		echo insertAnswer($i, $i, 0);
		echo insertAnswer($i, 2*$i+1, 1);
	}
}
testUser();
testQues();

?>
