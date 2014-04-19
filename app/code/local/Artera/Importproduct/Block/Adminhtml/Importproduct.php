<?php

Class Artera_Importproduct_Block_Adminhtml_Importproduct extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		$this->_controller = 'adminhtml_importproduct' ;
		$this->_blockGroup = 'importproduct' ;
		$this->_headerText = Mage::helper('importproduct')->__('Gestione errori') ;
		parent::__construct() ;
		$this->_removeButton('add') ;
	}
}
