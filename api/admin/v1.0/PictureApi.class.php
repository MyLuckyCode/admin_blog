<?php


class PictureApi extends Api{
	
	public function addPicture(){       //增加相册
        $_picture=new PictureModel();
        if($_picture->addPicture()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function editPicture(){  //修改相册
        $_picture=new PictureModel();
        if($_picture->editPicture()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
    
    public function deletePicture(){    //删除相册
        $_picture=new PictureModel();
        if($_picture->deletePicture()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function getPictureList(){   //获取全部相册
        $_picture=new PictureModel();
        echo json_encode($_picture->getPictureList());
    }
    
    public function deletePictureItem(){    //删除图片
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->deletePictureItem()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function editImageName(){    //修改图片名称
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->editImageName()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }

    public function movePictureItem(){    //移动图片
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->movePictureItem()){
            echo '{"state":"succ","info":"移动成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成移动不干净"}';
        }
    }
	
	public function getPictureItem(){   // 获取 图片 列表
        $_pictureItem = new PictureItemModel();
        $_type=$_POST['type'];
        $_currentPage=$_POST['currentPage'];
        $_pageSize=$_POST['pageSize'];
        echo json_encode($_pictureItem->getImageList($_type,$_currentPage,$_pageSize));
    }
	
}






?>