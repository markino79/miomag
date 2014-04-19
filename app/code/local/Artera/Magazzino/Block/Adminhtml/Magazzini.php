<?php
class Artera_Magazzino_Block_Adminhtml_Magazzini extends Mage_Adminhtml_Block_Widget_Grid_Container{
  public function __construct(){
    $this->_controller = 'adminhtml_magazzini';
    $this->_blockGroup = 'magazzino';
    $this->_headerText = Mage::helper('magazzino')->__('Gestione Magazzini');
    $this->_addButtonLabel = Mage::helper('magazzino')->__('Aggiungi magazzino');
    parent::__construct();
  }
}