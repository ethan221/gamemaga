<?php
require_once dirname(__FILE__).'/version.inc.php';

if($_GET['action']=='b'){
    _readnews();
}
if($_GET['action']=='a'){
    _readversion();
}
function _readnews() {
    $url = 'ht'.'tp'.':'.'//'.'ma'.'ga'.'.ww'.'zzs'.'.co'.'m'.'/'.'api'.'/'.'news_'.'ph'.'p'.'.'.'xml';
    $opts = array( 
    'http'=>array( 
        'method'=>"GET", 
        'timeout'=>5000, 
        )
    ); 
    $context = stream_context_create($opts); 
    $file_in = @file_get_contents($url, false, $context); 

    $doc = new DOMDocument();
    @$doc->loadXML($file_in);
    $newsn = $doc->getElementsByTagName("news");
    $news = array();
        echo "<table border='0' cellspacing='0' cellpadding='0'>";
    for ($i = 0; $i < $newsn->length; $i++) {
        $news[title] = $doc->getElementsByTagName('title')->item($i)->nodeValue;
        $news[link] = $doc->getElementsByTagName('link')->item($i)->nodeValue;
        $news[time] = $doc->getElementsByTagName('time')->item($i)->nodeValue;
        $news[color] = $doc->getElementsByTagName('color')->item($i)->nodeValue;
        echo "<tr><td class='news'>";
        echo "<a href='$news[link]' target='_blank' style='color:" . $news[color] . "'>$news[title]</a></td><td>";
        echo "$news[time]</td></tr>";
    }
    if (empty($news)) {
        echo "<tr><td class='news'>";
        echo "获取官方动态失败...<a href=right.inc.php>[刷新]</a></td><td>";
        echo "</td></tr>";
    }
        echo "</table>";
}
function _readversion() {
    $url = 'ht'.'tp:'.'//'.'ma'.'ga'.'.wwz'.'zs'.'.c'.'om'.'/'.'api'.'/'.'ver'.'sio'.'n_'.'ph'.'p.'.'xml';
    $opts = array( 
    'http'=>array( 
        'method'=>"GET", 
        'timeout'=>5000, 
        )
    ); 
    $context = stream_context_create($opts); 
    $file_in = @file_get_contents($url, false, $context);
    $doc = new DOMDocument();
    @$doc->loadXML($file_in);
    $version = array();
    $version[title] = $doc->getElementsByTagName("title")->item(0)->nodeValue;
    $version[description] = $doc->getElementsByTagName("description")->item(0)->nodeValue;
    $version[link] = $doc->getElementsByTagName("link")->item(0)->nodeValue;
    if($version[title]!=VERSION && $version[title]!=''){
    ?>
    <span>提示：</span>当前版本<b><?php echo VERSION; ?></b>有更新，最新版本<b><?php echo $version[title]; ?></b>，更新内容：<?php echo $version[description]; ?><a href="<?php echo $version[link]; ?>" target="_blank">下载升级文件</a>
    <?php
    }elseif ($version[title]==VERSION) {
    ?>
    <span>提示：</span>当前版本<b><?php echo VERSION; ?></b>，已经是最新版本！
    <?php
    }elseif ($version[title]==''){
    ?>
    <span>提示：</span>当前版本<b><?php echo VERSION; ?></b>，新版本检测失败<a href="right.inc.php">刷新</a>
    <?php
    }
}
?>