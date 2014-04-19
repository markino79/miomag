<?php

class Artera_Magazzino_Block_Adminhtml_Magazzini_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );
      $form->setUseContainer(true);
      $this->setForm($form);
      
	  $fieldset = $form->addFieldset('magazzino_form', array('legend'=>Mage::helper('magazzino')->__('magazzino')));
     
      $fieldset->addField('nome', 'text', array(
          'label'     => Mage::helper('magazzino')->__('Nome magazzino'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'nome',
      ));
      if (Mage::registry('magazzini_data'))
      	$form->setValues(Mage::registry('magazzini_data')->getData()) ;
      
      return parent::_prepareForm();
  }
}