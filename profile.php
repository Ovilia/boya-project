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
        <script type="text/javascript">
            function loadXMLDoc()
            {
                var xmlhttp;
                //for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest();
                }
                //for IE6, IE5
                else
                {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
				
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("right").innerHTML += xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "../write.php", true);
                xmlhttp.send();
            }
        </script>
    </head>
    <body>
        <div id="top">
            <img src="images/title.png"  height=45px style="float: left; margin-left: 30px; margin-right: 30px;"/>
            <div id="nav">
                <a href="home.php">首页</a> | <a href="profile.php">个人设置</a> | <a href="#">随便看看</a>
                <div id="logout" style="float:right; padding-right: 20px;">
                    <a href="logout.php">登出</a>
                </div>
            </div>
        </div>
        <div id="main">
            <div id="left">
                <img src="images/user.jpeg" width="70px" height="70px"
                     style="float: left; padding: 0 10px 10px 0;"/>
                <a href="#">Ovilia</a>
                <hr style="margin:2px">

            </div>
            <div id="right">
                This is right
                <a href="#" class="button big orange" onclick="loadXMLDoc()">Big Button</a>
            </div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
