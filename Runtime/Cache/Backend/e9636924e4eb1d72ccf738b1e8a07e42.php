<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/style.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/style_upfile.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/assets/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/admin/script.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //-----------------
        $("#inputfile").change(function(){
                //创建FormData对象
                var data = new FormData();
                //为FormData对象添加数据
                $.each($('#inputfile')[0].files, function(i, file) {
                    data.append('upload_file', file);
                });
                data.append('type', '<?php echo ($_GET['type']); ?>');
                $.ajax({
                    url:'/backend/upload/imgsave',
                    type:'POST',
                    data:data,
                    cache: false,
                    contentType: false,    //不可缺
                    processData: false,    //不可缺
                    success:function(data){
                           if(data['success']){
                                var callback = $('#callback').val();
                                if(callback!=''){
                                    operCallback(callback, data);
                                }
                                window.close();
                            }else{
                                alert(data['msg']);
                            }
                    }
                });
        });
    });
    //=======================
    function operCallback(callbackName, data){
        window.opener.uploadCallback(callbackName, data);
    }
    window.onbeforeunload=function(){
            window.opener.unlock();
    }
</script>
</head>
<body>
    <div class="file_box">
        <form id='upload-frm' action="" method="post" enctype="multipart/form-data">
                    <input type="text" readonly name="file" id="file" class="txt" value="未选择文件"/> 
                    <input type="button" class="btn" value="浏览..." />
                    <input type="file" name="file" class="file" id="inputfile" size="28" onchange="document.getElementById('file').value=this.value" />
                    <input type="button" name="submit" class="btn" value="上传" />
                    <input type="hidden" id='callback' value="<?php echo ($_GET['callback']); ?>" />
            </form>
    </div>
</body>
</html>