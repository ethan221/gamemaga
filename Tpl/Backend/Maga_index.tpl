<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>期刊列表</title></block>
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
function showPic(url,w,h){
    art.dialog({
        padding: 0,
        lock: true,
        title: '期刊封面预览',
        width: w + 'px',
        height: h + 'px',
        content: '<img src='+url+'>',
        fixed: true
    });
}
function delmaga(id){
    art.dialog({
        lock: true,
        title: '确定删除',
        content: '删除后会连同该期刊图片文件、<br/>评论等内容全部删除且不可恢复，<br/>确定删除这个期刊吗？',
        icon: 'warning',
        ok: function(){
            $.ajax({
                          type:"POST",  
                          url:'/backend/maga/delAction',
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
    <if condition="$Think.get.typeid neq ''"><div class="info"><a href="/backend/maga"><img src="__PUBLIC__/admin/images/ico_text.png">返回全部期刊</a></div></if>
<div class="rightbox">
        <div class="title">期刊列表</div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>期刊ID</th>
                <th>期刊缩略图</th>
                <th>期刊名称</th>
                <th>版面个数</th>
                <th>所属栏目</th>
                <th>添加日期</th>
                <th>操作</th>
            </tr>
               <volist name="magalist" id="vo">
                <tr>
                        <td width="60px"><{$vo['id']}></td>
                        <td width="120px" class="magaico"><if condition="$vo.photo neq ''"><img src="__PUBLIC__/../upload/magaico/<{$vo['photo']}>" onclick="showPic('__PUBLIC__/../upload/magaico/<{$vo['photo']}>','412','580');"  /><else /><img src="__PUBLIC__/images/nopic.png" /></if></td>
               <td><{$vo['maganame']}><if condition="$vo.pdf neq ''"><img src="__PUBLIC__/admin/images/ico_pdf.png" title="已上传PDF版"></if></td>
                        <td width="100px"><{$vo['pagatotal']}></td>
                        <td><if condition="$vo.typename neq ''"><a class='see' href="/backend/maga?typeid=<{$vo.typeid}>"><{$vo['typename']}></a><else />-</if></td>
                        <td><{$vo['intime']}></td>
                        <td class="a" width="166px"><a href="javascript:void(0);" onClick="delmaga('<{$vo['id']}>');">删除</a><a href="/backend/maga/edit?id=<{$vo['id']}>">编辑</a></td>
                    </tr>
            </volist>
            </table>
            <div class="pager"><{$pageination}></div>
        </div>
    </div>

</block>