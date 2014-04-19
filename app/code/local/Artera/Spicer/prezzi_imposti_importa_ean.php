<?php
require_once('../../../../../app/Mage.php');
Mage::app();

Mage::getSingleton('core/session', array('name'=>'frontend'));

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 

$file = Mage::getBaseDir('var') . DS . "ean_prezzi_imposti.csv" ;
$handle = fopen($file, "r");
$i = 0 ;
$sqlInsert = <<<EOMYSQL
	INSERT INTO `ean_prezzi_imposti`(`ean`, `prezzo`,`descrizione`) VALUES (:ean,:prezzo,:descrizione) ;
EOMYSQL;
$insert = $db->prepare($sqlInsert) ;
if ($handle) {
	while ($data = fgetcsv($handle, 0, "|")) {
		$i++ ;
		$insert->execute(array(
			"ean" => $data[1] ,
			"prezzo" =>  round(0 + str_replace(",",".",$data[0]),2) ,
			"descrizione" => $data[2] ,
		));
	}
	fclose($file);
}