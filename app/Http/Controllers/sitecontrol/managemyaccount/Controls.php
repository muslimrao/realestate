<?php

namespace App\Http\Controllers\sitecontrol\Managemyaccount;

use App\Http\Library\RoleManagement;
use App\Http\Controllers\My_controller;
use App\Http\Helpers\GeneralHelper;
use App\Http\Library\CustomHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Support\Facades\Config;
use \App\Http\Helpers\DropdownHelper;
use DB;

class Controls extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
		
		
        $this->data                                             = $this->default_data();


        $this->data["_heading"]									= 'Manage My Account';
        $this->data["_pagetitle"]								= $this->data["_heading"] . " - ";
        $this->data["_directory"]                               = "sitecontrol/managemyaccount/";
		
        
    }

    public function view( $is_ajax = 0 )
    {
        return redirect( $this->data["_directory"] . "controls/edit/" . RoleManagement::getCurrent_LoggedInID(  Config::get('constants.GUARD_SUPERADMIN')  ) );
    }



	public function save (Request $request )
    {
		$TMP_id														= $request["id"];
		$this->data['_pageview']                                    = $this->data["_directory"] . "edit";				
		
		
		if ( GeneralHelper::set_value("_use_from_other_controller") == "managemyaccount/" )
		{
			$this->data['_directory']			= GeneralHelper::set_value("_use_from_other_controller");		
		}
		
		
        $validator = Validator::make($request->all(), [
            "id"                    => "trim",
            "options"               => "trim",
            "unique_formid"         => "trim",

			"role_id"				=> "required",
            "prefix"                => "required",
            "username"              => "required",
            "firstname"             => "required",
            "lastname"              => "required",
            "email"                 => "required|email",
			"dob"					=> "datecheck:dd-mm-yyyy",
            "country"               => "trim",
            "gender"                => "required",
        ]);


		$input_labelName = array(
            'role_id'								=> "Role",
            'prefix'           						=> 'Prefix',
            'username'                           	=> "Username",
            'firstname'                         	=> "First Name",
            'lastname'                       		=> "Last Name",
            'email'                            		=> "Email",
			"dob"									=> "Date of Birth",
            'country'                              	=> "Country",
            'gender'                              	=> "Gender",

			
        );

        $validator->setAttributeNames($input_labelName);
		
		
		
		
		
        
        $validator_EMAIL = Validator::make($request->all(), [
            "password"          	=> "required|min:8",
            "confirm_password"  	=> "required|same:password"
        ]);


		$input_labelName_EMAIL = array(
            'password'                              => "Password",
            'confirm_password'                      => "Confirm Password",
        );

        $validator_EMAIL->setAttributeNames($input_labelName_EMAIL);
	
		
		
        
        
        if ( "IMAGE_UPLOAD" )
        {
            $other_upload       = array(    "validate"              => "",
                                            "input_field"           => "file_user_image",
                                            "db_field"              => "user_image",
                                            "input_nick"            => "Profile Image",
                                            "hdn_field"             => "user_image",
                                            "tmp_table_field"       => "upload_1",
											"only_validate"			=> TRUE,
                                            "is_multiple"           => FALSE);


            $config_image       = array("upload_path"               => $this->data["images_dir"],
                                        "allowed_types"             => $this->data['images_types'],
                                        "encrypt_name"              => TRUE);

            $config_thumb       = array();


	
            $tmp_upload_image_1 = $this->upload_image($request, $validator, $config_image, $config_thumb, $other_upload);
            #$validator          = $tmp_upload_image_1['validator'];

            #$this->tmp_record_uploads_in_db($request, TRUE, $tmp_upload_image_1  );
			
			
        }
		
		$is_FAIL							= FALSE;
        if ($validator->fails())
        {
            $is_FAIL							= TRUE;
            $this->data['_messageBundle']                               = $this->_messageBundle( 'danger' , $validator->messages(), 'Error!');
        }
        else if ($validator_EMAIL->fails() and $request["options"] != "edit")
        {
            $is_FAIL							= TRUE;
            $this->data['_messageBundle']                               = $this->_messageBundle( 'danger' , $validator_EMAIL->messages(), 'Error!');
        }
        else
        {
			
		
			if ($request["options"] == "edit")
			{
				#add Inputs on FLY
				$request->request->add(['user_id' => $request["id"]]);
				$request->request->remove('id');
				
				
				if ( isset($request["status"]) )
				{
					$request->request->add(['is_active' => $request["status"]]);
				}
				
				
				
				$request->request->add(['new_password' => $request["password"]]);
				$request->request->remove('password');
				
				
				$request->request->add(['password_confirmation' => $request["confirm_password"]]);
				$request->request->remove('confirm_password');
			}
			else
			{
				$request->request->add(['user_id' => NULL]);
			}
			
			
			
			$TMP_id 					= $request['user_id'];
            $model 						= Mage::getModel('admin/user')->load($TMP_id);
            if (!$model->getId() && $TMP_id) 
			{
				
				$is_FAIL							= TRUE;
           	 	$this->data['_messageBundle']                               = $this->_messageBundle( 'danger', array('This user no longer exists.'), 'Error!');
            }
			else
			{
				
				$result								= TRUE;
				
				
				$data								= Input::all();
				
				$model->setData($data);
	
	
					
				/*
				* Unsetting new password and password confirmation if they are blank
				*/
				if ($model->hasNewPassword() && $model->getNewPassword() === '') {
					$model->unsNewPassword();
				}
				
				if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
					$model->unsPasswordConfirmation();
				}
	
				if (!is_array($result)) 
				{
					$result = $model->validate();
				}
				
				if (is_array($result)) 
				{
					
					$is_FAIL							= TRUE;
					$this->data['_messageBundle']                               = $this->_messageBundle( 'danger' ,$result, 'Error!');
				}
				else
				{	
					try 
					{
						$model->save();						
						$model->setRoleIds	(array($request['role_id']))->setRoleUserId($model->getUserId())->saveRelations();			
						
						
						
						
						
						$tmp_Upload_Controls            = array("input_field"       => "file_user_image",
																"upload_path"       => "/media/avatar/",
																"allowed_types"     => $this->data['images_types'],
																"custom_array"      => $tmp_upload_image_1);
						
						
						if ( $tmp_upload_image_1['error'] == 0 and $tmp_upload_image_1['reason'] == 'none' and isset($_FILES[$other_upload["input_field"]]) ) 
						{
							if ( $_FILES[$other_upload["input_field"]]['name'] == '' )
							{
								$UPDATE_image 					= Mage::getModel('admin/user')->load( $model->getUserId() );
								$UPDATE_image->setuserImage( 'default-avatar.png' )->save();
							}
						}
						else
						{
							$UPLOADED_IMAGE                 = $this->upload_image_magento( $request, $tmp_Upload_Controls );
							
							if ( $UPLOADED_IMAGE['return'] )
							{ 
								$UPDATE_image 					= Mage::getModel('admin/user')->load( $model->getUserId() );
								$UPDATE_image->setuserImage( $UPLOADED_IMAGE['message'] )->save();
							}
							else
							{ 
								$is_FAIL                            = true;
								$this->data['_messageBundle']	= $this->_messageBundle( 'danger' , array($UPLOADED_IMAGE['message']) , 'Error!');
							}
						}
						
						
						
						
					} 
					catch (Mage_Core_Exception $e) 
					{
						
						$is_FAIL							= TRUE;
						$this->data['_messageBundle']       = $this->_messageBundle( 'danger' , array($e->getMessage()) , 'Error!');
					}
				}
        
			}
        }			
		
		if ( $is_FAIL )
        {
			
			$request->request->add(['id' => $TMP_id]);			
			return view( Config::get('constants.ADMINCMS_TEMPLATE_VIEW'), $this->data );
        }
        else
        {


			$this->data['_messageBundle']		= $this->_messageBundle('success' , trans("general_lang.operation_saved_success"),trans("general_lang.heading_operation_success"),false,true);
			
			if ( GeneralHelper::set_value("_use_from_other_controller") == "managemyaccount/" )
			{
				return redirect( $this->data["_directory"] . "controls/edit/" . RoleManagement::getCurrent_LoggedInID() ) ;
			}
			else
			{
				return redirect( $this->data["_directory"] . "controls/view" ) ;
			}
			
			/*			
			die("SAVE");
            $saveData   = $this->Mage->getModel('admin/user')->load($request['id']);

                        $saveData->setData(Input::all());
                        $saveData->save();
                        
            $saveData->setuserImage( $request['user_image'] )->save();

            $saveData->setRoleIds	(array($request['role_id']))
                                                                        ->setRoleUserId($saveData->getUserId())
                                                                        ->saveRelations();



            $this->data['_messageBundle']                                   = $this->_messageBundle('success' , trans("general_lang.operation_saved_success"),trans("general_lang.heading_operation_success"),false,true);

            return redirect( $this->data["_directory"] . "controls/view" ) ;
			*/
        }
		
    }
	
	
    public function edit( $edit_id = false )
    {        
	
	
        if ( !$this->_auth_current_logged_in_ID($edit_id, Config::get('constants.GUARD_SUPERADMIN')) )
        {
			
            return redirect	( 	
								$this->data["_directory"] . "controls/edit/" . 
								RoleManagement::getCurrent_LoggedInID( Config::get('constants.GUARD_SUPERADMIN') ) 
							);
        }
		
		
		
		$this->data['_pageview']									= $this->data["_directory"] . "edit";
     
	
        $this->data["edit_id"]                                      = $edit_id; 



        $edit_details												= Auth::guard( Config::get('constants.GUARD_SUPERADMIN') ) -> user()->toArray();
		$edit_details['current_password']							= "";
		$edit_details['new_password']								= "";
		$edit_details['new_confirm_password']						= "";
		$edit_details['user_image']									= "";
		
        $edit_details['options']									= "edit";
        $edit_details['unique_formid']								= "";
		



        
       
        $this->_create_fields_for_form(true, $this->data, $edit_details );

	

        return view( Config::get('constants.ADMINCMS_TEMPLATE_VIEW'), $this->data );

    
		
    }
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
		
		$empty_inputs               = array( "id", "username", "current_password", "new_password", "new_confirm_password", "email", "user_image", "status", "options", "unique_formid" );
		
		$filled_inputs              = array( "id", "username", "current_password", "new_password", "new_confirm_password", "email", "user_image", "status", "options", "unique_formid" );
		
		
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
				$tmp_value						= $db_data[ $filled_inputs[$x] ];
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value			= date("d-m-Y", strtotime( $db_data[ $filled_inputs[$x] ] ) );
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
				
			}
			
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				$explode_empty_inputs				= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]					= $explode_empty_inputs[0];
				$tmp_value							= "";
				
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value				= "00-00-0000";
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
			}
		}
	}
	
}
