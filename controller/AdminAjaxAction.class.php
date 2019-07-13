<?php
// header('Access-Control-Allow-Origin:*');
class AdminAjaxAction extends Action{
    
    public function __construct(){
        //header('Access-Control-Allow-Origin:*');
    }
    /*
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
    */
	
	/*
    public function addPicture(){       //增加相册
        $_picture=new PictureModel();
        if($_picture->addPicture()){
            echo '{"state":"succ","info":"添加成功"}';
        }else {
            echo '{"state":"error","info":"添加失败"}';
        }
    }
    
    public function editPicture(){  //修改相册
        $_picture=new PictureModel();
        if($_picture->editPicture()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }
    
    public function deletePicture(){    //删除相册
        $_picture=new PictureModel();
        if($_picture->deletePicture()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function getPictureList(){   //获取全部相册
        $_picture=new PictureModel();
        echo json_encode($_picture->getPictureList());
    }
    
    public function deletePictureItem(){    //删除图片
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->deletePictureItem()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成删除不干净"}';
        }
    }
    
    public function editImageName(){    //修改图片名称
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->editImageName()){
            echo '{"state":"succ","info":"修改成功"}';
        }else {
            echo '{"state":"error","info":"修改失败"}';
        }
    }

    public function movePictureItem(){    //移动图片
        $_pictureItem=new PictureItemModel();
        if($_pictureItem->movePictureItem()){
            echo '{"state":"succ","info":"移动成功"}';
        }else {
            echo '{"state":"error","info":"系统出错，可能造成移动不干净"}';
        }
    }
    */
	
    public function upImg(){    //上传图片
        echo Up::UpImg();
    }
	
    /*
    public function getPictureItem(){   // 获取 图片 列表
        $_pictureItem = new PictureItemModel();
        $_type=$_POST['type'];
        $_currentPage=$_POST['currentPage'];
        $_pageSize=$_POST['pageSize'];
        echo json_encode($_pictureItem->getImageList($_type,$_currentPage,$_pageSize));
    }
    */
	
    public function postClippingImage(){    //添加裁剪图片
        $image = new ImagesModel();
        $uniqueId = $image->addImage('clipping');
        if($uniqueId){
            echo '{"state":"succ","info":"裁剪成功","uniqueId":"'.$uniqueId.'"}';
        }else {
            echo '{"state":"error","info":"裁剪失败,后台出错"}';
        }
    }
    
	/*
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
    */
	
	/*
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
    */
	
	/*
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
	*/
	
	
    /*
    public function deleteComment(){    //删除评论
        $comment = new CommentModel();
        if($comment->deleteComment()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
	*/
    
	/*
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
	*/
	
	/*
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
	
	*/
    
    
}





































