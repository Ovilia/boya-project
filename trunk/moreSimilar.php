<?php
require_once("function.php");
require_once("loadImage.php");

$U_ID = $_GET['U_ID'];
$similar = getMostSimilar($U_ID, 0, 50);
for ($i = 0; $i < count($similar); ++$i){
	if ($similar[$i]['similar'] == 0){
		break;
	}
	$email = getEmail($similar[$i]['U_ID']);
	$username = getUsername($similar[$i]['U_ID']);
	$logo = loadImage($email);
	echo "<a href=\"user.php?U_ID=".$similar[$i]['U_ID']."\">".
	"<img src=\"".$logo."\" width=\"50px\" height=\"50px\" ".	
	"title=\"".$username."(相似度: ".
	number_format($similar[$i]['similar'] * 100, 2)."%)\" style=\"margin: 3px;\" /></a>";
}

?>
