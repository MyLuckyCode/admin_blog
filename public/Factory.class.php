<?php




class Factory{
    static private $_obj;
    
    static function setAction(){
        $_a=self::getA();
        if(!isset($_COOKIE['user']) && $_a!='images' && $_a!='ajax'){
            $_a='Login';   
        }
        if(!file_exists(ROOT_PATH.'controller/'.ucfirst($_a).'Action.class.php')) $_a='Admin';
        eval('self::$_obj = new '.ucfirst($_a).'Action();');
        return self::$_obj;
    }
    
    static public function getA(){
        if(isset($_GET['a']) && !empty($_GET['a'])){
            return $_GET['a'];
        }
        return 'admin';
    }
    
    static public function setModel(){
        $_a=self::getA();
        if(file_exists(ROOT_PATH.'model/'.ucfirst($_a).'model.class.php')) eval('self::$_obj = new '.ucfirst($_a).'Model();');
        return self::$_obj;
    }
}
























