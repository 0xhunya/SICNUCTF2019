<html>
<head>
<title>龙湖社工库</title>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<STYLE>
A {
	COLOR: #ffffff; TEXT-DECORATION: none
}
A:hover {
	COLOR: #6699cc; TEXT-DECORATION: underline
}
BODY 
{
	FONT-SIZE: 9pt; SCROLLBAR-HIGHLIGHT-COLOR: buttonface; SCROLLBAR-SHADOW-COLOR: 
buttonface;SCROLLBAR-ARROW-COLOR: #cacab7;SCROLLBAR-FACE-COLOR:000033;SCROLLBAR-3DLIGHT-COLOR: 
buttonhighlight; SCROLLBAR-TRACK-COLOR: #f5f5f5; FONT-FAMILY: 宋体; SCROLLBAR-DARKSHADOW-COLOR: 
buttonshadow
}
{
	FONT-FAMILY: "Verdana","Arial","宋体"; FONT-SIZE: 9pt
}
TD {
	FONT-FAMILY: 宋体,Arial,Verdana; FONT-SIZE: 9pt
}
FORM {
	MARGIN: 0px; PADDING-BOTTOM: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px}
.kker {
	BACKGROUND-COLOR: #ffffff; BORDER-BOTTOM: 1px dotted; BORDER-LEFT: 1px dotted; BORDER-RIGHT: 1px dotted; BORDER-TOP: 1px dotted; FONT-SIZE: 9pt; HEIGHT: 16px; MARGIN: 0px; PADDING-BOTTOM: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
</STYLE>
<STYLE type=text/css>BODY {
	SCROLLBAR-FACE-COLOR: #000000; SCROLLBAR-HIGHLIGHT-COLOR: #000000; SCROLLBAR-SHADOW-COLOR: #000000; SCROLLBAR-3DLIGHT-COLOR: #000000; SCROLLBAR-ARROW-COLOR: #ffffff; SCROLLBAR-TRACK-COLOR: #ffffff; FONT-FAMILY: Verdana; SCROLLBAR-DARKSHADOW-COLOR: #000000
}
.Estilo10 {
	COLOR: #ffffff; FONT-FAMILY: Haettenschweiler
}
.Estilo8 {
	FONT-SIZE: 10px; COLOR: #ffffff; FONT-FAMILY: Haettenschweiler
}
</STYLE>
<body onselectstart="return false;" oncontextmenu="return false;" >
<SCRIPT language=JavaScript1.2>  
if (document.all)  
document.body.style.cssText="border:30 ridge red"  
</SCRIPT>
<BGSOUND balance=0 src="http://www.hac-ker.com/hacker.mid" volume=0 loop=20></TR>
<STYLE type=text/css>
BODY{cursor:url('http://www.hac-ker.com/mouse.cur');}
A {CURSOR: url('http://www.hac-ker.com/mouse1.cur');}
</STYLE>
<style type="text/css">
.style1 {
	text-align: center;
}
.style2 {
	border-width: 0px;
}
</style>
</head>
<body bgcolor="#000000" text="#FFFFFF">
<p class="style1">
<img src="http://www.hac-ker.com/hacker/images/28_01.gif" class="style2"></a></p>
<BR>
<BR>
<p align="center"><font face="Impact" size="6" color="#FF0000">龙 . 湖 . 社 . 工 . 库</font>
<BR>
<BR>
<BR>
<BR>
<div style="text-align:center; vertical-align:middel;">
	<form action="" method="POST">
		<input type="text" name="name" placeholder="姓名">
		<input type="text" name="email" placeholder="邮箱">
		<input type="hidden" name="sort" value="asc">
		<input type="submit" name="submit" value="查询">
	</form><br><br>
	<?php
	//error_reporting(0);
	
	function Check($str){

		$blacklist = array(
			"[\s]",
			"\'",
			"\"",
			"=",
			"\/\*\*\/",
			"information_schema",
			"benchmark"
		);

		foreach ($blacklist as $value) {
			if (preg_match("/$value/i", $str)) {
				die("黑白只在一念间");
			}
		}

		return $str;
	}
	if (isset($_POST['submit'])&&(!empty($_POST['name'])||!empty($_POST['email']))){
		
		// MySQL Initial
		$con = new mysqli('localhost', 'sicnuctf', 'sicnuctf', 'sqli');
		if ($con->connect_error) {
		    die("MySQL Connection Error: " . $con->connect_error);
		}
		
		// Get Params
		$name = @$_POST['name'];
		$email = @$_POST['email'];
		$sort = empty($_POST['sort'])?'asc':Check($_POST['sort']);
		
		// Do SQL
		if($stmt = $con->prepare("
			SELECT name,email,password,info
			FROM sgk
			WHERE name LIKE concat('%',?,'%')
			AND email LIKE concat('%',?,'%')
			ORDER BY id $sort")){
			$stmt->bind_param("ss", $name, $email);
			
			// select and echo
			if($stmt->execute()){
				$stmt->store_result();
				$stmt->bind_result($one_name, $one_email, $one_password, $one_info);
				while ($stmt->fetch()) {
					echo $one_name.'---'.$one_email.'---'.$one_password.'---'.$one_info.'<br>';
				}
			}
			$stmt->close();
		}
		
		// Close
		$con->close();
	}
	?>
</div>
</body>
</html>