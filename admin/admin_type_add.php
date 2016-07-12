<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增栏目</title>
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
    })(art.dialog.defaults);
    if(getName('typename').value=='' || getName('typename').value.length < 2 || getName('typename').value.length > 10){
        art.dialog({
            content: '期刊名称必须为2~10位！'
        });
        return false;
    };
    if( getName('typesort').value < 0 || isNaN(getName('typesort').value) ){
        art.dialog({
            content: '期刊排序必须为大于0的数字！'
        });
        return false;
    };
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">新增期刊栏目</div>
        <form action="?action=addtype" method="post" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">栏目名称</td><td class="text"><input type="text" name="typename"></td><td class="right">栏目名称必填，长度2-10位。</td></tr>
                    <tr><td class="left">栏目排序</td><td class="text"><input type="text" name="typesort"></td><td class="right">栏目排序为空自动生成，数字越大排名越前。</td></tr>
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