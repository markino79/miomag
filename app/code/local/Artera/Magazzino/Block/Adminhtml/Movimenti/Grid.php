<?php

class Artera_Magazzino_Block_Adminhtml_Movimenti_Grid extends Mage_Adminhtml_Block_Widget_Grid{
  public function __construct(){
      parent::__construct();
      $this->setId('movimentiGrid');
      $this->setDefaultSort('created_time');
      $this->setDefaultDir('desc');
      $this->setSaveParametersInSession(true);
//       $this->setCountTotals(true) ;
  }

  protected function _prepareCollection(){
      $collection = Mage::getModel('magazzino/movimenti')->getCollection();
      $collection
      ->addExpressionFieldToSelect("segno","if(segno = '+','carico','scarico')",null)
      ->getSelect()
      ->joinLeft(array('p' => 'catalog_product_entity'),"main_table.product_id = p.entity_id",array('p.sku')) 
      ->joinLeft(array('pn' => 'catalog_product_entity_varchar'),"main_table.product_id = pn.entity_id and pn.attribute_id = 60",array('pn.value as p_name'))
      ->joinLeft(array('pp' => 'catalog_product_entity_decimal'),"main_table.product_id = pp.entity_id and pp.attribute_id = 64",array('pp.value as price'))
      ->joinLeft(array('psp' => 'catalog_product_entity_decimal'),"main_table.product_id = psp.entity_id and psp.attribute_id = 65",array('psp.value as special_price'))
      ->joinLeft(array('ppsm' => 'catalog_product_entity_decimal'),"main_table.product_id = ppsm.entity_id and ppsm.attribute_id = 138",array('ppsm.value as prezzo_scontato_max'))
      ->joinLeft(array('m' => 'magazzini'),"main_table.id_magazzino = m.id",array('m.nome as nome_mag')) ;
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns(){
//       $this->addColumn('id', array(
//           'header'    => Mage::helper('magazzino')->__('ID'),
//           'align'     =>'right',
//           'width'     => '10px',
//           'index'     => 'id',
//       ));


	  $this->addColumn('sku', array(
      	'header'    => Mage::helper('magazzino')->__('Codice'),
      	'align'     =>'left',
      	'width'   => '70px' ,
      	'index'     => 'sku',
      ));
      $this->addColumn('p_name', array(
      	'header'    => Mage::helper('magazzino')->__('nome prodotto'),
      	'align'     =>'left',
      	'width'   => '250px' ,
      	'index'     => 'p_name',
      	'filter_condition_callback' => array($this, '_filterNome'),
      ));
     $this->addColumn('price', array(
      	'header'    => Mage::helper('magazzino')->__('price'),
      	'align'     =>'right',
      	'width'   => '50px' ,
     	'type'  => 'price',
     	'currency_code' => 'EUR' ,
      	'index'     => 'price',
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('special_price', array(
      	'header'    => Mage::helper('magazzino')->__('special price'),
      	'align'     =>'left',
      	'width'   => '50px' ,
      	'type'  => 'price',
      	'currency_code' => 'EUR' ,
      	'index'     => 'special_price',
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('prezzo_scontato_max', array(
      	'header'    => Mage::helper('magazzino')->__('prezzo scontato max'),
      	'align'     =>'left',
      	'width'   => '50px' ,
      	'index'     => 'prezzo_scontato_max',
      	'type'  => 'price',
      	'currency_code' => 'EUR' ,
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('nome_mag', array(
      	'header'  => Mage::helper('magazzino')->__('magazzino'),
      	'align'   =>'left',
      	'width'   => '40px' ,
      	'index'   => 'nome_mag',
      	'type'      => 'options',
      	'options'   => Mage::getModel("magazzino/magazzini")->getListForOptionsGrid() ,
      	'renderer'  => 'Artera_Magazzino_Block_Render_Magazzino' ,
      	'filter_condition_callback' => array($this, '_filterMag'),
      ));
      $this->addColumn('user', array(
      	'header'  => Mage::helper('magazzino')->__('utente'),
      	'align'   =>'left',
      	'width'   => '70px' ,
      	'index'   => 'user',
      ));
      $this->addColumn('note', array(
      	'header'  => Mage::helper('magazzino')->__('note'),
      	'align'   =>'left',
      	'width'   => '150px' ,
      	'index'   => 'note',
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('qta', array(
      	'header'  => Mage::helper('magazzino')->__('Quantità'),
		'align'   =>'right',
		'width'   => '10px' ,
		'index'   => 'qta',
      	'type'  => 'number',
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('segno', array(
      	'header'=> Mage::helper('magazzino')->__('Tipo'),
      	'align'	=>'right',
      	'width'	=> '10px' ,
      	'index'	=> 'segno',
      	'filter'	=> false,
      	'sortable'  => false,
      ));
      $this->addColumn('created_time', array(
      	'header'=> Mage::helper('magazzino')->__('inserito il'),
      	'align'	=>'right',
      	'width'	=> '60px' ,
      	'index'	=> 'created_time',
      	'type'	=> 'datetime' ,
      	'renderer'  => 'Artera_Magazzino_Block_Render_Date' ,
      	'filter_condition_callback' => array($this, '_filterData'),
      ));
      
      $this->addExportType('*/*/exportMovimentiCsv', Mage::helper('customer')->__('CSV'));
      $this->addExportType('*/*/exportMovimentiXml', Mage::helper('customer')->__('Excel XML'));
      
      return parent::_prepareColumns();
  }
  protected function _filterMag($collection, $column){
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	$this->getCollection()->getSelect()
  	->where('main_table.id_magazzino = ?' , $value ) ;
  }
  protected function _filterNome($collection, $column){
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	$this->getCollection()->getSelect()
  	->where("pn.value like ?" , "%$value%" ) ;
  }
  protected function _filterData($collection, $column){
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}

  	$this->getCollection()->getSelect()
  	->where("UNIX_TIMESTAMP(main_table.created_time) >= ?" , $value['from']->getTimestamp()) 
  	->where("UNIX_TIMESTAMP(main_table.created_time) <= ?" , $value['to']->getTimestamp());
  }
  public function getRowUrl($row){
  	return null ;
  	//return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
}