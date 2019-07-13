

<?php

class Api{
	
	public function __construct(){
		
	}
	
	public function index(){
		exit('{"code":"404","data":"api错误"}');
	}
	
	public function run(){
       $_m=isset($_GET['m']) ? $_GET['m'] : 'index';
       method_exists($this, $_m) ? eval('$this->'.$_m.'();') : $this->index();
    }
	
	
}

?>
