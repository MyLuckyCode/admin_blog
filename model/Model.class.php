<?php


class Model extends DB{
    private $_pdo;
    protected $_check;
    protected $_R=array();
    public function __construct(){
        $this->_pdo=parent::getInstance();
    }
    
    public function add($_addData,$_seat1=null){
        return $this->_pdo->add($_addData,$this->_tables);
    }
    
    protected function getRequest(){
        return Request::getInstance();
    }
    
    public function isOne($_where,$_seat1=null){
        return $this->_pdo->isOne($_where,$this->_tables);
    }
    
    protected function select($_fields,$_where,$_seat1=null){
        return $this->_pdo->select($_fields,$_where,$this->_tables);
    }
    
    protected function update($_updateData,$_where,$_seat1=null){
        return $this->_pdo->update($_updateData,$_where,$this->_tables);
    }

    protected function updateAll($_updateData,$_where,$_seat1=null){
        return $this->_pdo->updateAll($_updateData,$_where,$this->_tables);
    }

    protected function total($_where=null,$_seat1=null){
        return $this->_pdo->total($this->_tables,$_where);
    }
    
    protected function nextId($_seat1=null){
        return $this->_pdo->nextId($this->_tables);
    }
    
    protected function delete($_where,$_seat1=null){
        return $this->_pdo->delete($this->_tables,$_where);
    }

    protected function deleteAll($_where,$_seat1=null){
        return $this->_pdo->deleteAll($this->_tables,$_where);
    }
    
    protected function lastInsertId(){
        return $this->_pdo->lastInsertId();
    }

    
}