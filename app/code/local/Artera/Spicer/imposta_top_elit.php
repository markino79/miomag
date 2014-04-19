<?php
require_once('../../../../../app/Mage.php');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);

$file = Mage::getBaseDir('var') . DS . "Top_100.csv" ;
$handle = fopen($file, "r");
if ($handle) {
	while ($data = fgetcsv($handle, 0, "|","\"")) {
		$productId = $db->fetchOne("select entity_id from catalog_product_entity where sku = :sku",
					array('sku' => $data[0])) ;
		if (!empty($productId)){
			if ($data[1] == 'OUT'){
				$db->query("delete from catalog_category_product where category_id = 189 and product_id = :product_id ",
					array('product_id' => $productId )) ;
				echo "eliminato \n" ;
			}else{
				try{
					$db->query("insert into catalog_category_product values(189,:product_id,0)",array('product_id' => $productId )) ;
					echo "inserito \n" ;
				}catch(Exception $e){
					echo "già presente \n" ;
				}
				
			}
		}
	}
}
