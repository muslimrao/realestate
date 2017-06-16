<?php

namespace App\Http\Helpers;


use App\Http\Models\Model_Site_Settings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Mage;

class GeneralHelper
{

	
	
	static function is_numeric( $value = false, $greater_than_zero = false )
	{
		if ( $value != "" and is_numeric($value) and !$greater_than_zero  )
		{
			return TRUE;		
		}
		else if ( $value != "" and is_numeric($value) and $greater_than_zero )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	static function generateNotice( $style = "alert", $class = "", $message = false, $title = false )
	{
		$TMP_notice				= "";
		if ( $style == "alert" )
		{
			$TMP_notice			= '<div class="alert alert-'. $class .' alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
									
			if ( $title )
			{
				if ( $class == "success")
				{
					$class		= "check";	
				}
				
				$TMP_notice		.= '<h4><i class="icon fa fa-'. $class .'"></i> '. $title  .'</h4>';
			}
			
			$TMP_notice			.= $message;
			
			$TMP_notice			.= '</div>';
		}
		else if ( $style == "callout" )
		{
			$TMP_notice			.= '<div class="callout callout-'. $class .'">';
			
			if ( $title )
			{
            	$TMP_notice			.= '<h4>'. $title .'</h4>';
			}
			$TMP_notice			.= $message;
			$TMP_notice			.= '</div>';
		}
		
							  
		return $TMP_notice;
	}
	
	
	static function verify_time_format($value) 
	{
		$pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
		$pattern2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
		return preg_match($pattern1, $value) || preg_match($pattern2, $value);
	}

	static function get_column_result_array( $TMP_array, $TMP_column = FALSE, $key_Name = false )
	{
		$TMP_id														= array();
		if ( count($TMP_array) > 0 )
		{
			for ( $i = 0; $i < count($TMP_array); $i++ )
			{
				if ( $key_Name )
				{
					$TMP_id[ $TMP_array[$i][$key_Name ] ]											= $TMP_array[$i][$TMP_column ];	
				}
				else
				{
					$TMP_id[]											= $TMP_array[$i][$TMP_column ];		
				}
				
			}	
		}
		
		return $TMP_id;
	}
	

    

    static function format_price( $price,  $is_JS = false)
    {
		
		if( is_numeric($price))
		{
			
            return Mage::helper('core')->currency($price, true, false);
		}
		
        else
		{
            return false;
		}
    }

    static function format_bool( $input = "", $match_value = FALSE, $debug = FALSE )
    {
        if ( $match_value != '' )
        {


            $return_value			= FALSE;

            if (  $input ==  $match_value )
            {
                $return_value	= TRUE;
            }

            return $return_value;
        }
        else
        {
            $return_value			= FALSE;
            if ( $input )
            {
                if ( $input == "1")
                {
                    $return_value	= TRUE;
                }
            }

            return $return_value;
            #return ( $input ) ? 1 : 0;
        }
    }

    static function set_value(  $field = "", $default_value = "" )
    {
        return Input::get($field, $default_value);
    }

    static function form_error( $errors, $field = "" )
    {
	
        if ($errors->has( $field ))
        {
            return '<span class="help-block form-error"><strong>'. $errors->first( $field ) .'</strong></span>';
        }
    }
	
	static function set_class( $errors, $field = "" )
    {
	
        if ($errors->has( $field ))
        {
            return 'form-error';
        }
    }

    static function show_error_page( $page, $custom_text = false )
    {
        abort( $page );
        //return Response::view('errors.' .  $page, array("text" => $custom_text),  $page);
    }

    static function required_field( $fontsize = FALSE, $color = FALSE )
    {
        $className			 = '';
        if ( $fontsize )
        {
            $className		.= $fontsize;
        }
        if ( $color )
        {
            $className		.= $color;
        }

        $className			= '';

        return "<span class='required_field ". $className ."'>*</span>";
    }

    public static function getSiteSettingsField($key)
    {
        $_rows          = Model_Site_Settings::first();

        if ( $_rows->count() )
        {
            return $_rows->$key;
        }

        return "";
    }

    static function generate_toccbcc_emails( $emails, $TMP_arr = array() )
    {
        $TMP_emails						= explode("|",  $emails );
        $TMP							= array();
        for ($i=0; $i < count($TMP_emails); $i++)
        {
            $TMP[ $TMP_arr[$i] ]		= explode(",", $TMP_emails[$i]);
        }

        return $TMP;
    }

    static function merge_multi_arrays( $array = array(), $array_name = "" )
    {
        $tmp				= array();

        for ($x=0; $x < count($array); $x++)
        {
            $settings_master					= $array[$x];



            foreach ( $settings_master as $k => $v )
            {
                if ( $array_name == "")
                {
                    $tmp[$k]							= $v;
                }
                else
                {
                    $tmp[ $array_name ][$k]				= $v;

                }
            }

        }

        return $tmp;
    }

	static function make_secure_image_link( $image_value = ""  )
	{
		
		
        $show_only_filename         = explode("/", $image_value );
				
				
		$lonely_filename            = $show_only_filename[ count($show_only_filename) - 1];

		unset( $show_only_filename[ count($show_only_filename) -1 ]);

		$IMPLODE_path               = Crypt::encrypt( implode("/", $show_only_filename) . '/' );



		#print_r($show_only_filename    );die;

		$show_url                   = Config::get('constants.JCASSETS_STATIC') . $IMPLODE_path . '/' . $lonely_filename;
		
		
		$TMP_return_array			= array("image_url"			=> url( $show_url ),
											"image_path"		=> $show_url,
											"lonely_filename"	=> $lonely_filename);
		
		return  (object) $TMP_return_array;
	}
	
	

	
    static function image_link( $input_name = "", $post_image, $runtime_popup = FALSE, $is_multiple = FALSE, $external_URL = FALSE, $append_URL = FALSE, $OTHER_array = array()  )
    {
		$is_HTTP					= $external_URL;
        $remove_image				= "";
        $image_link					= "";

        if ( $is_multiple )
        {
            $images_array			=  self::set_value($input_name, $post_image);


            $___input				= "";
            $___text				= "";


            if ( is_array( $images_array) )
            {
                $___text						= " <ul class='ilinks_sortable'>";
                foreach ($images_array as $key => $value)
                {
                    $random						= "_" . str_random(16);

                    $image_link					= '<a href="'. url( $value ) .'" class="modelImage">'. $value .'</a>';
                    $remove_image				= '&nbsp;&nbsp;<a class="label label-danger"  href="javascript:;" onclick="remImage(\''. $input_name . $random .'\');">(removeimage)</a> ';


                    $___text					.= '<li> <small class="'. $input_name . $random .'"> ' . $image_link . $remove_image . ' </small>';
                    $___text					.= '<input type="hidden" value="'. $value .'" id="'. $input_name . $random . '" name="'. $input_name .'[]" /> </li> ';
                }
                $___text						.= '</ul>';

            }


            return $___text . $___input;
        }
        else
        {
            if ( self::set_value($input_name, $post_image) != "" )
            {

                #label label-danger

				/*
                $show_only_filename         = explode("/", self::set_value($input_name, $post_image) );

                $lonely_filename            = $show_only_filename[ count($show_only_filename) - 1];

                unset( $show_only_filename[ count($show_only_filename) -1 ]);

                $IMPLODE_path               = Crypt::encrypt( implode("/", $show_only_filename) . '/' );



                #print_r($show_only_filename    );die;

              	$show_url                   = Config::get('constants.JCASSETS_STATIC') . $IMPLODE_path . '/' . $lonely_filename;
			  	*/
				

                              
                if ( $is_HTTP )
                {
                    if ( $append_URL )
                    {
                        $show_url           = (object) array(   "image_path"    => $append_URL . self::set_value($input_name, $post_image),
                                                                "lonely_filename"   => $append_URL . self::set_value($input_name, $post_image) );
                    }
                    else
                    {
                        $show_url           = (object) array(   "image_path"    => self::set_value($input_name, $post_image),
                                                                "lonely_filename"   => self::set_value($input_name, $post_image) );
                    }
                    
                }
                else
                {
					
                    $show_url					= self::make_secure_image_link( self::set_value($input_name, $post_image), FALSE );
                }		
				

				$is_IFRAME					= FALSE;
				if ( array_key_exists("iframe", $OTHER_array) )
				{
					
					if ( $OTHER_array["iframe"] != "" )
					{
						$is_IFRAME					= TRUE;
						$image_link					= '<a onclick="_runtimePopup(\''. $OTHER_array["iframe"] .'\', \''. url( $show_url->image_path ) .'\')" href="javascript:;" >'. $show_url->lonely_filename .'</a>';
					}
				}
				
				
				if ( !$is_IFRAME )
				{
                	$image_link					= '<a class="modelImage" href="'. url( $show_url->image_path ) .'" class="'.$COLORBOX_class.'">'. $show_url->lonely_filename .'</a>';
				}

                $remove_image				= '&nbsp;&nbsp;<a class="label label-danger"  href="javascript:;" onclick="remImage(\''. $input_name .'\');">(Remove Image)</a> ';
            }


            if ( !$runtime_popup )
            {
                $remove_image				= "";
            }

            return '<small>' . $image_link . $remove_image . ' </small>';
        }
    }

 
    public static function role_permissions_operations()
    {
        return array("show", "view", "view_records", "add", "edit", "save", "delete");
        
    }
	
	public static function role_permissions_left_pages( $ignore_pages = false )
	{
		if ( $ignore_pages )
		{
			return array("managebulkproductsdelete");	
		}
		
		
		
		return array(
					array(  "text"          => "Dashboard",
							"directory"		=> "managedashboard",
							"dont_include"	=> array("add", "edit", "save", "delete") ),
							
							
					array(  "text"          => "Manage Category",
							"directory"		=> "managecategory" ),

					array(  "text"          => "Manage Users",
							"directory"		=> "manageusers" ),
							
					array(  "text"          => "Manage Vendors",
							"directory"		=> "managevendors" ),
							
					array(  "text"          => "Manage Mapping Vendors",
							"directory"		=> "managemappingvendors" ),
							
					array(  "text"          => "Manage Vendor Categories / Commissions",
							"directory"		=> "managevendorcategoriescommissions" ),
							
					array(  "text"          => "Manage Warehouse",
							"directory"		=> "managewarehouse" ),
							
					array(  "text"          => "Manage Warehouse Location",
							"directory"		=> "managewarehouselocation" ),
					
					array(	"text"			=> "Manage Base Products",
						  	"directory"		=> "managebaseproducts" ),
					
					array(  "text"          => "Manage Vendor Products",
							"directory"		=> "managevendorsproducts",
							"extra_conditions"	=> array (	array(
																	"text"			=> "Show Request Consignment Pickup Button",
																	"key"			=> "requestconsignmentpickup_button",
																	"input_type"	=> "single_checkbox"
																 ),
																 
															/*array(
																	"text"			=> "Show Approve Products Button",
																	"key"			=> "approveproducts_button",
																	"input_type"	=> "single_checkbox"
																 ),*/
																 
															array(
																	"text"			=> "Show Generate Barcode Button",
																	"key"			=> "generateproductbarcode_button",
																	"input_type"	=> "single_checkbox"
																 )
														 )
						 ),
							
					array(  "text"          => "Manage Request Consignment Pickup",
							"directory"		=> "managerequestconsignmentpickup",
							"extra_conditions"	=> array (	
																 
															array(
																	"text"			=> "Show Create Purchase Order Button",
																	"key"			=> "createpurchaseorder_button",
																	"input_type"	=> "single_checkbox"
																 )
														 ),
							"page_conditions"	=> array(	array(
																	"text"			=> "When create PO, email to all roles listed below",
																	"key"			=> "requestconsignmentpickup_generate_po",
																	"input_type"	=> "multiple_select"
																 )
														),
						 ),
						 
					array(  "text"          => "Manage Purchase Orders",
							"directory"		=> "managepurchaseorders",
							"page_conditions"	=> array(	array(
																	"text"			=> "Set default status for Delivery Receipt Items",
																	"key"			=> "managepurchaseorders_default_status",
																	"input_type"	=> "multiple_select"
																 )
														),
						),
					
					
					array(  "text"          => "Manage Orders",
							"directory"		=> "manageorders",
							/*
							"extra_conditions"	=> array (	
																 
															array(
																	"text"			=> "Show Ship Button",
																	"key"			=> "showship_button",
																	"input_type"	=> "single_checkbox"
																 ),
																 
															array(
																	"text"			=> "Show Invoice Button",
																	"key"			=> "showinvoice_button",
																	"input_type"	=> "single_checkbox"
																 )
														 ),
							*/
							"dont_include"	=> array("delete"),
						 ),
							
									
					array(  "text"          => "CSV Upload",
							"directory"		=> "managecsvproducts" ),
					
					array(  "text"          => "Cycle Count",
							"directory"		=> "managecyclecount" ),
							
					array(  "text"          => "Manage Bulk Mapping",
							"directory"		=> "managebulkmapping"),
							
							
					array(  "text"          => "Manage Inventory",
							"directory"		=> "manageinventory" ),
							
					array(  "text"          => "Manage Warehouse Location Inventory",
							"directory"		=> "managewarehouselocationinventory" ),
							
					
					array(  "text"          => "Manage SellerCenter Status",
							"directory"		=> "managesellercenterstatus" ),
									
					array(  "text"          => "Manage Roles Identifier",
							"directory"		=> "managerolesidentifier" ),
							
					array(  "text"          => "Manage Roles Permissions",
							"directory"		=> "managerolespermissions" ),
					
					array(  "text"          => "Manage Configuration Settings",
							"directory"		=> "manageconfigurationsettings" ),
							
					array(  "text"          => "Manage My Account",
							"directory"		=> "managemyaccount" ),
					
					array(  "text"          => "Reports - Account Statement",
							"directory"		=> "managereportaccountstatement" ),
							
					array(  "text"          => "Reports - Sale Report",
							"directory"		=> "managereportsales" ),
					
					array(  "text"          => "Reports - Customers",
							"directory"		=> "managereportaccount" ),
					
					array(  "text"          => "Reports - Dispatched Orders",
							"directory"		=> "managereportcustomers" ),
							
				);	
	}


	static function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
	
		array_multisort($sort_col, $dir, $arr);
	}
	
	
	

}