<?php
class Artera_Magazzino_Adminhtml_MagazziniController extends Mage_Adminhtml_Controller_action{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('magazzino/ges_magazzini')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Gestione Magazzini'), Mage::helper('adminhtml')->__('Gestione Magazzini'));
		
		return $this;
	}   
	
	public function indexAction() {
		$this->_initAction() ;
		$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_magazzini')) ;
		$this->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('magazzino/magazzini')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('magazzini_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('magazzino/ges_magazzini');

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_magazzini_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magazzino')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
				
			$model = Mage::getModel('magazzino/magazzini');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));
				
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
					->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
	
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magazzino')->__('Magazzino salvato'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
	
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magazzino')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('magazzino/magazzini');
					
				$model->setId($this->getRequest()->getParam('id'))
				->delete();
	
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Magazzino eliminato'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
}
