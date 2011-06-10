// JavaScript Document
dojo.require("dojo.parser");
dojo.require("dijit.form.DateTextBox");
dojo.require("dijit.form.ValidationTextBox");
dojo.require("dijit.form.Button");
dojo.require("dijit.form.CheckBox");
dojo.require("dijit.form.Select");
dojo.addOnLoad("post_data");

function validate_and_submit() {
	var username = dojo.byId("username").value;
	var usernameReg = new RegExp("[a-z0-9]{5,}","i");
	var password = dojo.byId("password").value;
	var password_dup = dojo.byId("password_dup").value;
	//判断必填项
	var email = dojo.byId("email").value;
	var emailReg = new RegExp("[a-z0-9._%=-]+@[a-z0-9-]+\.[a-z]{2,4}","i");
	var birthday = dojo.byId("birthday").value;
	
	if (usernameReg.test(username) == false) {
		alert("无效的用户名");
		return false;
	} else if (password.length < 6) {
		alert("密码至少为六位");
		return false;
	} else if (password != password_dup) {
		alert("两次密码不一致");
		return false;
	}
	//判断email
	
	if (emailReg.test(email) == false) {
		alert("错误的电子邮件格式");
		return false;
	}
	//判断日期
	
	if (birthday.length != 0) {
		var birthdayReg = new RegExp("\\d{4}-\\d{1,2}-\\d{1,2}");
		if (birthdayReg.test(birthday) == false) {
			alert("无效的生日格式");
			return false;
		}
	}
	//CAPTCHA
	var challenge_field = document.getElementsByName('recaptcha_challenge_field')[0].value;
	var response_field = document.getElementsByName('recaptcha_response_field')[0].value;
	var job_field_id = document.getElementsByName('job_field')[0].value;
	var note = document.getElementById('note').value;
	var gender = document.getElementsByName('gender')[0].checked?'0':'1';
	
	//alert(challenge_field);
	var data = "recaptcha_challenge_field="+escape(challenge_field)+
"&recaptcha_response_field="+escape(response_field)+
"&username="+escape(username)+"&password="+escape(password)+"&email="+escape(email)+"&birthday="+escape(birthday)+"&gender="+escape(gender)+"&note="+escape(note)+"&job_field="+escape(job_field_id);
	//alert(data);
	post_data(data);
	//alert("OK");
}

function post_data(obj) {
	dojo.xhrPost({
		url: "valid.php",
		postData: obj,
		handleAs: "json",
		//headers: { "Content-Type": "application/json"},
		load: function(response, ioArgs) {
			console.log("OK!!! " + response + ' ioArgs: ' + ioArgs);
			if (response.captcha == false) {
				document.getElementById('captcha').innerHTML =
"请输入验证码<span id='required_mark'>验证码错误</span>";
			} else {			
				if (response.valid != 'none') {
					alert(valid+' form error');
					return;
				}
				if (response.dup == true) {
					alert('抱歉,用户名已被注册');
				} else {
					alert('注册成功');
					window.location.href="../login.html";
				}
				document.getElementById('captcha').innerHTML =
"请输入验证码";
			}
		},
		error: function(response, ioArgs) {
			console.log("ERROR!!! " + response + ioArgs);
		}
	});
}
