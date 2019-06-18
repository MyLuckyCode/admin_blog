<?php


class PictureItemModel extends Model{
    private $_fields=array('id','name','url','pid','uniqueId','date');
    protected $_tables=array(DB_FREFIX.'picture_item');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['pid'],
            $this->_R['id'],
            $this->_R['name']
        )=$this->getRequest()->getParam(array(
            isset($_POST['pid']) ? $_POST['pid'] : null,
            isset($_POST['id']) ? $_POST['id'] : null,
            isset($_POST['name']) ? $_POST['name'] : null
        ));
        
    }
    
    
    public function addImage($url,$name,$uniqueId){   //添加照片到数据库  图片上传类用
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getDate();
        $_addData['pid']= $this->_R['pid'];
        $_addData['url']= $url;
        $_addData['uniqueId']=$uniqueId;
        $_addData['name']=$name;
        
        $_pictureModel = new PictureModel();
        $_pictureModel->setCount($this->_R['pid'],1);

        return parent::add($_addData);
    }
    
    public function getImageList($pid,$pageCurrent,$page_size){   //后台模版用  ajax用

        $_start=($pageCurrent-1)*$page_size;
        $_end=$page_size;
        
        if($pid==0){    //查找全部图片
            $_where=array("pid!=0");
        }else {
            $_where=array("pid=$pid");
        }
        $_all = parent::select(array('id','name','url','pid','uniqueId'), array('where'=>$_where,'limit'=>"$_start,$_end",'order'=>'id DESC'));
        foreach($_all as $key=>$value){
            $array=explode('.',$value->uniqueId);
            $value->type=$array[count($array)-1];
        }
        return $_all;

    }
    
    public function deletePictureItem(){    //删除图片

        $PictureModel = new PictureModel();

        $json=$_POST['deleteData'];
        $json = stripslashes($json);
        $deleteData = json_decode($json, true);

        foreach($deleteData as $id=>$key){
            $whereStr=implode(',',$deleteData[$id]);
            $where=array("id in ($whereStr)");
            $count = parent::deleteAll($where);
            $PictureModel->reduceCount($id,$count);
        }
        return true;
    }

    public function movePictureItem(){    //移动图片到新的分组

        $PictureModel = new PictureModel();

        $newPid=$_POST['newPid'];
        if(!is_numeric($newPid) || $newPid==0 ) return false;

        $json=$_POST['moveData'];
        $json = stripslashes($json);
        $moveData = json_decode($json, true);

        $total=0;

        foreach($moveData as $id=>$key){
            $whereStr=implode(',',$moveData[$id]);
            $where=array("id in ($whereStr)");
            $_updateData['pid']=$newPid;
            $count = parent::updateAll($_updateData,$where);
            $total += $count;
            $PictureModel->reduceCount($id,$count);
        }
        $PictureModel->setCount($newPid,$total);

        return true;
    }
    
    public function movePicrureInitial($oldId){  //把被删除的分组组内图片移动到未分组     $oldId 是将要被删除分组的 ID 
        $newid=PICTURE_INITIAL_ID;   //未分组 id
        $_where = array("pid={$oldId}");
        $_updateData['pid'] = $newid;
        return parent::updateAll($_updateData, $_where);
    }
    
    public function editImageName(){    //修改图片名称
        $where=array("id ={$this->_R['id']}");
        $_updateData['name']=$this->_R['name'];
        return parent::update($_updateData,$where);
    }
    
    
   
}
















