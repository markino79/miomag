<?php

class Artera_Puntivendita_Adminhtml_PuntivenditaController extends Mage_Adminhtml_Controller_Action{
	protected function _initAction(){
		$this->loadLayout()
		->_setActiveMenu('puntivendita/items') ;
		//->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this ;
	}
	public function indexAction(){
		$this->_initAction() ;
		$this->_addContent($this->getLayout()->createBlock('puntivendita/adminhtml_puntivendita')) ;
		$this->renderLayout() ;
	}
	public function editAction(){
		$puntivenditaId 	= $this->getRequest()->getParam('id') ;
		$puntivenditaModel	= Mage::getModel('puntivendita/puntivendita')->load($puntivenditaId) ;
		if ($puntivenditaModel->getId() || $puntivenditaId == 0){
			Mage::register('puntivendita_data',$puntivenditaModel) ;
			$this->loadLayout() ;
			$this->_setActiveMenu('puntivendita/items') ;
			
			/* qui l'esempio moterebbe l' addBreadcrumb che però io non vedo ... */

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true) ;
			$this->_addContent($this->getLayout()->createBlock('puntivendita/adminhtml_puntivendita_edit')) ;
			$this->_addLeft($this->getLayout()->createBlock('puntivendita/adminhtml_puntivendita_edit_tabs'));
               
            $this->renderLayout();
		}else{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('puntivendita')->__('Item does not exist'));
            $this->_redirect('*/*/');
		}
	}
	public function newAction()
    {
        $this->_forward('edit');
    }
}
