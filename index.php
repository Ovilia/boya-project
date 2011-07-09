<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>BoYa</title>

            <link rel="stylesheet" type="text/css" href="css/common.css">
                <link rel="stylesheet" type="text/css" href="css/buttons.css">
                    <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
                    </head>

                    <body>
                        <div id="top">
                            <img src="images/title.png" style="float: left; margin-left: 30px; margin-right: 30px;"/>
                            <div id="nav">
                            </div>
                        </div>
                        <div id="main">
                            <div id="left" style="text-align:center;">
                                <div id="beginBoYa">开始伯牙之旅</div>
                                <form id="loginForm" style="margin-top: 20px; margin-bottom:20px;" action="login.php" method="POST">
                                    <table style="width:100%;">
                                        <tr>
                                            <td>
                                                <text for="email">邮箱</text>
                                            </td><td>
                                                <input id="email" name="email" size="15"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <text for="password">密码</text>
                                            </td><td>
                                                <input type="password" id="password" name="password" size="15"></password>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align:center; width:100%;">
										<a class="button small gray" href="#" onclick="document.forms['loginForm'].submit()">登录</a>
										<a class="button small gray" href="#" onclick="window.location='register.php'">注册</a>
									<hr>
									<a href="#" style="color:#444;">忘记密码</a> <a href="#" style="color:#444;">后台管理</a>
									</div>
                                </form>
                            </div>
                            <div id="right" style="font-size:20px; text-align: center; color: #333;">
                                <img src="images/back.jpg" />
				高山流水遇知音<br>
				在这里，与你的子期不期而遇<br>
                                        </div>				
                                        </div>

                                        <div id="footer">
                                            <hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
                                                    </div>
                                                    </body>
                                                    </html>
