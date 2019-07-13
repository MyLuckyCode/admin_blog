<?php


class ArticleApi extends Api{
	
	
    public function addArticle(){      //添加文章
        $_article=new ArticleModel();
        if($_article->addArticle()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function getArticleOne(){    //获取一条文章
        $_article=new ArticleModel();
        echo json_encode($_article->findOne());
    }
    
    public function getArticleHistoryOne(){     //获取一条历史记录文章
        $_articleHistory=new ArticleHistoryModel();
        echo json_encode($_articleHistory->findOne());
    }
    
    public function getArticleHistory(){    //获取文章历史版本
        $_articleHistory = new ArticleHistoryModel();
        echo json_encode( $_articleHistory->getHistory());
        
    }
    
    public function editArticle(){         //修改文章
        $_article=new ArticleModel();
        if($_article->editArticle()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
    
    public function deleteArticle(){   //删除文章
        $_article=new ArticleModel();
        if($_article->deleteArticle()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
    
    public function setArticleRoof(){   //设置文章的置顶
        $_article=new ArticleModel();
        if($_article->setRoof()){
            echo '{"state":"succ","info":"设置成功"}';
        }else {
            echo '{"state":"error","info":"设置失败"}';
        }
    }
    
    public function setArticleFlagComment(){   //设置文章的评论开关
        $_article=new ArticleModel();
        if($_article->setFlagComment()){
            echo '{"state":"succ","info":"设置成功"}';
        }else {
            echo '{"state":"error","info":"设置失败"}';
        }
    }        
    public function setArticleDisabled(){   //设置文章是否显示
        $_article=new ArticleModel();
        if($_article->setDisabled()){
            echo '{"state":"succ","info":"设置成功"}';
        }else {
            echo '{"state":"error","info":"设置失败"}';
        }
    }
    public function setArticleFocus(){   //设置焦点文章
        $_system=new SystemModel();
        if($_system->setArticleFocus()){
            echo '{"state":"succ","info":"设置成功"}';
        }else {
            echo '{"state":"error","info":"设置失败"}';
        }
    }
	
}






?>