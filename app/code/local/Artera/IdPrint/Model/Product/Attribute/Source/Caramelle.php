<?php

class Artera_IdPrint_Model_Product_Attribute_Source_Caramelle extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{
	
	public function getAllOptions(){
		/* esempio di array che deve tornare 
		  $this->_options = array(
                array(
                    'value' => '',
                    'label' => '',
                ),
                array(
                    'value' => '1',
                    'label' => 'Day',
                ),
                array(
                    'value' => '2',
                    'label' => 'Week',
                ),
                array(
                    'value' => '3',
                    'label' => 'Month',
                ),
                array(
                    'value' => '4',
                    'label' => 'Year',
                )
            );
        }
		 */
		if (!$this->_options){
			$caramelle = Mage::getModel("puntivendita/caramelle")->getCollection() ;
			$caramelle->addFieldToSelect("caramelle_id, nome") ;
			//$caramelle->addAttributeToSort('nome', 'ASC');
			$aCaramelle = array() ; 
			foreach($caramelle as $caramella){
				$aCaramelle[] = array(
					'value' => $caramella->getId() ,
					'label' => $caramella->getNome()
				) ;
			}
			$this->_options = $aCaramelle ;
		}
		return $this->_options ;
	}
}