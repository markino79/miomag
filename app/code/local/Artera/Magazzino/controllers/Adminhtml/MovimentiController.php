<?php
class Artera_Magazzino_Adminhtml_MovimentiController extends Mage_Adminhtml_Controller_action{
	protected function _initAction() {
		// nell'init setto il menu (il path di com'è definito nel config.xml) attivo in caso di scollegamento e ricollegamento 
		// ritornerà lì
		$this->loadLayout()
		->_setActiveMenu('magazzino/consultazioni/cons_movimenti');
		return $this;
	}
	public function indexAction() {
		$this->_initAction() ;
		$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_movimenti')) ;
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
			$this->_setActiveMenu('magazzino/consultazioni/cons_movimenti');
	
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	
			$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_movimenti_edit'));
	
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magazzino')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		Mage::register('movimenti_data',  $this->getRequest()->getParams());
		
		$this->loadLayout();
		$this->_setActiveMenu('magazzino/consultazioni/cons_movimenti');
		
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		
		$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_movimenti_edit'));
		
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getPost() ;
		
		$product = Mage::getModel('catalog/product') ;
		$p_id = $product->getIdBySku($data['sku']) ;
		$product->load($p_id) ;
		
		if ($product->getId()){
			try {
				$movimento= Mage::getModel('magazzino/movimenti');
				if ($data['tipo'] == 'C'){
					$movimento->carico($product->getId(), $data['id_magazzino'] ,$data['qta'],$data['note']) ;
				}else{
					$movimento->scarico($product->getId(), $data['id_magazzino'] ,$data['qta'],$data['note']) ;
				}	
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('magazzino')->__('Movimento salvato'));
			$data = array('tipo' => $data['tipo'] ) ;
		}else{
			Mage::getSingleton('adminhtml/session')->addError("codice {$data['sku']} non trovato!");
		}
		$this->_redirect('*/*/new',$data);
		return;
	}
	public function searchproductAction(){
		$dati = $this->getRequest()->getParams() ;
		unset($dati['key']) ;
		Mage::register('movimenti_data',$dati);
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->_addContent($this->getLayout()->createBlock('magazzino/adminhtml_selectproduct'));
		$this->renderLayout();
	}
	/*
	 * Azione che visualizza la Grid
	 */
	public function showqtyAction(){
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		// creo il blokko GridContainer che conterrà la grid
		// dove mi è possibile mettere un titolo e i pulsanti che mi servono
		$gridContainer = $this->getLayout()->createBlock('magazzino/adminhtml_showqty') ;
		// se voglio impostare la Collection dlla grid nel controller lo faccio qui
      	$grid = $gridContainer->getChild('grid') ;
		//$movimenti = Mage::getModel("magazzino/movimenti");
      	//$grid->setCollection($movimenti->getMovimentiAggregati());
		
		$this->_addContent($gridContainer);
		$this->renderLayout();
	}
	
	public function exportMovimentiCsvAction(){
		header('Content-Type: application/text; charset="UTF-8"');
		header('Content-Disposition: attachment; filename="movimenti.csv"');
		echo  $this->getLayout()->createBlock('magazzino/adminhtml_movimenti_grid')
		->getCsv();
	}

	public function exportMovimentiXmlAction(){
		header('Content-Type: application/text; charset="UTF-8"');
		header('Content-Disposition: attachment; filename="movimenti.xml"');
		echo $this->getLayout()->createBlock('magazzino/adminhtml_movimenti_grid')
		->getXml();
	}
	public function exportQtaMagazzinoCsvAction(){
		header('Content-Type: application/text; charset="UTF-8"');
		header('Content-Disposition: attachment; filename="qta_magazzino.csv"');
		echo  $this->getLayout()->createBlock('magazzino/adminhtml_Showqty_Grid')
		->getCsv();
	}
	
	public function exportQtaMagazzinoMovimentiXmlAction(){
		header('Content-Type: application/text; charset="UTF-8"');
		header('Content-Disposition: attachment; filename="qta_magazzino.xml"');
		echo $this->getLayout()->createBlock('magazzino/adminhtml_Showqty_Grid')
		->getXml();
	}
}