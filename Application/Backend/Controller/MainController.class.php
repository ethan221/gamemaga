<?php
namespace Backend\Controller;
use Backend\Controller\MasterController;
use Backend\Model\IdentityAuth;

class MainController extends MasterController {

        public function index(){
                $this->display();
        }
        
        public function top(){
                $this->display();
        }

        public function left(){
                $this->display();
        }

        public function right(){
                $this->display();
        }

        public function logout(){
                $adminAuth = IdentityAuth::getInstance();
                $adminAuth->clearIdentity();
                header('Location: /backend');
        }
}
