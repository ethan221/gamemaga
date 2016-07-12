<?php
require_once dirname(__file__) . '/includes/main.inc.php';
$siteinfo = _query("SELECT * FROM magacms_siteinfo");
$system = _query("SELECT * FROM magacms_system");
$_pagesize = $system['pagenum'];
$type = $_GET['type'];
if ($system['rewrite'] == 0) {
	$typeurl[0] = '?type=';
	$typeurl[1] = '';
	$pageurl[0] = '?type=';
	$pageurl[1] = '&';
	$pageurl[2] = 'page=';
	$pageurl[3] = '';
	$reade[0] = 'reade/?id=';
	$reade[1] = '';
} else {
	$typeurl[0] = 'type_';
	$typeurl[1] = '.html';
	if ($type == '') {
		$pageurl[0] = 'index';
	} else {
		$pageurl[0] = 'type_';
	}
	$pageurl[1] = '_';
	$pageurl[2] = '';
	$pageurl[3] = '.html';
	$reade[0] = 'reade/maga_';
	$reade[1] = '.html';
}
if ($type == '') {
	$_num = _mysqlnum("SELECT id FROM magacms_maga");
	require_once ROOTDIR . '/template/PageHeader.inc.php';
	if ($system['sort'] == 1) {
		$result = $_conn->query("SELECT * FROM magacms_maga ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
	} else {
		$result = $_conn->query("SELECT * FROM magacms_maga ORDER BY id ASC LIMIT $_pagenum,$_pagesize");
	}
} else {
	if (!_query("SELECT id FROM magacms_type WHERE id='$type' LIMIT 1")) {
		function_alert('', './');
	} else {
		$typeinfo = _query("SELECT id,name FROM magacms_type WHERE id='$type' LIMIT 1");
		$typename = $typeinfo['name'];
		$typeid = $typeinfo['id'];
	}
	$_num = _mysqlnum("SELECT id FROM magacms_maga WHERE typeid='$type'");
	require_once ROOTDIR . '/template/PageHeader.inc.php';
	if ($system['sort'] == 1) {
		$result = $_conn->query("SELECT * FROM magacms_maga WHERE typeid='$type' ORDER BY id DESC LIMIT $_pagenum,$_pagesize");
	} else {
		$result = $_conn->query("SELECT * FROM magacms_maga WHERE typeid='$type' ORDER BY id ASC LIMIT $_pagenum,$_pagesize");
	}
}
$newmaga = _query("SELECT id FROM magacms_maga ORDER BY id DESC LIMIT 1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($typename == '') {  ?>
<title><?php echo $siteinfo['sitename']; ?> - Powered by Wwzzs.com!</title>
<?php } else { ?>
<title><?php echo $typename ?> - <?php echo $siteinfo['sitename']; ?> - Powered by Wwzzs.com!</title>
<?php } ?>
<meta name="keywords" content="<?php echo $siteinfo['sitekey'] . ',万众网络,Wwzzs.Com'; ?>" />
<meta name="description" content="<?php echo $siteinfo['sitedes'] . '万众电子期刊/杂志/报纸/DM在线阅读系统,Maga.Wwzzs.Com'; ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/scroll.js"></script>
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<?php require_once ROOTDIR . '/template/header.inc.php'; ?>
<div id="main">
    <?php if ($_num == 0) { if (_query('SELECT id FROM magacms_maga')) { ?>
    <div class="info"><span>提示：</span><?php if ($typename != '') { echo '“<b>' . $typename . '</b>”栏目下'; } ?>暂无内容，推荐你阅读以下最新期刊或者<a href="./">查看所有期刊</a>。</div>
    <ul>
	<?php 
		$result = $_conn->query("SELECT * FROM magacms_maga ORDER BY id DESC LIMIT 5");
		while (!!$row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$id = $row['id'];
			$photo = $row['photo'];
			$maganame = $row['maganame'];
			$intime = $row['intime'];
			$pagan = _mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'");
			if ($pagan == 0) {
				$pagan = '无版面';
			} else {
				$pagan = '共' . $pagan . '版';
			}
	?>
        <a href="<?php echo $reade[0]; ?><?php echo $id; ?><?php echo $reade[1]; ?>"><li><div class="libox"><?php if ($photo == '') { ?><img src="images/nopic.png" /><?php	} else { ?><img src="upload/magaico/<?php echo $photo; ?>" /><?php } ?><p><?php echo $maganame; ?></p><div class="pagen"><?php echo $pagan . '&nbsp;' . $intime; ?></div><?php if ($newmaga['id'] == $id) { ?><div class="newmaga"></div><?php } ?></div></li></a>
            <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="info"><span>提示</span><?php if ($typename != '') { echo '“' . $typename . '”栏目下'; } ?>暂无期刊！</div>
    <?php } } else { ?>
    <ul>
	<?php while (!!$row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$id = $row['id'];
		$photo = $row['photo'];
		$maganame = $row['maganame'];
		$intime = $row['intime'];
		$pagan = _mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'");
		if ($pagan == 0) {
			$pagan = '无版面';
		} else {
			$pagan = '共' . $pagan . '版';
		} ?>
        <a href="<?php echo $reade[0]; ?><?php echo $id; ?><?php echo $reade[1]; ?>"><li><div class="libox"><?php if ($photo == '') { ?><img src="images/nopic.png" /><?php } else { ?><img src="upload/magaico/<?php echo $photo; ?>" /><?php } ?>
		<p><?php echo $maganame; ?></p><div class="pagen"><?php echo $pagan . '&nbsp;' . $intime; ?></div>
	<?php if ($newmaga['id'] == $id) { ?><div class="newmaga"></div><?php } ?></div></li></a>
            <?php } ?>
    </ul>
    <?php } ?>
</div>
<div class="clear"></div>
<?php require_once ROOTDIR . '/template/PageBottom.inc.php'; require_once ROOTDIR . '/template/footer.inc.php'; ?>
</body>
</html>
<?php $_conn->close(); ?>