<?php
class Artera_Search_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
		$this->loadLayout();
		$collection = Mage::getModel("catalog/product")->getCollection();
		$layout = $this->getLayout();
		$block = $layout->createBlock("Catalog/Product_List");
		$block->setTemplate("catalog/product/list.phtml");
		$block->setAvailableOrders(array('name'=>'Name','price'=>'Price'));
		$block->setDefaultOrder('price');
		$block->setCollection($collection);
		//echo print_r($toolbarBlock->getAvailableOrders());exit;
		
// 		echo "<pre>";
// 		foreach($collection as $item){
// 			print_r($item->getData());
// 		}
		
		$this->getLayout()->getBlock('content')->append($block); 
		$this->renderLayout();
    }
}