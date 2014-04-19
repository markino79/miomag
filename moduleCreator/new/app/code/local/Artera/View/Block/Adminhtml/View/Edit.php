<?php

class Artera_View_Block_Adminhtml_View_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'view';
        $this->_controller = 'adminhtml_view';
        
        $this->_updateButton('save', 'label', Mage::helper('view')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('view')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('view_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'view_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'view_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('view_data') && Mage::registry('view_data')->getId() ) {
            return Mage::helper('view')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('view_data')->getTitle()));
        } else {
            return Mage::helper('view')->__('Add Item');
        }
    }
}