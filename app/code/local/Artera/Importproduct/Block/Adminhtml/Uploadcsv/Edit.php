<?php

class Artera_Importproduct_Block_Adminhtml_Uploadcsv_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	public function __construct(){
		parent::__construct() ;
		$this->_blockGroup = 'importproduct' ;
		$this->_controller = 'adminhtml_uploadcsv' ;

		$this->_updateButton('save','label',Mage::helper('importproduct')->__('Save')) ;
		//$this->_updateButton('delete','label',Mage::helper('puntivendita')->__('Cancella :(')) ;
		$this->_removeButton('delete') ;
		//$this->_removeButton('reset') ;
		$this->_removeButton('back') ;
	}
	public function getHeaderText(){
	    return Mage::helper('importproduct')->__("Upload CSV prodotti");
    }
}
