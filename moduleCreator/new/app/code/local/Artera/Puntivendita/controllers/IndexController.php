<?php
class Artera_Puntivendita_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/puntivendita?id=15 
    	 *  or
    	 * http://site.com/puntivendita/id/15 	
    	 */
    	/* 
		$puntivendita_id = $this->getRequest()->getParam('id');

  		if($puntivendita_id != null && $puntivendita_id != '')	{
			$puntivendita = Mage::getModel('puntivendita/puntivendita')->load($puntivendita_id)->getData();
		} else {
			$puntivendita = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($puntivendita == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$puntivenditaTable = $resource->getTableName('puntivendita');
			
			$select = $read->select()
			   ->from($puntivenditaTable,array('puntivendita_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$puntivendita = $read->fetchRow($select);
		}
		Mage::register('puntivendita', $puntivendita);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}