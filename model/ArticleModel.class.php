<?php


class ArticleModel extends Model{
    private $_fields=array('title','nav','label','face','info','content','fabulous','flagComment',
                            'readCount','keyword','source','author','commentCount','roof','disabled','date','update_date');
    protected $_tables=array(DB_FREFIX.'article');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['id'],
            $this->_R['s']
        )=$this->getRequest()->getParam(array(
            isset($_GET['id']) ? $_GET['id'] : null,
            isset($_GET['s']) ? $_GET['s'] : null
        ));
    }
    
    public function addArticle(){       
        $_addData=$this->getRequest()->fiter($this->_fields);
        $_addData['date']=Tool::getDate();
        $_addData['update_date']=Tool::getDate();
        
        $total=new TotalModel();
        $total->setCount('article',1);
        $total->setLastDate('lastDate', Tool::getDate());
        
        if(parent::add($_addData)){
            $id = parent::lastInsertId();
            $_articleHistory = new ArticleHistoryModel();
            $_addData['pid']=$id;
            return $_articleHistory->addArticleHistory($_addData);
        }else return false;
    }
    
    public function findOne(){  //获取一条 后台ajax用
        $_where=array("id='{$this->_R['id']}'");
        if(!$this->isOne($_where)) return array('state'=>'error','info'=>'该文档不存在');
        $_all=parent::select(array('id','title','nav','label','face','info','content','fabulous','flagComment','roof',
            'readCount','keyword','source','author','disabled','date'),array('where'=>$_where,'limit'=>1));
        return array('state'=>'succ','data'=>$_all[0]);
    }
    
    public function editArticle(){       //修改一条 后台ajax用
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=$this->getRequest()->fiter($this->_fields);
        $_updateData['update_date']=Tool::getDate();
        
        $total=new TotalModel();
        $total->setLastDate('lastDate', Tool::getDate());
        
        if(parent::update($_updateData, $_where)){
            
            $_articleHistory = new ArticleHistoryModel();
            $_updateData['pid']=$this->_R['id'];
            $_updateData['date']=Tool::getDate();
            return $_articleHistory->addArticleHistory($_updateData);
            
        }else return false;

    }
    
    public function findAll($_pageCurrent,$page_size){     //后台模版调用
        
        if(isset($this->_R['s']) && !empty($this->_R['s'])){
            $tem =implode(explode(" ",$this->_R['s']),'');
            if(!empty($tem)){
                $_where = array("(title like '%{$this->_R['s']}%' OR keyword like '%{$this->_R['s']}%' OR a.info like '%{$this->_R['s']}%')");
            }else {
                $_where =null;
            }
        }else {
            $_where =null;
        }
        
        $_start=($_pageCurrent-1)*$page_size;
        $_end=$page_size;
        $this->_tables=array(DB_FREFIX.'article a LEFT JOIN '.DB_FREFIX.'nav b ON a.nav=b.id');
        $_all=parent::select(array('a.id','a.title','a.nav','a.label','a.face','a.info','a.content','a.fabulous','a.flagComment','a.commentCount',
                           'a.roof','a.readCount','a.keyword','a.date','a.source','a.author','a.disabled','a.date smallDate','b.name NavName'),
            array('where'=>$_where,'limit'=>"$_start,$_end",'order'=>'roof DESC,date DESC'));
        $this->_tables=array(DB_FREFIX.'label');
        foreach($_all as $key=>$value){
           
            if($value->label!=''){
                $value->label=parent::select(array('id','name'), array('where'=>array("id in ($value->label)")));
                $_tem=[];
                foreach($value->label as $v){
                    $_tem[]= $v->name;
                }
                $value->label =implode(',',$_tem);
            }
            $value->smallDate=Tool::setStr($value->smallDate, 0, 10, 'utf-8');
            $value->info=Tool::setStr($value->info, 0, 20, 'utf-8');
            
        }
        return $_all;
    }
    
    public function findOneTitle($id){ //获取文章的标题，后台评论用
        return parent::select(array('id','title'),
            array('where'=>array("id=$id"),'limit'=>"1"));
    }
    
    public function getFocusArticle($id=null){  //获取焦点文章
        $id = isset($id) ? $id :$this->_R['id'];
        return parent::select(array('id','title','info'),
            array('where'=>array("id=$id"),'limit'=>"1"));
    }
    
    public function getTotal(){     //后台模版用
        if(isset($this->_R['s']) && !empty($this->_R['s'])){
            $tem =implode(explode(" ",$this->_R['s']),'');
            if(!empty($tem)){
                $_where = array("(title like '%{$this->_R['s']}%' OR keyword like '%{$this->_R['s']}%' OR info like '%{$this->_R['s']}%')");
            }else {
                $_where =null;
            }
        }else {
            $_where =null;
        }
        
        return parent::total($_where);
    }
    
    public function deleteArticle(){   //后台模版用
        $_where=array("id='{$this->_R['id']}'");
        
        $total=new TotalModel();
        $total->setCount('article',-1);
        
        return parent::delete($_where);
    }

    
    public function getIndexArticle(){  //前端 ajax调用,获取文章列表

        $_start=($_GET['page']-1)*$_GET['page_size'];
        $_end=$_GET['page_size'];
        
        $_type=isset($_GET['type']) ? $_GET['type'] :'web';
        
        if(is_numeric($_type)){
            $_where=array("nav={$_type}","a.disabled=1");
        }else {
            $_where=array("category='{$_type}'");
            $this->_tables=array(DB_FREFIX.'nav');
            $_nav=parent::select(array('id'), array('where'=>$_where));
            if(empty($_nav)) return array();
            $_tem=[];
            foreach($_nav as $_value){
                array_push($_tem,$_value->id);
            }
           
            $_nav=implode(',',$_tem);
            $_where=array("a.disabled=1","nav in ($_nav)");
        }
        
        $this->_tables=array(DB_FREFIX.'article a LEFT JOIN blog_nav b ON a.nav=b.id');
        $_all=parent::select(array('a.id','a.title','a.nav','a.label','a.face','a.info','a.fabulous','a.flagComment','a.commentCount','a.roof',
            'a.readCount','a.keyword','a.source','a.author','a.disabled','a.date','b.name NavName'),array('where'=>$_where,'limit'=>"$_start,$_end",'order'=>'roof DESC,date DESC'));
        return $_all;
    }
    
    public function getSearch(){
        $_start=($_GET['page']-1)*$_GET['page_size'];
        $_end=$_GET['page_size'];
        $_where = array("(title like '%{$this->_R['s']}%' OR keyword like '%{$this->_R['s']}%' OR a.info like '%{$this->_R['s']}%')","a.disabled=1");
        $this->_tables=array(DB_FREFIX.'article a LEFT JOIN blog_nav b ON a.nav=b.id');
        $_all=parent::select(array('a.id','a.title','a.nav','a.label','a.face','a.info','a.fabulous','a.flagComment','a.commentCount','a.roof',
            'a.readCount','a.keyword','a.source','a.author','a.disabled','a.date','b.name NavName'),
            array('where'=>$_where,'order'=>'roof DESC,date DESC'));
        
        $html=array();
        
        $i=0;
        foreach($_all as $key=>$_value){
           if($key>=$_start && $i<$_end){
               $html[]=$_value;
               $i++;
               if($i==$_end) break;
           }
        }
        $tem=[];
        $tem['content']=$html;
        $tem['count']=count($_all);
        return $tem;
    }
    
    public function findIndexOne(){   //前端 ajax调用,获取 详情
        $_where=array("id='{$this->_R['id']}'");
        if(!$this->isOne($_where)) return array('info'=>'no');
        $_all=parent::select(array('id','title','nav','label','face','info','content','fabulous','flagComment',
            'readCount','commentCount','keyword','source','author','date'),array('where'=>$_where,'limit'=>1));
        $this->_tables=array(DB_FREFIX.'label');
        if($_all[0]->label!='')$_all[0]->label = parent::select(array('id','name'), array('where'=>array("id in ({$_all[0]->label})")));
        return $_all[0];
    }
    
    public function getArticlePrev(){       //获取下一条
        $this->_tables=array(DB_FREFIX.'article');
        $_where=array('id=(select min(id) from '.DB_FREFIX.'article where id>'.$this->_R['id'].' AND disabled=1)');
        $_all=parent::select(array('id','title'), array('where'=>$_where));
        if(empty($_all)) $_all[0]='到底了~';
        return $_all[0];
    }
    
    public function getArticleNext(){          //获取上一条
        $this->_tables=array(DB_FREFIX.'article');
        $_where=array('id=(select max(id) from '.DB_FREFIX.'article where id<'.$this->_R['id'].' AND disabled=1)');
        $_all=parent::select(array('id','title'), array('where'=>$_where));
        if(empty($_all)) $_all[0]='不能在上了~';
        return $_all[0];
    }
    
    
    public function getIndexTotal(){        //有用，获取总数
        
       $_type=isset($_GET['type']) ? $_GET['type'] :'web';
        
        if(is_numeric($_type)){
            $_where=array("nav={$_type}","disabled=1");
        }else {
            $_where=array("category='{$_type}'");
            $this->_tables=array(DB_FREFIX.'nav');
            $_nav=parent::select(array('id'), array('where'=>$_where));
            $_tem=[];
            foreach($_nav as $_value){
                array_push($_tem,$_value->id);
            }
            $_nav=implode(',',$_tem);
            $_where=array("nav in ($_nav)","disabled=1");
        }
        $this->_tables=array(DB_FREFIX.'article');
        return parent::total($_where);
    }
    
    
    public function getHot(){ //获取热门文章--前台
        return parent::select(array('id','title','readCount'), array('where'=>array("disabled=1"),'order'=>'readCount DESC','limit'=>'5'));
    }
    
    public function getUpdate(){ //获取最近更新文章--前台
        return parent::select(array('id','title','face','date'), array('where'=>array("disabled=1"),'order'=>'update_date DESC','limit'=>'5'));
    }
    
    
    public function getContentListId(){     //有用--废了
        return parent::select(array('id'),null);
    }
    
    public function deleteContent(){
        $_where=array("id='{$this->_R['id']}'");
        return parent::delete($_where);
    }
    
    public function setReadCount(){ //前台修改阅读量
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=array('readCount'=>array('readCount+1'));
        return parent::update($_updateData, $_where);
       
    }
    
    public function setFabulous(){   //前台修改点赞量
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=array('fabulous'=>array('fabulous+1'));
        return parent::update($_updateData, $_where);
    }
    public function setCommentCount($id){   //添加评论时修改评论量
        $_where=array("id=$id");
        $_updateData=array('commentCount'=>array('commentCount+1'));
        return parent::update($_updateData, $_where);
    }
    
    public function setRoof(){
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=array('roof'=>$_GET['value']);
        return parent::update($_updateData, $_where);
    }
    
    public function setFlagComment(){
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=array('flagComment'=>$_GET['value']);
        return parent::update($_updateData, $_where);
    }
    
    public function setDisabled(){
        $_where=array("id='{$this->_R['id']}'");
        $_updateData=array('disabled'=>$_GET['value']);
        return parent::update($_updateData, $_where);
    }
      
    
    
}
















