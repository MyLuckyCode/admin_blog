<?php


class LabelApi extends Api{
	
	 public function getLabelList(){     //获取全部标签
        $_label=new LabelModel();
        echo json_encode($_label->getLabelList());
    }

    public function addLabel(){         //添加标签
        $_label=new LabelModel();
        $id=$_label->addLabel();
        if($id){
            echo '{"state":"succ","info":"添加成功","id":"'.$id.'"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }

    public function editLabel(){    // 修改标签
        $_label = new LabelModel();
        if($_label->editLabel()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }

    public function deleteLabel(){    //删除标签
        $_label=new LabelModel();
        if($_label->deleteLabel()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
	
}






?>