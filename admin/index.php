<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录 - 万众电子期刊后台管理系统 - Powered by Wwzzs.com!</title>
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body style="background:url(images/bg_login_big.png) 50% 50% ;background-position:center;background-repeat: no-repeat;background-attachment: fixed;}">
<div id="login">
    <div class="login">
    <div class="title">管理员登录</div>
    <form action="?action=login" method="post">
        <dl><dt>管理员：</dt><dd><input type="text" name="username" /></dd></dl>
        <dl><dt>密码：</dt><dd><input type="password" name="password" /></dd></dl>
        <dl><dt>验证码：</dt><dd><input class="code" type="text" maxlength="4" name="code" /><a href="" title="点击刷新验证码"><img src="../includes/code.inc.php"/></a></dd></dl>
        <dl class="submit" ><input type="submit" value="登录" /></dl>
    </form>
    </div>
    <?php function_copyright();?>
</div>
</body>
</html>