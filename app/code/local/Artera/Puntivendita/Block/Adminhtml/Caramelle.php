<?php
class Artera_Puntivendita_Block_Adminhtml_Caramelle extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		$this->_controller = 'adminhtml_caramelle' ;
		//$this->_controller = 'adminhtml_puntivendita' ;
		$this->_blockGroup = 'puntivendita' ;
		//$this->_blockGroup = 'caramelle' ;
		$this->_headerText = Mage::helper('puntivendita')->__('Gestione caramelle') ;
		$this->_addButtonLabel = Mage::helper('puntivendita')->__('Aggiungi caramella') ;
		parent::__construct() ;
	}
}
