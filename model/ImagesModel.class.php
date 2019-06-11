<?php


class ImagesModel extends Model{
    private $_fields=array('id','url','largeWidth','largeHeight',
                            'newHeight','newWidth','x','y',
                            'type','uniqueId','date'
    );
    protected $_tables=array(DB_FREFIX.'images');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['id'],
            $this->_R['uniqueId']
        )=$this->getRequest()->getParam(array(
            isset($_GET['id']) ? $_GET['id'] : null,
            isset($_GET['uniqueId']) ? $_GET['uniqueId'] : null
        ));
    }
    
    public function addImage($type,$url=null,$uniqueId=null){     //有用
        $uniqueId = isset($uniqueId) ? $uniqueId : Tool::getUnique().'.png';
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['url']=isset($_addData['url']) ? $_addData['url'] : $url;
        $_addData['type']=$type;
        
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $uniqueId = $d[0].$d[2].$d[3].'/'.$uniqueId;
        $_addData['uniqueId']=$uniqueId;
        $_addData['date']=Tool::getdate();
        if(parent::add($_addData)){
            $_one = $this->findOne($uniqueId);
            Up::baocun($_one);
            return $uniqueId;
        }else return false;
    }
    
    public function findOne($uniqueId=null){
        $uniqueId = isset($uniqueId) ? $uniqueId : $this->_R['uniqueId'];
        $_where=array("uniqueId='{$uniqueId}'");
        if(!$this->isOne($_where)) {
            $obj=new stdClass();
            $obj->info='no';
            return $obj;
        }
        $_all=parent::select(array('id','url','largeWidth','largeHeight',
                            'newHeight','newWidth','x','y','type','uniqueId'),array('where'=>$_where,'limit'=>1));
        return $_all[0];
    }
       
    
    

    

}
















