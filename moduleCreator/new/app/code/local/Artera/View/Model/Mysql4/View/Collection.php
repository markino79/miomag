<?php

class Artera_View_Model_Mysql4_View_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('view/view');
    }
}