<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;

class TopicController extends MasterController {

        private $errorMsg;

        public function index(){
                $page = I('get.page', 1);
                $total = M('type')->count();
                $topiclist = array();
                $topicsum_result = array();
                if($total>0){
                        $limit = \Utils::getLimitByPage($total, 10, $page);
                        $topiclist = M('type')->field('id,sort,name')->limit($limit, 10)->order('sort DESC')->select();
                        $topic_ids = array_column($topiclist, 'id');
                        $topicsum_query = M('maga')->field("COUNT(typeid) AS total,typeid")->where("typeid IN ('". implode("','", $topic_ids) ."')")->group("typeid")->select();
                        if($topicsum_query){
                                $topicsum_result = array_column($topicsum_query, 'total', 'typeid');
                        }
                        foreach ($topiclist as &$entries){
                                $entries['total'] = isset($topicsum_result[$entries['id']]) ? $topicsum_result[$entries['id']] : 0;
                        }
                }
                $url = \Utils::link('/backend/topic', 'page={page}');
                $pageination = parent::pagination($url, $total);
                $this->assign('pageination', $pageination);
                $this->assign('topiclist', $topiclist);
                $this->display();
        }

        public function edit(){
                $id = I('get.id');
                $typeinfo = M('type')->field('id,sort,name')->where("id='{$id}'")->find();
                if(!$typeinfo){
                        $this->error('不存在的栏目信息');
                }
                $this->assign('typeinfo', $typeinfo);
                $this->display();
        }

        public function add(){
                $this->display();
        }

        public function addAction(){
                $json = array();
                $name = I('post.typename', '');
                $sort = (int)I('post.sort', '0');
                if($sort>-1 && $sort<100 && mb_strlen($name)>1 && mb_strlen($name)<11){
                        $userinfo = M('type')->where("name='{$name}'")->find();
                        if($userinfo){
                                $this->errorMsg = '该专栏名称已存在';
                        }else{
                                $add_data = array(
                                    'name' => $name,
                                    'sort' => $sort
                                );
                                if(M('type')->add($add_data)){
                                        $json = array(
                                            'success' => 1,
                                            'redirect' => '/backend/topic'
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
                $name = I('post.typename', '');
                $sort = (int)I('post.sort', '0');
                if($id != '' && mb_strlen($name)>1 && mb_strlen($name)<11){
                        $typeinfo = M('type')->where("id='{$id}'")->find();
                        if($typeinfo){
                                $updatedata = array(
                                    'name' => $name,
                                    'sort' => $sort,
                                    'utime' => time()
                                );
                                if(M('type')->data($updatedata)->where("id='{$id}'")->save()){
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '不存在的栏目数据';
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
                        $typeinfo = M('type')->where("id='{$id}'")->find();
                        if($typeinfo){
                                if(M('type')->where("id='{$id}'")->delete()){
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '不存在的专栏记录';
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
