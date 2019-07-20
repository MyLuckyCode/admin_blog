

<?php

class Api{
	
	public function __construct(){
		if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
			exit('{"code":"404","info":"api验证出错"}');
		}
	}
	
	public function index(){
		exit('{"code":"404","info":"api错误"}');
	}
	
	public function run(){
       $_m=isset($_GET['m']) ? $_GET['m'] : 'index';
       method_exists($this, $_m) ? eval('$this->'.$_m.'();') : $this->index();
    }
	
	
}

?>
