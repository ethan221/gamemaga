<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
<link href="/assets/admin/images/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="rightbox">
    <div class="title">欢迎您，<?php echo $_SESSION['ADMIN']['username']; ?>！</div>
    <div class="boxtext">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25%"><a href='../admin_maga_add.php' target="right"><img src="/assets/admin/images/ico_text_add.png" />新增期刊</a></td>
                <td width="25%"><a href='../admin_maga.php' target="right"><img src="/assets/admin/images/ico_text.png" />期刊管理</a></td>
                <td width="25%"><a href='../admin_type_add.php' target="right"><img src="/assets/admin/images/ico_type_add.png" />新增栏目</a></td>
                <td><a href='../admin_type.php' target="right"><img src="/assets/admin/images/ico_type.png" />栏目管理</a></td>
            </tr>
            <tr>
                    <td><a href='../admin_user.php' target="right"><img src="/assets/admin/images/ico_user.png" />管理员列表</a></td>
                    <td><a href='../admin_user_add.php' target="right"><img src="/assets/admin/images/ico_user_add.png" />新增管理员</a></td>
                    <td><a href='../admin_system.php' target="right"><img src="/assets/admin/images/ico_system.png" />系统配置</a></td>
                    <td><a href='../admin_siteinfo.php' target="right"><img src="/assets/admin/images/ico_siteinfo.png" />站点信息</a></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>