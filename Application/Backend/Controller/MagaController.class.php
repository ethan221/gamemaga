<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;

class MagaController extends MasterController {

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

        public function edit(){
                $id = I('get.id');
                $magainfo = M('maga')->where("id='{$id}'")->find();
                if(!$magainfo){
                        $this->error('不存在的期刊信息');
                }
                $typelist = M('type')->field("id,name")->select();
                $categorylist = M('page_category')->where("magaid='{$id}'")->order("sort DESC,id")->select();
                if($categorylist){
                        $ids = array_column($categorylist, 'id');
                        $total_query = M('page')->field("COUNT(categoryid) AS total,categoryid")->where("categoryid IN ('". implode("','", $ids) ."')")->select();
                        if($total_query){
                                $total_result = array_column($total_query, 'total', 'categoryid');
                        }
                        foreach ($categorylist as &$entries){
                                $entries['pagetotal'] = isset($total_result[$entries['id']]) ? $total_result[$entries['id']] : 0;
                        }
                        unset($entries);
                }
                $this->assign('typelist', $typelist);
                $this->assign('categorylist', $categorylist);
                $this->assign('magainfo', $magainfo);
                $this->display();
        }

        public function add(){
                $typelist = M('type')->field("id,name")->select();
                $this->assign('typelist', $typelist);
                $this->display();
        }

        public function addAction(){
                $json = array();
                $name = I('post.maganame', '');
                $type = I('post.type', '');
                $intime = I('post.intime', '');
                $photo = I('post.photo', '');
                $issue = I('post.issue', '0');
                $magasn = I('post.magasn', '');
                $frontnotes = I('post.frontnotes', '');
                if(mb_strlen($name)>1 && mb_strlen($name)<19 && mb_strlen($frontnotes)<1025){
                        $time = $intime == '' ? time() : strtotime($intime);
                        $picdir = date('YmdHis');
                        $add_data = array(
                            'maganame' => $name,
                            'frontnotes' => $frontnotes,
                            'picdir' => $picdir,
                            'typeid' => $type=='' ? '' : (int)$type,
                            'intime' => date('Y-m-d', $time),
                            'year' => date('Y', $time),
                            'month' => date('m', $time),
                            'photo' => $photo,
                            'issue' => (int)$issue,
                            'magasn' => $magasn,
                            'mtime' => time()
                        );
                        if(M('maga')->add($add_data)){
                                $json = array(
                                    'success' => 1,
                                    'redirect' => '/backend/maga'
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
                $id = I('post.id', '');
                $name = I('post.maganame', '');
                $type = I('post.type', '');
                $intime = I('post.intime', '');
                $photo = I('post.photo', '');
                $issue = I('post.issue', '0');
                $magasn = I('post.magasn', '');
                $frontnotes = I('post.frontnotes', '');
                if($id != '' && mb_strlen($name)>1 && mb_strlen($name)<19 && mb_strlen($frontnotes)<1025){
                        $magainfo = M('maga')->where("id='{$id}'")->find();
                        if($magainfo){
                                $time = $intime == '' ? time() : strtotime($intime);
                                $updatedata = array(
                                    'maganame' => $name,
                                    'frontnotes' => $frontnotes,
                                    'typeid' => $type=='' ? '' : (int)$type,
                                    'intime' => date('Y-m-d', $time),
                                    'year' => date('Y', $time),
                                    'month' => date('m', $time),
                                    'photo' => $photo,
                                    'issue' => (int)$issue,
                                    'magasn' => $magasn,
                                    'mtime' => time()
                                );
                                if(M('maga')->data($updatedata)->where("id='{$id}'")->save()){
                                        if($magainfo['photo'] <> $photo){
                                                $destfile = UPLOAD_PATH.'magaico/'.$magainfo['photo'];
                                                if(is_file($destfile)){
                                                        @unlink($destfile);
                                                }
                                        }
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '不存在的期刊数据';
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
                        $magainfo = M('maga')->where("id='{$id}'")->find();
                        if($magainfo){
                                if(M('maga')->where("id='{$id}'")->delete()){
                                        M('maga')->where("id='{$id}'")->delete();
                                        M('gbook')->where("magaid='{$id}'")->delete();
                                        $json = array(
                                            'success' => 1
                                        );
                                }else{
                                        $this->errorMsg = '系统错误';
                                }
                        }else{
                                $this->errorMsg = '不存在的期刊记录';
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
