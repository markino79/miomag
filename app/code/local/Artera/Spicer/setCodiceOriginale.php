<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$spicer = Mage::helper("spicer") ;

$spicer->setCodiceOriginale() ;

