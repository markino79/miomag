<?php
require_once('../../../../../app/Mage.php');
//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

for ($index = 1; $index <= 9; $index++) {  
	$process = Mage::getModel('index/process')->load($index);  
	$process->setMode(Mage_Index_Model_Process::MODE_MANUAL);
	$process->save() ;
	$process->clearInstance() ;
	unset($process) ;
}
