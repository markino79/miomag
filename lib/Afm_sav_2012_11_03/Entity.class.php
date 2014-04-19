<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Attribute.class.php") ;

class Entity extends Attribute {
	protected $entity_code ;
	public function __construct(){
		parent::__construct() ;
		$db = $this->db ;
		$this->entity_type_id = $db->fetchOne(
			"select entity_type_id from "
			. $this->getMagentoTableName("eav_entity_type")
			. " where entity_type_code = :entity_type_code "
			, array("entity_type_code" => $this->entity_code)
		) ;
		$this->entity_table = $this->entity_code . "_entity";
		$this->store_id = 0;
	}
	public function loadById($entity_id){
		$db = $this->db ;
		$this->entity_id = $db->fetchOne(
			"SELECT entity_id FROM "
			. $this->getMagentoTableName($this->entity_table) .
			" where entity_id = :entity_id" ,
			array(
				"entity_id" => $entity_id 
			)
		) ;
		return $this->entity_id ;
	}
	public function getId(){
		return $this->entity_id ;
	}
	public function getIdByAttributeValue($attribute_name,$attribute_value){ 
		$db = $this->db ;
		$attributo = $this->getAttibuteReff($attribute_name) ;
		if (!$attributo){
			return false ;
		}
		$attributo_val = $db->query("
			SELECT
				*
			FROM "
				. $this->getMagentoTableName($this->entity_table . '_' . $attributo->backend_type) .
			" WHERE
				entity_type_id = :entity_type_id AND
				attribute_id = :attribute_id AND
				store_id  = :store_id AND 
				value = :value limit 1 "
			, array(
				"entity_type_id" => $this->entity_type_id , 
				"attribute_id" => $attributo->attribute_id ,
				"store_id" => $this->store_id ,
				"value" => $attribute_value 
			)
		) ->fetchObject(); 

		try{
			return $attributo_val->entity_id ;
		}catch(Exception $e){
			return null ;
		}
	}
} 
