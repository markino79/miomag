<?php

class Artera_Puntivendita_Block_Adminhtml_Puntivendita_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{
	protected function _prepareForm(){
	$form = new Varien_Data_Form() ;
	$this->setForm($form) ;
	$fieldset = $form->addFieldset('puntivendita_form', array('legend'=>Mage::helper('puntivendita')->__('informazioni punit vendita')));

	$fieldset->addField('nome', 'text', array(
	    'label'     => Mage::helper('puntivendita')->__('Nome'),
	    'class'     => 'required-entry',
	    'required'  => true,
	    'name'      => 'nome'
	));
	
	$fieldset->addField('indirizzo', 'text', array(
	    'label'     => Mage::helper('puntivendita')->__('indirizzo'),
	    'class'     => 'required-entry',
	    'required'  => true,
	    'name'      => 'indirizzo'
	));
	
	$fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('puntivendita')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('puntivendita')->__('Attivo'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('puntivendita')->__('Inattivo'),
                ),
            ),
        ));

	if ( Mage::getSingleton('adminhtml/session')->getPuntivenditaData() ){
	    $form->setValues(Mage::getSingleton('adminhtml/session')->getPuntivenditaData());
	    Mage::getSingleton('adminhtml/session')->setPuntivenditaData(null);
	}elseif( Mage::registry('puntivendita_data') ) {
		$form->setValues(Mage::registry('puntivendita_data')->getData());
	}
	return parent::_prepareForm();
	}
}
