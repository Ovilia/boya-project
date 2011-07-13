<?php
require_once("function.php");

function startInsert($offset, $amt){
	
	echo "insertUser, insertQuestion";
	for ($i = 0; $i < $amt; ++$i){
		if ($i % 1000 == 0)
			echo $i." ";
		
		$index = $offset + $i;
		if ($i % 5 == 0)
			$VIP = 1;
		else
			$VIP = 0;
		
		insertUser("username".$index, "password".$index, "email".$index."@boya.com", "", "", "", $VIP);					
		insertQuestion("你是否喜欢".$index);
	}
	
	//echo "insertAnswer";
	$str = "insert into Answer values ";
	for ($i = 1; $i < 100; ++$i){
		for ($j = 1000; $j < 1100; ++$j){	
			if ($i != 1 || $j != 1000)
				$str .= ", ";
			if (rand(0,2))
				$ans = "'y'";
			else
				$ans = "'n'";
			$str .= "(" . $i . ", " . $j . ", default, " . $ans . ")";
		}
	}
	$str .= ";";
	echo $str;
	
	echo "insertFollow";
	for ($i = 0; $i < $ansAmt; ++$i){	
		echo $i." ";
		for ($j = 0; $j < 200; ++$j){	
			$rnd = rand(0, $amt);
			setFollow($i, $rnd);
		}
	}

}

startInsert(0, 10000);

?>
