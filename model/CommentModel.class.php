<?php


class CommentModel extends Model{
    private $_fields=array('id','content','name','email','url','face','user_ip','browser','content_id','p_name','pid');
    protected $_tables=array(DB_FREFIX.'comment');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['id'],
            $this->_R['content_id']
        )=$this->getRequest()->getParam(array(
            isset($_GET['id']) ? $_GET['id'] : null,
            isset($_GET['content_id']) ? $_GET['content_id'] : null
        ));
    }
    
    public function findAll($pageCurrent,$page_size){  //后台模版使用
        $_start=($pageCurrent-1)*$page_size;
        $_end=$page_size;
        $all = parent::select(array('id','content','name','email','url','browser','user_ip','content_id','date smallDate','date'),
            array('limit'=>"$_start,$_end",'order'=>'date DESC'));
        $tempArr=[];
        foreach($all as $key=>$value){
            $value->smallDate = Tool::setStr($value->smallDate, 0, 10, 'utf-8');
            $tempArr[$value->content_id]=$value->content_id;
        }
        $article = new ArticleModel();
        foreach($tempArr as $k=>$v){
            $one=$article->findOneTitle($v);
          
                foreach($all as $key=>$value){
                    if($value->content_id==$v){
                        if(isset($one) && !empty($one)){
                            $value->content_id=$one[0]->title;
                        }else{
                            $value->content_id='<span style="color:red;">改文章可能已经删除</span>';
                        }
                    }
                }            
        }

        return $all;
    }
    
    public function getTotal(){
        return parent::total();
    }
    
    public function deleteComment(){   //删除评论
        $_where=array("id='{$this->_R['id']}'");
        
        $total=new TotalModel();
        $total->setCount('comment',-1);
        
        return parent::delete($_where);
    }
    
    public function addComment(){     //有用
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getdate();
        $_user = new UserModel();
        $_addData['face']=$_user->findOne();
        $_addData['user_ip']=Tool::getIp();
        $_article = new ArticleModel();
        $_article->setCommentCount($_addData['content_id']);
        
        //统计数目
        $total=new TotalModel();
        $total->setCount('comment',1);
        
        if(parent::add($_addData)){
            return parent::lastInsertId();
        }else {
            return 0;
        }
    }
    
    public function getComment(){ //有用
        
        $_start=isset($_GET['start']) ? $_GET['start'] : 0 ;
        
        $_end=isset($_GET['end']) ? $_GET['end'] : 10 ;
        
        $_all = parent::select(array('id','content','name','face','browser','pid','date'),
            array('where'=>array('pid=0',"content_id='{$this->_R['content_id']}'"),'limit'=>"$_start,$_end",'order'=>'date ASC'));
        foreach($_all as $_key=>$_value){
           $this->getCommentItem($_value,$_value->id);
        }
        return $_all;
    }
     
    private function getCommentItem($_item,$id){
        $_all = parent::select(array('id','content','name','pid','p_name'),
            array('where'=>array("pid=$id")));
        if(empty($_all)){
            return [];
        }else {
            foreach($_all as $_key=>$_value){
                $_item->ul[]=$_value;
                $this->getCommentItem($_item,$_value->id);
            }
        }
        return $_all;
    }
    

}
















