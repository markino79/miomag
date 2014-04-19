<?php

class Artera_Puntivendita_Block_Adminhtml_Upfile_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	public function __construct(){
		parent::__construct() ;
		$this->_blockGroup = 'puntivendita' ;
		$this->_controller = 'adminhtml_upfile' ;

		$this->_updateButton('save','label',Mage::helper('puntivendita')->__('Salva ;)')) ;
		//$this->_updateButton('delete','label',Mage::helper('puntivendita')->__('Cancella :(')) ;
		$this->_removeButton('delete') ;
		$this->_removeButton('reset') ;
		$this->_removeButton('back') ;
	}
	public function getHeaderText(){
	    return Mage::helper('puntivendita')->__("Upload file dei punti vendita");
    }
} 
