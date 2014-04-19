<?php

class Artera_Spicer_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup{
	/**
	* @return Array
	*/
	public function getDefaultEntities(){
		return array(
			'catalog_product' => array(
				'entity_model' => 'catalog/product',
				'attribute_model' => 'catalog/resource_eav_attribute' ,
				'table' => 'catalog/product' ,
				'additional_attribute_table' => 'catalog/eav_attribute', /* dalla 1.4 in poi altrimenti non verranno mostrati nel back office*/
                'entity_attribute_collection' => 'catalog/product_attribute_collection', /* dalla 1.4 in poi altrimenti non verranno mostrati nel back office*/	
				'attributes' => array(
					'codice_ean' => array(
						'group' 			=> 'General' , 
						'type' 				=> 'varchar' ,
						'label' 			=> 'codice ean' ,
						'input' 			=> 'text' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => true,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'codice_originale' => array(
						'group' 			=> 'General' , 
						'type' 				=> 'varchar' ,
						'label' 			=> 'codice originale' ,
						'input' 			=> 'text' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => true,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'categoria' => array(
						'group' 			=> 'General' , 
						'type' 				=> 'varchar' ,
						'label' 			=> 'cetegoria per ricerca' ,
						'input' 			=> 'text' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => true,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'marchio' => array(
						'group' 			=> 'General' , 
						'type' 				=> 'int' ,
						'label' 			=> 'Marchio' ,
						'input' 			=> 'select' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => true,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'fornitore' => array(
						'group' 			=> 'General' , 
						'type' 				=> 'int' ,
						'label' 			=> 'Fornitore' ,
						'input' 			=> 'select' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'old_special_price' => array(
						'group' 			=> 'Prices' , 
						'type' 				=> 'decimal' ,
						'label' 			=> 'old special price' ,
						'input' 			=> 'text' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					)
				)
			),
			'catalog_category'               => array(
				'entity_model'                   => 'catalog/category',
				'attribute_model'                => 'catalog/resource_eav_attribute',
				'table'                          => 'catalog/category',
				'additional_attribute_table'     => 'catalog/eav_attribute',
				'entity_attribute_collection'    => 'catalog/category_attribute_collection',
				'default_group'                  => 'General Information',
				'attributes'                     => array(
					'codice_spicer'            		  => array(
						'type'                       => 'varchar',
						'label'                      => 'Codice categoira spicer',
						'input'                      => 'text',
						'required'                   => false,
						'visible'                    => true,
						'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
						'group'                      => 'General Information',
					),
					'ricarico'            		  => array(
						'type'                       => 'decimal',
						'label'                      => 'ricarico',
						'class'						 => 'validate-number' ,
						'input'                      => 'text',
						'required'                   => false,
						'visible'                    => true,
						'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
						'group'                      => 'General Information',
					),
			),
		)
	);
	
	}
}
 
