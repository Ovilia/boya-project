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

        <script type="text/javascript">
            var browser=navigator.appName;
            if (browser == 'Microsoft Internet Explorer')
            {
                //window.navigate("browser.php");
            }
        </script>

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
                <img src=<?php echo $imageUrl; ?> width="70px" height="70px"
                     style="float: left; padding: 0 10px 10px 0;"/>
                <a href="#">
                    <?php
                    session_start();
                    echo $_SESSION['user_name'];
                    ?>
                </a>
                <hr style="margin:2px">

            </div>
            <div id="right">
                <div id="question">
                    <div id="questionPanel"></div>
                    <div id="commandPanel">
                        <div id="yes" class="command">是</div>
                        <div id="no" class="command">否</div>
                        <div id="next" class="command">不回答</div>
                    </div>
                </div>
                <!--<a href="#" class="button big orange" onclick="loadXMLDoc()">Big Button</a>-->
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
