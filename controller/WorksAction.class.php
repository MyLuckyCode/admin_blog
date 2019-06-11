<?php

class WorksAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'works/show.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('works_show'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('works_show')); //注入 script
        
        $this->_tpl->assign('findAllDisabled',$this->_model->findAllDisabled());
        
        //分页,当前第一页，默认是第一页
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $total = $this->_model->getTotal();
        $_pageCurrent =  $_pageCurrent>ceil($total/PAGE_SIZE) ? ceil($total/PAGE_SIZE) : $_pageCurrent;
        $_pageCurrent = $_pageCurrent<=0 ? 1 : $_pageCurrent;
        $this->_tpl->assign('pageCurrent',$_pageCurrent);
        
        //每页显示多少条
        $this->_tpl->assign('pageSize',PAGE_SIZE);
        
        //总数，用于分页
        $this->_tpl->assign('total',$total);
        
        //获取信息列表
        $this->_tpl->assign('findAll',$this->_model->findAll($_pageCurrent,PAGE_SIZE));
        
        $this->_tpl->implement();
    }
    
    public function add(){  //有用
        $this->_tpl->display(VIEW_ADMIN.'works/add.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('works_add'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('works_add',['upFileButton','Tailoring','Gallery'])); //注入 script
        
        $this->_tpl->implement();
    }
    
    public function update(){   //有用

        $this->_tpl->assign('Style',$this->includesStyle('works_update'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('works_update',['upFileButton','Tailoring','Gallery'])); //注入 script
        if(isset($_GET['id'])){
            $this->_tpl->display(VIEW_ADMIN.'works/update.tpl');
            
            $this->_tpl->assign('BrandOne', $this->_model->findOne());
            
            $this->_tpl->implement();
        }
    }
    
    

   
}