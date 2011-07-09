<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
		
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">		
        
		<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" />
		<link rel="stylesheet" type="text/css" href="js/plugins/buttonCaptcha/jquery.buttonCaptcha.styles.css" />
		
		<link rel="stylesheet" type="text/css" href="js/dojo/resources/dojo.css">
		<link rel="stylesheet" type="text/css" href="js/dijit/themes/claro/claro.css">
		
		<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/plugins/buttonCaptcha/jquery.buttonCaptcha.min.js"></script>
		
		<script type="text/javascript" src="js/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
		<script type="text/javascript">
            dojo.require("dijit.form.CheckBox");
            dojo.require("dijit.form.DateTextBox");
            dojo.require("dijit.form.Form");
            dojo.require("dijit.form.Button");
            dojo.require("dijit.form.ValidationTextBox");
        </script>
        
        <script type="text/javascript">
                $('document').ready(function(){
                    $(function() {
						$("#radio").buttonset();
					});					
					
					$(function() {
						$("#submit").buttonCaptcha({
							codeWord:'boya',
							codeZone:'php'
						});
					});
                });
                
                function checkSubmit(){
					if(dijit.byId("username") == null || dijit.byId("username") == ""){
						alert("用户名不能为空");
						return false;
					}
					var email = document.getElementById("email").value;
                    var password = document.getElementById("password").value;
                    var repassword = document.getElementById("repassword").value;                    
                    var username = document.getElementById("username").value;
                    var male = document.getElementById("male").value;
                    var birthday = document.getElementById("birthday").value;
                    var website = document.getElementById("website").value;
                    
                    if (email == '' || password == '' || repassword == '' ||
						username == ''){
                        alert('请填写*部分');
                        return false;
                    }else{
						if (!checkLength(email, "email", 4, 32)||
							!checkLength(password, "password", 4, 16)||
							!checkLength(repassword, "retype password", 4, 16)||
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
						
						//password
						if (password != repassword){
							alert("This password doesn't match the confirmation password.");
							return false;
						}
						var pw_patt = new RegExp("[^0-9a-zA-Z_]");
						if (pw_patt.test(password)){
							alert("Illegal password!");
							return false;
						}
						
						document.forms["registerForm"].submit();
					}
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
            <a href="index.php"><img src="images/title.png" height=45px style="float: left; margin-left: 30px; margin-right: 30px;"/></a>
            <div id="nav">
            </div>
        </div>
        <div id="main">
            <div id="left">
				<h2 style="margin:0px;">你的知音在哪里？</h2>
				<hr>
				<div style="font-weight:bold;">1.注册<br></div>
				2.登录回答问题<br>
				3.查看全站相似用户<br>
				4.伯牙子期相遇<br>
            </div>
            <div id="right">
				<h2 style="margin:0px;">
					注册 - 伯牙网
				</h2>
				<hr>
				<form id="registerForm" action="registerValid.php" method="post">
					<table>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="username">用户名:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input type="text" maxlength="16" dojoType="dijit.form.ValidationTextBox" 
								trim=true id="username" name="username" required="true" 
								regExp="[A-Za-z0-9]{5,}" invalidMessage="无效的用户名" 
								promptMessage="用户名至少为4-16个字符的英文字母或是数字">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="password">密码:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input type="password" maxlength="16" dojoType="dijit.form.ValidationTextBox" 
								trim=true id="password" name="password" required="true" 
								regExp="[A-Za-z0-9_]{5,}" invalidMessage="无效的密码" 
								promptMessage="密码至少为4-16个字符的英文字母、数字或下划线">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="repassword">重复密码:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>						
								<input maxlength="16" type="password" dojoType="dijit.form.ValidationTextBox"  
								id="repassword" name="repassword" required=true invalidMessage="两次密码不一致"
								validator="return this.getValue() == dijit.byId('password').getValue()">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="email">邮箱:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input maxlength="32" dojoType="dijit.form.ValidationTextBox" id="email" name="email" promptMessage="邮箱最大长度32位" invalidMessage="无效的电子邮件格式" required=true regExp="[A-Za-z0-9._%=-]+@[A-Za-z0-9-]+\.[A-Za-z]{2,4}">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="age">生日:</label>
							</td><td>
							</td><td>								
								<input type="text"  name="birthday" id="birthday"
                                       dojoType="dijit.form.DateTextBox">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="website">个人网址:</label>
							</td><td>
							</td><td>
								<input type="text" maxlength="50" dojoType="dijit.form.ValidationTextBox" trim=true id="website" name="website" regExp="[A-Za-z0-9_.?#/:]{3,}" invalidMessage="无效的网址" promptMessage="请输入个人网址">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="gender">性别:</label>
							</td><td>
							</td><td>
								<input name="gender" id="male" dojoType="dijit.form.RadioButton" value="M">男</input>
								<input name="gender" id="female" dojoType="dijit.form.RadioButton"value="F">女</input>
							</td>
						</tr>
					</table>
					<hr>					
                    <a href="javascript:;" class="button large orange" id="submit" onclick="checkSubmit()">注册</a>
                    <a href="index.php" class="button large orange">返回</a>
				</form>
            </div>				
        </div>
		
		<div id="footer">
			<hr>
			伯牙网 www.boya.vv.cc<br>
			开发人员 张雯莉 zwl.sjtu@gmail.com
		</div>
    </body>
</html>
