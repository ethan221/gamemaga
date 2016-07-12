<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录 - 电子竞技后台管理系统</title>
<link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/admin/script.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#login-submit-btn').click(function(){
                 var username = $('#login-frm input[name=username]').val();
                 var password = $('#login-frm input[name=password]').val();
                 var code = $('#login-frm input[name=code]').val();
                 if(username==''){
                     alert('用户名不能为空');
                     return false;
                 }   
                 if(password==''){
                     alert('密码不能为空');
                     return false;
                 }
                 if(code==''){
                     alert('验证码不能为空');
                     return false;
                 }
                 $.ajax({
                          type:"POST",  
                          url:'/backend/index/login',
                          data:{'username':username, 'password':password, 'code':code}, 
                          dataType:'json',
                          beforeSend: function(){
                                $('#login-submit-btn').button('loading');
                          },
                          complete: function(){
                              $('#login-submit-btn').button('reset');
                          },
                          success: function(result){
                               jsonCheck(result);
                               if(result['success']){ 
                                   window.location.href = result['redirect'];
                               } else{
                                   $('#verify-code').attr('src', '/backend/index/getverify?v='+new Date().getTime());
                                   $('#login-return-msg').html('<div class="text-danger">' + result.msg + '</div>');
                               }
                          },
                        error: function(xhr, desc, err) {
                            console.log(xhr);
                            alert("Details0: " + desc + "\nError:" + err);
                        }
                  });
        });
        
        //-----------------
    });
</script>
</head>

<body style="background:url(__PUBLIC__/admin/images/bg_login_big.png) 50% 50% ;background-position:center;background-repeat: no-repeat;background-attachment: fixed;}">
<div id="login">
    <div class="login">
    <div class="title">管理员登录</div>
    <form id="login-frm" action="/backend/index/login" method="post">
        <dl><dt>管理员：</dt><dd><input type="text" maxlength="16" name="username" /></dd></dl>
        <dl><dt>密码：</dt><dd><input type="password" maxlength="16" name="password" /></dd></dl>
        <dl><dt>验证码：</dt><dd><input class="code" type="text" maxlength="4" name="code" /><a href="" title="点击刷新验证码"><img id="verify-code" src="/backend/index/getverify"/></a></dd></dl>
        <dl class="submit" ><input type="button" id="login-submit-btn" data-loading-text="正在登录" value="登录" /></dl><br />
        <div style="clear:both;" id="login-return-msg"></div>
    </form>
    </div>
    
</div>
</body>
</html>