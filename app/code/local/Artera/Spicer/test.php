<?php
require_once('../../../../../app/Mage.php');
//require_once('_product_function.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->setFetchMode(Zend_Db::FETCH_ASSOC);

$spicerCatalog = Mage::getModel("spicer/Spicercatalogo");
echo $spicerCatalog->getFtpFile();
