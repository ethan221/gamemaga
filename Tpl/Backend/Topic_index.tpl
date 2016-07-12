<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>栏目列表</title></block>
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
//==================================
function deltype(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个期刊栏目吗？',
        icon: 'warning',
        ok: function(){
                  $.ajax({
                          type:"POST",  
                          url:'/backend/topic/delAction',
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
</block>
<block name="content">
<div class="rightbox">
        <div class="title">栏目列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>栏目ID</th>
                <th>栏目名称</th>
                <th>期刊数量</th>
                <th>栏目排序</th>
                <th>操作</th>
            </tr>
               <volist name="topiclist" id="vo">
                <tr>
                        <td width="60px"><{$vo['id']}></td>
                        <td><{$vo['name']}></td>
                        <td><{$vo['total']}></td>
                        <td><{$vo['sort']}></td>
                        <td class="a" width="166px"><a href="javascript:void(0);" onClick="deltype('<{$vo['id']}>');">删除</a><a href="/backend/topic/edit?id=<{$vo['id']}>">编辑</a></td>
                    </tr>
            </volist>
            </table>
            <div class="pager"><{$pageination}></div>
        </div>
    </div>

</block>