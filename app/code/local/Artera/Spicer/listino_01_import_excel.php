<?php
require_once('../../../../../app/Mage.php');

//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
require_once(Mage::getBaseDir('lib') . DS . 'Excel/reader.php') ;

$file = Mage::getBaseDir('var') . DS . "SpicerFile.xls" ;

$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
echo "pulisco file di lavoro \n" ;
$db->query('delete from spicer') ;
unset($db) ;
mb_detect_order("UTF-8,ISO-8859-1") ;
$data = new Spreadsheet_Excel_Reader();
//$data->setOutputEncoding('CP1251');
$data->setOutputEncoding('UTF-8');
$data->read($file);

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
	
	$spicer = Mage::getModel("spicer/spicer") ;
	
	$spicer->setCodiceArticolo("".getCellValue($i,1)."") ;
	
	$DescrizioneOscarnet = "".getCellValue($i,2)."" ;
	if (mb_detect_encoding($DescrizioneOscarnet)!='UTF-8'){
		$spicer->setDescrizioneOscarnet(utf8_encode($DescrizioneOscarnet)) ;
	}else{
		$spicer->setDescrizioneOscarnet($DescrizioneOscarnet) ;
	}
	
	$spicer->setRiferimentoOriginale("".getCellValue($i,3)."") ;
	
	$marchio = "".getCellValue($i,4)."" ;
	if (mb_detect_encoding($marchio)!='UTF-8'){
		$spicer->setMarchio(utf8_encode($marchio)) ;
	}else{
		$spicer->setMarchio($marchio) ;
	}
	$spicer->setCodiceCategoria("".getCellValue($i,5)."") ;
	
	$categoria = "".getCellValue($i,6)."" ;
	if (mb_detect_encoding($categoria)!='UTF-8'){
		$spicer->setCategoria(utf8_encode($categoria)) ;
	}else{
		$spicer->setCategoria($categoria) ;
	}
	
	$spicer->setCodiceGruppo("".getCellValue($i,7)."") ;
	
	
	$gruppo = "".getCellValue($i,8)."" ;
	if (mb_detect_encoding($gruppo)!='UTF-8'){
		$spicer->setGruppo(utf8_encode($gruppo)) ;
	}else{
		$spicer->setGruppo($gruppo) ;
	}
	$spicer->setPrezzoFasciaListino("".getCellValue($i,9)."") ;
	$spicer->setPrezzoPromo("".getCellValue($i,10)."") ;
	$spicer->setDataInizioPromo("".getCellValue($i,11)."") ;
	$spicer->setDataFinePromo("".getCellValue($i,12)."") ;
	$spicer->setVariazionePrezzo("".getCellValue($i,13)."") ;
	$spicer->setVariazioneQta("".getCellValue($i,14)."") ;
	$spicer->setEliminato("".getCellValue($i,15)."") ;
	
	$spicer->save() ;
	unset($spicer) ;
	$rins = $i -1 ;
	echo "Importati $rins records nel file di lavoro \r" ;
}
echo "\n" ;
unset($data) ;
function getCellValue($row,$col){
	global $data;
	if (isset($data->sheets[0]['cells'][$row]) && isset($data->sheets[0]['cells'][$row][$col]))
		return $data->sheets[0]['cells'][$row][$col];
	else
		return "";
}