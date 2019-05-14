<?php
if (empty($_POST['NS'])) {
	highlight_file('register.txt');
}

include('config.php');
try{
$pdo = new PDO('mysql:host=localhost;dbname=sicnu', 'root', '147258');
}catch (Exception $e){
die('mysql connected error:');
}
$admin = "sicnu"."#".str_shuffle('hello_here_is_your_flag_but_it_no_easy');
$username = (isset($_POST['username']) === true && $_POST['username'] !== '') ? (string)$_POST['username'] : die('Missing username');
$password = (isset($_POST['password']) === true && $_POST['password'] !== '') ? (string)$_POST['password'] : die('Missing password');
$code = (isset($_POST['code']) === true) ? (string)$_POST['code'] : '';

if (strlen($username) > 16 || strlen($username) > 16) {
die('is too long');
}

$sth = $pdo->prepare('SELECT username FROM users WHERE username = :username');
$sth->execute([':username' => $username]);
if ($sth->fetch() !== false) {
die('username has been registered');
}

$sth = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
$sth->execute([':username' => $username, ':password' => $password]);

preg_match('/^(sicnu)((?:#|\w)+)$/i', $code, $matches);
if (count($matches) === 3 && $admin === $matches[0]) {
$sth = $pdo->prepare('INSERT INTO inspect (username, permit) VALUES (:username, :permit)');
$sth->execute([':username' => $username, ':permit' => $matches[1]]);
} else {
$sth = $pdo->prepare('INSERT INTO inspect (username, permit) VALUES (:username, "TERRIBLE")');
$sth->execute([':username' => $username]);
}
echo '<script>alert("register success");location.href="log.html"</script>';


?>