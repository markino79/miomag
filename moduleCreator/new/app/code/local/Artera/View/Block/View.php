<?php
class Artera_View_Block_View extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getView()     
     { 
        if (!$this->hasData('view')) {
            $this->setData('view', Mage::registry('view'));
        }
        return $this->getData('view');
        
    }
}