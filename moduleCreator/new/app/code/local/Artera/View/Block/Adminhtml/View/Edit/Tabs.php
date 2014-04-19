<?php

class Artera_View_Block_Adminhtml_View_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('view_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('view')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('view')->__('Item Information'),
          'title'     => Mage::helper('view')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('view/adminhtml_view_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}