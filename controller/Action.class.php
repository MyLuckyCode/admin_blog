<?php

class Action{
    protected $_tpl;
    protected $_model;
    public function __construct(){
        $this->_tpl=new TPL();
        $this->_model=Factory::setModel();
    }
    
    public function run(){
       $_m=isset($_GET['m']) ? $_GET['m'] : 'index';
       method_exists($this, $_m) ? eval('$this->'.$_m.'();') : $this->index();
    }
    
    protected function includesStyle($name){
        return  
        <<<ENG
            <link rel="stylesheet" href="view/admin/style/basic.css">
	       <link rel="stylesheet" href="view/admin/style/{$name}.css">
	       <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
	       <link rel="stylesheet" href="//at.alicdn.com/t/font_1173901_f875hvgvvrp.css">
ENG;
    }
    
    protected function includesScript($name,$components=[]){
     
        $str =<<<ENG
            <script src="view/admin/js/vue.js"></script>
            <script src="https://unpkg.com/element-ui/lib/index.js"></script>
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
ENG;
        
        if(isset($components)){
            foreach($components as $value){
                $str .= 
                    <<<ENG
                          <script type="text/javascript" src="view/admin/components/{$value}/index.js"></script>
ENG;
            }
        }
        $str.= 
            <<<ENG
                <script type="text/javascript" src="view/admin/js/{$name}.js" ></script> 
ENG;
        return $str;
    }
    
}















