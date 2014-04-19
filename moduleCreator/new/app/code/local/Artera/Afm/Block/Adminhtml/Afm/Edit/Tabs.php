<?php

class Artera_Afm_Block_Adminhtml_Afm_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('afm_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('afm')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('afm')->__('Item Information'),
          'title'     => Mage::helper('afm')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('afm/adminhtml_afm_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}