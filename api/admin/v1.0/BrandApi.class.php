<?php


class BrandApi extends Api{
	
	
	public function addBrand(){ //添加轮播图
        $_brand=new BrandModel();
        if($_brand->addBrand()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function deleteBrand(){  //删除轮播图
        $_brand=new BrandModel();
        if($_brand->deleteBrand()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
    
    public function getBrandOne(){  //获取一条 brand
        $_brand=new BrandModel();
        echo json_encode($_brand->findOne());
    }
    
    public function editBrand(){  //修改 brand
        $_brand=new BrandModel();
        if($_brand->editBrand()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败，没有任何数据被修改"}';
        }
    }
	
}






?>