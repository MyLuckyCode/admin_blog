<?php

class AdminAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        if(!isset($_COOKIE['user'])){
            header("location:?a=login");
        }
        $this->_tpl->display(VIEW_ADMIN.'public/admin.tpl');
        $this->_tpl->implement();
    }
    
}