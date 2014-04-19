<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Table.class.php") ;

class Attribute extends Table {
	protected $entity_type_id ;
	protected $attribute_table ;
	protected $attribute_option_table ;
	protected $attribute_option_value_table ;
	protected $entity_table ;
	protected $entity_id ;
	protected $store_id ;
	public function __construct(){
		parent::__construct() ;
		$this->attribute_table = $this->getMagentoTableName('eav_attribute') ;
		$this->attribute_option_table = $this->getMagentoTableName('eav_attribute_option');
		$this->attribute_option_value_table = $this->getMagentoTableName('eav_attribute_option_value') ;
	}
	public function setStoreId($store_id){
		$this->store_id = $store_id ;
	}
	public function setAttributeOptionValue($attribute_name, $attribute_value , $value_vetrine = array()){
		if (!$this->entity_id)
			return false ;
		$attributo = $this->getAttibuteReff($attribute_name) ;
		if (!$attributo){
			return false ;
		}
		$db  = $this->db ;
		$option_value = $db->fetchOne(
			"SELECT eao.option_id FROM "  
				. $this->attribute_option_table . " eao "
			." left join " 
				. $this->attribute_option_value_table .  " eaov "  
			." on eao.`option_id` =  eaov.`option_id` "
			." WHERE eao.attribute_id = :attributo and eaov.value = :value and store_id = 0"
			." limit 1"
		,array('attributo'=>$attributo->attribute_id,'value'=> $attribute_value));
		if (!$option_value){
			$data = array('attribute_id' => $attributo->attribute_id, 'sort_order' => 0, ); 
			$db->insert( $this->attribute_option_table, $data);
			$option_value = $db->lastInsertId() ;
			$data = array('option_id' => $option_value, 'store_id' => 0, 'value' => $attribute_value); 
			$db->insert($this->attribute_option_value_table, $data);
			foreach($value_vetrine as $store=>$valore){
				$data = array('option_id' => $option_value, 'store_id' => $store, 'value' => $valore); 
				$db->insert($this->attribute_option_value_table, $data);
			}
		}	
		$this->setAttributeValue($attribute_name, $option_value) ;
	}
	protected function getAttibuteReff($attribute_name){
		$db  = $this->db ;
		return $db->query(
				"SELECT * FROM "
				.  $this->attribute_table
				. " WHERE entity_type_id = :entity_type_id AND attribute_code=:attribute_code", 
				array(
				'entity_type_id'=>$this->entity_type_id ,
				'attribute_code'=>$attribute_name
				)
			)->fetchObject();
	
	}
	protected function getAttributeValue($attribute_name){
		if (!$this->entity_id)
			return false ;
		$db = $this->db ;
		$attributo = $this->getAttibuteReff($attribute_name) ;
		if (!$attributo){
			return false ;
		}
		if ($attributo->backend_type != "static") {
			try{
				$attributo_val = $db->query("
					SELECT
						value
					FROM "
						. $this->getMagentoTableName($this->entity_table . '_' . $attributo->backend_type) .
					" WHERE
						entity_type_id = :entity_type_id AND
						attribute_id = :attribute_id AND
						store_id  = :store_id AND 
						entity_id = :entity_id "
					, array(
						"entity_type_id" => $this->entity_type_id ,
						"attribute_id" => $attributo->attribute_id ,
						"store_id" => $this->store_id ,
						"entity_id" => $this->entity_id
					)
				) ->fetchObject(); 
				return $attributo_val->value ;
			}catch(Exception $e){
				return false ;
			}
		}else{
			try{
				return $db->fetchOne(
					"select " . $attribute_name . " from "
					. $this->getMagentoTableName($this->entity_table) 
					. " where entity_id = :entity_id "
					, array("entity_id" => $this->entity_id)
				) ;
			}catch(Exception $e){
				return false ;
			}
		}
	}
	protected function setAttributeValue($attribute_name, $attribute_value){
		if (!$this->entity_id)
			return false ;
		// la chiave primaria è entity_id, attribute_id, store_id
		$db = $this->db ;
		$attributo = $this->getAttibuteReff($attribute_name) ;
		if (!$attributo){
			return false ;
		}
		if ($attributo->backend_type != "static") {
			$query = $db->prepare(
				"INSERT INTO "
					. $this->getMagentoTableName($this->entity_table . '_' . $attributo->backend_type).
				" SET
					value = :value,
					entity_type_id = :entity_type_id,
					entity_id = :entity_id,
					attribute_id = :attribute_id,
					store_id = :store_id
				ON DUPLICATE KEY UPDATE
					value = :value, entity_type_id = :entity_type_id
			");
			$query->execute(array(
				'value' => $attribute_value,
				'entity_type_id' => $this->entity_type_id ,
				'attribute_id' => $attributo->attribute_id,
				'store_id' => $this->store_id  ,
				'entity_id' => $this->entity_id
			));
		}else{
			$db->query(
				"update " 
				. $this->getMagentoTableName($this->entity_table) 
				. " set " . $attribute_name . " = :attribute_value "
				. " where entity_id = :entity_id "
					, array(
					"attribute_value" => $attribute_value ,
					"entity_id" => $this->entity_id
					)
			) ;
		}
		return $attribute_value ;
	}
	public function __set($attribute_name , $attribute_value){
		$this->setAttributeValue($attribute_name, $attribute_value) ;
	}
	public function __get($attribute_name){
		return $this->getAttributeValue($attribute_name) ;
	}
} 
