<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
        <?php
        require_once('PhpConsole.php');
		PhpConsole::start(true, true, dirname(__FILE__));
		
        session_start();
        require_once('function.php');
        if (!(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 'y')){
            header("location:index.php");
        }
        ?>
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
        <script type="text/javascript">
			function moreUser(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreUser.php",
					data: ("offset=" + offset),
					success: function(msg){
						$("#right").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function deleteUser(offset, U_ID){
				$.ajax({
					type: "GET",
					url: "deleteUser.php",
					data: ("U_ID=" + U_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to delete User: " + U_ID);
						moreUser(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
        </script>

    </head>
    <body onload="">
        <div id="top">
            <img src="images/title.png" height=45px style="float: left; margin-left: 30px; margin-right: 30px;"/>
            <div id="nav">
                <div id="logout" style="float:right; padding-right: 20px;">
                    <a href="logout.php">登出</a>
                </div>
            </div>
        </div>
        <div id="main">
            <div id="left">
				<a href="javascript:;" onclick="moreUser(0)">User</a><br>
				<a href="/phpMyAdmin">phpMyAdmin</a>
            </div>
            <div id="right">
			</div>
        </div>
        <div id="footer">
            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
        </div>
    </body>
</html>
