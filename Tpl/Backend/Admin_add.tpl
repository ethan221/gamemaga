<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>新增管理员</title></block>
<block name="cssjs_extent">
<link href="__PUBLIC__/admin/artDialog/skins/default.css" rel="stylesheet" type="text/css">
<script>
// skin demo
(function() {
	var _skin, _jQuery;
	var _search = window.location.search;
	if (_search) {
		_skin = _search.split('demoSkin=')[1];
		_jQuery = _search.indexOf('jQuery=true') !== -1;
		if (_jQuery) document.write('<scr'+'ipt src="__PUBLIC__/js/jquery/jquery-1.9.1.min.js"></sc'+'ript>');
	};
	
	document.write('<scr'+'ipt src="__PUBLIC__/admin/artDialog/artDialog.source.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
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
    if(getName('username').value.length <3 || getName('username').value.length >10 ){
        art.dialog({
            content: '用户名长度需为3~10位！'
        });
        return false;
    };
    if(getName('password').value=='' || getName('password2').value=='' ){
        art.dialog({
            content: '新密码、新密码确认不能为空！'
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
</block>
<block name="content">
 <div class="rightbox">
        <div class="title">新增管理员</div>
        <form id='add-frm' action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">用户名</td><td class="text"><input type="text" name="username"></td><td class="right">用户名必填，长度3-10位。</td></tr>
                    <tr><td class="left">密码</td><td class="text"><input type="password" maxlength='18' name="password"></td><td class="right">密码必填，长度5-18位。</td></tr>
                    <tr><td class="left">密码确认</td><td class="text"><input type="password" name="password2"></td><td class="right">重复输入以上密码。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="button" id='add-submit-btn' data-loading-text='正在提交'  value="提交"></td></tr>
                </table>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            //--/ edit /--
           $('#add-submit-btn').click(function(){
               if(validate_form()){
                   var user = $('#add-frm input[name=username]').val();
                   var pwd = $('#add-frm input[name=password]').val();
                   $.ajax({
                          type:"POST",  
                          url:'/backend/admin/addAction',
                          data:{'username':user, 'password':pwd}, 
                          dataType:'json',
                          beforeSend: function(){
                                $('#add-submit-btn').button('loading');
                          },
                          complete: function(){
                              $('#add-submit-btn').button('reset');
                          },
                          success: function(result){
                               jsonCheck(result);
                               if(result['success']){ 
                                   location.href = result['redirect'];
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
</block>