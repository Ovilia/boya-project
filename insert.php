<?php
require_once('function.php');

function startInsert($offset, $amt){	
	for ($i = 0; $i < $amt; ++$i){
		$index = $offset + $i;
		
		insertUser('username'.$index, 'password'.$index, 'email'.$index.'@boya.com');					
		insertQuestion('content of question'.$index.'一些中文问题的内容');			
	}
	
	for ($i = 0; $i < $amt; ++$i){	
		for ($j = 0; $j < rand(0, $amt); ++$j){	
			if (rand(0, 1))
				$ans = 'Y';
			else
				$ans = 'N';
			insertAnswer($i + 1, $j + 1, $ans);
			
			setFollow($i + 1, $j + 1);
		}
	}
}

startInsert(0, 100);
?>
