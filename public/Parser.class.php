<?php

class Parser{
    private $_tpl;
    private $_vars;
    function __construct($_tplFile,$_vars){
        if(!$this->_tpl=file_get_contents($_tplFile)){
            exit('初始化模板文件失败,原因是模版没有任何内容');
        }
        $this->_vars=$_vars;
    }
    
    public function parSystem(){
        $_parStart='/\{\$tpl\.([\w]+)\.([\w]+)\}/';
        if(preg_match_all($_parStart,$this->_tpl,$_startAll)){
            foreach($_startAll[1] as $_key=>$_value){
                if(preg_match($_parStart,$this->_tpl)){
                    $_string='';
                    if($_value=='get'){
                        $_string='$_GET["'.$_startAll[2][$_key].'"]';
                    }else if($_value=='post'){
                        $_string='$_POST["'.$_startAll[2][$_key].'"]';
                    }else if($_value=='cookie'){
                        $_string='$_COOKIE["'.$_startAll[2][$_key].'"]';
                    }else {
                        exit('系统变量只支持 [get,post,cookie]');
                    }
                    $this->_tpl=preg_replace($_parStart,"<?php echo $_string; ?>",$this->_tpl,1);
                }
            }
        }
    }
    
    public function parVar(){
        $_parStart='/\{\$(?!tpl)(.*)\}/U';
        if(preg_match_all($_parStart,$this->_tpl,$_startAll)){  //如果找到 $变量
            foreach($_startAll[1] as $_value){
                $_string=$this->ParVarTion($_value);
                if(preg_match($_parStart,$this->_tpl)){
                    $this->_tpl=preg_replace($_parStart,"<?php echo $_string; ?>",$this->_tpl,1);
                }
            }
        }
    }
    
    public function parIf(){
        $_parStart='/\{if\s(.*)\}/U';
        $_parElseIf='/\{elseif\s*(.*)\}/';
        $_parElse='/\{else\}/';
        $_parEnd='/\{\/if\}/';
        if(preg_match_all($_parStart,$this->_tpl,$_startAll)){  //如果找到 if 语句
            foreach($_startAll[1] as $_value){
                $_string=$this->ParIfTion($_value);
                if(preg_match($_parStart,$this->_tpl)){
                        $this->_tpl=preg_replace($_parStart,"<?php if($_string){ ?>",$this->_tpl,1);
                }
            }
        }
        if(preg_match_all($_parElseIf,$this->_tpl,$_elseIfAll)){   //如果有else if 条件
            foreach ($_elseIfAll[1] as $_value){
                $_string=$this->ParIfTion($_value);
                $this->_tpl=preg_replace($_parElseIf,"<?php }else if($_string){?>",$this->_tpl,1);
            }
        }
        $this->_tpl=preg_replace($_parElse,"<?php }else{?>",$this->_tpl);   //如果有else语句
        $this->_tpl=preg_replace($_parEnd,"<?php } ?>",$this->_tpl);        //找到if结尾语句
    }

    public function ParFor(){
        $_parTem=array();
        $_parStart='/\{foreach\s+(.*)\}/';
        $_parEnd='/\{\/foreach\}/';
        if(preg_match_all($_parStart, $this->_tpl,$_StartAll)){
            foreach($_StartAll[1] as $_key=>$_value){
                $_target=$this->ParForTion($_value);
                $this->_tpl=preg_replace($_parStart,"$_target",$this->_tpl,1);
            }
            $this->_tpl=preg_replace($_parEnd,"<?php } ?>", $this->_tpl);
        }
    }
    
    public function ParInclude(){
        $_parStart='/\{include\s+file=(\'|\")([\w\.\-\/]+)(\'|\")\}/';
        if(preg_match_all($_parStart,$this->_tpl,$_startAll)){
            foreach($_startAll[2] as $_key=>$_value){
                if(!file_exists(TPL_DIR.$_value)){
                    exit(TPL_DIR.$_value.'模版不存在');
                }
            }
            $this->_tpl=preg_replace($_parStart,"<?php \$this->create(TPL_DIR.'\\2');?>",$this->_tpl);
        }
    }
    
    public function ParCheckBoxes(){
        $_parStart='/\{html_checkboxes\s+(.*)\}/';                 
        if(preg_match_all($_parStart, $this->_tpl,$_startAll)){
            foreach($_startAll[1] as $_value){
                $_target=$this->ParCheckTion($_value);
                $this->_tpl=preg_replace($_parStart,"$_target",$this->_tpl,1);
            }
        }
    }
    
    public function ParRadios(){
        $_parStart='/\{html_radios\s+(.*)\}/'; 
        if(preg_match_all($_parStart, $this->_tpl,$_startAll)){
            foreach($_startAll[1] as $_value){
                $_target=$this->ParRadioTion($_value);
                $this->_tpl=preg_replace($_parStart,"$_target",$this->_tpl,1);
            }
        }
    }
    
