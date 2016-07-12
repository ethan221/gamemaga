<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>编辑期刊</title></block>
<block name="cssjs_extent">
<link href="__PUBLIC__/admin/artDialog/skins/default.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/js/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/js/summernote/summernote.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/summernote/lang/summernote-zh-CN.js"></script>
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
</block>
<block name="content">
    <div class="rightbox">
        <div class="title"><{$pageinfo.title}></div>
        <form id='edit-frm' action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td>文章标题</td><td align="left"><span  class="text"><input type="text" maxlength='32' value='<{$pageinfo.title}>' name="title"></span></td><td>文章标题不能为空。</td></tr>
                    <tr><td>文章作者</td><td align="left"><span  class="text"><input type="text" maxlength='32' value='<{$pageinfo.author}>' name="author"></span></td><td>文章作者不能为空。</td></tr>
                    <tr><td>文章内容</td>
                        <td style="padding-top: 20px; width: 700px;">
                            <textarea class="summernote" name="content" id="page-content"><{$pageinfo.content}></textarea>
                        </td>
                        <td>文章内容不能为空。</td></tr>
                    <tr><td>文章排序</td><td align="left"><span  class="mintext"><input type="text" maxlength='2' value="<{$pageinfo.sort}>" name="sort"></span></td><td>栏目排序为空自动生成。</td></tr>
                    <tr><td colspan="3" class="submit">
                            <input type="button" id='edit-submit-btn' data-loading-text='正在提交'  value="提交">
                            <input type="button" id="back-btn"  value="返回" onclick="exit_info('/backend/page/categoryedit?id=<{$pageinfo.categoryid}>&magaid=<{$pageinfo.magaid}>');"></td></tr> 
                </table>
                <input type="hidden" name="id" value="<{$pageinfo.id}>" />
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#edit-frm select[name=type]').val(<{$magainfo.typeid}>);
            //--/ edit /--
           $('#edit-submit-btn').click(function(){
               if(validate_form()){
                   $.ajax({
                          type:"POST",  
                          url:'/backend/page/editAction',
                          data:$('#edit-frm input[type=\'text\'], #edit-frm input[type=\'hidden\'],  #edit-frm textarea, #edit-frm select'),
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
                                    setTimeout(function(){
                                        $('#back-btn').trigger('click');
                                    }, 1200);
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