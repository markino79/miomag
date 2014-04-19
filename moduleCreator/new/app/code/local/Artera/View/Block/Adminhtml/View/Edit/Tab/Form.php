<?php

class Artera_View_Block_Adminhtml_View_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('view_form', array('legend'=>Mage::helper('view')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('view')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('view')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('view')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('view')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('view')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('view')->__('Content'),
          'title'     => Mage::helper('view')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getViewData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getViewData());
          Mage::getSingleton('adminhtml/session')->setViewData(null);
      } elseif ( Mage::registry('view_data') ) {
          $form->setValues(Mage::registry('view_data')->getData());
      }
      return parent::_prepareForm();
  }
}