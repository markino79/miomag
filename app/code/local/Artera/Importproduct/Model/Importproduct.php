<?php

class Artera_Importproduct_Model_Importproduct extends Mage_Core_Model_Abstract{
	public function _construct() {
		parent::_construct() ;
		$this->_init('importproduct/importproduct');
	}
}