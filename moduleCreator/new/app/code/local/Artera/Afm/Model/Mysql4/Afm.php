<?php

class Artera_Afm_Model_Mysql4_Afm extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the afm_id refers to the key field in your database table.
        $this->_init('afm/afm', 'afm_id');
    }
}