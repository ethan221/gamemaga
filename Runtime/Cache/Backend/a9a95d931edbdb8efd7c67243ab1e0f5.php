<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增文章</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="/assets/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/admin/script.js"></script>
<!-- extent JS and CSS Includes -->

<link href="/assets/admin/artDialog/skins/default.css" rel="stylesheet" type="text/css">
<link href="/assets/admin/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="/assets/js/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/js/summernote/summernote.js"></script>
<script type="text/javascript" src="/assets/js/summernote/lang/summernote-zh-CN.js"></script>
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
    if(getName('title').value=='' || getName('title').value.length < 1 || getName('title').value.length > 32){
        art.dialog({
            content: '文章标题必须为1~32位！'
        });
        return false;
    };
    if(getName('author').value=='' || getName('author').value.length < 1 || getName('author').value.length > 10){
        art.dialog({
            content: '文章作者必须为1~10位！'
        });
        return false;
    };
    var desc = $('#page-content').summernote('code');
    if(desc==''){
        art.dialog({
            content: '文章内容不能为空！'
        });
        return false;
    };
    if( getName('sort').value < 0 || isNaN(getName('sort').value) ){
        art.dialog({
            content: '文章排序必须为大于0的数字！'
        });
        return false;
    };
    return true;
}
</script>

</head>
<body style="margin: 8px;">

 <div class="rightbox">
        <div class="title">"<?php echo ($_GET['category']); ?>" 新增文章</div>
        <form id='add-frm' action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td>文章标题</td><td align="left"><span  class="text"><input type="text" maxlength='32' name="title"></span></td><td>文章标题不能为空。</td></tr>
                    <tr><td>文章作者</td><td align="left"><span  class="text"><input type="text" maxlength='32' name="author"></span></td><td>文章作者不能为空。</td></tr>
                    <tr><td>文章内容</td>
                        <td style="padding-top: 20px; width: 700px;">
                            <textarea class="summernote" name="content" id="page-content"></textarea>
                        </td>
                        <td>文章内容不能为空。</td></tr>
                    <tr><td>文章排序</td><td align="left"><span  class="mintext"><input type="text" maxlength='2' name="sort"></span></td><td>栏目排序为空自动生成。</td></tr>
                    <tr><td colspan="3" class="submit">
                            <input type="button" id='add-submit-btn' data-loading-text='正在提交'  value="提交">
                            <input type="button" id="return-btn"  value="返回" onclick="exit_info('/backend/page/categoryedit?id=<?php echo ($_GET['categoryid']); ?>&magaid=<?php echo ($_GET['magaid']); ?>');"></td></tr> 
                </table>
                <input type="hidden" name="categoryid" value="<?php echo ($_GET['categoryid']); ?>" />
                <input type="hidden" name="magaid" value="<?php echo ($_GET['magaid']); ?>" />
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
                          url:'/backend/page/addAction',
                          data:$("#add-frm input[type=text], #add-frm input[type=hidden], #add-frm textarea"), 
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
                                   $('#return-btn').trigger('click');
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

<script type="text/javascript" src="/assets/admin/filemanager.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //-----------------
       
    });
</script>
</body>
</html>