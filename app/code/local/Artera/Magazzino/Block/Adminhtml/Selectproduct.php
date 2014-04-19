<?php
class Artera_Magazzino_Block_Adminhtml_Selectproduct extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		$this->_controller = 'adminhtml_selectproduct';
		$this->_blockGroup = 'magazzino';
		$this->_headerText = Mage::helper('magazzino')->__('Seleziona prodotto');
		parent::__construct();
		$this->_removeButton('add') ;
	}
}