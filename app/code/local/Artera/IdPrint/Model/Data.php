<?php
Class Artera_IdPrint_Model_Data extends Mage_Core_Model_Abstract 
{
	protected $_indCompleto = "";
	protected $soap_userdata ;
	
	function __construct(){
		$ind = Mage::getStoreConfig('catalog/idprint_config/ind',$this->soreId) ;
		$key = Mage::getStoreConfig('catalog/idprint_config/key',$this->soreId) ;
		$this->_indCompleto = $ind ."/". $key. "?wsdl" ;
		
		$userdata = array(
			'userkey'=>$this->_key
		);
		$this->soap_userdata = new SoapParam($userdata,'userkey');
	}
	public function getDataIdPrint($marca ,$tipo ,$modello){
		if( ( !isset($marca) && !isset($tipo) ) && !eregi("%",$marca) ){
			return $this->getMarche() ;
		}
		if( ( isset($marca) && !isset($tipo) ) && !eregi("%",$marca) ){
			return $this->getTipi($marca) ;
		}
		if(  ( isset($marca) && isset($tipo) && !isset($modello) ) && !eregi("%",$tipo)){
			return $this->getModelli($marca,$tipo) ;
		}
		if(  ( isset($modello) ) && !eregi("%",$modello)){
			return $this->getTabToner($marca,$tipo,$modello) ;
		}
	} 
	private function getMarche(){
		try {
			$request = array( 
				'idbrand'=>0,
				'idcat'=>0,
				'idprinter'=>0
			);
			$soap_request = new SoapParam($request,'request');
			
			$soapClient = new SoapClient($this->_indCompleto);
			$response = $soapClient->getList($this->soap_userdata,$soap_request);
			
			$ritorno =  "<select name=\"marche\" id=\"marche\" class=\"input-text\" style=\"width:300px;\" OnChange=\"clickMarche(this.value);\">"
					. "<option value=\"NONE\">[Scegliere la marca]</option>\n";
			if (isset($response['brand'])){
				$ritorno .= $this->_feedSelect($response['brand']) ;
			}
			$ritorno .= "</select>";
			
		}catch (SoapFault $exception) {
			return '<pre>'.$exception.'</pre>';   
		}
		return $ritorno ;
	}
	private function getTipi($marca){
		try {
			$request = array( 
				'idbrand'=>$marca,
				'idcat'=>0,
				'idprinter'=>0
			);
			$soap_request = new SoapParam($request,'request');
			
			$soapClient = new SoapClient($this->_indCompleto);
			$response = $soapClient->getList($this->soap_userdata,$soap_request);
			
			$ritorno =  "<select name=\"tipi\" id=\"tipi\" class=\"input-text\" style=\"width:300px;\" OnChange=\"clickTipi(document.search.marche.value, this.value);\">"
					. "<option value=\"NONE\">[Scegliere il tipo]</option>\n";
			if (isset($response['type'])){
				$ritorno .= $this->_feedSelect($response['type']) ;
			}
			$ritorno .= "</select>";
			
		}catch (SoapFault $exception) {
			return '<pre>'.$exception.'</pre>';   
		}
		return $ritorno ;
	}
	private function getModelli($marca,$tipo){
		try {
			$request = array( 
				'idbrand'=>$marca,
				'idcat'=>$tipo,
				'idprinter'=>0
			);
			$soap_request = new SoapParam($request,'request');
			
			$soapClient = new SoapClient($this->_indCompleto);
			$response = $soapClient->getList($this->soap_userdata,$soap_request);
			
			$ritorno =  "<select name=\"modelli\" id=\"modelli\" class=\"input-text\" style=\"width:300px;\" OnChange=\"clickModelli(this.value);\">"
					. "<option value=\"NONE\">[Scegliere il modello]</option>\n";
			if (isset($response['model'])){
				$ritorno .= $this->_feedSelect($response['model']) ;
			}
			$ritorno .= "</select>";
			
		}catch (SoapFault $exception) {
			return '<pre>'.$exception.'</pre>';   
		}
		return $ritorno ;
	}
	private function getTabToner($marca,$tipo,$modello){
		try {
			$request = array( 
				'idbrand'=>$marca,
				'idcat'=>$tipo,
				'idprinter'=>$modello
			);
			$soap_request = new SoapParam($request,'request');
			
			$soapClient = new SoapClient($this->_indCompleto);
			$response = $soapClient->getList($this->soap_userdata,$soap_request);
			$ritorno = "" ; 
			$codici = array() ;
			$codici_b = array() ;
			$codici_bor = array() ;
			$codici_idPrint = array() ;
			if (isset($response['consumable'])){
				foreach($response['consumable'] as $k=>$v ){
					$codici[] = $v['original_code'] ;
					$codici_b[] = 'B' .$v['original_code'] ;
					$codici_orb[] = 'ORB' . $v['original_code'] ;
					$codici_idPrint[] = $k ;
 				}
				//echo print_r($k);
				$collection = Mage::getModel('catalog/product')->getCollection();
				$collection->addAttributeToSelect('*') ;
				//$collection->addAttributeToFilter('codice_originale' , array('in' => $codici));
				//$collection->addAttributeToFilter('sku' , array('in' => $codici_orb));
				$collection->addAttributeToFilter(array(
					array(
						'attribute' => 'sku',
						'in' => $codici_orb
					),
					array(
						'attribute' => 'sku',
						'in' => $codici_b
					),
					array(
						'attribute' => 'codice_originale',
						'in' => $codici
					)
				));
				$ritorno = "<div class='listing-type-grid catalog-listing'>";
				$ritorno .= "<ol class='grid-row last odd'>" ;
				$i = 0 ;
				foreach($collection as $_product){
					$i++ ;
					$last = ($i%2==0) ? "last" : "" ;
					$immagine = Mage::helper('catalog/image')->init($_product, 'small_image')->resize(250, 135) ;
					$price = $_product->getFinalPrice(); 
					$img_btn = Mage::getDesign()->getSkinUrl('images/btn_add_to_cart.gif') ;
					$ajax_cart = Mage::helper('checkout/cart')->getAddUrl($_product,array()) ;
					$viewUrl = Mage::getUrl('idprint/view?id='.$_product->getId()) ;
					
					$ritorno .= "<li class='item $last'>" ;
					$ritorno .=  "<p class='product-image'>" ;
					$ritorno .=    "<a href=\"Javascript:open('".$viewUrl."','ConsumbaleDetail','scrollbars=yes,toolbar=no,height=600,width=800').focus();\">" ;
					$ritorno .=      "<img src='$immagine' width='250' height='135'";
					$ritorno .=    "</a>" ;
					$ritorno .=  "</p>" ;
					$ritorno .=  "<h5><a href=\"Javascript:open('".$viewUrl."','ConsumbaleDetail','scrollbars=yes,toolbar=no,height=600,width=800').focus();\">" . $_product->getName() . "</a></h5>" ; 
					$ritorno .=  "<div class=\"price-box\">Iva Escl : <span class=\"price\">&euro; ".number_format($price,2,",",".")."</span></span><div>";
					//$ritorno .= "<a onclick=\"submit_ajax_cart('$ajax_cart')\" href=\"#idprint-tb-2\"><img alt=\"Aggiungi al carrello\" src='$img_btn' /></a></td>" ;
					if($_product->isSaleable()){
						$ritorno .= "<button class='form-button' onclick='setLocation(\"$ajax_cart\")'><span>aggiungi al carrello</span></button> " ;
					}else{
						$ritorno .= "<div class='out-of-stock'><span>esaurito</span></div>" ;
					}
					$ritorno .= "</li>" ;
				}
				$ritorno .= "</ol></div>" ;
			}
		}catch (SoapFault $exception) {
			return '<pre>'.$exception.'</pre>';   
		}
		return $ritorno ;
	}
	private function _feedSelect($food){
		$ritorno = "" ;
		foreach($food as $k=>$v){
				if (trim($v) && trim($k))
				$ritorno .= "<option value=\"$k\">$v</option>\n";
		}
		return $ritorno ;
	}
	public function getItemInfomation($code){
		/** Esempio di dati ritornati
		Array(
			[consumable] => Array
				(
					[8028] => Array
					(
						[original_code] => C4810A
						[brand] => HP
						[or_code] => HEWC4810A
						[description] => Testina di stampa 11 nero
						[market_description] => 
						[image_url] => http://www.idprint.it/multimedia/Catalogue/images/items/HEW/HEWC4810A.jpg
						[technology] => Inkjet
						[class_description] => Informatica/Consumabili per stampa/Inkjet
						[attribute1_name] => Tipo
						[attribute1_value] => Testina di stampa
						[attribute2_name] => Sigla
						[attribute2_value] => 11
						[attribute3_name] => Colore
						[attribute3_value] => nero
						[attribute4_name] => 
						[attribute4_value] => 
						[attribute5_name] => Resa pagine
						[attribute5_value] => 16000
						[compatible_flag] => O
						[reference_code] => 
						[iva] => 20
						[currency] => EUR
						[consumer_price] => 37.13
						[pack_description] => 
						[pieces] => 1
						[barcode] => 0 88698-85721 2
						[exposure] => 
						[production_down] => 
						[substitute_code] => 
						[security_card] => http://www.idprint.it/multimedia/Catalogue/cards/HEW/HEWC4810A_S_ITA.pdf
						[technical_card] => http://www.idprint.it/multimedia/Catalogue/cards/HEW/HEWC4810A_T_IT.pdf
						[compatible_printers] => HP Stampante  1000 - Inkjet, HP Stampante  1000 SERIES - Inkjet, HP Stampante  2800 - Inkjet, HP Stampante  2800 SERIES - Inkjet, HP Stampante  2800DT - Inkjet, HP Stampante  2800DTN - Inkjet, HP Stampante Business InkJet 1100 SERIES - Inkjet, HP Stampante Business InkJet 1100D - Inkjet, HP Stampante Business InkJet 1100DTN - Inkjet, HP Stampante Business InkJet 1200 - Inkjet, HP Stampante Business InkJet 1200D - Inkjet, HP Stampante Business InkJet 1200DN - Inkjet, HP Stampante Business InkJet 1200DTN - Inkjet, HP Stampante Business InkJet 1200DTWN - Inkjet, HP Stampante Business InkJet 2200 - Inkjet, HP Stampante Business InkJet 2200 SERIES - Inkjet, HP Stampante Business InkJet 2200SE - Inkjet, HP Stampante Business InkJet 2200XI - Inkjet, HP Stampante Business InkJet 2230 - Inkjet, HP Stampante Business InkJet 2250 - Inkjet, HP Stampante Business InkJet 2280 - Inkjet, HP Stampante Business InkJet 2280TN - Inkjet, HP Stampante Business InkJet 2300 - Inkjet, HP Stampante Business InkJet 2300 SERIES - Inkjet, HP Stampante Business InkJet 2300DTN - Inkjet, HP Stampante Business InkJet 2300N - Inkjet, HP Stampante Business InkJet 2600 - Inkjet, HP Stampante Business InkJet 2600 SERIES - Inkjet, HP Stampante Business InkJet 2600DN - Inkjet, HP Stampante Business InkJet CP 1700 - Inkjet, HP Stampante Business InkJet CP 1700D - Inkjet, HP Stampante Business InkJet CP 1700PS - Inkjet, HP Stampante DesignJet 100 - Inkjet, HP Stampante DesignJet 100 PLUS - Inkjet, HP Stampante DesignJet 10PS - Inkjet, HP Stampante DesignJet 110 - Inkjet, HP Stampante DesignJet 110 PLUS - Inkjet, HP Stampante DesignJet 110 PLUS NR - Inkjet, HP Stampante DesignJet 110 PLUS R - Inkjet, HP Stampante DesignJet 111 - Inkjet, HP Stampante DesignJet 120 - Inkjet, HP Stampante DesignJet 120NR - Inkjet, HP Stampante DesignJet 20PS - Inkjet, HP Stampante DesignJet 500 - Inkjet, HP Stampante DesignJet 500 - 610 mm - Inkjet, HP Stampante DesignJet 500 PLUS-1067 mm - Inkjet, HP Stampante DesignJet 500 PLUS-610 mm - Inkjet, HP Stampante DesignJet 500-1.067 mm - Inkjet, HP Stampante DesignJet 500PS - Inkjet, HP Stampante DesignJet 500PS PLS-1067 mm - Inkjet, HP Stampante DesignJet 500PS PLUS-610 mm - Inkjet, HP Stampante DesignJet 500PS-1067 mm - Inkjet, HP Stampante DesignJet 500PS-610 mm - Inkjet, HP Stampante DesignJet 50PS - Inkjet, HP Stampante DesignJet 510 - 610 mm - Inkjet, HP Stampante DesignJet 510-1.067 mm - Inkjet, HP Stampante DesignJet 70 - Inkjet, HP Stampante DesignJet 800 - Inkjet, HP Stampante DesignJet 800 - 610 mm - Inkjet, HP Stampante DesignJet 800-1.067 mm - Inkjet, HP Stampante DesignJet 800PS - Inkjet, HP Stampante DesignJet 800PS-1067 mm - Inkjet, HP Stampante DesignJet 800PS-610 mm - Inkjet, HP Multifunzione DesignJet 815MFP - Inkjet, HP Stampante DesignJet 820MFP - Inkjet, HP Fotocopiatrice DesignJet CC800PS - Inkjet, HP Stampante DeskJet 2250TN - Inkjet, HP Stampante OfficeJet 9110 - Inkjet, HP Stampante OfficeJet 9120 - Inkjet, HP Stampante OfficeJet 9130 - Inkjet, HP Stampante OfficeJet PRO K850 - Inkjet, HP Stampante OfficeJet PRO K850DN - Inkjet
					)
				)
			)
		*/
		try{
			$request = array( 
				'item_text' => $code,
			);
			$soap_request = new SoapParam($request,'request');
			//echo $this->_indCompleto . "<br/>";
			$soapClient = new SoapClient($this->_indCompleto);
			$response = $soapClient->getList($this->soap_userdata,$soap_request);
			if (isset($response['consumable'])){
				$request = array( 
					'item_text' => $code,
					'iditem' => key($response['consumable']),
				);
				$soap_request = new SoapParam($request,'request');
				$response = $soapClient->getList($this->soap_userdata,$soap_request);
			}
			return $response ;
		}catch(Exception $e){return null ;}
	}
}
?>
