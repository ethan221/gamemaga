<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增管理员</title>
<link href="images/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="images/script.js"></script>
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
    })(art.dialog.defaults);
    if(getName('username').value.length <3 || getName('username').value.length >10 ){
        art.dialog({
            content: '用户名长度需为3~10位！'
        });
        return false;
    };
    if(getName('password').value=='' || getName('password2').value=='' ){
        art.dialog({
            content: '新密码、新密码确认不能为空！'
        });
        return false;
    };
    if(getName('password').value.length <5 || getName('password').value.length >18 ){
        art.dialog({
            content: '密码长度需在5~18位！'
        });
        return false;
    };
    if(getName('password').value != getName('password2').value){
        art.dialog({
            content: '两次密码必须相同！'
        });
        return false;
    };
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">新增管理员</div>
        <form action="?action=adduser" method="post" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">用户名</td><td class="text"><input type="text" name="username"></td><td class="right">用户名必填，长度3-10位。</td></tr>
                    <tr><td class="left">密码</td><td class="text"><input type="password" name="password"></td><td class="right">密码必填，长度5-18位。</td></tr>
                    <tr><td class="left">密码确认</td><td class="text"><input type="password" name="password2"></td><td class="right">重复输入以上密码。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="submit" value="提交"></td></tr>
                </table>
            </div>
        </form>
    </div>
    <?php function_copyright();?>
    <?php if($_GET['info']!=''){ ?>
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