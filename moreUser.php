<?php
require_once('function.php');
require_once('loadImage.php');

$offset = $_GET['offset'];

$user = getUserID($offset, 30);
$pages = ceil(getUserAmt($U_ID) / 30);
if ($pages == 0)
	return;
	
echo '<div><a class="medium orange button" href="javascript:;" onclick="deleteAll()">删除全部</a>'.
	'<a class="medium orange button" href="javascript:;" onclick="deleteAll()">屏蔽全部</a></div><hr>';
for ($i = 0; $i < count($user); ++$i){
	$imageUrl = loadImage(getEmail($user[$i]));
	$username = getUsername($user[$i]);
	$isSpam = getUserSpam($user[$i]);
	
	echo '<div class="userImg" style="float:left; width: 32%;"><img src="'.
		 $imageUrl.'" height=60px style="float: left; padding: 0 10px 10px 0; float: left;"/>'.
		 $username.'<br>'.
		 '<a class="small ';
	if ($isSpam)
		echo 'gray button" href="javascript:;" onclick="unuspamUser(\''.$user[$i].'\')">不屏蔽</a>';
	else
		echo 'orange button" href="javascript:;" onclick="spamUser("'.$user[$i].'")">屏蔽</a>';
	echo '<a class="small orange button" href="javascript:;" onclick="deleteUser('.$offset.', '.$user[$i].')">删除</a></div>';
}

$curPage = floor($offset / 30);
if ($curPage != 0){
	echo '<a href="javascript:;" onclick="moreUser('.(($curPage - 1) * 30).
	')">Previous</a> ';
}
echo ($curPage + 1)."/".$pages." ";
if ($curPage != $pages - 1){
	echo '<a href="javascript:;" onclick="moreUser('.(($curPage + 1) * 30).
	')">Next</a>';
}

?>
