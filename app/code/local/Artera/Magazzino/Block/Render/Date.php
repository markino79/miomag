<?php
class Artera_Magazzino_Block_Render_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
		$date = Mage::app()->getLocale()->date($value,'YYYY/MM/dd HH:mm:ss');
		return $date->toString("d/MM/yy H:m") ;
	}
}