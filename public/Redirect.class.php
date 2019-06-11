<?php

class Redirect{
    static private $_instance=null;
    private $_tpl;
    static public function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance=new self();
            self::$_instance->_tpl=new TPL();
        }
        return self::$_instance;
    }
    
    private function __construct(){}
    
    //成功跳转
    public function succ($_url,$_info=''){
        if(!empty($_info)){
            if(!is_array($_info)){
                $_info=array($_info);
            }
            $this->_tpl->assign('message',$_info);
            $this->_tpl->assign('url',$_url);
            $this->_tpl->create(VIEW_ADMIN.'public/succ.tpl');
        }else {
            header('Location:'.$_url);
        }
        exit();
    }
    //失败返回
    public function error($_info){
        if(!is_array($_info)){
            $_info=array($_info);
        }
        $this->_tpl->assign('message',$_info);
        $this->_tpl->assign('prev',Tool::getPrevPage());
        $this->_tpl->create(VIEW_ADMIN.'public/error.tpl');
        exit();
    }
}











































