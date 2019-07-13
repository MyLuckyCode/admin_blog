<?php


class WorksApi extends Api{
	
	
	
    public function addWorks(){ //添加作品
        $_works=new WorksModel();
        if($_works->addWorks()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function deleteWorks(){  //删除作品
        $_works=new WorksModel();
        if($_works->deleteWorks()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
    
    public function getWorksOne(){  //获取一条 作品
        $_works=new WorksModel();
        echo json_encode($_works->findOne());
    }
    
    public function editWorks(){  //修改 作品
        $_works=new WorksModel();
        if($_works->editWorks()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败，没有任何数据被修改"}';
        }
    }
	
	
}






?>