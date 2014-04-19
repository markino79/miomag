<?php

class Artera_Afm_Model_Afm extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('afm/afm');
    }
}