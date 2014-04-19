<?php
class Artera_Puntivendita_Block_Adminhtml_Puntivendita  extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		$this->_controller = 'adminhtml_puntivendita' ;
		$this->_blockGroup = 'puntivendita' ;
		$this->_headerText = Mage::helper('puntivendita')->__('Gestione punti vendita') ;
		$this->_addButtonLabel = Mage::helper('puntivendita')->__('aggiungi punto') ;
		parent::__construct() ;
		$model = Mage::getModel("puntivendita/puntivendita") ;
		$saluto = $model->getCiao() ;
		$saluto .= " " ;
	}
}
