<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增期刊</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
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
    if(getName('maganame').value=='' || getName('maganame').value.length < 2 || getName('maganame').value.length > 18){
        art.dialog({
            content: '期刊名称必须在2~18位！'
        });
        return false;
    };
   if(getName('frontnotes').value.length > 1024){
        art.dialog({
            content: '卷首语长度不得超过1024!'
        });
        return false;
    };
    return true;
}
//---------------------

</script>

</head>
<body style="margin: 8px;">

    <div class="rightbox">
        <div class="title">新增期刊</div>
        <form id="add-frm" enctype="multipart/form-data" action="" method="post" name="addmaga">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">期刊名称</td><td class="text"><input type="text" maxlength="18" name="maganame"></td><td class="right" id="rigth">期刊名称，长度2-18位。</td></tr>
                    <tr><td class="left">所属栏目</td>
                        <td class="text">
                            <select name="type">
                                <option value="">－请选择－</option>
                                <?php if(is_array($typelist)): $i = 0; $__LIST__ = $typelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['id']); ?>"><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <td class="right">选择期刊所属栏目。</td></tr>
                    <tr><td class="left">发布时间</td><td class="text"><input readonly type="text" name="intime" value="<?php echo (date('Y-m-d',time(date('Y-m-d g:i a',time())))); ?>" class="tcal"></td><td class="right">留空则自动生成当前日期。</td></tr>
                    <tr><td class="left">期号+总刊号</td><td><span class="mintext"><input type="text" placeholder="期号" name="issue" value="" /></span> + <span class="text"><input type="text" placeholder="总刊号" style="width:50%; display: inherit;" name="magasn" value="" /></span><td class="right"></td></tr>
                    <tr><td class="left">期刊缩略图</td><td class="text">
                            <input readonly="true" type="text" name="photo">
                            <p style="text-align: center;">
                            <img width="50%" src="" id="maga-photo" style="display:none;" />
                            </p>
                        </td>
                        <td class="right"><a href="javascript:void(0);" class="upload" onclick="uploadbox('/backend/upload?callback=photoUploadDone&type=magaphoto',400,120);">上传</a> 最佳尺寸206px×290px。</td></tr>
                    <tr>
                        <td class="left">卷首语</td>
                        <td class="text" style="padding-top:5px; color: #333;" valign="middle">
                            <textarea id="frontnotes" name="frontnotes" style="height: 120px; line-height: 21px; padding: 2px;"></textarea>
                        </td>
                        <td></td>
                    </tr>
                    <tr><td colspan="3" class="submit"><input type="button" id="add-submit-btn" value="提交"></td></tr>
                </table>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            //--/ edit /--
           $('#add-submit-btn').click(function(){
               if(validate_form()){
                   $.ajax({
                          type:"POST",  
                          url:'/backend/maga/addAction',
                          data:$('#add-frm input[type=\'text\'], #add-frm input[type=\'hidden\'],  #add-frm textarea, #add-frm select'),
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

</body>
</html>