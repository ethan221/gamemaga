<?php
require dirname(__FILE__).'/includes/global.fun.php';
function_safety();
$_pagesize=10;
$_num=_mysqlnum("SELECT id FROM magacms_type");
require dirname(__FILE__).'/includes/PageHeader.inc.php';
$result=$_conn->query("SELECT * FROM magacms_type ORDER BY sort DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目列表</title>
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
function deltype(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个期刊栏目吗？',
        icon: 'warning',
        ok: function(){
            window.location.href = '?action=deltype&id='+id;
        },
        cancelVal: '取消',
        cancel: true
    });
}
</script>
</head>
<body>
    <div class="rightbox">
        <div class="title">栏目列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <?php
            if(!!_query("SELECT id FROM magacms_type")){
            ?>
            <tr>
                <th>栏目ID</th>
                <th>栏目名称</th>
                <th>期刊数量</th>
                <th>栏目排序</th>
                <th>操作</th>
            </tr>
            <?php
            while (!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            ?>
            <tr>
                <td width="60px"><?php echo $row['id'];?></td>
                <td width="100px"><a class='see' href="admin_maga.php?type=<?php echo $row['id'];?>"><?php echo $row['name'];?></a></td>
                <td>共<b><?php echo _mysqlnum("SELECT id FROM magacms_maga WHERE typeid=".$row['id']);?></b>个期刊</td>
                <td><?php echo $row['sort'];?></td>
                <td class="a" width="166px"><a href="javascript:void(0)" onClick="deltype('<?php echo $row['id'];?>')">删除</a><a href="admin_type_edit.php?id=<?php echo $row['id'];?>">编辑</a></td>
            </tr>
            <?php
            }
            }else{
            ?>
            <tr>
                <td>栏目列表为空！</td>
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
        fixed: 'true'
    });
    </script>
    <?php } ?>
</body>
</html>