<?php

class Artera_Importproduct_ImportController extends Mage_Core_Controller_Front_Action{
	public function indexAction(){
		
		$this->_clearWorkFile() ;
		$this->_feedWorkFile() ;
		$this->_inCatalog() ;
		$this->_inCache(0,"Finito") ;
		
 	}
 	protected function _clearWorkFile(){
		$this->_inCache(1,"Pulisco il file di lavoro.") ;
		$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
		$db->query('delete from importproduct') ;
 	}
 	protected function _feedWorkFile(){
		$this->_inCache(1,"Importo il csv nel file di lavoro.") ;
		$sFile = Mage::getBaseDir('var') . DS . 'prodotti.csv' ;
		$aFile = file($sFile) ; 
		$lines = count($aFile) ;
		$line_number = 0 ;
		$this->_inCache(1,"$lines righe nel file csv da importare nel file di lavoro.") ;
		foreach($aFile as $line){
			$field = explode('|',$line) ;
			// almeno il codice e il nome devono essere impostati altrimenti non scrivo nemeno il record
				$importproduct = Mage::getModel('importproduct/importproduct') ;
				if (isset($field[0]))
					$importproduct->setName($field[0]) ;
				if (isset($field[1]))
					$importproduct->setDescription($field[1]) ;
				if (isset($field[2]))
					$importproduct->setDescriptionShort($field[2]) ;
				if (isset($field[3]))
					$importproduct->setCode($field[3]) ;
				if (isset($field[4]))
					$importproduct->setWeight($field[4]) ;
				if (isset($field[5]))
					$importproduct->setCodeOriginal($field[5]) ;
				if (isset($field[6]))
					$importproduct->setPrice($field[6]) ;
				if (isset($field[7]))
					$importproduct->setCost($field[7]) ;
				if (isset($field[8]))
					$importproduct->setImage($field[8]) ;
				if (isset($field[9]))
					$importproduct->setStockQty($field[9]) ;
				if (isset($field[10]))
					$importproduct->setCategoryId($field[10]) ;
				$importproduct->save() ;
				$line_number++ ;
		}
		$this->_inCache(1,"$line_number righe importate.") ;
 	}
 	protected function _inCatalog(){
		$inseriti = 0 ;
		$aggiornati = 0 ;
		$inErrore = 0 ;
		$modo = "" ;
		$importproducts = Mage::getModel('importproduct/importproduct')->getCollection() ;
		$importproducts->addFieldToFilter('is_processed',array(
			'eq' => 0
			)) ;
		$importproducts->addFieldToFilter('status',array(
			'eq' => 0
			)) ;
		$totale = $importproducts->count() ;
		$this->_inCache(1,"inseriti $inseriti, aggiornati $aggiornati, errati $inErrore, di $totale "  ) ;
		foreach($importproducts as $importproduct){
			$import = $importproduct->getData() ;
			if (empty($import['code'])){
				$importproduct->setMessage("Il codice è obbligatorio") ;
				$importproduct->setStatus(2) ;
				$importproduct->save() ;
				$inErrore++ ;
				continue ;
			}
			$productModel = Mage::getModel('catalog/product');
			$productId = $productModel->getIdBySku($importproduct->getCode());
			if (empty($productId)) {
				$modo = "inserimento" ;
				// se inserminto il nome è vuoto non lo inserisco
				$name = trim($importproduct->getName()) ;
				if (empty($name)){
					$importproduct->setMessage("In caso d'inserimento il nome è obbligatorio") ;
					$importproduct->setStatus(2) ;
					$importproduct->save() ;
					$inErrore++ ;
					$this->_updateLastMsg("inseriti $inseriti, aggiornati $aggiornati, errati $inErrore, di $totale "  ) ;
					continue ;
				}
				$productModel->setAttributeSetId(9);
				$productModel->setTypeId('simple');
				$productModel->setStoreId(Mage::app()->getStore()->getStoreId());
                //$productModel->setStore(1);
				$productModel->setSku($importproduct->getCode());
				$productModel->setVisibility(4);
				$productModel->setTaxClassId(2); //2 taxable goods
				$productModel->setStatus(1); // 1 abilitato 2 disabilitato
			}else{
				$modo = "modifica" ;
				$productModel->load($productId);
				echo "<pre>" ;
				echo print_r($productModel->getWebsiteIds());
				echo "</pre>" ;
			}
			
			if (!empty($import['name']))
				$productModel->setName($importproduct->getName());
			if (!empty($import['description']))
				$productModel->setDescription($importproduct->getDescription());
			if (!empty($import['description_short']))
				$productModel->setShortDescription($importproduct->getDescriptionShort());
			if (!empty($import['weight']))
				$productModel->setWeight($importproduct->getWeight());
			if (!empty($import['code_original'])){
				$productModel->setCodiceOriginale($importproduct->getCodeOriginal());
				$idprint = Mage::getModel('idprint/data')->getItemInfomation($import['code_original']);
				if (!empty($idprint) && !empty($idprint['consumable'])){
					$infoItem = $idprint['consumable'][key($idprint['consumable'])] ;
					$descrizione = $productModel->getDescription() ;
					if (empty($descrizione)){
						$productModel->setDescription($infoItem['description']) ;
					}else{
						$productModel->setIdprintDescription($infoItem['description']) ;
					}
					$productModel->setResaPagine($infoItem['attribute5_value']);
				}
			}
			if (!empty($import['price']))
				$productModel->setPrice($importproduct->getPrice());
			if (!empty($import['cost']))
				$productModel->setCost($importproduct->getCost());
			
			
			
			if(!empty($idprint) && isset($infoItem['compatible_printers'])){
				$productModel->setCompatibilita(str_replace(",","\n",$infoItem['compatible_printers'])) ;
			}
			if (!empty($import['stock_qty'])){
				$stockData = array();
				$stockData['qty'] = $importproduct->getStockQty();
				$stockData['is_in_stock'] = 1;
				$stockData['manage_stock'] = 1;
				$stockData['max_sale_qty'] = 10000;
				$stockData['min_sale_qty'] = 0;
				$productModel->setStockData($stockData);
			}
			if (!empty($import['category_id'])){
				$categorie = $importproduct->getCategoryId() ;
				$categorie = str_replace(array("\n","\t","\r","\r\n"),"",$categorie) ;
				//$a_categorie = explode(',',$categorie) ;
				if ($modo == "modifica"){
					$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
					$db->query("delete from catalog_category_product where product_id = $productId") ;
					$db->query("delete from catalog_category_product_index where product_id = $productId") ;
				}
				$productModel->setCategoryIds($categorie);
			}
			if (empty($import['image']) && !empty($idprint) && isset($infoItem['image_url'])){
					//echo $infoItem['image_url'] ;
					$aImg = explode('/',$infoItem['image_url']) ;
					$imgName = end($aImg) ;
					$ch = curl_init($infoItem['image_url']);
					$imageFile = Mage::getBaseDir('media') . DS ."import" .DS . $imgName ;
					$fp = fopen($imageFile, "w");
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					$this->_setImg($productModel , $imgName) ;
			}
			if (!empty($import['image'])){
				$this->_setImg($productModel , $import['image']) ;
			}
			$productModel->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId())) ;	
			try{
				//$productModel->save() ;
				$productModel->saveRow() ;
				if ($modo == "inserimento"){
					$inseriti++ ;
				}else{
					$aggiornati++ ;
				}
				$importproduct->setIsProcessed(1) ;
				//$importproduct->save() ;
				$this->_updateLastMsg("inseriti $inseriti, aggiornati $aggiornati, errati $inErrore, di $totale "  ) ;
			
				/** provo a settare l0immagine dopo il primo salvataggio */
				
			}catch(Exception $e){
				$importproduct->setMessage($modo . " " . $e->getMessage()) ;
				$importproduct->setStatus(2) ;
				$importproduct->save() ;
				$inErrore++ ;
				$this->_updateLastMsg("inseriti $inseriti, aggiornati $aggiornati, errati $inErrore, di $totale "  ) ;
			}
		}
 	}
 	protected function _inCache($status , $message){
		$cache = Mage::app()->getCache()  ; 
		$stato = unserialize($cache->load('importproductdata')) ;
		$stato['status'] = $status ;
		array_push($stato['message'] ,$message) ;
		$cache->save( serialize($stato), 'importproductdata' ,array('importproductdata') , null) ;
 	}
 	protected function _updateLastMsg($message){
		$cache = Mage::app()->getCache()  ; 
		$stato = unserialize($cache->load('importproductdata')) ;
		end($stato['message']) ;
		$lastkey = key($stato['message']) ;
		$stato['message'][$lastkey] = $message ;
		$cache->save( serialize($stato), 'importproductdata' ,array('importproductdata') , null) ;
 	}
 	protected function _setImg($productModel , $imgName){
		$imageFile = Mage::getBaseDir('media') . DS ."import" .DS . $imgName ;
		if (is_file($imageFile)) {
			/* cancello eventuali immagini già presenti*/
			$attributes = $productModel->getTypeInstance()->getSetAttributes();
			if (isset($attributes['media_gallery'])) {
				$gallery = $attributes['media_gallery'];
				$galleryData = $productModel->getMediaGallery();
				foreach($galleryData['images'] as $image){
					if ($gallery->getBackend()->getImage($productModel, $image['file'])) {
						$gallery->getBackend()->removeImage($productModel, $image['file']);
					}
				}
			}
			/* inserisco la mnuova immagine */
			$visibility = array (
			    'thumbnail',
			    'small_image',
			    'image'
			);
			//$productModel->setData($atttribute, $value);
			$productModel->addImageToMediaGallery($imageFile, $visibility, false, false);
			//$productModel->save() ;
		}
 	}
} 
