<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
        <?php
        session_start();
        require_once('isLogin.php');
        require_once('function.php');
        if (!isLogin()) {
            header("location:index.php");
        }
        $U_ID = $_GET['U_ID'];
        if (getEmail($U_ID) == ''){
			header("location:home.php");
		}
        ?>
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>

        <script type="text/javascript">
            var questionList = new Array("你喜欢动物吗？","你喜欢看电影吗？","你喜欢听音乐吗？");
            var curQuestion = 0;
            function loadQuestion(index){     
                $("#questionPanel").text(questionList[index]);
            };            
            
            $(document).ready(function(){
				$(".command").mouseup(function(){
					curQuestion++;
					loadQuestion(curQuestion);
				});
				
				$("#closeSheet").click(function(){
					$("#sheet").slideUp(500);
					$("#question").slideUp(500);
				});
			});
            
        </script>
    </head>
    <body onload="loadQuestion(0);">
        <div id="top">
            <?php
            require_once("loadImage.php");
            session_start();
            $imageUrl = loadImage(getEmail($U_ID));
            ?>
            <img src="images/title.png" height=45px style="float: left; margin-left: 30px; margin-right: 30px;"/>
            <div id="nav">
                <a href="home.php">首页</a> | <a href="profile.php">个人设置</a> | <a href="#">随便看看</a>
                <div id="logout" style="float:right; padding-right: 20px;">
                    <a href="logout.php">登出</a>
                </div>
            </div>
        </div>
        <div id="main">
            <div id="left">
                <div id="leftTop">
                    <img src="<?php echo $imageUrl; ?>" width="70px" height="70px"
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">
                        <?php
                        echo getUsername($U_ID);
                        ?>
                    </a>
                    <hr style="margin:2px">
                    <div id="website">
                        <a href="<?php echo getWebsite($U_ID); ?>" title="访问ta的个人网站">
                            个人主页: <?php echo getWebsite($U_ID); ?>
                        </a>
                    </div>
                </div>
                <div style="text-align: center;">
					关注&nbsp;<a href="#"><?php echo getFollowingAmt($U_ID);?></a>&nbsp;|&nbsp;
					粉丝&nbsp;<a href="#"><?php echo getFollowerAmt($U_ID);?></a>&nbsp;|&nbsp;
					回答&nbsp;<a href="#"><?php echo getAnsweredAmt($U_ID);?></a>&nbsp;
                </div>
                
                <hr>
				<h3>我 & ta</h3>
				相似度: <?php echo number_format(getSimilarity($_SESSION['U_ID'], $U_ID) * 100, 2);?>%<br>
				置信度: <?php echo number_format(getReliability($_SESSION['U_ID'], $U_ID) * 100, 2);?>%
                
                <div id="followPanel">
					<?php
					$isFollowed = isFollowed($_SESSION['U_ID'], $U_ID)
					?>
					<a class="button medium gray"
						<?php
							if ($isFollowed){
								echo ' onmouseover="$(this).text(\'Unfollow\')"'.
									 ' onmouseout="$(this).text(\'Followed\')"'.
									 ' href="follow.php?follow=unfollow&U_ID='.
									 $U_ID.'"';
							} else {
								echo 'href="follow.php?follow=follow&U_ID='.
									 $U_ID.'"';
							}
						?>
					>
						<?php
							if ($isFollowed) echo 'Followed';
							else echo 'Follow';
						?>
					</a>
                </div>
                
                <hr>
                
                <h3>和ta最相似的人</h3>
               <?php
                $mostSimilar = getMostSimilar($U_ID, 0, 3);
                
                for ($i = 0; $i < 2; ++$i){
					if (!isset($mostSimilar[$i]) || $mostSimilar[$i]['similar'] == 0){
						break;
					}
					echo '<div class="userImg"><img src="'.
						 loadImage(getEmail($mostSimilar[$i]['U_ID'])).
						 '" height=50px style="float: left; padding: 0 10px 10px 0; float: left;"/>'.
						 '<a href="user.php?U_ID='.$mostSimilar[$i]['U_ID'].'">'.getUsername($mostSimilar[$i]['U_ID']).'</a><br>'.
						 '相似度:&nbsp;'.number_format($mostSimilar[$i]['similar'] * 100, 2).'%<br>'.
						 '置信度:&nbsp;'.number_format(
								getReliability($U_ID, 
									$mostSimilar[$i]['U_ID']) * 100, 2).'%</div>';
									
				}
                ?>
				
            </div>
            
            
            <div id="right">
				<div id="sheet" style="display:none;">
					<h3 style="float: left;">答题卡</h3>
					<div id="closeSheet" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="question" style="display:none;">
                    <div id="questionPanel"></div>
                    <div id="commandPanel">
                        <a href="#" class="button small orange">是</a>
                        <a href="#" class="button small orange">否</a>
                        <a href="#" class="button small orange">跳过</a>
                    </div>
                </div>
                <?php 
                $recentAnswers = getRecentAnswers($U_ID, 30);
                for ($i = 0; $i < count($recentAnswers); ++$i){
					echo "<a href=\"javascipt:;\">".getUsername($U_ID).
					"</a>回答了问题: ".$recentAnswers[$i]['content'].
					"<div style=\"text-align: right\"></div><div class=\"time\">".
					$recentAnswers[$i]['answer_time']."</div><hr>";
				}?>
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
