<?php

class TPL{
    
    private $_vars=array();
    private $_tplFile='';      //模版文件路径
    private $_parFile='';       //编译文件路径
    private $_cacheFile='';     //缓存文件路径
    static public $_cache=false;        //是否开启缓存
    static public $_noCache=array();      //指定文件不缓存
	static public $_compileDir='';
	static public $_cacheDir='';
    public function assign($_var,$_value){
        $this->_vars[$_var]=$_value;
    }
    
    public function display($_file){
        $this->_tplFile=$_file;
        
        $_fileArr=pathinfo($this->_tplFile);
        if(!file_exists($this->_tplFile)){
            exit($_fileArr['basename'].'这个模版不存在');
        }
        
        $_fileQuery='';
        
        if(!empty($_SERVER["QUERY_STRING"])){
            $_fileQuery=$_SERVER["QUERY_STRING"];
        }
        
        $this->_parFile=self::$_compileDir.md5($_fileArr['dirname']).'_'.$_fileArr['basename'].'.php';  //编译文件
        $this->_cacheFile=self::$_cacheDir.md5($_fileArr['dirname']).'_'.$_fileArr['basename'].$_fileQuery.'.html'; //缓存文件
        
        if(self::$_cache && !in_array($this->_tplFile, self::$_noCache)){
            if(file_exists($this->_parFile) && file_exists($this->_cacheFile)){
                if(filemtime($this->_parFile) >= filemtime($this->_tplFile) && filemtime($this->_cacheFile) >= filemtime($this->_parFile)){
                    include $this->_cacheFile;
                    exit ;
                }
            }
        }
        return $this;
    }
    
    public function implement(){
        $_fileArr=pathinfo($this->_tplFile);
        if(!file_exists($this->_parFile) || filemtime($this->_tplFile)>filemtime($this->_parFile)){
            $_parser=new Parser($this->_tplFile,$this->_vars);
            $_parser->compile($this->_parFile);
        }
        include $this->_parFile;
        if(self::$_cache && !in_array($this->_tplFile, self::$_noCache)){
            file_put_contents($this->_cacheFile,ob_get_contents());
            //清除缓冲区(清除了编译文件加载的内容)
            ob_end_clean();
            //载入缓存文件
            include $this->_cacheFile;
        }
    }
    
    public function create($_file){
        $_fileArr=pathinfo($_file);
        if(!file_exists($_file)){
            exit($_fileArr['basename'].'这个模版不存在');
        }
        //编译文件
        $_parFile=self::$_compileDir.md5($_fileArr['dirname']).'_'.$_fileArr['basename'].'.php';  //编译文件
        //当编译文件不存在，或者模板文件修改过，则生成编译文件
        if (!file_exists($_parFile) || filemtime($_parFile) < filemtime($_file)) {
            //引入模板解析类
            $_parser=new Parser($_file,$this->_vars);
            $_parser->compile($_parFile);
        }
        //载入编译文件
        include $_parFile;
    }
    

    
}

