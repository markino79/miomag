<?php

class Artera_Puntivendita_Model_Mysql4_Puntivendita extends Mage_Core_Model_Mysql4_Abstract {
	public function _construct(){
		$this->_init('puntivendita/puntivendita','puntivendita_id') ;
	}
}
