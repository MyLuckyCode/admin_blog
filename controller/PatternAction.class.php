<?php

class patternAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'pattern/show.tpl');
        $this->_tpl->assign('Style',$this->includesStyle('pattern_show'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('pattern_show')); //注入 script
		
        $_patternItemModel = new PatternItemModel();
         // 0 代表查找全部
        $_type = isset($_GET['type']) && is_numeric($_GET['type']) ? $_GET['type'] : 0;

        //获取相册列表
        $this->_tpl->assign('patternList',$this->_model->getPatternList());
        
         //获取相册名称以及 图片的总数
        $_patternTitleInfo = $this->_model->getPatternCount($_type);   
        $this->_tpl->assign('patternTitleInfo',$_patternTitleInfo);
        //$this->_tpl->implement();
        //return;     
        
        //分页,当前第一页，默认是第一页
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $_pageCurrent =  $_pageCurrent>ceil( $_patternTitleInfo[0]->total/PAGE_SIZE) ? ceil( $_patternTitleInfo[0]->total/PAGE_SIZE) : $_pageCurrent;
        $_pageCurrent = $_pageCurrent<=0 ? 1 : $_pageCurrent;
        $this->_tpl->assign('pageCurrent',$_pageCurrent);

        //每页显示多少条
        $this->_tpl->assign('pageSize',PAGE_SIZE);

        //获取相册的图片列表
        $_ItemList = $_patternItemModel->getPatternItemList($_type,$_pageCurrent,PAGE_SIZE);   
        $this->_tpl->assign('patternItemList',$_ItemList);

        $this->_tpl->implement();
    }
	
	public function add(){
		$this->_tpl->display(VIEW_ADMIN.'pattern/add.tpl');
        $this->_tpl->assign('Style',$this->includesStyle('pattern_add'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('pattern_add',['UpFileButton','Tailoring','Gallery'])); //注入 script
        $this->_tpl->assign('findAllPattern', $this->_model->getPatternList());
		$this->_tpl->implement();
	}
	
	public function update(){
		$this->_tpl->display(VIEW_ADMIN.'pattern/update.tpl');
        $this->_tpl->assign('Style',$this->includesStyle('pattern_update'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('pattern_update',['UpFileButton','Tailoring','Gallery'])); //注入 script
        $this->_tpl->assign('findAllPattern', $this->_model->getPatternList());
		$this->_tpl->implement();
	}
    
   
   
}