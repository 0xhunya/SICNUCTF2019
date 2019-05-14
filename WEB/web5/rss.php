<?php
//Initial
ini_set("session.cookie_httponly", 1);
require_once "jwt.php";
require_once "checklogin.php";
//Check Login
if (!$login) {
	echo "<script>alert('请先登录!');window.location.href='index.php';</script>";
	exit();
}else{
	//Chekc VIP
	if ($isvip !== 1) {
		echo "<script>alert('请先成为VIP!');window.history.back();</script>";
		exit();
	}
}
//WAF
require_once "waf.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>RSS订阅</title>
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
        	<ul class='nav navbar-nav navbar-right'>
	        	<li><a href='#'><?php if($login){echo $username;}?></a></li>
	        </ul>
	    </div>
	</div>
</nav>

<div class="main" style="padding: 5% 15% 3% 15%;">
	<div class="page-header">
	    <h1 align="center" style="font-size: 250%;">添加RSS订阅</h1>
	</div>
	<div>
	    <form class="bs-example bs-example-form" role="form" action="" method="POST">
	        <div class="row">
	                <div class="input-group">
	                    <input type="text" class="form-control" name="rss" placeholder="http(s)://">
	                    <span class="input-group-btn">
	                        <button class="btn btn-default" type="submit">Go!</button><br>
	                    </span>
	                </div><!-- /input-group -->
	        </div><!-- /.row -->
	    </form>
	</div><br><br>
	<p align="center" style="font-size: 150%;color: red">
		<?php
		if (isset($_POST['rss'])) {

			$rssurl = $_POST['rss'];

			if (checkURL($rssurl)) {

				if ($xml = getXML($rssurl)) {

					echo '添加成功';
				}else{

					echo '添加失败';
				}
			}else{

				echo "Invalid URL";
			}
		}
		?>
	</p>
</div>

</body>
</html>