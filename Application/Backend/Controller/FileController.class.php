<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;

class FileController extends MasterController {
	public function index() {
		$filter_name = I('get.filter_name', null);
                                    $directory = I('get.directory', null);
                                    $page = I('get.page', 1);

		if ($filter_name) {
			$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $filter_name), '/');
		}

		// Make sure we have the correct directory
		if ($directory) {
			$directory = rtrim(UPLOAD_PATH . 'cache/' . str_replace(array('../', '..\\', '..'), '', $directory), '/');
		} else {
			$directory = UPLOAD_PATH . 'cache';
		}

		$data['images'] = array();

		// Get directories
		$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

		if (!$directories) {
			$directories = array();
		}

		// Get files
		$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

		if (!$files) {
			$files = array();
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if (isset($this->request->get['target'])) {
					$url .= '&target=' . $this->request->get['target'];
				}

				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}

				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => \Utils::utf8_substr($image, mb_strlen(UPLOAD_PATH)),
					'href'  => '/backend/file?directory='.urlencode(\Utils::utf8_substr($image, mb_strlen(UPLOAD_PATH . 'cache/'))) . $url
				);
			} elseif (is_file($image)) {
                                                                        if(strpos($image, '_mid.')){
                                                                                $thumb = '/upload/cache/'.ltrim($image, UPLOAD_PATH . 'cache/');
                                                                                $destimg = substr($thumb, 0, strrpos($thumb, '_mid.')).substr($thumb, strrpos($thumb, '_mid.')+4);
                                                                                echo $destimg;
                                                                                $data['images'][] = array(
                                                                                        //'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
                                                                                        'thumb' => $thumb,
                                                                                        'name'  => implode(' ', $name),
                                                                                        'type'  => 'image',
                                                                                        'path'  => \Utils::utf8_substr($image, mb_strlen(UPLOAD_PATH)),
                                                                                        'href'  => $destimg
                                                                                );
                                                                        }
			}
		}

		if ('' != I('get.directory', '')) {
			$data['directory'] = urlencode(I('get.directory'));
		} else {
			$data['directory'] = '';
		}

		if ('' != I('get.filter_name', '')) {
			$data['filter_name'] = I('get.filter_name');
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if ('' != I('get.target', '')) {
			$data['target'] = I('get.target');
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if ('' != I('get.thumb', '')) {
			$data['thumb'] = I('get.thumb');
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if ('' != I('get.directory', '')) {
			$pos = strrpos(I('get.directory'), '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr(I('get.directory'), 0, $pos));
			}
		}

		if ('' != I('get.target', '')) {
			$url .= '&target=' . I('get.target');
		}

		if ('' != I('get.thumb', '')) {
			$url .= '&thumb=' . I('get.thumb');
		}

		$data['parent'] = '/backend/file?v='.time().$url;

		// Refresh
		$url = '';

		if ('' != I('get.directory', '')) {
			$url .= '&directory=' . urlencode(I('get.directory'));
		}

		if ('' != I('get.target', '')) {
			$url .= '&target=' . I('get.target');
		}

		if ('' != I('get.thumb', '')) {
			$url .= '&thumb=' . I('get.thumb');
		}

		$data['refresh'] = '/backend/file?v='.time().$url;

		$url = '';

		if ('' != I('get.directory', '')) {
			$url .= '&directory=' . urlencode(html_entity_decode(I('get.directory'), ENT_QUOTES, 'UTF-8'));
		}

		if ('' != I('get.filter_name', '')) {
			$url .= '&filter_name=' . urlencode(html_entity_decode(I('get.filter_name'), ENT_QUOTES, 'UTF-8'));
		}

		if ('' != I('get.target', '')) {
			$url .= '&target=' .  I('get.target');
		}

		if ('' != I('get.thumb', '')) {
			$url .= '&thumb=' . I('get.thumb');
		}

                                    $url = \Utils::link($url, 'page={page}');
                                    $pageination = parent::pagination($url, $image_total, 16);
                                    $this->assign('data', $data);print_r($data);
                                    $this->assign('pageination', $pageination);
                                    $this->display();
	}

	public function upload() {
		$json = array();
                                    $directory = I('get.directory', null);
		// Make sure we have the correct directory
		if ($directory) {
			$directory = rtrim(UPLOAD_PATH . 'cache/' . str_replace(array('../', '..\\', '..'), '', $directory), '/');
		} else {
			$directory = UPLOAD_PATH . 'cache';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = '不存在的目录！';
		}
                                    $directory != '' && $directory = $directory.'/';

		if (!$json) {
                                                $config = array(
                                                        'maxSize'    =>    3145728,
                                                        'rootPath'   =>    $directory,
                                                        'savePath'   =>    '',
                                                        'saveName'   =>    array('uniqid',''),
                                                        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                                                        'autoSub'    =>    true,
                                                        'subName'    =>    array('date', 'Ym'),
                                                );
                                                $upload = new \Think\Upload($config); // 实例化上传类
                                                // 上传单个文件 
                                                $info   =   $upload->uploadOne($_FILES['file']);
                                                if(!$info) {// 上传错误提示错误信息
                                                        $json['error'] = $upload->getError();
                                                }else{// 上传成功
                                                        $realpath = $info['savepath'].$info['savename'];
                                                        $destpath = $directory.$info['savepath'].$info['savename'];
                                                        $thumb = $directory.$info['savepath'].str_replace('.', '_mid.', $info['savename']);
                                                        //压缩
                                                        $image = new \Think\Image();
                                                        $image->open($destpath);
                                                        $image->thumb(100, 100, \Think\Image::IMAGE_THUMB_FILLED)->save($thumb);

                                                        $json = array(
                                                                'success' => '图片上传成功',
                                                                'realpath' => $realpath
                                                        );
                                                }
                                }
                                if(isset($json['error'])){
                                        $json = array(
                                            'error' => 1,
                                            'msg' => $json['error']
                                        );
                                }else if(!$json['success']){
                                        $json = array(
                                            'error' => 1,
                                            'msg' => '上传失败'
                                        );
                                }
                                $this->ajaxReturn($json);
	}

	public function folder() {
		$json = array();
		$directory = I('get.directory', null);
                                    $folder = I('post.folder');
		// Make sure we have the correct directory
		if ($directory) {
			$directory = rtrim(UPLOAD_PATH . 'cache/' . str_replace(array('../', '..\\', '..'), '', $directory), '/');
		} else {
			$directory = UPLOAD_PATH . 'cache';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = '不存在的目录！';
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($folder, ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((mb_strlen($folder) < 3) || (mb_strlen($folder) > 128)) {
				$json['error'] = '文件夹名长度不合法！';
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = '文件已经存在！';
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);
			$json = array(
                                                                'success' => 1
                                                        );
		}else{
                                                      $json = array(
                                                                'error' => 1,
                                                                'msg' => $json['error']
                                                    );
                                    }

		$this->ajaxReturn($json);
	}

	public function delete() {
		$json = array();
                                    $paths = I('post.path', array());

		// Loop through each path to run validations
                                    if(!empty($paths)){
                                                foreach ($paths as $path) {
                                                        $path = rtrim(UPLOAD_PATH . str_replace(array('../', '..\\', '..'), '', $path), '/');
                                                        // Check path exsists
                                                        if ($path == UPLOAD_PATH . 'cache') {
                                                                $json['error'] = '不可删除的文件夹！';
                                                                break;
                                                        }
                                                }
                                    }

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(UPLOAD_PATH . str_replace(array('../', '..\\', '..'), '', $path), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}
		}

                                    if (!$json) {
			$json = array(
                                                                'success' => 1
                                                        );
		}else{
                                                      $json = array(
                                                                'error' => 1,
                                                                'msg' => $json['error']
                                                    );
                                    }
                                    $this->ajaxReturn($json);
	}
}

