<?php

class Artera_Puntivendita_Block_Adminhtml_Puntivendita_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('puntivendita_form', array('legend'=>Mage::helper('puntivendita')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('puntivendita')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('puntivendita')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('puntivendita')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('puntivendita')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('puntivendita')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('puntivendita')->__('Content'),
          'title'     => Mage::helper('puntivendita')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getPuntivenditaData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPuntivenditaData());
          Mage::getSingleton('adminhtml/session')->setPuntivenditaData(null);
      } elseif ( Mage::registry('puntivendita_data') ) {
          $form->setValues(Mage::registry('puntivendita_data')->getData());
      }
      return parent::_prepareForm();
  }
}