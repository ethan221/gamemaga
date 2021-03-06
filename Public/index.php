<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);

// 定义应用目录
define('APP_PATH', '../Application/');
define('COMMON_PATH',  APP_PATH.'Common/'); //公共模块
define('TMPL_CACHE_ON', false);  //是否缓存
define('DB_FIELD_CACHE', false); //是否缓存
define('HTML_CACHE_ON', false);  //是否缓存
define('RUNTIME_PATH',  APP_PATH.'../Runtime/');
define('TMPL_PATH', APP_PATH.'../Tpl/');// 定义模板目录
define('UPLOAD_PATH', APP_PATH.'../Public/upload/');// 定义模板目录

// 引入ThinkPHP入口文件
require '../ThinkPHP/ThinkPHP.php';