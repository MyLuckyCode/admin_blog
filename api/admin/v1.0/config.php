<?php


session_start(); 
define('ROOT_PATH',substr(dirname(__FILE__),0,-14));

define('DB_DNS','mysql:lost=localhost;dbname=admin_blog');
define('DB_USER','root');
define('DB_PASS','');
define('DB_FREFIX','blog_');

define('PAGE_SIZE',10);   //分页

define('PICTURE_INITIAL_ID',1); //默认上传图片到未分组相册，未分组相册 ID 为 1

$d = explode('-', date("Y-y-m-d-H-i-s"));
ini_set('log_error','no');      //开启日志写入功能
//ini_set('display_errors','off');    //屏蔽错误在页面显示
error_reporting(E_ALL);                //输出所有错误
ini_set('error_log','./log/'.$d[0].$d[2].$d[3].'.log');        //日志存放位置

spl_autoload_register(function($_className){
    if(substr($_className,-6)=='Action'){
        require ROOT_PATH.'/controller/'.$_className.'.class.php';
    }else if(substr($_className,-5)=='Model'){
        require ROOT_PATH.'/model/'.$_className.'.class.php';
    }else if(substr($_className,-3)=='Api'){
        require './'.$_className.'.class.php';
    }else{
        require ROOT_PATH.'/public/'.$_className.'.class.php';
    }
});


 







?>