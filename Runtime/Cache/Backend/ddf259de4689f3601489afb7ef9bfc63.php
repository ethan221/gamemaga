<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员列表</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="/assets/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/admin/script.js"></script>
<!-- extent JS and CSS Includes -->

<link href="/assets/admin/artDialog/skins/default.css" rel="stylesheet" type="text/css">
<script>
// skin demo
(function() {
	var _skin, _jQuery;
	var _search = window.location.search;
	if (_search) {
		_skin = _search.split('demoSkin=')[1];
		_jQuery = _search.indexOf('jQuery=true') !== -1;
		if (_jQuery) document.write('<scr'+'ipt src="/assets/js/jquery/jquery-1.9.1.min.js"></sc'+'ript>');
	};
	
	document.write('<scr'+'ipt src="/assets/admin/artDialog/artDialog.source.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
	window._isDemoSkin = !!_skin;
})();
function deluser(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个管理员吗？',
        icon: 'warning',
        ok: function(){

                  $.ajax({
                          type:"POST",  
                          url:'/backend/admin/delAction',
                          data:{'id':id}, 
                          dataType:'json',
                          success: function(result){
                               jsonCheck(result);
                               if(result['success']){ 
                                   location.href =  location.href;
                               } else{
                                           art.dialog({
                                                content: result['msg']
                                            });
                               }
                          },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            alert("Details0: " + desc + "\nError:" + err);
                        }
                  });
            
        },
        cancelVal: '取消',
        cancel: true
    });
}
</script>

</head>
<body style="margin: 8px;">

<div class="rightbox">
        <div class="title">管理员列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>管理员ID</th>
                <th>用户名</th>
                <th>最后登录时间</th>
                <th>最后登录IP</th>
                <th>操作</th>
            </tr>
               <?php if(is_array($adminlist)): $i = 0; $__LIST__ = $adminlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td width="60px"><?php echo ($vo['id']); ?></td>
                        <td><?php echo ($vo['username']); ?></td>
                        <td><?php echo ($vo['intime']); ?></td>
                        <td><?php echo ($vo['inip']); ?></td>
                        <td class="a" width="166px"><a href="javascript:void(0);" onClick="deluser('<?php echo ($vo['id']); ?>');">删除</a><a href="/backend/admin/edit?id=<?php echo ($vo['id']); ?>">编辑</a></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
                        <div class="pager"><?php echo ($pageination); ?></div>
        </div>
    </div>


<script type="text/javascript" src="/assets/admin/filemanager.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //-----------------
       
    });
</script>
</body>
</html>