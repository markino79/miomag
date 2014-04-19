<?php

class Artera_Puntivendita_Adminhtml_UpfileController extends Mage_Adminhtml_Controller_Action{
	function indexAction(){
		$this->loadlayout()->_setActiveMenu('puntivendita/mkupfile') ;
		$this->_addContent($this->getLayout()->createBlock('puntivendita/adminhtml_upfile_edit')) ;
		$this->renderLayout() ;
	}
	function saveAction(){
		$this->loadlayout() ;
		$uploader = new Varien_File_Uploader('fileinputname');
		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','txt')); // or pdf or anything
		 
		$uploader->setAllowRenameFiles(false);
		$uploader->setFilesDispersion(false);
		$path = Mage::getBaseDir('var') . DS ;
		//$uploader->save($path, $_FILES['fileinputname']['name']);
		$uploader->save($path."uptemp", 'prova');
		$this->renderLayout() ;
	}
} 
