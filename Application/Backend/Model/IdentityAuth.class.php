<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Backend\Model;

/**
 * Description of IdentityAuth
 * admin登录操作类
 * @author wql
 */
class IdentityAuth {
    //put your code here
    protected static $_instance = null;

    /**
     * 
     */
    protected $_userinfo = null;
    /**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
    protected function __construct()
    {}

    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone()
    {}

    /**
     * Returns an instance of Zend_Auth
     *
     * Singleton pattern implementation
     *
     * @return Zend_Auth Provides a fluent interface
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 获取已存在login session信息
     * @return type
     */
    public function getUser()
    {
        if($_SESSION['ADMIN']){
            $this->_userinfo = $_SESSION['ADMIN'];
        }
        return $this->_userinfo;
    }
    
    public function uid(){
            if($_SESSION['ADMIN']){
                    return $_SESSION['ADMIN']['id'];
            }
    }

    /**
     * 保存用户登录信息
     * @param array $userinfo
     * @return IdentityAuth
     */
    public function setUser($userinfo) {
        if ($this->hasLogin()) {
            $this->clearIdentity();
        }
        $this->_userinfo = $userinfo;
        SESSION('ADMIN', $userinfo);
        return $this;
    }

    /**
     * Returns true if and only if an identity is available from storage
     * 是否已登录
     * @return boolean
     */
    public function hasLogin()
    {
        return !empty($this->getUser());
    }

    /**
     * Clears the identity from persistent storage
     * 删除 admin 登录信息（delete session）
     * @return void
     */
    public function clearIdentity()
    {
//        if(!empty($_COOKIE))
//        {
//            foreach($_COOKIE as $ck => $cv)
//            {
//                unset( $_COOKIE[$ck] );
//                setcookie($ck, '', time()-3600, '/');
//            }
//        }
//        @session_destroy();
        SESSION('ADMIN', NULL);
    }
}
