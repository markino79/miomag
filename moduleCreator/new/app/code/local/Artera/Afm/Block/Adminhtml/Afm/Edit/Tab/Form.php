<?php

class Artera_Afm_Block_Adminhtml_Afm_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('afm_form', array('legend'=>Mage::helper('afm')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('afm')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('afm')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('afm')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('afm')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('afm')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('afm')->__('Content'),
          'title'     => Mage::helper('afm')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getAfmData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAfmData());
          Mage::getSingleton('adminhtml/session')->setAfmData(null);
      } elseif ( Mage::registry('afm_data') ) {
          $form->setValues(Mage::registry('afm_data')->getData());
      }
      return parent::_prepareForm();
  }
}