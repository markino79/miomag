<?php

class Artera_Ordercli_Model_Mysql4_Ordercli_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ordercli/ordercli');
    }
}