<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$type=$_GET['type'];
if($type==''){
    //分页模块
    $_pagesize=10;
    $_num=_mysqlnum("SELECT id FROM magacms_maga");
    require dirname(__FILE__).'/includes/PageHeader.inc.php';
    //分页模块结束
    $result=$_conn->query("SELECT * FROM magacms_maga ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
}else{
    //分页模块
    $_pagesize=10;
    $_num=_mysqlnum("SELECT id FROM magacms_maga WHERE typeid='$type'");
    require dirname(__FILE__).'/includes/PageHeader.inc.php';
    //分页模块结束
    $result=$_conn->query("SELECT * FROM magacms_maga WHERE typeid='$type' ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>期刊列表</title>
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
function showPic(url,w,h){
    art.dialog({
        padding: 0,
        lock: true,
        title: '期刊封面预览',
        width: w + 'px',
        height: h + 'px',
        content: '<img src='+url+'>',
        fixed: true
    });
}
function delmaga(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '删除后会连同该期刊图片文件、<br/>评论等内容全部删除且不可恢复，<br/>确定删除这个期刊吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delmaga&id='+id;
        },
        cancelVal: '取消',
        cancel: true
    });
}
</script>
</head>
<body>
    <?php
    if($type!=''){
    $result2=$_conn->query("SELECT * FROM magacms_type WHERE id=".$type." LIMIT 1");
    $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
    ?>
    <div class="info"><span>提示：</span>当前显示的是“<b><?php echo $row2['name'];?></b>”栏目下的期刊。<a href="admin_maga.php"><img src="images/ico_text.png">返回全部期刊</a></div>
    <?php
    }
    ?>
    <div class="rightbox">
        <div class="title">期刊列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($type==''){
                $sql="SELECT id FROM magacms_maga";
            }else{
                $sql="SELECT id FROM magacms_maga WHERE typeid='$type'";
            }
            if(!!_query($sql)){
            ?>
            <tr>
                <th>期刊ID</th>
                <th>期刊缩略图</th>
                <th>期刊名称</th>
                <th>版面个数</th>
                <th>所属栏目</th>
                <th>添加日期</th>
                <th>操作</th>
            </tr>
            <?php
            while (!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            ?>
            <tr>
                <td width="60px"><?php echo $row['id'];?></td>
                <td width="120px" class="magaico"><?php if($row['photo']){?><img src="../upload/magaico/<?php echo $row['photo'];?>" onclick="showPic('../upload/magaico/<?php echo $row['photo'];?>','206','290');" /><?php }else{?><img src="../images/nopic.png" /><?php }?></td>
                <td><?php echo $row['maganame'];?> <?php if($row['pdf']){?><img src="images/ico_pdf.png" title="已上传PDF版"><?php }?></td>
                <td>共<b><?php echo _mysqlnum("SELECT id FROM magacms_page WHERE magaid=".$row['id']);?></b>个版面</td>
                <td width="100px">
                <?php
                    if(!_query("SELECT * FROM magacms_type WHERE id=".$row['typeid']." LIMIT 1")){
                        echo "<font color='#f00'>无效栏目</font>";
                    }else{
                    $result2=$_conn->query("SELECT * FROM magacms_type WHERE id=".$row['typeid']." LIMIT 1");
                    $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
                    echo "<a class='see' href='?type=".$row2['id']."'>".$row2['name']."</a>";
                    }
                ?>
                </td>
                <td><?php echo $row['intime'];?></td>
                <td width="166px" class="a"><a href="javascript:void(0);" onclick="delmaga('<?php echo $row['id'];?>')">删除</a><a href="admin_maga_edit.php?id=<?php echo $row['id'];?>">编辑</a></td>
            </tr>
            <?php
            }
            }else{
            ?>
            <tr>
                <td>期刊列表为空，请先新增期刊！</td>
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