<?php
require_once("function.php");
session_start();

$U_ID = $_GET['U_ID'];
$offset = $_GET['offset'];
$isMe = $_GET['isMe'];
$pages = ceil(getAnsweredAmt($U_ID) / 20);
if ($pages == 0)
	return;

$recentAnswers = getRecentAnswers($U_ID, $offset, 20);
for ($i = 0; $i < count($recentAnswers); ++$i){
	if ($recentAnswers[$i]['content'] == '')
		return;
		
	echo "<a href=\"javascipt:;\">".getUsername($U_ID).
	"</a>回答了问题: ".$recentAnswers[$i]['content'].
	"<div style=\"text-align: right\"></div><div class=\"time\">".
	$recentAnswers[$i]['answer_time'];
	
	if ($isMe == 'f'){
		echo "<a href='javascript:;' class='button small ";
		if (isAnswered($_SESSION['U_ID'], $recentAnswers[$i]['Q_ID'])){
			echo "gray' style='color:#333'>我已回答</a>";
		}else{
			echo "orange' onclick='showQuestion(\"".$recentAnswers[$i]['Q_ID'].
			"\", \"".$recentAnswers[$i]['content']."\");".
			" \$(this).removeClass(); \$(this).addClass(\"button gray small\"); ".
			"\$(this).text(\"我已回答\");'>我也回答</a>";
		}
	}
	
	echo "</div><hr>";
}

$curPage = floor($offset / 20);
if ($curPage != 0){
	echo '<a href="javascript:;" onclick="moreAnswer('.(($curPage - 1) * 20).
	')">Previous</a> ';
}
echo ($curPage + 1)."/".$pages." ";
if ($curPage != $pages - 1){
	echo '<a href="javascript:;" onclick="moreAnswer('.(($curPage + 1) * 20).
	')">Next</a>';
}

?>
