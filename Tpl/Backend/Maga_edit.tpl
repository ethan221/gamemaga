<extend name="./../Tpl/Backend/base.tpl" />
<block name="title"><title>编辑期刊</title></block>
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
function upPic(){
    art.dialog({
        padding: 0,
        title: '上传版面文件到《<{$mageinfo['maganame']}>》',
        lock: true,
        width: '800px',
        height: '300px',
        content: '<iframe width=800 height=400 src="/backend/cfupload/magaupload?id=<{$mageinfo.id}>" frameborder=0 scrolling=no></iframe>'
    });
}

function showPic(url,w,h){
    art.dialog({
        padding: 0,
        lock: true,
        title: '版面预览',
        width: w + 'px',
        height: h + 'px',
        content: '<img src='+url+'>',
        fixed: true
    });
}

function validate_form(){
    (function (config) {
        config['title'] = '错误';
        config['lock'] = true;
        config['fixed'] = true;
        config['time'] = 2;
        config['icon'] = 'error';
        config['zIndex'] = '1000';
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
</script>
</block>
<block name="content">
    <div class="rightbox">
        <div class="title">编辑期刊“<{$magainfo.maganame}>”</div>
        <form method="post" name="editmaga" id="edit-frm">
            <div class="boxlist" style="height: 400px; overflow-y: scroll; border-bottom: 1px solid #ccc;">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="left">期刊名称</td><td class="text"><input type="text" name="maganame" value="<{$magainfo.maganame}>"></td><td class="right">期刊名称，长度2-18位。</td></tr>
                    <!-- <tr><td class="left">版面上传目录</td><td class="text"><input disabled type="text" name="picdir" value="/upload/<{$magainfo.picdir}>/"></td><td class="right">版面上传路径，系统自动生成。</td></tr> -->
                    <tr><td class="left">所属栏目</td>
                        <td class="text">
                        <select name="type">
                            <option value="">－请选择－</option>
                            <volist name="typelist" id="vo">
                                <option value="<{$vo['id']}>"><{$vo['name']}></option>
                            </volist>
                        </select>
                    </td>
                    <td class="right">选择期刊所属栏目。</td></tr>
                    <tr><td class="left">发布时间</td><td class="text"><input readonly type="text" name="intime" value="<{$magainfo.intime}>" class="tcal"></td><td class="right">留空则自动生成当前日期。</td></tr>
                    <tr><td class="left">期号+总刊号</td><td><span class="mintext">第<input type="text" placeholder="期号" name="issue" value="<if condition="$magainfo.issue neq '0'"><{$magainfo.issue}></if>" />期</span> + <span class="text">总刊号<input type="text" placeholder="总刊号" style="width:50%; display: inherit;" name="magasn" value="<{$magainfo.magasn}>" /></span><td class="right"></td></tr>
                    <tr>
                        <td class="left">期刊缩略图</td>
                        <td class="text" style="padding-top:5px;" valign="middle">
                            <input readonly type="text" name="photo" <if condition="$magainfo.photo eq ''">value="无缩略图"<else />value="<{$magainfo.photo}>"</if>>
                            <p style="text-align: center;">
                            <img width="50%" src="__PUBLIC__/../upload/magaico/<{$magainfo.photo}>" id="maga-photo" <if condition="$magainfo.photo eq ''">style="display:none;"</if> />
                            </p>
                        </td>
                        <td class="right"><a class="upload" href="javascript:void(0);" onclick="uploadbox('/backend/upload?type=magaphoto&callback=photoUploadDone', 400, 120);"><if condition="$magainfo.photo eq ''">上传<else />替换</if></a> 最佳尺寸206px×290px。</td></tr>
                    <tr>
                        <td class="left">卷首语</td>
                        <td class="text" style="padding-top:5px;color: #333;" valign="middle">
                            <textarea id="frontnotes" name="frontnotes" style="height: 120px; line-height: 21px; padding: 2px;"><{$magainfo.frontnotes}></textarea>
                        </td>
                        <td></td>
                    </tr>
                </table>
                    <input type="hidden" name="id" value="<{$magainfo.id}>" />
            </div>
            <div class="boxlist">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td colspan="3" class="submit"><input id="edit-submit-btn" type="button" value="提交"> <input type="button" value="返回" onclick="exit_info('/backend/maga');" /></td></tr>
            </table>
            </div>
        </form>
    </div>
    <!-------------- box2 -------------->
    <div class="rightbox">
        <div class="title" name="categorylist" id="categorylist">
            <div class="container-fluid pull-right">
                <a class="btn-link" href="/backend/maga/categoryadd?magaid=<{$magainfo.id}>&topic=<{$magainfo.maganame}>">
                    +添加目录
                </a>
            </div>
            版面目录列表
        </div>
        <div class="boxtext">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>序号</th>
                <th>排序</th>
                <th>目录名称</th>
                <th>文章篇数</th>
                <th>操作</th>
            </tr>
            <empty name="categorylist">
                <tr>
                    <td colspan="5">该期刊暂未添加版面目录！</td>
                </tr>
            <else />
                <tr>
                    <volist name="categorylist" id="vo">
                        <td><{$i}></td>
                        <td><{$vo.sort}></td>
                        <td><{$vo.name}></td>
                        <td><{$vo.pagetotal}></td>
                        <td class="a">
                        <a href="javascript:void(0);" onClick="delcategory('<{$vo.id}>')">删除</a>
                        <a href="/backend/page/categoryedit?id=<{$vo.id}>&magaid=<{$magainfo.id}>&topic=<{$vo.name}>">编辑</a>
                        </td>
                    </volist>
                </tr>
            </empty>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#edit-frm select[name=type]').val(<{$magainfo.typeid}>);
            //--/ edit /--
           $('#edit-submit-btn').click(function(){
               if(validate_form()){
                   $.ajax({
                          type:"POST",  
                          url:'/backend/maga/editAction',
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
                                        location.href = location.href;
                                    }, 1500);
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