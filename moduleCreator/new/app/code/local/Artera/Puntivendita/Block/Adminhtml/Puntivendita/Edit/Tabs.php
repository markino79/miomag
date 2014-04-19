<?php

class Artera_Puntivendita_Block_Adminhtml_Puntivendita_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('puntivendita_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('puntivendita')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('puntivendita')->__('Item Information'),
          'title'     => Mage::helper('puntivendita')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('puntivendita/adminhtml_puntivendita_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}