<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);
$tabellaTier = getMagentoTableName('catalog_product_entity_tier_price') ;
$sqlDeleteTier = "delete from $tabellaTier where entity_id = :product_id" ;
$deleteTier = $db->prepare($sqlDeleteTier) ;

$prezzi_imposti = $db->fetchAll("SELECT * FROM ListinoAvery where codice_spicer is not null and codice_spicer <> '' order by codice_spicer") ;
foreach($prezzi_imposti as $prezzo_imposto){
	if (empty($prezzo_imposto['codice_spicer']))
		continue;
	$product_id = getIdBySku($prezzo_imposto['codice_spicer']) ;
	if (!$product_id)
		continue ;
	setAttributeValue("price", $prezzo_imposto['prezzo_listino'], $product_id) ;
	setAttributeValue("special_price", $prezzo_imposto['prezzo_minimo'], $product_id) ;
	
	//azzero i tier price
	$deleteTier->execute(array("product_id"=>$product_id));
// 	echo $prezzo_imposto['codice_spicer'] ."\n";
// 	break ;
}
function getIdBySku($sku){
	global $db ;
	return $db->fetchOne("
		SELECT
			entity_id
		FROM " 
		. getMagentoTableName('catalog_product_entity') . 
		" where sku = :sku
	",array("sku"=>$sku)) ;
}
function getProductIdByAttributeValue($attribute_name,$attribute_value){
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
			value = :value "
		, array(
			"attribute_id" => $attributo->attribute_id ,
			"store_id" => 0 ,
			"value" => $attribute_value 
		)
	) ->fetchObject(); 

	try{
		return $attributo_val->entity_id ;
	}catch(Exception $e){
		return null ;
	}
}
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