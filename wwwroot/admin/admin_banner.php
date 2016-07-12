<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$row=_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$picdir=$row['picdir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>幻灯配置</title>
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
function delbanner(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个幻灯图片吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delbanner&id='+ id
        },
        cancelVal: '取消',
        cancel: true
    });
}
function showPic(url,w,h){
    art.dialog({
		padding: 0,
        lock: true,
        title: 'Banner预览',
        width: w + 'px',
        height: h + 'px',
        content: '<img src='+url+'>',
        fixed: true
    });
}
function validate_form(){
    (function (config) {
        config['title'] = '错误';
        config['lock'] = true;
        config['fixed'] = true;
        config['time'] = 2;
        config['icon'] = 'error';
    })(art.dialog.defaults);
if(getName('photo').value==''){
    art.dialog({
        content: '必须上传一个banner图片才可以保存！'
    });
    return false;
};
if( isNaN(getName('sort').value)){
    art.dialog({
        content: 'Banner排序必须为数字！'
    });
    return false;
};
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">幻灯配置</div>
        <form action="?action=addbanner" method="post" name="banner" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">幻灯图片</td><td class="text"><input readonly type="text" name="photo"></td><td class="right"><a class="upload" href="javascript:void(0);" onclick="uploadbox('includes/upload.inc.php?input=photo&form=banner&dir=bannerpic&type=a&text=只允许上传jpg、jpeg、gif、png文件！',400,100);lock();">上传</a>最佳尺寸910px×350px。</td></tr>
                    <tr><td class="left">排序</td><td class="text"><input type="text" name="sort"></td><td class="right">设置该Banner图片的顺序，大的排前面。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="submit" value="提交"></td></tr>
                </table>
            </div>
        </form>
    </div>
    <div class="rightbox">
        <div class="title">幻灯图片列表（没上传图片的话自动调用“根目录/images/nobanner.png”图片）</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <?php
            $_pagesize=10;
            $_num=_mysqlnum("SELECT id FROM magacms_banner");
            require dirname(__FILE__).'/includes/PageHeader.inc.php';
            $result=$_conn->query("SELECT * FROM magacms_banner ORDER BY sort DESC LIMIT $_pagenum,$_pagesize");
            if(_query("SELECT * FROM magacms_banner")){
            ?>
            <tr>
                <th>ID</th>
                <th>排序</th>
                <th width="70px">调整排序</th>
                <th>Banner图片</th>
                <th>操作</th>
            </tr>
            <?php
            while(!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            ?>
            <tr <?php if($_GET['id']==$row['id']){?>class="sorted"<?php }?>>
                <td><?php echo $row['id'];?></td>
                <td>第<?php echo $row['sort'];?>个</td>
                <td><a class="sort_up" href="?action=upbannersort&id=<?php echo $row['id'];?>"></a><a class="sort_down" href="?action=downbannersort&id=<?php echo $row['id'];?>"></a></td>
                <td>../upload/bannerpic/<?php echo $row['photo'];?></td>
                <td class="a" width="170px"><a href="javascript:void(0);" onClick="delbanner('<?php echo $row['id'];?>')">删除</a><a href="javascript:void(0);" onclick="showPic('../upload/bannerpic/<?php echo $row['photo'];?>','910','350');">预览</a></td>
            </tr>
            <?php
            }
            ?>
            <?php
            }else{
            ?>
            <tr>
                <td>暂无Bannner图片！</td>
            </tr>
            <?php
            }
            $_conn->close();
            ?>
            </table>
            <?php
            require dirname(__FILE__).'/includes/PageBottom.inc.php';
            ?>
        </div>
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