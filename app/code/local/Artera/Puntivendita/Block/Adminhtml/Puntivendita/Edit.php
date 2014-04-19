<?php
class Artera_Puntivendita_Block_Adminhtml_Puntivendita_Edit extends Mage_Adminhtml_block_Widget_Form_Container{
	public function __construct(){
		parent::__construct() ;
		$this->objectId = 'id' ;
		$this->_blockGroup = 'puntivendita' ;
		$this->_controller = 'adminhtml_puntivendita' ;

		$this->_updateButton('save','label',Mage::helper('puntivendita')->__('Salva ;)')) ;
		$this->_updateButton('delete','label',Mage::helper('puntivendita')->__('Cancella :(')) ;
		//$this->_removeButton('delete') ;
		//$this->_removeButton('reset') ;
	}
	public function getHeaderText()
    {
        if( Mage::registry('puntivendita_data') && Mage::registry('puntivendita_data')->getId() ) {
            return Mage::helper('puntivendita')->__("Modifica '%s'", $this->htmlEscape(Mage::registry('puntivendita_data')->getNome()));
        } else {
            return Mage::helper('puntivendita')->__('Aggiungi elemento');
        }
    }
}
