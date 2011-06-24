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
                <div class="userImg">
                    <img src="<?php echo loadImage('hfdusifh'); ?>" height=50px
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">djias</a><br>
					相似度&nbsp;98%<br>
					准确性&nbsp;60%
                </div>
				<div class="userImg">
                    <img src="<?php echo loadImage('dhauodjs'); ?>" height=50px
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">frnja</a><br>
					相似度&nbsp;95%<br>
					准确性&nbsp;30%
                </div>
				<div class="userImg">
                    <img src="<?php echo loadImage('hduaio'); ?>" height=50px
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">djaiu</a><br>
					相似度&nbsp;90%<br>
					准确性&nbsp;10%
                </div>
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
                        <a href="#" class="button small orange">是</a>
                        <a href="#" class="button small orange">否</a>
                        <a href="#" class="button small orange">跳过</a>
                    </div>
                </div>
               <a href="#">fhdsui</a>回答了问题: 你喜欢动物吗？
               <div style="text-align: right">
					<a href="#" class="button small orange">我也回答</a>
               </div>
               <div class="time">
				   2011-4-23 23:22
               </div>
               <hr>
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
