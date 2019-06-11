<?php

class NavAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/nav.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('nav'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('nav')); //注入 script
        
        $this->_tpl->implement();
    }
    
   
}