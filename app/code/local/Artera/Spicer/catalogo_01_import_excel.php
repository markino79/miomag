<?php
require_once('../../../../../app/Mage.php');

//SETTAGGI MAGENTO
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
require_once(Mage::getBaseDir('lib') . DS . 'Excel/reader.php') ;

ini_set("memory_limit","256M"); 
ini_set("max_execution_time","0"); 
echo "pulisco il file di lavoro\n" ;
$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
$db->query('delete from spicercatalogo') ;
unset($db) ;
$file = Mage::getBaseDir('var') . DS . "SpicerCatalog.xls" ;
$data = new Spreadsheet_Excel_Reader($file);
$data->setOutputEncoding('UTF-8');
$data->read($file);
$numeroRighe = $data->sheets[0]['numRows'] ;
$count = 0 ;
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
	$count++ ;
	
	mb_detect_order("UTF-8,ISO-8859-1") ;
	if (trim($data->sheets[0]['cells'][$i][1]) == "")
		break ;
	$spicercatalog = Mage::getModel("spicer/spicercatalogo") ;
	//$spicercatalog->setModificato("".$data->sheets[0]['cells'][$i][3]."") ;
	$spicercatalog->setCodiceSpicer("".$data->sheets[0]['cells'][$i][1]."") ;
	$spicercatalog->setRiferimentoOriginale("".$data->sheets[0]['cells'][$i][2]."") ;
	$spicercatalog->setNuovo("".$data->sheets[0]['cells'][$i][3]."") ;
	$spicercatalog->setStampaLogoNovita("".$data->sheets[0]['cells'][$i][4]."") ;
	$spicercatalog->setPagCatStandard("".$data->sheets[0]['cells'][$i][5]."") ;
	$spicercatalog->setLetCatStandard("".$data->sheets[0]['cells'][$i][6]."") ;
	$spicercatalog->setCodiceCategoria("".$data->sheets[0]['cells'][$i][7]."");
	
	$nomeCategoria = $data->sheets[0]['cells'][$i][8] ;
	if (mb_detect_encoding($nomeCategoria)!='UTF-8'){
		$spicercatalog->setNomeCategoria(utf8_encode($nomeCategoria)) ;
	}else{
		$spicercatalog->setNomeCategoria($nomeCategoria) ;
	}
	
	$spicercatalog->setCodiceGruppo("".$data->sheets[0]['cells'][$i][9]."") ;
	
	$nomeGruppo = $data->sheets[0]['cells'][$i][10] ;
	if (mb_detect_encoding($nomeGruppo)!='UTF-8'){
		$spicercatalog->setNomeGruppo(utf8_encode($nomeGruppo)) ;
	}else{
		$spicercatalog->setNomeGruppo($nomeGruppo) ;
	}
	
	$spicercatalog->setCodiceSottogruppo("".$data->sheets[0]['cells'][$i][11]."") ;
	$spicercatalog->setNomeSottogruppo("".$data->sheets[0]['cells'][$i][12]."") ;
	$spicercatalog->setCodiceBrand("".$data->sheets[0]['cells'][$i][13]."") ;
	
	$nomeBrand = $data->sheets[0]['cells'][$i][14] ;
	if (mb_detect_encoding($nomeBrand)!='UTF-8'){
		$spicercatalog->setNomeBrand(utf8_encode($nomeBrand)) ;
	}else{
		$spicercatalog->setNomeBrand($nomeBrand) ;
	}
	
	$spicercatalog->setIdLoghi("".$data->sheets[0]['cells'][$i][15]."") ;
	$spicercatalog->setCodiceProdotto("".$data->sheets[0]['cells'][$i][16]."") ;
	
	
	$nomeProdotto = $data->sheets[0]['cells'][$i][17] ;
	if (mb_detect_encoding($nomeProdotto)!='UTF-8'){
		$spicercatalog->setNomeProdotto(utf8_encode($nomeProdotto)) ;
	}else{
		$spicercatalog->setNomeProdotto($nomeProdotto) ;
	}
	$spicercatalog->setUnitaVendita("".$data->sheets[0]['cells'][$i][18]."") ;
	$spicercatalog->setQtaXUnita("".$data->sheets[0]['cells'][$i][19]."") ;
	$descrizioneBreve = $data->sheets[0]['cells'][$i][20] ;
	if (mb_detect_encoding($descrizioneBreve)!='UTF-8'){
		$spicercatalog->setDescizioneBreve(utf8_encode($descrizioneBreve)) ;
	}else{
		$spicercatalog->setDescizioneBreve($descrizioneBreve) ;
	}
	$descrizioneEstesa = $data->sheets[0]['cells'][$i][21] ;
	if (mb_detect_encoding($descrizioneEstesa)!='UTF-8'){
		$spicercatalog->setDescizioneEstesa(utf8_encode($descrizioneEstesa)) ;
	}else{
		$spicercatalog->setDescizioneEstesa($descrizioneEstesa) ;
	}
	
	
	$spicercatalog->setImmagine("".$data->sheets[0]['cells'][$i][22]."") ;
	$spicercatalog->setPrezzoAlPubblico("".$data->sheets[0]['cells'][$i][23]."") ;
	// µ
	$elencoAttributi = $data->sheets[0]['cells'][$i][24] ; 
	if (mb_detect_encoding($elencoAttributi)!='UTF-8'){
		$spicercatalog->setElencoAttributi(utf8_encode($elencoAttributi)) ;
	}else{
		$spicercatalog->setElencoAttributi($elencoAttributi) ;
	}
	
	$spicercatalog->save() ;
	unset($spicercatalog) ;
	echo "importati " . $count . " records nel file di lavoro\r" ;
}
unset($data) ;
echo "\n" ;