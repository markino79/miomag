<?php

class Artera_Magazzino_Model_Mysql4_Movimenti_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        parent::_construct();
        $this->_init('magazzino/movimenti');
    }
}