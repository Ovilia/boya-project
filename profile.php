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
		<link rel="stylesheet" type="text/css" href="js/dojo/resources/dojo.css">
		<link rel="stylesheet" type="text/css" href="js/dijit/themes/claro/claro.css">
		
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>

		<script type="text/javascript" src="js/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
		<script type="text/javascript">
            dojo.require("dijit.form.CheckBox");
            dojo.require("dijit.form.DateTextBox");
            dojo.require("dijit.form.Form");
            dojo.require("dijit.form.Button");
            dojo.require("dijit.form.ValidationTextBox");
            
            function checkSubmit(){
					if(dijit.byId("username") == null || dijit.byId("username") == ""){
						alert("用户名不能为空");
						return false;
					}
					var email = document.getElementById("email").value;       
                    var username = document.getElementById("username").value;
                    var male = document.getElementById("male").value;
                    var birthday = document.getElementById("birthday").value;
                    var website = document.getElementById("website").value;
                    
                    if (email == '' || username == ''){
                        alert('请填写*部分');
                        return false;
                    }else{
						if (!checkLength(email, "email", 4, 32)||
							!checkLength(username, "username", 4, 16)){
								return false;
						}							
						
						//email
						var email_patt = /^([a-zA-Z0-9_.])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
						if (!email_patt.test(email)){
							alert("Illegal email!");
							return false;
						}
												
						//username
						var name_patt = new RegExp("[^0-9a-zA-Z_]");
						if (name_patt.test(username)){
							alert("Illegal username!");
							return false;
						}
												
						document.forms["profileForm"].submit();
					}
				}		
				
				function checkPW(){					
					if(dijit.byId("password") == null || dijit.byId("newpassword") == "" || dijit.byId("repassword") == ""){
						alert("密码不能为空");
						return false;
					}
					var password = document.getElementById("password").value;       
                    var newpassword = document.getElementById("newpassword").value;
                    var repassword = document.getElementById("repassword").value;
                    if (!checkLength(password, "password", 4, 16)||
						!checkLength(repassword, "retype password", 4, 16)||
						!checkLength(newpassword, "newpassword", 4, 16)){
							return false;
					}
					if (newpassword != repassword){
						alert("This password doesn't match the confirmation password.");
						return false;
					}
					var pw_patt = new RegExp("[^0-9a-zA-Z_]");
					if (pw_patt.test(password)){
						alert("Illegal password!");
						return false;
					}
					
					document.forms["changepwForm"].submit();
				}
				
                function checkLength(obj, msg, min, max){
					if(obj.length < min || obj.length > max){
						alert("Illegal length of " + msg + "!");
						return false;
					}
					return true;
				}
				
        </script>
    </head>
    <body class="claro" style="font-size:15px;">
        <div id="top">
            <?php
            require_once("loadImage.php");
            $imageUrl = loadImage($_SESSION['email']);
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
					关注&nbsp;<a href="javascript:;"><?php echo getFollowingAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					粉丝&nbsp;<a href="javascript:;"><?php echo getFollowerAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					回答&nbsp;<a href="javascript:;"><?php echo getAnsweredAmt($_SESSION['U_ID']);?></a>&nbsp;
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
                <div id="mainContent">					
					<h2>修改个人信息</h2>
					<hr>
					<form id="profileForm" action="updateProfile.php" method="post">
						<table>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="username">用户名:</label>
								</td><td><span class="required_mark">(*)</span>
								</td><td>
									<input type="text" maxlength="16" dojoType="dijit.form.ValidationTextBox" 
									trim=true id="username" name="username" required="true" 
									regExp="[A-Za-z0-9]{4,}" invalidMessage="无效的用户名" 
									promptMessage="用户名至少为4-16个字符的英文字母或是数字"
									value="<?php echo getUsername($_SESSION['U_ID']);?>">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="email">邮箱:</label>
								</td><td><span class="required_mark">(*)</span>
								</td><td>
									<input maxlength="32" dojoType="dijit.form.ValidationTextBox" 
									id="email" name="email" promptMessage="邮箱最大长度32位" 
									invalidMessage="无效的电子邮件格式" required=true 
									regExp="[A-Za-z0-9._%=-]+@[A-Za-z0-9-]+\.[A-Za-z]{2,4}"
									value="<?php echo getEmail($_SESSION['U_ID']);?>">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="age">生日:</label>
								</td><td>
								</td><td>								
									<input type="text"  name="birthday" id="birthday"
										   dojoType="dijit.form.DateTextBox"
										   value="<?php echo getBirthday($_SESSION['U_ID']);?>">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="website">个人网址:</label>
								</td><td>
								</td><td>
									<input type="text" maxlength="50" dojoType="dijit.form.ValidationTextBox" 
									trim=true id="website" name="website" regExp="[A-Za-z0-9_.?#/:]{3,}" 
									invalidMessage="无效的网址" promptMessage="请输入个人网址"
									value="<?php echo getWebsite($_SESSION['U_ID']);?>">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="gender">性别:</label>
								</td><td>
								</td><td>
									<?php $gender = getGender($_SESSION['U_ID']);?>
									<input name="gender" id="male" dojoType="dijit.form.RadioButton" value="M"
									<?php if ($gender == 'm' || $gender == 'M') echo ' checked';?>>男</input>
									<input name="gender" id="female" dojoType="dijit.form.RadioButton"value="F"
									<?php if ($gender == 'f' || $gender == 'F') echo ' checked';?>>女</input>
								</td>
							</tr>
						</table>
						<br>
						<a href="javascript:;" class="button large orange" id="submit" onclick="checkSubmit()">修改</a>
						<a href="home.php" class="button large orange">取消</a>
					</form>
					<br>
					
					<h2>重置密码</h2>
					<hr>
					<form id="changepwForm" name="changepwForm" action="updatePW.php" method="post">
						<table>							
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="password">旧密码:</label>
								</td><td>
								</td><td>
									<input type="password" maxlength="16" dojoType="dijit.form.ValidationTextBox" 
									trim=true id="password" name="password" required="true" 
									regExp="[A-Za-z0-9_]{4,}" invalidMessage="无效的密码" 
									promptMessage="密码至少为4-16个字符的英文字母、数字或下划线">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="newpassword">新密码:</label>
								</td><td>
								</td><td>
									<input type="password" maxlength="16" dojoType="dijit.form.ValidationTextBox" 
									trim=true id="newpassword" name="newpassword" required="true" 
									regExp="[A-Za-z0-9_]{4,}" invalidMessage="无效的密码" 
									promptMessage="密码至少为4-16个字符的英文字母、数字或下划线">
								</td>
							</tr>
							<tr>
								<td style="text-align:right;" width="120px;">
									<label for="repassword">重复密码:</label>
								</td><td>
								</td><td>						
									<input maxlength="16" type="password" dojoType="dijit.form.ValidationTextBox"  
									id="repassword" name="repassword" required=true invalidMessage="两次密码不一致"
									validator="return this.getValue() == dijit.byId('newpassword').getValue()">
								</td>
							</tr>
						</table>
						<br>
						<a href="javascript:;" class="button large orange" id="submit" onclick="checkPW()">修改</a>
						<a href="home.php" class="button large orange">取消</a>
					</form>
				</div>
            </div>
        </div>
		<?php
		require_once("footer.php");
		?>
    </body>
</html>
