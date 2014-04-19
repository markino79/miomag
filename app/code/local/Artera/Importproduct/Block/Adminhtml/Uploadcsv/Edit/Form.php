<?php

class Artera_Importproduct_Block_Adminhtml_Uploadcsv_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	protected function _prepareForm(){
		$form = new Varien_Data_Form(array(
										'id'=> 'edit_Form' ,
										'name'=> 'editForm' ,
										'action' => $this->getUrl('*/*/save') ,
										'method' => 'post',
										'enctype' => 'multipart/form-data'
										)
		) ;
		$form->setUseContainer(true) ;
		$this->setForm($form) ;
		$fieldset = $form->addFieldset('upfile_form', array('legend'=>Mage::helper('importproduct')->__("Importazione articoli")));

		$fieldset->addField('filecsv', 'file', array(
		    'label'     => Mage::helper('importproduct')->__("Selezione il file per l'upload"),
		    'class'     => 'required-entry',
		    'name'      => 'filecsv' ,
		    'required'  => true
		));
		return parent::_prepareForm() ;
	}
}