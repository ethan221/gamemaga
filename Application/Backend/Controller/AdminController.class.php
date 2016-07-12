<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;
use Backend\Model\IdentityAuth;

class AdminController extends MasterController {
        private $errorMsg;
        public function index(){
                $page = I('get.page', 1);
                $total = M('admin')->count();
                $adminlist = array();
                if($total>0){
                        $limit = \Utils::getLimitByPage($total, 10, $page);
                        $adminlist = M('admin')->field('id,username,intime,inip')->limit($limit, 10)->select();
                }
                $url = \Utils::link('/backend/admin', 'page={page}');
                $pageination = parent::pagination($url, $total);
                $this->assign('pageination', $pageination);
                $this->assign('adminlist', $adminlist);
                $this->display();
        }

        public function edit(){
                $id = I('get.id');
                $admininfo = M('admin')->field('id,username,intime,inip')->where("id='{$id}'")->find();
                if(!$admininfo){
                        $this->error('不存在的管理员信息');
                }
                $this->assign('userinfo', $admininfo);
                $this->display();
        }

        public function add(){
                $this->display();
        }

        public function addAction(){
                $json = array();
                $username = I('post.username', '');
                $pwd = I('post.password', '');
                if(strlen($username)>2 && strlen($username)<11 && strlen($pwd)>4 && strlen($pwd)<19){
                        $userinfo = M('admin')->where("username='{$username}'")->find();
                        if($userinfo){
                                $this->errorMsg = '该用户名已存在';
                        }else{
                                $ip = \Utils::get_client_ip();
                                $add_data = array(
                                    'username' => $username,
                                    'password' => MD5($pwd),
                                    'intime' => date('Y-m-d H:i:s'),
                                    'inip' => $ip
                                );
                                if(M('admin')->add($add_data)){
                                        $json = array(
                                            'success' => 1,
                                            'redirect' => '/backend/admin'
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }
                }else{
                        $this->errorMsg = '请求的数据错误';
                }
                if($this->errorMsg){
                        $json = array(
                            'error' => 1,
                            'msg' => $this->errorMsg
                        );
                }
                $this->ajaxReturn($json);
        }

        public function editAction(){
                $json = array();
                $id = I('post.id', '');
                $password = I('post.password', '');
                $pwdold = I('passwordold', '');
                $adminAuth = IdentityAuth::getInstance();
                if($id != ''  && $pwdold != '' && $id == $adminAuth->uid() && strlen($password)>4 && strlen($password)<19){
                        $oldpwd = MD5($pwdold);
                        $admininfo = M('admin')->where("id='{$id}' AND password='{$oldpwd}'")->find();
                        if($admininfo){
                                $updatedata = array(
                                    'password' => MD5($password)
                                );
                                if(M('admin')->data($updatedata)->where("id='{$id}'")->save()){
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '旧密码输入错误';
                        }
                }else{
                        $this->errorMsg = '请求的数据错误';
                }
                if($this->errorMsg){
                        $json = array(
                            'error' => 1,
                            'msg' => $this->errorMsg
                        );
                }
                $this->ajaxReturn($json);
        }
        
       public function delAction(){
                $json = array();
                $id = I('post.id', '');
                $adminAuth = IdentityAuth::getInstance();
                if($id != ''){
                        $admininfo = M('admin')->where("id='{$id}'")->find();
                        if($admininfo){
                                if(M('admin')->where("id='{$id}'")->delete()){
                                        $json = array(
                                            'success' => 1,
                                            'redirect' => '/backend/admin'
                                        );
                                        if($id == $adminAuth->uid()){
                                                $adminAuth->clearIdentity();
                                                $json['redirect'] = '/backend';
                                        }
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '不存在的用户';
                        }
                }else{
                        $this->errorMsg = '请求的数据错误';
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
