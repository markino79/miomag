<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$file = Mage::getBaseDir('var') . DS . "SpicersStock.csv" ;
$db = Mage::getSingleton('core/resource') ->getConnection('core_read');

$handle = fopen($file, "r");
if ($handle) {
	$update = $db->prepare("
		UPDATE
			cataloginventory_stock_item s_i,
			cataloginventory_stock_status s_s
		SET
			s_i.qty = :qty, s_i.is_in_stock = :is_in_stock,
			s_s.qty = :qty, s_s.stock_status = :is_in_stock
		WHERE
			s_i.product_id = :product_id AND s_i.product_id = s_s.product_id
	");
	while (!feof($handle)) {
		$line = fgets($handle) ;
		$line = str_replace(array("\n","\t","\r"),"",$line) ;
		$sku = substr($line,0,6);
		$qty = trim(substr($line,strrpos($line,' ')));
		
		$product_id = $db->fetchOne("SELECT entity_id FROM catalog_product_entity WHERE sku LIKE ?", array($sku));
		if (!empty($product_id)) {
			$update->execute(array(
				'qty' => $qty,
				'is_in_stock' => 1,
				'product_id' => $product_id
			));
		}
	}
}
