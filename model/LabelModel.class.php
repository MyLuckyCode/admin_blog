<?php


class LabelModel extends Model{
    private $_fields=array('id','name');
    protected $_tables=array(DB_FREFIX.'label');
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
    
    public function addLabel(){     // 添加标签  后台 ajax 用
        $_where=array("name='{$this->_R['name']}'");
        if($this->isOne($_where)){
            echo '{"state":"repeat","info":"该标签已存在"}';
            exit;
        }
        
        //统计数目
        $total=new TotalModel();
        $total->setCount('label',1);
        
        $_addData=$this->getRequest()->fiter($this->_fields);
        if(parent::add($_addData)) return parent::lastInsertId();
    }
    
    public function findAllLabel(){ // 后台模版用
        $_all=parent::select(array('id','name'),null);
        $this->_tables=array(DB_FREFIX.'label');
        $_all=Tool::setFormItem($_all,'id', 'name');
        return $_all;
    }
    
    public function getLabel(){  //前台用
        return parent::select(array('id','name'),null);
    }
    
    
    public function getLabelList(){ // 获取全部标签  后台 ajax 用
        return parent::select(array('id','name'),null);
    }
    
    public function editLabel(){  // 修改标签  后台  ajax 用 
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        return parent::update($_updateData, $_where);
    }
    
    public function deleteLabel(){   // 删除标签  后台  ajax 用 
        $_where=array("id='{$this->_R['id']}'");
        
        //统计数目
        $total=new TotalModel();
        $total->setCount('label',-1);
        
        return parent::delete($_where);
    }
    

    
    
}
















