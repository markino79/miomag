<?php
class Artera_Ordercli_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/ordercli?id=15 
    	 *  or
    	 * http://site.com/ordercli/id/15 	
    	 */
    	/* 
		$ordercli_id = $this->getRequest()->getParam('id');

  		if($ordercli_id != null && $ordercli_id != '')	{
			$ordercli = Mage::getModel('ordercli/ordercli')->load($ordercli_id)->getData();
		} else {
			$ordercli = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($ordercli == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$ordercliTable = $resource->getTableName('ordercli');
			
			$select = $read->select()
			   ->from($ordercliTable,array('ordercli_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$ordercli = $read->fetchRow($select);
		}
		Mage::register('ordercli', $ordercli);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}