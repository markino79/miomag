<?php
class Artera_Magazzino_Block_Adminhtml_Selectproduct_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	public function __construct(){
		parent::__construct();
		$this->setId('selectproductGrid');
		$this->setDefaultSort('sku');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(false);
	}

	protected function _prepareCollection(){
		$collection = Mage::getModel('catalog/product')->getCollection();
		$collection->addAttributeToSelect("sku") ;
		$collection->addAttributeToSelect("id") ;
		$collection->addAttributeToSelect("name") ;
		$collection->addAttributeToSelect("barcode") ;
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
				'header'    => Mage::helper('magazzino')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'entity_id',
		));
		$this->addColumn('sku', array(
				'header'    => Mage::helper('magazzino')->__('codice'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'sku',
		));
		$this->addColumn('barcode', array(
				'header'    => Mage::helper('magazzino')->__('barcode'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'barcode',
		));
		$this->addColumn('name', array(
				'header'    => Mage::helper('magazzino')->__('name'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'name',
		));
		
		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row){
		$md = Mage::registry('movimenti_data') ;
		unset($md['sku']) ;
		$data = array_merge(array('sku' => urlencode($row->getSku())) ,$md ) ;
		return $this->getUrl('magazzino/adminhtml_movimenti/new', $data);
	}
}