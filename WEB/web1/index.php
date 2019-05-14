<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="UTF-8">  
    <meta name="robots" content="noindex,nofollow">  
    <title>418 - 页面错误</title>  
    <style>  
        body{font-size: 14px;font-family: 'helvetica neue',tahoma,arial,'hiragino sans gb','microsoft yahei','Simsun',sans-serif; background-color:#fff; color:#808080;}  
        .wrap{margin:200px auto;width:510px;}  
        td{text-align:left; padding:2px 10px;}  
        td.header{font-size:22px; padding-bottom:10px; color:#000;}  
        td.check-info{padding-top:20px;}  
        a{color:#328ce5; text-decoration:none;}  
        a:hover{text-decoration:underline;}  
    </style>  
</head>  
<body>  
    <?php
        if(!isset($_COOKIE['want'])){
            setcookie('want',base64_encode('coffee'),time()+600);
            header("Location: index.php");
            exit();
        }

        $cookie = @$_COOKIE['want'];
        if(base64_decode($cookie)==="coffee"){
            header("HTTP/1.1 418 I'm a teapot"); 
            echo "
            <div class='wrap'>  
                <table>  
                    <tr>  
                        <td rowspan='5'><img src='https://ws1.sinaimg.cn/large/a15b4afegy1fhsfdznep4j2020020web.jpg'></td>  
                        <td class='header'>Error 418</td>  
                    </tr>  
                    <tr><td>你访问的页面出现错误</td></tr>  
                </table>  
            </div>
            ";
        }
        elseif(base64_decode($cookie)==="tea") {
            echo "sicnuctf{1'm_A_Teeeeeeap0t}";
        }
        else{
            echo "Tell me what you want !";
        }
    ?>
</body>  
</html> 