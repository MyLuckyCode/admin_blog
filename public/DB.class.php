<?php

class DB{
    private $_pdo;
    static private $_instance;
    public function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance=new self;
        }
        return self::$_instance;
    }
    
    public function __get($key){
        
        if($key=='_pdo'){
            return $this->getInstance();
        }else return $this->$key;
    }
    
    private function __clone(){}
    // array(PDO::ATTR_PERSISTENT => true
    private function __construct(){
        try {
            
            //$this->_pdo=new PDO(DB_DNS,DB_USER,DB_PASS);
            $this->_pdo=new PDO(DB_DNS,DB_USER,DB_PASS, array(PDO::ATTR_PERSISTENT => true));
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    protected function add($_addData,$_tables){
        $_addFields=array();
        $_addValues=array();
        foreach($_addData as $_key=>$_value){
            $_addFields[]=$_key;
            $_addValues[]=$_value;
        }
        $_addFields=implode(',', $_addFields);
        $_addValues=implode("','", $_addValues);
        $_sql="INSERT INTO {$_tables[0]} ($_addFields)VALUES('$_addValues')";
        return $this->execute($_sql)->rowCount();
    }
    
    protected function isOne($_where,$_tables){
        $_temp='';
        foreach($_where as $_key=>$_value){
            $_temp .= "$_value AND ";
        }
        $_temp=substr($_temp, 0,-4);
        $_sql="SELECT id FROM {$_tables[0]} WHERE $_temp";
        return $this->execute($_sql)->rowCount();
    }
    
    protected function select($_fields,$_where,$_tables){
        $_selectFields=implode(',',$_fields);
        $_selectWhere=$_selectLimit=$_selectOrder='';
        if(isset($_where['where']) && is_array($_where['where'])){
            foreach($_where['where'] as $_value){
                $_selectWhere .= "$_value AND ";
            }
            $_selectWhere=' WHERE '.substr($_selectWhere, 0,-4);
        }
        $_selectLimit=isset($_where['limit']) ? 'LIMIT '.$_where['limit'] : '';
        $_selectOrder=isset($_where['order']) ? 'ORDER BY '.$_where['order'] : '';
        $_table=isset($_tables[1]) ? $_tables[0].','.$_tables[1] : $_tables[0];
        $_sql="SELECT $_selectFields FROM {$_table}$_selectWhere $_selectOrder $_selectLimit";
        $_stmt=$this->execute($_sql);
        $_result=array();
        while(!!$obj=$_stmt->fetchObject()){
            $_result[]=$obj;
        }
        return $_result;
    }
    
    protected function update($_updateData,$_where,$_tables){
        $_update=$_updateWhere='';
        foreach($_updateData as $_key=>$_value){
            if(is_array($_value)){
                $_update .= "$_key=$_value[0],";
            }else {
                $_update .= "$_key='$_value',";                
            }

        }
        foreach($_where as $_value){
            $_updateWhere .= "$_value AND ";
        }
        $_updateWhere = substr($_updateWhere, 0,-4);
        $_update=substr($_update, 0,-1);
        $_sql="UPDATE {$_tables[0]} SET $_update WHERE $_updateWhere LIMIT 1 ";
        return $this->execute($_sql)->rowCount();
    }

    protected function updateAll($_updateData,$_where,$_tables){
        $_update=$_updateWhere='';
        foreach($_updateData as $_key=>$_value){
            if(is_array($_value)){
                $_update .= "$_key=$_value[0],";
            }else {
                $_update .= "$_key='$_value',";                
            }

        }
        foreach($_where as $_value){
            $_updateWhere .= "$_value AND ";
        }
        $_updateWhere = substr($_updateWhere, 0,-4);
        $_update=substr($_update, 0,-1);
        $_sql="UPDATE {$_tables[0]} SET $_update WHERE $_updateWhere ";
        return $this->execute($_sql)->rowCount();
    }
    
    protected function total($_tables,$_where=null){
        $_totalWhere='';
        if(isset($_where) && is_array($_where)){
            foreach($_where as $_value){
                $_totalWhere .= "$_value AND ";
            }
            $_totalWhere='WHERE '.substr($_totalWhere, 0,-4);
        }
        $_sql="SELECT COUNT(*) as count FROM {$_tables[0]} $_totalWhere";
        return $this->execute($_sql)->fetchObject()->count;
    }
    
    protected function delete($_tables,$_where){
        $_deleteWhere='';
        if(isset($_where) && is_array($_where)){
            foreach($_where as $_value){
                $_deleteWhere .= "$_value AND ";
            }
            $_deleteWhere='WHERE '.substr($_deleteWhere, 0,-4);
        }
        $_sql="DELETE FROM $_tables[0] $_deleteWhere LIMIT 1";
        return $this->execute($_sql)->rowCount();
    }
    
    protected function deleteAll($_tables,$_where){
        $_deleteWhere='';
        if(isset($_where) && is_array($_where)){
            foreach($_where as $_value){
                $_deleteWhere .= "$_value AND ";
            }
            $_deleteWhere='WHERE '.substr($_deleteWhere, 0,-4);
        }
        $_sql="DELETE FROM $_tables[0] $_deleteWhere";
        return $this->execute($_sql)->rowCount();
    }
    
    protected function nextId($_tables){
        $_sql="SHOW TABLE STATUS LIKE '$_tables[0]'";
        $_stmt=$this->execute($_sql);
        return $_stmt->fetchObject()->Auto_increment;
    }
    
    protected function lastInsertId(){
        return $this->_pdo->lastInsertId();
    }
    
    
    protected function execute($_sql){
        try {
            $_stmt=$this->_pdo->prepare($_sql);
            $_stmt->execute();
        } catch (PDOException $e) {
            exit('SQL语句：'.$_sql.'</br>错误信息：'.$e->getMessage());
        }
        return $_stmt;
    }
    
}           