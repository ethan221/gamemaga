<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$id=$_GET['id'];
if(!_query("SELECT * FROM magacms_maga WHERE id='$id'")){
        function_error('期刊不存在', '指定期刊不存在，无法进行编辑！', 'E013', '0');
}
$row=_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$picdir=$row['picdir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑期刊</title>
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
function upPic(){
    art.dialog({
		padding: 0,
        title: '上传版面文件到《<?php echo $row['maganame'];?>》',
        lock: true,
        width: '800px',
        height: '300px',
        content: '<iframe width=800 height=400 src=cfupload/admin_maga_upload.php?id=<?php echo $id; ?> frameborder=0 scrolling=no></iframe>'
    });
}
function delIco(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个缩略图封面吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delico&id='+ id
        },
        cancelVal: '取消',
        cancel: true
    });
}
function delPdf(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个PDF文件吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delpdf&id='+ id
        },
        cancelVal: '取消',
        cancel: true
    });
}
function showPic(url,w,h){
    art.dialog({
		padding: 0,
        lock: true,
        title: '版面预览',
        width: w + 'px',
        height: h + 'px',
        content: '<img src='+url+'>',
        fixed: true
    });
}
function delpage(id,id2){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个版面吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delpage&pid='+ id +'&id='+ id2
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
        <div class="title">编辑期刊“<?php echo $row['maganame'];?>”</div>
        <form action="?action=editmaga&id=<?php echo $id;?>" method="post" name="editmaga" onsubmit="return validate_form()">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">期刊名称</td><td class="text"><input type="text" name="maganame" value="<?php echo $row['maganame'];?>"></td><td class="right">期刊名称，长度2-18位。</td></tr>
                    <tr><td class="left">版面上传目录</td><td class="text"><input disabled type="text" name="picdir" value="../upload/<?php echo $row['picdir'];?>/"></td><td class="right">版面上传路径，系统自动生成。</td></tr>
                    <tr><td class="left">所属栏目</td>
                        <td class="text">
                        <?php
                        if(_query("SELECT id FROM magacms_type LIMIT 1")){
                        $result=$_conn->query("SELECT id,name FROM magacms_type");
                        ?>
                        <select name="type">
                        <?php
                        while(!!$row2=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        ?><option value="<?php echo $row2['id'];?>" <?php if($row2['id']==$row['typeid']){?>selected="selected"<?php }?>><?php echo $row2['name'];?></option>
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
                    <tr><td class="left">发布时间</td><td class="text"><input readonly type="text" name="intime" value="<?php echo $row['intime'];?>" class="tcal"></td><td class="right">留空则自动生成当前日期。</td></tr>
                    <tr><td class="left">期刊缩略图</td><td class="text"><input readonly type="text" name="photo" <?php if($row['photo']==''){?>value="无缩略图"<?php }else{?>value="<?php echo $row['photo'];?>"<?php }?>></td><td class="right"><a class="upload" href="javascript:void(0);" onclick="uploadbox('includes/upload.inc.php?input=photo&form=editmaga&dir=magaico&type=a&text=只允许上传jpg、jpeg、gif、png文件！',400,100);lock();"><?php if($row['photo']==''){?>上传<?php }else{?>替换<?php }?></a><?php if($row['photo']!=''){?><a class="del" href="javascript:void(0);" onClick="delIco(<?php echo $id;?>);">删除</a><?php }?> 最佳尺寸206px×290px。</td></tr>
                    <tr><td class="left">期刊PDF</td><td class="text"><input readonly type="text" name="pdf" <?php if($row['pdf']==''){?>value="无PDF文件"<?php }else{?>value="<?php echo $row['pdf'];?>"<?php }?>></td><td class="right"><a class="upload" href="javascript:void(0);" onclick="uploadbox('includes/upload.inc.php?input=pdf&form=editmaga&dir=magapdf&type=b&text=只允许上传pdf文件！',400,100);lock();"><?php if($row['pdf']==''){?>上传<?php }else{?>替换<?php }?></a><?php if($row['pdf']!=''){?><a class="del" href="javascript:void(0);" onClick="delPdf(<?php echo $id;?>)">删除</a><?php }?> 提供pdf供读者下载。</td></tr>
                    <tr><td class="left">放大前尺寸</td><td class="mintext" ><input type="text" name="width" value="<?php echo $row['width'];?>">像素 ×<input class="px" type="text" name="height" value="<?php echo $row['height'];?>">像素</td><td class="right">阅读界面放大前的显示大小。</td></tr>
                    <tr><td class="left">放大后尺寸</td><td class="mintext" ><input type="text" name="mwidth" value="<?php echo $row['mwidth'];?>">像素 ×<input class="px" type="text" name="mheight" value="<?php echo $row['mheight'];?>">像素</td><td class="right">阅读界面放大后的显示大小。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="submit" value="提交"> <input type="button" value="返回" onclick="exit_info('admin_maga.php');" /></td></tr>
                </table>
            </div>
        </form>
    </div>
    <div class="rightbox">
        <div class="title" name="pagelist" id="pagelist">版面列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <?php
			$w=$row['width'];
			$h=$row['height'];
            $_pagesize=10;
            $_num=_mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'");
            require dirname(__FILE__).'/includes/PageHeader.inc.php';
            $result=$_conn->query("SELECT * FROM magacms_page WHERE magaid='$id' ORDER BY sort ASC LIMIT $_pagenum,$_pagesize");
            if(_query("SELECT * FROM magacms_page WHERE magaid='$id'")){
            ?>
            <tr>
                <th>版面ID</th>
                <th>排序</th>
                <th width="70px">调整排序</th>
                <th>版面图片</th>
                <th>缩略图片</th>
                <th>图片容量</th>
                <th>操作</th>
            </tr>
            <?php
            while(!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            ?>
            <tr <?php if($_GET['pid']==$row['id']){?>class="sorted"<?php }?>>
                <td><?php echo $row['id'];?></td>
                <td>第<?php echo $row['sort'];?>页</td>
                <td><a class="sort_up" href="?action=upsort&id=<?php echo $id;?>&pid=<?php echo $row['id'];?>"></a><a class="sort_down" href="?action=downsort&id=<?php echo $id;?>&pid=<?php echo $row['id'];?>"></a></td>
                <td>../upload/<?php echo $picdir.'/'.$row['photo'];?></td>
                <td><?php if(_isfolder('../upload/'.$picdir.'/resize/'.$row['photo'])){ echo '存在';}else{ echo '<a href=?action=mphoto&id='.$id.'&pid='.$row['id'].'>生成</a>';}?></td>
                <td><?php echo _filesize('../upload/'.$picdir.'/'.$row['photo']);?></td>
                <td class="a" width="170px"><a href="javascript:void(0);" onClick="delpage('<?php echo $row['id'];?>','<?php echo $id;?>')">删除</a><a href="javascript:void(0);" onclick="showPic('<?php if(_isfolder('../upload/'.$picdir.'/resize/'.$row['photo'])){ echo '../upload/'.$picdir.'/resize/'.$row['photo'];}else{ echo '../upload/'.$picdir.'/'.$row['photo'];}?>','<?php echo $w; ?>','<?php echo $h; ?>');">预览</a></td>
            </tr>
            <?php
            }
            ?>
            <?php
            }else{
            ?>
            <tr>
                <td>该期刊暂未上传版面！</td>
            </tr>
            <?php
            }
            $_conn->close();
            ?>
            <tr><td  colspan="7" class="submit"><input type="button" value="上传" onclick="upPic();" /> 当前期刊版面图片容量共计：<b><?php echo _dirsize('../upload/'.$picdir.'/');?></b></td></tr>
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