<?php

class Artera_Ordercli_Model_Mysql4_Ordercli extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ordercli_id refers to the key field in your database table.
        $this->_init('ordercli/ordercli', 'ordercli_id');
    }
}