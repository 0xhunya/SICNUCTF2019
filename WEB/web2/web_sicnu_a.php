<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>welcome to sicnu</title>
</head>
<body>
    <div align="center"><font size="20">welcome to sicnu</font></div>
  <?php
 @error_reporting(E_ALL^E_NOTICE);
  
    $show=1;
  require('config.php');
  

 $user = null;

 
 if(!empty($_GET['data'])) {
     try {
         $data = json_decode($_GET['data'], true);
     } catch (Exception $e) {
         $data = [];
     }
     extract($data);
     if($users[$username] && strcmp($users[$username], $password) == 0) {
         $user = $username;
     }

 }
if ($user==$usname) {
    echo "sicnuctf{G1t_Le4k_Is_D@ng3r0us}";
}

?>

<!--  ?php
 require('config.php');
  

 $user = null;

 
 if(!empty($_GET['data'])) {
     try {
         $data = json_decode($_GET['data'], true);
     } catch (Exception $e) {
         $data = [];
     }
     extract($data);
     if($users[$username]) {
         $user = $username;
     }

 }
if ($user==$usname) {
    echo "sicnuctf{************}";
}
? -->
</body>
</html>

