<?php
require_once('function.php');
require_once('adminFunction.php');

$offset = $_GET['offset'];
$questions = searchQContent($_GET['input'], $offset);

$pages = ceil(getSearchQuesAmt($_GET['input']) / 20);
if ($pages == 0)
	return;

echo "<h2>Question</h2><form id='searchForm'><input id='searchInput' name='searchInput' value='".
	$_GET['input']."'>".
	"<a class='button gray small' href='javascript:;' onclick='searchQues(0)'>Search</a></form><hr>";
for ($i = 0; $i < count($questions); ++$i){
	echo $questions[$i]['content'];
	if($spam){
		echo "<a class='button gray small' href='javascript:;' onclick='unspamQues(".$offset.", ".
			$questions[$i]['Q_ID'].")'>不屏蔽</a>";
	}else{
		echo "<a class='button orange small' href='javascript:;' onclick='spamQues(".$offset.", ".
			$questions[$i]['Q_ID'].")'>屏蔽</a>";
	}
	echo "<a class='button orange small' href='javascript:;' onclick='deleteQues(".$offset.", ".
		$questions[$i]['Q_ID'].")'>删除</a><br>";
}

$curPage = floor($offset / 20);
if ($curPage != 0){
	echo '<a href="javascript:;" onclick="searchQues('.(($curPage - 1) * 20).
	')">Previous</a> ';
}
echo ($curPage + 1)."/".$pages." ";
if ($curPage != $pages - 1){
	echo '<a href="javascript:;" onclick="searchQues('.(($curPage + 1) * 20).
	')">Next</a>';
}

?>
