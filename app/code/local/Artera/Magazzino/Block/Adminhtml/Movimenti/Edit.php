<?php

class Artera_Magazzino_Block_Adminhtml_Movimenti_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'magazzino';
        $this->_controller = 'adminhtml_movimenti';
        $this->_mode = 'edit';
        
        $this->_updateButton('save', 'label', Mage::helper('magazzino')->__('Salva'));
        $this->_updateButton('delete', 'label', Mage::helper('magazzino')->__('Cancella'));
        $this->_removeButton('reset') ;
       
    }
    public function getHeaderText(){
        $a = Mage::registry('movimenti_data') ;
        if ($a['tipo'] == 'C'){
            return Mage::helper('magazzino')->__("inserimento CARICO");
        } else {
            return Mage::helper('magazzino')->__('inserimento SCARICO');
        }
    }
}