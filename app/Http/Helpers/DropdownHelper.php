<?php

namespace App\Http\Helpers;


use App\Http\Helpers\Magento as MagentoHelper;
use App\Http\Controllers\MY_controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Http\Library\CustomFunctions;
use App\Warehouse;
use Mage_Catalog_Model_Category;
use Mage;


class DropdownHelper extends MagentoHelper
{
    function __construct()
    {
        parent::__construct();

    }
    
	
	function warehouse_location_dropdown( $hide_first_index = FALSE, $find_key = FALSE, $dont_include_ids = false, $only_include_ids = false )
	{
		$TMP_warehouse				= \App\WarehouseLocation::whereNotNull('id');
		
	

		
		if ( !$hide_first_index and !$only_include_ids)
        {
            $tmp_array[""]							= 'Select Warehouse Location';
        }


		if ( $only_include_ids )
        {
			if ( is_array($only_include_ids) )
			{
            	$TMP_warehouse->whereIn("id", $only_include_ids);
			}
			else
			{
				$TMP_warehouse->where("id", $only_include_ids);	
			}
        }
        else
        {
            if ( $dont_include_ids )
            {   
                $TMP_warehouse->whereNotIn('id', $dont_include_ids);
            }
        }
		
		
		$TMP_warehouse		= $TMP_warehouse->orderBy('id', 'DESC')->get();
			
		
        foreach ( $TMP_warehouse as $row )
        {
			$tmp_array[ $row->id ] 				= $row->Warehouse()->get()->first()->name;
        }

        if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		
		return $tmp_array;
		
		
	}
	
	function warehouse_dropdown( $hide_first_index = FALSE, $find_key = FALSE, $dont_include_ids = false, $only_include_ids = false )
	{
		$TMP_warehouse				= Warehouse::whereNotNull('id');
		
	

		
		if ( !$hide_first_index and !$only_include_ids)
        {
            $tmp_array[""]							= 'Select Warehouse';
        }


		if ( $only_include_ids )
        {
			if ( is_array($only_include_ids) )
			{
            	$TMP_warehouse->whereIn("id", $only_include_ids);
			}
			else
			{
				$TMP_warehouse->where("id", $only_include_ids);	
			}
        }
        else
        {
            if ( $dont_include_ids )
            {   
                $TMP_warehouse->whereNotIn('id', $dont_include_ids);
            }
        }
		
		
		$TMP_warehouse		= $TMP_warehouse->orderBy('id', 'DESC')->get();
			
		
        foreach ( $TMP_warehouse as $row )
        {
			$tmp_array[ $row->id ] 				= $row->name;
        }

        if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		
		return $tmp_array;
		
		
	}
	
	
    function categories_dropdown( $root_category = FALSE, $dont_include_this_id = FALSE, $hide_first_index = TRUE, $extra_where = '' )
    {
        $TMP_where			= "";
        /*if ( $dont_allow )
        {
                $TMP_where		= " AND id not in (". $dont_allow .")";
        }*/

        
        #$rootCatId      = Mage::app() -> getDefaultStoreView() -> getRootCategoryId();
        
        $rootCatId      = Mage_Catalog_Model_Category::TREE_ROOT_ID;
        
        if ( $root_category )
        {
            $rootCatId  = $root_category;
        }
        
        
       
         $TMP_array      = array();
        if ( !$hide_first_index )
        {
                $tmp_array[""]							= "Select Menu";
        }

        
        /*
        $TMP_filters    = array ( 
                                    array(
                                            'attribute' => 'is_active',
                                            'eq' => 1
                                        ),
                                    array(
                                            'attribute' => 'include_in_menu',
                                            'eq' => 1
                                        )
                                );
        
        */
        
        $TMP_filters    = false;
        if ($dont_include_this_id  )
        {
            $TMP_filters[]  = array(
                                        'attribute' => 'entity_id',
                                        'neq' => array($dont_include_this_id)
                                    );
        }
                                
        $catlistHtml    = CustomFunctions::getCategoriesTreeArray($TMP_filters, $rootCatId , false, "&nbsp;&nbsp;&nbsp;", $TMP_array);
      
        foreach ( $TMP_array as $row )
        {
                $tmp_array[ $row["entity_id"] ] 				= $row["newName"];
        }


        
        return $tmp_array;
    }
    function getCategoriesDropdown( $sale_cats = false ) {

        $categories         = array();
        $categoriesArray    = Mage::getModel('catalog/category')
                                ->getCollection()
                                ->addAttributeToSelect('name')
                                ->addAttributeToSort('path', 'asc')
                                ->addFieldToFilter('is_active', array('eq'=>'1'))
                                ->load()
                                ->toArray();

        foreach ($categoriesArray as $categoryId => $category) {
            if ( isset($category['name']) && ( $category['level'] !== '1' ) ) {
                $categories[] = array(
                    'label' => $category['name'],
                    'level'  =>$category['level'],
                    'value' => $categoryId
                );
            }
        }
        return $categories;
    }


