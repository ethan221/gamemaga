<?php
//function_error
//错误提示页面
function function_error($title,$text,$num,$url){
        require ROOTDIR.'/template/warning.inc.php';
        exit();
}
//function_alert
//JS提示/跳转信息
//[$_text]提示语，为空则只跳转
//[$_url]提示后跳转地址，为空则默认后退页面
function function_alert($_text, $_url) {
    if ($_url == '') {
        echo "<script>alert('$_text');window.history.back();</script>";
    } elseif ($_text == '') {
        echo "<script>window.location.href = '$_url';</script>";
    } else {
        echo "<script>alert('$_text');window.location.href = '$_url';</script>";
    }
    exit;
}

//function_strlen
//检查字符串长度是介于某个范围
//[$_text]被检字符串
//[$_min]最小位数
//[$_max]最大位数
function function_strlen($_text, $_min, $_max) {
    if (mb_strlen($_text, UTF8) > $_max | mb_strlen($_text, UTF8) < $_min) {
        return NULL;
    } else {
        return 1;
    }
}

//底部信息
function function_copyright() {
    echo "<div class='copyright'>";
    echo "Copyright &copy; inc <a href='http://maga.wwzzs.com/' target='new'>MagaCMS</a> ";
    echo "Version.".VERSION." ";
    echo "万众电子期刊在线阅读系统 Wwzzs.Com";
    echo "</div>";
}

//字符串格式化
function function_cleanstr($str) {
    $newstr = htmlspecialchars(trim($str)); //删除两侧空格并转码html
    return $newstr;
}

//获取客户端IP
function function_getRealIp() {
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi("^(10│172.16│192.168).", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

//检测php的GD库
// 取得 PHP 的版本信息   
if (!preg_match('#([0-9]{1,2}).([0-9]{1,2}).([0-9]{1,2})#', phpversion(), $match)) {
    $result = preg_match('#([0-9]{1,2}).([0-9]{1,2})#', phpversion(), $match);
}

if (isset($match) && !empty($match[1])) {
    if (!isset($match[2])) {
        $match[2] = 0;
    }

    if (!isset($match[3])) {
        $match[3] = 0;
    }

    define('_INT_VER', (int) sprintf('%d%02d%02d', $match[1], $match[2], $match[3]));
    unset($match);
} else {
    define('_INT_VER', 0);
}
if (_INT_VER < 43000 && ini_get('html_errors') == '') {
    ini_set('html_errors', true);
}

function _gd_info() {
    $_tmp = Array(
        "GD Version" => "",
        "FreeType Support" => true,
        "FreeType Linkage" => "",
        "FreeType Version" => "",
        "T1Lib Support" => false,
        "GIF Read Support" => false,
        "GIF Create Support" => false,
        "JPG Support" => false,
        "PNG Support" => false,
        "WBMP Support" => false,
        "XPM Support" => false,
        "XBM Support" => false,
        "JIS-mapped Japanese Font Support" => false
    );

    $gif_support = 0;

    ob_start();
    phpinfo(INFO_MODULES);
    $info = stristr(ob_get_contents(), "<h2><a name=\"module_gd\">gd</a></h2>");
    ob_end_clean();

    $line_count = 0;
    foreach (explode("\n", $info) AS $line) {
        // 去掉 HTML 标记   

        $line = strip_tags($line);

        if (strpos($line, "GD Version") !== false) {
            $_tmp["GD Version"] = trim(str_replace("GD Version ", "", $line));
            continue;
        }

        if (strpos($line, "FreeType Support") !== false) {
            $_tmp["FreeType Support"] = trim(str_replace("FreeType Support", "", $line));
            continue;
        }

        if (strpos($line, "FreeType Linkage") !== false) {
            $_tmp["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", $line));
            continue;
        }

        if (strpos($line, "FreeType Version") !== false) {
            $_tmp["FreeType Version"] = trim(str_replace("FreeType Version", "", $line));
            continue;
        }

        if (strpos($line, "T1Lib Support") !== false) {
            $_tmp["T1Lib Support"] = trim(str_replace("T1Lib Support", "", $line));
            continue;
        }

        if (strpos($line, "GIF Read Support") !== false) {
            $_tmp["GIF Read Support"] = trim(str_replace("GIF Read Support", "", $line));
            continue;
        }

        if (strpos($line, "GIF Create Support") !== false) {
            $_tmp["GIF Create Support"] = trim(str_replace("GIF Create Support", "", $line));
            continue;
        }

        if (strpos($line, "GIF Support") !== false) {
            $gif_support = trim(str_replace("GIF Support", "", $line));
            continue;
        }

        if (strpos($line, "JPG Support") !== false) {
            $_tmp["JPG Support"] = trim(str_replace("JPG Support", "", $line));
            continue;
        }

        if (strpos($line, "PNG Support") !== false) {
            $_tmp["PNG Support"] = trim(str_replace("PNG Support", "", $line));
            continue;
        }

        if (strpos($line, "WBMP Support") !== false) {
            $_tmp["WBMP Support"] = trim(str_replace("WBMP Support", "", $line));
            continue;
        }

        if (strpos($line, "XBM Support") !== false) {
            $_tmp["XBM Support"] = trim(str_replace("XBM Support", "", $line));
            continue;
        }

        $line_count ++;

        if ($line_count >= 15) {
            break;
        }
    }

    if ($gif_support === "enabled") {
        $_tmp["GIF Read Support"] = true;
        $_tmp["GIF Create Support"] = true;
    }

    foreach ($_tmp AS $k => $v) {
        if ($v === "enabled") {
            $_tmp[$k] = true;
        }
    }

    return $_tmp;
}

function browinfo(){
if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 8.0")) {
$visitor_browser = "Internet Explorer 8.0";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")) {
$visitor_browser = "Internet Explorer 7.0";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
$visitor_browser = "Internet Explorer 6.0";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) {
$visitor_browser = "Internet Explorer 5.5";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 5.0")) {
$visitor_browser = "Internet Explorer 5.0";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 4.01")) {
$visitor_browser = "Internet Explorer 4.01";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "NetCaptor")) {
$visitor_browser = "NetCaptor";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Netscape")) {
$visitor_browser = "Netscape";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Lynx")) {
$visitor_browser = "Lynx";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Opera")) {
$visitor_browser = "Opera";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Konqueror")) {
$visitor_browser = "Konqueror";
} elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Mozilla/5.0")) {
$visitor_browser = "Mozilla";
} else {
$visitor_browser = "others";
}
return $visitor_browser;
}
?>