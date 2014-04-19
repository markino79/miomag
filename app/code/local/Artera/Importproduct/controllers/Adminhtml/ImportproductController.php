<?php
class Artera_Importproduct_Adminhtml_ImportproductController extends Mage_Adminhtml_Controller_action {
	   
	public function importtableAction(){
		$this->loadLayout() 
			->_setActiveMenu('catalog/import/importtable') ;
		$this->_addContent($this->getLayout()->createBlock('importproduct/adminhtml_importproduct')) ;
		$this->renderLayout();
	}
	public function indexAction() {
		$this->loadLayout() 
			->_setActiveMenu('catalog/import/importfilecsv') ;
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->_addContent($this->getLayout()->createBlock('importproduct/adminhtml_uploadcsv_edit')) ;
		$this->renderLayout();
	}
	public function exampleAction(){
		header('Content-Type: application/CSV; charset="UTF-8"');
		header('Content-Disposition: attachment; filename="example.csv"');
		echo "nome|descrizione|descrizione_breve|codice|peso|codice_originale**|prezzo|costo|immagine*|qta_in_stock|categoria \n" ;
		echo "\n\n\n\n" ; 
		echo "* Inserire il nome dell'immagine completo di estensione e posizionare il file nella cartella media/import \n" ;
		echo "  se non viene inserito un nome immagine si tentera' di reperirla da idprint \n" ;
		echo "** Il codice originale e' necessario per reperire le informazioni aggiuntive da idprint la sua assenza non pregiudichera' l'importazione \n" ;
		echo "(in codici esitenti saranno aggiornati)" ;
	}
	public function saveAction(){
		try{
			$uploader = new Varien_File_Uploader('filecsv');
			$uploader->setAllowedExtensions(array('csv')); 
			
			$uploader->setAllowRenameFiles(false);
			$uploader->setFilesDispersion(false);
			$path = Mage::getBaseDir('var') . DS ;
			//$uploader->save($path, $_FILES['fileinputname']['name']);
			$uploader->save($path, 'prodotti.csv');
			$cache = Mage::app()->getCache() ;
			$stato = array("status" => 1 , "message" => array());
			array_push($stato['message'] ,'File csv salvato sul sistema') ;
			$cache->save( serialize($stato), 'importproductdata' ,array('importproductdata') , null) ;
			$ch = curl_init(Mage::getUrl('importproduct/import')) ;
			curl_setopt($ch, CURLOPT_TIMEOUT, 1) ;
			curl_exec($ch);
			curl_close($ch);
			$this->_forward('showprogress');
			//$this->_redirect('showprogress') ;
		}catch(Exception $e){
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('importproduct')->__($e->getMessage()));
            $this->_forward('index');
		}
	}
	public function showprogressAction(){
 		$this->loadLayout()  ;
 		$this->renderLayout();
	}
}
?>