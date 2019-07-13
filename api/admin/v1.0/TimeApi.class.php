<?php


class TimeApi extends Api{
	
	public function getTimeList(){      //获取time数据
        $_time=new TimeModel();
        echo json_encode($_time->findAll());
    }
    
    public function deleteTime(){   //删除时光
        $_time=new TimeModel();
        if($_time->deleteTime()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
    
    public function addTime(){      //添加时光
        $_time=new TimeModel();
        if($_time->addTime()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function editTime(){         //修改时光
        $_time=new TimeModel();
        if($_time->editTime()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
	
}






?>