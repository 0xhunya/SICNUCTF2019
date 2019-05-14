<?php
// Initial
ini_set("session.cookie_httponly", 1);
require_once "jwt.php";
require_once "checklogin.php";
date_default_timezone_set('PRC');
//Check Login
if(!$login){
	echo "<script>alert('请先登录!');window.location.href='index.php';</script>";
	exit();
}
// CSP
header("Content-Security-Policy: default-src 'self' cdn.staticfile.org;script-src 'self' cdn.staticfile.org;style-src 'self' 'unsafe-inline' cdn.staticfile.org;");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>论坛</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

<div class="main" style="padding: 0% 15% 3% 15%;">
	<form role="form" id="msg" method="POST">
		<div class="form-group">
			<div class="page-header"><h1>龙湖论坛</h1></div>
			<textarea class="form-control" rows="3" name="msg"></textarea>
		</div>
		<div id="myButtons1" class="bs-example">
		   	<button value="submit" type="submit" class="btn btn-primary" style="float: right;">提交</button>
		</div>
	</form>
	<?php
	// Submit Msg
	if(isset($_POST['msg'])){
		if(!empty($_POST['msg'])){
			$msg = @$_POST['msg'];
			$time = date('Y-m-d G:i:s', time());
			$con = new mysqli('localhost','root','root','bbs');
		    if($con->connect_error){
		        die("Connection Error: " . $con->connect_error);
		    }

			$stmt1 = $con->prepare("INSERT INTO message(`username`,`msg`,`time`) VALUES(?,?,?)");
			$stmt1->bind_param("sss", $username, $msg, $time);

			$stmt1->execute();
		    $stmt1->close();
		    $con->close();
		}
	}
	?>
	<div class="page-header">
	    <h1>留言楼</h1>
	</div>

	<?php
	// Show Msg
	$con = mysqli_connect("localhost","root","root","bbs");
	if(!$con){
		die("Connection Error: " . mysqli_connect_error());
	}
	$sql = "SELECT `username`,`msg`,`time` FROM message";
	if($res = mysqli_query($con,$sql)){
		if(mysqli_num_rows($res)>0){
			while($row = mysqli_fetch_assoc($res)) 
			{
				$name = htmlspecialchars($row['username'],ENT_QUOTES);
				$text = htmlspecialchars($row['msg'],ENT_QUOTES);
				$t = $row['time'];

				$s = "
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<h3 class='panel-title' style='display: inline;'>".$name."</h3>
						<h3 class='panel-title' style='display: inline;float: right;'>".$t."</h3>
					</div>
					<div class='panel-body'>".$text."</div>
				</div>
				";
				echo $s;
			}
		}
	}
	mysqli_close($con);
	?>
</div>

</body>
</html>