<?php


class ArticleHistoryModel extends Model{
    private $_fields=array('title','nav','label','face','info','content','fabulous','flagComment',
                            'readCount','keyword','source','author','commentCount','roof','disabled','date','pid');
    protected $_tables=array(DB_FREFIX.'article_history');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['pid'],
            $this->_R['id']
        )=$this->getRequest()->getParam(array(
            isset($_GET['pid']) ? $_GET['pid'] : null,
            isset($_GET['id']) ? $_GET['id'] : null
        ));
    }
    
    public function addArticleHistory($_addData){       

        unset($_addData['update_date']);
        return parent::add($_addData);
    }
    
    public function getHistory(){
        
        $_where =array("pid='{$this->_R['pid']}'");
        $_all = parent::select(array('id','date'), array('where'=>$_where,'order'=>'date DESC'));
        $tem=[];
        $tem['content']=$_all;
        $tem['count']=count($_all);
        return $tem;
    }
    
    public function findOne(){  //获取一条 后台ajax用
        $_where=array("id='{$this->_R['id']}'");
        if(!$this->isOne($_where)) return array('state'=>'error','info'=>'该文档不存在');
        $_all=parent::select(array('id','title','nav','label','face','info','content','fabulous','flagComment','roof',
            'readCount','keyword','source','author','disabled','date'),array('where'=>$_where,'limit'=>1));
        return array('state'=>'succ','data'=>$_all[0]);
    }
    
}
















