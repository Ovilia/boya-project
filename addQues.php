<?php
require_once('function.php');
$content = $_GET['content'];

$return = insertQuestion($content);

if ($return){
	echo 't';
}else{
	echo 'f';
}

?>
