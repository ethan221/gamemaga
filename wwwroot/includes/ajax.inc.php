<?php require_once dirname(__file__) . '/main.inc.php'; function read_dir($dir){ global $ryfile;
	$path = opendir($dir);
	while (false !== ($file = readdir($path))) {
		if ($file != "." && $file != "..") {
			if (is_file($dir . "/" . $file))
				$files[] = $file;
			else
				$dirs[] = $dir . "/" . $file;
		}
	}
	if ($files) {
		natcasesort($files);
		foreach ($files as $file) {
			$dir_ = mb_convert_encoding(str_replace(ROOTDIR . "upload/", "", $dir), "UTF-8",
				"GBK");
			$dir__ = explode('/', $dir_);
			$file = mb_convert_encoding($file, "UTF-8", "GBK");
			echo "<tr>\n";
			if (strtoupper($dir__[0]) == strtoupper("magapdf")) {
				echo "<td class='news'>|—<img src='images/ico_pdf.png'/> ";
			} else {
				echo "<td class='news'>|—<img src='images/ico_photo.gif'/> ";
			}
			echo $file . "</td>";
			if (in_array(strtoupper($dir__[0]), array(
				strtoupper("magaico"),
				strtoupper("bannerpic"),
				strtoupper("magapdf"),
				strtoupper("showad")))) {
				if (_query("SELECT photo FROM magacms_maga WHERE photo='$file'") && strtoupper($dir__[0]) ==
					strtoupper("magaico")) {
					echo "<td width='200px'>正常</td><td width='200px'>保留</td>\n";
				}  else if (_query("SELECT photo FROM magacms_banner WHERE photo='$file'") && strtoupper($dir__[0]) == strtoupper("bannerpic")) {
					echo "<td width='200px'>正常</td><td width='200px'>保留</td>\n";
				} else if (_query("SELECT pdf FROM magacms_maga WHERE pdf='$file'") && strtoupper($dir__[0]) ==
						strtoupper("magapdf")) {
						echo "<td width='200px'>正常</td><td width='200px'>保留</td>\n";
					} else
						if (_query("SELECT adphoto FROM magacms_system WHERE adphoto='$file'") &&
							strtoupper($dir__[0]) == strtoupper("showad")) {
							echo "<td width='200px'>正常</td><td width='200px'>保留</td>\n";
						} else {
							echo "<td width='200px' name='ryfiletr' id='ryfiletr'>冗余</td><td width='200px'><a href='?action=delfile&path=../upload/" .
								$dir_ . "/" . $file . "'>删除</a></td>\n";
							$ryfile++;
						}
			} else
				if (_query("SELECT photo FROM magacms_page WHERE photo='$file'")) {
					echo "<td width='200px'>正常</td><td width='200px'>保留</td>\n";
				} else {
					echo "<td width='200px' name='ryfiletr' id='ryfiletr'>冗余</td><td width='200px'><a href='?action=delfile&path=../upload/" .
						$dir_ . "/" . $file . "'>删除</a></td>\n";
					$ryfile++;
				}
				echo "</tr>\n";
		}
	}
	if ($dirs) {
		natcasesort($dirs);
		foreach ($dirs as $dir) {
			$dir_ = mb_convert_encoding(str_replace(ROOTDIR . "upload/", "", $dir), "UTF-8",
				"GBK");
			$dir__ = explode('/', $dir_);
			echo "<tr>\n";
			echo "<td class='news'><img src='images/ico_folder.gif'/> ";
			echo $dir_ . "</td>";
			if (_query("SELECT picdir FROM magacms_maga WHERE picdir='$dir__[0]'") && count
				($dir__) < 3) {
				if ($dir__[1] == 'resize' || count($dir__) == 1) {
					echo "<td>正常</td><td>保留</td>\n";
					echo "</tr>\n";
					read_dir($dir);
				} else {
					echo "<td name='ryfiletr' id='ryfiletr'>冗余</td><td><a href='?action=delfolder&path=../upload/" .
						$dir_ . "'>删除</a></td>\n";
					$ryfile++;
				}
			} else {
				if (count($dir__) < 2 && in_array(strtoupper($dir__[0]), array(
					strtoupper("magaico"),
					strtoupper("bannerpic"),
					strtoupper("magapdf"),
					strtoupper("showad")))) {
					echo "<td>正常</td><td>保留</td>\n";
					echo "</tr>\n";
					read_dir($dir);
				} else {
					echo "<td name='ryfiletr' id='ryfiletr'>冗余</td><td><a href='?action=delfolder&path=../upload/" .
						$dir_ . "'>删除</a></td>\n";
					$ryfile++;
				}
			}
		}
	}
	closedir($path);
}
if ($_GET['action'] == 'ryfile') {
	$path = ROOTDIR . 'upload';
	echo "<table border='0' cellspacing='0' cellpadding='0'>\n";
	read_dir($path);
	echo "</table>\n";
	if ($ryfile != '') {
            echo "<div id='warning'><div class='wl'></div><div class='wr'>有" . $ryfile . "个冗余！<a href='#ryfiletr'>定位</a></div></div>";
        }
}
?>