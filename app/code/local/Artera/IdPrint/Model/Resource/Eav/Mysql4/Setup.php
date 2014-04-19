<?php
class Artera_IdPrint_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup{
	/**
	 *  @return Array
	 */
	public function getDefaultEntities(){
		/* un buon esempio è in app/code/core/Mage/Catalog/Model/Resource/Eav/Mysql4/Setup.php 
		 
		 	class	 	Validation class for data. Example values: validate-digits, validate-number
			backend	 	Model for handling input in the backend (eg customer/customer_attribute_backend_password)
			frontend	Model for handling display of attribute on the frontend (eg catalog/product_attribute_frontend_image)
			source	 	Model defining values for select boxes/dropdowns (see below)

		 */
		return array(
			'catalog_product' => array(
				'entity_model' => 'catalog/product',
				'attribute_model' => 'catalog/resource_eav_attribute' ,
				'table' => 'catalog/product' ,
				'additional_attribute_table' => 'catalog/eav_attribute', /* dalla 1.4 in poi altrimenti non verranno mostrati nel back office*/
                'entity_attribute_collection' => 'catalog/product_attribute_collection', /* dalla 1.4 in poi altrimenti non verranno mostrati nel back office*/	
				'attributes' => array(
					'resa_pagine' => array(
						'group' 			=> 'General' , /* la tab dove lo si vuole vedere visualizzato nel beckend  */
						'type' 				=> 'varchar' ,
						'label' 			=> 'numero pagine' ,
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
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'visible_in_advanced_search' => false,
                        'unique'            => false 
					),
					'idprint_description' => array(
						'group' 			=> 'General' , /* la tab dove lo si vuole vedere visualizzato nel beckend  */
						'type' 				=> 'text' ,
						'label' 			=> 'Descrizione idprint' ,
						'input' 			=> 'textarea' ,
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
					'caramelle' => array(
						'group' 			=> 'General' , /* la tab dove lo si vuole vedere visualizzato nel beckend  */
						'type' 				=> 'int' ,
						'label' 			=> 'tipo caramella' ,
						'input' 			=> 'select' ,
						'default' 			=> '' ,
						'class' 			=> '' ,
						'backend' 			=> '' ,
						'frontend' 			=> '' ,
						'source'            => 'idprint/product_attribute_source_caramelle',
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
					)
				)
			),
			// qui è possibile definire attributi per un altra entità
		);
	}
}