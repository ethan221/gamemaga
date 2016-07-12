<?php
    header('content-Type:text/html;charset=UTF-8');
    session_start();
    require dirname(dirname(dirname(__file__))) . '/includes/main.inc.php';
    $action = $_GET['action'];
    switch($action) { case 'login': function_login(); break; case 'adduser': function_adduser(); break; case 'deluser': function_deluser(); break; case 'edituser': function_edituser(); break; case 'addmaga': function_addmaga(); break; case 'delmaga': function_delmaga(); break; case 'editmaga': function_editmaga(); break; case 'siteinfo': function_siteinfo(); break; case 'delico': function_delico(); break; case 'delpage': function_delpage(); break; /* case'addpage': function_addpage(); break; */ case 'addtype': function_addtype(); break; case 'deltype': function_deltype(); break; case 'edittype': function_edittype(); break; case 'logout': function_logout(); break; case 'editsystem': function_editsystem(); break; case 'delpdf': function_delpdf(); case 'mphoto': function_mphoto(); case 'upsort': function_upsort(); case 'downsort': function_downsort(); case 'deladphoto': function_delphoto(); case 'delfolder': function_delfolder(); case 'delfile': function_delfile(); case 'delgbook': function_delgbook(); case 'addbanner': function_addbanner(); case 'delbanner': function_delbanner();  case 'upbannersort': function_upbanner(); case 'downbannersort': function_downbanner();}
	//下移banner排序
	function function_downbanner(){
       function_safety();
        $id = function_cleanstr($_GET['id']);
        if (!_query("SELECT id FROM magacms_banner WHERE id='$id' LIMIT 1")) {
            function_alert('','admin_banner.php?info=排序失败，当前Banner不存在！&icon=error');
        }
        $row = _query("SELECT * FROM magacms_banner WHERE id='$id' LIMIT 1");
        $newsort = $row['sort'] + 1;
        $oldsort = $row['sort'];
        $pagen = _mysqlnum("SELECT id FROM magacms_banner");
        if ($newsort <= $pagen) {
            if (_query("SELECT id FROM magacms_banner WHERE sort='$newsort' LIMIT 1")) {
				_update("UPDATE magacms_banner SET sort='$oldsort' WHERE sort='$newsort'");
            }
            _update("UPDATE magacms_banner SET sort='$newsort' WHERE id='$id'");
        } else {
            _update("UPDATE magacms_banner SET sort='$pagen' WHERE id='$id'");
        }
        function_alert('', 'admin_banner.php?info=排序成功！&icon=succeed&id=' . $id);
	}
	//上移banner排序
	function function_upbanner(){
        $id = function_cleanstr($_GET['id']);
        if (!_query("SELECT id FROM magacms_banner WHERE id='$id' LIMIT 1")) {
            function_alert('','admin_banner.php?info=排序失败，当前Banner不存在！&icon=error');
        }
        $row = _query("SELECT * FROM magacms_banner WHERE id='$id' LIMIT 1");
        $newsort = $row['sort'] - 1;
        $oldsort = $row['sort'];
        if ($newsort > 0) {
            if (_query("SELECT id FROM magacms_banner WHERE sort='$newsort' LIMIT 1")) {
                _update("UPDATE magacms_banner SET sort='$oldsort' WHERE sort='$newsort'");
            }
            _update("UPDATE magacms_banner SET sort='$newsort' WHERE id='$id'");
        } else {
            _update("UPDATE magacms_banner SET sort='1' WHERE id='$id'");
        }
        function_alert('','admin_banner.php?info=排序成功！&icon=succeed&id=' . $id);
	}
	//删除banner
	function function_delbanner(){
       function_safety();
        $id = function_cleanstr($_GET['id']);
        if (_query("SELECT id FROM magacms_banner WHERE id='$id' LIMIT 1")) {
            $row = _query("SELECT id,photo FROM magacms_banner WHERE id='$id' LIMIT 1");
            _delfile("../upload/bannerpic/" . $row['photo']);
			_deldate("DELETE FROM magacms_banner WHERE id='$id'");
            function_alert('', 'admin_banner.php?info=Banner删除成功！&icon=succeed');
        } else {
        function_alert('', 'admin_banner.php?info=删除失败，指定Banner的ID不存在！&icon=error');
        }
	}
	//添加banner
	function function_addbanner(){
       function_safety();
        $photo = function_cleanstr($_POST['photo']);
        $sort = function_cleanstr($_POST['sort']);
		if($sort==''){
			$sort=_mysqlnum("SELECT id FROM magacms_banner")+1;
		}
		//@$resizeimage = new resizeimage("../upload/bannerpic/$photo", "910", "350", "0", "../upload/bannerpic/$photo");
		_insert("INSERT INTO magacms_banner(photo,sort) VALUES ('$photo','$sort')");
		function_alert('', 'admin_banner.php?info=Banner添加成功！&icon=succeed');
	}
    //删除评论
    function function_delgbook() {
        $id = function_cleanstr($_GET['id']);
        if(!_query("SELECT id FROM magacms_gbook WHERE id='$id' LIMIT 1")){
            function_alert('','admin_gbook.php?info=删除失败，指定评论已经不存在！&icon=error');
        }
        _deldate("DELETE FROM magacms_gbook WHERE id='$id'");
        function_alert('','admin_gbook.php?info=删除评论成功！&icon=succeed');
    }
    //删除文件
    function function_delfile() {
        $path = mb_convert_encoding($_GET['path'],"GBK","UTF-8");
        if (_delfile($path)) {
            function_alert('','admin_ryfile.php?info=删除文件成功！&icon=succeed');
        } else {
            function_alert('','admin_ryfile.php?info=删除文件失败！&icon=error');
        }
    }
    //删除非空文件夹
    function function_delfolder() {
        $path = mb_convert_encoding($_GET['path'],"GBK","UTF-8");
        _delfolder($path);
        function_alert('','admin_ryfile.php?info=删除文件夹成功！&icon=succeed');
    }
    //删除广告图片
    function function_delphoto(){
        $row = _query("SELECT adphoto FROM magacms_system LIMIT 1");
        _delfile('../upload/showad/' . $row['adphoto']);
        _update("UPDATE magacms_system SET adphoto='',adtime=0");
        function_alert('','admin_system.php?info=广告图片删除成功！&icon=succeed');
    }
    //下调版面排序
    function function_downsort() {
        $id = function_cleanstr($_GET['id']);
        $pid = function_cleanstr($_GET['pid']);
        if (!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")){
            function_alert('', 'admin_maga.php?info=排序失败，当前期刊不存在！&icon=error');
        }
        if (!_query("SELECT id FROM magacms_page WHERE id='$pid' LIMIT 1")){
            function_alert('', 'admin_maga_edit.php?info=排序失败，指定版面不存在！&icon=error&id=' . $id .'#pagelist');
        }
        $row = _query("SELECT id,sort FROM magacms_page WHERE id='$pid' LIMIT 1");
        $newsort = $row['sort'] + 1;
        $oldsort = $row['sort'];
        $pagen = _mysqlnum("SELECT id  FROM magacms_page WHERE magaid='$id'");
        if ($newsort <= $pagen) {
            if (_query("SELECT id FROM magacms_page WHERE magaid='$id' AND sort='$newsort' LIMIT 1")) {
                    _update("UPDATE magacms_page SET sort='$oldsort' WHERE sort='$newsort' AND magaid='$id'");
            }
            _update("UPDATE magacms_page SET sort='$newsort' WHERE id='$pid'");
        } else {
            _update("UPDATE magacms_page SET sort='$pagen' WHERE id='$pid'");
        }
        function_alert('', 'admin_maga_edit.php?info=排序成功！&icon=succeed&id=' . $id . '&pid=' . $pid . '#pagelist');
    }
    //上调版面排序
    function function_upsort() {
        $id = function_cleanstr($_GET['id']);
        $pid = function_cleanstr($_GET['pid']);
        if (!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")) {
            function_alert('','admin_maga.php?info=排序失败，当前期刊不存在！&icon=error');
        }
        if (!_query("SELECT id FROM magacms_page WHERE id='$pid' LIMIT 1")) {
            function_alert('','admin_maga_edit.php?info=排序失败，指定版面不存在！&icon=error&id=' . $id .'#pagelist');
        }
        $row = _query("SELECT id,sort FROM magacms_page WHERE id='$pid' LIMIT 1");
        $newsort = $row['sort'] - 1;
        $oldsort = $row['sort'];
        if ($newsort > 0) {
            if (_query("SELECT id FROM magacms_page WHERE magaid='$id' AND sort='$newsort' LIMIT 1")) {
                _update("UPDATE magacms_page SET sort='$oldsort' WHERE sort='$newsort' AND magaid='$id'");
            }
            _update("UPDATE magacms_page SET sort='$newsort' WHERE id='$pid'");
        } else {
            _update("UPDATE magacms_page SET sort='1' WHERE id='$pid'");
        }
        function_alert('','admin_maga_edit.php?info=排序成功！&icon=succeed&id=' . $id . '&pid=' . $pid . '#pagelist');
    }
    //手动生成缩略图
    function function_mphoto() {
        $id = $_GET['id'];
        $pid = $_GET['pid'];
        if (!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")) {
            function_alert('', 'admin_maga.php?info=生成失败，当前期刊不存在！&icon=error#pagelist');
        }
        $row = _query("SELECT width,height,picdir FROM magacms_maga WHERE id='$id' LIMIT 1");
        $picdir = $row['picdir'];
        $width = $row['width'];
        $height = $row['height'];
        if (!_query("SELECT id FROM magacms_page WHERE id='$pid' LIMIT 1")) {
            function_alert('', 'admin_maga_edit.php?info=生成失败，指定版面不存在！&icon=error&id=' . $id . '#pagelist');
        }
        $row = _query("SELECT id,photo FROM magacms_page WHERE id='$pid' LIMIT 1");
        $photo = $row['photo'];
        if (!_isfolder('../upload/' . $picdir . '/' . $photo)) {
            function_alert('', 'admin_maga_edit.php?info=生成失败，指定版面文件丢失！&icon=error&id=' . $id . '#pagelist');
        }
        $resizeimage = new resizeimage("../upload/$picdir/$photo", $width, $height, "0", "../upload/$picdir/resize/$photo");
        function_alert('', 'admin_maga_edit.php?id=' . $id .'&info=生成缩略图成功！&icon=succeed');
    }
    //编辑系统设置
    function function_editsystem() {
        $pagenum = function_cleanstr($_POST['pagenum']);
        $sort = function_cleanstr($_POST['sort']);
        $gbook = function_cleanstr($_POST['gbook']);
        $adtime = function_cleanstr($_POST['adtime']);
        $adphoto = function_cleanstr($_POST['adphoto']);
        $adlink = function_cleanstr($_POST['adlink']);
        $rewrite = function_cleanstr($_POST['rewrite']);
        if ($pagenum <= 0 || $pagenum > 50 || !is_numeric($pagenum) || !function_strlen($pagenum, 0, 2)) {
            function_alert('', 'admin_system.php?info=首页期刊数量必须为1~50之间的数字！&icon=error');
        }
        if (!function_strlen($adlink, 0, 255)) {
            function_alert('', 'admin_system.php?info=广告链接必须为0~255之内！&icon=error');
        }
        if ($adtime < 0 || $adtime > 60 || is_int($adtime)) {
            function_alert('', 'admin_system.php?info=广告展示时间必须为0~60之内的数字！&icon=error');
        }
        if ($adphoto == '无广告图片') {
                $adphoto = '';
        }
        if ($adtime != 0 && $adphoto == '') {
            function_alert('', 'admin_system.php?info=广告时间不为0时必须上传一张广告图片！&icon=error');
        }
        $row = _query("SELECT adphoto FROM magacms_system");
        if ($row['adphoto'] != $adphoto && $row['adphoto'] != '') {
            _delfile('../upload/showad/' . $row['adphoto']);
            @$resizeimage = new resizeimage("../upload/showad/$adphoto", "600", "300", "0", "../upload/showad/$adphoto");
        } else {
            @$resizeimage = new resizeimage("../upload/showad/$adphoto", "600", "300", "0", "../upload/showad/$adphoto");
        }
        _update("UPDATE magacms_system SET pagenum='$pagenum',sort='$sort',gbook='$gbook',adtime='$adtime',adphoto='$adphoto',adlink='$adlink',rewrite='$rewrite'");
        if ($pagenum % 5 == 0) {
            function_alert('', 'admin_system.php?info=编辑成功！&icon=succeed');
        }
        function_alert('', 'admin_system.php?info=编辑成功，但是为了首页界面美观，建议把“首页期刊数量”设置为5的倍数！&icon=succeed');
    }
    //退出登录
    function function_logout() {
        unset($_SESSION['username']);
        function_alert('您已经安全退出后台！', '../');
        exit();
    }
    //编辑期刊栏目
    function function_edittype() {
            function_safety();
            $id = $_GET['id'];
            $typename = function_cleanstr($_POST['typename']);
            $typesort = function_cleanstr($_POST['typesort']);
            if (!_query("SELECT id FROM magacms_type WHERE id='$id'")) {
                function_alert('', 'admin_type.php?info=期刊栏目不存在！&icon=error');
            }
            if ($typename == '') {
                function_alert('', 'admin_type_edit.php?id='.$id.'&info=期刊名称必填！&icon=error');
            }
            if (!function_strlen($typename, 2, 10)) {
                function_alert('', 'admin_type_edit.php?id='.$id.'&info=期刊栏目名称长度必须在2~10个字符！&icon=error');
            }
            if ($typesort != '') {
                if (!is_numeric($typesort) || $typesort < 0) {
                    $typesort = 0;
                }
            } else {
                $typesort = 0;
            }
            _update("UPDATE magacms_type SET name='$typename',sort='$typesort' WHERE id='$id'");
            function_alert('', 'admin_type_edit.php?id='.$id.'&info=期刊栏目编辑成功！&icon=succeed');
    }
    //删除期刊栏目
    function function_deltype() {
            function_safety();
            $id = $_GET['id'];
            if (!_query("SELECT id FROM magacms_type WHERE id='$id' LIMIT 1")) {
                function_alert('', 'admin_type.php?info=删除失败，指定栏目不存在！&icon=error');
            }
            if (_query("SELECT id FROM magacms_maga WHERE typeid='$id' LIMIT 1")) {
                function_alert('', 'admin_type.php?info=删除失败，请先清空本栏目下的期刊！&icon=error');
            }
            _deldate("DELETE FROM magacms_type WHERE id='$id'");
            function_alert('', 'admin_type.php?info=期刊栏目删除成功！&icon=succeed');
    }
    //添加期刊栏目
    function function_addtype() {
	function_safety();
	$typename = function_cleanstr($_POST['typename']);
	$typesort = function_cleanstr($_POST['typesort']);
	if ($typename == '') {
            function_alert('', 'admin_type_add.php?info=添加失败，期刊名称必填！&icon=error');
	}
	if (!function_strlen($typename, 2, 10)) {
            function_alert('', 'admin_type_add.php?info=添加失败，期刊名称长度必须在2~10个字符！&icon=error');
	}
	if ($typesort != '') {
            if (!is_numeric($typesort) || $typesort < 0) {
                $typesort = 0;
            }
	} else {
            $typesort = 0;
	}
	_insert("INSERT INTO magacms_type(name,sort) VALUES ('$typename','$typesort')");
	function_alert('', 'admin_type.php?info=期刊栏目添加成功！&icon=succeed');
    }

