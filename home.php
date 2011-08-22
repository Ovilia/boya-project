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
        <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/modules/exporting.js"></script>
		<script type="text/javascript" src="js/themes/gray.js"></script>
		
        <script type="text/javascript">
            $(document).ready(function(){
				curQuestion = 0;
				loadQuestion(curQuestion);
				
				$("#closeSheet").click(function(){
					$("#sheet").slideUp(500);
					$("#question").slideUp(500);
				});
				$("#closeHead").click(function(){
					$("#similarBox").slideUp(500);
					$("#similarHead").slideUp(500);
				});
			});
			
            var questionList = new Array();
            <?php
            $questions = getRndQuestion($_SESSION['U_ID'], 10);
            for ($i = 0; $i < count($questions); ++$i){
				echo "questionList[".$i."] = new Array();";
				echo "questionList[".$i."]['Q_ID'] = ".$questions[$i]['Q_ID'].";";
				echo "questionList[".$i."]['content'] = '".$questions[$i]['content']."';";
			}
            ?>
            var curQuestion = 0;
            function loadQuestion(index){     
                $("#questionPanel").text(questionList[index]['content']);
            };
            
            function requestQuestion(){
				$.ajax({
					url: "requestQuestion.php",
					async: true,
					success: function(html){
						content = html.substr(0, html.indexOf("^"));
						Q_ID = html.substr(html.indexOf("^") + 1);
						$("#questionPanel").text(content);
					}
				});
			}
			
			function sendAnswer(Q_ID, answer){
				$.ajax({
					type: "POST",
					url: "sendAnswer.php",
					data: ("Q_ID=" + Q_ID + "&answer=" + answer),
					success: function(msg){
						//alert( "Data Saved: " + msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function answer(ans){
				curQuestion++;
				if (ans == 'y' || ans == 'n'){
					if (curQuestion > questionList.length){
						//alert("send: "+Q_ID+"; ans: "+ans);
						sendAnswer(Q_ID, ans);
					}else{
						//alert("send: "+questionList[curQuestion - 1]['Q_ID']+"; ans: "+ans);
						sendAnswer(questionList[curQuestion - 1]['Q_ID'], ans);
					}
				}
				
				if (curQuestion < questionList.length){
					loadQuestion(curQuestion);
				}else{
					requestQuestion();
				}
			}
			
			function moreSimilar(){
				$.ajax({
					type: "GET",
					url: "moreSimilar.php",
					data: ("U_ID=" + <?php echo $_SESSION['U_ID'];?>),
					success: function(msg){
						$("#similarPanel").html(msg);
						$("#similarHead").slideDown(500);
						$("#similarBox").slideDown(500);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreAnswer(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreAnswer.php",
					data: ("U_ID=" + <?php echo $_SESSION['U_ID'];?> 
							+ "&offset=" + offset + "&isMe=t"),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreFollower(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreFollower.php",
					data: ("U_ID=" + <?php echo $_SESSION['U_ID'];?> 
							+ "&offset=" + offset),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
			
			function moreFollowing(offset){
				$('html, body').animate({scrollTop:0}, 'slow');
				$.ajax({
					type: "GET",
					url: "moreFollowing.php",
					data: ("U_ID=" + <?php echo $_SESSION['U_ID'];?> 
							+ "&offset=" + offset),
					success: function(msg){
						$("#mainContent").html(msg);
					},
					error: function(msg){
						alert("Database Error");
					}
				});
			}
            
            function addQues(){
				var content = prompt("请输入问题","");
				if (content!=null && content!=""){
					$.ajax({
						type: "GET",
						url: "addQues.php",
						data: ("content=" + content),
						success: function(msg){
							if (msg == 't')
								alert("新建问题成功！");
							else
								alert(msg + "新建问题失败！");
						},
						error: function(msg){
							alert("Database Error");
						}
					});
				}
			}
			
			
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chart', 
						defaultSeriesType: 'scatter',
						zoomType: 'xy'
					},
					title: {
						text: '最相似的人'
					},
					xAxis: {
						title: {
							enabled: true,
							text: '相似度(%)'
						},
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true,
						max: 100
					},
					yAxis: {
						title: {
							text: '置信度(%)'
						},
						max: 100
					},
					tooltip: {
						formatter: function() {
				                return '相似度: '+
								this.x +'%, 置信度: '+ this.y +'%';
						}
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						verticalAlign: 'top',
						x: 40,
						y: 40,
						floating: true,
						backgroundColor: '#333',
						borderWidth: 1
					},
					plotOptions: {
						scatter: {
							marker: {
								radius: 7,
								states: {
									hover: {
										enabled: true,
										lineColor: 'rgb(100,100,100)'
									}
								}
							},
							states: {
								hover: {
									marker: {
										enabled: true
									}
								}
							}
						},						
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										location.href = this.options.url;
									}
								}
							}
						}
					},
					<?php
						$similar = getMostSimilar($_SESSION['U_ID'], 0, 50);
						$similarF = array();
						$similarN = array();
						for ($i = 0; $i < count($similar); ++$i){
							if (!isset($similar[$i]) || $similar[$i]['similar'] == 0){
								break;
							}
							if (isFollowed($_SESSION['U_ID'], $similar[$i]['U_ID'])){
								array_push($similarF, $similar[$i]);
							}else{
								array_push($similarN, $similar[$i]);
							}
						}
					?>
					series: [{
						name: 'Following',
						color: 'rgba(255, 170, 0, .8)',
						data: [
						<?php
							for ($i = 0; $i < count($similarF); ++$i){
								if (!isset($similarF[$i]) || $similarF[$i]['similar'] == 0){
									break;
								}
								if ($i != 0){
									echo ', ';
								}
								echo '{x:'.number_format($similarF[$i]['similar'] * 100, 2).
										', y:'.number_format(getReliability($_SESSION['U_ID'], $similarF[$i]['U_ID']) * 100, 2).
										', url: "user.php?U_ID='.$similarF[$i]['U_ID'].'"}';
							}
						?>
						]
					}, {
						name: 'Not following',
						color: 'rgba(201, 256, 92, .5)',
						data: [
						<?php
							for ($i = 0; $i < count($similarN); ++$i){
								if (!isset($similarN[$i]) || $similarN[$i]['similar'] == 0){
									break;
								}
								if ($i != 0){
									echo ', ';
								}
								echo '{x:'.number_format($similarN[$i]['similar'] * 100, 2).
										', y:'.number_format(getReliability($_SESSION['U_ID'], $similarN[$i]['U_ID']) * 100, 2).
										', url: "user.php?U_ID='.$similarN[$i]['U_ID'].'"}';
								}
							?>
						]
					}]
				});
			});
        </script>
    </head>
    <body onload="loadQuestion(0);moreAnswer(0);">
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
					关注&nbsp;<a href="javascript:;" onclick="moreFollowing(0);"><?php echo getFollowingAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					粉丝&nbsp;<a href="javascript:;" onclick="moreFollower(0);"><?php echo getFollowerAmt($_SESSION['U_ID']);?></a>&nbsp;|&nbsp;
					回答&nbsp;<a href="javascript:;" onclick="moreAnswer(0);"><?php echo getAnsweredAmt($_SESSION['U_ID']);?></a>&nbsp;<br>
					
					<?php
					if ($_SESSION['VIP'] == 1){
						echo '<a href="javascript:;" onclick="addQues();" class="button gray small">新增问题</a>';
					}
					?>
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
                <a style="float: right" href="javascript:;" onclick="moreSimilar()">More>></a>
            </div>
            <div id="right">
				<a href="javascript:;" onclick="$('#chart').slideToggle(500);">Chart</a>
                <div id="chart" style="text-shadow: 0 0 1px #666"></div>
                
				<div id="similarHead" style="display:none;" class="rightBoxHead">
					<h3 style="float: left;">最相似的人</h3>
					<div id="closeHead" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="similarBox" class="rightBox" style="display:none;">
                    <div id="similarPanel" class="rightBoxPanel"></div>
                </div>
                
				<div id="sheet" class="rightBoxHead">
					<h3 style="float: left;">答题卡</h3>
					<div id="closeSheet" style="float: right; margin: 5px;">
						<a href="#" style="color: #333; text-shadow: 1px 1px #fff">X</a>
					</div>
				</div>
                <div id="question" class="rightBox">
                    <div id="questionPanel" class="rightBoxPanel"></div>
                    <div id="commandPanel">
                        <a href="javascript:;" class="button small orange" onclick="answer('y')">是</a>
                        <a href="javascript:;" class="button small orange" onclick="answer('n')">否</a>
                        <a href="javascript:;" class="button small orange" onclick="answer('p')">跳过</a>
                    </div>
                </div>
                
                <div id="mainContent">
				</div>
            </div>
        </div>
        <?php
            require_once("footer.php");
        ?>
    </body>
</html>
