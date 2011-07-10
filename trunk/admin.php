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
			
			function spamUser(offset, U_ID){
				$.ajax({
					type: "GET",
					url: "spamUser.php",
					data: ("U_ID=" + U_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to spam User: " + U_ID);
						moreUser(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function unspamUser(offset, U_ID){
				$.ajax({
					type: "GET",
					url: "unspamUser.php",
					data: ("U_ID=" + U_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to unspam User: " + U_ID);
						moreUser(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function searchUser(offset){
				var input = document.getElementById("searchInput").value;
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "searchUser.php",
					data: ("input=" + input + "&offset=" + offset),
					success: function(msg){
						$("#right").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreQues(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreQues.php",
					data: ("offset=" + offset),
					success: function(msg){
						$("#right").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}		
			
			function deleteQues(offset, Q_ID){
				$.ajax({
					type: "GET",
					url: "deleteQues.php",
					data: ("Q_ID=" + Q_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to delete Question: " + Q_ID);
						moreQues(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}	
			
			function spamQues(offset, Q_ID){
				$.ajax({
					type: "GET",
					url: "spamQues.php",
					data: ("Q_ID=" + Q_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to spam Question: " + U_ID);
						moreQues(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function unspamQues(offset, Q_ID){
				$.ajax({
					type: "GET",
					url: "unspamQues.php",
					data: ("Q_ID=" + Q_ID),
					success: function(msg){
						if (msg == 'f')
							alert("Failed to unspam Question: " + U_ID);
						moreQues(offset);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function searchQues(offset){
				var input = document.getElementById("searchInput").value;
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "searchQues.php",
					data: ("input=" + input + "&offset=" + offset),
					success: function(msg){
						$("#right").html(msg);
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
				<h3 style="text-align:center">Admin</h3><hr>
				<a href="javascript:;" onclick="moreUser(0)" class="button gray small">User</a><br>
				<a href="javascript:;" onclick="moreQues(0)" class="button gray small">Question</a><br>
				<a href="/phpMyAdmin" class="button gray small">phpMyAdmin</a>
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
