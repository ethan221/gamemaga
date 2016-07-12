<?php
$_pageabsolute=ceil($_num/$_pagesize);
$_page=$_GET['page'];
if($_page==''||$_page<=0 || !is_numeric($_page) || $_page>$_pageabsolute){
    $_page=1;
}
$_pagenum=($_page-1)*$_pagesize;
?>