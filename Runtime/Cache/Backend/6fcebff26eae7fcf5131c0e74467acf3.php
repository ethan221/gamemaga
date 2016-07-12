<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员列表</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/admin/script.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //-----------------
    });
</script>
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
//-----------
function validate_form(){
    (function (config) {
        config['title'] = '错误';
        config['lock'] = true;
        config['fixed'] = true;
        config['time'] = 2;
        config['icon'] = 'error';
    })(art.dialog.defaults);
    if(getName('password').value=='' || getName('password2').value=='' ||  getName('passwordold').value=='' ){
        art.dialog({
            content: '原密码、新密码、新密码确认不能为空！'
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
    return true;
}
</script>

</head>
<body style="margin: 8px;">

 <div class="rightbox">
        <div class="title">编辑管理员“<?php echo ($userinfo['username']); ?>”</div>
        <form id="edit-frm" action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">用户名</td><td class="text"><input disabled type="text" name="username" value="<?php echo ($userinfo['username']); ?>"></td><td class="right">用户名不可更改。</td></tr>
                    <tr><td class="left">原始密码</td><td class="text"><input type="password" name="passwordold"></td><td class="right">请输入该管理员的旧密码。</td></tr>
                    <tr><td class="left">密码</td><td class="text"><input type="password" name="password"></td><td class="right">密码必填，长度5-18位。</td></tr>
                    <tr><td class="left">密码确认</td><td class="text"><input type="password" name="password2"></td><td class="right">重复输入以上密码。</td></tr>
                    <tr><td class="left">最后登录时间</td><td class="text"><input disabled type="text" name="intime" value="<?php echo ($userinfo['intime']); ?>"></td><td class="right">系统自动记录，无需修改。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="button" id="edit-submit-btn" data-loading-text='正在提交' value="提交">
                            <input type="button" value="返回" onclick="exit_info('/backend/admin');" /></td></tr>
                </table>
                    <input type="hidden" name="id" value="<?php echo ($userinfo['id']); ?>" />
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            //--/ edit /--
           $('#edit-submit-btn').click(function(){
               if(validate_form()){
                   var id = $('#edit-frm input[name=id]').val();
                   var pwdold = $('#edit-frm input[name=passwordold]').val();
                   var pwd = $('#edit-frm input[name=password2]').val();
                   $.ajax({
                          type:"POST",  
                          url:'/backend/admin/editAction',
                          data:{'id':id, 'password':pwd, 'passwordold':pwdold}, 
                          dataType:'json',
                          beforeSend: function(){
                                $('#edit-submit-btn').button('loading');
                          },
                          complete: function(){
                              $('#edit-submit-btn').button('reset');
                          },
                          success: function(result){
                               jsonCheck(result);
                               if(result['success']){ 
                                   art.dialog({
                                                content: '修改成功'
                                    });
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
               }
            });
        });
    </script>

</body>
</html>