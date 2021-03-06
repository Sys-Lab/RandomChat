<?php
require_once('../include/User.php');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width,innitial-scale=1">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- <style type="text/css">
       body{background-image: url("home_bg.jpg");background-repeat:no-repeat;border-image: 100%}
                       .table th, .table td {text-align: center;}
     </style>-->
    <style type="text/css">
        .vertical-button{position: absolute;top: 70%;left: 50%;transform: translate(-50%, -50%);}
        .a font{position: absolute;top: 40%;left: 50%;transform: translate(-50%, -50%);}
        .b font{position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);}
        .modal.fade.in {top: 25%;}
    </style>
    <script type="text/javascript">
        function userexists()
        {
            var xmlhttp;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("POST","userexists.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("user=" + document.getElementById("name1").value);
            xmlhttp.onreadystatechange = callback;
            function callback()
            {
                if(xmlhttp.readyState === 4)
                {
                    if(xmlhttp.status === 200)
                    {
                        var a = eval('['+xmlhttp.responseText+']');
                        var code= a[0]['message']['Code'];
                        if(code == -200)
                        {
                            document.getElementById("span1").innerHTML='<font color="red">用户名已存在！</font>';
                        }
                        if(code == -202)
                        {
                            document.getElementById("span1").innerHTML='<font color="green">用户名可用</font>';
                        }
                        if(code == -204)
                        {
                            document.getElementById("span1").innerHTML='<font color="red">用户名格式错误！</font>';
                        }
                        if(code == -206)
                        {
                            document.getElementById("span1").innerHTML='<font color="red">用户名不可为空</font>';
                        }
                    }
                }
                else
                {
//
                }
            }
        }


    </script>
    <script type="text/javascript">
        function RegCheck(RegForm)
        {
            if (RegForm.username.value == "")
            {
                alert("用户名不可为空");
                RegForm.username.focus();
                return (false);
            }
            if (RegForm.username.value.length > 15 || RegForm.username.value.length < 3)
            {
                alert("用户名长度不符");
                RegForm.username.focus();
                return (false);
            }
            if (RegForm.password.value == "")
            {
                alert("密码不可为空");
                RegForm.password.focus();
                return (false);
            }
            if (RegForm.password.value.length > 16 || RegForm.password.value.length < 6)
            {
                alert("密码长度不符");
                RegForm.password.focus();
                return (false);
            }
            if (RegForm.email.value == "")
            {
                alert("电子邮箱不可为空");
                RegForm.email.focus();
                return (false);
            }
        }
        function SignCheck(SignForm)
        {
            if (SignForm.username.value == "")
            {
                alert("用户名不可为空");
                SignForm.username.focus();
                return (false);
            }
            if (SignForm.password.value == "")
            {
                alert("密码不可为空");
                SignForm.password.focus();
                return (false);
            }
        }
    </script>
    <title>welcome to our randomchat</title>
</head>
<body >
<div id="bg" style="position:absolute; width:100%; height:100%; z-index:-1">
    <img src="src/index_bg.jpg" height="100%" width="100%"/>
</div>
<div class="container">
    <div class="row">
        <div class="a">
            <p>
                <font class="text-center align=center" color="#FFFFFFF" size=1000%>Chat with stranger</font>
            </p>
        </div>
        <div class="b">
            <p>
                <font class="text-center align=center" color="#FFFFFFF" size=1000%>Chat with surprise</font>
            </p>
        </div>
        <div class="vertical-button">
            <?php
            $user = new User();
            if ($user->isLogin())
            {
                ?>
                <p>
                    <button class="btn btn-info btn-lg" type="button" onclick="location='home.php'">home</button>
                </p>
                <?php
            }
            else
            {
                ?>
                <p>
                    <button class="btn btn-info btn-lg" type="button" data-toggle="modal" data-target="#myRegister">register</button>
                    <button class="btn btn-default btn-lg" type="button" data-toggle="modal" data-target=".bs-example-modal-sm"> signin </button>
                </p>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div id="mySignin" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="text-center text-primary">登录</h1>
            </div>
            <div class="modal-body">
                <form method="post" action="login.php" class="form col-md-12 center-block" onSubmit="return SignCheck(this)">
                    <div class="form-group">
                        <label for="Username">  Username</label>
                        <input type="username" class="form-control input-lg" name="username" placeholder="username">
                    </div>
                    <div class="form-group">
                        <label for="Username">  Password</label>
                        <input type="password" class="form-control input-lg" name="password" placeholder="password" maxlength=16>
                    </div>
                    <div class="form-group" align="center">
                        <button type="submit" class="btn btn-default btn-lg">Submit</button>
                        <br>
                        <p>
                            <span><a href="" align=center>忘记密码?</a></span></p>
                    </div>
                </form>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
<div id="myRegister" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="text-center text-primary">注册</h1>
            </div>
            <div class="modal-body">
                <form method="post" action="register.php" class="form col-md-12 center-block" onSubmit="return RegCheck(this)">
                    <div class="form-group">
                        <label for="Username">  Username</label>
                        <input type="username" class="form-control input-lg" id="name1" placeholder="username" name="username" onblur="userexists()">
                        <span>(必填，3~15字符长度，支持字母、数字及下划线)</span><br>
                        <span id="span1"></span>
                    </div>
                    <div class="form-group">
                        <label for="Password">  Password</label>
                        <input type="password" class="form-control input-lg" placeholder="password" name="password" maxlength=16>
                        <span>(必填,6~16位,支持字母、数字及下划线,区分大小写)</span><br>
                        <span></span>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="male" checked> gentleman
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="female"> lady
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="Email">  Email</label>
                        <input type="email" class="form-control input-lg" placeholder="email" name="email">
                        <span>(必填,建议使用gmail)</span>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default btn-lg">Submit</button>
            </div>
            </form>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
</body>
</html>