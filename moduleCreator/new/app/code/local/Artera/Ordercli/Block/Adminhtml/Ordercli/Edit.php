<?php

class Artera_Ordercli_Block_Adminhtml_Ordercli_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ordercli';
        $this->_controller = 'adminhtml_ordercli';
        
        $this->_updateButton('save', 'label', Mage::helper('ordercli')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('ordercli')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('ordercli_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'ordercli_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'ordercli_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('ordercli_data') && Mage::registry('ordercli_data')->getId() ) {
            return Mage::helper('ordercli')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('ordercli_data')->getTitle()));
        } else {
            return Mage::helper('ordercli')->__('Add Item');
        }
    }
}