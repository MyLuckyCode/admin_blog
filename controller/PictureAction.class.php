<?php

class PictureAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'picture/show.tpl');
        $this->_tpl->assign('Style',$this->includesStyle('picture'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('picture')); //注入 script
        
        $_pictureItemModel = new PictureItemModel();
         // 0 代表查找全部
        $_type = isset($_GET['type']) && is_numeric($_GET['type']) ? $_GET['type'] : 0;

        //获取相册列表
        $this->_tpl->assign('pictureList',$this->_model->getPictureList());
        
         //获取相册名称以及 图片的总数
        $_pictureTitleInfo = $this->_model->getPictureCount($_type);   
        $this->_tpl->assign('pictureTitleInfo',$_pictureTitleInfo);
        
         //上传图片到哪个相册 ，默认就是 1 ，未分组
        $this->_tpl->assign('pid', isset($_GET['type']) && is_numeric($_GET['type']) ? $_GET['type'] : 1);     
        
        //分页,当前第一页，默认是第一页
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $_pageCurrent =  $_pageCurrent>ceil( $_pictureTitleInfo[0]->total/PAGE_SIZE) ? ceil( $_pictureTitleInfo[0]->total/PAGE_SIZE) : $_pageCurrent;
        $_pageCurrent = $_pageCurrent<=0 ? 1 : $_pageCurrent;
        $this->_tpl->assign('pageCurrent',$_pageCurrent);

        //每页显示多少条
        $this->_tpl->assign('pageSize',PAGE_SIZE);

        //获取相册的图片列表
        $_imgList = $_pictureItemModel->getImageList($_type,$_pageCurrent,PAGE_SIZE);   
        $this->_tpl->assign('imgList',$_imgList);

        $this->_tpl->implement();
    }
    
   
   
}