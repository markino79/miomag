<?php

class Artera_Afm_Block_Adminhtml_Afm_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'afm';
        $this->_controller = 'adminhtml_afm';
        
        $this->_updateButton('save', 'label', Mage::helper('afm')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('afm')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('afm_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'afm_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'afm_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('afm_data') && Mage::registry('afm_data')->getId() ) {
            return Mage::helper('afm')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('afm_data')->getTitle()));
        } else {
            return Mage::helper('afm')->__('Add Item');
        }
    }
}