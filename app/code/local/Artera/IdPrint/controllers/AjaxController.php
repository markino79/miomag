<?php
Class Artera_IdPrint_AjaxController extends Mage_Core_Controller_Front_Action{
	public function indexAction(){
		$marca = $this->getRequest()->get('marca') ;
		$tipo = $this->getRequest()->get('tipo') ;
		$modello = $this->getRequest()->get('modello') ;
		$data = Mage::getModel("idprint/data") ;
		echo $data->getDataIdPrint($marca ,$tipo ,$modello) ;
	}
	public function testAction(){
		echo "<pre>" ;
		echo print_r(Mage::getModel("idprint/data")->getItemInfomation('C3906A')) ;
		echo "<pre>" ;
	}
}
