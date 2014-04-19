<?php
class Artera_View_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/view?id=15 
    	 *  or
    	 * http://site.com/view/id/15 	
    	 */
    	/* 
		$view_id = $this->getRequest()->getParam('id');

  		if($view_id != null && $view_id != '')	{
			$view = Mage::getModel('view/view')->load($view_id)->getData();
		} else {
			$view = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($view == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$viewTable = $resource->getTableName('view');
			
			$select = $read->select()
			   ->from($viewTable,array('view_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$view = $read->fetchRow($select);
		}
		Mage::register('view', $view);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}