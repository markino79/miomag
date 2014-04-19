<?php

require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$file = Mage::getBaseDir('var') . DS . "eliminare.csv" ;
$handle = fopen($file, "r");
if ($handle) {
	while ($data = fgetcsv($handle, 0, ";","\"")) {
		
		$product_model = Mage::getModel("catalog/product") ;
		$product_id = $product_model->getIdBySku($data[0]) ;
		if ($product_model->getSku()){
			echo $data[0] . "\n" ;
			// 		Mage::register('isSecureArea', true);
			// 		$productModel->delete() ;
			// 		Mage::unregister('isSecureArea');
		}

	}
}