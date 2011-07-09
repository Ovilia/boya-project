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
        //check if user exists
        if (getEmail($U_ID) == ''){
			header("location:home.php");
		}
        ?>
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>

		<script type="text/javascript">
			questionID = 0;
            $(document).ready(function(){	
				$("#closeSheet").click(function(){
					$("#sheet").slideUp(500);
					$("#question").slideUp(500);
				});
				$("#closeHead").click(function(){
					$("#similarBox").slideUp(500);
					$("#similarHead").slideUp(500);
				});
			});            
			
			function sendAnswer(answer){
				$.ajax({
					type: "POST",
					url: "sendAnswer.php",
					data: ("Q_ID=" + questionID + "&answer=" + answer),
					success: function(msg){
						//alert( "Data Saved: " + msg);
						$("#sheet").slideUp(500);
						$("#question").slideUp(500);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}            
			
			function showQuestion(Q_ID, content){
				$("#sheet").slideDown(500);
				$("#question").slideDown(500);
				questionID = Q_ID;
				$("#questionPanel").text(content);
				$('html, body').animate({scrollTop:0}, 'slow');
			}
			
			function moreSimilar(){
				$.ajax({
					type: "GET",
					url: "moreSimilar.php",
					data: ("U_ID=" + <?php echo $U_ID;?>),
					success: function(msg){
						$("#similarPanel").html(msg);
						$("#similarHead").slideDown(500);
						$("#similarBox").slideDown(500);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreAnswer(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreAnswer.php",
					data: ("U_ID=" + <?php echo $U_ID;?> 
							+ "&offset=" + offset + "&isMe=f"),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreFollower(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreFollower.php",
					data: ("U_ID=" + <?php echo $U_ID;?> 
							+ "&offset=" + offset),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}			
			
			function moreFollowing(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreFollowing.php",
					data: ("U_ID=" + <?php echo $U_ID;?> 
							+ "&offset=" + offset),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
        </script>
    </head>
    <body onload="moreAnswer(0);">
        <div id="top">
            <?php
            require_once("loadImage.php");
            session_start();
            $imageUrl = loadImage(getEmail($U_ID));
            ?>
            <img src="images/title.png" height=45px style="float: left; margin-left: 30px; margin-right: 30px;"/>
            <div id="nav">
                <a href="home.php">首页</a> | <a href="profile.php">个人设置</a> | 
                <a href="user.php?U_ID=<?php echo getRndU_ID();?>">随便看看</a>
                <div id="logout" style="float:right; padding-right: 20px;">
                    <a href="logout.php">登出</a>
                </div>
            </div>
        </div>
        <div id="main">
            <div id="left">
                <div id="leftTop">
					<a href="http://www.gravatar.com" target=_blank
					title="Change your avatar via www.gravatar.com">
						<img src="<?php echo $imageUrl; ?>" width="70px" height="70px"
							 style="float: left; padding: 0 10px 10px 0; float: left;"/>
					 </a>
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
					关注&nbsp;<a href="javascript:;" onclick="moreFollowing(0);"><?php echo getFollowingAmt($U_ID);?></a>&nbsp;|&nbsp;
					粉丝&nbsp;<a href="javascript:;" onclick="moreFollower(0);"><?php echo getFollowerAmt($U_ID);?></a>&nbsp;|&nbsp;
					回答&nbsp;<a href="javascript:;" onclick="moreAnswer(0);"><?php echo getAnsweredAmt($U_ID);?></a>&nbsp;
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
                $mostSimilar = getMostSimilar($U_ID, 0, 2);
                
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
				
                <a style="float: right" href="javascript:;" onclick="moreSimilar()">More>></a>
            </div>
            
            
            <div id="right">
				<div id="similarHead" style="display:none;" class="rightBoxHead">
					<h3 style="float: left;">最相似的人</h3>
					<div id="closeHead" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="similarBox" class="rightBox" style="display:none;">
                    <div id="similarPanel" class="rightBoxPanel"></div>
                </div>
                
				<div id="sheet" style="display:none;" class="rightBoxHead">
					<h3 style="float: left;">答题卡</h3>
					<div id="closeSheet" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="question" class="rightBox" style="display:none;">
                    <div id="questionPanel" class="rightBoxPanel"></div>
                    <div id="commandPanel">
                        <a href="javascript:;" class="button small orange" onclick="sendAnswer('y')">是</a>
                        <a href="javascript:;" class="button small orange" onclick="sendAnswer('n')">否</a>
                    </div>
                </div>
                <div id="mainContent">
				</div>
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
