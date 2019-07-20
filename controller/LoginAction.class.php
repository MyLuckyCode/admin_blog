<?php

class LoginAction extends Action{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_tpl->display(VIEW_ADMIN.'public/login.tpl');
        $this->_tpl->implement();
    }
    
    public function login(){
        if(isset($_POST['send'])){
            if($_POST['user']=='admin' && $_POST['pass']=='123456'){
                setcookie('user',$_POST['user']);
				$_SESSION['user']=$_POST['user'];
                header("location:?a=admin");
            }else {
                Redirect::getInstance()->error('账号或密码错误');
            }
        }
    }
    
    public function outLogin(){
        setcookie('user','',time()-1);
		session_destroy();
        header("location:?a=login");
    }
    
}