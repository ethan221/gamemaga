<?php require_once dirname(__file__) . '/includes/global.fun.php'; function_safety(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>冗余文件检测</title>
<link href="images/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="images/script.js"></script>
<script language="javascript" src="images/ajax.js"></script>
<link href="artDialog/skins/default.css" rel="stylesheet" type="text/css">
<script language="javascript">
// skin demo
(function() {
    var _skin, _jQuery;
    var _search = window.location.search;
    if (_search) {
            _skin = _search.split('demoSkin=')[1];
            _jQuery = _search.indexOf('jQuery=true') !== -1;
            if (_jQuery) document.write('<scr'+'ipt src="../jquery-1.6.2.min.js"></sc'+'ript>');
    };
    document.write('<scr'+'ipt src="artDialog/artDialog.source.js?skin=' + (_skin || 'default') +'"></sc'+'ript>');
    window._isDemoSkin = !!_skin;	
})();
window.onload = function(){
    loadXMLDoc("../includes/ajax.inc.php?action=ryfile&t=" + Math.random(), "ryfile");
} 
</script>
</head>
<body>
    <div class="rightbox">
            <div class="title">冗余文件检测</div>
            <div class="boxtext" id="ryfile">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="news"><img src="images/loading_2.gif" /> 正在检测冗余文件，请稍后……</td></tr>
                </table>
            </div>
    </div>
    <?php function_copyright();?>
    <?php if($_GET['info']!=''){ ?>
    <script language="javascript">
    art.dialog({
        title: '提示',
        icon: '<?php echo $_GET['icon']; ?>',
        lock: true,
        time: 2,
        content: '<?php echo $_GET['info']; ?>',
        fixed: 'true'
    });
    </script>
    <?php } ?>
</body>
</html>