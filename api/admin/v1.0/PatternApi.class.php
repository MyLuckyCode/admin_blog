<?php


class PatternApi extends Api{
	
	public function addPattern(){       //增加样式分组
        $_pattern=new PatternModel();
        if($_pattern->addPattern()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function editPattern(){  //修改样式分组
        $_pattern=new PatternModel();
        if($_pattern->editPattern()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
    
    public function deletePattern(){    //删除样式分组
        $_pattern=new PatternModel();
        if($_pattern->deletePattern()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function getPatternList(){   //获取全部样式分组
        $_pattern=new PatternModel();
        echo json_encode($_pattern->getPatternList());
    }
    
    public function addPatternItem(){      //添加样式模板
        $_pattern=new PatternItemModel();
        if($_pattern->addPatternItem()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
	
	public function deletePatternItem(){    //删除模板样式
        $_pattern=new PatternItemModel();
        if($_pattern->deletePatternItem()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function editPatternItemName(){    //修改模板样式名称
        $_pattern=new PatternItemModel();
        if($_pattern->editPatternName()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }

    public function movePatternItem(){    //移动模板样式
        $_pattern=new PatternItemModel();
        if($_pattern->movePatternItem()){
            echo '{"state":"succ","info":"移动成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成移动不干净"}';
        }
    }
	
	public function getPatternItemOne(){    //获取一条样式
        $_PatternItem=new PatternItemModel();
        echo json_encode($_PatternItem->findOne());
    }
	
	public function editPatternItem(){         //修改样式
        $_PatternItem=new PatternItemModel();
        if($_PatternItem->editPatternItem()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
	
	public function getPatternItem(){   // 获取 图片 列表
        $_patternItem = new PatternItemModel();
        $_type=$_POST['type'];
        $_currentPage=$_POST['currentPage'];
        $_pageSize=$_POST['pageSize'];
        echo json_encode($_patternItem->getPatternItemList($_type,$_currentPage,$_pageSize));
    }
	
	
}






?>