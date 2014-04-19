<?php
class Artera_Ordercli_Block_Adminhtml_Ordercli extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_ordercli';
    $this->_blockGroup = 'ordercli';
    $this->_headerText = Mage::helper('ordercli')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('ordercli')->__('Add Item');
    parent::__construct();
  }
}