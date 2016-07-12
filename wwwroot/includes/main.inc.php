<?php
	define('ROOTDIR',str_replace('\\','/',realpath(dirname(dirname(__FILE__).'/')))."/");
	$path = explode(str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']),str_replace("\\","/",ROOTDIR));
	define('ROOTNAME',end($path));
	require_once ROOTDIR.'/includes/file.fun.php';
	require_once ROOTDIR.'/includes/version.inc.php';
	require_once ROOTDIR.'/includes/other.fun.php';
	require_once ROOTDIR.'/includes/photo.class.php';
	if(PHP_VERSION<'4.1.0'){
		function_error('PHP版本过低', '您的PHP版本低于4.1.0，当前PHP版本为'.PHP_VERSION.'，不能支持本程序的一些必须函数，请尝试升级您的PHP版本！', 'E001', '');
	}
	ini_set("memory_limit","50M");
	require_once ROOTDIR.'/includes/config.inc.php';
	define('DB_HOST',$db_host);
	define('DB_USER',$db_user);
	define('DB_PASSWORD',$dbpassword);
	define('DB_NAME',$db_name);
	require ROOTDIR.'/includes/mysql.fun.php';
	_connect();
	_set_names();
?>