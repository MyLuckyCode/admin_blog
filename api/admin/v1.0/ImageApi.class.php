<?php


class ImageApi extends Api{
	
	public function upImg(){    //上传图片
        echo Up::UpImg();
    }
	
	public function postClippingImage(){    //添加裁剪图片
        $image = new ImagesModel();
        $uniqueId = $image->addImage('clipping');
        if($uniqueId){
            echo '{"state":"succ","info":"裁剪成功","uniqueId":"'.$uniqueId.'"}';
        }else {
            echo '{"state":"error","info":"裁剪失败,后台出错"}';
        }
    }
	
	
}






?>