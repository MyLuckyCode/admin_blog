<?php

class CommentAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/comment.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('comment'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('comment')); //注入 script
        
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
        
        $all = $this->_model->findAll($_pageCurrent,PAGE_SIZE);

        $this->_tpl->assign('findAll',$all);
        
        $this->_tpl->implement();
    }
    
   
}