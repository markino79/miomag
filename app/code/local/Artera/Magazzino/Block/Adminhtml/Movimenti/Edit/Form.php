<?php

class Artera_Magazzino_Block_Adminhtml_Movimenti_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm(){
	  
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );
      $form->setUseContainer(true);
      $this->setForm($form);
      
	  $fieldset = $form->addFieldset('movimenti_form', array('legend'=>Mage::helper('magazzino')->__(' ')));

	  $fieldset->addField('tipo', 'hidden', array(
	  		'label'     => Mage::helper('magazzino')->__('tipo'),
	  		'class'     => 'required-entry',
	  		'name'      => 'tipo',
	  ));
	  $fieldset->addField('sku', 'text', array(
	  		'label'     => Mage::helper('magazzino')->__('Codice prodotto'),
	  		'class'     => 'required-entry',
	  		'required'  => true,
	  		'name'      => 'sku',
	  		'note'		=> "<a href='{$this->getUrlsearch()}'>trova codice prodotto</a>" ,
	  ));
      $fieldset->addField('qta', 'text', array(
          'label'     => Mage::helper('magazzino')->__('quantità'),
          'class'     => 'required-entry validate-greater-than-zero input-text required-entry validation-failed',
          'required'  => true,
          'name'      => 'qta',
      ));
      $fieldset->addField('id_magazzino', 'select', array(
      		'label'     => Mage::helper('magazzino')->__('Magazzino'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'id_magazzino',
      		'values'	=> Mage::getModel("magazzino/magazzini")->getListForSelectField() ,
      ));
      $fieldset->addField('note', 'textarea', array(
      		'label'     => Mage::helper('magazzino')->__('note'),
      		'name'      => 'note',
      ));
      if (Mage::registry('movimenti_data'))
      	$form->setValues(Mage::registry('movimenti_data')) ;
      
      return parent::_prepareForm();
  }
  private function getUrlsearch(){
  	$dati = Mage::registry('movimenti_data') ;
  	unset($dati['form_key']) ;
  	unset($dati['key']) ;
  	return Mage::helper("adminhtml")->getUrl("magazzino/adminhtml_movimenti/searchproduct",$dati) ;
  }
}