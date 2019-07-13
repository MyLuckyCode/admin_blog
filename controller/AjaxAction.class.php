<?php
// header('Access-Control-Allow-Origin:*');
class AjaxAction extends Action{
    
    public function __construct(){
        header('Access-Control-Allow-Origin:*');
    }
    

    public function getIndexArticle(){      //获取文章的列表
        $_article=new ArticleModel();
        echo json_encode($_article->getIndexArticle());
    }
    
    public function getArticleOne(){        //获取文章详情，上一条和下一条
        $_article=new ArticleModel();
        $arr=[];
        $arr['content']=$_article->findIndexOne();
        $arr['prev']=$_article->getArticlePrev();
        $arr['next']=$_article->getArticleNext();
        echo json_encode($arr);
    }
    
    public function getIndexTotal(){      //获取文章的列表的总数
        $_article=new ArticleModel();
        echo json_encode($_article->getIndexTotal());
    }
    
    public function getHotArticle(){ //获取热门文章
        $_article = new ArticleModel();
        echo json_encode($_article->getHot());
    }
    
    public function getUpdateArticle(){ //获取最近更新文章
        $_article = new ArticleModel();
        echo json_encode($_article->getUpdate());
    }
    
    public function getWebNav(){    //获取前端导航
        $_nav = new NavModel();
        echo json_encode($_nav->getWebNav());
    }
    
    public function getLabel(){     //获取全部标签
        $_label = new LabelModel();
        echo json_encode($_label->getLabel());
    }
    
    public function getTotal(){ //获取统计量
        $total=new TotalModel();
         echo json_encode($total->findOne());
    }
    
    public function getBrand(){         //获取轮播图
        $_brand = new BrandModel();
        echo json_encode($_brand->findAllDisabled());
    }
    
    public function setFabulous(){      //设置点赞量
        $_article=new ArticleModel();
        echo json_encode($_article->setFabulous());
    }
    
    public function setReadCount(){     //设置阅读量
        $_article=new ArticleModel();
        echo json_encode($_article->setReadCount());
    }
    
    public function getTime(){      //获取时光机
        $_time=new TimeModel();
        echo json_encode($_time->getTime());
    }
    
    public function getTimeCount(){      //获取时光机总数
        $_time=new TimeModel();
        echo json_encode($_time->getTimeCount());
    }
    
    public function addComment(){   //添加评论
        $_comment = new CommentModel();
        echo json_encode($_comment->addComment());
    }
    
    public function getComment(){     //获取评论
        $_comment = new CommentModel();
        echo json_encode($_comment->getComment());
    }
    
    public function getWorks(){ //获取作品
        $_works = new WorksModel();
        echo json_encode($_works->findAllDisabled());
    }
    
    public function getConfig(){    //获取配置
        $_system = new SystemModel();
        echo json_encode($_system->findAll());
    }
    
    public function getFocusArticle(){  //获取焦点文章
        $_article=new ArticleModel();
        echo json_encode($_article->getFocusArticle());
    }
    
    public function setVisitCount(){    //统计访问量
        $total=new TotalModel();
        $total->setCount('visit',1);
    }
    
    public function getSearch(){    // 获取搜索
        $_article=new ArticleModel();
        echo json_encode($_article->getSearch());
    }
    

    public function getContentListId(){         //有用    --废了
        $_tem=[];
        $_article=new ArticleModel();
        $_num=isset($_GET['page_size']) ? $_GET['page_size'] : 5;
        
        $_idList=$_article->getContentListId();
        $total=count($_idList);
        
        foreach ($_idList as $_value){
            $route=new stdClass();
            $route->url='/details/'.$_value->id;
            array_push($_tem,$route);
        }
        for($i=1;$i<=ceil($total/$_num);$i++){
            $route=new stdClass();
            $route->url='/article/'.$i;
            array_push($_tem,$route);
        }
        echo json_encode($_tem);
    }
     
    

    

    

    

    
   
}





































