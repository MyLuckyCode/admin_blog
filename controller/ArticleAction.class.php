<?php

class ArticleAction extends Action{
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'article/show.tpl');

        $this->_tpl->assign('Style',$this->includesStyle('article_show'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('article_show')); //注入 script
        
        //一共有多少条
        $total=$this->_model->getTotal();
        $this->_tpl->assign('total',$total);
        
        //分页,当前第一页，默认是第一页
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $_pageCurrent =  $_pageCurrent>ceil($total/PAGE_SIZE) ? ceil($total/PAGE_SIZE) : $_pageCurrent;
        $_pageCurrent = $_pageCurrent<=0 ? 1 : $_pageCurrent;
        $this->_tpl->assign('pageCurrent',$_pageCurrent);
        
        //获取焦点文章
        $_system = new SystemModel();
        $_systemOne = ($_system->findAll())[0];
        $this->_tpl->assign('focusArticle',$this->_model->getFocusArticle($_systemOne->focusArticle));
        //每页显示多少条
        $this->_tpl->assign('pageSize',PAGE_SIZE);
        
        $this->_tpl->assign('findAll',$this->_model->findAll($_pageCurrent,PAGE_SIZE));
        $this->_tpl->implement();
    }
    
    public function add(){  //有用
        
        $this->_tpl->display(VIEW_ADMIN.'article/add.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('article_add'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('article_add',['upFileButton','Tailoring','Gallery'])); //注入 script
        
        $_nav=new NavModel();
        $this->_tpl->assign('findAllNav', $_nav->findAllNav());
        $_label=new LabelModel();
        $this->_tpl->assign('findAllLabel', $_label->findAllLabel());
        $_comment=array(1=>'允许评论',0=>'禁止评论');
        $this->_tpl->assign('comment', $_comment);
        $_source=array(1=>'原创',0=>'转载');
        $this->_tpl->assign('source', $_source);
        
        $this->_tpl->implement();
    }
    
    public function update(){       //有用
        
        $this->_tpl->display(VIEW_ADMIN.'article/update.tpl');
        
        $this->_tpl->assign('Style',$this->includesStyle('article_update'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('article_update',['upFileButton','Tailoring','Gallery'])); //注入 script
        
        $_nav=new NavModel();
        $this->_tpl->assign('findAllNav', $_nav->findAllNav());
        $_label=new LabelModel();
        $this->_tpl->assign('findAllLabel', $_label->findAllLabel());
        $_comment=array(1=>'允许评论',0=>'禁止评论');
        $this->_tpl->assign('comment', $_comment);
        $_source=array(1=>'原创',0=>'转载');
        $this->_tpl->assign('source', $_source);
        $this->_tpl->implement();
        
    }
    
    public function history(){
        $this->_tpl->display(VIEW_ADMIN.'article/history.tpl');
        $this->_tpl->assign('Style',$this->includesStyle('article_history'));   //注入css
        $this->_tpl->assign('Script',$this->includesScript('article_history',['upFileButton','Tailoring','Gallery'])); //注入 script
        $_nav=new NavModel();
        $this->_tpl->assign('findAllNav', $_nav->findAllNav());
        $_label=new LabelModel();
        $this->_tpl->assign('findAllLabel', $_label->findAllLabel());
        $_comment=array(1=>'允许评论',0=>'禁止评论');
        $this->_tpl->assign('comment', $_comment);
        $_source=array(1=>'原创',0=>'转载');
        $this->_tpl->assign('source', $_source);
        $this->_tpl->implement();
    }
    
    

    
}

