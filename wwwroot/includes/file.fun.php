<?php
//_folder
//创建文件夹
function _folder($pathname){
    if(!_isfolder($pathname)){
        mkdir($pathname);
    }
}
//_delfolder
//删除非空文件夹
function _delfolder($pathname) {
	if(_isfolder($pathname)){
		$dh=opendir($pathname);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$pathname."/".$file;
				if(!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
                                    _delfolder($fullpath);
				}
			}
		}
		closedir($dh);
		if(!rmdir($pathname)){
			if(_isfolder($pathname)){
                            return ture;
                            function_error('删除指定文件夹出错', '目标文件夹无可写权限！', 'E003', '');
			}
		} else {
			return false;
		}
	}
}
//_isfolder
//判断文件/文件夹是否存在
//存在返回1
//不存在返回空
function _isfolder($pathname){
    if(file_exists($pathname)){
        return 1;
    }else{
        return NULL;
    }
}
//_delfile
//删除文件
function _delfile($pathname){
    if(_isfolder($pathname)){
        unlink($pathname);
        return 1;
    }else{
        return NULL;
    }
}
//_filesize
//返回文件容量
function _filesize($file){
    if(_isfolder($file)){
        return _realsize(filesize($file));;
    }else{
        return '0';
    }
}
//getDirSize
// 获取文件夹大小
function _dirsize($dir){ 
    $handle = opendir($dir);
    while (false!==($FolderOrFile = readdir($handle))){ 
        if($FolderOrFile != "." && $FolderOrFile != ".."){ 
            if(is_dir("$dir/$FolderOrFile")){ 
                $size+=_dirsize("$dir/$FolderOrFile"); 
            }else{ 
                $size+=filesize("$dir/$FolderOrFile"); 
            }
        }
    }
    closedir($handle);
    return _realsize($size);
}
//_realsize
//格式化文件容量单位
function _realsize($size){ 
    $kb = 1024; 
    $mb = 1024 * $kb;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;
    if($size < $kb){ 
        return $size." B";
    }else if($size < $mb){ 
        return round($size/$kb,2)." KB";
    }else if($size < $gb){ 
        return round($size/$mb,2)." MB";
    }else if($size < $tb){ 
        return round($size/$gb,2)." GB";
    }else{ 
        return round($size/$tb,2)." TB";
    }
}
?>