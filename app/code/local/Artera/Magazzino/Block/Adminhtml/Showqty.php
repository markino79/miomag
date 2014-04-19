<?php
class Artera_Magazzino_Block_Adminhtml_Showqty extends Mage_Adminhtml_Block_Widget_Grid_Container{
	public function __construct(){
		// con questi parametri definisco dov'è il bloccco Grid
		// con i parametri come sotto farà
		/*
		  $this->setChild( 'grid',
            $this->getLayout()
            	->createBlock('magazzino/adminhtml_showqty_grid','adminhtml_showqty.grid')
            	->setSaveParametersInSession(true) 
          );
          a questo punto la Grid sarà disponibile con 
          $this->getChild('grid) ;
		 */
		$this->_blockGroup = 'magazzino';
		$this->_controller = 'adminhtml_showqty';
		// titolo mostrato nel container
		$this->_headerText = Mage::helper('magazzino')->__('Quantità');
		parent::__construct();
		$this->_removeButton('add') ;
		
	}
}