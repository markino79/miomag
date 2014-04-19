<?php

class Artera_Magazzino_Model_Magazzini extends Mage_Core_Model_Abstract{
    public function _construct() {
        parent::_construct();
        $this->_init('magazzino/magazzini');
    }
    public function getListForSelectField(){
    	$magazzini = $this->getCollection() ;
    	$list = array() ;
    	foreach ($magazzini as $magazzino){
    		$list[] = array(
    				'value' => $magazzino->getId() ,
    				'label' => $magazzino->getNome()
    				);
    	}
    	return $list ;
    }
    public function getListForOptionsGrid(){
    	$mc = $this->getCollection() ;
    	$ar = array() ;
    	foreach($mc as $m){
    		$ar[$m->id] = $m->nome ;
    	}
    	return $ar ;
    }
}