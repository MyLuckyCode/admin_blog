<?php

class Tool{
    static public function setFormString($_string){
        if(!get_magic_quotes_gpc()){
            if(is_array($_string)){
                foreach($_string as $_key=>$_value){
                    $_string[$_key]=self::setFormString($_value);
                }
            }else {
                return addslashes($_string);
            }
        }
        return $_string;
    }
    
    static public function setRequest(){
        if(isset($_GET)) $_GET=self::setFormString($_GET);
        if(isset($_POST)) $_POST=self::setFormString($_POST);
    }
    
    static public function getDate(){
        return date('Y-m-d H:i:s');
    }
    
    
    static public function setFormItem($_data,$key,$value){
        $_items=array();
        if(is_array($_data)){
            foreach ($_data as $_k=>$_v){
                $_items[$_v->$key]=$_v->$value;
                if(isset($_v->child)){
                    $_items['child']=self::setFormItem($_v->child,'id', 'name');
                }
            }
            return $_items;
        }   
    }
    
    static public function getPrevPage(){
        return empty($_SERVER['HTTP_REFERER']) ? '###' : $_SERVER['HTTP_REFERER'];
    }
    
    static public function setStr($str,$start,$length,$encoding){
        return mb_substr($str, $start,$length,$encoding);
    }
    
    static public function getUnique(){
        $cherset='abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTWXYZ23456789';
        $_len=strlen($cherset)-1;
        $code='';
        for($j=0;$j<20;$j++){
            $code.=$cherset[mt_rand(0,$_len)];
        }
        $times=time();
        return $times.$code;
    }
    
    static public function getIp(){
        $ip=false;

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    
            $ip=$_SERVER['HTTP_CLIENT_IP'];
    
        }

        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    
            $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
    
            if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
    
            for ($i=0; $i < count($ips); $i++){
    
                if(!preg_match ('/^(10│172.16│192.168)./', $ips[$i])){
    
                    $ip=$ips[$i];
    
                    break;
    
                }
    
            }
    
        }

        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
        
    }
    
    
    
    
}
