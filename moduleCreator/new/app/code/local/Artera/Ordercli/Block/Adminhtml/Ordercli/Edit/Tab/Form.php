<?php

class Artera_Ordercli_Block_Adminhtml_Ordercli_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ordercli_form', array('legend'=>Mage::helper('ordercli')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('ordercli')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('ordercli')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('ordercli')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('ordercli')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('ordercli')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('ordercli')->__('Content'),
          'title'     => Mage::helper('ordercli')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getOrdercliData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOrdercliData());
          Mage::getSingleton('adminhtml/session')->setOrdercliData(null);
      } elseif ( Mage::registry('ordercli_data') ) {
          $form->setValues(Mage::registry('ordercli_data')->getData());
      }
      return parent::_prepareForm();
  }
}