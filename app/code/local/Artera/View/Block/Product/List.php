<?php
class Artera_View_Block_Product_List extends Mage_Catalog_Block_Product_List{
	public function getLoadedProductCollection(){
		$collection = parent::getLoadedProductCollection();
// 		foreach ($collection as $item){
// 			$item->final_price = 99;
// 		}
		return $collection;
	}
} 
