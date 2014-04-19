<?php
class Table {
	protected $resource ;
	protected $db ;
	public function __construct(){
		$this->resource = Mage::getSingleton('core/resource');
		$this->db = $this->resource->getConnection('core_write'); 
	}
	public function getMagentoTableName($table) {
		$name = $this->resource->getTableName($table);
		return $name;
	}
}  
