<?php
namespace Backend\Controller;
use Think\Controller;
use Backend\Model\IdentityAuth;
class MasterController extends Controller {

        public function _initialize() {
                import('ORG.Util.Utils');
                $adminAuth = IdentityAuth::getInstance();
                if(!$adminAuth->hasLogin()){
                         if(IS_AJAX){
                                 $json = array(
                                     'error' => '1',
                                     'redirect' => '/backend'
                                 );
                                 $this->ajaxReturn($json);
                         }else{
                                 header('Location: /backend');
                         }
                         exit();
                }
        }
        
        public function index(){

        }

        public function pagination($url, $total, $pagesize = 10, $page=''){
                import('Org.Page.Pageination');
                if($page==''){
                        $page = I('get.page', 1);
                }
                $pageination = new \Pageination();
                $pageination->url = $url;
                $pageination->total = $total;
                $pageination->page = $page;
                $pageination->limit = $pagesize;
                return $pageination->render();
        }
}
