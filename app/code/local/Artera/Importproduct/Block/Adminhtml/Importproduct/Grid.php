<?php

class Artera_Importproduct_Block_Adminhtml_Importproduct_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	public function __construct(){
		parent::__construct() ;
		$this->setId('importproductGrid') ;
		$this->setDefaultSort('importproduct_id') ;
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	protected function _prepareCollection(){
		$collection = Mage::getModel('importproduct/importproduct')->getCollection() ;
		$collection->addFieldToFilter('status',array(
			'neq' => 0
		)) ;
		$this->setCollection($collection) ;
		return parent::_prepareCollection() ;
	}
	protected function _prepareColumns(){
		$this->addColumn('importproduct_id', array(
			'header'    => Mage::helper('importproduct')->__('ID'),
			'align'     =>'right',
			'width'     => '50px',
			'index'     => 'importproduct_id',
		));
		$this->addColumn('code', array(
			'header'    => Mage::helper('importproduct')->__('Sku'),
			'align'     =>'left',
			'width'     => '100px',
			'index'     => 'code',
		));
		$this->addColumn('name', array(
			'header'    => Mage::helper('importproduct')->__('Nome'),
			'align'     =>'left',
			'width'     => '150px',
			'index'     => 'name',
		));
		$this->addColumn('message', array(
			'header'    => Mage::helper('importproduct')->__('Messaggio'),
			'align'     =>'left',
			'index'     => 'message',
		));
		
		return parent::_prepareColumns();
	}
}
