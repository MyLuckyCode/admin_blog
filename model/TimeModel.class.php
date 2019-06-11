<?php


class TimeModel extends Model{
    private $_fields=array('id','content','date');
    protected $_tables=array(DB_FREFIX.'time');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['content'],
            $this->_R['id']
        )=$this->getRequest()->getParam(array(
            isset($_POST['content']) ? $_POST['content'] : null,
            isset($_POST['id']) ? $_POST['id'] : null
        ));
    }
    
    public function addTime(){    
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getDate();
        return parent::add($_addData);
    }
   
    
    public function findAll(){      //前台 ajax 用
        
        $_pageCurrent = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $_start=($_pageCurrent-1)*PAGE_SIZE;
        $_end=PAGE_SIZE;
        $_all=parent::select(array('id','content','date','date smallDate'),array('limit'=>"$_start,$_end",'order'=>'date DESC'));
        foreach($_all as $key=>$value){
            $value->smallDate = Tool::setStr($value->smallDate, 0, 10, 'utf-8');
        }
        $arr['content']=$_all;
        $arr['total']=$this->getTimeCount();
        $arr['size']=PAGE_SIZE;
        
        return $arr;
    }
    
    public function editTime(){  
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        return parent::update($_updateData, $_where);
    }
    
    public function deleteTime(){  
        $_where=array("id='{$this->_R['id']}'");
        return parent::delete($_where);
    }
    
    public function getTime(){      //前台 ajax 用
        $_start=($_GET['page']-1)*$_GET['page_size'];
        $_end=$_GET['page_size'];
        $_all=parent::select(array('content','date'),array('limit'=>"$_start,$_end",'order'=>'date DESC'));
        return $_all;
    }
    
    public function getTimeCount(){ //前台和后台的ajax用
        return parent::total();
    }

    
    
}
















