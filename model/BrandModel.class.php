<?php


class BrandModel extends Model{
    private $_fields=array('id','title','target','imgUrl','disabled');
    protected $_tables=array(DB_FREFIX.'brand');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['title'],
            $this->_R['id']
        )=$this->getRequest()->getParam(array(
            isset($_POST['title']) ? $_POST['title'] : null,
            isset($_GET['id']) ? $_GET['id'] : null
        ));
    }
    
    public function addBrand(){     //有用,后台ajax调用
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getdate();
        return parent::add($_addData);
    }
    
    public function findOne(){  
        $_where=array("id='{$this->_R['id']}'");
        return parent::select(array('id','title','target','imgUrl','disabled'),
                                array('where'=>$_where,'limit'=>'1'));
    }
    
    public function findAllDisabled(){ //有用 前台和后台的ajax调用
        return parent::select(array('id','title','target','imgUrl'),array('where'=>array('disabled=1')));
    }
    
    public function findAll($pageCurrent,$page_size){ //有用 后台模版用
        $_start=($pageCurrent-1)*$page_size;
        $_end=$page_size;
        $all = parent::select(array('id','title','target','imgUrl','disabled','date','date smallDate'),
            array('limit'=>"$_start,$_end",'order'=>'date DESC'));
        
        foreach($all as $key=>$value){
            $value->smallDate = Tool::setStr($value->smallDate, 0, 10, 'utf-8');
        }
        return $all;
    }
    
    public function getTotal(){
        return parent::total();
    }
    
    public function editBrand(){  //有用
        $_where=array("id='{$_POST['id']}'");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        return parent::update($_updateData, $_where);
    }
    
    public function deleteBrand(){   //有用
        $_where=array("id='{$this->_R['id']}'");
        return parent::delete($_where);
    }
    
}
















