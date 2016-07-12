<?php
return array(
    'SERVER_NAME'     => 'http://www.gamezz.test',
    'DEFAULT_MODULE'  =>  'Main', //默认模块
    'DB_TYPE' => 'Mysql', // 数据库类型

    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'gamezz', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '',  // 密码
 

    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'magacms_', //表前缀
   // 'DB_SEQUENCE_PREFIX' => 'magacms_', //序列表前缀
    'DB_CASE_LOWER' => true, //结果字段小写
    'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_LOWER),
    'DB_SQL_BUILD_LENGTH' => 20,//SQL缓存队列

    //url地址大小写不敏感设置
    'URL_CASE_INSENSITIVE'  =>  false,
    'DB_CHARSET'            =>  'utf8', // 数据库编码默认采用utf8
    'TMPL_TEMPLATE_SUFFIX' => '.tpl', //模板后缀名
    'TMPL_FILE_DEPR' => '_', //模板层次定义
    //'SHOW_PAGE_TRACE'=>True,  
    'TMPL_PARSE_STRING'=> array('__PUBLIC__'=>'/assets','__WEB_PCHOST__'=>'http://www.gamezz.test'), //模板替换变量定义
    'URL_HTML_SUFFIX'  => '', //伪静态url后缀
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',
    'URL_MODEL'=>2,
    'URL_PARAMS_BIND' => true, // URL变量绑定到Action方法参数
    'URL_PATHINFO_DEPR' => '/', //PATHINFO URL分割符

);
