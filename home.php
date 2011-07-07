<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
        <?php
        require_once('PhpConsole.php');
		PhpConsole::start(true, true, dirname(__FILE__));
		
        session_start();
        require_once('isLogin.php');
        require_once('function.php');
        if (!isLogin()) {
            header("location:index.php");
        }
        ?>
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
				curQuestion = 0;
				loadQuestion(curQuestion);
				
				$("#closeSheet").click(function(){
					$("#sheet").slideUp(500);
					$("#question").slideUp(500);
				});
			});
			
            var questionList = new Array();
            <?php
            $questions = getRndQuestion($_SESSION['U_ID'], 10);
            for ($i = 0; $i < count($questions); ++$i){
				echo "questionList[".$i."] = new Array();";
				echo "questionList[".$i."]['Q_ID'] = ".$questions[$i]['Q_ID'].";";
				echo "questionList[".$i."]['content'] = '".$questions[$i]['content']."';";
			}
            ?>
            var curQuestion = 0;
            function loadQuestion(index){     
                $("#questionPanel").text(questionList[index]['content']);
            };
            
            function requestQuestion(){
				$.ajax({
					url: "requestQuestion.php",
					async: true,
					success: function(html){
						content = html.substr(0, html.indexOf("^"));
						Q_ID = html.substr(html.indexOf("^") + 1);
						$("#questionPanel").text(content);
					}
				});
			}
			
			function sendAnswer(Q_ID, answer){
				$.ajax({
					type: "POST",
					url: "sendAnswer.php",
					data: ("Q_ID=" + Q_ID + "&answer=" + answer),
					success: function(msg){
						//alert( "Data Saved: " + msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function answer(ans){
				curQuestion++;
				if (ans == 'y' || ans == 'n'){
					if (curQuestion > questionList.length){
						//alert("send: "+Q_ID+"; ans: "+ans);
						sendAnswer(Q_ID, ans);
					}else{
						//alert("send: "+questionList[curQuestion - 1]['Q_ID']+"; ans: "+ans);
						sendAnswer(questionList[curQuestion - 1]['Q_ID'], ans);
					}
				}
				
				if (curQuestion < questionList.length){
					loadQuestion(curQuestion);
				}else{
					requestQuestion();
				}
			}
            
        </script>
    </head>
    <body onload="loadQuestion(0);">
        <div id="top">
            <?php
            require_once("loadImage.php");
            $imageUrl = loadImage($_SESSION['email']);
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
                        echo $_SESSION['user_name'];
                        ?>
                    </a>
                    <hr style="margin:2px">
                    <div id="website">
                        <a href="<?php echo getWebsite($_SESSION['U_ID']); ?>" title="访问ta的个人网站">
                            个人主页: <?php echo getWebsite($_SESSION['U_ID']); ?>
                        </a>
                    </div>
                </div>
                <div style="text-align: center;">
					关注&nbsp;<a href="#"><?php echo getFollowingAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					粉丝&nbsp;<a href="#"><?php echo getFollowerAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					回答&nbsp;<a href="#"><?php echo getAnsweredAmt($_SESSION['U_ID']);?></a>&nbsp;
                </div>
                <hr>
                <h3>最相似的人</h3>
                
                <?php
                $mostSimilar = getMostSimilar($_SESSION['U_ID'], 0, 3);
                
                for ($i = 0; $i < 3; ++$i){
					if (!isset($mostSimilar[$i]) || $mostSimilar[$i]['similar'] == 0){
						break;
					}
					echo '<div class="userImg"><img src="'.
						 loadImage(getEmail($mostSimilar[$i]['U_ID'])).
						 '" height=50px style="float: left; padding: 0 10px 10px 0; float: left;"/>'.
						 '<a href="user.php?U_ID='.$mostSimilar[$i]['U_ID'].'">'.getUsername($mostSimilar[$i]['U_ID']).'</a><br>'.
						 '相似度:&nbsp;'.number_format($mostSimilar[$i]['similar'] * 100, 2).'%<br>'.
						 '置信度:&nbsp;'.number_format(
								getReliability($_SESSION['U_ID'], 
									$mostSimilar[$i]['U_ID']) * 100, 2).'%</div>';
									
				}
                ?>
            </div>
            <div id="right">
				<div id="sheet">
					<h3 style="float: left;">答题卡</h3>
					<div id="closeSheet" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="question">
                    <div id="questionPanel"></div>
                    <div id="commandPanel">
                        <a href="javascript:;" class="button small orange" onclick="answer('y')">是</a>
                        <a href="javascript:;" class="button small orange" onclick="answer('n')">否</a>
                        <a href="javascript:;" class="button small orange" onclick="answer('p')">跳过</a>
                    </div>
                </div>
                <?php 
                $recentAnswers = getRecentAnswers($_SESSION['U_ID'], 30);
                for ($i = 0; $i < count($recentAnswers); ++$i){
					echo "<a href=\"javascipt:;\">".$_SESSION['user_name'].
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
