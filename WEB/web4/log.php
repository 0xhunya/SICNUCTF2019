<?php
if (empty($_POST['NS'])) {
	highlight_file('log.txt');
}

session_start();
include('config.php');
try{
$pdo = new PDO('mysql:host=localhost;dbname=sicnu', 'root', '147258');
}catch (Exception $e){
die('mysql connected error');
}
$username = (isset($_POST['username']) === true && $_POST['username'] !== '') ? (string)$_POST['username'] : die('Missing username');
$password = (isset($_POST['password']) === true && $_POST['password'] !== '') ? (string)$_POST['password'] : die('Missing password');

if (strlen($username) > 32 || strlen($password) > 32) {
die('is too long');
}

$sth = $pdo->prepare('SELECT password FROM users WHERE username = :username');
$sth->execute([':username' => $username]);
if ($sth->fetch()[0] !== $password) {
die('Error in username or password');
}
$_SESSION['username'] = $username;
unset($_SESSION['is_logined']);
unset($_SESSION['is_guest']);
#echo $username;
header("Location: member.php");

?>