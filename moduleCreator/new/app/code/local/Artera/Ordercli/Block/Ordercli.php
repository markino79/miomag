<?php
class Artera_Ordercli_Block_Ordercli extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOrdercli()     
     { 
        if (!$this->hasData('ordercli')) {
            $this->setData('ordercli', Mage::registry('ordercli'));
        }
        return $this->getData('ordercli');
        
    }
}