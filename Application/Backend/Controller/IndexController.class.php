<?php
namespace Backend\Controller;
use Think\Controller;
use Backend\Model\AdminModel;
use Backend\Model\IdentityAuth;

class IndexController extends Controller {
        private $errorMsg;
        
        public function _initialize() {
                import('ORG.Util.Utils');
        }

        public function index(){
                $this->display();
        }

        public function getverify(){
                $Verify = new \Think\Verify();
                $Verify->fontSize = 30;
                $Verify->codeSet = '0123456789';
                $Verify->length   = 4;
                $Verify->useNoise = false;
                $Verify->entry();
        }

        public function login(){
                $json = array();
                $username = I('post.username', '');
                $password = I('post.password', '');
                $code = I('post.code', '');
                if($username == '' || $password == '' || $code == ''){
                        $this->errorMsg = '请求数据错误';
                }else{
                        $verify = new \Think\Verify();
                        if($verify->check($code)){
                                $adminMod = new AdminModel();
                                $userinfo = $adminMod->findOne(array('username' => $username, 'password' => $password));
                                if(!$userinfo){
                                        $this->errorMsg = '用户名或密码错误';
                                }else{
                                        $adminAuth = IdentityAuth::getInstance();
                                        $adminAuth->setUser($userinfo);
                                        $id = $userinfo['id'];
                                        $ip = \Utils::get_client_ip();
                                        M('admin')->data(array('inip' => $ip))->where("id='{$id}'")->save();
                                }
                        }else{
                                $this->errorMsg = '验证码错误';
                        }
                }
                if($this->errorMsg){
                        $json = array(
                            'error' => '1',
                            'msg' => $this->errorMsg
                        );
                }else{
                        $json = array(
                            'success' => '1',
                            'redirect' => U('/backend/main')
                        );
                }
                $this->ajaxReturn($json);
        }
}