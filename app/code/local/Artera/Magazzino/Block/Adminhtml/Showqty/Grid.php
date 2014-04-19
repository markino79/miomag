<?php
class Artera_Magazzino_Block_Adminhtml_Showqty_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	public function __construct(){
		parent::__construct();
		$this->setId('selectproductGrid');
		// imposto l'ordinamento di defaulto per la grid
		$this->setDefaultSort('tipo');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(false);
		// dico di mostrarmi i totali in fondo alla Grid
		$this->setCountTotals(true);
		// se voglio impostare la collection nella Grid lo faccio qui
		$movimenti = Mage::getModel("magazzino/movimenti");
		$this->setCollection($movimenti->getMovimentiAggregati());
	}
	/*
	 * Imposto i totali per la GRid
	 * il metodo è un po' colorito ma per il momento è il migliore che ho trovato
	 */
	public function getCountTotals(){
		if (!$this->getTotals()) {
			$totale = 0 ;
			$collection = $this->getCollection() ;
			$select = $collection->getSelect()->limit(0)->__toString() ;
			$db = $collection->getConnection() ;
			$rows = $db->fetchAll($select) ;
			foreach ($rows as $row){
				$totale += $row['qta'] ;
			}	
			
			$totals = new Varien_Object() ;
			$totals->setNumero("totali") ;
			$totals->setQta($totale) ;
			$this->setTotals($totals);
		}
		return parent::getCountTotals();
	}
	protected function _prepareColumns(){
		$this->addColumn('ncarama', array(
				'header'    => Mage::helper('magazzino')->__('numero caremelle'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'numero',
		));
		$this->addColumn('nomic', array(
				'header'    => Mage::helper('magazzino')->__('nomi caramelle'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'caramelle',
		));
		$this->addColumn('tipo', array(
				'header'    => Mage::helper('magazzino')->__('tipo'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'tipo',
		));
		$this->addColumn('qta', array(
				'header'    => Mage::helper('magazzino')->__('qta'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'qta',
				'filter'	=> false,
      			'sortable'  => false,
		));
		
		return parent::_prepareColumns();
	}
	public function getRowUrl($row){
		return null ;
	}
}