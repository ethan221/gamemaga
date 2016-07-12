<?php
require_once dirname(__FILE__).'/includes/main.inc.php';
if(!_isfolder('install/install.lock')){
    header("Location: install");
}
$keyword=function_cleanstr($_GET['keyword']);
if($keyword=='' || $keyword=='输入要查找的内容'){
    function_error('无效字符', '请输入有效的字符进行搜索！', 'E010', '0');
    exit();
}
$siteinfo=_query("SELECT * FROM magacms_siteinfo");
$system=_query("SELECT * FROM magacms_system");
$_pagesize=$system['pagenum'];
$type=$_GET['type'];
if($system['rewrite']==0){
    $typeurl[0]='?type=';
    $typeurl[1]='';
    $pageurl[0]='?';
    $pageurl[1]='';
    $pageurl[2]='page=';
    $pageurl[3]='';
    $reade[0]='reade/?id=';
    $reade[1]='';
}else{
    $typeurl[0]='type_';
    $typeurl[1]='.html';
    $pageurl[0]='so_';
    $pageurl[1]='';
    $pageurl[2]='_';
    $pageurl[3]='.html';
    $reade[0]='reade/maga_';
    $reade[1]='.html';
}
$newmaga=_query("SELECT id FROM magacms_maga ORDER BY id DESC LIMIT 1");
$_num=_mysqlnum("SELECT id FROM magacms_maga WHERE maganame LIKE'%$keyword%'");
require_once ROOTDIR.'/template/PageHeader.inc.php';
if($system['sort']==1){
    $result=$_conn->query("SELECT * FROM magacms_maga WHERE maganame LIKE'%$keyword%' ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
}else{
    $result=$_conn->query("SELECT * FROM magacms_maga WHERE maganame LIKE'%$keyword%' ORDER BY id ASC LIMIT $_pagenum,$_pagesize");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>搜索“<?php echo $keyword;?>” - <?php echo $siteinfo['sitename'];?> - Powered by Wwzzs.com!</title>
<meta name="keywords" content="<?php echo $siteinfo['sitekey'].',万众网络,Wwzzs.Com';?>" />
<meta name="description" content="<?php echo $siteinfo['sitedes'].'万众电子期刊/杂志/报纸/DM在线阅读系统,Maga.Wwzzs.Com';?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/scroll.js"></script>
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<?php
require_once ROOTDIR.'/template/header.inc.php';
?>
<div id="main">
    <?php
    if($_num==0 && _query("SELECT * FROM magacms_maga")){
    ?>
    <div class="info"><span>提示</span>暂无和“<b><?php echo $keyword; ?></b>”相关的期刊，推荐你阅读以下最新期刊或者<a href="./">查看所有期刊</a>。</div>
    <ul>
        <?php
        $result=$_conn->query("SELECT * FROM magacms_maga ORDER BY id DESC LIMIT 5");
        while (!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $id=$row['id'];
            $photo=$row['photo'];
            $maganame=$row['maganame'];
            $intime=$row['intime'];
            $pagan=_mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'");
            if($pagan==0){
                $pagan='无版面';
            }else{
                $pagan='共'.$pagan.'版';
            }
        ?>
        <a href="<?php echo $reade[0]; ?><?php echo $id;?><?php echo $reade[1]; ?>"><li><div class="libox"><?php if($photo==''){?><img src="images/nopic.png" /><?php }else{?><img src="upload/magaico/<?php echo $photo;?>" /><?php }?><p><?php echo $maganame;?></p><div class="pagen"><?php echo $pagan.'&nbsp;'.$intime;?></div><?php if($newmaga['id']==$id){?><div class="newmaga"></div><?php } ?></div></li></a>
        <?php
        }
        ?>
    </ul>
    <?php }else if($_num==0 && !_query("SELECT * FROM magacms_maga")){ ?>
    <div class="info"><span>提示</span>暂无和“<b><?php echo $keyword; ?></b>”相关的期刊。</div>
    <?php }else{ ?>
    <div class="info"><span>提示</span>搜索“<b><?php echo $keyword; ?></b>”相关的期刊，共找到<b><?php echo $_num; ?></b>个相关期刊。</div>
    <ul>
    <?php
    while (!!$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $id=$row['id'];
        $photo=$row['photo'];
        $maganame=$row['maganame'];
        $intime=$row['intime'];
        $pagan=_mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'");
        if($pagan==0){
            $pagan='无版面';
        }else{
            $pagan='共'.$pagan.'版';
        }
    ?>
    <a href="<?php echo $reade[0]; ?><?php echo $id;?><?php echo $reade[1]; ?>"><li><div class="libox"><?php if($photo==''){?><img src="images/nopic.png" /><?php }else{?><img src="upload/magaico/<?php echo $photo;?>" /><?php }?><p><?php echo $maganame;?></p><div class="pagen"><?php echo $pagan.'&nbsp;'.$intime;?></div><?php if($newmaga['id']==$id){?><div class="newmaga"></div><?php } ?></div></li></a>
    <?php } } ?>
</div>
<div class="clear"></div>
<?php require_once ROOTDIR.'/template/PageBottom.inc.php'; require_once ROOTDIR.'/template/footer.inc.php'; ?>
</body>
</html>
<?php $_conn->close();?>