<?php
class Artera_Afm_Block_Afm extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAfm()     
     { 
        if (!$this->hasData('afm')) {
            $this->setData('afm', Mage::registry('afm'));
        }
        return $this->getData('afm');
        
    }
}