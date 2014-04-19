<?php
require_once(Mage::getBaseDir('lib') . DS . 'Excel/reader.php') ;

class Artera_Spicer_Helper_Data extends Mage_Core_Helper_Abstract{
	public function excelListinoToWorkFile($file){
		
	}
	public function excelCatalogoToWorkFile($file){
		
		ini_set("memory_limit","256M"); 
		ini_set("max_execution_time","0"); 
		
		$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
		$db->query('delete from spicercatalogo') ;
		unset($db) ;
		
		$data = new Spreadsheet_Excel_Reader($file);
		$data->setOutputEncoding('UTF-8');
		$data->read($file);
		
		$count = 0 ;
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
			$count++ ;
			echo $count . "\n" ;
			mb_detect_order("UTF-8,ISO-8859-1") ;
			
			$spicercatalog = Mage::getModel("spicer/spicercatalogo") ;
			$spicercatalog->setModificato("".$data->sheets[0]['cells'][$i][1]."") ;
			$spicercatalog->setCodiceSpicer("".$data->sheets[0]['cells'][$i][2]."") ;
			$spicercatalog->setRiferimentoOriginale("".$data->sheets[0]['cells'][$i][3]."") ;
			$spicercatalog->setNuovo("".$data->sheets[0]['cells'][$i][4]."") ;
			$spicercatalog->setStampaLogoNovita("".$data->sheets[0]['cells'][$i][5]."") ;
			$spicercatalog->setPagCatStandard("".$data->sheets[0]['cells'][$i][6]."") ;
			$spicercatalog->setLetCatStandard("".$data->sheets[0]['cells'][$i][7]."") ;
			$spicercatalog->setCodiceCategoria("".$data->sheets[0]['cells'][$i][8]."");
			
			$nomeCategoria = $data->sheets[0]['cells'][$i][9] ;
			if (mb_detect_encoding($nomeCategoria)!='UTF-8'){
				$spicercatalog->setNomeCategoria(utf8_encode($nomeCategoria)) ;
			}else{
				$spicercatalog->setNomeCategoria($nomeCategoria) ;
			}
			
			$spicercatalog->setCodiceGruppo("".$data->sheets[0]['cells'][$i][10]."") ;
			
			$nomeGruppo = $data->sheets[0]['cells'][$i][11] ;
			if (mb_detect_encoding($nomeGruppo)!='UTF-8'){
				$spicercatalog->setNomeGruppo(utf8_encode($nomeGruppo)) ;
			}else{
				$spicercatalog->setNomeGruppo($nomeGruppo) ;
			}
			
			$spicercatalog->setCodiceSottogruppo("".$data->sheets[0]['cells'][$i][12]."") ;
			$spicercatalog->setNomeSottogruppo("".$data->sheets[0]['cells'][$i][13]."") ;
			$spicercatalog->setCodiceBrand("".$data->sheets[0]['cells'][$i][14]."") ;
			
			$nomeBrand = $data->sheets[0]['cells'][$i][15] ;
			if (mb_detect_encoding($nomeBrand)!='UTF-8'){
				$spicercatalog->setNomeBrand(utf8_encode($nomeBrand)) ;
			}else{
				$spicercatalog->setNomeBrand($nomeBrand) ;
			}
			
			$spicercatalog->setIdLoghi("".$data->sheets[0]['cells'][$i][16]."") ;
			$spicercatalog->setCodiceProdotto("".$data->sheets[0]['cells'][$i][17]."") ;
			
			
			$nomeProdotto = $data->sheets[0]['cells'][$i][18] ;
			if (mb_detect_encoding($nomeProdotto)!='UTF-8'){
				$spicercatalog->setNomeProdotto(utf8_encode($nomeProdotto)) ;
			}else{
				$spicercatalog->setNomeProdotto($nomeProdotto) ;
			}
			
			$descrizioneBreve = $data->sheets[0]['cells'][$i][19] ;
			if (mb_detect_encoding($descrizioneBreve)!='UTF-8'){
				$spicercatalog->setDescizioneBreve(utf8_encode($descrizioneBreve)) ;
			}else{
				$spicercatalog->setDescizioneBreve($descrizioneBreve) ;
			}
			$descrizioneEstesa = $data->sheets[0]['cells'][$i][20] ;
			if (mb_detect_encoding($descrizioneEstesa)!='UTF-8'){
				$spicercatalog->setDescizioneEstesa(utf8_encode($descrizioneEstesa)) ;
			}else{
				$spicercatalog->setDescizioneEstesa($descrizioneEstesa) ;
			}
			$spicercatalog->setUnitaVendita("".$data->sheets[0]['cells'][$i][21]."") ;
			$spicercatalog->setQtaXUnita("".$data->sheets[0]['cells'][$i][22]."") ;
			$spicercatalog->setImmagine("".$data->sheets[0]['cells'][$i][23]."") ;
			$spicercatalog->setPrezzoAlPubblico("".$data->sheets[0]['cells'][$i][24]."") ;
			// µ
			$elencoAttributi = $data->sheets[0]['cells'][$i][25] ; 
			if (mb_detect_encoding($elencoAttributi)!='UTF-8'){
				$spicercatalog->setElencoAttributi(utf8_encode($elencoAttributi)) ;
			}else{
				$spicercatalog->setElencoAttributi($elencoAttributi) ;
			}
			
			$spicercatalog->save() ;
			unset($spicercatalog) ;
		}
		unset($data) ;
	}
	
	public function inCatalog() {
		ini_set("memory_limit","256M"); 
		ini_set("max_execution_time","0"); 
		
// 		for ($index = 1; $index <= 9; $index++) {  
// 			$process = Mage::getModel('index/process')->load($index);  
// 			$process->setMode(Mage_Index_Model_Process::MODE_MANUAL);
// 			$process->save() ;
// 			$process->clearInstance() ;
// 			unset($process) ;
// 		}
		
		
		$spicercatalog = Mage::getModel("spicer/spicercatalogo")->getCollection() ;
		
		$spicercatalog->addFieldToSelect("spicercatalogo_id") ;
		$spicercatalog->addFieldToSelect("modificato") ;
		$spicercatalog->addFieldToSelect("codice_spicer") ;
		$spicercatalog->addFieldToSelect("riferimento_originale") ;
		$spicercatalog->addFieldToSelect("codice_gruppo") ;
		$spicercatalog->addFieldToSelect("nome_gruppo") ;
		$spicercatalog->addFieldToSelect("nome_brand") ;
		$spicercatalog->addFieldToSelect("descizione_breve") ;
		$spicercatalog->addFieldToSelect("descizione_estesa") ;
		$spicercatalog->addFieldToSelect("immagine") ;
		$spicercatalog->addFieldToSelect("elenco_attributi") ;
		$spicercatalog->addFieldToSelect("status") ;
		$spicercatalog->addFieldToFilter('status',0) ;
		
		$count = 0 ;
		foreach($spicercatalog as $row){
			$count++ ;
			echo $count . " " .$row->getCodiceSpicer() .  " memoria :" . memory_get_usage() ."\n" ;
			//$this->_writeProduct($row) ;
			$this->appOnlyShortdes($row) ;
			$row->setStatus(1) ;
			$row->save() ;
			$row->clearInstance() ;
			unset($row) ;
 			if ($count > 99)
				break ;
		}
		unset($spicercatalog) ;
// 		for ($index = 1; $index <= 9; $index++) {  
// 			$process = Mage::getModel('index/process')->load($index);  
// 			$process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME);
// 			$process->save() ;
// 			$process->reindexAll() ;
// 			$process->clearInstance() ;
// 			unset($process) ;
// 		}
	}
	private function appOnlyShortdes($spicerRow){
		$productModel = Mage::getModel("catalog/product") ;
		$productId = $productModel->getIdBySku($spicerRow->getCodiceSpicer()) ;
		$productModel->load($productId) ;
		if ($productModel->getSku()){
			//Short Description
			$productModel->setShortDescription($spicerRow->getElencoAttributi());
			$productModel->save() ;
		}
		$productModel->clearInstance();
		unset($productModel) ;
	} 
	private function _writeProduct($spicerRow){
		
		$old_sku = "S". $spicerRow->getCodiceSpicer() ;
		$productModel = Mage::getModel("catalog/product") ;
		$productId = $productModel->getIdBySku($old_sku) ;
		if (empty($productId)){
			$productId = $productModel->getIdBySku($spicerRow->getCodiceSpicer()) ;
		}
		if (empty($productId)){
			echo "trovato" ;
			//Attribute set
			$productModel->setAttributeSetId('4');
			//Product type
			$productModel->setTypeId('simple');
			//Website
			$productModel->setWebsiteIds(array('1'));
			//Weight
			$productModel->setWeight(0);
			//Status
			$productModel->setStatus(2); // 1 abilitato 2 disabilitato
			//Visibility
			$productModel->setVisibility(4); 
			
		}else{
			$productModel->load($productId) ;
		}
		//Sku
		$productModel->setSku($spicerRow->getCodiceSpicer() );
		//Tax
		$productModel->setTaxClassId(7); //2 taxable goods
		//Name
		$productModel->setName($spicerRow->getDescizioneBreve());//
		//Description
		$productModel->setDescription($spicerRow->getDescizioneEstesa());
		//Short Description
		$productModel->setShortDescription($spicerRow->getElencoAttributi());
		//Price
		$productModel->setPrice(0);
		//Cost
		$productModel->setCost(0);
		//Weight
		$productModel->setWeight(0);
		//Visibility
		$productModel->setVisibility(4);
		//Category
		$productModel->setCategoryIds($this->getCategory($spicerRow->getCodiceGruppo() , $spicerRow->getNomeGruppo()));
		// categoria per ricerca (attributo contenente il nome della categoria per eesere incluso nella ricerca)
		$productModel->setCategoria($spicerRow->getNomeGruppo()) ;
		// marchio
		$this->setAttribute('marchio', $spicerRow->getNomeBrand(), $productModel) ;
		// fornitore
		$this->setAttribute('fornitore','spicer', $productModel) ;
		// immagine
		$this->_setImg($productModel , $spicerRow->getImmagine()) ;
		//Stock
		$stockData = array();
		$stockData['qty'] = 1000 ;
		$stockData['is_in_stock'] = 1;
		$stockData['manage_stock'] = 1;
		$stockData['max_sale_qty'] = 10000;
		$stockData['min_sale_qty'] = 0;
		
		$productModel->setStockData($stockData);
		unset($stockData) ;

		try {
			$productModel->save();
			
		} catch(Exception $e) {
			echo $e->getMessage() ."\n" ;
		}
		$productModel->clearInstance();
		$spicerRow->clearInstance() ;
		unset($productModel) ;
		unset($spicerRow) ;
	}
	public function getCategory($codice_categoria_spicer , $nome_categoria_spicer){
		$categories = Mage::getModel("catalog/category")->getCollection() ;
		$categories->addAttributeToSelect("codice_spicer") ;
		$categories->addAttributeToSelect("name") ;
		$categories->addAttributeToFilter("codice_spicer" ,array('eq' => $codice_categoria_spicer)) ;
		foreach($categories as $category){
			if ($category->getName() !=  $nome_categoria_spicer){
				$category->setName($nome_categoria_spicer) ;
				$category->save() ;
				// qui devo inserire l'invio di un messaggio per dire che la categoria ha cambiato nome
			}
			$categoryId = $category->getId() ;
			unset($categories) ;
			$category->clearInstance();
			unset($category) ;
			return $categoryId ;
		} 
		unset($categories) ;
		if(isset($category))
			unset($category) ;
		$app = Mage::app() ;
		$store = $app->getStore() ;
		$rootPath = '1/2';
		$storeId = $store->getId() ;
		unset($store) ;
		unset($app) ;
		$category = Mage::getModel('catalog/category')
					->setStoreId($storeId)
					->setPath($rootPath)
					->setName($nome_categoria_spicer)
					->setCodiceSpicer($codice_categoria_spicer)
					->setIsActive(0)
					->setIsAnchor(0)
					->setIncludeInMenu(1)
					->setDisplayMode('PRODUCTS_AND_PAGE')
					->save();
		$categoryId = $category->getId() ;
		$category->clearInstance();
		unset($category) ;
		// qui devo inserire l'invio di un messaggio per informare della nuova categoria
		return $categoryId ;
	}
	public function setPrezzi(){
		$listTierPrices = array(3 => 0.5, 5 => 1, 10 => 1.5) ;
		
		$spicer_listino = Mage::getModel("spicer/spicer")->getCollection() ;
		$spicer_listino->addFieldToSelect("spicer_id") ;
		$spicer_listino->addFieldToSelect("codice_articolo") ;
		$spicer_listino->addFieldToSelect("prezzo_fascia_listino") ;
		$spicer_listino->addFieldToSelect("eliminato") ;
		$spicer_listino->addFieldToSelect("codice_gruppo") ;
		$spicer_listino->addFieldToSelect("status") ;
		$spicer_listino->addFieldToFilter("status" , array("eq" => 0)) ;
		$count = 0 ;
		foreach($spicer_listino as $riga){
			$count++ ;
			echo $count ." " ;
			$sku = $riga->getCodiceArticolo() ;
			$productModel = Mage::getModel("catalog/product") ;
			$productId = $productModel->getIdBySku($sku) ;

			if (!empty($productId)){
				$productModel->load($productId) ;
				if (trim($riga->getEliminato()) == "Y"){
					Mage::register('isSecureArea', true);
					$productModel->delete() ;
					Mage::unregister('isSecureArea');
					echo "Eliminato " . $sku  . "\n";
				}
				$categories = Mage::getModel("catalog/category")->getCollection() 
							->addAttributeToSelect("ricarico")
							->addAttributeToSelect("level")
							->addAttributeToSelect("parent_id")
							->addAttributeToSelect("codice_spicer")
							->addAttributeToFilter("codice_spicer",$riga->getCodiceGruppo())
							->load() ;
				$ricarico = 0 ;
				foreach($categories as $category){
					$ricarico = $category->getRicarico() ;
					$parentId = $category->getParentId() ;
					$level = $category->getLevel() ;
					
					while ($level > 1 && $ricarico == 0 ): 
							$category = Mage::getModel('catalog/category')->load($parentId); 
							$parentId = $category->getParentId() ;
							$ricarico = $category->getRicarico() ;
							$level = $category->getLevel() ;
							$category->clearInstance() ;
							unset($category) ;
					endwhile ;
					
					if (isset($category)){
						$category->clearInstance() ;
						unset($category) ;
					}
					break ;
				} 
				if ($ricarico == 0){
					$ricarico = 19 ;
				}
				/// controllo se il prodotto appartiene alla categoria "500 prodotti"
				$categoryIds = $productModel->getCategoryIds() ;
				foreach($categoryIds as $catid){
					if ($catid == "147"){
						$cat_model = Mage::getModel("catalog/category")->load("147") ;
						$ricaricoSpecial = $cat_model->getRicarico() ;
						$specialPrice = round($riga->getPrezzoFasciaListino() * (1+($ricaricoSpecial /100) ),2) ;
						$productModel->setSpecialPrice($specialPrice) ;
						$cat_model->clearInstance() ;
						unset($cat_model) ;
					} 
				}
				$prezzo = round($riga->getPrezzoFasciaListino() * (1+($ricarico /100) ),2) ;
				
				//Status
				$productModel->setStatus(1); // 1 abilitato 2 disabilitato
				//Price
				$productModel->setPrice($prezzo);
				//Cost
				$productModel->setCost($riga->getPrezzoFascialistino());
				//Tier Price
				$tierPrices = array();
				foreach($listTierPrices as $qty=>$sconto) {
					$tierPrices[] = array(
						'website_id'	=> 0,
						'cust_group'	=> Mage_Customer_Model_Group::CUST_GROUP_ALL,
						'price_qty'		=> $qty,
						'price'			=> number_format($prezzo*(1-$sconto/100), 2, '.', '')
					);
				}
				$productModel->setData('tier_price', $tierPrices);
				
				$productModel->save() ;
				$productModel->clearInstance() ;
				unset($productModel) ;
				echo "aggiornato " . $sku . " Ricarico " . $ricarico . "\n";
			}
			
			$riga->setStatus(1) ;
			$riga->save() ;
			if ($count > 99)
				break ;
		}
	}
	protected function _setImg($p , $imgName){
		$imageFile = Mage::getBaseDir('media') . DS ."import" .DS . "images" .DS .$imgName ;
		//echo "immagine " . $imageFile ;
		if (is_file($imageFile)) {
			/* cancello eventuali immagini già presenti*/
			$instance = $p->getTypeInstance() ;
			$attributes = $instance->getSetAttributes();
			if (isset($attributes['media_gallery'])) {
				$gallery = $attributes['media_gallery'];
				$backEnd = $gallery->getBackend() ;
				$galleryData = $p->getMediaGallery();
				if ($galleryData) {
					foreach($galleryData['images'] as $image){
						if ($backEnd->getImage($p, $image['file'])) {
							$backEnd->removeImage($p, $image['file']);
						}
						
					}
				}
			}
			
			$p->addImageToMediaGallery($imageFile, array('small_image', 'thumbnail', 'image'), false, true);
// $newImage = array(
// 				'file' => array(
// 					'content' => base64_encode(file_get_contents($imageFile)),
// 					'mime'    => 'image/jpeg',
// 					'name'    => $imgName
// 				),
// 				'label'    => "",
// 				'position' => 1, 
// 				'types'    => array('image', 'small_image', 'thumbnail'),
// 				'exclude'  => 1
// 			);
// 			if ($p->getId()){
// 				$mediaApi = Mage::getModel("catalog/product_attribute_media_api");
// 				$items = $mediaApi->items($p->getId());
// 				foreach($items as $item)
// 					$mediaApi->remove($p->getId(), $item['file']);
// 				
// 			}
// 			$mediaApi->create($p->getSku(), $newImage);
			/* inserisco la mnuova immagine */
			
		}
 	}
 	private function setAttribute($attributeCode, $attributeValue, $product) {
		$code = $this->attributeValueExists($attributeCode, $attributeValue);
		if (!$code) {
			$this->addAttributeValue($attributeCode, $attributeValue);
			$code = $this->attributeValueExists($attributeCode, $attributeValue);
		}
		$product->setData($attributeCode, $code);
	}

	private function attributeValueExists($arg_attribute, $arg_value) {
		$attribute_model = Mage::getModel('eav/entity_attribute');
		$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

		$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
		$attribute = $attribute_model->load($attribute_code);


		$attribute_table = $attribute_options_model->setAttribute($attribute);
		$options = $attribute_options_model->getAllOptions(false);

		$return = false;
		foreach ($options as $option) {
			if ($option['label'] == $arg_value) {
				$return = $option['value'];
				break;
			}
		}

		//Pulizia
		unset($attribute_model);
		unset($attribute_options_model);
		unset($attribute_code);
		unset($attribute);
		unset($options);

		return $return;
	}

	private function addAttributeValue($arg_attribute, $arg_value) {
		$attribute_model = Mage::getModel('eav/entity_attribute');
		$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

		$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
		$attribute = $attribute_model->load($attribute_code);

		$attribute_table = $attribute_options_model->setAttribute($attribute);
		$options = $attribute_options_model->getAllOptions(false);

		if (!$this->attributeValueExists($arg_attribute, $arg_value)) {
			$value['option'] = array($arg_value, $arg_value);
			$result = array('value'=>$value);
			$attribute->setData('option', $result);
			$attribute->save();
		}

		$return = true;
		foreach ($options as $option) {
			if ($option['label'] == $arg_value) {
				$return =  $option['value'];
				break;
			}
		}

		//Pulizia
		unset($attribute_model);
		unset($attribute_options_model);
		unset($attribute_code);
		unset($attribute);
		unset($options);

		return $return;
	}
	public function setSpecialPriceProduct($file){
		
		for ($index = 1; $index <= 9; $index++) {  
			$process = Mage::getModel('index/process')->load($index);  
			$process->setMode(Mage_Index_Model_Process::MODE_MANUAL);
			$process->save() ;
			$process->clearInstance() ;
			unset($process) ;
		}
		
		$handle = fopen($file, "r");
		if ($handle) {
			while (!feof($handle)) {
				$linea =fgets($handle) ;
				$sku =   str_replace(array("\n","\t","\r"),"",$linea) ;
				$productModel = Mage::getModel("catalog/product") ;
				$productId = $productModel->getIdBySku($sku) ;
				$productModel->load($productId) ;
				if ($productModel->getSku()){
					
 					$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
 					$db->setFetchMode(Zend_Db::FETCH_ASSOC);
 					$spicer = $db->fetchRow('select * from spicer where codice_articolo = ? ' , $sku) ;
 					$specialPrice = null;//round(($spicer['prezzo_fascia_listino'] * 1.15),2) ;
 					$price = round(($spicer['prezzo_fascia_listino'] * 1.15),2) ;
 					$productModel->setSpecialPrice($specialPrice) ;
					$productModel->setPrice($price) ;
					//$categorie = $productModel->getCategoryIds() ;
					//$categorie[] = 147 ;
					//$productModel->setCategoryIds($categorie) ;
					$productModel->save() ;
					//echo $productModel->getSku()  . "\n" ;
 					echo $productModel->getSku() . " costo " . $spicer['prezzo_fascia_listino'] . 
						" prezzo " . $productModel->getPrice() .
						" special " .$specialPrice . " " . memory_get_usage() .
 						"\n" ;
				}
				$productModel->clearInstance() ;
			}
		}
		for ($index = 1; $index <= 9; $index++) {  
			$process = Mage::getModel('index/process')->load($index);  
			$process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME);
			$process->save() ;
			$process->reindexAll() ;
			$process->clearInstance() ;
			unset($process) ;
		}
	}
	public function setCodiceOriginale(){
		for ($index = 1; $index <= 9; $index++) {  
			$process = Mage::getModel('index/process')->load($index);  
			$process->setMode(Mage_Index_Model_Process::MODE_MANUAL);
			$process->save() ;
			$process->clearInstance() ;
			unset($process) ;
		}
		
		$spicercatalog = Mage::getModel("spicer/spicercatalogo")->getCollection() ;
		
		$spicercatalog->addFieldToSelect("spicercatalogo_id") ;
		$spicercatalog->addFieldToSelect("codice_spicer") ;
		$spicercatalog->addFieldToSelect("riferimento_originale") ;
		$spicercatalog->addFieldToFilter('status', array('neq' => 3)) ;
		
		$count = 0 ;
		foreach($spicercatalog as $row){
			$count++ ;
			$productModel = Mage::getModel("catalog/product") ;
			$productId = $productModel->getIdBySku($row->getCodiceSpicer()) ;
			$productModel->load($productId) ;
			if($productModel->getSku()){
				echo $count . " sku " . $productModel->getSku() . " orig. " . $row->getRiferimentoOriginale() . " m "  . memory_get_usage() . "\n" ;
				$productModel->setCodiceOriginale($row->getRiferimentoOriginale()) ;
				$productModel->save() ;
				$row->setStatus(3) ;
				$row->save() ;
			} 
			$productModel->clearInstance() ;
			unset($productModel) ;
		}
		unset($spicercatalog) ;
		
		for ($index = 1; $index <= 9; $index++) {  
			$process = Mage::getModel('index/process')->load($index);  
			$process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME);
			$process->save() ;
			$process->reindexAll() ;
			$process->clearInstance() ;
			unset($process) ;
		}
	}
}
