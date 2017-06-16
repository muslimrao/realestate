<?php
namespace App\Http\Helpers;

use Mage;
use Mage_Core_Model_App;
use Mage_Core_Model_Store;
require_once(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))) . '/app/Mage.php');

class Magento{
	
	private static $mInstance = NULL;
	private static $dsid = NULL;
	private function __construct() {


		Mage::app();
		Mage::app('admin');
		Mage::register('isSecureArea', 1);
		#Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));

		self::$dsid 	= Mage::app() -> getDefaultStoreView() -> getRootCategoryId();
	}
	
	public function __call($function, $args) {
           return call_user_func_array(['Mage',$function],$args);
	}
	
	public static function getInstance() {
		if(self::$mInstance==NULL){
			
			self::$mInstance 						= new Magento();
			self::$mInstance->defaultStoreId 		= self::$dsid;

		}
		return self::$mInstance;
	}

	public static function mageInstance()
    {
        return self::$mInstance;
    }
    	
    public function getMediaURL( $link = false )
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $link;
    }
	
	public function checkProductType($product_id)
	{
		$product = Mage::getModel('catalog/product')->load($product_id);
		return $product->getTypeId(); 
	}
	
	public function getNavFilterableAttributesBySetId( $attributeSetId )
	{
		$attributes 	= array();		
		$attributes 	= Mage::getResourceModel("catalog/product_attribute_collection")
							->setAttributeSetFilter($attributeSetId)
							->addFieldToFilter("is_filterable", "1")
							->getItems();
		
		
		if(	count($attributes) > 0	)
		{
			$attributes	= array_keys($attributes);
		}	
		
		return $attributes;
	}
	
	public function getfilterableAttributesBySetId( $attributeSetId )
	{
		$attributes 	= array();		
		$attributes 	= Mage::getResourceModel("catalog/product_attribute_collection")
							->setAttributeSetFilter($attributeSetId)
							->addFieldToFilter("frontend_input", "select")
							->addFieldToFilter("is_configurable", "1")
							->addFieldToFilter("is_global", "1")
							->getItems();
		
		
		if(	count($attributes) > 0	)
		{
			$attributes	= array_keys($attributes);
			
			if( $attributeSetId == 41 ) // Is Fashion
			{
				$attributes	=  array_diff($attributes, array( 378, 381 )); // Remove aa=32-b, size_15=shirt size	
			}
			
		}	
			
		
		return $attributes;
	}
    
	public function getgroupidbysetid( $set_id ) 
	{
		if( $set_id )
		{
			$entity_attr_group_model 						= Mage::getModel('eav/entity_attribute_group')
																->getResourceCollection()
																->setAttributeSetFilter($set_id)
																->addFieldToFilter('attribute_group_name', "General")
																->setSortOrder()
																->load();
			
			$attribute_group_data							= $entity_attr_group_model->getFirstItem()->getData();	
			
			return $attribute_group_data['attribute_group_id'];
		}
		return false;
	}
	
	public function getattributesoptions($arg_attribute) { 
		$attribute_model 			= Mage::getModel('eav/entity_attribute'); 
		$attribute_options_model	= Mage::getModel('eav/entity_attribute_source_table');   
		
		$attribute_code 			= $attribute_model->getIdByCode('catalog_product', $arg_attribute); 
		$attribute 					= $attribute_model->load($attribute_code);   
		
		$attribute_table 			= $attribute_options_model->setAttribute($attribute); 
		$options 					= $attribute_options_model->getAllOptions(false);   
		/*
		foreach($options as $option) { 
			if ($option['label'] == $arg_value) {
				return $option['value']; 
			} 
		}*/   
		return $options; 
	}
	
	public function setCustomerSession( $customer_ID, $unset_session = FALSE, $frontend_adminhtml = "frontend" )
	{
		$session					= Mage::getSingleton('customer/session', array('name' => $frontend_adminhtml));
		$session->setCustomerAsLoggedIn( Mage::getModel('customer/customer')->load( $customer_ID ) );
		
		if ( $unset_session )
		{
			$session->unsetAll();
		}
	}
	
	public function setProductQuantity( $product_ID = false, $quantity_to_UPDATE = 0 )
	{
		if ( ! $product_ID )
		{
			return FALSE;
		}
		
		$stockItem 				= Mage::getModel('cataloginventory/stock_item')->loadByProduct( $product_ID );
		
		
		if ($stockItem->getId() > 0 and !$stockItem->getManageStock()) 
		{
			
			
			$stockItem->setData('manage_stock', 1);
			$stockItem->save();

			$stockItem 				= Mage::getModel('cataloginventory/stock_item')->loadByProduct( $product_ID );

		}
		
		

		if ($stockItem->getId() > 0 and $stockItem->getManageStock()) 
		{
			
			
			$qty				= $stockItem->getQty() + $quantity_to_UPDATE;
			$stockItem->setQty($qty);
			$stockItem->setIsInStock((int)($qty > 0));
			$stockItem->save();
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
		
	}
	
}