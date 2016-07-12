<?php require_once dirname(__FILE__) . '/global.fun.php'; function_safety();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>万众网络</title>
<link href="../images/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../images/ajax.js"></script>
<script>window.onload=function(){ loadXMLDoc("<?php echo ROOTNAME; ?>includes/xml.fun.php?action=a&t=" + Math.random(), "version"); loadXMLDoc("<?php echo ROOTNAME; ?>includes/xml.fun.php?action=b&t=" + Math.random(), "news"); loadXMLDoc("<?php echo ROOTNAME; ?>includes/xml.fun.php?action=b&t=" + Math.random(), "news");}</script>
</head>
<body>
<div class="info" id="version"><span>提示：</span><img src="../images/loading_2.gif" /> 版本信息获取中……</div>
<div class="rightbox">
    <div class="title">欢迎您，<?php echo $_SESSION['username']; ?>！</div>
    <div class="boxtext">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25%"><a href='../admin_maga_add.php' target="right"><img src="../images/ico_text_add.png" />新增期刊</a></td>
                <td width="25%"><a href='../admin_maga.php' target="right"><img src="../images/ico_text.png" />期刊管理</a></td>
                <td width="25%"><a href='../admin_type_add.php' target="right"><img src="../images/ico_type_add.png" />新增栏目</a></td>
                <td><a href='../admin_type.php' target="right"><img src="../images/ico_type.png" />栏目管理</a></td>
            </tr>
            <tr>
                    <td><a href='../admin_user.php' target="right"><img src="../images/ico_user.png" />管理员列表</a></td>
                    <td><a href='../admin_user_add.php' target="right"><img src="../images/ico_user_add.png" />新增管理员</a></td>
                    <td><a href='../admin_system.php' target="right"><img src="../images/ico_system.png" />系统配置</a></td>
                    <td><a href='../admin_siteinfo.php' target="right"><img src="../images/ico_siteinfo.png" />站点信息</a></td>
            </tr>
        </table>
    </div>
</div>
<div class="rightbox">
    <div class="title">官方动态</div>
    <div class="boxtext" id="news">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr><td class="news"><img src="../images/loading_2.gif" /> 官方动态数据获取中……</td></tr>
        </table>
    </div>
</div>
<div class="rightbox">
    <div class="title">环境信息</div>
    <div class="boxtext">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25%">解释器</td>
                <td width="25%">程序根目录</td>
                <td width="25%">来访IP</td>
                <td>服务器域名</td>
            </tr>
            <tr>
                <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                <td><?php echo dirname(dirname(dirname(__FILE__))); ?></td>
                <td><?php echo function_getRealIp(); ?></td>
                <td><?php echo $_SERVER["SERVER_NAME"] . ':' . $_SERVER['SERVER_PORT']; ?></td>
            </tr>
            <tr>
                <td>服务器系统</td>
                <td>Php上传限制<b>*重要</b></td>
                <td>GD库<b>*重要</b></td>
                <td>当前管理员</td>
            </tr>
            <tr>
                <td><?php echo php_uname('s'); ?></td>
                <td><?php echo ini_get('upload_max_filesize'); ?></td>
                <td><?php if (extension_loaded("gd") || function_exists("gd_info")) { echo'启用';} else { echo'禁用（部分功能失效）'; } ?></td>
                <td><?php echo $_SESSION['username']; ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="rightbox">
    <div class="title">程序介绍</div>
    <div class="texts">
        <p>万众电子期刊在线阅读系统是万众网络（www.wwzzs.com）开发的一套针对DM商家、杂志商等需要在线阅读刊物的系统，程序后台采用PHP开发，数据库采用Mysql，采用多种安全机制避免数据丢失，页面采用纯DIV+CSS,界面友好有利于搜索引擎优化，是需要一套在线阅读系统的用户的最佳选择。</p>
    </div>
</div>
<div class="rightbox">
    <div class="title">功能概述</div>
    <div class="texts">
        <p>1、设置网站基本信息 2、设置多个管理员共同管理 3、支持伪静态设置 4、期刊管理支持jpg、gif、png等图片的上传 5、后台期刊和版面集中管理，可删除、修改 6、后台删除期刊自动删除期刊包含的图片文件，节省磁盘空间 7、后台删除版面同上 8、后台集成web文件管理器，可快速随时删除、编辑、上传所需的文件。</p>
    </div>
</div>
<div class="rightbox">
    <div class="title">版权申明</div>
    <div class="texts">
        <p>1、《万众电子期刊在线阅读系统 PHP版》以下简称“本程序”，是万众网络团队开发的一套利用Php+Mysql程序语言开发的一套开源程序，本程序版权归万众网络所有；</p>
        <p>2、用户在购买本程序后，可以进行常规（如：刊登广告、付费阅读等）商业化运营，但禁止以出售、二次开发、公开传播以及其它一切万众网络认为不合适的方式来进行商业化运营；</p>
        <p>3、由于本程序代码开源且非独家授权，因此用户在使用本程序搭建网站时可能会发生故障，万众网络不承担故障对用户造成的一切损失。</p>
        <p>4、本条款最终解释权归万众网络所有。</p>
    </div>
</div>
<?php function_copyright(); ?>
</body>
</html>