<?php

class ImagesAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        ob_clean();
        
        if(isset($_GET['uniqueId'])){
            //$one = $this->_model->findOne();
            //if(isset($one->info) && $one->info=='no') exit('图片不存在');
            //Up::clipping($one);
            header("Cache-Control: private, max-age=10800, pre-check=10800");
            header("Pragma: private");
            header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
            
            $uniqueId = $_GET['uniqueId'];
            $url = './upload/clippingImages/'.$uniqueId;
            if(isset($_GET['type']) && $_GET['type']=='small'){
                $url = './upload/thumbnail/'.$uniqueId;
                if(!file_exists($url)){
                    $url = './upload/clippingImages/'.$uniqueId;
                }
            }
            
            if(!file_exists($url)){
                $this->noPic();
            }
            
            Up::Initial($url);
        }
        
    }
	
	
	
	public function getSizeImage(){
		 ob_clean();
		if(!isset($_GET['uniqueId']) || empty($_GET['uniqueId'])){
			$this->noPic();
		}
		$uniqueId = $_GET['uniqueId'];
		header("Cache-Control: private, max-age=10800, pre-check=10800");
		header("Pragma: private");
		header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
		$obj=new stdClass();
		$obj->type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : 'min';
		$obj->type = $obj->type=='min' ? 'min' : 'max';
		$obj->size = (isset($_GET['size']) && !empty($_GET['size'])) ? $_GET['size'] : 200;
		$obj->url = './upload/clippingImages/'.$uniqueId;
		Up::InitialSize($obj);
		
	}
	
	private function noPic(){
		header('Content-Type:image/png');
		$tempImg=imagecreatefrompng('./image/noPic.png');
		imagepng($tempImg);
		exit;
	}
    
    public function test(){
        /*
        $info=getimagesize('http://localhost/smarty/admin_blog/?a=image&id=12');

        $largeImage=imagecreatefromjpeg('http://localhost/smarty/admin_blog/?a=image&id=12');
        header('Content-Type:image/jpeg');
        
        imagejpeg($largeImage);
        */
        echo Tool::getUnique();
    }
    
   
}