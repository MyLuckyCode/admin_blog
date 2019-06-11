<?php

class UserAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    

    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/user.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('user'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('user')); //注入 script
        
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
    
    public function login(){
        //https://github.com/login/oauth/authorize?client_id=Iv1.1dd6cde4d1ccafae
        $url = "https://github.com/login/oauth/access_token?client_id=Iv1.1dd6cde4d1ccafae&client_secret=d903dbc485056e8dd6edca292436883e263dbe88&code=".$_GET['code'];
        $res = $this->_getAccess($url);
        //MDQ6VXNlcjQzMjkxMzY3
        $url2="https://api.github.com/user?".$res;
        print_r($this->_getAccess($url2));
    }
    

    
    public function _getAccess($url,$headers = array()){
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,$url);
        
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_USERAGENT, "https://api.github.com/user");

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        
        curl_close($ch);
        return $output;
    }
    
    
}