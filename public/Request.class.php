<?php





class Request{
    static private $_instance;
    static public function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance=new Request();
        }
        return self::$_instance;
    }
    private function __construct(){
        Tool::setRequest();
    }
    
    public function fiter($_fields){
        $_addData=array();
        if(is_array($_POST) && !Validate::isNullArray($_POST)){
            //筛选数据
            foreach($_POST as $key=>$value){
                if(in_array($key,$_fields)){
                    $_addData[$key]=$value;
                }
            }
            return $_addData;
        }
    }
    
    public function getParam($_param){
        $_getParam=array();
        foreach($_param as $_key=>$_value){
            $_getParam[]=Tool::setFormString($_value);
        }
        return $_getParam;
    }
    
}




















