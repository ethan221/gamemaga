<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;

class PageController extends MasterController {

        private $errorMsg;

        public function index(){
                $page = I('get.page', 1);
                $typeid =  I('get.typeid', '');
                if($typeid == ''){
                        $total = M('maga')->count();
                }else{
                        $total = M('maga')->where("typeid='{$typeid}'")->count();
                }
                $magalist = array();
                $topic_result = array();
                $page_result = array();
                if($total>0){
                        $limit = \Utils::getLimitByPage($total, 10, $page);
                        if($typeid == ''){
                                $magalist = M('maga')->limit($limit, 10)->order('id DESC')->select();
                        }else{
                                $magalist = M('maga')->where("typeid='{$typeid}'")->limit($limit, 10)->order('id DESC')->select();
                        }
                        $topic_ids = array_column($magalist, 'typeid');
                        $topic_query = M('type')->field("name,id")->where("id IN ('". implode("','", $topic_ids) ."')")->select();
                        if($topic_query){
                                $topic_result = array_column($topic_query, 'name', 'id');
                        }
                        $maga_ids = array_column($magalist, 'id');
                        $page_query = M('page')->field("COUNT(magaid) AS total,magaid")->where("magaid IN ('". implode("','", $maga_ids) ."')")->group('magaid')->select();
                        if($page_query){
                                $page_result = array_column($page_query, 'total', 'magaid');
                        }
                        foreach ($magalist as &$entries){
                                $entries['typename'] = isset($topic_result[$entries['typeid']]) ? $topic_result[$entries['typeid']] : '';
                                $entries['pagatotal'] = isset($page_result[$entries['id']]) ? $page_result[$entries['id']] : 0;
                        }
                        unset($entries);
                }
                $url = \Utils::link('/backend/maga', 'page={page}');
                $pageination = parent::pagination($url, $total);
                $this->assign('pageination', $pageination);
                $this->assign('magalist', $magalist);
                $this->display();
        }

        public function categoryedit(){
                $id = I('get.id', 0);
                $magaid = I('get.magaid', 0);
                $cateinfo = M('page_category')->where("id='{$id}'")->find();
                if(!$cateinfo){
                        $this->error('不存在的版面信息');
                }
                $pagelist = M('page')->field('id,title,author,sort,addtime')->where("magaid='{$magaid}'")->order('sort')->select();
                $this->assign('pagelist', $pagelist);
                $this->assign('cateinfo', $cateinfo);
                $this->display();
        }

        public function edit(){
                $id = I('get.id');
                $pageinfo = M('page')->where("id='{$id}'")->find();
                if(!$pageinfo){
                        $this->error('不存在的文章信息');
                }
                $this->assign('pageinfo', $pageinfo);
                $this->display();
        }

        public function add(){
                $this->display();
        }

        public function addAction(){
                $json = array();
                $title = I('post.title', '');
                $author = I('post.author', '');
                $content = I('post.content', '');
                $sort = I('post.sort', '0');
                $cateid = I('post.categoryid', '');
                $magaid = I('post.magaid', '');
                if($cateid>0 && $magaid>0 && mb_strlen($title)>0 && mb_strlen($title)<33 && mb_strlen($author)>0 && mb_strlen($author)<11 && mb_strlen($content)>0){
                        $add_data = array(
                            'title' => trim($title),
                            'author' => trim($author),
                            'magaid' => $magaid,
                            'categoryid' => $cateid,
                            'content' => $content,
                            'addtime' => date('Y-m-d H:i:s'),
                            'sort' => $sort
                        );
                        if(M('page')->add($add_data)){
                                $json = array(
                                    'success' => 1
                                );
                        }else{
                                $this->errorMsg = '系统错误';
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
                $title = I('post.title', '');
                $author = I('post.author', '');
                $content = I('post.content', '');
                $sort = I('post.sort', '0');
                $id = I('post.id', '');
                if($id>0 && mb_strlen($title)>0 && mb_strlen($title)<33 && mb_strlen($author)>0 && mb_strlen($author)<11 && mb_strlen($content)>0){
                                $updatedata = array(
                                        'title' => trim($title),
                                        'author' => trim($author),
                                        'content' => $content,
                                        'sort' => $sort,
                                        'updatetime' => time()
                                );
                                if(M('page')->data($updatedata)->where("id='{$id}'")->save()){
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
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
                if($id != ''){
                        if(M('page')->where("id='{$id}'")->delete()){
                                $json = array(
                                    'success' => 1
                                );
                        }else{
                                $this->errorMsg = '系统错误';
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

        public function categoryadd(){
                $this->display();
        }

        public function cateaddAction(){
                $json = array();
                $name = I('post.name', '');
                $sort = I('post.sort', '');
                $magaid = I('post.magaid', '');
                if($magaid>0 && mb_strlen($name)>0 && mb_strlen($name)<19){
                        $add_data = array(
                            'magaid' => (int)$magaid,
                            'name' => $name,
                            'sort' => (int)$sort,
                            'update_time' => time()
                        );
                        if(M('page_category')->add($add_data)){
                                $json = array(
                                    'success' => 1
                                );
                        }else{
                                $this->errorMsg = '系统错误';
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
