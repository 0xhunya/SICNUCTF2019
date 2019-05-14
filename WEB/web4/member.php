<?php
error_reporting(0);
session_start();
include('config.php');
if (isset($_SESSION['username']) === false) {
die('please login first');
}
try{
$pdo = new PDO('mysql:host=localhost;dbname=sicnu', 'root', '147258');
}catch (Exception $e){
die('mysql connected error');
}
$sth = $pdo->prepare('SELECT permit FROM inspect WHERE username = :username');
$sth->execute([':username' => $_SESSION['username']]);
if ($sth->fetch()[0] === 'TERRIBLE') {
$_SESSION['is_guest'] = true;
}

$_SESSION['is_logined'] = true;
if (isset($_SESSION['is_logined']) === false || isset($_SESSION['is_guest']) === true) {
	echo "no no no!";
}else{
if(isset($_GET['file'])===false)
echo "no";
elseif(is_file($_GET['file']))
echo "you cannot give me a file";
else
readfile($_GET['file']);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<div align="center"><img src="1.gif" width="400" ></div>
	<div align="center"><p style="color:orange">你是拿不到flag的^..^</p></div>


<!-- ?php
error_reporting(0);
session_start();
include('config.php');
if (isset($_SESSION['username']) === false) {
die('please login first');
}
try{
$pdo = new PDO('mysql:host=localhost;dbname=***', '***', '***');
}catch (Exception $e){
die('mysql connected error');
}
$sth = $pdo->prepare('SELECT permit FROM inspect WHERE username = :username');
$sth->execute([':username' => $_SESSION['username']]);
if ($sth->fetch()[0] === 'TERRIBLE') {
$_SESSION['is_guest'] = true;
}

$_SESSION['is_logined'] = true;
if (isset($_SESSION['is_logined']) === false || isset($_SESSION['is_guest']) === true) {
	echo "no no no!";
}else{
if(isset($_GET['file'])===false)
echo "no";
elseif(is_file($_GET['file']))
echo "you cannot give me a file";
else
readfile($_GET['file']);
}
 ?-->
</body>
</html>