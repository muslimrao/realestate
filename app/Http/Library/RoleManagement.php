<?php
namespace App\Http\Library;

use \Illuminate\Support\Facades\Session;
use App\Http\Helpers\GeneralHelper;

use Mage;
use Auth;

class RoleManagement  {

     private $is_user       = FALSE;
     private $is_vendor      = FALSE;
    
  
    
     function is_user()
     {
         return Auth::guard('web')->check();
     }
     
     function is_vendor()
     {
         return Auth::guard('customer')->check();
     }
     
     function get_current_role_id()
     {
         if ( self::is_user() )
         {
             $role_id           = Auth::guard('web')->user()->user_id;
         }
         else if ( self::is_vendor() )
         {
             $role_id           = Auth::guard('customer')->user()->entity_id;
         }
         else
         {
             $role_id           = Auth::guard('web')->user()->id;
         }
         
        
         return $role_id;
     }
     
     function is_vendor_manager()
     {
         $TMP_user          = Mage::getModel('admin/user')->load( Auth::guard('web')->user()->user_id  );
         
         $TMP_roles_detail = $TMP_user->getRole()->getData();
         
         #echo $TMP_roles_detail['role_id'];
         
         $a = \App\Rolesidentifier::first();
         
         if ( $a->toArray()['vendor_manager_role_id'] == $TMP_roles_detail['role_id'] )
         {
             return TRUE;
         }
         
         return FALSE;
     }
     
   
     
     static function getCurrent_LoggedInID( $guard = "" )
     {
         return Auth::guard( $guard ) -> ID();		 
     }
     
     
    //list of functions:
    //is_Admin, is_QC, is_ST, is_VM, is_Vendor, is_CS, is_WL
    //if_Allowed (3 parameters ) [0]directory, [1]operation
    public static function __callStatic($name, $arguments)
    {

        if ( substr($name, 0, 3) == "is_")
        {
			return TRUE;
			
			/*
            $ROLE_details                      = \App\Rolesidentifier::get()->first();
            if ( $ROLE_details -> count() > 0 )
            {
                
                
                $get_ROLE_to_check                  = explode("_", $name);
                $if_YES                             = FALSE;
                $requested_role                     = strtolower( $get_ROLE_to_check[1] );
                switch ( TRUE )
                {
                    case $requested_role == "admin" and Session::get("role_id") == $ROLE_details->administrator_role_id:
                        $if_YES                     = TRUE;
                        break;

                    case $requested_role == "qc" and Session::get("role_id") == $ROLE_details->quality_assurance_role_id:
                        $if_YES                     = TRUE;
                        break;
                    
                    case $requested_role == "st" and Session::get("role_id") == $ROLE_details->sourcing_team_role_id:
                        $if_YES                     = TRUE;
                        break;
                    
                    case $requested_role == "vm" and Session::get("role_id") == $ROLE_details->vendor_manager_role_id:
                        $if_YES                     = TRUE;
                        break;
                    
                    case $requested_role == "vendor" and Session::get("role_id") == $ROLE_details->vendor_role_id:
                        $if_YES                     = TRUE;
                        break;
                    
                    case $requested_role == "cs" and Session::get("role_id") == $ROLE_details->customer_support_role_id:
                        $if_YES                     = TRUE;
                        break;
                    
                    case $requested_role == "wl" and Session::get("role_id") == $ROLE_details->warehousing_role_id:
                        
                        $if_YES                     = TRUE;
                        break;

                    default:
                        $if_YES                     = FALSE;
                        break;
                }

                
                return $if_YES;
            }
            else
            {
               GeneralHelper::show_error_page("401");
            }
			*/


           
        }
        
        
        else if ( substr($name, 0, 10) == "if_Allowed")
        {
			return TRUE;
			/*
            //return true;
			$DIRECTORY               = $arguments[0];
            $if_slash_found          = substr( $DIRECTORY, strlen($DIRECTORY)-1, strlen($DIRECTORY) );
            if ( $if_slash_found           == "/" )
            {
                $DIRECTORY          = substr( $DIRECTORY, 0, strlen($DIRECTORY) - 1 );
            }
            

            if (!array_key_exists(1, $arguments))
            {
                $arguments[1]           = "show";
            }
           
            
            //Array ( [0] DIRECTORY [1] => OPERATION )
            $_record = RolesPermissions::where(["user_role_id" => Session::get("role_id"), "directory" => $DIRECTORY, "operation" => $arguments[1]])->get();
            
           
            if ( $arguments[0] == "managecategory")
            {
                 #print_r($_record->count());
                 #die;
                 
                    #echo $arguments[1];
                    #die;
            }
            
            if ( $_record -> count() > 0 )
            {
                return TRUE;
            }
            
            
            
            return FALSE;
			*/
        }
        else
        {
            GeneralHelper::show_error_page("503");
        }
    }
	
	
	
     
    
    
    
    
	
}