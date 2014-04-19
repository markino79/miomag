<?php
class Artera_Puntivendita_Block_Puntivendita extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPuntivendita()     
     { 
        if (!$this->hasData('puntivendita')) {
            $this->setData('puntivendita', Mage::registry('puntivendita'));
        }
        return $this->getData('puntivendita');
        
    }
}