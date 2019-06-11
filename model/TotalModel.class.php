<?php


class TotalModel extends Model{
    private $_fields=array('id','nav','label','article','comment','visit','page','lastDate');
    protected $_tables=array(DB_FREFIX.'total');
    public function __construct(){
        parent::__construct();
    }
    
    public function setCount($fields,$count){
        $_where=array("id=1");
        $_updateData[$fields]=array("$fields+$count");
        return parent::update($_updateData,$_where);
    }
    
    public function setLastDate($fields,$date){
        $_where=array("id=1");
        $_updateData[$fields]=$date;
        return parent::update($_updateData,$_where);
    }
    
    public function findOne(){
        return parent::select(array('*'), null);
    }
    
    

    

}
