    public function ParOptions(){
        $_parStart='/\{html_options\s+(.*)\}/';
        if(preg_match_all($_parStart, $this->_tpl,$_startAll)){
            foreach($_startAll[1] as $_value){
                $_target=$this->ParOptionsTion($_value);
                $this->_tpl=preg_replace($_parStart,"$_target",$this->_tpl,1);
            }
        }
    }
    
    private function ParIfTion($_string){ //处理if语句专用
        //echo $_string.'</br>';
        $_parStart='/\$([\w]+)*/';
        if(preg_match_all($_parStart,$_string,$_startAll)){
            foreach($_startAll[1] as $_value){
                //echo $_value.'<br/>';
                if($_value=='tpl'){
                    $_parTpl='/\$tpl\.([\w]+)\.([\w]+)/';
                    if(preg_match($_parTpl,$_string,$_tplAll)){
                        if($_tplAll[1]=='get'){
                            $_target='$_GET["'.$_tplAll[2].'"]';
                        }else if($_tplAll[1]=='post'){
                            $_target='$_POST["'.$_tplAll[2].'"]';
                        }else if($_tplAll[1]=='cookie'){
                            $_target='$_COOKIE["'.$_tplAll[2].'"]';
                        }else {
                            exit('系统变量只支持 [get,post,cookie]');
                        }
                        $_string=preg_replace($_parTpl,"$_target",$_string,1);
    
                    }
                }else{
                  
                    $_target=isset($this->_vars[$_value]) ? '@this->_vars["'.$_value.'"]' : '@'.$_value;
                    $_string=preg_replace('/\$(?![\_GET]|[\_POST]|[\_COOKIE])([\w]+)*/',"$_target",$_string,1);
                   
                }
                
              
                
            }
            $_string=preg_replace('/\@([\w]+)*/',"\$$1",$_string);
        }
        return $_string;
    }
    
    private function ParVarTion($_string){ //处理Var语句专用
        $_parStart='/^([\w]+)(.*)/';
        $_string=preg_replace($_parStart,"isset(\$\\1\\2) ? \$\\1\\2 : \$this->_vars['\\1']\\2",$_string);
        return $_string;
    }
    
    private function ParForTion($_string){ //处理for语句专用
        $_tmpArr1=explode(' ', $_string);
        $_tmpArr2=array();
        $_ParFrom='/from=\$([\w]+)(.*)/';
        $_ParItem='/item=([\w]+)/';
        $_ParKey='/key=([\w]+)/';
        foreach($_tmpArr1 as $_key=>$_value){
            $tmp=array();
            if(preg_match_all($_ParFrom, $_value,$_FromAll)){

                $_from=isset($this->_vars[$_FromAll[1][0]]) ? '$this->_vars["'.$_FromAll[1][0].'"]' : '$'.$_FromAll[1][0];
                $_tmpstr=preg_replace('/\$([\w]+)(.*)/',"$_from\\2",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
            }else if(preg_match_all($_ParItem, $_value,$_ItemAll)){
                $_tmpstr=preg_replace($_ParItem,"item=\$\\1",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
            }else if(preg_match_all($_ParKey, $_value,$_KeyAll)){
                $_tmpstr=preg_replace($_ParKey,"key=\$\\1",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
            }
        }
        $_target='';
        $_target.=isset($_tmpArr2['from']) ? "<?php foreach(".$_tmpArr2['from']." as " : exit('foreach必须要有 from ');
        $_target.=isset($_tmpArr2['key']) ? $_tmpArr2['key']."=>" : "";
        $_target.=isset($_tmpArr2['item']) ? $_tmpArr2['item']."){ ?>" : exit('foreach必须要有 item ');
        return $_target;
    }
    
    private function ParCheckTion($_string){
        
        $_tmpArr2=$this->ParHtmlForm($_string);
        $_target='';
        $_target.=!empty($_tmpArr2['options']) ? "<?php foreach(".$_tmpArr2['options']." as \$_key=>\$_value){" : exit('html_checkboxes必须要有 options ');
       
            $_target.= <<<ENG
                    
                    if(is_array({$_tmpArr2['selected']})){
                            if(in_array(\$_key,{$_tmpArr2['selected']})){  
                                echo '<label><input type="checkbox" value="'.\$_key.'" name={$_tmpArr2['name']} checked/>'.\$_value.'</label>'; 
                            }else {
                                echo '<label><input type="checkbox" value="'.\$_key.'" name={$_tmpArr2['name']} />'.\$_value.'</label>'; 
                            }
                    }else {
                   
                        if(\$_key=={$_tmpArr2['selected']}){
                            echo '<label><input type="checkbox" value="'.\$_key.'" name={$_tmpArr2['name']} checked/>'.\$_value.'</label>';    
                        }else {
                            echo '<label><input type="checkbox" value="'.\$_key.'" name={$_tmpArr2['name']} />'.\$_value.'</label>';    
                        }
                    }
            }

                                ?>
ENG;
        
        return $_target;
    }
    
    
    private function ParRadioTion($_string){
        $_tmpArr2=$this->ParHtmlForm($_string);
        $_target='';
        $_target.=!empty($_tmpArr2['options']) ? "<?php foreach(".$_tmpArr2['options']." as \$_key=>\$_value){" : exit('html_radios必须要有 options ');
        $_target.= <<<ENG
       
                    if(\$_key=={$_tmpArr2['selected']}){
                        echo '<label><input type="radio" value="'.\$_key.'" name={$_tmpArr2['name']} checked/>'.\$_value.'</label> ';
                    }else {
                        echo '<label><input type="radio" value="'.\$_key.'" name={$_tmpArr2['name']} />'.\$_value.'</label>';
                    }
           } 
                                ?>
ENG;
        return $_target;
    }
    
    private function ParOptionsTion($_string){
        $_tmpArr2=$this->ParHtmlForm($_string);
        $_target='';
        $_target.=isset($_tmpArr2['options']) ? "<?php foreach(".$_tmpArr2['options']." as \$_key=>\$_value){" : exit('html_radios必须要有 options ');
        $_target.= <<<ENG
    
                    if(\$_key=={$_tmpArr2['selected']}){
                        echo '<option value="'.\$_key.'" selected/>'.\$_value.'</option>';
                    }else {
                        echo '<option value="'.\$_key.'"/>'.\$_value.'</option>';
                    }
           }
                                ?>
ENG;
        return $_target;
    }
    
