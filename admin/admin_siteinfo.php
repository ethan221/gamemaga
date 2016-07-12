<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$row=_query("SELECT * FROM magacms_siteinfo LIMIT 1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站点信息设置</title>
<link href="images/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="images/script.js"></script>
<link href="artDialog/skins/default.css" rel="stylesheet" type="text/css">
<script>
// skin demo
(function() {
	var _skin, _jQuery;
	var _search = window.location.search;
	if (_search) {
		_skin = _search.split('demoSkin=')[1];
		_jQuery = _search.indexOf('jQuery=true') !== -1;
		if (_jQuery) document.write('<scr'+'ipt src="../jquery-1.6.2.min.js"></sc'+'ript>');
	};
	
	document.write('<scr'+'ipt src="artDialog/artDialog.source.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
	window._isDemoSkin = !!_skin;	
})();
function validate_form(){
    (function (config) {
        config['title'] = '错误';
        config['lock'] = true;
        config['fixed'] = true;
        config['time'] = 2;
        config['icon'] = 'error';
    config['zIndex'] = '1000';
    })(art.dialog.defaults);
    if(getName('sitename').value=='' || getName('sitename').value.length<2 || getName('sitename').value.length>50 ){
        art.dialog({
            content: '站点名称长度限制为2~50位！'
        });
        return false;
    };
    if(getName('siteurl').value=='' || getName('siteurl').value.length<3 || getName('siteurl').value.length>50 ){
        art.dialog({
            content: '站点域名长度限制为3~50位！'
        });
        return false;
    };
    if( getName('sitekey').value.length>200){
        art.dialog({
            content: '站点关键词超出200位！'
        });
        return false;
    };
    if( getName('sitedes').value.length>255){
        art.dialog({
            content: '站点描述超出255位！'
        });
        return false;
    };
    if( getName('sitetj').value.length>255){
        art.dialog({
            content: '统计代码超出255位！'
        });
        return false;
    };
    if( getName('siteicp').value.length>20){
        art.dialog({
            content: '备案信息超出20位！'
        });
        return false;
    };
    if( getName('siteright').value.length>500){
        art.dialog({
            content: '版权信息超出500位！'
        });
        return false;
    };
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">站点信息设置</div>
        <form action="?action=siteinfo" method="post" name="siteinfo" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">站点名称</td><td class="text"><input style="disply:none" type="text" name="sitename" value="<?php echo $row['sitename'];?>"></td><td class="right">您的网站名称，将显示在浏览器标题栏（2~50位）。</td></tr>
                    <tr><td class="left">站点域名</td><td class="text"><input style="disply:none" type="text" name="siteurl" value="<?php echo $row['siteurl'];?>"></td><td class="right">您的网站域名，全站调用，格式如：“www.wwzzs.com”（3~50位）。</td></tr>
                    <tr><td class="left">站点关键词</td><td class="text"><input style="disply:none" type="text" name="sitekey" value="<?php echo $row['sitekey'];?>"></td><td class="right">站点关键词，首页keywords调用，有利于SEO（不能超过200位）。</td></tr>
                    <tr><td class="left">站点描述</td><td class="text"><input style = "disply:none"  type="text" name="sitedes" value="<?php echo $row['sitedes'];?>"></td><td class="right">站点描述，首页description调用，有利于SEO（不能超过255位）。</td></tr>
                    <tr><td class="left">统计代码</td><td class="text"><input style="disply:none" type="text" name="sitetj" value="<?php echo $row['sitetj'];?>"></td><td class="right">统计网站流量，可从“51LA”等第三方网站获取（不能超过255位）。</td></tr>
                    <tr><td class="left">备案号</td><td class="text"><input style="disply:none" type="text" name="siteicp" value="<?php echo $row['siteicp'];?>"></td><td class="right">备案号，无则不填（不能超过20位）。</td></tr>
                    <tr><td class="left">底部版权</td><td class="text"><textarea style="disply:none" name="siteright" rows="3"><?php echo $row['siteright'];?></textarea></td><td class="right">首页底部描述，支持HTML代码（不能超过500位）。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="submit" value="提交"></td></tr>
                </table>
            </div>
        </form>
    </div>
    <?php function_copyright();?>
    <?php if($_GET['info']!=''){?>
    <script>
    art.dialog({
        title: '提示',
        icon: '<?php echo $_GET['icon']; ?>',
        lock: true,
        time: 2,
        content: '<?php echo $_GET['info']; ?>',
        fixed: 'true'
    });
    </script>
    <?php } ?>
</body>
</html>