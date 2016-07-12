<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增期刊</title>
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
if(getName('maganame').value=='' || getName('maganame').value.length < 2 || getName('maganame').value.length > 18){
    art.dialog({
        content: '期刊名称必须在2~18位！'
    });
    return false;
};
if( isNaN(getName('width').value) || isNaN(getName('mwidth').value) || isNaN(getName('height').value) || isNaN(getName('mheight').value)){
    art.dialog({
        content: '期刊尺寸必须为数字！'
    });
    return false;
};
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">新增期刊</div>
        <form enctype="multipart/form-data" action="?action=addmaga" method="post" name="addmaga" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">期刊名称</td><td class="text"><input type="text" name="maganame"></td><td class="right" id="rigth">期刊名称，长度2-18位。</td></tr>
                    <tr><td class="left">所属栏目</td>
                        <td class="text">
                        <?php
                        if(_query("SELECT id FROM magacms_type LIMIT 1")){
                        $result=$_conn->query("SELECT id,name FROM magacms_type");
                        ?>
                        <select name="type">
                        <?php
                        while(!!$row2=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        ?><option value="<?php echo $row2['id'];?>"><?php echo $row2['name'];?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <?php
                        }else{
                        ?>
                        <select name="type"><option value="0" selected="selected">暂无栏目，请先添加栏目</option></select>
                        <?php
                        }
                        ?>
                    </td><td class="right">选择期刊所属栏目。</td></tr>
                    <tr><td class="left">发布时间</td><td class="text"><input readonly type="text" name="intime" value="<?php echo date('Y-m-d');?>" class="tcal"></td><td class="right">留空则自动生成当前日期。</td></tr>
                    <tr><td class="left">期刊缩略图</td><td class="text"><input readonly="true" type="text" name="photo"></td><td class="right"><a href="javascript:void(0);" class="upload" onclick="uploadbox('includes/upload.inc.php?input=photo&form=addmaga&dir=magaico&type=a&text=只允许上传jpg、jpeg、gif、png文件！',400,100);lock();">上传</a> 最佳尺寸206px×290px。</td></tr>
                    <tr><td class="left">期刊PDF</td><td class="text"><input readonly="true" type="text" name="pdf"></td><td class="right"><a href="javascript:void(0);" class="upload" onclick="uploadbox('includes/upload.inc.php?input=pdf&form=addmaga&dir=magapdf&type=b&text=只允许上传pdf文件！',400,100);lock();">上传</a> 提供pdf供读者下载。</td></tr>
                    <tr><td class="left">放大前尺寸</td><td class="mintext" ><input type="text" name="width" value="295">像素 ×<input class="px" type="text" name="height" value="450">像素</td><td class="right">阅读界面放大前的显示大小。</td></tr>
                    <tr><td class="left">放大后尺寸</td><td class="mintext" ><input type="text" name="mwidth" value="1000">像素 ×<input class="px" type="text" name="mheight" value="1430">像素</td><td class="right">阅读界面放大后的显示大小。</td></tr>
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