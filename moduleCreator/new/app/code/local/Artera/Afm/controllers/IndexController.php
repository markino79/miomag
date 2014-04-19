<?php
class Artera_Afm_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/afm?id=15 
    	 *  or
    	 * http://site.com/afm/id/15 	
    	 */
    	/* 
		$afm_id = $this->getRequest()->getParam('id');

  		if($afm_id != null && $afm_id != '')	{
			$afm = Mage::getModel('afm/afm')->load($afm_id)->getData();
		} else {
			$afm = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($afm == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$afmTable = $resource->getTableName('afm');
			
			$select = $read->select()
			   ->from($afmTable,array('afm_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$afm = $read->fetchRow($select);
		}
		Mage::register('afm', $afm);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}