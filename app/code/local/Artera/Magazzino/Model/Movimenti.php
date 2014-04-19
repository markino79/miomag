<?php

class Artera_Magazzino_Model_Movimenti extends Mage_Core_Model_Abstract{
    public function _construct() {
        parent::_construct();
        $this->_init('magazzino/movimenti');
    }
    public function carico($product_id,$id_magazzino,$qta,$note = ""){
    	$this->aggiungiMovimento($product_id,$id_magazzino,$qta,'+',$note) ;
    	
    	$totali = Mage::getModel('magazzino/totalimagazzini');
    	$totali->aggiungi($product_id,$id_magazzino,$qta)  ;
    }
	public function scarico($product_id,$id_magazzino,$qta,$note = ""){
    	$this->aggiungiMovimento($product_id,$id_magazzino,$qta,'-',$note) ;
    	
    	$totali = Mage::getModel('magazzino/totalimagazzini');
    	$totali->sottrai($product_id,$id_magazzino,$qta)  ;
    }
    protected function aggiungiMovimento($product_id,$id_magazzino,$qta,$segno,$note){
    	$user = Mage::getSingleton('admin/session')->getUser();
    	
    	$this->setId(null) ;
    	$this->setCreatedTime(now())->setUpdateTime(now());
    	$this->setUser($user->getFirstname() . " " .  $user->getLastname()) ;
    	$this->setProductId($product_id) ;
    	$this->setIdMagazzino($id_magazzino) ;
    	$this->setQta($qta) ;
    	$this->setSegno($segno) ;
    	$this->setNote($note) ;
    	$this->save() ;
		
    }
    public function getMovimentiAggregati(){
    	// preparo una nuova collezione personalizzata che sarà mostrata nella grid
    	// se voglio quella di default per il modello c'è già la funzione getCollection() ;
		$resource = Mage::getSingleton('core/resource');
		$db = $resource->getConnection('core_read'); 
      	// creo una mia collection personalizzata senza passare da un modello
		$collection = new Varien_Data_Collection_Db($db) ;    	
      	$sql = "(SELECT COUNT( * ) as numero, tipo, SUM( qta ) as qta, group_concat(distinct nome separator ',') as caramelle
				FROM  `caramelle` 
				GROUP BY tipo)" ;
      	// con l'opzione get select della collection_db posso impostare la query con zend_db
      	// uso new Zend_Db_Expr($sql) perchè ci sono problemi di paginazione con le group by
      	// con Zend_Db_Expr crea una sotto query e poi agisce su quella come fosse una tabella
      	// un po' pesante ma mi risolve i proplemi con le group by
      	// forse potrei usare una vista dovre ottenere lo stesso risultato
      	$collection->getSelect()->from(new Zend_Db_Expr($sql)) ;
      	return $collection ;
    }
} 
