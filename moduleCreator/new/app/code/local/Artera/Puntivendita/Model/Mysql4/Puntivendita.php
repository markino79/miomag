<?php

class Artera_Puntivendita_Model_Mysql4_Puntivendita extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the puntivendita_id refers to the key field in your database table.
        $this->_init('puntivendita/puntivendita', 'puntivendita_id');
    }
}