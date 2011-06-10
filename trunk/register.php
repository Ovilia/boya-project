<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BoYa</title>
		
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">		
		<link rel="stylesheet" type="text/css" href="js/dojo/resources/dojo.css">
		<link rel="stylesheet" type="text/css" href="js/dijit/themes/claro/claro.css">
		<script type="text/javascript" src="js/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
		<script type="text/javascript">
            dojo.require("dijit.form.CheckBox");
            dojo.require("dijit.form.Form");
            dojo.require("dijit.form.Button");
            dojo.require("dijit.form.ValidationTextBox");
        </script>
    </head>
	
    <body class="claro" style="font-size:15px; font-family: '微软雅黑';">
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
				<form id="registForm">
					<table>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="user_name">用户名:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input type="text" maxlength="16" dojoType="dijit.form.ValidationTextBox" trim=true id="user_name" name="user_name" required="true" regExp="[A-Za-z0-9]{5,}" invalidMessage="无效的用户名" promptMessage="用户名至少为5-16个字符的英文字母或是数字">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="password">密码:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input type="password" maxlength="16" dojoType="dijit.form.ValidationTextBox" trim=true id="password" name="password" required="true" regExp="[A-Za-z0-9_]{5,}" invalidMessage="无效的密码" promptMessage="密码至少为5-16个字符的英文字母、数字或下划线">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="password_dup">重复密码:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>						
								<input maxlength="20" type="password" dojoType="dijit.form.ValidationTextBox"  id="password_dup" name="password_dup" required=true invalidMessage="无效的密码">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="email">邮箱:</label>
							</td><td>
								<span class="required_mark">(*)</span>
							</td><td>
								<input maxlength="32" dojoType="dijit.form.ValidationTextBox" id="email" promptMessage="邮箱最大长度32位" invalidMessage="无效的电子邮件格式" required=true regExp="[A-Za-z0-9._%=-]+@[A-Za-z0-9-]+\.[A-Za-z]{2,4}">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="age">年龄:</label>
							</td><td>
							</td><td>
								<input type="text" maxlength="3" dojoType="dijit.form.ValidationTextBox" trim=true id="age" name="age" regExp="[0-9]{1,3}" invalidMessage="无效的年龄" promptMessage="请输入年龄">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="website">个人网址:</label>
							</td><td>
							</td><td>
								<input type="text" maxlength="50" dojoType="dijit.form.ValidationTextBox" trim=true id="website" name="website" regExp="[A-Za-z0-9_.?#]{3,}" invalidMessage="无效的网址" promptMessage="请输入个人网址">
							</td>
						</tr>
						<tr>
							<td style="text-align:right;" width="120px;">
								<label for="gender">性别:</label>
							</td><td>
							</td><td>
								<input name="gender" id="male" dojoType="dijit.form.RadioButton" value="0">男</input>
								<input name="gender" id="female" dojoType="dijit.form.RadioButton"value="1">女</input>
							</td>
						</tr>
					</table>
					<hr>
					<button type="button" dojoType="dijit.form.Button" onclick="validate_and_submit()">确认</button>
					<button type="reset" dojoType="dijit.form.Button">重置</button>
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
