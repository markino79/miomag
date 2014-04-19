<?php
class Artera_View_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_view';
    $this->_blockGroup = 'view';
    $this->_headerText = Mage::helper('view')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('view')->__('Add Item');
    parent::__construct();
  }
}