<?php
require_once(Mage::getBaseDir('lib') . DS . 'Excel/reader.php') ;
class Artera_Spicer_Model_Spicercatalogo extends Mage_Core_Model_Abstract{
	protected $nomeTabella;
	protected $ftp_server = "ftp.spicers.net";
	protected $ftp_user_name = "5017688";
	protected $ftp_user_pass = "yooquafofo";
	protected $ftp_dir = "DB e-commerce 2012 aggiornamento Giugno";
	protected $ftp_file_name = "Spicers-DB_WEB_Cat2012_5017688_100x100 UFFICIO.xls";
	public function _construct(){
		parent::_construct() ;
		$this->_init('spicer/spicercatalogo');
		$this->nomeTabella = $this->getTableName();
	}
	protected function decode($s){
		mb_detect_order("UTF-8,ISO-8859-1") ;
		if (mb_detect_encoding($s)!='UTF-8'){
			return utf8_encode($s) ;
		}else{
			return $s;
		}
	}
	protected function getConnection(){
		$db = Mage::getSingleton('core/resource')->getConnection('core_write'); 
		$db->setFetchMode(Zend_Db::FETCH_ASSOC);
		RETURN $db;
	}
	protected function getTableName(){
		$r = $this->getResource();
		return $r->getMainTable();
	}
	public function getColumnNames(){
		$db = $this->getConnection();
		$nomeTabella = $this->nomeTabella;
		$dirtyFields = $db->query("SHOW COLUMNS FROM  `$nomeTabella`;");
		$fields = array();
		foreach($dirtyFields as $dirtyField)
			if ($dirtyField['Field'] != 'spicercatalogo_id')
				$fields[] = $dirtyField['Field'];
		return $fields;
	}
	protected function clear(){
		$db = $this->getConnection();
		$nomeTabella = $this->nomeTabella;
		$db->query("delete from $nomeTabella");
	}
	protected function getXLSFileName(){
		return $file = Mage::getBaseDir('var') . DS . "SpicerCatalog.xls";
	}
	public function importFromExcel(){
		ini_set("memory_limit","256M"); 
		ini_set("max_execution_time","0"); 
		echo "pulisco il file di lavoro\n";
		$this->clear();
		$data = new Spreadsheet_Excel_Reader($this->getXLSFileName());
		$data->setOutputEncoding('UTF-8');
		$data->read($file);
		$numeroRighe = $data->sheets[0]['numRows'];
		$count = 0;
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
			$count++ ;
			$valori = $data->sheets[0]['cells'][$i];
			if (trim($valori[1]) == "")
				break ;
			$nomi = $this->getColumnNames();
			$row = array_combine($nomi ,$valori);
			$spicercatalog = Mage::getModel("spicer/spicercatalogo") ;
			foreach ($row as $nome => $valore){
				$spicercatalog->setData($nome,$this->decode(""+$valore));
			}
			$spicercatalog->save() ;
			unset($spicercatalog) ;
			echo "importati " . $count . " records nel file di lavoro\r" ;
		}
		echo "\n" ;
	}
	public function getFtpFile(){
		$conn_id = ftp_connect($this->ftp_server); 
		$login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass);
		if ($login_result){
			ftp_chdir($conn_id, $this->ftp_dir);
			ftp_get($conn_id, $this->getXLSFileName(), $this->ftp_file_name, FTP_BINARY);
			ftp_close($conn_id);
		}else{
			echo "connessione non riuscita\n";
		}
	}
}
