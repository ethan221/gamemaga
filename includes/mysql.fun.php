<?php
//_connect
//连接Mysql数据库服务器
function _connect(){
	global $_conn;
    if(!$_conn=new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME, 3306)){
        function_error('数据库服务器连接失败','数据库服务器连接失败，'.mysql_error($_conn), 'E004', '');
	}
}

//_set_names
//选择Mysql字符集
function _set_names(){
		global $_conn;
    	$_conn->set_charset("utf8");
		$_conn->query("SET SQL_MODE = ''");
}

//_query
//返回数据库结果集[以字段名返回]
//[$_sql]Mysql语句
function _query($_sql){
	global $_conn;
    if(!$result=$_conn->query($_sql)){
    function_error('SQL读取错误','SQL读取错误，'.mysqli_error($_conn), 'E006', '');
    }
    return mysqli_fetch_array($result,MYSQLI_ASSOC);
}

//_update
//修改数据库内容
//[$_sql]Mysql语句
function _update($_sql){
	global $_conn;
    if(!$_conn->query($_sql)){
		function_error('SQL修改错误','SQL修改错误，'.mysql_error($_conn), 'E007', '');
    }
}

//_insert
//新增数据库内容
//[$_sql]Mysql语句
function _insert($_sql){
	global $_conn;
    if(!$_conn->query($_sql)){
    function_error('SQL新增错误','SQL新增命令错误，'.mysql_error($_conn), 'E008', '');
    }
}

//_deldate
//删除数据库内容
//[$_sql]Mysql语句
function _deldate($_sql){
	global $_conn;
    if(!$_conn->query($_sql)){
    function_error('SQL删除错误','SQL删除命令错误，'.mysql_error($_conn), 'E009', '');
    }
}

//_mysqlnum
//返回数据库总数据条数
//[$_sql]Mysql语句
function _mysqlnum($_sql){
	global $_conn;
    if(!$_conn->query($_sql)){
    function_error('SQL读取总条数错误','SQL读取总条数错误，'.mysql_error($_conn), 'E010', '');
    }else{
        return $_conn->query($_sql)->num_rows;
    }
}
?>