<?php

class Artera_Puntivendita_Block_Adminhtml_Upfile_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	
	protected function _prepareForm(){
		$form = new Varien_Data_Form(array(
										'id'=> 'edit_form' ,
										'action' => $this->getUrl('*/*/save') ,
										'method' => 'post',
										'enctype' => 'multipart/form-data'
										)
		) ;
		$form->setUseContainer(true) ;
		$this->setForm($form) ;
		$fieldset = $form->addFieldset('mkupofile_form', array('legend'=>Mage::helper('puntivendita')->__("Importazione punti vendita")));

		$fieldset->addField('fileinputname', 'file', array(
		    'label'     => Mage::helper('puntivendita')->__("Selezione il file per l'upload"),
		    'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'fileinputname'
		));
		return parent::_prepareForm() ;
	}
}
