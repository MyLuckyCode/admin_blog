<?php


class SystemModel extends Model{
    private $_fields=array('id','focusArticle');
    protected $_tables=array(DB_FREFIX.'system');
    public function __construct(){
        parent::__construct();
        list(
            $this->_R['id']
        )=$this->getRequest()->getParam(array(
            isset($_GET['id']) ? $_GET['id'] : null
        ));
    }
    
    public function findAll(){
        return parent::select(array('*'), null);
    }
    
    public function setArticleFocus(){
        $_where=array("id=1");
        $_updateData['focusArticle']=$this->_R['id'];
        return parent::update($_updateData, $_where);
    }
    
    

}
















