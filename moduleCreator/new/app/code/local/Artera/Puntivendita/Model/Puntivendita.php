<?php

class Artera_Puntivendita_Model_Puntivendita extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('puntivendita/puntivendita');
    }
}