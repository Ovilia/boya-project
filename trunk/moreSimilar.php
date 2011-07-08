<?php
require_once("function.php");
require_once("loadImage.php");

$U_ID = $_GET['U_ID'];
$similar = getMostSimilar($U_ID, 0, 40);
for ($i = 0; $i < count($similar); ++$i){
	$email = getEmail($similar[$i]['U_ID']);
	$username = getUsername($similar[$i]['U_ID']);
	$logo = loadImage($email);
	echo "<a href=\"user.php?U_ID=".$similar[$i]['U_ID']."\">".
	"<img src=\"".$logo."\" width=\"70px\" height=\"70px\" ".	
	"title=\"".$username."(相似度: ".
	number_format($similar[$i]['similar'] * 100, 2)."%, 置信度: ".
	number_format(getReliability($similar[$i]['U_ID'], $U_ID) * 100, 2).
	"%)\" /></a>";
	//$similar[$i]['similar']."<br>";
}

?>
