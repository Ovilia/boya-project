// JavaScript Document
// Basically implements navigation in the homepage.

var current_signal = 0;
var signal_img_names = ["images/key_signal01.png","images/key_signal02.png","images/key_signal03.png"];
var temp,temp2;
var current_img;

window.onload=function() {
	play_signal();
}

function play_signal() {
	current_signal++;
	
	if (current_signal >= 3)
		current_signal = 0;
	document.getElementById("signal_light_src").src = signal_img_names[current_signal];
	temp = setTimeout("play_signal()",500);
}

function img_enlarge(img,width,height) {
	img.style.width = width*1.3 + "px";
	img.style.height = height*1.3 + "px";
}

function img_shrink(img,width,height) {
	img.style.width = width + "px";
	img.style.height = height + "px";
}

function nav_to_world () {
	window.open("demo_page01.html","_self");
}

// handle login
var current_pos = 0;

function move_down_keyboard (evt) {
	var keyboard = document.getElementById("keyboard");
	if (current_pos <= 10) {
		keyboard.innerHTML = "";
	}
	if (current_pos <= 285) {
		// graudally move the picture to right
		current_pos = current_pos + 10;		
		keyboard.style.top = current_pos + "px"; 
		keyboard.style.height = 275-current_pos + "px";
		temp = setTimeout("move_down_keyboard("+evt+")",20);
	} else {
		evt();
	}
}

function destory_keyboard () {
}

function show_login_interface () {
	var txt = "<div id=\"login_interface\">"+
    	"<table class=\"login_table\" frame=\"box\" cellpadding=\"2px\">"+
        "<th>用户登陆</th>"+
        "<tr><td>用户名</td><td><input type=\"text\"></td></tr>"+
        "<tr><td>密码</td><td><input type=\"text\"></td></tr>"+
        "<tr><td></td><td style=\"text-align:right\">记住密码<input type=\"checkbox\"></td></tr>"+
        "<tr><td></td><td style=\"text-align:right\"><input type=\"submit\" value=\"提交\"></td></tr>"+
        "</table></div>";
	var main_content = document.getElementById("mainContent");
	main_content.innerHTML = txt;
	
}

function show_register_interface () {
	var txt = "<iframe src='register.html' frameborder=0 scrolling='NO' width=600 height=450></iframe>";
	document.getElementById("mainContent").innerHTML = txt;
}
