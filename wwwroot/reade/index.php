<?php
header('content-Type:text/html;charset=UTF-8');
require dirname(dirname(__FILE__)).'/includes/main.inc.php';
$id=$_GET['id'];
if(!_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1")){
    function_error('指定期刊不存在', '期刊ID非法，指定期刊不存在！', 'E009', 'index.php');
    exit();
}
$system=_query("SELECT * FROM magacms_system LIMIT 1");
$adtime=$system['adtime'];
$adphoto=$system['adphoto'];
$adlink=$system['adlink'];
$gbook=$system['gbook'];
$rewrite=$system['rewrite'];
if($rewrite==0){
    $magaurl[0]='?id=';
    $magaurl[1]='';
}else{
    $magaurl[0]='maga_';
    $magaurl[1]='.html';
}
$typeinfo=_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$typeid=$typeinfo['typeid'];
$typeinfo=_query("SELECT * FROM magacms_type WHERE id='$typeid' LIMIT 1");
$typename=$typeinfo['name'];

$siteinfo=_query("SELECT * FROM magacms_siteinfo");
$row=_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$name=$row['maganame'];
$picdir=$row['picdir'];
$intime=$row['intime'];
$width=$row['width'];
$height=$row['height'];
$mwidth=$row['mwidth'];
$mheight=$row['mheight'];
$pdf=$row['pdf'];
if(!_query("SELECT * FROM magacms_page WHERE magaid='$id'")){
    function_error('期刊无版面', '该期刊暂未上传版面，无法进行阅读！', 'E008', 'index.php');
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $name;?> - <?php echo $typename;?> - <?php echo $siteinfo['sitename'];?> - Powered by Wwzzs.com!</title>
<link href="images/liquid-green.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script/liquid.js"></script>
<script type="text/javascript" src="script/swfobject.js"></script>
<script type="text/javascript" src="script/flippingsettings.js"></script>
<script type="text/javascript" src="script/flippingbook.js"></script>
<script type="text/javascript" src="script/script.js"></script>
<script>
window.onload=function(){
    if(getCookie("showad")=='1'){
         CloseId("showad");
    }else{
        setTimeout("CloseId('showad','0');",<?php echo $adtime; ?>*1000);
    }
}
</script>
</head>
<body>
<script>
flippingBook.pages = [
    <?php
    $result=$_conn->query("SELECT * FROM magacms_page WHERE magaid='$id' ORDER BY sort ASC");
    $num=_mysqlnum("SELECT * FROM magacms_page WHERE magaid='$id'");
    while(!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $i++;
        if(_isfolder('../upload/'.$picdir.'/resize/'.$row['photo'])){
    ?>
    "../upload/<?php echo $picdir."/resize/".$row['photo']?>"<?php if($i!=$num){ ?>,<?php }?>
    <?php }else{ ?>
    "../upload/<?php echo $picdir."/".$row['photo']?>"<?php if($i!=$num){ ?>,<?php }?>
    <?php } } ?>
];
flippingBook.contents = [
    [ "首版",1],
    <?php
    $i=0;
    $result=$_conn->query("SELECT * FROM magacms_page WHERE magaid='$id' ORDER BY sort ASC");
    while(!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $i++;
    if($i%2==0 && $i+1<$num){?>[ "<?php echo $i;?>-<?php echo $i+1;?>版",<?php echo $i;?>],<?php }} ?>
    [ "尾版",<?php echo $num;?>]
];
flippingBook.settings.bookWidth = <?php echo 2*$width;?>;
flippingBook.settings.backgroundImage = "images/1a.jpg";
flippingBook.settings.bookHeight = <?php echo $height;?>;
flippingBook.settings.zoomPath = "../upload/<?php echo $picdir;?>/";
flippingBook.settings.zoomImageWidth = <?php echo $mwidth;?>;
flippingBook.settings.zoomImageHeight = <?php echo $mheight;?>;
flippingBook.settings.downloadURL = "<?php echo '../upload/magapdf/'.$pdf;?>";
flippingBook.settings.downloadSize = "大小：<?php echo _filesize('../upload/magapdf/'.$pdf);?>";
flippingBook.create();
</script>
<div id="fbContainer">
<a class="altlink" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"><div id="altmsg">Download Adobe Flash Player.</div></a>
</div>
<div id="fbFooter">
    <div id="fbContents">
        <span class="texts">目录：</span>
        <select id="fbContentsMenu" name="fbContentsMenu"></select>
        <span class="texts">版面：</span>
        <span id="fbCurrentPages">1</span>
        <span id="fbTotalPages"></span>
        <span class="texts">名称：</span>
        <span class="text">《<?php echo $name;?>》</span>
        <span class="texts">栏目：</span>
        <span class="text"><?php echo $typename;?></span>
        <span class="texts">时间：</span>
        <span class="text"><?php echo $intime;?></span>
    </div>
    <div id="fbMenu">
        <a href="../"><img src="images/btnIndex.gif" width="36" height="40" border="0" title="返回首页"/></a>
        <?php if($gbook==1){ ?><a href="javascript:void(0);" onclick="gbook();"><img id="gbookimg" src="images/btnGbook.gif" width="36" height="40" border="0" title="评论"/></a><?php } ?>
        <img src="images/btnDiv.gif" width="13" height="40" border="0" />
        <img src="images/btnZoom.gif" width="36" height="40" border="0" id="fbZoomButton" title="缩放"/>
        <img src="images/btnPrint.gif" width="36" height="40" border="0" id="fbPrintButton" title="打印" />
        <?php if(!!$pdf){ ?>
        <img src="images/btnDownload.gif" width="36" height="40" border="0" id="fbDownloadButton" title="下载PDF版"/>
        <?php }else{ ?>
        <img src="images/btnDownload_2.gif" width="36" height="40" border="0" title="本期无PDF版"/>
        <?php } ?>
        <img src="images/btnDiv.gif" width="13" height="40" border="0" />
        <img src="images/btnPrevious.gif" width="36" height="40" border="0" id="fbBackButton" title="上一页" />
        <img src="images/btnNext.gif" width="36" height="40" border="0" id="fbForwardButton" title="下一页" />
        <img src="images/btnDiv.gif" width="13" height="40" border="0" />
        <?php if($row=_query("SELECT id FROM magacms_maga WHERE id<'$id' ORDER BY id DESC LIMIT 1")){ ?>
        <a href="<?php echo $magaurl[0]; ?><?php echo $row['id']; ?><?php echo $magaurl[1]; ?>"><img src="images/btnPrevious_2.gif" width="36" height="40" border="0" title="上一期" /></a>
        <?php
        }else{
        ?>
        <img src="images/btnPrevious_2_2.gif" width="36" height="40" border="0" title="已经是最早一期"/>
        <?php
        }
        if($row=_query("SELECT id FROM magacms_maga WHERE id>'$id' LIMIT 1")){
        ?>
        <a href="<?php echo $magaurl[0]; ?><?php echo $row['id']; ?><?php echo $magaurl[1]; ?>"><img src="images/btnNext_2.gif" width="36" height="40" border="0" title="下一期" /></a>
        <?php
        }else{
        ?>
        <img src="images/btnNext_2_2.gif" width="36" height="40" border="0" title="已经是最新一期"/>
        <?php } ?>
    </div>
    <div id="showad">
        <a href="<?php echo $adlink;?>" target="_blank"><img src="../upload/showad/<?php echo $adphoto; ?>" /></a>
        <a href="javascript:void(0);" onclick="CloseId('showad','0');"><div class="close"></div></a>
    </div>
    <div id="showgbook">
        <iframe width=100% height=100% src="../gbook/index.php?id=<?php echo $id; ?>" frameborder=0 scrolling="no"></iframe>
        <a href="javascript:void(0);" onclick="gbook();"><div class="close"></div></a>
    </div>
</div>
</body>
</html>
<?php $_conn->close();?>