    function runtime_dropdown( $data_array, $key_value = array(), $first_index = "" )
    {

        $tmp_array											= array();

        if ( $first_index != "" )
        {
            $tmp_array[""]									= $first_index;
        }

        if ( count($key_value) > 0 )
        {
            if($data_array) {
                foreach ( $data_array as $row )
                {
                    $tmp_array[ $row[ $key_value["key"] ] ] 		= $row[ $key_value["value"] ];
                }
            }
        }
        else
        {
            if($data_array)
            {
                foreach ( $data_array as $row )
                {
                    $tmp_array[ $row ] 		= $row;
                }
            }
        }

        return $tmp_array;
    }



    function country_dropdown( $hide_first_index = FALSE, $id = 'value', $find_key = FALSE)
    {

        $countryCollection      = self::mageInstance()->getModel('directory/country')->getResourceCollection()
            ->loadByStore()
            ->toOptionArray(true);



        if ( !$hide_first_index )
        {
            $tmp_array[""]							= 'Select Country';
        }


        foreach ( $countryCollection as $row )
        {
            if ( $row[ $id ] != "" )
            {
                $tmp_array[ $row[ $id ] ] 				= $row["label"];
            }
        }

        if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }

        return $tmp_array;

    }


    function emailmode_dropdown()
    {
        $droparray			= array("smtp"			=> "SMTP",
                                    "mail"			=> "MAIL"
        );

        return $droparray;
    }


    
    function roles_dropdown( $hide_first_index = FALSE, $dont_include_ids = false, $only_include_ids = false, $return_collection = false )
    {
        if ( !$hide_first_index and !$only_include_ids )
        {
            $tmp_array[""]                          = "Select Role";
        }


        $ROLE_details                               = Mage::getModel('admin/roles')->getCollection();
        
        $ROLE_details->addFieldToFilter('parent_id', 0 );
        
        
        
        if ( $only_include_ids )
        {
            $ROLE_details->addFieldToFilter('role_id', array('in' => $only_include_ids));
        }
        else
        {
            if ( $dont_include_ids )
            {   
                $ROLE_details->addFieldToFilter('role_id', array('nin' => $dont_include_ids));
            }
        }
        
        
		
		if ( $return_collection )
		{
			return $ROLE_details;
		}
		else
		{
			if( $ROLE_details->count() > 0 )
			{
				foreach ( $ROLE_details as $role )
				{
					$tmp_array[$role->getId()] = $role->getRoleName();
				}
			}
	
	
			return $tmp_array;
		}
    }
	

	function magento_order_states_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
    {

		$tmp_array 									= Mage::getSingleton('sales/order_config')->getStates();
        #$states									 	= array_merge(array('' => ''), $states);
		
		#$ROLE_details									= Mage::getModel('sales/order_status')->getResourceCollection()->addStateFilter( $state_filter );        
        

		if ( !$hide_first_index  and !$find_key)
        {
			$tmp_array								= array_merge(array('' => 'Select Order State'), $tmp_array);
        }
		
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }
	
	function magento_order_status_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
    {

		$tmp_array 									= Mage::getSingleton('sales/order_config')->getStatuses();
        

		if ( !$hide_first_index  and !$find_key)
        {
			$tmp_array								= array_merge(array('' => 'Select Order Status'), $tmp_array);
        }
		
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }
	
	
	
	
	function magento_order_invoice_states_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
    {
        if ( !$hide_first_index  and !$find_key)
        {
            $tmp_array[""]                          = "Select State";
        }

		
		
		
		$STATE_details									= Mage::getModel('sales/order_invoice')->getStates();
        

        if( count($STATE_details) > 0 )
        {
			
            foreach ( $STATE_details as $index => $value )
            {
                $tmp_array[ $index ] 			= $value;
            }
        }
		
		
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }
	
	
	
	function magento_order_creditmemo_states_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
    {
        if ( !$hide_first_index  and !$find_key)
        {
            $tmp_array[""]                          = "Select State";
        }

		
		
		
		$STATE_details									= Mage::getModel('sales/order_creditmemo')->getStates();
        

        if( count($STATE_details) > 0 )
        {
			
            foreach ( $STATE_details as $index => $value )
            {
                $tmp_array[ $index ] 			= $value;
            }
        }
		
		
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }
	
	function magento_product_status_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
    {
        

		
		$tmp_array								= Mage::getSingleton('catalog/product_status')->getOptionArray();        
        
		if ( !$hide_first_index  and !$find_key)
        {
            $tmp_array[""]                          = "Select Status";
        }
        
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }
	
	function magento_status_dropdown( $hide_first_index = FALSE, $find_key = FALSE, $state_filter = 'sellercenter' )
    {
        if ( !$hide_first_index  and !$find_key)
        {
            $tmp_array[""]                          = "Select Status";
        }
		
		
		$ROLE_details									= Mage::getModel('sales/order_status')->getResourceCollection();
		
		if ( $state_filter )
		{
			$ROLE_details->addStateFilter( $state_filter );        
		}
		
        

        if( $ROLE_details->count() > 0 )
        {
			
            foreach ( $ROLE_details as $role )
            {
                $tmp_array[$role->getStatus()] 			= $role->getLabel();
            }
        }
		
		
		if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }
		

        return $tmp_array;
    }

    function usersbyrole_dropdown( $role_id, $user_id_not_in = FALSE, $only_this_id = FALSE, $hide_first_index = FALSE )
    {
        if ( !$hide_first_index and !$only_this_id)
        {
            $tmp_array[""]                          = "Select";
        }


        $LIST_UsersID_by_Role                = Mage::getModel('admin/roles')->load( $role_id )->getRoleUsers();

        $LIST_VendorManager                  = Mage::getModel('admin/user')->getCollection();
        $LIST_VendorManager->addFieldToFilter('user_id', array('in' => $LIST_UsersID_by_Role));
        
        
        if ( $user_id_not_in )
        {
            $LIST_VendorManager->addFieldToFilter('user_id', array('nin' => $user_id_not_in));
        }
        
        if ( $only_this_id )
        {
            $LIST_VendorManager->addFieldToFilter('user_id', array('eq' => $only_this_id));
        }
        
        
        foreach ( $LIST_VendorManager as $user )
        {
            $tmp_array[$user->getId()] = $user->getName();
        }
        return $tmp_array;
    }
    
	function vendors_addresses_dropdown( $hide_first_index = FALSE, $entity_id = FALSE, $return_collection = FALSE, $user_id_not_in = FALSE, $only_this_id = FALSE )
    {

        if ( !$hide_first_index )
        {
            $tmp_array[""]                          = "Select Vendor / Seller Address";
        }
        



		$collectionfetch = Mage::getModel('marketplace/userprofile')->getCollection();
		
		$record = array();
		foreach($collectionfetch as $id)
		{
			$record[] = $id->getmageuserid();
		}
		
		

        $_USER_DETAILS                              = Mage::getModel('customer/customer')->getCollection();

		
		$_USER_DETAILS->addAttributeToFilter('entity_id', array('in' => $record));
		
		
        if ( $entity_id )
        {
            $_USER_DETAILS->addAttributeToFilter('entity_id', $entity_id);
        }
        
		
		if ( $user_id_not_in )
        {
            $_USER_DETAILS->addFieldToFilter('entity_id', array('nin' => $user_id_not_in));
        }
        
        $_USER_DETAILS->addAttributeToSort('entity_id', "DESC");
        
        
        $_USER_DETAILS->joinTable('marketplace/userprofile', 'mageuserid = entity_id', array('*'), null, 'left');


		#print_r($_USER_DETAILS->getData());
		#die;
		
        if ( count($_USER_DETAILS) > 0 )
        {
            foreach ( $_USER_DETAILS as $user )
            {
				foreach ( $user->getAddressesCollection()   as $addressList ) 
				{
					$tmp_array[$addressList->getId()]              = implode(", ", $addressList->getstreet() ) . " - " . $addressList->getCity();
				}
				
                #$tmp_array[$user->getId()]              = $user->getName();
            }
        }


        if ( $return_collection )
        {
            return $_USER_DETAILS;
        }

        return $tmp_array;
    }


    function vendors_dropdown( $hide_first_index = FALSE, $entity_id = FALSE, $return_collection = FALSE, $user_id_not_in = FALSE, $only_this_id = FALSE )
    {
		
		$tmp_array									= array();

		$collectionfetch = Mage::getModel('marketplace/userprofile')->getCollection();
		
		$record = array();
		foreach($collectionfetch as $id)
		{
			$record[] = $id->getmageuserid();
		}
		

        $_USER_DETAILS                              = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
			

            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('shipping_country_id', 'customer_address/country_id', 'default_shipping', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');
			

		$_USER_DETAILS->addAttributeToFilter('entity_id', array('in' => $record));
		
		
        if ( $entity_id )
        {
            $_USER_DETAILS->addAttributeToFilter('entity_id', $entity_id);
        }
        
		
		if ( $user_id_not_in )
        {
            $_USER_DETAILS->addFieldToFilter('entity_id', array('nin' => $user_id_not_in));
        }
		
		
		if ( $only_this_id )
        {
            $_USER_DETAILS->addFieldToFilter('entity_id', array('in' => $only_this_id));
        }
        
        #$_USER_DETAILS->addAttributeToSort('entity_id', "DESC");
        
        $prefix 				= Mage::getConfig()->getTablePrefix();
        $_USER_DETAILS->joinTable(		array('marketplace_userprofile' => 'marketplace/userprofile'), 
										'mageuserid = entity_id', 
										array('*'), 
										null, 'left'); 
										
		

		#$_USER_DETAILS->addAttributeToSort('name', 'ASC');
		
		#$_USER_DETAILS->getSelect()->order('marketplace_userprofile.profileurl','desc');
		
		
		
		if ( $return_collection )
        {
            return $_USER_DETAILS;
        }
		
		
        if ( count($_USER_DETAILS) > 0 )
        {
            foreach ( $_USER_DETAILS as $user )
            {
                $tmp_array[$user->getId()]              = $user->getprofileurl() . "  (" . $user->getName() . ")";
            }
        }
		
		
        

		asort( $tmp_array );
		
		
		$Starting_Index									= array();
		if ( !$hide_first_index and is_array($entity_id) )
        {
            $Starting_Index[""]                          = "Select Vendor / Seller Center";
        }
        else if ( !$hide_first_index and !$entity_id )
        {
            $Starting_Index[""]                          = "Select Vendor / Seller Center";
        }
		
	
	
		if ( count($Starting_Index) > 0 )
		{
			
			
			if ( gettype($hide_first_index) ==  "boolean")
			{
				
			}
			else
			{
				$Starting_Index[""]                          = $hide_first_index;
			}
			
			$tmp_array					=  $Starting_Index + $tmp_array;
		}
		

        return $tmp_array;
    }

    function gender_dropdown( $hide_first_index = FALSE )
    {
        
        if ( !$hide_first_index )
        {
            $tmp_array[""]                          = 'Select Gender';
        }

        $array  = array('M' => 'Male', 'F' => 'Female');

        foreach ( $array as $key => $row )
        {
            if ( $key != "" )
            {
                $tmp_array[ $key ]               = $row;
            }
        }

        return $tmp_array;

    }
	
	function magento_gender_dropdown( $hide_first_index = FALSE )
    {
        
        if ( !$hide_first_index )
        {
            $tmp_array[""]                          = 'Select Gender';
        }

        $array  = array('1' => 'Male', '2' => 'Female');

        foreach ( $array as $key => $row )
        {
            if ( $key != "" )
            {
                $tmp_array[ $key ]               = $row;
            }
        }

        return $tmp_array;

    }

    function ActiveInactive_dropdown( $find_key = '' )
    {
         $droparray          = array("0"          	=> "Inactive",
                                     "1"          	=> "Active");
									 
									 
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}

        return $droparray;

    }
    
    function YesNo_dropdown( $find_key = '' )
    {
        $droparray          = array("0"          	=> "No",
                                    "1"          	=> "Yes");


        if ( $find_key != '' )
        {
			if ( array_key_exists($find_key, $droparray) )
			{
					return $droparray[ $find_key ];	
			}
			else
			{
					return $droparray[0];	
			}
        }
		else if ( $find_key == NULL and $find_key != '')
		{
			return $droparray[0];	
		}
		

        return $droparray;

    }

    function prefix_dropdown( $hide_first_index = FALSE )
    {
        

		$tmp_array									= array();
        $array  									= self::mageInstance()->helper('customer')->getNamePrefixOptions(); #array('Mr' => 'Mr.', 'Mrs' => 'Mrs.', 'Ms' => 'Ms.');
		
		
		if ( !$hide_first_index )
        {
            $tmp_array[""]                     	    = 'Select Prefix';
        }
		
		
		foreach ( $array as $key => $row )
        {
            if ( $key != "" )
            {
                $tmp_array[ $key ]               = $row;
            }
        }
		
        return $tmp_array;

    }

    function seller_dropdown( $hide_first_index = FALSE, $id = 'entity_id', $find_key = FALSE)
    {

        $customerCollection = self::mageInstance()->getModel('marketplace/userprofile')->getCollection();

        $customers = [];

        foreach($customerCollection as $customerId)
        {
            $seller_id = (int) $customerId->getmageuserid();

            $customers[] = self::mageInstance()->getModel('customer/customer')->load($seller_id)->getData();
        }

        if ( !$hide_first_index )
        {
            $tmp_array[""]                          = 'Select Seller';
        }

        foreach ( $customers as $row )
        {
            
            if ( $row[ $id ] != "" )
            {
                $tmp_array[ $row[ $id ] ]               = $row["prefix"] .' '. $row["firstname"] . ' ' . $row['lastname'];
            }
        }

        if ( $find_key != '' )
        {
            if ( array_key_exists($find_key, $tmp_array) )
            {
                return $tmp_array[ $find_key ];
            }
            else
            {
                return $tmp_array[0];
            }
        }

        return $tmp_array;

    }



}