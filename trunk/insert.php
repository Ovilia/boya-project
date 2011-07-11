<?php
require_once('function.php');

function startInsert($offset, $amt){
	$amt2 = $amt * $amt;
	
	echo 'insertUser, insertQuestion';
	for ($i = 0; $i < $amt; ++$i){
		if ($i % 1000 == 0)
			echo $i.' ';
		
		$index = $offset + $i;
		if ($i % 5 == 0)
			$VIP = 'y';
		else
			$VIP = 'n';
		
		insertUser('username'.$index, 'password'.$index, 'email'.$index.'@boya.com', $VIP);					
		insertQuestion('你是否喜欢'.$index);
	}
	
	echo 'insertAnswer';
	for ($i = 0; $i < $amt; ++$i){	
		echo $i.' ';
		$rnd = rand(0, 1);
		if ($rnd % 2)
			$ans = 'Y';
		else
			$ans = 'N';
		for ($j = 0; $j < $amt; ++$j){	
			if ($j % $i < 4)
				insertAnswer($i, $j, $ans);	
		}
	}
	
	echo 'insertFollow';
	for ($i = 0; $i < $amt; ++$i){
		echo $i.' ';
		$rnd = rand(0, 2);
		for ($j = 0; $j < $amt; ++$j){	
			if ($j % $i == 0)
				setFollow($i, $j);	
		}
	}

}

startInsert(0, 100);

?>
