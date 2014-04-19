<?php

class Artera_Ordercli_Block_Adminhtml_Ordercli_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ordercli_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ordercli')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ordercli')->__('Item Information'),
          'title'     => Mage::helper('ordercli')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('ordercli/adminhtml_ordercli_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}