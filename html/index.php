
<?php
/*
*  this is index.php
*  has: login(with input,js with ajax to login.php),register(no input,location:register.php),
*
*/

require_once ('../include/session_start.php');

//  check login --> give user message, and login should not repeat
?>


<!DOCTYPE html>
<html lang="zh-cmn">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body background="src/index_bg.jpg">
<div class="container">
    <div align="middle" >
        <h1><font color=green size=100>HELLO strangers~</font> <small>sign in</small></h1>
    </div>
    <hr>
    <form name="signin" method="post" action="login.php" role="form">
        <div class="input-group">
            <font size=5>Username= </font><input type="text" name="username" size=30  placeholder="请输入用户名">
            <br>
            <font size=5>Password = </font><input type="password" name="password" size=30 maxlength=16  placeholder="请输入密码">
            <br>
            <input type="submit" name="submit" value="   登  陆   " class="btn btn-primary">
        </div>
    </form>
</div>
</body>
</html>


<?php
    //require_once('../include/footer.php');
?>