<?php
require dirname(dirname(dirname(__FILE__))) . '/includes/main.inc.php';

$id = getGet("id");

$row=_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1");
$picdir=$row['picdir'];
$width=$row['width'];
$height=$row['height'];
$mwidth=$row['mwidth'];
$mheight=$row['mheight'];
$maganame=$row['maganame'];

$save_path = "../../upload/" . $picdir . "/";
    
//定义允许上传的文件扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png');
//最大文件大小
$max_size = 1024 * 10000; //(默认500K)

//有上传文件时
if (empty($_FILES) === false) {
    //原文件名
    $file_name = $_FILES['Filedata']['name'];
    //服务器上临时文件名
    $tmp_name = $_FILES['Filedata']['tmp_name'];
    //文件大小
    $file_size = $_FILES['Filedata']['size'];
    //检查文件名
    if (!$file_name) {
        exit("返回错误：请选择文件。");
    }
    //检查目录
    if (@is_dir($save_path) === false) {
        exit("返回错误：上传目录不存在。($save_path)");
    }
    //检查目录写权限
    if (@is_writable($save_path) === false) {
        exit("返回错误：上传目录没有写权限。($save_url)");
    }
    //检查是否已上传
    if (@is_uploaded_file($tmp_name) === false) {
        exit("返回错误：临时文件可能不是上传文件。($file_name)($tmp_name)");
    }
    //检查文件大小
    if ($file_size > $max_size) {
        exit("返回错误：上传文件($file_name)大小超过限制。最大" . ($max_size / 1024) . "KB");
    }
    $temp_arr = explode(".", $file_name);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);
    if (in_array($file_ext, $ext_arr) === false) {
        exit("返回错误：上传文件扩展名是不允许的扩展名。");
    }

    
    //新文件名
    $new_file_name = date("YmdHis") . rand(10000, 99999) .'.' . $file_ext;
    
    //移动文件
    $file_path = $save_path . $new_file_name;
    @chmod($file_path, 0644); //修改目录权限(Linux)
    if (move_uploaded_file($tmp_name, $file_path) === false) {//开始移动
        exit("返回错误：上传文件失败。($file_name)");
    }
    
    $pagen=_mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'")+1;
    _insert("INSERT INTO magacms_page(photo,magaid,sort) VALUES ('$new_file_name','$id','$pagen')");
    @$resizeimage = new resizeimage("../../upload/$picdir/$new_file_name",$width,$height,"0","../../upload/$picdir/resize/$new_file_name");//创建小图
    @$resizeimage = new resizeimage("../../upload/$picdir/$new_file_name",$mwidth,$mheight,"0","../../upload/$picdir/$new_file_name");//重生大图

    echo "<p>选择文件：<span>" . $file_name . "</span></p>";
    echo "<p>文件类型：<span>" . $file_ext . "</span></p>";
    echo "<p>文件大小：<span>" . round(($file_size / 1024),2) . " KB</span></p>";
    if (getPost("access2008_box_info_max") != "") {
        echo "<p>已经完成<span>" . ((int) getPost("access2008_box_info_over") + 1) . "</span>个，总数量<span>" . getPost("access2008_box_info_max") . "</span>个，剩余<span>" . ((int) getPost("access2008_box_info_upload") - 1)."</span>个。</p>";
    }
    echo "<p>已经添加到<span>".$maganame."</span>期刊内！</p>";
}

function filekzm($a) {
    $c = strrchr($a, '.');
    if ($c) {
        return $c;
    } else {
        return '';
    }
}

function getGet($v) {// 获取GET
    if (isset($_GET[$v])) {
        return $_GET[$v];
    } else {
        return '';
    }
}

function getPost($v) {// 获取POST
    if (isset($_POST[$v])) {
        return $_POST[$v];
    } else {
        return '';
    }
}
?>

