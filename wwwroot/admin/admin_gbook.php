<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$_pagesize=10;
$_num=_mysqlnum("SELECT id FROM magacms_gbook");
require dirname(__FILE__).'/includes/PageHeader.inc.php';
$result=$_conn->query("SELECT * FROM magacms_gbook ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论列表</title>
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
function delgbook(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这条评论吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=delgbook&id='+id;
        },
        cancelVal: '取消',
        cancel: true
    });
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">评论列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
                <?php 
                if(_query("SELECT id FROM magacms_gbook")){
                ?>
            <tr>
                <th width="40px">ID</th>
                <th width="120px">所属期刊</th>
                <th width="80px">评论者</th>
                <th>评论内容</th>
                <th width="100px">评论时间</th>
                <th width="100px">评论IP</th>
                <th>操作</th>
            </tr>
            <?php
            while (!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            ?>
            <tr>
                <td><?php echo $row['id'];?></td>
                <?php
                $magaid=$row['magaid'];
                $row2=_query("SELECT id,maganame FROM magacms_maga WHERE id='$magaid'");
                ?>
                <td><?php echo $row2['maganame'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['text'];?></td>
                <td><?php echo $row['time'];?></td>
                <td><?php echo $row['ip'];?></td>
                <td class="a" width="83px"><a href="javascript:void(0);" onClick="delgbook(<?php echo $row['id'];?>);">删除</a></td>
            </tr>
            <?php
            }
            $_conn->close();
                }else{
            ?>
                <tr><td>暂无评论！</td></tr>
                <?php } ?>
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
        fixed: 'true'
    });
    </script>
    <?php } ?>
</body>
</html>