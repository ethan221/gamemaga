<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>新增文章目录</title></block>
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
    if(getName('name').value=='' || getName('name').value.length < 2 || getName('name').value.length > 10){
        art.dialog({
            content: '目录名称必须为2~10位！'
        });
        return false;
    };
    if( getName('sort').value < 0 || isNaN(getName('sort').value) ){
        art.dialog({
            content: '目录排序必须为大于0的数字！'
        });
        return false;
    };
    return true;
}
</script>
</block>
<block name="content">
 <div class="rightbox">
        <div class="title">"<{$Think.get.topic}>" 新增文章目录</div>
        <form id='add-frm' action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">目录名称</td><td class="text"><input type="text" maxlength='10' name="name"></td><td class="right">名称必填，长度2-10位。</td></tr>
                    <tr><td class="left">目录排序</td><td class="text"><input type="text" maxlength='2' name="sort"></td><td class="right">排序为空自动生成，数字越大排名越前。</td></tr>
                    <tr><td colspan="3" class="submit"><input type="button" id='add-submit-btn' data-loading-text='正在提交'  value="提交">
                            <input type="button" value="返回" id="back-btn" onclick="exit_info('/backend/maga/edit?id=<{$Think.get.magaid}>');" />
                        </td></tr> 
                </table>
                <input type="hidden" value="<{$Think.get.magaid}>" name="magaid" /> 
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
                          url:'/backend/maga/cateaddAction',
                          data:$("#add-frm input[type=text],#add-frm input[type=hidden]"),
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
                                   $('#back-btn').trigger('click');
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