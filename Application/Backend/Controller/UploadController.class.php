<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;

class UploadController extends MasterController {

        private $errorMsg;

        public function index(){
                $this->display();
        }

        public function imgsave(){
                $json = array();
                if(isset($_FILES['upload_file'])){
                        $type = I('post.type', '');
                        $rootpath = UPLOAD_PATH;
                        if($type == 'magaphoto'){
                                $rootpath = UPLOAD_PATH.'magaico/';
                        }
                        $config = array(
                                'maxSize'    =>    3145728,
                                'rootPath'   =>    $rootpath,
                                'savePath'   =>    '',
                                'saveName'   =>    array('uniqid',''),
                                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                                'autoSub'    =>    true,
                                'subName'    =>    array('date', 'Ymd'),
                        );
                        $upload = new \Think\Upload($config); // 实例化上传类
                        // 上传单个文件 
                        $info   =   $upload->uploadOne($_FILES['upload_file']);
                        if(!$info) {// 上传错误提示错误信息
                                $this->errorMsg = $upload->getError();
                        }else{// 上传成功
                                $realpath = $info['savepath'].$info['savename'];
                                if($type == 'magaphoto'){
                                        $destpath = $rootpath.$realpath;
                                        //压缩
                                        $image = new \Think\Image(); 
                                        $image->open($destpath);
                                        $image->thumb(206, 290, \Think\Image::IMAGE_THUMB_FILLED)->save($destpath);
                                }
                                $json = array(
                                        'success' => 1,
                                        'realpath' => $realpath
                                );
                        }
                }else{
                        $this->errorMsg = '请求数据错误';
                }
                if($this->errorMsg){
                        $json = array(
                            'error' => 1,
                            'msg' => $this->errorMsg
                        );
                }
                $this->ajaxReturn($json);
        }
}
