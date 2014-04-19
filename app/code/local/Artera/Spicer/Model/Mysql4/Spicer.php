<?php

class Artera_Spicer_Model_Mysql4_Spicer extends Mage_Core_Model_Mysql4_Abstract{
	public function _construct(){
		$this->_init('spicer/spicer','spicer_id') ;
	}
}
