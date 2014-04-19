<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$productCollection = Mage::getModel("catalog/product")->getCollection() ;
$productIds = $productCollection->getAllIds() ;
$productCollection->clear() ;
$count = 0 ;
foreach($productIds as $productId){
	$count++ ;
	$productModel = Mage::getModel("catalog/product")->load($productId) ;
	if ($productModel->getSku()){
		$categoryIds = $productModel->getCategoryIds() ;
		foreach($categoryIds as $k=> $categoryId){
			$categoryModel = Mage::getModel("catalog/category")->load($categoryId) ;
			if ($categoryModel->getname()){
					$productModel->setCategoria($categoryModel->getname()) ;
					$productModel->save() ;
					echo $count . " " .  $productModel->getSku() . " " . $categoryModel->getname() . " " . memory_get_usage() .  "\n" ;
			}
			$categoryModel->clearInstance() ;
			unset($categoryModel) ;
			break ;
		}
 	}
	$productModel->clearInstance() ;
	unset($productModel) ;
}
