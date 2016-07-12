<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>后台管理</title>
        <link href="/assets/admin/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="leftbox">
            <div class="title">系统配置</div>
            <ul>
                <li><a href="/assets/admin/admin_siteinfo.php" target="right"><img src="/assets/admin/images/ico_siteinfo.png" />站点信息</a></li>
                <li><a href="/assets/admin/admin_system.php" target="right"><img src="/assets/admin/images/ico_system.png" />系统配置</a></li>
                <li><a href="/assets/admin/admin_banner.php" target="right"><img src="/assets/admin/images/ico_banner.png" />幻灯配置</a></li>
            </ul>
        </div>
        <div class="leftbox">
            <div class="title">栏目管理</div>
            <ul>
                <li><a href="/backend/topic" target="right"><img src="/assets/admin/images/ico_type.png" />栏目列表</a></li>
                <li><a href="/backend/topic/add" target="right"><img src="/assets/admin/images/ico_type_add.png" />新增栏目</a></li>
            </ul>
        </div>
        <div class="leftbox">
            <div class="title">内容管理</div>
            <ul>
                <li><a href="/backend/maga" target="right"><img src="/assets/admin/images/ico_text.png" />期刊列表</a></li>
                <li><a href="/backend/maga/add" target="right"><img src="/assets/admin/images/ico_text_add.png" />新增期刊</a></li>
            </ul>
        </div>
        <div class="leftbox">
            <div class="title">管理员</div>
            <ul>
                <li><a href="/backend/admin" target="right"><img src="/assets/admin/images/ico_user.png" />管理员列表</a></li>
                <li><a href="/backend/admin/add" target="right"><img src="/assets/admin/images/ico_user_add.png" />新增管理员</a></li>
            </ul>
        </div>
        <div class="leftbox">
            <div class="title">拓展功能</div>
            <ul>
                <li><a href="/assets/admin/admin_ryfile.php" target="right"><img src="/assets/admin/images/ico_ryfile.png" />冗余文件检测</a></li>
                <li><a href="/assets/admin/admin_gbook.php" target="right"><img src="/assets/admin/images/ico_gbook.png" />评论管理</a></li>
            </ul>
        </div>
        <div class="leftbox">
            <div class="title">电子竞技</div>
            <ul class="about">
                <img src="/assets/admin/images/ico_logo.png" />
            </ul>
        </div>
    </body>
</html>