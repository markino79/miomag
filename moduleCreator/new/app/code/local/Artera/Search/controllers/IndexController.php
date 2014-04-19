<?php
class Artera_Search_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/search?id=15 
    	 *  or
    	 * http://site.com/search/id/15 	
    	 */
    	/* 
		$search_id = $this->getRequest()->getParam('id');

  		if($search_id != null && $search_id != '')	{
			$search = Mage::getModel('search/search')->load($search_id)->getData();
		} else {
			$search = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($search == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$searchTable = $resource->getTableName('search');
			
			$select = $read->select()
			   ->from($searchTable,array('search_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$search = $read->fetchRow($select);
		}
		Mage::register('search', $search);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}