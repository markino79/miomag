<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR ."Entity.class.php") ;

class Product extends Entity{
	public function __construct(){
		$this->entity_code = "catalog_product" ;
		parent::__construct() ;
	}
	public function loadBySku($sku){
		$db = $this->db ;
		$this->entity_id = $db->fetchOne(
			"SELECT entity_id FROM "
			. $this->getMagentoTableName($this->entity_table) .
			" where sku = :sku" ,
			array(
				"sku" => $sku 
			)
		) ;
		return $this->entity_id ;
	}
	public function removeAllCategoryIds(){
		if (!$this->entity_id)
				return false ;
		$db = $this->db ;
		$db->query(
			"delete from "
			. $this->getMagentoTableName('catalog_category_product') 
			." where product_id = :product_id " ,
			array('product_id' => $this->entity_id) 
		) ;
	}
	public function setCategoryIds($categories = array()){
		if (!$this->entity_id)
				return false ;
		$db = $this->db ;
		foreach($categories as $category){
			$data = array('category_id' => $category,'product_id' => $this->entity_id , 'position' => 1) ;
			try{
				$db->insert($this->getMagentoTableName('catalog_category_product'), $data);
			}catch(Exception $e){}
		}
	}
	/**
		le immagini vanno messe nella cartella /media/catalog/product 
		meglio se in una cartella di propria scelta (esempio mia_cartella)
		$file conterrà la stringa "/mia_cartella/mio_file.jpg"
		gli attributi media sono array('small_image', 'thumbnail', 'image')
	*/
	function addImageToMediaGallery($file, $mediaAttribute=null,  $exclude=true){
		if (!$this->entity_id)
			return false ;
		$db = $this->db ;
		$attributo = $this->getAttibuteReff('media_gallery') ;
		if (!$attributo){
			return false ;
		}
		$file_path = Mage::getBaseDir("media") . "/catalog/product" . $file ;
		if (!file_exists($file_path)){
			return false ;
		}
		$data = array('attribute_id' => $attributo->attribute_id, 'entity_id' => $this->entity_id, 'value' => $file ); 
		$value_id = $db->fetchOne(
			"select value_id from " 
			. $this->getMagentoTableName('catalog_product_entity_media_gallery')
			." where attribute_id = :attribute_id and entity_id = :entity_id and value = :value"
			,$data) ;
		if (!$value_id){
			$db->insert($this->getMagentoTableName('catalog_product_entity_media_gallery'), $data);
			$value_id = $db->lastInsertId() ;
			$data2 = array('value_id' => $value_id, 'store_id' => $this->store_id, 'label' => null ,'position' => null ,'disabled' => ($exclude)?1:0 ); 
			$db->insert($this->getMagentoTableName('catalog_product_entity_media_gallery_value'), $data2);
		}
		if ($mediaAttribute){
			foreach($mediaAttribute as $attributo){
				$this->setAttributeValue($attributo,$file) ;
			}
		}
		return true ;
	}
	function removeProductImages(){
		if (!$this->entity_id)
			return false ;
		$db = $this->db ;
		$attributo = $this->getAttibuteReff('media_gallery') ;
		if (!$attributo){
			return false ;
		}
		$data = array('attribute_id' => $attributo->attribute_id, 'entity_id' => $this->entity_id) ;
		$db->query(
			"delete from "
			. $this->getMagentoTableName('catalog_product_entity_media_gallery')
			." where attribute_id = :attribute_id and entity_id = :entity_id "
		,$data) ;
		$mediaAttribute = array('small_image', 'thumbnail', 'image') ;
		foreach($mediaAttribute as $attributo){
			$this->setAttributeValue($attributo,'no_selection') ;
		}
		return true ;
	}
} 
