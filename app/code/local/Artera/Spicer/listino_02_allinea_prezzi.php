<?php
if (!isset($da_gestione_campagne)){
	require_once('../../../../../app/Mage.php');
	require_once('_product_function.php');
}
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);
$elimina = $db->prepare("delete from " . getMagentoTableName('catalog_product_entity') . " where sku = :sku") ;
$tabellaTier = getMagentoTableName('catalog_product_entity_tier_price') ;
$sqlDeleteTier = "delete from $tabellaTier where entity_id = :product_id AND website_id = :website_id" ;
$deleteTier = $db->prepare($sqlDeleteTier) ;
$sqlInsertTier = <<<EOMYSQL
	INSERT INTO $tabellaTier
	(`entity_id`, `all_groups`, `customer_group_id`, `qty`, `value`, `website_id`) 
	VALUES 
	(:product_id,:all_groups,:customer_group_id,:qty,:prezzo,:website_id)
EOMYSQL;
$insertTier = $db->prepare($sqlInsertTier) ;
$listTierPrices = array(3 => 0.5, 5 => 1, 10 => 1.5) ;
$righe = $db->fetchOne("select count(*) from spicer") ;
$listinoSpicer = $db->query("select * from spicer") ;
$i = 0 ;
while($prodotto = $listinoSpicer->fetch()){
	$i++ ;
	$sku = $prodotto['codice_articolo']  ;
	$id = getIdBySku($sku) ;
	if (!$id)
		continue ;
	$ean = getAttributeValue('codice_ean' ,$id) ;
	
	/// se l'articolo è eliminato lo elimino
	if (trim($prodotto['eliminato']) == "Y"){
		setAttributeValue("status",2,$id) ;
		//$elimina->execute(array('sku'=>$sku)) ;
		continue ;
	}
	/// se fa parte degli articoli a prezzo imposto non lo riprezzo 
	$prezzoImposto = $db->fetchOne("SELECT ean FROM ean_prezzi_imposti where ean = :ean",array("ean"=>$ean)) ;
	if ($prezzoImposto){
		//echo "prezzo imposto sku " . $sku . "\n" ;
		continue ;
	}
	/// se fa parte degli articoli Avery a prezzo imposto salto il riprezzamento
	$prezzoImpostoArvey = $db->fetchOne("SELECT codice_spicer FROM ListinoAvery where codice_spicer = :sku",array("sku"=>$sku)) ;
	if ($prezzoImpostoArvey)
		continue ;
	
	//echo "\n" . $sku . "\n" ;

	/// se fa parte di quella in promozione salto il riprezzamento
// 	$noRiprez = $db->fetchOne("SELECT category_id FROM catalog_category_product where category_id = 190 and product_id = :id",array("id"=>$id)) ;
// 	if ($noRiprez){
// 		continue ;
// 	}
	
	/// metto il vecchio prezzo il un campo per confrontarli
	$old_prezzo = getAttributeValue('special_price' ,$id) ;
	if (!$old_prezzo){
		$old_prezzo = getAttributeValue('price' ,$id) ;
	}
	
	$prezzo_base = $prodotto['prezzo_promo'] ;
	if ($prezzo_base == 0) {
		$prezzo_base = $prodotto['prezzo_fascia_listino'] ;
	}
	/// se fa parte della categoria dei 500 prodotti o della categoria top elite sconto ulteriormente lo special price
	$topElite = $db->fetchOne("SELECT category_id FROM catalog_category_product where category_id = 189 and product_id = :id",array("id"=>$id)) ;

	if ($topElite){
		$prezzo = round($prezzo_base * 1.60,2) ;
		$special_price = round($prezzo * 0.70,2) ;
		$special_price_unappa = round($special_price * 0.985,2) ;
		$tier_unappa = round($special_price * 0.975,2) ;
	}else{
		$cinquecento = $db->fetchOne("SELECT category_id FROM catalog_category_product where category_id = 147 and product_id = :id",array("id"=>$id)) ;
		if ($cinquecento){
			$prezzo = round($prezzo_base * 1.55,2) ;
			$special_price = round($prezzo * 0.75,2) ;
			$special_price_unappa = round($special_price * 0.97,2) ;
			$tier_unappa = round($special_price * 0.95,2) ;
		}else{
			$prezzo = round($prezzo_base * 1.50,2) ;
			$special_price = round($prezzo * 0.80,2) ;
			$special_price_unappa = round($special_price * 0.93,2) ;
			$tier_unappa = round($special_price * 0.90,2) ;
		}
	}
	
	$campagna = $db->fetchRow("SELECT * FROM campagna_catalogo WHERE sku = ? AND validita_al >= NOW() AND (sconto IS NOT NULL OR prezzo IS NOT NULL)" , array($sku));
	if (isset($campagna) && !empty($campagna)){
		//Il prodotto è in CAMPAGNA con date ancora valide
		if (!is_null($campagna['prezzo'])) {
			if ($campagna['prezzo'] == 0) {
				$prezzo = 0;
				$special_price = null;
			} else {
				$special_price = $campagna['prezzo'];
			}
		} elseif(!is_null($campagna['sconto'])) {
			if ($campagna['sconto'] == 100) {
				$prezzo = 0;
				$special_price = null;
			} else {
				$sconto = 1 - ($campagna['sconto'] / 100) ;
				$special_price = round($prezzo * $sconto,2);
			}
		}

		//elimino i tierprice della vetrina 100x100ufficio
		$deleteTier->execute(array("product_id"=>$id, "website_id" => 1));
	} else {
		//imposto i tier price 
		$deleteTier->execute(array("product_id"=>$id, "website_id" => 1));
		foreach($listTierPrices as $qty=>$sconto) {
			$tPrice = number_format($special_price*(1-$sconto/100), 2, '.', '') ;
			if ($tPrice > $prodotto['prezzo_fascia_listino']){
				$tierPrices = array(
					'qty'			=> $qty,
					'prezzo'		=> $tPrice ,
					'product_id'	=> $id ,
					'all_groups'	=> 1 ,
					'customer_group_id' => 0 ,
					'website_id' => 1 ,
				);
				$insertTier->execute($tierPrices) ;
			}
		}
	}

	
	//Queste sono le operazioni eseguite indifferentemente sia che il prodotto è in campagna o meno
	setAttributeValue("price",$prezzo,$id) ;
	setAttributeValue("special_price",$special_price,$id) ;
	setAttributeValue("old_special_price",$old_prezzo,$id) ;
	setAttributeValue("cost",$prezzo_base,$id) ;
	setAttributeValue("status",1,$id) ;
	
	$ckWebsite = $db->fetchOne("SELECT product_id FROM catalog_product_website WHERE product_id = ? AND website_id = ?", array($id, 4));
	if (!empty($ckWebsite)) {
		setAttributeValue("special_price",$special_price_unappa,$id,2) ; // metto lo store_id a 2 unappa cancelleria
		
		$deleteTier->execute(array("product_id"=>$id, "website_id" => 4));
		$tierPrices = array(
					'qty'			=> 5,
					'prezzo'		=> $tier_unappa ,
					'product_id'	=> $id ,
					'all_groups'	=> 1 ,
					'customer_group_id' => 0 , 
					'website_id' => 4 , /** Unappa Cancelleria */
				);
		$insertTier->execute($tierPrices) ;
	} else {//inserito momentaneamente per ripulire i dati sporchi. si può rimuovere
		$deleteTier->execute(array("product_id"=>$id, "website_id" => 4));
	}

	
	if (!isset($da_gestione_campagne))
		echo "aggiornate $i righe di $righe \r" ;
}
echo "\n" ;




