<?php

class Artera_View_Model_Mysql4_View extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the view_id refers to the key field in your database table.
        $this->_init('view/view', 'view_id');
    }
}