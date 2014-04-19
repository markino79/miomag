<?php

class Artera_Importproduct_Model_Mysql4_Importproduct extends Mage_Core_Model_Mysql4_Abstract {
	public function _construct(){
		$this->_init('importproduct/importproduct','importproduct_id') ;
	}
}
