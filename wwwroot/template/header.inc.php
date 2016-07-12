<div id="top">
    <div class="top">
    	<div class="logo"><?php echo $siteinfo['sitename'];?></div>
        <div class="search">
            <form action="search.php" method="get" name="so"><a class="sosub" onclick="so.submit();"/>搜索</a><input class="sobox" name="keyword" type="text" value="输入要查找的内容" onblur="if(this.value==''){this.value='输入要查找的内容';};" autocomplete="off" onfocus="if(this.value=='输入要查找的内容'){this.value='';}" x-webkit-speech=""/></form>
        </div>
    </div>
</div>
<div class="clear"></div>
<div id="header">
<?php
$bannernum = _mysqlnum("SELECT id FROM magacms_banner");
if($bannernum > 1){
?>
<div class="scroll">
	<div class="slide_01" id="slide_01">
	<?php
	$result3=$_conn->query("SELECT * FROM magacms_banner ORDER BY sort DESC");
	while (!!$row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
	?>
	<div class="mod_01"><img src="./upload/bannerpic/<?php echo $row3['photo']; ?>" alt="<?php echo $row3['photo']; ?>"></div>
	<?php } ?>
	</div>
	<div class="dotModule_new">
		<div id="slide_01_dot"></div>
	</div>
</div>
<?php }else if($bannernum == 1){ $banner=_query("SELECT * FROM magacms_banner ORDER BY sort DESC"); ?>
<img src="./upload/bannerpic/<?php echo $banner['photo']; ?>" width="910px" height="350px">
<?php }else{ ?>
<img src="./images/nobanner.png" width="910px" height="350px">
<?php } ?>
<script type="text/javascript">
if(document.getElementById("slide_01")){
	var slide_01 = new ScrollPic();
	slide_01.scrollContId   = "slide_01"; //内容容器ID
	slide_01.dotListId      = "slide_01_dot";//点列表ID
	slide_01.dotOnClassName = "selected";
	slide_01.arrLeftId      = "sl_left"; //左箭头ID
	slide_01.arrRightId     = "sl_right";//右箭头ID
	slide_01.frameWidth     = 910;
	slide_01.pageWidth      = 480;
	slide_01.upright        = false;
	slide_01.speed          = 10;
	slide_01.space          = 30; 
	slide_01.initialize(); //初始化
}
</script>
</div>
<div id="nav">
	<ul>
    	<li><div class="libox"><a href="./" <?php if($type==''){?>class="main"<?php }?>>全部期刊<i></i></a></div></li>
        <?php
        $result2=$_conn->query("SELECT * FROM magacms_type ORDER BY sort DESC LIMIT 10");
        while (!!$row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
        ?>
    	<li><div class="libox"><a href="<?php echo $typeurl[0]; ?><?php echo $row2['id']; ?><?php echo $typeurl[1]; ?>" <?php if($typeid==$row2['id']){?>class="main"<?php }?>><?php echo $row2['name']; ?><i></i></a></div></li>
        <?php
        }
        ?>
    </ul>
</div>
<div class="clear"></div>