<?php
require_once('function.php');

$email = $_POST['email'];
sendEmail($email);

function sendEmail($email){
	if(emailExist($email)){
		$password = resetPassword($email);
		
		$to = $email;
		$subject = "Reset password from BoYa.com";
		$body = "Your new password is set to be ".$password.". Please login soon and CHANGE THE PASSWORD!";
		if (mail($to, $subject, $body)) {
			echo "<script type='text/javascript'>alert('新密码已发送至".$email."，请尽快查收并修改密码!');";
		} else {
			echo "<script type='text/javascript'>alert('邮件发送失败，请稍候再试...');";
		}
	}else{
		echo "<script type='text/javascript'>alert('该邮箱未注册!');";
	}
	echo "window.location.href='index.php';</script>";
}
?>
