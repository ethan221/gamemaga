<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>期刊版面列表</title></block>
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
//-------------------------
function delpage(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '确定删除这个版面吗？',
        icon: 'warning',
        ok: function(){
                $.ajax({
                          type:"POST",  
                          url:'/backend/page/delAction',
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
        <div class="title" name="pagelist" id="pagelist">
            <div class="container-fluid pull-right">
                <a class="btn-link" href="/backend/page/add?categoryid=<{$Think.get.id}>&magaid=<{$Think.get.magaid}>&category=<{$cateinfo.name}>">
                    +添加文章
                </a>
            </div>
            "<{$cateinfo.name}>" 版面列表
        </div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>版面ID</th>
                <th>排序</th>
                <th>标题</th>
                <th>文章作者</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <empty name="pagelist">
            <tr>
                <td colspan="6">该期刊暂无版面！</td>
            </tr>
            <else />
                <volist name='pagelist' id='vo'>
                <tr>
                    <td><{$vo.id}></td>
                    <td><{$vo.sort}></td>
                    <td><{$vo.title}></td>
                    <td><{$vo.author}></td>
                    <td><{$vo.addtime}></td>
                    <td class="a" width="170px"><a href="javascript:void(0);" onClick="delpage('<{$vo.id}>');">删除</a><a href="/backend/page/edit?id=<{$vo.id}>">编辑</a></td>
                </tr>
                </volist>
            </empty>
           <tr>
               <td colspan="6"><input type="button"  value="返回" onclick="exit_info('/backend/maga/edit?id=<{$Think.get.magaid}>');" ></td>
            </tr>
            </table>
        </div>
    </div>

</block>