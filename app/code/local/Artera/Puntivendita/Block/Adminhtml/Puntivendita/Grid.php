<?php

class Artera_Puntivendita_Block_Adminhtml_Puntivendita_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	public function __construct(){
		parent::__construct() ;
		$this->setId('puntivenditaGrid');
		$this->setDefaultSort('puntivendita_id') ;
		$this->setDefaultDir('ASC') ;
		$this->setSaveParameterInSession(true) ;
	}
	protected function _prepareCollection(){
		$collection = Mage::getModel('puntivendita/puntivendita')->getCollection() ;
		$this->setCollection($collection) ;
		return parent::_prepareCollection() ;
	}
	protected function _prepareColumns(){
		$this->addColumn('puntivendita_id',array(
			'header' => Mage::helper('puntivendita')->__('ID') ,
			'align'  => 'right' ,
			'width'  => '10px' ,
			'index'  => 'puntivendita_id'
		)) ;
		$this->addColumn('nome',array(
			'header' => Mage::helper('puntivendita')->__('Nome') ,
			'align'  => 'left' ,
			'index'  => 'nome'
		)) ;
		$this->addColumn('created_time', array(
			'header'    => Mage::helper('puntivendita')->__('Creation Time'),
			'align'     => 'left',
			'width'     => '120px',
			'type'      => 'date',
			'default'   => '--',
			'index'     => 'created_time',
		));

		$this->addColumn('update_time', array(
			'header'    => Mage::helper('puntivendita')->__('Update Time'),
			'align'     => 'left',
			'width'     => '120px',
			'type'      => 'date',
			'default'   => '--',
			'index'     => 'update_time',
		));  
		$this->addColumn('status', array(
			'header'    => Mage::helper('puntivendita')->__('Status'),
			'align'     => 'left',
			'width'     => '80px',
			'index'     => 'status',
			'type'      => 'options',
			'options'   => array(
			    1 => 'Active',
			    0 => 'Inactive',
			),
		));
        return parent::_prepareColumns();
	}
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit',array('id' => $row->getId())) ;
	}
} 
