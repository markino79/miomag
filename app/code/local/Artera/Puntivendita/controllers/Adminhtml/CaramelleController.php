<?php

class Artera_Puntivendita_Adminhtml_CaramelleController  extends Mage_Adminhtml_Controller_Action{
	protected function _initAction(){
		$this->loadLayout()
		->_setActiveMenu('puntivendita/caramelle') ;
		//->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this ;
	}
	public function indexAction(){
		$this->_initAction() ;
		$this->_addContent($this->getLayout()->createBlock('puntivendita/adminhtml_caramelle')) ;
		$this->renderLayout() ;
	}
}
