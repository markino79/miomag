<?php 
class Artera_Product_Block_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs{
	 protected function _prepareLayout(){
	 	$r = parent::_prepareLayout(); ;
	 	$this->addTab('set', array(
               'label'     => Mage::helper('catalog')->__('prova'),
               //'content'   => $this->_translateHtml($this->getLayout()->createBlock('puntivendita/adminhtml_puntivendita')->toHtml()),
                'content' => "<div>Test</div>" ,
           ));
	  	return $r ;
	 }
}