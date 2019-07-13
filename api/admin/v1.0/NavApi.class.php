<?php


class NavApi extends Api{
	
	
	public function addNav(){   //添加导航
        $_nav=new NavModel();
        $id = $_nav->addNav();
        if($id){
            echo '{"state":"succ","info":"添加成功","id":"'.$id.'"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function getNavList(){   //获取全部导航
        $_nav=new NavModel();
        echo json_encode($_nav->getNavList());
    }
    
    public function deleteNav(){    //删除导航
        $_nav=new NavModel();
        if($_nav->deleteNav()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }

    public function editNav(){          //修改导航
        $_nav = new NavModel();
        if($_nav->editNav()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
	
}






?>