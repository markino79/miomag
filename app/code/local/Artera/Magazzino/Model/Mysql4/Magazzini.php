<?php

class Artera_Magazzino_Model_Mysql4_Magazzini extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){    
        $this->_init('magazzino/magazzini', 'id');
    }
}