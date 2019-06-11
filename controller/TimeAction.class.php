<?php

class TimeAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/time.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('time'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('time')); //注入 script
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $this->_tpl->assign('currentPage',$_pageCurrent );
        $this->_tpl->implement();
    }
   
}