<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$spicer = Mage::helper("spicer") ;

$file = Mage::getBaseDir('var') . DS . "100prodotti.csv" ;

$spicer->setSpecialPriceProduct($file) ;

