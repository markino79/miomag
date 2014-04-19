<?php
require_once('../../../../../app/Mage.php');
require_once('_product_function.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);
$elimina = $db->prepare("delete from " . getMagentoTableName('catalog_product_entity') . " where sku = :sku") ;
$tabellaTier = getMagentoTableName('catalog_product_entity_tier_price') ;
$sqlDeleteTier = "delete from $tabellaTier where entity_id = :product_id" ;
$deleteTier = $db->prepare($sqlDeleteTier) ;
$sqlInsertTier = <<<EOMYSQL
	INSERT INTO $tabellaTier
	(`entity_id`, `all_groups`, `customer_group_id`, `qty`, `value`, `website_id`) 
	VALUES 
	(:product_id,1,0,:qty,:prezzo,0)
EOMYSQL;
$insertTier = $db->prepare($sqlInsertTier) ;
$listTierPrices = array(3 => 0.5, 5 => 1, 10 => 1.5) ;
$file = Mage::getBaseDir('var') . DS . "prezzi.csv" ;
$handle = fopen($file, "r");
$i = 0 ;
if ($handle) {
	while($prodotto = fgetcsv($handle, 0, "|")){
		$i++ ;
		$sku = $prodotto[0]  ;
		$id = getIdBySku($sku) ;
		if (!$id)
			continue ;
		$ean = getAttributeValue('codice_ean' ,$id) ;
		
		/// se l'articolo è eliminato lo elimino
// 		if (trim($prodotto['eliminato']) == "Y"){
// 			setAttributeValue("status",2,$id) ;
// 			//$elimina->execute(array('sku'=>$sku)) ;
// 			continue ;
// 		}
		/// se fa parte degli articoli a prezzo imposto non lo riprezzo 
		$prezzoImposto = $db->fetchOne("SELECT ean FROM ean_prezzi_imposti where ean = :ean",array("ean"=>$ean)) ;
		if ($prezzoImposto){
			//echo "prezzo imposto sku " . $sku . "\n" ;
			continue ;
		}
		
		/// metto il vecchio prezzo il un campo per confrontarli
		$old_prezzo = getAttributeValue('special_price' ,$id) ;
		if (!$old_prezzo){
			$old_prezzo = getAttributeValue('price' ,$id) ;
		}
		$prezzo = round($prodotto[1] * 1.40,2) ;
		if ($prezzo ==0 )
			continue ;
		/// se fa parte della categoria dei 500 prodotti sconto ulteriormente lo special price
		$cinquecento = $db->fetchOne("SELECT category_id FROM catalog_category_product where category_id = 147 and product_id = :id",array("id"=>$id)) ;
		if ($cinquecento){
			$special_price = round($prezzo * 0.75,2) ;
		}else{
			$special_price = round($prezzo * 0.80,2) ;
		}
		//
		setAttributeValue("price",$prezzo,$id) ;
		/// lo special price lo aggiorno solo se non fa parte delle vendite live
		//$live = $db->fetchOne("SELECT category_id FROM catalog_category_product where category_id = 18 and product_id = :id",array("id"=>$id)) ;
		//if (!$live) 
		
		setAttributeValue("special_price",$special_price,$id) ;
		setAttributeValue("old_special_price",$old_prezzo,$id) ;
		setAttributeValue("cost",$prodotto[1],$id) ;
		setAttributeValue("status",1,$id) ;
		//imposto i tier price 
		$deleteTier->execute(array("product_id"=>$id));
		foreach($listTierPrices as $qty=>$sconto) {
			$tPrice = number_format($special_price*(1-$sconto/100), 2, '.', '') ;
			$tierPrices = array(
				'qty'			=> $qty,
				'prezzo'		=> $tPrice ,
				'product_id'	=> $id
			);
			$insertTier->execute($tierPrices) ;
		}
		echo "aggiornate $i righe di $righe \r" ;
		//echo " id " . $id . " costo " . $prodotto['prezzo_fascia_listino'] . " price " . $prezzo . " special " . $special_price . " " . $cinquecento . "\n" ;
	// 	if ($i > 2 ) 
	// 		break ;
	}
}
echo "\n" ;




