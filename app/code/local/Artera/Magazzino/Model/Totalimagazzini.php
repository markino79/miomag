<?php
class Artera_Magazzino_Model_Totalimagazzini extends Mage_Core_Model_Abstract{
	public function _construct() {
		parent::_construct();
		$this->_init('magazzino/totalimagazzini');
	}
	public function aggiungi($product_id,$id_magazzino,$qta) {
		$this->aggiornaTotali($product_id,$id_magazzino,$qta) ;
	}
	public function sottrai($product_id,$id_magazzino,$qta){
		$this->aggiornaTotali($product_id,$id_magazzino,$qta*-1) ;
	}
	protected function aggiornaTotali($product_id,$id_magazzino,$qta){
	
		if ($total_id = $this->getIdFromProductMag($product_id,$id_magazzino)){
			$this->load($total_id) ;
			$this->qta = $this->qta + $qta ;
		}else{
			$this->product_id = $product_id ;
			$this->id_magazzino = $id_magazzino ;
			$this->qta = $qta ;
		}
		$this->save() ;
	}
	private function getIdFromProductMag($product,$mag){
		$c = $this->getCollection() ;
		$c->getSelect()
		->where('main_table.id_magazzino = ?' , $mag ) 
		->where('main_table.product_id = ?' , $product ) ;
		foreach ($c as $i){
			return $i['id'] ;
		}
		return null ;
	}
}