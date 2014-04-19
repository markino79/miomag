<?php
/**
	Condivisi
*/
function getMagentoTableName($table) {
	$resource = Mage::getSingleton('core/resource');
	$name = $resource->getTableName($table);
	unset($resource);
	return $name;
}
/**
	Prodotti
*/
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

function setAttributeOptionValue($attribute_name, $attribute_value, $product_id){
	global $db ;
	$attributo = getAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$option_value = $db->fetchOne(
		"SELECT eao.option_id FROM "  
			. getMagentoTableName('eav_attribute_option') . " eao "
		." left join " 
			. getMagentoTableName('eav_attribute_option_value') .  " eaov "  
		." on eao.`option_id` =  eaov.`option_id` "
		." WHERE eao.attribute_id = :attributo and eaov.value = :value "
		." limit 1"
	,array('attributo'=>$attributo->attribute_id,'value'=> $attribute_value));
	if ($option_value){
		setAttributeValue($attribute_name, $option_value, $product_id) ;
	}else{
		$data = array('attribute_id' => $attributo->attribute_id, 'sort_order' => 0, ); 
		$db->insert(getMagentoTableName('eav_attribute_option'), $data);
		$option_value = $db->lastInsertId() ;
		$data = array('option_id' => $option_value, 'store_id' => 0, 'value' => $attribute_value); 
		$db->insert(getMagentoTableName('eav_attribute_option_value'), $data);
		$data = array('option_id' => $option_value, 'store_id' => 1, 'value' => $attribute_value); 
		$db->insert(getMagentoTableName('eav_attribute_option_value'), $data);
		setAttributeValue($attribute_name, $option_value, $product_id) ;
	}	
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
			value = :value limit 1 "
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
function removeCategoryIds($product_id){
	global $db ;
	$db->query(
		"delete from "
		.getMagentoTableName('catalog_category_product') 
		." where product_id = :product_id " ,
		array('product_id' => $product_id) 
	) ;
}
function setCategoryIds($product_id,$categories = array()){
	global $db ;
	foreach($categories as $category){
		$data = array('category_id' => $category,'product_id' => $product_id , 'position' => 1) ;
		try{
			$db->insert(getMagentoTableName('catalog_category_product'), $data);
		}catch(Exception $e){}
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
		if ($attributo_val)
			return $attributo_val->value ;
		else
			return null;
	}catch(Exception $e){
		return null ;
	}
}
function setAttributeValue($attribute_name, $attribute_value, $product_id , $store_id = 0){
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
		'store_id' => $store_id ,
		'entity_id' => $product_id
	));
	return true ;
}
/**
	immagini
*/
function removeProductImages($product_id){
	global $db ;
	$attributo = getAttibuteReff('media_gallery') ;
	if (!$attributo){
		return false ;
	}
	$data = array('attribute_id' => $attributo->attribute_id, 'entity_id' => $product_id) ;
	$db->query(
		"delete from "
		. getMagentoTableName('catalog_product_entity_media_gallery')
		." where attribute_id = :attribute_id and entity_id = :entity_id "
	,$data) ;
	$mediaAttribute = array('small_image', 'thumbnail', 'image') ;
	foreach($mediaAttribute as $attributo){
		setAttributeValue($attributo,'no_selection',$product_id) ;
	}
	
}
function addImageToMediaGallery($product_id,$file, $mediaAttribute=null,  $exclude=true){
	global $db ;
	$attributo = getAttibuteReff('media_gallery') ;
	if (!$attributo){
		return false ;
	}
	$data = array('attribute_id' => $attributo->attribute_id, 'entity_id' => $product_id, 'value' => $file ); 
	$value_id = $db->fetchOne(
		"select value_id from " 
		. getMagentoTableName('catalog_product_entity_media_gallery')
		." where attribute_id = :attribute_id and entity_id = :entity_id and value = :value"
		,$data) ;
	if (!$value_id){
		$db->insert(getMagentoTableName('catalog_product_entity_media_gallery'), $data);
		$value_id = $db->lastInsertId() ;
		$data2 = array('value_id' => $value_id, 'store_id' => 0, 'label' => null ,'position' => null ,'disabled' => ($exclude)?1:0 ); 
		$db->insert(getMagentoTableName('catalog_product_entity_media_gallery_value'), $data2);
	}
	if ($mediaAttribute){
		foreach($mediaAttribute as $attributo){
			setAttributeValue($attributo,$file,$product_id) ;
		}
	}
}

/**
	Categorie
*/
function getCategoryAttibuteReff($attribute_name){
	global $db ;
	// entity_type_id = 2  clienti
	// entity_type_id = 3  categorie
	// entity_type_id = 4  prodotti
	return $db->query(
			"SELECT * FROM ". 
				getMagentoTableName('eav_attribute').
			" WHERE entity_type_id = 3 AND attribute_code=?", array($attribute_name))->fetchObject();
	
}
function getCategoryIdByAttributeValue($attribute_name,$attribute_value){
	global $db ;
	$attributo = getCategoryAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$attributo_val = $db->query("
		SELECT
			*
		FROM "
			. getMagentoTableName('catalog_category_entity_' . $attributo->backend_type) .
		" WHERE
			entity_type_id = 3 AND
			attribute_id = :attribute_id AND
			store_id  = :store_id AND 
			value = :value limit 1 "
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
function getCategoryAttributeValue($attribute_name ,$category_id){
	global $db ;
	$attributo = getCategoryAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$attributo_val = $db->query("
		SELECT
			*
		FROM "
			. getMagentoTableName('catalog_category_entity_' . $attributo->backend_type) .
		" WHERE
			entity_type_id = 3 AND
			attribute_id = :attribute_id AND
			store_id  = :store_id AND 
			entity_id = :entity_id "
		, array(
			"attribute_id" => $attributo->attribute_id ,
			"store_id" => 0 ,
			"entity_id" => $category_id 
		)
	) ->fetchObject(); 

	try{
		return $attributo_val->value ;
	}catch(Exception $e){
		return null ;
	}
}
function setCategoryAttributeValue($attribute_name, $attribute_value, $category_id){
	// la chiave primaria è entity_id, attribute_id, store_id
	global $db ;
	$attributo = getCategoryAttibuteReff($attribute_name) ;
	if (!$attributo){
		return false ;
	}
	$query = $db->prepare(
		"INSERT INTO "
			.getMagentoTableName('catalog_category_entity_'. $attributo->backend_type).
		" SET
			value = :value,
			entity_type_id = 3,
			entity_id = :entity_id,
			attribute_id = :attribute_id,
			store_id = :store_id
		ON DUPLICATE KEY UPDATE
			value = :value, entity_type_id = 3
	");
	$query->execute(array(
		'value' => $attribute_value,
		'attribute_id' => $attributo->attribute_id,
		'store_id' => 0 ,
		'entity_id' => $category_id
	));
	return true ;
}