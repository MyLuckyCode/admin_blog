<?php

include './config.php';

function getA(){
	if(isset($_GET['a']) && !empty($_GET['a'])){
		return $_GET['a'];
	}
	exit('{"code":"404","data":"api错误"}');
}

$_a=getA();
if(!file_exists('./'.ucfirst($_a).'Api.class.php')) exit('{"code":"404","data":"api不存在"}'); ;
eval('$_obj = new '.ucfirst($_a).'Api();');
$_obj->run();



?>