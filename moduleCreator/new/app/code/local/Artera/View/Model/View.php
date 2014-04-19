<?php

class Artera_View_Model_View extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('view/view');
    }
}