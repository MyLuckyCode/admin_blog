<?php

class SettingAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/setting.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('setting'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('setting')); //注入 script
        


        //获取信息列表
        //$this->_tpl->assign('findAll',$this->_model->findAll($_pageCurrent,PAGE_SIZE));
        
        $this->_tpl->implement();
    }
   
}