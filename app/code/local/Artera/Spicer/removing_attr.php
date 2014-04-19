<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

//$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
//$setup->removeAttribute( 'catalog_product', 'categoria' );
//$setup->removeAttribute( 'catalog_product', 'fornitore' );