////function_addpage
////添加期刊版面
//function function_addpage(){
//    function_safety();
//    $id=$_GET['id'];
//    $photo=$_POST['photo'];
//	if($photo==''){
//        function_alert('添加版面失败，版面文件不能为空！', '');
//        exit();
//	}
//    if(!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")){
//        function_alert('添加版面失败，指定期刊不存在！', '');
//        exit();
//    }
//    $row=_query("SELECT picdir,width,height,mwidth,mheight FROM magacms_maga WHERE id='$id' LIMIT 1");
//    $picdir=$row['picdir'];
//    $width=$row['width'];
//    $height=$row['height'];
//    $mwidth=$row['mwidth'];
//    $mheight=$row['mheight'];
//    $pagen=_mysqlnum("SELECT id FROM magacms_page WHERE magaid='$id'")+1;
//    _insert("INSERT INTO magacms_page(photo,magaid,sort) VALUES ('$photo','$id','$pagen')");
//    @$resizeimage = new resizeimage("../upload/$picdir/$photo",$width,$height,"2","../upload/$picdir/resize/$photo");//创建小图
//    @$resizeimage = new resizeimage("../upload/$picdir/$photo",$mwidth,$mheight,"2","../upload/$picdir/$photo");//重生大图
//    function_alert('', 'admin_maga_edit.php?id='.$id.'#uppage');
//    exit();
//}
    //删除版面
    function function_delpage() {
        function_safety();
        $pid = function_cleanstr($_GET['pid']);
        $id = function_cleanstr($_GET['id']);
        if (!_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")) {
            function_alert('', 'admin_maga.php?info=删除失败，期刊不存在或者已被删除！&icon=error');
        }
        $row = _query("SELECT id,picdir FROM magacms_maga WHERE id='$id' LIMIT 1");
        $picdir = $row['picdir'];
        if (!_query("SELECT * FROM magacms_page WHERE id='$pid' LIMIT 1")) {
            function_alert('', 'admin_maga_edit.php?id=' . $id . '&info=删除失败，版面不存在或者已被删除！&icon=error');
        }
        $row = _query("SELECT * FROM magacms_page WHERE id='$pid' LIMIT 1");
        $oldsort = $row['sort'];
        _delfile("../upload/" . $picdir . "/" . $row['photo']);
        _delfile("../upload/" . $picdir . "/resize/" . $row['photo']);
        _deldate("DELETE FROM magacms_page WHERE id='$pid'");
        //删除其中一个版面，重排其余版面排序
        $result = $_conn->query("SELECT * FROM magacms_page WHERE magaid='$id' AND sort>'$oldsort' ORDER BY sort ASC");
        while (!!$row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $pid = $row['id'];
            $sort = $row['sort'] - 1;
            _update("UPDATE magacms_page SET sort='$sort' WHERE id='$pid'");
        }
        function_alert('', 'admin_maga_edit.php?id=' . $id . '&info=版面删除成功！&icon=succeed#pagelist');
    }
    //删除期刊缩略图
    function function_delico() {
        function_safety();
        $id = function_cleanstr($_GET['id']);
        if (_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")) {
            $row = _query("SELECT id,photo FROM magacms_maga WHERE id='$id' LIMIT 1");
            _delfile("../upload/magaico/" . $row['photo']);
            _update("UPDATE magacms_maga SET photo='' WHERE id='$id'");
            function_alert('', 'admin_maga_edit.php?id=' . $id .'&info=缩略图删除成功！&icon=succeed');
        } else {
            function_alert('', 'admin_maga_edit.php?id=' . $id .'&info=删除失败，指定期刊ID不存在！&icon=error');
        }
    }
    //删除期刊pdf
    function function_delpdf() {
        function_safety();
        $id = function_cleanstr($_GET['id']);
        if (_query("SELECT id FROM magacms_maga WHERE id='$id' LIMIT 1")) {
            $row = _query("SELECT id,pdf FROM magacms_maga WHERE id='$id' LIMIT 1");
            _delfile("../upload/magapdf/" . $row['pdf']);
            _update("UPDATE magacms_maga SET pdf='' WHERE id='$id'");
            function_alert('', 'admin_maga_edit.php?id=' . $id .'&info=PDF文件删除成功！&icon=succeed');
        } else {
        function_alert('', 'admin_maga_edit.php?id=' . $id .'&info=删除失败，指定期刊ID不存在！&icon=error');
        }
    }
    //编辑站点信息
    function function_siteinfo() {
        function_safety();
        $sitename = function_cleanstr($_POST['sitename']);
        $siteurl = function_cleanstr($_POST['siteurl']);
        $sitekey = function_cleanstr($_POST['sitekey']);
        $sitedes = function_cleanstr($_POST['sitedes']);
        $sitetj = function_cleanstr($_POST['sitetj']);
        $siteicp = function_cleanstr($_POST['siteicp']);
        $siteright = function_cleanstr($_POST['siteright']);
        if (!function_strlen($sitename, 2, 50)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点名称长度必须在2~50个字符！&icon=error');
        }
        if (!function_strlen($siteurl, 3, 50)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点域名长度必须在3~50个字符！&icon=error');
        }
        if (!function_strlen($sitekey, 0, 200)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点关键词不能超过200个字符！&icon=error');
        }
        if (!function_strlen($sitedes, 0, 255)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点描述不能超过255个字符！&icon=error');
        }
        if (!function_strlen($sitetj, 0, 255)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点统计不能超过255个字符！&icon=error');
        }
        if (!function_strlen($siteicp, 0, 20)) {
            function_alert('', 'admin_siteinfo.php?info=站点备案信息不能超过20个字符！&icon=error');
        }
        if (!function_strlen($siteright, 0, 500)) {
            function_alert('', 'admin_siteinfo.php?info=编辑失败，站点版权信息不能超过500个字符！&icon=error');
        }
        $row = _query("SELECT * FROM magacms_siteinfo LIMIT 1");
        _update("UPDATE magacms_siteinfo SET sitename='$sitename',siteurl='$siteurl',sitekey='$sitekey',sitedes='$sitedes',sitetj='$sitetj',siteicp='$siteicp',siteright='$siteright'");
        function_alert('', 'admin_siteinfo.php?info=编辑成功！&icon=succeed');
    }
    //编辑期刊
    function function_editmaga() {
            function_safety();
            $id = function_cleanstr($_GET['id']);
            $maganame = function_cleanstr($_POST['maganame']);
            $intime = function_cleanstr($_POST['intime']);
            $photo = function_cleanstr($_POST['photo']);
            $width = function_cleanstr($_POST['width']);
            $height = function_cleanstr($_POST['height']);
            $mwidth = function_cleanstr($_POST['mwidth']);
            $mheight = function_cleanstr($_POST['mheight']);
            $pdf = function_cleanstr($_POST['pdf']);
            $type = function_cleanstr($_POST['type']);
            if ($type == '0') {
                function_alert('', 'admin_maga_edit.php?id='.$id.'&info=编辑失败，期刊栏目无效！&icon=error');
            }
            if ($maganame == '') {
                function_alert('', 'admin_maga_edit.php?id='.$id.'&info=编辑失败，期刊名称必填！&icon=error');
            }
            if (!function_strlen($maganame, 2, 18)) {
                function_alert('', 'admin_maga_edit.php?id='.$id.'&info=编辑失败，期刊名称长度必须在2~18位！&icon=error');
            }
            if (!function_strlen($width, 0, 4) || !function_strlen($mwidth, 0, 4) || !
                function_strlen($height, 0, 4) || !function_strlen($mheight, 0, 4)) {
                function_alert('', 'admin_maga_edit.php?id='.$id.'&info=编辑失败，期刊尺寸数字必须为4位以内！&icon=error');
            }
            if ($width != '') {
                if (!is_numeric($width) || $width <= 0) {
                    $width = 295;
                }
            } else {
                $width = 295;
            }
            if ($height != '') {
                if (!is_numeric($height) || $height <= 0) {
                    $height = 450;
                }
            } else {
                $height = 450;
            }
            if ($mwidth != '') {
                if (!is_numeric($mwidth) || $mwidth <= 0) {
                    $mwidth = 1000;
                }
            } else {
                $width = 1000;
            }
            if ($mheight != '') {
                if (!is_numeric($mheight) || $mheight <= 0) {
                    $mheight = 1430;
                }
            } else {
                $mheight = 1430;
            }
            if ($intime == '') {
                $intime = date('Y-m-d H:i:s', time());
            }
            if (_query("SELECT * FROM magacms_maga WHERE id='$id' LIMIT 1")) {
                $row = _query("SELECT * FROM magacms_maga WHERE id='$id'");
                if (!_isfolder('../upload/' . $row['picdir'])) {
                    _folder('../upload/' . $row['picdir']);
                }
                if (!_isfolder('../upload/' . $row['picdir'] . '/resize')) {
                    _folder('../upload/' . $row['picdir'] . '/resize', 0777);
                }
                if ($row['photo'] != $photo && $row['photo'] != '') {
                    //如果期刊缩略图发生改变，证明是替换过的，要删除原来的；
                    if (_isfolder('../upload/magaico/' . $row['photo'])) {
                        _delfile('../upload/magaico/' . $row['photo']);
                    }
                }
                if ($row['pdf'] != $pdf && $row['pdf'] != '') {
                    //如果期刊pdf发生改变，证明是替换过的，要删除原来的；
                    if (_isfolder('../upload/magapdf/' . $row['pdf'])) {
                        _delfile('../upload/magapdf/' . $row['pdf']);
                    }
                }
                if ($photo == '无缩略图') {
                    $photo = '';
                }
                if ($pdf == '无PDF文件') {
                    $pdf = '';
                }
                if ($photo != '') {
                    @$resizeimage = new resizeimage("../upload/magaico/$photo", "206", "290", "0", "../upload/magaico/$photo");
                }
                _update("UPDATE magacms_maga SET maganame='$maganame',intime='$intime',photo='$photo',typeid='$type',width='$width',height='$height',mwidth='$mwidth',mheight='$mheight',pdf='$pdf' WHERE id='$id'");
                function_alert('', 'admin_maga_edit.php?id='.$id.'&info=期刊编辑成功！&icon=succeed');
            } else {
                function_alert('', 'admin_maga.php?info=编辑失败，指定期刊不存在！&icon=error');
            }
    }
    //删除期刊
    function function_delmaga() {
            function_safety();
            $id = function_cleanstr($_GET['id']);
            $row = _query("SELECT * FROM magacms_maga WHERE id='$id'");
            $picdir = $row['picdir'];
            if (_query("SELECT * FROM magacms_maga WHERE id='$id'")) {
                _delfolder('../upload/' . $picdir); //删除该期刊版面上传文件夹
                if (_isfolder('../upload/magaico/' . $row['photo']) && $row['photo'] != '') { //如果ico缩略图存在就删除
                    _delfile('../upload/magaico/' . $row['photo']);
                }
                if (_isfolder('../upload/magapdf/' . $row['pdf']) && $row['pdf'] != '') { //如果有pdf存在就删除
                    _delfile('../upload/magapdf/' . $row['pdf']);
                }
                _deldate("DELETE FROM magacms_maga WHERE id='$id'");
                _deldate("DELETE FROM magacms_page WHERE magaid='$id'");
                _deldate("DELETE FROM magacms_gbook WHERE magaid='$id'");
                function_alert('', 'admin_maga.php?info=期刊删除成功！&icon=succeed');
            } else {
                function_alert('', 'admin_maga.php?info=删除失败，指定期刊不存在！icon=error');
            }
    }
    //新增期刊
    function function_addmaga() {
        function_safety();
        $maganame = function_cleanstr($_POST['maganame']);
        $intime = function_cleanstr($_POST['intime']);
        $photo = function_cleanstr($_POST['photo']);
        $width = function_cleanstr($_POST['width']);
        $height = function_cleanstr($_POST['height']);
        $mwidth = function_cleanstr($_POST['mwidth']);
        $mheight = function_cleanstr($_POST['mheight']);
        $pdf = function_cleanstr($_POST['pdf']);
        $type = function_cleanstr($_POST['type']);
            if ($type == '0') {
                function_alert('', 'admin_maga_add.php?info=新增失败，期刊栏目无效！&icon=error');
            }
            if ($maganame == '') {
                function_alert('', 'admin_maga_add.php?info=新增失败，期刊名称必填！&icon=error');
            }
            if (!function_strlen($maganame, 2, 18)) {
                function_alert('', 'admin_maga_add.php?info=新增失败，期刊名称长度必须在2~18位！&icon=error');
            }
            if (!function_strlen($width, 0, 4) || !function_strlen($mwidth, 0, 4) || !
                function_strlen($height, 0, 4) || !function_strlen($mheight, 0, 4)) {
                function_alert('', 'admin_maga_add.php?info=新增失败，期刊尺寸数字必须为4位以内！&icon=error');
            }
            if ($width != '') {
                if (!is_numeric($width) || $width <= 0) {
                    $width = 295;
                }
            } else {
                $width = 295;
            }
            if ($height != '') {
                if (!is_numeric($height) || $height <= 0) {
                    $height = 450;
                }
            } else {
                $height = 450;
            }
            if ($mwidth != '') {
                if (!is_numeric($mwidth) || $mwidth <= 0) {
                    $mwidth = 1000;
                }
            } else {
                $width = 1000;
            }
            if ($mheight != '') {
                if (!is_numeric($mheight) || $mheight <= 0) {
                    $mheight = 1430;
                }
            } else {
                $mheight = 1430;
            }
            if ($intime == '') {
                $intime = date('Y-m-d H:i:s', time());
            }
            $picdir = date('YmdHis');
            if ($photo != '') {
                $resizeimage = new resizeimage("../upload/magaico/$photo", "206", "290", "0", "../upload/magaico/$photo");
            }
            _folder('../upload/' . $picdir, 0777); //创建期刊版面文件夹
            _folder('../upload/' . $picdir . '/resize', 0777); //创建期刊版面小图文件夹
            _insert("INSERT INTO magacms_maga(maganame,intime,photo,picdir,typeid,width,height,mwidth,mheight,pdf) VALUES ('$maganame','$intime','$photo','$picdir','$type','$width','$height','$mwidth','$mheight','$pdf')");
            $row = _query("SELECT id FROM magacms_maga ORDER BY id DESC LIMIT 1");
            function_alert('', 'admin_maga_edit.php?id=' . $row['id'] . '&info=期刊新增成功，接下来你可以为本期刊上传版面！&icon=succeed');
    }
    //验证是否登录状态
    function function_safety() {
        //$_COOKIE['username']可用cookie来记忆
        if (isset($_SESSION['username'])) {
            if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                function_alert('', 'admin_main.php');
            }
        } else {
            if (basename($_SERVER['PHP_SELF']) != 'index.php') {
                function_alert('你尚未登录，请先登录后再进行操作！', 'index.php');
            }
        }
    }
    //登录判断
    function function_login() {
        session_start();
        function_safety();
        $username = function_cleanstr($_POST['username']);
        $password = md5($_POST['password']);
        $code = md5(strtoupper($_POST['code']));
        if ($username == '' or $password == '') {
            function_alert('用户名和密码不能为空！', 'index.php');
        }
        if ($code != $_SESSION['code']) {
            function_alert('验证码错误！', 'index.php');
        }
        if (!_query("SELECT * FROM magacms_user WHERE username='$username' AND password='$password' LIMIT 1")) {
            function_alert('用户名和密码错误！', 'index.php');
        }
        $intime = date('Y-m-d H:i:s', time());
        $inip = function_getRealIp();
        // setcookie('username',  md5($username)); //采用cookie记忆登录状态
        $_SESSION['username'] = $username; //采用session记忆登录状态
        _update("UPDATE magacms_user SET intime='$intime',inip='$inip' WHERE username='$username'");
        function_alert('', 'admin_main.php');
    }
    //新增管理员
    function function_adduser() {
            function_safety();
            $username = function_cleanstr($_POST['username']);
            $password = function_cleanstr($_POST['password']);
            $password2 = function_cleanstr($_POST['password2']);
            if ($username == '' | $password == '' | $password2 == '') {
                function_alert('', 'admin_user.php?info=新增失败，用户名、密码必填！&icon=error');
            }
            if ($password != $password2) {
                function_alert('', 'admin_user.php?info=新增失败，两次密码不一样！&icon=error');
            }
            if (!function_strlen($username, 3, 10)) {
                function_alert('', 'admin_user.php?info=新增失败，用户名长度必须在3~10位！&icon=error');
            }
            if (!function_strlen($password, 5, 18)) {
                function_alert('', 'admin_user.php?info=新增失败，密码长度必须在5~18位！&icon=error');
            }
            if (_query("SELECT * FROM magacms_user WHERE username='$username' LIMIT 1")) {
                function_alert('', 'admin_user.php?info=新增失败，该管理员已经存在，请重新增加！&icon=error');
            } else {
                $intime = date('Y-m-d H:i:s', time());
				$inip = function_getRealIp();
                _insert("INSERT INTO magacms_user(username,password,intime,inip) VALUES ('$username',md5('$password'),'$intime','$inip')");
                function_alert('', 'admin_user.php?info=管理员新增成功！&icon=succeed');
            }
    }
    //删除管理员
    function function_deluser() {
        function_safety();
        $id = function_cleanstr($_GET['id']);
        $row = _query("SELECT * FROM magacms_user WHERE id='$id' LIMIT 1");
        $username = $row['username'];
        if (md5($username) == md5($_SESSION['username'])) { //$_COOKIE
            function_alert('', 'admin_user.php?info=删除失败，当前处于登录状态的管理员不能删除！&icon=error');
        }
        if (mysqli_num_rows($_conn->query("SELECT * FROM magacms_user")) <= 1) {
            function_alert('', 'admin_user.php?info=删除失败，最后一个管理员不能被删除！&icon=error');
        }
        if (_query("SELECT * FROM magacms_user WHERE id='$id' LIMIT 1")) {
            _deldate("DELETE FROM magacms_user WHERE id='$id'");
            function_alert('', 'admin_user.php?info=删除管理员成功！&icon=succeed');
        } else {
            function_alert('', 'admin_user.php?info=删除失败，指定管理员不存在！&icon=error');
        }
    }
    //编辑管理员
    function function_edituser() {
        function_safety();
        $id = function_cleanstr($_GET['id']);
        $username = function_cleanstr($_POST['username']);
        $passwordold = md5($_POST['passwordold']);
        $password = function_cleanstr($_POST['password']);
        $password2 = function_cleanstr($_POST['password2']);
        if ($passwordold == '' | $password == '' | $password2 == '') {
            function_alert('', 'admin_user_edit.php?id='.$id.'&info=编辑失败，原始密码、新密码、新密码确认都不能为空！&icon=error');
        }
        if ($password != $password2) {
            function_alert('', 'admin_user_edit.php?id='.$id.'&info=编辑失败，两次密码不一样！&icon=error');
        }
        if (!function_strlen($password, 5, 18)) {
            function_alert('', 'admin_user_edit.php?id='.$id.'&info=编辑失败，密码长度必须在5~18位！&icon=error');
        }
        if (!_query("SELECT * FROM magacms_user WHERE id='$id' AND password='$passwordold' LIMIT 1")) {
            function_alert('', 'admin_user_edit.php?id='.$id.'&info=编辑失败，原始密码不正确！&icon=error');
        }
        if (_query("SELECT * FROM magacms_user WHERE id='$id' LIMIT 1")) {
            _update("UPDATE magacms_user SET password=md5('$password') WHERE id='$id'");
            function_alert('', 'admin_user_edit.php?id='.$id.'&info=管理员编辑成功！&icon=succeed');
        } else {
            function_alert('', 'admin_user.php?info=编辑失败，指定管理员不存在！&icon=error');
        }
    }
?>