<?php

class LabelAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/label.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('label'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('label')); //注入 script
        
        $this->_tpl->implement();
    }
    
   
}