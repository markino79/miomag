<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 

$file = Mage::getBaseDir('var') . DS . "BARCODE2011.csv" ;
$handle = fopen($file, "r");
$i = 0 ;
if ($handle) {
	while ($data = fgetcsv($handle, 0, ";")) {
		$i++ ;
		$product_model = Mage::getModel("catalog/product") ;
		$product_id = $product_model->getIdBySku($data[0]) ;
		if (!empty($product_id)){
			$ean = str_replace("\n","",$data[1]) ;
			setAttributeValue('codice_ean', $ean , $product_id) ;
			echo $i ." id " . $product_id ." ean " . $ean .  "\n" ;
			//if ($i > 1) exit() ;
		}
		$product_model->clearInstance() ;
		unset($product_model) ;
	}
}



//echo getAttributeValue('codice_ean',13109) . "\n" ;


function getAttributeValue($attribute_name ,$product_id){
	global $db ;
	$attributo = getAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$attributo_val = $db->query("
		SELECT
			*
		FROM "
			. getMagentoTableName('catalog_product_entity_' . $attributo->backend_type) .
		" WHERE
			entity_type_id = 4 AND
			attribute_id = :attribute_id AND
			store_id  = :store_id AND 
			entity_id = :entity_id "
		, array(
			"attribute_id" => $attributo->attribute_id ,
			"store_id" => 0 ,
			"entity_id" => $product_id 
		)
	) ->fetchObject(); 

	try{
		return $attributo_val->value ;
	}catch(Exception $e){
		return null ;
	}
}
function setAttributeValue($attribute_name, $attribute_value, $product_id){
	// la chiave primaria è entity_id, attribute_id, store_id
	global $db ;
	$attributo = getAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$query = $db->prepare(
		"INSERT INTO "
			.getMagentoTableName('catalog_product_entity_'. $attributo->backend_type).
		" SET
			value = :value,
			entity_type_id = 4,
			entity_id = :entity_id,
			attribute_id = :attribute_id,
			store_id = :store_id
		ON DUPLICATE KEY UPDATE
			value = :value, entity_type_id = 4
	");
	$query->execute(array(
		'value' => $attribute_value,
		'attribute_id' => $attributo->attribute_id,
		'store_id' => 0 ,
		'entity_id' => $product_id
	));
	return true ;
}
function getAttibuteReff($attribute_name){
	global $db ;
	// entity_type_id = 2  clienti
	// entity_type_id = 3  categorie
	// entity_type_id = 4  prodotti
	return $db->query(
			"SELECT * FROM ". 
				getMagentoTableName('eav_attribute').
			" WHERE entity_type_id = 4 AND attribute_code=?", array($attribute_name))->fetchObject();
	
}
function getMagentoTableName($table) {
	$resource = Mage::getSingleton('core/resource');
	$name = $resource->getTableName($table);
	unset($resource);
	return $name;
}