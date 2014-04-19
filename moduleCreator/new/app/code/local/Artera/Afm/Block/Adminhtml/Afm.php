<?php
class Artera_Afm_Block_Adminhtml_Afm extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_afm';
    $this->_blockGroup = 'afm';
    $this->_headerText = Mage::helper('afm')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('afm')->__('Add Item');
    parent::__construct();
  }
}