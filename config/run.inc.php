<?php 
session_start();
ob_start();
header('Content-Type:text/html;chatset=urf-8');


define('ROOT_PATH',substr(dirname(__FILE__),0,-6));
define('CACHE_DIR',ROOT_PATH.'cache/'); //缓存目录
define('COMPILE_DIR',ROOT_PATH.'compile/'); //编译目录
define('TPL_DIR',ROOT_PATH.'view/'); // 模版目录
define('VIEW_ADMIN',ROOT_PATH.'view/admin/'); // 后台模版
//define('VIEW_FRONT',ROOT_PATH.'view/default/'); // 前台模版   ， 该网站前后端分离，没有前台

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
ini_set('error_log',ROOT_PATH.'/log/'.$d[0].$d[2].$d[3].'.log');        //日志存放位置


date_default_timezone_set('Asia/shanghai');

spl_autoload_register(function($_className){
    if(substr($_className,-6)=='Action'){
        require ROOT_PATH.'/controller/'.$_className.'.class.php';
    }else if(substr($_className,-5)=='Model'){
        require ROOT_PATH.'/model/'.$_className.'.class.php';
    }else{
        require ROOT_PATH.'/public/'.$_className.'.class.php';
    }
});

	
	
	
	
$_cache=array();		//如果开启缓存，则把不需要缓存的页面加进数组
TPL::$_noCache=$_cache;	
TPL::$_cache=false;		//不开启缓存

TPL::$_cacheDir = CACHE_DIR;	//缓存目录
TPL::$_compileDir = COMPILE_DIR;	//编译目录
Factory::setAction()->run();
