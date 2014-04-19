<?php

class Artera_Importproduct_GetstatusController extends Mage_Core_Controller_Front_Action{
	public function indexAction(){
		$cache = Mage::app()->getCache()  ; 
		$stato = $cache->load('importproductdata') ;
		echo json_encode(unserialize($stato))  ;
 	}
}
