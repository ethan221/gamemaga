<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>新增栏目</title></block>
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
    if(getName('typename').value=='' || getName('typename').value.length < 2 || getName('typename').value.length > 10){
        art.dialog({
            content: '期刊名称必须为2~10位！'
        });
        return false;
    };
    if( getName('typesort').value < 0 || isNaN(getName('typesort').value) ){
        art.dialog({
            content: '期刊排序必须为大于0的数字！'
        });
        return false;
    };
    return true;
}
</script>
</block>
<block name="content">
 <div class="rightbox">
        <div class="title">新增期刊栏目</div>
        <form id='add-frm' action="" method="post">
            <div class="boxlist">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">栏目名称</td><td class="text"><input type="text" maxlength='10' name="typename"></td><td class="right">栏目名称必填，长度2-10位。</td></tr>
                    <tr><td class="left">栏目排序</td><td class="text"><input type="text" maxlength='2' name="typesort"></td><td class="right">栏目排序为空自动生成，数字越大排名越前。</td></tr>
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
                   var name = $('#add-frm input[name=typename]').val();
                   var sort = $('#add-frm input[name=typesort]').val();
                   $.ajax({
                          type:"POST",  
                          url:'/backend/topic/addAction',
                          data:{'typename':name, 'sort':sort}, 
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