<?php
	require dirname(dirname(__FILE__)).'/includes/main.inc.php';
	$id=$_GET['id'];
	if(!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")){
		function_alert('非法ID！','');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>期刊评论</title>
<link href="images/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="showgbook">
    <div class="gbook_l" id="gbook">
<?php
if(_query("SELECT * FROM magacms_gbook WHERE magaid='$id' ORDER BY id DESC")){
$result = $_conn->query("SELECT * FROM magacms_gbook WHERE magaid='$id' ORDER BY id DESC");
$i=_mysqlnum("SELECT magaid FROM magacms_gbook WHERE magaid='$id'")+1;
while (!!$row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $i--;
?>
        <div class="gbookinfo">
                <div class="username"><b><?php echo $row['username']?>：</b></div>
                <div class="text"><?php echo $row['text']?></div>
                <div class="time">发布于 <?php echo $row['time']?></div>
        </div>
<?php
}
}else{
?>
<div class="gbookinfo">
                <div class="nogbook">该期刊暂无评论，快来抢沙发吧~</div>
        </div>
<?php
}
?>
    </div>
    <div class="gbook_r">
        <form name="addgbook" method="post" action="?action=addgbook&id=<?php echo $id; ?>">
            <dl><dt>您的大名：</dt><dd><input type="text" name="username" class="text" /></dd></dl>
            <dl><dt>评论内容：</dt><dd><textarea  class="text"  style = "disply:none" name="gbooktext" rows="4" value="文明上网，理性发言！" onfocus="if(this.value=='文明上网，理性发言！'){this.value='';}" onblur="if(this.value==''){this.value='文明上网，理性发言！';};" >文明上网，理性发言！</textarea></dd></dl>
            <dl><dt style="text-align:center;width:100%;"><input type="submit" value="评论" style="text-align:center;width:80px;height:20px;border:0;"> <input type="button" value="刷新" style="text-align:center;width:80px;height:20px;border:0;" onclick="window.location.reload();"></dt></dl>
            1、文明上网，理性发言；<br/>
            2、名字必须介于3~10个字符；<br/>
            3、留言内容必须介于15~144个字符。<br/>
        </form>
    </div>
</div>
</body>
</html>
<?php
if ($_GET['action']=='addgbook'){
    $id=$_GET['id'];
    $username=function_cleanstr($_POST['username']);
    $gbooktext=function_cleanstr($_POST['gbooktext']);
    $time=date('Y年m月d日 H:i',time());
    $ip=function_getRealIp();
    if($username==''){
        function_alert('请留下您的大名！', '');
    }
    if($gbooktext=='' || $gbooktext=='文明上网，理性发言！'){
        function_alert('留言内容不能为空！', '');
    }
    if(!function_strlen($username,3,10)){
        function_alert('你的姓名必须介于3~10个字符！', '');
    }
    if(!function_strlen($gbooktext,15,144)){
        function_alert('留言内容必须介于15~144个字符！', '');
    }
    _insert("INSERT INTO magacms_gbook(username,time,text,magaid,ip) VALUES ('$username','$time','$gbooktext','$id','$ip')");
    function_alert('', '?id='.$id);
}
?>