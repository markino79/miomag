<?php
class Mkp_Attributesgroup_Block_Product_View_Attributes extends Mage_Catalog_Block_Product_View_Attributes {
/**
     * $excludeAttr is optional array of attribute codes to
     * exclude them from additional data array
     *
     * @param array $excludeAttr
     * @return array
     */
    public function getAdditionalData(array $excludeAttr = array())
    {	
    	// parent::getAdditionalData();
        $data = array();
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        $selectedGroupIdAttributes = array();
        foreach ($attributes as $attribute) {
//            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                	$selectedGroupIdAttributes[] = $attribute->getId();
                    $data[$attribute->getAttributeCode()] = array(
                        'id'    => $attribute->getId(),
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code'  => $attribute->getAttributeCode()
                    );
                }
            }
        }
        
        if (empty($selectedGroupIdAttributes))
        	return array();
        
        $setId = $setId = $product->getAttributeSetId();
    	
    	$groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->addFieldToFilter('main_table.attribute_set_id', array('eq' => $setId));
        $groupCollection->getSelect()
        	->columns("group_concat(eas.attribute_id SEPARATOR  ',') as attribute_in_group")
        	->join(
        		array('eas'=> $groupCollection->getTable('entity_attribute')),
        		'main_table.attribute_group_id = eas.attribute_group_id'
        	)
        	->where('eas.attribute_id in ('.implode(',',$selectedGroupIdAttributes).')')
        	->group('main_table.attribute_group_id')
        	->order(array('main_table.sort_order ASC'))
        	;
        // echo $groupCollection->getSelect();exit;
        	
        $groupCollection->load();
	
        $gruppi = array();
        foreach ($groupCollection as $group){
        	if (!isset($gruppi[$group->getAttributeGroupName()]))
        		$gruppi[$group->getAttributeGroupName()] = array();
        		
        	$groupArticleIds = explode(",", $group->getData('attribute_in_group'));
      		$gruppi[$group->getAttributeGroupName()]['data'] =  array();
        	foreach ($data as $key=>$attribute){
        		if(in_array($attribute['id'],$groupArticleIds)){
        			$gruppi[$group->getAttributeGroupName()]['data'][] = $attribute;
        			unset($data[$key]);
        		}
        	}
        	
        }       
        return $gruppi;
    }
}