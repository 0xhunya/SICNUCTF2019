<?php
//Initial
ini_set("session.cookie_httponly", 1);
require_once "jwt.php";
require_once "checklogin.php";
date_default_timezone_set('PRC');
//Login
if(isset($_POST['login_submit'])){
	if(empty($_POST['login_user'])||empty($_POST['login_pwd'])){
		echo "<script>alert('请将信息填写完整!')</script>";
	}else{
		$get_user = @$_POST['login_user'];
		$get_pwd = @$_POST['login_pwd'];

		$con = new mysqli('localhost','root','root','bbs');
		if ($con->connect_error) {
		    die("Connection Error: " . $con->connect_error);
		}
		if($stmt = $con->prepare("SELECT * FROM users WHERE username=? AND pwd=?")){
			$stmt->bind_param("ss", $get_user,$get_pwd);
			if($stmt->execute()){
				$stmt->store_result(); //取回结果
				if(($stmt->num_rows())==1){ //登陆成功跳转
					$token = getJWT($get_user);
					setcookie("token",$token,time()+3600);
					header("Refresh:0;url=index.php");
					exit();
				}else{
					echo "<script>alert('用户名或密码错误!')</script>";
				}
			}else{
					echo "<script>alert('ERROR!')</script>";
			}
			$stmt->close();
		}
		$con->close();
	}
}
//Register
if(isset($_POST['reg_submit'])){
	if(empty($_POST['reg_user'])||empty($_POST['reg_pwd'])){
		echo "<script>alert('请将信息填写完整!');window.history.back();</script>";
	}else{
		$get_user = @$_POST['reg_user'];
		$get_pwd = @$_POST['reg_pwd'];

		$con = new mysqli('localhost','root','root','bbs');
	    if ($con->connect_error) {
	        die("Connection Error: " . $con->connect_error);
	    }
	    $check_register = $con->prepare("SELECT * FROM users WHERE username=(?)");
	    $check_register->bind_param("s", $get_user);
	    $register = $con->prepare("INSERT INTO users(`username`,`pwd`) VALUES(?,?)");
	    $register->bind_param("ss", $get_user,$get_pwd);
	    // 执行
	    if($check_register->execute()){
	    	$check_register->store_result();
	    	if(($check_register->num_rows())==1){
	    		echo "<script>alert('用户名已存在!')</script>";
	    	}else{
	    		if($register->execute()){
			      echo "<script>alert('注册成功!')</script>";
			    }else{
			      echo "<script>alert('注册失败!')</script>";
			    }
	    	}
	    }
	    $check_register->close();
	    $register->close();
	    $con->close();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>首页</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
	    <div class="navbar-header">
	        <a class="navbar-brand" href="index.php">首页</a>
	    </div>
	    <div>
	        <ul class="nav navbar-nav">
	            <li><a href="msg.php">论坛</a></li>
	            <li><a href="rss.php">RSS订阅</a></li>
	            <li><a href="logout.php">注销</a></li>
	        </ul>
	        <?php
	        if($login){
	        	echo "
	        	<ul class='nav navbar-nav navbar-right'>
		        	<li><a href='#'>".$username."</a></li>
		        </ul>
	        	";
	        }else{
	        	echo "
	        	<nav class='main-nav'>
			        <ul class='nav navbar-nav navbar-right'>
			        	<li><a class='cd-signin' href='#0'>登录/注册</a></li>
			        </ul>
		    	</nav>
	        	";
	        }
	        ?>
	    </div>
	</div>
</nav>

<div class="main" style="padding: 5% 15% 3% 15%;">
	<div class="page-header">
	    <h1 align="center" style="font-size: 250%;">龙湖论坛v1.0</h1>
	</div>
	<p align="center" style="font-size: 150%;">Welcom to LongHu BBS</p>
	<p align="center" style="font-size: 150%;">Let's talk</p>
</div>

<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
	<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
		<ul class="cd-switcher">
			<li><a href="#0">登录</a></li>
			<li><a href="#0">注册</a></li>
		</ul>

		<div id="cd-login"> <!-- log in form -->
			<form id="login_form" class="cd-form" action="" method="POST">
				<p class="fieldset">
					<label class="image-replace cd-username" for="signup-username">用户名</label>
					<input name="login_user" class="full-width has-padding has-border" id="signup-username" type="text" placeholder="用户名">
					<span class="cd-error-message">错误!</span>
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signin-password">密码</label>
					<input name="login_pwd" class="full-width has-padding has-border" id="signin-password" type="password"  placeholder="密码">
					<span class="cd-error-message">错误!</span>
				</p>

				<p class="fieldset">
					<input name="login_submit" class="full-width" type="submit" value="登录">
				</p>
			</form>
			
			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div> <!-- cd-login -->

		<div id="cd-signup"> <!-- sign up form -->
			<form id="reg_form" class="cd-form" action="" method="POST">
				<p class="fieldset">
					<label class="image-replace cd-username" for="signup-username">用户名</label>
					<input name="reg_user" class="full-width has-padding has-border" id="signup-username" type="text" placeholder="用户名">
					<span class="cd-error-message">错误!</span>
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signup-password">密码</label>
					<input name="reg_pwd" class="full-width has-padding has-border" id="signup-password" type="password"  placeholder="密码">
					<span class="cd-error-message">错误!</span>
				</p>

				<p class="fieldset">
					<input name="reg_submit" class="full-width has-padding" type="submit" value="注册">
				</p>
			</form>

			<!-- <a href="#0" class="cd-close-form">Close</a> -->
		</div> <!-- cd-signup -->
		<a href="#0" class="cd-close-form">关闭</a>
	</div> <!-- cd-user-modal-container -->
</div> <!-- cd-user-modal -->
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/main.js"></script> <!-- Gem jQuery -->
</body>
</html>