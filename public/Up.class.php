<?php


class Up{
    
    static public function UpImg(){		//图片上传
        $_route=self::getUrl('images');
        if(move_uploaded_file($_FILES['file']['tmp_name'],ROOT_PATH.$_route)){
            $_pictureItem = new PictureItemModel();
            $_route='.'.$_route;
            $uniquId = Tool::getUnique().'.'.self::getImageType();
            
            $d = explode('-', date("Y-y-m-d-H-i-s"));
            if($_pictureItem->addImage($_route, $_FILES['file']['name'],$d[0].$d[2].$d[3].'/'.$uniquId)) {
                
                $images = new ImagesModel();
                
                $images->addImage('initial',$_route,$uniquId);
                
                return '{"state":"succ","url":"'.$_route.'"}';
            } else return '{"state":"error"}';
        }
    }
    
    static public function getUrl($_type='images',$fileName=null){   //获取地址，内部专用
        if(isset($_FILES['file']['name'])){
            $_name=$_FILES['file']['name'];
            $array=explode('.',$_name);
            $attr=$array[count($array)-1];
        }else {
            if(isset($fileName)){
                $array=explode('.',$fileName);
                $attr=$array[count($array)-1];
            }
        }
        
        $cherset='abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTWXYZ23456789';
        $_len=strlen($cherset)-1;
        $code='';
        for($j=0;$j<4;$j++){
            $code.=$cherset[mt_rand(0,$_len)];
        }
        $times=time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        if(!is_dir(ROOT_PATH.'/upload/'.$_type.'/'.$d[0].$d[2].$d[3])){
            mkdir(ROOT_PATH.'/upload/'.$_type.'/'.$d[0].$d[2].$d[3],0777);
        }
        $fileName = isset($fileName) ? $fileName : $d[0].$d[2].$d[3].'/'.$times.$code.'.'.$attr;
        $_route='/upload/'.$_type.'/'.$fileName;
        return $_route;
    }
    
    static public function getImageType(){  //获取文件类型
        $_name=$_FILES['file']['name'];
        $array=explode('.',$_name);
        $type=$array[count($array)-1];
        return $type;
    }
    
    static public function Initial($url){  //输出本地图片
        $url='./upload/clippingImages/'.$url;
        if(!file_exists($url)){
            header('Content-Type:image/png');
            $tempImg=imagecreatefrompng('./image/noPic.png');
            imagepng($tempImg);
            exit;
        }
        $info=getimagesize($url);
        $w=$info[0];
        $h=$info[1];
        switch($info[2]){
            case 1:
                $largeImage=imagecreatefromgif($url);
                break;
            case 2:
                $largeImage=imagecreatefromjpeg($url);
                break;
            case 3:
                $largeImage=imagecreatefrompng($url);
                break;
        }
        switch($info[2]){
            case 1:
                header('Content-Type:image/gif');
                imagegif($largeImage);
                break;
            case 2:
                header('Content-Type:image/jpeg');
                imagejpeg($largeImage);
                break;
            case 3:
                header('Content-Type:image/png');
                imagepng($largeImage);
                break;
        }
        imagedestroy($largeImage);
    }
    
    static public function clipping($obj){  //输出裁剪图片
        if($obj->type!='initial') $obj->url='http://localhost/smarty/admin_blog/'.$obj->url;
        
        $info=getimagesize($obj->url);
        
        $w=$info[0];
        $h=$info[1];
        

        switch($info[2]){
            case 1:
                $largeImage=imagecreatefromgif($obj->url);
                break;
            case 2:
                $largeImage=imagecreatefromjpeg($obj->url);
                break;
            case 3:
                $largeImage=imagecreatefrompng($obj->url);
                break;
        }
        
        if($obj->type=='initial'){       //输出原始图片，即该图没有裁剪
            switch($info[2]){
                case 1:
                    header('Content-Type:image/gif');
                    imagegif($largeImage);
                    break;
                case 2:
                    header('Content-Type:image/jpeg');
                    imagejpeg($largeImage);
                    break;
                case 3:
                    header('Content-Type:image/png');
                    imagepng($largeImage);
                    break;
            }
            imagedestroy($largeImage);
            exit;
        }
        
       
        

        $tempImage=imagecreatetruecolor($obj->largeWidth,$obj->largeHeight);
        imagecopyresampled($tempImage,$largeImage,0,0,0,0,$obj->largeWidth,$obj->largeHeight,$w,$h);
        
        imagedestroy($largeImage);
        
        $newImage = imagecreatetruecolor($obj->newWidth,$obj->newHeight);
        imagecopyresampled($newImage,$tempImage,0,0,$obj->x,$obj->y,$obj->newWidth,$obj->newHeight,$obj->newWidth,$obj->newHeight);
        imagedestroy($tempImage);
        
        switch($info[2]){
            case 1:

                header('Content-Type:image/gif');
                imagegif($newImage);
                break;
            case 2:
                header('Content-Type:image/jpeg');
                imagejpeg($newImage);
                break;
            case 3:
                header('Content-Type:image/png');
                imagepng($newImage);
                break;
        }
        
        imagedestroy($newImage);
    }
    
    static public function baocun($obj){        //保存裁剪图片到本地 
        
        $rouer = self::getUrl('clippingImages',$obj->uniqueId);
        
        if($obj->type!='initial') $obj->url='http://localhost/smarty/admin_blog/'.$obj->url;
        
        $info=getimagesize($obj->url);
        
        $w=$info[0];
        $h=$info[1];
        
        switch($info[2]){
            case 1:
                $largeImage=imagecreatefromgif($obj->url);
                break;
            case 2:
                $largeImage=imagecreatefromjpeg($obj->url);
                break;
            case 3:
                $largeImage=imagecreatefrompng($obj->url);
                break;
        }
        
        if($obj->type=='initial'){       //输出原始图片，即该图没有裁剪
            
            
            switch($info[2]){
                case 1:
                    //imagegif($largeImage,'.'.$rouer);
                    copy($obj->url,'.'.$rouer);
                    break;
                case 2:
                    imagejpeg($largeImage,'.'.$rouer);
                    break;
                case 3:
                    imagepng($largeImage,'.'.$rouer);
                    break;
            }
            imagedestroy($largeImage);
            return ;
        }
        
        $tempImage=imagecreatetruecolor($obj->largeWidth,$obj->largeHeight);
        imagecopyresampled($tempImage,$largeImage,0,0,0,0,$obj->largeWidth,$obj->largeHeight,$w,$h);
        
        imagedestroy($largeImage);
        
        $newImage = imagecreatetruecolor($obj->newWidth,$obj->newHeight);
        imagecopyresampled($newImage,$tempImage,0,0,$obj->x,$obj->y,$obj->newWidth,$obj->newHeight,$obj->newWidth,$obj->newHeight);
        imagedestroy($tempImage);
        
        switch($info[2]){
            case 1:
                imagegif($newImage,'.'.$rouer);
                //copy($obj->url, '.'.$rouer);
                break;
            case 2:
                imagejpeg($newImage,'.'.$rouer);
                break;
            case 3:
                imagepng($newImage,'.'.$rouer);
                break;
        }
        imagedestroy($newImage);
    }
    
}


?>