<?php


class UserModel extends Model{
    private $_fields=array('id','email','face','date');
    protected $_tables=array(DB_FREFIX.'user');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['email'],
            $this->_R['id']
        )=$this->getRequest()->getParam(array(
            isset($_POST['email']) ? $_POST['email'] : null,
            isset($_GET['id']) ? $_GET['id'] : null
        ));
    }
    
    private function addUser(){     //有用
        $_addData=$this->getRequest()->fiter($this->_fields);
        $face='m'.mt_rand(1,64).'.gif';
        $_addData['face']=$face;
        $_addData['date']=Tool::getdate();
        parent::add($_addData);
        return $face;
    }
    
    public function findAll($pageCurrent,$page_size){ //有用 后台模版用
        $_start=($pageCurrent-1)*$page_size;
        $_end=$page_size;
        $all = parent::select(array('id','email','face','date','date smallDate'),
            array('limit'=>"$_start,$_end",'order'=>'date DESC'));

        foreach($all as $key=>$value){
            $value->smallDate = Tool::setStr($value->smallDate, 0, 10, 'utf-8');
        }
        return $all;
    }
       
    public function findOne(){  //有用
        $_where=array("email='{$this->_R['email']}'");
        $_one=parent::select(array('id','email','face'),
            array('where'=>$_where,'limit'=>'1'));
      if(empty($_one)){
          return $this->addUser();
      }
      return $_one[0]->face;
    }
    
    
    public function getTotal(){
        return parent::total();
    }

    

}
















