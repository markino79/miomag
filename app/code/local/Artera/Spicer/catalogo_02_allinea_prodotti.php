<?php
require_once('../../../../../app/Mage.php');
require_once('_product_function.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);
/// inserimento tabella prodotti
$tabellaProdotti = getMagentoTableName('catalog_product_entity') ;
$sqlInsertProduct = <<<EOMYSQL
	INSERT INTO $tabellaProdotti
	(`entity_type_id`,`attribute_set_id`,`type_id`,`sku`,`has_options`,`required_options`,`created_at`,`updated_at`) 
	VALUES 
	(4,4,'simple',:sku,0,0,now(),now())
EOMYSQL;
$insertProduct = $db->prepare($sqlInsertProduct) ;
/// inserimento tabella che associa website e prodotto
$tabellaProdottiWebsite = getMagentoTableName('catalog_product_website') ;
$sqlInsertProductWebsite = <<<EOMYSQL
	INSERT INTO $tabellaProdottiWebsite
	(`product_id`, `website_id`)
	VALUES 
	(:id,1)
EOMYSQL;
$insertProductWebsite = $db->prepare($sqlInsertProductWebsite) ;
/// inserimento nello stock-item
$tabellaStockItem = getMagentoTableName('cataloginventory_stock_item') ;
$sqlInsertStockItem = <<<EOMYSQL
	INSERT INTO $tabellaStockItem
	(`product_id`, `stock_id`, `qty`, `min_qty`, `use_config_min_qty`, `is_qty_decimal`, `backorders`, `use_config_backorders`, 
	`min_sale_qty`, `use_config_min_sale_qty`, `max_sale_qty`, `use_config_max_sale_qty`, `is_in_stock`, `low_stock_date`, `notify_stock_qty`, 
	`use_config_notify_stock_qty`, `manage_stock`, `use_config_manage_stock`, `stock_status_changed_auto`, `use_config_qty_increments`, `qty_increments`, 
	`use_config_enable_qty_inc`, `enable_qty_increments`) 
	VALUES 
	(:id,1,1000,0,1,0,0,1,0,0,10000,0,1,null,null,1,1,1,0,1,0,1,0)
EOMYSQL;
$insertStockItem = $db->prepare($sqlInsertStockItem) ;
/// inserimento nello stock-status
$tabellaStockStatus = getMagentoTableName('cataloginventory_stock_status') ;
$sqlInsertStockStatus = <<<EOMYSQL
	INSERT INTO $tabellaStockStatus
	(`product_id`, `website_id`, `stock_id`, `qty`, `stock_status`) 
	VALUES 
	(:id,1,1,1000,1)
EOMYSQL;
$insertStockStatus = $db->prepare($sqlInsertStockStatus) ;
/// inserimento nuova categoria
$tabellaCategorie = getMagentoTableName('catalog_category_entity') ;
$sqlInsertCategory = <<<EOMYSQL
	INSERT INTO $tabellaCategorie
	(`entity_type_id`, `attribute_set_id`, `parent_id`, `created_at`, `updated_at`, `path`, `position`, `level`, `children_count`) 
	VALUES 
	(3,3,:parent_id,now(),now(),'',:posizione,:level,0)
EOMYSQL;
$insertCategory = $db->prepare($sqlInsertCategory) ;

$righe = $db->fetchOne("select count(*) from spicercatalogo") ;
$listinoSpicer = $db->query("select * from spicercatalogo ") ;
$i = 0 ;
while($prodotto = $listinoSpicer->fetch()){
	$i++ ;
	$sku = $prodotto['codice_spicer']  ;
	$id = getIdBySku($sku) ;
	if (!$id){
		$insertProduct->execute(array('sku'=>$sku)) ;
		$id = getIdBySku($sku) ;
		$insertProductWebsite->execute(array('id'=>$id)) ;
		$insertStockItem->execute(array('id'=>$id)) ;
		$insertStockStatus->execute(array('id'=>$id)) ;
		setAttributeValue("status",2,$id) ;
		setAttributeValue("visibility",4,$id) ;
		setAttributeValue("weight",1,$id) ;
		setAttributeValue("fornitore",4,$id) ;
		setAttributeValue("tax_class_id",7,$id) ;
		echo "add " . $sku . " con id " . $id . "\n" ;
	}
	if (!empty($prodotto['descizione_breve'])){
		setAttributeValue("name",$prodotto['descizione_breve'],$id) ;
	}else{
		setAttributeValue("name",$prodotto['nome_prodotto'],$id) ;
	}
	setAttributeValue("description",$prodotto['descizione_estesa'],$id) ;
	setAttributeValue("short_description",$prodotto['elenco_attributi'],$id) ;
	setAttributeOptionValue("marchio", $prodotto['nome_brand'], $id) ;
	
	if (!empty($prodotto['immagine'])){
		removeProductImages($id) ;
		addImageToMediaGallery($id,'/Spicer/'.$prodotto['immagine'], array('small_image', 'thumbnail', 'image'),  $exclude=true) ;
	}
	//$categoryId = getCategoryIdByAttributeValue('name' , $prodotto['nome_categoria']) ;
	$categoryId = getCategoryIdByAttributeValue('codice_spicer' , $prodotto['codice_gruppo']) ;
	if (!$categoryId){
		$posizione = $db->fetchOne("select max(`position`) from " . $tabellaCategorie . " where parent_id = 2") ;
		$insertCategory->execute(array('parent_id' => 2 , 'posizione'=> $posizione +1 , 'level' => 2 )) ;
		$categoryId = $db->lastInsertId() ;
		$db->query(
		"update " . $tabellaCategorie . " set path = :path where entity_id = :entity_id" ,
		array(
			'path'=>'1/2/'.$categoryId ,
			'entity_id' => $categoryId)
		);
		setCategoryAttributeValue('name',$prodotto['nome_gruppo'],$categoryId) ;
		setCategoryAttributeValue('codice_spicer',$prodotto['codice_gruppo'],$categoryId) ;
		setCategoryAttributeValue('is_active',0,$categoryId) ;
		setCategoryAttributeValue('is_anchor',0,$categoryId) ;
		setCategoryAttributeValue('include_in_menu',1,$categoryId) ;
		setCategoryAttributeValue('display_mode','PRODUCTS_AND_PAGE',$categoryId) ;
	}
	
	//removeCategoryIds($id) ;
	setCategoryIds($id,array($categoryId)) ;
	
	echo "aggiornate $i righe di $righe \r" ;
	
}
echo "\n" ;




