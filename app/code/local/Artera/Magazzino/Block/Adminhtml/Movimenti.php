<?php
class Artera_Magazzino_Block_Adminhtml_Movimenti extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		$this->_controller = 'adminhtml_movimenti';
		$this->_blockGroup = 'magazzino';
		$this->_headerText = Mage::helper('magazzino')->__('Movimenti');
		parent::__construct();
		$this->_removeButton('add') ;
	}
}