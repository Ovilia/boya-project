<?php
require_once('function.php');
require_once('loadImage.php');

$U_ID = $_GET['U_ID'];
$offset = $_GET['offset'];

$following = getFollowingID($U_ID, $offset, 30);
$pages = ceil(getFollowingAmt($U_ID) / 30);
if ($pages == 0)
	return;

for ($i = 0; $i < count($following); ++$i){
	$imageUrl = loadImage(getEmail($following[$i]));
	$username = getUsername($following[$i]);
	$similarity = getSimilarity($following[$i], $U_ID);
	$reliability = getReliability($following[$i], $U_ID);
	
	echo '<div class="userImg" style="float:left; width: 32%;"><img src="'.
		 $imageUrl.'" height=60px style="float: left; padding: 0 10px 10px 0; float: left;"/>'.
		 '<a href="user.php?U_ID='.$following[$i].'">'.$username.'</a><br>'.
		 '相似度:&nbsp;'.number_format($similarity * 100, 2).'%<br>'.
		 '置信度:&nbsp;'.number_format($reliability * 100, 2).'%</div>';
}

$curPage = floor($offset / 30);
if ($curPage != 0){
	echo '<a href="javascript:;" onclick="moreFollowing('.(($curPage - 1) * 30).
	')">Previous</a> ';
}
echo ($curPage + 1)."/".$pages." ";
if ($curPage != $pages - 1){
	echo '<a href="javascript:;" onclick="moreFollowing('.(($curPage + 1) * 30).
	')">Next</a>';
}

?>
