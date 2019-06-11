<?php

class Validate{
    static public function isNullArray($_array){
        return count($_array)==0 ? true : false;
    }
    
    static public function checkStrLength($_string,$_length,$_flag,$_charset='utf-8'){
        if($_flag=='min'){
            if(mb_strlen(trim($_string),$_charset)<$_length)return true;
            return false;
        }else if($_flag=='max'){
            if(mb_strlen(trim($_string),$_charset)>$_length)return true;
            return false;
        }else if($_flag=='equals'){
            if(mb_strlen(trim($_string),$_charset)!=$_length)return true;
            return false;
        }
    }
    
    static public function isNullString($_string){
        return empty($_string) ? true : false;
    }
    
}