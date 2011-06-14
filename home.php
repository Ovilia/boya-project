<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
        <?php
        require_once('isLogin.php');
        if (!isLogin()) {
            header("location:index.php");
        }
        ?>
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>

        <script type="text/javascript">
            var questionList = new Array("你喜欢动物吗？","你喜欢看电影吗？","你喜欢听音乐吗？");
            var curQuestion = 0;
            function loadQuestion(index){     
                $("#questionPanel").text(questionList[index]);
            };
            $(".command").mouseup(function(){
                curQuestion++;
                loadQuestion(curQuestion);
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
                        session_start();
                        echo $_SESSION['user_name'];
                        ?>
                    </a>
                    <hr style="margin:2px">
                    <div id="website">
                        <a href="http://blog.sina.com.cn/plainjane001" title="访问ta的个人网站">
                            http://blog.sina.com.cn/plainjane001
                        </a>
                    </div>
                </div>
                关注&nbsp;<a href="#">12</a>&nbsp;|&nbsp;
                粉丝&nbsp;<a href="#">32</a>&nbsp;|&nbsp;
                回答&nbsp;<a href="#">41</a>&nbsp;
                <hr>
                <h3>最相似的人</h3>
                <div class="userImg">
                    <img src="<?php echo loadImage('hfdusifh'); ?>"
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">djias</a><br>
					相似度&nbsp;98%<br>
					准确性&nbsp;60%
                </div>
				<div class="userImg">
                    <img src="<?php echo loadImage('dhauodjs'); ?>"
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">frnja</a><br>
					相似度&nbsp;95%<br>
					准确性&nbsp;30%
                </div>
				<div class="userImg">
                    <img src="<?php echo loadImage('hduaio'); ?>"
                         style="float: left; padding: 0 10px 10px 0; float: left;"/>
                    <a href="#">djaiu</a><br>
					相似度&nbsp;90%<br>
					准确性&nbsp;10%
                </div>
            </div>
            <div id="right">
                <div id="question">
                    <div id="questionPanel"></div>
                    <div id="commandPanel">
                        <a href="#" class="button small orange">是</a>
                        <a href="#" class="button small orange">否</a>
                        <a href="#" class="button small orange">跳过</a>
                    </div>
                </div>
               这里有些<a href="#">文字</a>
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
