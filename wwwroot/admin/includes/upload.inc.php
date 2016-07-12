<?php
header('content-Type:text/html;charset=UTF-8');
require '../../includes/other.fun.php';
require '../../includes/file.fun.php';
$input=$_GET['input'];
$form=$_GET['form'];
$dir=$_GET['dir'];
$text=$_GET['text'];
$type=$_GET['type'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>
<link href="../images/style_upfile.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    function input(url){
        window.opener.document.<?php echo $form;?>.<?php echo $input;?>.value=url;
    }
    window.onbeforeunload=function(){
            window.opener.unlock();
    }
</script>
</head>
<body>
<?php
if($_GET['action']=='upfile'){
    $input=$_GET['input'];
    $form=$_GET['form'];
    $dir=$_GET['dir'];
    $text=$_GET['text'];
    $type=$_GET['type'];
	if(!_isfolder('../../upload/'.$dir)){
		_folder('../../upload/'.$dir);
	}
	if(!_isfolder('../../upload/'.$dir)){
		echo '无法创建/upload/'.$dir.'文件夹，请检查权限！';
	}
    if($type=='a'){
        $filetype=array('image/png','image/jpeg','image/gif','image/pjpeg');
    }
    if($type=='b'){
        $filetype=array('application/pdf');
    }
    if($_FILES['file']['error']==4){
        function_alert('请选择需要上传的文件！', '');
    }
    if(!in_array($_FILES['file']['type'],$filetype)){
        function_alert('文件格式不支持！','');
    }
    if($_FILES['file']['error']==1){
        function_alert('文件大小超过PHP允许的大小限制！', '');
    }
    if($_FILES['file']['error']==3){
        function_alert('网络中断，请重新上传！', '');
    }
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
		if($_FILES['file']['type']=='image/png'){
			$filetype='png';
		}
		if($_FILES['file']['type']=='image/jpeg'){
			$filetype='jpg';
		}
		if($_FILES['file']['type']=='image/gif'){
			$filetype='gif';
		}
		if($_FILES['file']['type']=='image/pjpeg'){
			$filetype='jpeg';
		}
		if($_FILES['file']['type']=='application/pdf'){
			$filetype='pdf';
		}
        $filename=date('YmdHis').'.'.$filetype;
		?>
		<div class="upload"><img src="../images/loading.gif" /><p>数据处理中，请勿关闭此窗口……</p></div>
		<?php
        move_uploaded_file($_FILES['file']['tmp_name'],'../../upload/'.$dir.'/'.$filename);
        if($form!='addpage'){
        echo "<script>input('".$filename."');window.close();</script>";
        }else{
            echo "<script>input('".$filename."');window.opener.$form.submit();window.close();</script>";
        }
    }
}else{
?>
    <div class="file_box">
        <form action="?action=upfile&input=<?php echo $input;?>&form=<?php echo $form;?>&dir=<?php echo $dir;?>&text=<?php echo $text;?>&type=<?php echo $type;?>" method="post" enctype="multipart/form-data">
                    <input type="text" readonly name="file" id="file" class="txt" value="未选择文件"/>  
                    <input type="button" class="btn" value="浏览..." />
                    <input type="file" name="file" class="file" id="file" size="28" onchange="document.getElementById('file').value=this.value" />
                    <input type="submit" name="submit" class="btn" value="上传" />
            </form>
            <div class="info">注意：<?php echo $text;?></div>
    </div>
<?php
}
?>
</body>
</html>