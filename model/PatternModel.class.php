<?php


class PatternModel extends Model{
    private $_fields=array('id','name','operation','count');
    protected $_tables=array(DB_FREFIX.'pattern_title');
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
    
    public function addPattern(){   //添加相册，后台 ajax 用
        $_where=array("name='{$this->_R['name']}'");
        if($this->isOne($_where)){
            echo '{"state":"repeat","info":"该相册已存在"}';
            exit;
        }
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getDate();
        if(parent::add($_addData)) return parent::lastInsertId();
    }
    
    public function editPattern(){  //修改相册，后台 ajax 用
        $_where=array("name='{$this->_R['name']}'");
        if($this->isOne($_where)){
            echo '{"state":"repeat","info":"该相册已存在"}';
            exit;
        }
        $_where=array("id={$this->_R['id']}");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        return parent::update($_updateData,$_where);
    }
    
    public function deletePattern(){
        $newId = PICTURE_INITIAL_ID; //未分组 id
        $_patternItem = new PatternItemModel();
        $oldId=$this->_R['id'];     //即将被删除分组的 ID
        $count = $_patternItem->movePatternInitial($oldId);    //删除分组前，先将分组组内的图片移动到未分组  
        $this->setCount($newId,$count);
        $_where=array("id={$oldId}");
        return parent::delete($_where);
        
    }
    
    
    public function getPatternList(){   //获取全部相册 后台 ajax 用,后台模板用
        return parent::select(array('id','name','count','operation'),null);
    }
    
    public function getPatternCount($id){  //统计图片总数 
        if($id==0){    //查找全部相册
            $_where=array("id!=0");
        }else {
            $_where=array("id=$id");
        }
        return parent::select(array('id','name','operation','SUM(count) as total'),array('where'=>$_where));
    }


    public function setCount($id,$count=1){  //上传图片 数量加 1
         $_where=array("id=$id");
         $_updateData['count']=array("count+$count");
         return parent::update($_updateData,$_where);
    }

    public function reduceCount($id,$count){  // 删除图片是减少数量
         $_where=array("id=$id");
         $_updateData['count']=array("count-$count");
         return parent::update($_updateData,$_where);
    }
    
}
















