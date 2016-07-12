<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?> - Powered by Wwzzs.com!</title>
<link href="<?php echo ROOTNAME ?>images/style_error.css" rel="stylesheet" type="text/css" />
<?php if($url){ ?>
<script>
setTimeout(function(){
    window.location.href='<?php echo ROOTNAME.$url; ?>';
},"3000");
</script>
<?php }elseif ($url=='0') { ?>
<script>
setTimeout(function(){
history.go(-1);
},"3000");
</script>
<?php }?>
</head>
<body>
    <div id="error">
        <div class="title"><?php echo $title ?> [错误代码：<?php echo $num ?>]</div>
        <div class="text"><?php echo $text ?></div>
        <?php if($url!=''){ ?>
            <div class="url">如无自动跳转请<?php if($url=='0'){ ?><a href="javascript:void()" onclick="history.go(-1);"><?php }else{ ?><a href="<?php echo ROOTNAME.$url ?>"><?php } ?>点击跳转</a></div>
        <?php } ?>
    </div>
</body>
</html>
<?php
exit();
?>