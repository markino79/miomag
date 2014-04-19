<?php

class Artera_Afm_Model_Mysql4_Afm_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('afm/afm');
    }
}