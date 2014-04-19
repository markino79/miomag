<?php

class Artera_Magazzino_Block_Adminhtml_Magazzini_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magazzino';
        $this->_controller = 'adminhtml_magazzini';
        
        $this->_updateButton('save', 'label', Mage::helper('magazzino')->__('Salva'));
        $this->_updateButton('delete', 'label', Mage::helper('magazzino')->__('Cancella'));
        $this->_removeButton('reset') ;
       
    }
    public function getHeaderText(){
        if( Mage::registry('magazzini_data') && Mage::registry('magazzini_data')->getId() ) {
            return Mage::helper('magazzino')->__("Modifica Magazzino");
        } else {
            return Mage::helper('magazzino')->__('Nuovo magazzino');
        }
    }
}