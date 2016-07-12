<?php
require dirname(dirname(__FILE__)) . '/includes/global.fun.php';
function_safety();
$id = $_GET['id'];
if (!_query("SELECT * FROM magacms_maga WHERE id='$id'")) {
    function_alert('期刊不存在或者已经被删除！', '');
}
$row = _query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$maganame = $row['maganame'];
$picdir = $row['picdir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>版面上传 - <?php echo $maganame; ?></title>
<link href="../images/style.css" rel="stylesheet" type="text/css">
</head>
<body style="margin: 0;">
<script language="javascript">
    function challs_flash_update() {
        var a = {};
        a.title = "选择图片";
        a.FormName = "Filedata";
        a.url = "cfupload.php";
        a.parameter = "id=<?php echo $id; ?>";
        a.typefile = ["Images (*.gif,*.png,*.jpg,*jpeg)", "*.gif;*.png;*.jpg;*.jpeg;",
            "GIF (*.gif)", "*.gif;",
            "PNG (*.png)", "*.png;",
            "JPEG (*.jpg,*.jpeg)", "*.jpg;*.jpeg;"];
        a.newTypeFile = ["Images (*.gif,*.png,*.jpg,*jpeg)", "*.gif;*.png;*.jpg;*.jpeg;", "JPE;JPEG;JPG;GIF;PNG",
            "GIF (*.gif)", "*.gif;", "GIF",
            "PNG (*.png)", "*.png;", "PNG",
            "JPEG (*.jpg,*.jpeg)", "*.jpg;*.jpeg;", "JPE;JPEG;JPG"];
        a.UpSize = 0;
        a.fileNum = 0;
        a.size = 5; //上传限制MB
        a.FormID = [];
        a.autoClose = 1;
        a.CompleteClose = true;
        a.repeatFile = true;
        a.returnServer = true;
        a.MD5File = 0;
        a.loadFileOrder = true;
        a.mixFileNum = 0;
        a.ListShowType = 2;
        a.InfoDownRight = "";
        a.TitleSwitch = false;
        a.ForceFileNum = 0;
        a.autoUpload = false;
        a.adjustOrder = true;
        a.deleteAllShow = true
        a.language = 0;
        a.countData = true;
        a.isShowUploadButton = true;
        return a;
    }

    function challs_flash_onComplete(a) {
        var name = a.fileName;
        var size = a.fileSize;
        var time = a.updateTime;
        var type = a.fileType;
        var creationDate = a.fileCreationDate;
        var modificationDate = a.fileModificationDate;
        //document.getElementById('showinfo').innerHTML += name + '，' + size + '字节，文件类型：' + type + '，用时 ' + (time / 1000) + '秒<br>'
    }

    function challs_flash_onCompleteData(a) {
        //document.getElementById('showinfo').innerHTML += '<p><b>服务器反馈：</b></p>' + a;
    }

    function challs_flash_onStart(a) {
        var name = a.fileName;
        var size = a.fileSize;
        var type = a.fileType;
        var creationDate = a.fileCreationDate;
        var modificationDate = a.fileModificationDate;
        //document.getElementById('showinfo').innerHTML += '<p><span>' + name + '</span>开始上传！</p>';
        return true;
    }

    function challs_flash_onStatistics(a) {
        var uploadFile = a.uploadFile;
        var overFile = a.overFile;
        var errFile = a.errFile;
    }

    function challs_flash_alert(a) {
        //document.getElementById('showinfo').innerHTML += '<p><b>组件提示：</b></p>' + a;
    }

    function challs_flash_onCompleteAll(a) {
        //document.getElementById('showinfo').innerHTML += '<p>所有文件上传完毕，上传失败<span>' + a + '</span>个，3秒后自动返回！</p>';
//        setTimeout(function(){
//            //window.location.href = '../admin_maga_edit.php?id=<?php echo $id; ?>';
//            art.dialog.close();
//        },'1000');
        parent.location.href = '../admin_maga_edit.php?id=<?php echo $id; ?>&info=版面上传完成！&icon=succeed#pagelist';
    }
    function challs_flash_onSelectFile(a) {
        //document.getElementById('showinfo').innerHTML += '<p>文件选择完成，等待上传文件<span>' + a + '</span>个，您可以拖动列表图片进行排序！</p>';
    }

    function challs_flash_deleteAllFiles() {
        return confirm("你确定要清空列表吗？");
    }

    function challs_flash_onError(a) {
        var err = a.textErr;
        var name = a.fileName;
        var size = a.fileSize;
        var type = a.fileType;
        var creationDate = a.fileCreationDate;
        var modificationDate = a.fileModificationDate;
       // document.getElementById('showinfo').innerHTML += '<p><span>' + name + ' - ' + err + '</span></p>';
    }

    function challs_flash_FormData(a) {
        try {
            var value = '';
            var id = document.getElementById(a);
            if (id.type == 'radio') {
                var name = document.getElementsByName(id.name);
                for (var i = 0; i < name.length; i++) {
                    if (name[i].checked) {
                        value = name[i].value;
                    }
                }
            } else if (id.type == 'checkbox') {
                var name = document.getElementsByName(id.name);
                for (var i = 0; i < name.length; i++) {
                    if (name[i].checked) {
                        if (i > 0)
                            value += ",";
                        value += name[i].value;
                    }
                }
            } else if (id.type == 'select-multiple') {
                for (var i = 0; i < id.length; i++) {
                    if (id.options[i].selected) {
                        if (i > 0)
                            value += ",";
                        values += id.options[i].value;
                    }
                }
            } else {
                value = id.value;
            }
            return value;
        } catch (e) {
            return '';
        }
    }

    function challs_flash_style() {
        var a = {};

        /*  整体背景颜色样式 */
        a.backgroundColor = ['#ffffff', '#ffffff', '#ffffff'];	//颜色设置，3个颜色之间过度
        a.backgroundLineColor = '#ffffff';					//组件外边框线颜色
        a.backgroundFontColor = '#066AD1';					//组件最下面的文字颜色
        a.backgroundInsideColor = '#FFFFFF';					//组件内框背景颜色
        a.backgroundInsideLineColor = ['#e5edf5', '#34629e'];	//组件内框线颜色，2个颜色之间过度
        a.upBackgroundColor = '#ffffff';						//上翻按钮背景颜色设置
        a.upOutColor = '#000000';								//上翻按钮箭头鼠标离开时颜色设置
        a.upOverColor = '#FF0000';							//上翻按钮箭头鼠标移动上去颜色设置
        a.downBackgroundColor = '#ffffff';					//下翻按钮背景颜色设置
        a.downOutColor = '#000000';							//下翻按钮箭头鼠标离开时颜色设置
        a.downOverColor = '#FF0000';							//下翻按钮箭头鼠标移动上去时颜色设置

        /*  头部颜色样式 */
        a.Top_backgroundColor = ['#e0eaf4', '#bcd1ea']; 		//颜色设置，数组类型，2个颜色之间过度
        a.Top_fontColor = '#245891';							//头部文字颜色

        /*  按钮颜色样式 */
        a.button_overColor = ['#FBDAB5', '#f3840d'];			//鼠标移上去时的背景颜色，2个颜色之间过度
        a.button_overLineColor = '#e77702';					//鼠标移上去时的边框颜色
        a.button_overFontColor = '#ffffff';					//鼠标移上去时的文字颜色
        a.button_outColor = ['#ffffff', '#dde8fe']; 			//鼠标离开时的背景颜色，2个颜色之间过度
        a.button_outLineColor = '#91bdef';					//鼠标离开时的边框颜色
        a.button_outFontColor = '#245891';					//鼠标离开时的文字颜色

        /* 文件列表样式 */
        a.List_scrollBarColor = "#000000"						//列表滚动条颜色
        a.List_backgroundColor = '#EAF0F8';					//列表背景色
        a.List_fontColor = '#333333';							//列表文字颜色
        a.List_LineColor = '#B3CDF1';							//列表分割线颜色
        a.List_cancelOverFontColor = '#ff0000';				//列表取消文字移上去时颜色
        a.List_cancelOutFontColor = '#D76500';				//列表取消文字离开时颜色
        a.List_progressBarLineColor = '#B3CDF1';				//进度条边框线颜色
        a.List_progressBarBackgroundColor = '#D8E6F7';		//进度条背景颜色	
        a.List_progressBarColor = ['#FFCC00', '#FFFF00'];		//进度条进度颜色，2个颜色之间过度

        /* 错误提示框样式 */
        a.Err_backgroundColor = '#C0D3EB';					//提示框背景色
        a.Err_fontColor = '#245891';							//提示框文字颜色
        a.Err_shadowColor = '#000000';						//提示框阴影颜色

        return a;
    }
    var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
    function thisMovie(movieName) {
        if (isMSIE) {
            return window[movieName];
        } else {
            return document[movieName];
        }
    }
    </script>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="100%" height="300" id="update" align="middle">
        <param name="allowFullScreen" value="false" />
        <param name="allowScriptAccess" value="always" />
        <param name="movie" value="update.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="update.swf" quality="high" bgcolor="#ffffff" width="100%" height="300" name="update" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
    </object>
</body>
</html>