    private function ParHtmlForm($_string){
        $_tmpArr1=explode(' ', $_string);
        $_tmpArr2=array();
        $_tmpArr2['selected']='2';
        $_tmpArr2['name']=' ';
        $_ParOption='/options=\$([\w]+)(.*)/';
        $_ParName='/name=(\"|\')*(\$[\w]+|[\w]+)(\"|\')*/';
        $_ParSelected='/selected=(\"|\')*(\$[\w]+|[\w]+)(\"|\')*/';
        foreach($_tmpArr1 as $_key=>$_value){
            $tmp=array();
            if(preg_match_all($_ParOption, $_value,$_OptionAll)){
                $_option=isset($this->_vars[$_OptionAll[1][0]]) ? '$this->_vars["'.$_OptionAll[1][0].'"]' : '$'.$_OptionAll[1][0];
                $_tmpstr=preg_replace('/\$([\w]+)(.*)/',"$_option\\2",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
            }else if(preg_match_all($_ParName, $_value,$_NameAll)){
        
                $_tmpstr=preg_replace($_ParName,"name=\\2",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
        
                if(strpos($_tmpArr2['name'],'$')!==false){
                    $_option=isset($this->_vars[substr($_tmpArr2['name'],1)]) ? '\'.$this->_vars["'.substr($_tmpArr2['name'],1).'"].\'' : '\'.'.$_tmpArr2['name'].'.\'';
                    $_tmpArr2['name']=$_option;
                }else {
                    $_tmpArr2['name'] ='"'.$_tmpArr2['name'].'"';
                }
            }else if(preg_match_all($_ParSelected, $_value,$_SelectedAll)){
                $_tmpstr=preg_replace($_ParSelected,"selected=\\2",$_value,1);
                $tmp=explode('=', $_tmpstr);
                $_tmpArr2[$tmp[0]]=$tmp[1];
                if(preg_match('/^\$/',$_tmpArr2['selected'])!=false){
                    $_string=preg_replace('/\$([\w]+)(.*)/',"\$a=isset(\$\\1\\2) ? '\$\\1\\2' : '\$this->_vars[\"\\1\"]\\2';",$_tmpArr2['selected']);
                    eval($_string);
                    $_tmpArr2['selected']=$a;
                }else {
                    $_tmpArr2['selected'] ='"'.$_tmpArr2['selected'].'"';
                }
            }
        }
        return $_tmpArr2;
    }
    
    public function compile($_parFile){
        $this->parVar();
        $this->ParFor();
        $this->parSystem();
       
        $this->parIf();
        $this->ParCheckBoxes();
        $this->ParRadios();
        $this->ParOptions();
        $this->parInclude();
        
        
        if(!file_put_contents($_parFile, $this->_tpl)){
            exit('解析模板里的内容失败');
        }
    }
}

