<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$row=_query("SELECT * FROM magacms_system LIMIT 1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统设置</title>
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
function delPic(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个广告图片吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=deladphoto'
        },
        cancelVal: '取消',
        cancel: true
    });
}
function validate_form(){
    (function (config) {
        config['title'] = '错误';
        config['lock'] = true;
        config['fixed'] = true;
        config['time'] = 2;
        config['icon'] = 'error';
    config['zIndex'] = '1000';
    })(art.dialog.defaults);
    if(getName('pagenum').value=='' || getName('pagenum').value < 1 || isNaN(getName('pagenum').value) || getName('pagenum').value > 50 ){
        art.dialog({
            content: '显示数量必须为1~50之间的数字！'
        });
        return false;
    };
    if( getName('adtime').value < 0 || getName('adtime').value > 60 || isNaN(getName('adtime').value)){
        art.dialog({
            content: '广告时间必须为0~60之间的数字！'
        });
        return false;
    };
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">系统设置</div>
        <form action="?action=editsystem" method="post" name="editsystem" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">首页每页显示数量</td><td class="text"><input type="text" name="pagenum" value="<?php echo $row['pagenum'];?>"></td><td class="right">建议为5的倍数。</td></tr>
                    <tr><td class="left">排序方式</td><td class="text">
                        <select name="sort">
                        <option value="1" <?php if($row['sort']==1){;?>selected="selected"<?php }?>>新添加的在前</option>
                        <option value="0" <?php if($row['sort']==0){;?>selected="selected"<?php }?>>新添加的在后</option>
                        </select>
                    </td><td class="right">设置首页期刊的排序方式。</td></tr>
                    <tr><td class="left">评论功能</td><td class="text">
                    <select name="gbook">
                    <option value="1" <?php if($row['gbook']==1){;?>selected="selected"<?php }?>>打开</option>
                    <option value="0" <?php if($row['gbook']==0){;?>selected="selected"<?php }?>>关闭</option>
                    </select>
                    </td><td class="right">评论功能开关。</td></tr>
                    <tr><td class="left">伪静态</td><td class="text">
                    <select name="rewrite">
                    <option value="1" <?php if($row['rewrite']==1){;?>selected="selected"<?php }?>>打开</option>
                    <option value="0" <?php if($row['rewrite']==0){;?>selected="selected"<?php }?>>关闭</option>
                    </select>
                    </td><td class="right">需要配置好规则以及服务器对伪静态的支持。</td></tr>
                    <tr><td class="left">阅读界面广告时间</td><td class="text"><input type="text" name="adtime" value="<?php echo $row['adtime'];?>"></td><td class="right">0~60秒之内，关闭广告请输入0。</td></tr>
                    <tr><td class="left">阅读界面广告图片</td><td class="text"><input readonly type="text" name="adphoto" <?php if($row['adphoto']==''){?>value="无广告图片"<?php }else{?>value="<?php echo $row['adphoto'];?>"<?php }?>></td><td class="right"><a class="upload" href="javascript:void(0);" onclick="uploadbox('includes/upload.inc.php?input=adphoto&form=editsystem&dir=showad&type=a&text=只允许上传jpg、jpeg、gif、png文件！',400,100);lock();"><?php if($row['adphoto']==''){?>上传<?php }else{?>替换<?php }?></a><?php if($row['adphoto']!=''){?><a class="del" href="javascript:void(0);" onClick="delPic();">删除</a><?php }?> 最佳尺寸600px×300px。</td></tr>
                    <tr><td class="left">阅读界面广告链接</td><td class="text"><input type="text" name="adlink" value="<?php echo $row['adlink'];?>"></td><td class="right">输入以http://开头的网址。</td></tr>
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
        fixed: true
    });
    </script>
    <?php } ?>
</body>
</html>