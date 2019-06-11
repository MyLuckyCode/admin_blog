<?php


class NavModel extends Model{
    private $_fields=array('id','name','info','category','disabled');
    protected $_tables=array(DB_FREFIX.'nav');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['name'],
            $this->_R['id']

        )=$this->getRequest()->getParam(array(
            isset($_POST['name']) ? $_POST['name'] : null,
            isset($_POST['id']) ? $_POST['id'] : null
        ));
    }
    
    public function addNav(){   //添加导航，后台 ajax 用

        $_where=array("name='{$this->_R['name']}'");
        if($this->isOne($_where)){
            echo '{"state":"repeat","info":"该导航名称已存在"}';
            exit;
        }
        //统计数目
        $total=new TotalModel();
        $total->setCount('nav',1);
        
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getdate();
        if(parent::add($_addData)) return parent::lastInsertId();
    }
    
    public function getNavList(){   //获取全部导航 后台  ajax 用
         return parent::select(array('id','name','info','category','disabled','date'),null);
    }
    
    public function deleteNav($_seat1=null,$_seat2=null){   //删除导航 后台 ajax  用
        $_where=array("id={$this->_R['id']}");
        
        //统计数目
        $total=new TotalModel();
        $total->setCount('nav',-1);
        
        return parent::delete($_where);
    }

    public function editNav(){  // 修改导航  后台 ajax 用
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        return parent::update($_updateData, $_where);
    }
    
    public function findAllNav(){    //获取全部导航，后台模版用
        $_allNav=parent::select(array('id','name'),null);
        $_allNav=Tool::setFormItem($_allNav, 'id', 'name');
        return $_allNav;
    }
    
    public function getWebNav(){
        $_where=array("category='web'","disabled=1");
        return parent::select(array('id','name'), array('where'=>$_where));
    }
    
}
















