<?php
namespace Backend\Model;
use Think\Model;

class AdminModel extends Model {

    protected $tableName = 'admin';
    
    protected $fields = array(
        'id',
        'username',
        'password',
        'intime',
        'inip'
    );

    public function findOne($data){
            $username = $data['username'];
            $password = MD5($data['password']);
            $admin = M('admin')->field('id,username')->where("username='{$username}' AND password='{$password}'")->find();
            if($admin){
                    return $admin;
            }
            return FALSE;
    }
}
