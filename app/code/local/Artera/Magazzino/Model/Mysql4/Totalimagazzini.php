<?php
class Artera_Magazzino_Model_Mysql4_Totalimagazzini extends Mage_Core_Model_Mysql4_Abstract{
	public function _construct(){
		$this->_init('magazzino/totalimagazzini', 'id');
	}
}